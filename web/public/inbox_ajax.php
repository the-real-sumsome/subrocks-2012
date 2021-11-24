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
    $search = $_SESSION['siteusername'];

    $stmt = $__db->prepare("SELECT * FROM pms WHERE touser = :username AND readed = 'y' ORDER BY id DESC");
    $stmt->bindParam(":username", $_SESSION['siteusername']);
    $stmt->execute();

    $results_per_page = 12;
    $number_of_result = $stmt->rowCount();
    $number_of_page = ceil ($number_of_result / $results_per_page);  

    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = (int)$_GET['page'];  
    }  

    $page_first_result = ($page - 1) * $results_per_page;  

    if($_GET['filter'] == "notification") {
        $stmt6 = $__db->prepare("SELECT * FROM pms WHERE touser = :search AND type = 'nt' AND readed = 'y' ORDER BY id DESC LIMIT :pfirst, :pper");
        $stmt6->bindParam(":search", $search);
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute();
    } else if($_GET['filter'] == "sent") {
        $stmt6 = $__db->prepare("SELECT * FROM pms WHERE owner = :search AND readed = 'y' ORDER BY id DESC LIMIT :pfirst, :pper");
        $stmt6->bindParam(":search", $search);
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute(); 
    } else if($_GET['filter'] == "pm") {
        $stmt6 = $__db->prepare("SELECT * FROM pms WHERE touser = :search AND type = 'nm' AND readed = 'y' ORDER BY id DESC LIMIT :pfirst, :pper");
        $stmt6->bindParam(":search", $search);
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute(); 
    } else {
        $stmt6 = $__db->prepare("SELECT * FROM pms WHERE touser = :search AND readed = 'y' ORDER BY id DESC LIMIT :pfirst, :pper");
        $stmt6->bindParam(":search", $search);
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute();
    }
?>              
<table style="width: 100%;">
    <tr>
        <!-- <th style="margin: 5px; width: 5%;"></th> -->
        <th style="margin: 5px; width: 21%;">
            From
        </th>
        <th style="width: 69%;">
            Message
        </th>
        <th style="margin: 5px; width: 20%;">
            Date
        </th>
    </tr>
    
    <?php
        while($inbox = $stmt6->fetch(PDO::FETCH_ASSOC)) { 
            if($__video_h->video_exists($inbox['video_attribute'])) {
                $inbox['video'] = $__video_h->fetch_video_rid($inbox['video_attribute']);
                $inbox['video_attr_exists'] = true;

                $inbox['video']['age'] = $__time_h->time_elapsed_string($inbox['video']['publish']);		
                $inbox['video']['duration'] = $__time_h->timestamp($inbox['video']['duration']);
                $inbox['video']['views'] = $__video_h->fetch_video_views($inbox['video']['rid']);
                $inbox['video']['author'] = htmlspecialchars($inbox['video']['author']);		
                $inbox['video']['title'] = htmlspecialchars($inbox['video']['title']);
                $inbox['video']['description'] = $__video_h->shorten_description($inbox['video']['description'], 50);
            }
    ?> 
    <tr style="margin-top: 5px;" id="videoslist">
            <!--
            <?php if($inbox['readed'] == "n") { ?>
                <a style="position:relative;top:7px;color: white;text-decoration: none;background-color: #d54343;padding: 7px;padding-left: 10px;margin-right: 12px;display: inline;" href="/inbox/">
                NEW
                </a>
            <?php } ?>
            -->
        <td class="video-manager-stats" style="background: none;padding-left: 8px;font-size: 10px;">
            <br>
            <img style="width: 50px;height:50px;" src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($inbox['owner']); ?>">
            <span style="display: inline-block; vertical-align:top;width: 87px;">
                <b><a href="/user/<?php echo htmlspecialchars($inbox['owner']); ?>"><?php echo htmlspecialchars($inbox['owner']); ?></a></b><br>
                <?php echo $__user_h->fetch_subs_count($inbox['owner']); ?> subscribers<br>
                <?php echo $__user_h->fetch_user_videos($inbox['owner']); ?> videos published<br>
            </span><br><br>
            <a href="/inbox/compose?title=RE: <?php echo htmlspecialchars($inbox['subject']); ?>&to=<?php echo htmlspecialchars($inbox['owner']); ?>">
                <button class="yt-uix-button yt-uix-button-default">
                    Reply
                </button>
            </a>

            <a href="/inbox/delete_message?id=<?php echo $inbox['id']; ?>">
                <button class="yt-uix-button yt-uix-button-default">
                    Delete
                </button>
            </a>
        </td>
        <td class="video-manager-stats" style="background: none;padding-left: 8px;">
            <h3><?php echo htmlspecialchars($inbox['subject']); ?></h3>
            <p style="width:475px;">
            <?php echo $__video_h->shorten_description($inbox['message'], 300, true); ?>
            </p>
            <?php if($inbox['video_attr_exists']) { ?>
                <hr>
                <ul>
                    <li class="video-list-item "><a href="/watch?v=<?php echo $inbox['video']['rid']; ?>" class="video-list-item-link yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-sptl%26cid%3Dinp-hs-ytg"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $inbox['video']['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $inbox['video']['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $inbox['video']['duration']; ?></span>
                        <button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="yuTBQ86r8o0" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                        </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
                        </span><span dir="ltr" class="title" title="<?php echo $inbox['video']['title']; ?>"><?php echo $inbox['video']['title']; ?></span><span class="stat">by <span class="yt-user-name " dir="ltr"><?php echo $inbox['video']['author']; ?></span></span><span class="stat view-count">  <span class="viewcount"><?php echo $inbox['video']['views']; ?> views</span>
                        </span></a>
                    </li>
                </ul>
            <?php } ?>
        </td>
        <td class="video-manager-stats" style="background: none;padding-left: 8px;font-size: 10px;">
            <br>
            <?php echo date("M d, Y", strtotime($inbox['date'])); ?> at <?php echo date("h:m a", strtotime($inbox['date'])); ?>
        </td>
    </tr>
    <?php } ?>
</table> 
<?php
$content = ob_get_clean();
header('Content-Type: application/json');
echo '{"content_html": ' . json_encode($content) . '}';
exit();