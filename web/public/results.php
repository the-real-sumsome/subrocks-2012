<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php
   $request = (object) [
      "search_term"      => htmlspecialchars($_GET['search_query']),
      "like_search_term" => "%" . htmlspecialchars($_GET['search_query']) . "%",
      "search_amount"    => 0 /* [fallback] */
   ];

   $stmt = $__db->prepare("SELECT * FROM videos WHERE lower(title) LIKE lower(:search) ");
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

   $stmt6 = $__db->prepare("SELECT * FROM videos WHERE lower(title) LIKE lower(:search) ORDER BY id DESC LIMIT :pfirst, :pper");
   $stmt6->bindParam(":search", $request->like_search_term);
   $stmt6->bindParam(":pfirst", $page_first_result);
   $stmt6->bindParam(":pper", $results_per_page);
   $stmt6->execute();

   /* TODO :: Easy & Clean Pagination Class PLZ :((( ))) */
?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
	$__server->page_embeds->page_title = "SubRocks - Search";
	$__server->page_embeds->page_description = "SubRocks is a site dedicated to bring back the 2012 layout of YouTube.";
	$__server->page_embeds->page_image = "/yt/imgbin/full-size-logo.png";
	$__server->page_embeds->page_url = "https://subrock.rocks/";
?>
<!DOCTYPE html>
<html>
   <head>
      <title><?php echo $__server->page_embeds->page_title; ?></title>
      <meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
      <meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
      <meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
      <meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
      <script>
         var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
      </script>
      <link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
      <link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
      <script>
         if (window.yt.timing) {yt.timing.tick("ct");}    
      </script>
   </head>
   <body id="" class="date-20120930 en_US ltr   ytg-old-clearfix guide-feed-v2 " dir="ltr">
      <form name="logoutForm" method="POST" action="/logout">
         <input type="hidden" name="action_logout" value="1">
      </form>
      <!-- begin page -->
      <div id="page" class="">
         <div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php"); ?></div>
         <div id="content">
            <noscript>
               <div class="yt-alert yt-alert-default yt-alert-error  ">
                  <div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
                  <div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button>
                  </div>
                  <div class="yt-alert-content" role="alert">
                     <span class="yt-alert-vertical-trick"></span>
                     <div class="yt-alert-message">
                        Hello, you seem to have JavaScript turned off.  Please enable it to see search results properly.
                     </div>
                  </div>
               </div>
            </noscript>
            <div id="search-header">
               <div id="search-header-inner">
                  <p class="num-results">
                     About <strong><?php echo number_format($request->search_amount); ?></strong> results
                  </p>
                  <h2>
                     Search results for
                     <strong class="query"><?php echo $request->search_term; ?></strong>
                  </h2>
               </div>
               <hr class="yt-horizontal-rule">
            </div>
            <div id="search-refinements">
               <div id="search-section-header" class="ytg-box">
                  <div class="clear"></div>
                  <div id="toolbelt-top" class="hid">
                     <div id="toolbelt-container">
                        <div class="search-option-box search-option-box-first">
                           <div class="search-option-label">
                              Result type:
                           </div>
                           <div class="search-option">
                              All
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3">Videos</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=search_users&amp;uni=3">Channels</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=search_playlists&amp;uni=3">Playlists</a>
                           </div>
                        </div>
                        <div class="search-option-box">
                           <div class="search-option-label">
                              Sort by:
                           </div>
                           <div class="search-option">
                              Relevance
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;search_sort=video_date_uploaded">Upload date</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;search_sort=video_view_count">View count</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;search_sort=video_avg_rating">Rating</a>
                           </div>
                        </div>
                        <div class="search-option-box">
                           <div class="search-option-label">
                              Upload date:
                           </div>
                           <div class="search-option">
                              Anytime
                           </div>
                           <div class="search-option">
                              <a href="/results?uploaded=d&amp;search_type=videos&amp;uni=3">Today</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?uploaded=w&amp;search_type=videos&amp;uni=3">This week</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?uploaded=m&amp;search_type=videos&amp;uni=3">This month</a>
                           </div>
                        </div>
                        <div class="search-option-box">
                           <div class="search-option-label">
                              Categories:
                           </div>
                           <div class="search-option">
                              All
                           </div>
                           <div class="search-option">
                              <a href=" /results?search_type=videos&amp;search_category=10&amp;uni=3">Music</a>
                           </div>
                           <div class="search-option">
                              <a href=" /results?search_type=videos&amp;search_category=43&amp;uni=3">Shows</a>
                           </div>
                           <div class="search-option">
                              <a href=" /results?search_type=videos&amp;search_category=24&amp;uni=3">Entertainment</a>
                           </div>
                           <div class="search-option">
                              <a href=" /results?search_type=videos&amp;search_category=2&amp;uni=3">Autos &amp; Vehicles</a>
                           </div>
                        </div>
                        <div class="search-option-box">
                           <div class="search-option-label">
                              Duration:
                           </div>
                           <div class="search-option">
                              All
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;search_duration=short">Short (~4 minutes)</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;search_duration=long">Long (20~ minutes)</a>
                           </div>
                        </div>
                        <div class="search-option-box">
                           <div class="search-option-label">
                              Features:
                           </div>
                           <div class="search-option">
                              All
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;closed_captions=1&amp;uni=3">Closed captions</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;high_definition=1">HD (high definition)</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;partner=1&amp;uni=3">Partner videos</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;rental=1">Rental</a>
                           </div>
                           <div class="search-option">
                              <a href="/results?search_type=videos&amp;uni=3&amp;webm=1">WebM</a>
                           </div>
                        </div>
                        <div class="clear"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="yt-horizontal-rule "><span class="first"></span><span class="second"></span><span class="third"></span></div>
            <div id="search-base-div">
               <div id="search-main" class="ytg-4col new-snippets">
                  <div id="results-main-content">
                     <ol id="search-results">
                        <?php
                           while($video = $stmt6->fetch(PDO::FETCH_ASSOC)) { 
                              $video['video_responses'] = $__video_h->get_video_responses($video['rid']);
                              $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                              $video['duration'] = $__time_h->timestamp($video['duration']);
                              $video['views'] = $__video_h->fetch_video_views($video['rid']);
                              $video['author'] = htmlspecialchars($video['author']);		
                              $video['title'] = htmlspecialchars($video['title']);
                              $video['description'] = $__video_h->shorten_description($video['description'], 50, true);
                        ?>
                              <li class="yt-grid-box result-item-video *sr ">
                                 <div id="" class="yt-uix-tile yt-lockup-list yt-tile-default yt-grid-box ">
                                    <div style="width: 139px;" class="yt-lockup-thumbnail"><a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap contains-addto result-item-thumb"><span class="video-thumb ux-thumb yt-thumb-default-138 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" width="138"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
                                       <button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <span class="addto-label">
                                       Watch Later
                                       </span>
                                       <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
                                       </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
                                       </a>
                                    </div>
                                    <div class="yt-lockup-content">
                                       <h3 style="font-size: 14px;"><a class="yt-uix-tile-link result-item-translation-title" dir="ltr" title="<?php echo $video['title']; ?>" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $video['title']; ?></a></h3>
                                       <p style="font-size: 11px;" class="description " dir="ltr"><?php echo $video['description']; ?></p>
                                       <div style="font-size: 11px;" class="yt-lockup-meta">
                                          <p class="facets">
                                             <span  style="font-size: 11px;" class="username-prepend">by     <a href="/user/<?php echo $video['author']; ?>" class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></a>
                                             </span>
                                             <span style="font-size: 11px;" class="metadata-separator">|</span>  <span style="font-size: 11px;" class="date-added"><?php echo $video['age']; ?></span>
                                             <span style="font-size: 11px;" class="metadata-separator">|</span>  <span style="font-size: 11px;" class="viewcount"><?php echo $video['views']; ?> views</span>
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                        <?php } ?>
                        <?php if($request->search_amount == 0)
                           echo "Your search query has brought no results.<br><br>";
                        ?>
                     </ol>
                  </div>
               </div>
               <div id="search-pva-content">

        

    </div>
            </div>
            <div id="search-footer-box" class="searchFooterBox">
               <div class="yt-uix-pager" role="navigation">
                  <?php for($page = 1; $page<= $number_of_page; $page++) { ?>
                     <a href="/results?search_query=<?php echo $request->search_term; ?>&page=<?php echo $page; ?>">
                        <button class="yt-uix-button yt-uix-button-default"><?php echo $page; ?></button>
                     </a>
                  <?php } ?>   
               </div>
            </div>
         </div>
         <div id="footer-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/footer.php"); ?></div>
         <div id="playlist-bar" class="hid passive editable" data-video-url="/watch?v=&amp;feature=BFql&amp;playnext=1&amp;list=QL" data-list-id="" data-list-type="QL">
            <div id="playlist-bar-bar-container">
               <div id="playlist-bar-bar">
                  <div class="yt-alert yt-alert-naked yt-alert-success hid " id="playlist-bar-notifications">
                     <div class="yt-alert-icon">
                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                     </div>
                     <div class="yt-alert-content" role="alert"></div>
                  </div>
                  <span id="playlist-bar-info"><span class="playlist-bar-active playlist-bar-group"><button onclick=";return false;" title="Previous video" type="button" id="playlist-bar-prev-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-prev" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"><span class="yt-valign-trick"></span></span></button><span class="playlist-bar-count"><span class="playing-index">0</span> / <span class="item-count">0</span></span><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-next-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-next" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button></span><span class="playlist-bar-active playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-autoplay-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-autoplay" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-shuffle-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-shuffle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button></span><span class="playlist-bar-passive playlist-bar-group"><button onclick=";return false;" title="Play videos" type="button" id="playlist-bar-play-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-play" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Play videos"><span class="yt-valign-trick"></span></span></button><span class="playlist-bar-count"><span class="item-count">0</span></span></span><span id="playlist-bar-title" class="yt-uix-button-group"><span class="playlist-title">Unsaved Playlist</span></span></span>
                  <a id="playlist-bar-lists-back" href="#">
                  Return to active list
                  </a>
                  <span id="playlist-bar-controls"><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-text yt-uix-button-empty" onclick=";return false;" id="playlist-bar-toggle-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-toggle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button></span><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked yt-uix-button-reverse flip yt-uix-button yt-uix-button-text" onclick=";return false;" data-button-menu-id="playlist-bar-options-menu" data-button-has-sibling-menu="true" role="button"><span class="yt-uix-button-content">Options </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button></span></span>      
               </div>
            </div>
            <div id="playlist-bar-tray-container">
               <div id="playlist-bar-tray" class="yt-uix-slider yt-uix-slider-fluid">
                  <button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-prev" onclick="return false;"><img class="yt-uix-slider-prev-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"></button><button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-next" onclick="return false;"><img class="yt-uix-slider-next-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Next video"></button>
                  <div class="yt-uix-slider-body">
                     <div id="playlist-bar-tray-content" class="yt-uix-slider-slide">
                        <ol class="video-list"></ol>
                        <ol id="playlist-bar-help">
                           <li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="/sign_in">sign in</a> to load a different list.</li>
                        </ol>
                     </div>
                     <div class="yt-uix-slider-shade-left"></div>
                     <div class="yt-uix-slider-shade-right"></div>
                  </div>
               </div>
               <div id="playlist-bar-save"></div>
               <div id="playlist-bar-lists" class="dark-lolz"></div>
               <div id="playlist-bar-loading"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Loading..."><span id="playlist-bar-loading-message">Loading...</span><span id="playlist-bar-saving-message" class="hid">Saving...</span></div>
               <div id="playlist-bar-template" style="display: none;" data-video-thumb-url="//i4.ytimg.com/vi/__video_encrypted_id__/default.jpg">
                  <!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__" class="yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=BFa"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
                     </span></span><span class="dragger"></span></a></li>-->
               </div>
               <div id="playlist-bar-next-up-template" style="display: none;">
                  <!--<div class="playlist-bar-next-thumb"><span class="video-thumb ux-thumb yt-thumb-default-74 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//i4.ytimg.com/vi/__video_encrypted_id__/default.jpg" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" width="74" ><span class="vertical-align"></span></span></span></span></div>-->
               </div>
            </div>
            <div id="playlist-bar-options-menu" class="hid">
               <div id="playlist-bar-extras-menu">
                  <ul>
                     <li><span class="yt-uix-button-menu-item" data-action="clear">
                        Clear all videos from this list
                        </span>
                     </li>
                  </ul>
               </div>
               <ul>
                  <li><span class="yt-uix-button-menu-item" onclick="window.location.href='//support.google.com/youtube/bin/answer.py?answer=146749&amp;hl=en-US'">Learn more</span></li>
               </ul>
            </div>
         </div>
         <div id="shared-addto-watch-later-login" class="hid">
            <a href="/sign_in" class="sign-in-link">Sign in</a> to add this to a playlist
         </div>
         <div id="shared-addto-menu" style="display: none;" class="hid sign-in">
            <div class="addto-menu">
               <div id="addto-list-panel" class="menu-panel active-panel">
                  <span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="/sign_in" class="sign-in-link">Sign in</a> to add this to a playlist
                  </span>
               </div>
               <div id="addto-list-saved-panel" class="menu-panel">
                  <div class="panel-content">
                     <div class="yt-alert yt-alert-naked yt-alert-success  ">
                        <div class="yt-alert-icon">
                           <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                        </div>
                        <div class="yt-alert-content" role="alert">
                           <span class="yt-alert-vertical-trick"></span>
                           <div class="yt-alert-message">
                              <span class="message">Added to <span class="addto-title yt-uix-tooltip yt-uix-tooltip-reverse" title="More information about this playlist" data-tooltip-show-delay="750"></span></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="addto-list-error-panel" class="menu-panel">
                  <div class="panel-content">
                     <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
                     <span class="error-details"></span>
                     <a class="show-menu-link">Back to list</a>
                  </div>
               </div>
               <div id="addto-note-input-panel" class="menu-panel">
                  <div class="panel-content">
                     <div class="yt-alert yt-alert-naked yt-alert-success  ">
                        <div class="yt-alert-icon">
                           <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                        </div>
                        <div class="yt-alert-content" role="alert">
                           <span class="yt-alert-vertical-trick"></span>
                           <div class="yt-alert-message">
                              <span class="message">Added to playlist:</span>
                              <span class="addto-title yt-uix-tooltip" title="More information about this playlist" data-tooltip-show-delay="750"></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="yt-uix-char-counter" data-char-limit="150">
                     <div class="addto-note-box addto-text-box"><textarea id="addto-note" class="addto-note yt-uix-char-counter-input" maxlength="150"></textarea><label for="addto-note" class="addto-note-label">Add an optional note</label></div>
                     <span class="yt-uix-char-counter-remaining">150</span>
                  </div>
                  <button disabled="disabled" type="button" class="playlist-save-note yt-uix-button yt-uix-button-default" onclick=";return false;" role="button"><span class="yt-uix-button-content">Add note </span></button>
               </div>
               <div id="addto-note-saving-panel" class="menu-panel">
                  <div class="panel-content loading-content">
                     <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
                     <span>Saving note...</span>
                  </div>
               </div>
               <div id="addto-note-saved-panel" class="menu-panel">
                  <div class="panel-content">
                     <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
                     <span class="message">Note added to:</span>
                  </div>
               </div>
               <div id="addto-note-error-panel" class="menu-panel">
                  <div class="panel-content">
                     <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
                     <span class="message">Error adding note:</span>
                     <ul class="error-details"></ul>
                     <a class="add-note-link">Click to add a new note</a>
                  </div>
               </div>
               <div class="close-note hid">
                  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="close-button">
               </div>
            </div>
         </div>
      </div>
      <!-- end page -->
