<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ob_start(); ?>
<?php
   $request = (object) [
      "search_term"      => $_SESSION['siteusername'],
      "like_search_term" => "%" . $_SESSION['siteusername'] . "%",
      "search_amount"    => 0 /* [fallback] */
   ];

   $stmt = $__db->prepare("SELECT * FROM playlists WHERE lower(author) LIKE lower(:search) ");
   $stmt->bindParam(":search", $request->like_search_term);
   $stmt->execute(); 
   $request->search_amount = $stmt->rowCount();

   $results_per_page = 12;
   $number_of_result = $request->search_amount;
   $number_of_page = ceil ($number_of_result / $results_per_page);  

   if (!isset ($_GET['page']) ) {  
       $page = 1;  
   } else {  
       $page = (int)$_GET['page'];  
   }  

   $page_first_result = ($page - 1) * $results_per_page;  

   $stmt6 = $__db->prepare("SELECT * FROM playlists WHERE lower(author) LIKE lower(:search) ORDER BY id DESC LIMIT :pfirst, :pper");
   $stmt6->bindParam(":search", $request->like_search_term);
   $stmt6->bindParam(":pfirst", $page_first_result);
   $stmt6->bindParam(":pper", $results_per_page);
   $stmt6->execute();

   /* TODO :: Easy & Clean Pagination Class PLZ :((( ))) */
?>               
<table style="width: 100%;">
    <tr>
        <th style="width: 80%;">
            <small class="video-filter-options">

            </small>
        </th>
        <th style="margin: 5px; width: 20%;"></th>
    </tr>
    
    <?php
        while($playlist = $stmt6->fetch(PDO::FETCH_ASSOC)) { 
            $playlist['videos'] = json_decode($playlist['videos']);
            if($__video_h->video_exists(@$playlist['videos'][0])) {
                if(count($playlist['videos']) != 0) {
                    $video = $__video_h->fetch_video_rid($playlist['videos'][0]);
                    $video['video_responses'] = $__video_h->get_video_responses($video['rid']);
                    $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                    $video['duration'] = $__time_h->timestamp($video['duration']);
                    $video['views'] = $__video_h->fetch_video_views($video['rid']);
                    $video['author'] = htmlspecialchars($video['author']);		
                    $video['title'] = htmlspecialchars($video['title']);
                    $video['description'] = $__video_h->shorten_description($video['description'], 50);
                    $playlist['title'] = htmlspecialchars($playlist['title']);
        ?> 
        <tr style="margin-top: 5px;" id="videoslist">
            <td class="video-manager-left">
                <ul>
                    <li class="video-list-item "><a href="/view_playlist?v=<?php echo $playlist['rid']; ?>" class="video-list-item-link yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-sptl%26cid%3Dinp-hs-ytg"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" alt="<?php echo htmlspecialchars($playlist['title']); ?>" onerror=";this.src='/dynamic/thumbs/default.jpg';"  data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
                        <button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="yuTBQ86r8o0" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                        </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
                        </span><span dir="ltr" class="title" title="<?php echo htmlspecialchars($playlist['title']); ?>"><?php echo htmlspecialchars($playlist['title']); ?></span><span class="stat"><?php echo htmlspecialchars($playlist['description']); ?></span><span class="stat">by <span class="yt-user-name " dir="ltr"><?php echo htmlspecialchars($playlist['author']); ?></span></span><span class="stat view-count">  <span class="viewcount"><?php echo $video['views']; ?> views</span>
                        </span></a>
                    </li>
                </ul>
            </div>
                
            </td>
            <td class="video-manager-stats" style="background: none;padding-left: 8px;">
            <a href="/edit_playlist?id=<?php echo $playlist['rid']; ?>">
                    <button type="button" class=" yt-uix-button yt-uix-button-default" role="button">
                        Edit
                    </button>
                </a> 
                <a href="/get/delete_playlist?id=<?php echo $playlist['rid']; ?>">
                    <button type="button" class=" yt-uix-button yt-uix-button-default" role="button">
                        Delete
                    </button>
                </a><br><br>

                <span>
                    <img src="/s/img/world.png"> <span style="font-size: 11px;position: relative;bottom: 2px;left: 5px;">Public</span>
                </span>
            </td>
        </tr>
    <?php } } } ?>
</table> 
<?php
$content = ob_get_clean();
header('Content-Type: application/json');
echo '{"content_html": ' . json_encode($content) . '}';
exit();