<script id="www-core-js" src="/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
      <script id="www-core-js" src="//s.ytimg.com/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
      <script>
         yt.setConfig({
         'XSRF_TOKEN': 'iz8jtUnR4Eomusl012h4goGYKHl8MTM0OTE0MDU3NEAxMzQ5MDU0MTc0',
         'XSRF_FIELD_NAME': 'session_token'
         });
         yt.pubsub.subscribe('init', yt.www.xsrf.populateSessionToken);
         
         yt.setConfig('XSRF_REDIRECT_TOKEN', 'DKwX8BwPtPQ3NCknEYmL0VtXh6x8MTM0OTE0MDU3NEAxMzQ5MDU0MTc0');
         
         yt.setConfig({
         'EVENT_ID': "CNLr3rbS3rICFSwSIQodSW397Q==",
         'CURRENT_URL': "http:\/\/www.youtube.com\/",
         'LOGGED_IN': false,
         'SESSION_INDEX': null,
         
         'WATCH_CONTEXT_CLIENTSIDE': false,
         
         'FEEDBACK_LOCALE_LANGUAGE': "en",
         'FEEDBACK_LOCALE_EXTRAS': {"logged_in": false, "experiments": "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706", "guide_subs": "NA", "accept_language": null}    });
      </script>
      <script>
         if (window.yt.timing) {yt.timing.tick("js_head");}    
      </script>
      <script>
         _gel('masthead-search-term').focus();
         yt.setConfig('GUIDE_VERSION', 1);
      </script>
      <script>
         yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
         yt.setConfig({
         'PLAYER_CONFIG': {"url": "\/\/s.ytimg.com\/yt\/swf\/masthead_child-vflRMMO6_.swf", "min_version": "8.0.0", "args": {"enablejsapi": 1}, "url_v9as2": "", "params": {"bgcolor": "#FFFFFF", "allowfullscreen": "false", "allowscriptaccess": "always"}, "attrs": {"width": "1", "id": "masthead_child", "height": "1"}, "url_v8": "", "html5": false}
         });
         
         yt.flash.embed("masthead_child_div", yt.getConfig('PLAYER_CONFIG'));
      </script>
      <script src="//s.ytimg.com/yt/jsbin/www-guide-vflO6qP5Q.js" data-loaded="true"></script>
      <script>
         window.masthead = new yt.www.ads.MastheadAd(
             "OC52H-osudk",
             true);
         
         yt.www.guide.init();
         
         
      </script>
      <script>
         if (window.yt.timing) {yt.timing.tick("js_page");}    
      </script>
      <script>
         yt.setConfig('TIMING_ACTION', "glo");    
      </script>
      <script>yt.www.thumbnaildelayload.init(300);</script>
      <script>
         yt.setMsg({
           'LIST_CLEARED': "List cleared",
           'PLAYLIST_VIDEO_DELETED': "Video deleted.",
           'ERROR_OCCURRED': "Sorry, an error occurred.",
           'NEXT_VIDEO_TOOLTIP': "Next video:\u003cbr\u003e \u0026#8220;${next_video_title}\u0026#8221;",
           'NEXT_VIDEO_NOTHUMB_TOOLTIP': "Next video",
           'SHOW_PLAYLIST_TOOLTIP': "Show playlist",
           'HIDE_PLAYLIST_TOOLTIP': "Hide playlist",
           'AUTOPLAY_ON_TOOLTIP': "Turn autoplay off",
           'AUTOPLAY_OFF_TOOLTIP': "Turn autoplay on",
           'SHUFFLE_ON_TOOLTIP': "Turn shuffle off",
           'SHUFFLE_OFF_TOOLTIP': "Turn shuffle on",
           'PLAYLIST_BAR_PLAYLIST_SAVED': "Playlist saved!",
           'PLAYLIST_BAR_ADDED_TO_FAVORITES': "Added to favorites",
           'PLAYLIST_BAR_ADDED_TO_PLAYLIST': "Added to playlist",
           'PLAYLIST_BAR_ADDED_TO_QUEUE': "Added to queue",
           'AUTOPLAY_WARNING1': "Next video starts in 1 second...",
           'AUTOPLAY_WARNING2': "Next video starts in 2 seconds...",
           'AUTOPLAY_WARNING3': "Next video starts in 3 seconds...",
           'AUTOPLAY_WARNING4': "Next video starts in 4 seconds...",
           'AUTOPLAY_WARNING5': "Next video starts in 5 seconds...",
           'UNDO_LINK': "Undo"  });
         
         
         yt.setConfig({
           'DRAGDROP_BINARY_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-dragdrop-vflWKaUyg.js",
           'PLAYLIST_BAR_PLAYING_INDEX': -1  });
         
           yt.setAjaxToken('addto_ajax_logged_out', "fp0KWJkOgzvoH_zrQWDO1rTnfkx8MTM0OTE0MDU3NEAxMzQ5MDU0MTc0");
         
           yt.pubsub.subscribe('init', yt.www.lists.init);
         
             yt.events.listen(_gel('masthead-search-term'), 'focus', yt.www.home.ads.workaroundReset);
           yt.setConfig({'SBOX_JS_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-searchbox-vflsHyn9f.js",'SBOX_SETTINGS': {"CLOSE_ICON_URL": "\/\/s.ytimg.com\/yt\/img\/icons\/close-vflrEJzIW.png", "SHOW_CHIP": false, "PSUGGEST_TOKEN": null, "REQUEST_DOMAIN": "us", "EXPERIMENT_ID": -1, "SESSION_INDEX": null, "HAS_ON_SCREEN_KEYBOARD": false, "CHIP_PARAMETERS": {}, "REQUEST_LANGUAGE": "en"},'SBOX_LABELS': {"SUGGESTION_DISMISS_LABEL": "Dismiss", "SUGGESTION_DISMISSED_LABEL": "Suggestion dismissed"}});
      </script>
      <script>
         yt.setMsg({
           'ADDTO_WATCH_LATER_ADDED': "Added",
           'ADDTO_WATCH_LATER_ERROR': "Error"
         });
      </script>
      <script>
         if (window.yt.timing) {yt.timing.tick("js_foot");}    
      </script>
   </body>
</html>

