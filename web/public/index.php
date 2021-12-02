<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/page_builder.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__page_b = new page_builder("templates/m"); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php ob_start(); ?>
<?php
	$__server->page_embeds->page_title = "SubRocks - Homepage";
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
			<div id="content-container">
				<!-- begin content -->
				<div id="content">
					<div class="guide-layout-container enable-fancy-subscribe-button">
						<div class="guide-container">
						<?php if(!isset($_SESSION['siteusername'])) { ?>
									<div id="guide-builder-promo">
								<h2>
							Sign in to add channels to your homepage
								</h2>
								<div id="guide-builder-promo-buttons" class="signed-out">
									<button href="/sign_in" type="button" class=" yt-uix-button yt-uix-button-dark" onclick=";window.location.href=this.getAttribute('href');return false;" role="button"><span class="yt-uix-button-content">Sign In </span></button>
								</div>
								<?php } else { ?>
									<div id="guide-builder-promo">
								
								<div id="guide-builder-promo-buttons" class="">
									<button href="/videos" type="button" onclick=";window.location.href=this.getAttribute('href');return false;" role="button" class=" yt-uix-button  yt-uix-button-primary"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="yt-uix-button-icon-add"><span class="yt-uix-button-content"> Browse videos</span></button>
								</div>
								<?php } ?>
							</div>
							<div class="guide">
							<?php 
								if(isset($_SESSION['siteusername'])) {
								?>
								<div style="/*! margin-top: 0px; *//*! margin-left: 10px; *//*! margin-bottom: 13px; */height: 99px;" class="guide-section feed-header channel first"><img alt="" src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" style="height: 88px;position: relative;top: 4px;left: 4px;" class="feed-header-thumb channel-thumb" width="88px"><div id="links" style="/*! margin-left: 5px; */position: relative;left: 13px;top: 7px;"><div style="font-size: 11px;margin-bottom: 6px;" class="metadata">
								<a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" style="color: inherit;">My channel
								<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="see-more-arrow" alt=""></a>        
								</div><div style="font-size: 11px;margin-bottom: 6px;" class="metadata">
								<a href="/my_videos" style="color: inherit;">Videos</a>        </div><div style="font-size: 11px;margin-bottom: 6px;" class="metadata">
								<a href="/playlists" style="color: inherit;">Playlists</a>        </div><div style="font-size: 11px;margin-bottom: 6px;" class="metadata">
								<a href="/logout" style="color: inherit;">Log Out</a>        </div><div style="font-size: 11px;margin-bottom: 6px;" class="metadata">
								<a href="/inbox/" style="color: inherit;">Inbox</a>        </div><div style="font-size: 11px;margin-bottom: 6px;" class="metadata">
								</div></div></div>

								<div class="guide-section yt-uix-expander  ">
								<h3 class="guide-item-container guide-item-action">
									<a class="guide-item" href="/inbox/">
									<span class="thumb">
										<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="" class="system-icon category">
									</span>
									<span class="display-name">Inbox</span>
									</a>
								</h3>
								<ul>
								</ul>
								<div class="guide-item-container">
									<span class="guide-item guide-item-action guide-item-fake">
							<a style="display: none;" href="/web/20121123233507/http://www.youtube.com/videos?feature=hp">&nbsp;<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="see-more-arrow" alt=""></a>        </span>
								</div>
								</div>
								<?php } ?>
								<div class="guide-section yt-uix-expander  first ">
									<h3 class="guide-item-container selected-child">
										<a class="guide-item selected" data-feed-name="youtube" data-feed-type="system">
										<span class="thumb">
										<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="" class="system-icon category">
										</span>
										<span class="display-name">
										From SubRocks
										</span>
										</a>
									</h3>
									<ul>
										<li class="guide-item-container ">
											<a class="guide-item" data-feed-name="trending" data-feed-type="system">
											<span class="thumb">
											<img class="system-icon system trending" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											</span>
											<span class="display-name">
											Trending
											</span>
											</a>
										</li>
										<li class="guide-item-container ">
											<a class="guide-item" data-feed-name="music" data-feed-type="system">
											<span class="thumb">
											<img class="system-icon system music" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											</span>
											<span class="display-name">
											Music
											</span>
											</a>
										</li>
										<li class="guide-item-container ">
											<a class="guide-item" data-feed-name="entertainment" data-feed-type="chart">
											<span class="thumb">
											<img class="system-icon chart entertainment" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											</span>
											<span class="display-name">
											Entertainment
											</span>
											</a>
										</li>
										<li class="guide-item-container ">
											<a class="guide-item" data-feed-name="sports" data-feed-type="chart">
											<span class="thumb">
											<img class="system-icon chart sports" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											</span>
											<span class="display-name">
											Sports
											</span>
											</a>
										</li>
										<li class="guide-item-container ">
											<a class="guide-item" data-feed-name="comedy" data-feed-type="chart">
											<span class="thumb">
											<img class="system-icon chart comedy" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											</span>
											<span class="display-name">
											Comedy
											</span>
											</a>
										</li>
										<li class="guide-item-container ">
											<a class="guide-item" data-feed-name="film" data-feed-type="chart">
											<span class="thumb">
											<img class="system-icon chart film" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											</span>
											<span class="display-name">
											Film &amp; Animation
											</span>
											</a>
										</li>
										<li class="guide-item-container ">
											<a class="guide-item" data-feed-name="gadgets" data-feed-type="chart">
											<span class="thumb">
											<img class="system-icon chart gadgets" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											</span>
											<span class="display-name">
											Gaming
											</span>
											</a>
										</li>
                                        <?php if(!isset($_SESSION['siteusername'])) { ?>
                                            <?php foreach($__server->featured_channels as $channel) { ?>
                                                <li class="guide-item-container ">
                                                    <a class="guide-item" data-external-id="<?php echo htmlspecialchars($channel); ?>" data-feed-name="<?php echo htmlspecialchars($channel); ?>" data-feed-type="user">
                                                    <span class="thumb">  <span class="video-thumb ux-thumb yt-thumb-square-28 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($channel); ?>" width="28"><span class="vertical-align"></span></span></span></span>
                                                    </span>
                                                    <span class="display-name">
                                                        <?php echo htmlspecialchars($channel); ?>
                                                    </span>
                                                    </a>
                                                </li>
                                            <?php } } else { ?>
                                            <?php
                                                $stmt = $__db->prepare("SELECT * FROM subscribers WHERE sender = :username ORDER BY id DESC LIMIT 20");
                                                $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                $stmt->execute();
                                                while($channel = $stmt->fetch(PDO::FETCH_ASSOC)) { $channel = $channel['reciever']; ?>
                                                <li class="guide-item-container ">
                                                    <a class="guide-item" data-external-id="<?php echo htmlspecialchars($channel); ?>" data-feed-name="<?php echo htmlspecialchars($channel); ?>" data-feed-type="user">
                                                    <span class="thumb">  <span class="video-thumb ux-thumb yt-thumb-square-28 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($channel); ?>" width="28"><span class="vertical-align"></span></span></span></span>
                                                    </span>
                                                    <span class="display-name">
                                                        <?php echo htmlspecialchars($channel); ?>
                                                    </span>
                                                    </a>
                                                </li> 
                                            <?php } ?>
                                        <?php } ?>
									</ul>
									<div class="guide-item-container">
										<span class="guide-item guide-item-action guide-item-fake">
										<a href="#">see all<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="see-more-arrow" alt=""></a>        </span>
									</div>
								</div>
							</div>
						</div>
						<div class="guide-background"></div>
						<div id="video-sidebar">
							<div id="ad_creative_expand_btn_1" class="masthead-ad-control open hid">
								<a onclick="masthead.expand_ad(); return false;">
								<span>Show ad</span>
								<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
								</a>
							</div>
							<h2>2012 is out!</h2>
							<p class="sidebar-module-description">
								Enjoy some recommended videos selected for you by our nonexistant recommendation algorythmn.
							</p>
							<p class="sidebar-module-description">
								Presented by: <a href="/user/SubRocks">SubRocks</a>
							</p>
							<ul>
								<?php
									$stmt = $__db->prepare("SELECT * FROM videos WHERE visibility = 'n' ORDER BY rand() LIMIT 4");
									$stmt->execute();
									while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
										$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
										$video['duration'] = $__time_h->timestamp($video['duration']);
										$video['views'] = $__video_h->fetch_video_views($video['rid']);
										$video['author'] = htmlspecialchars($video['author']);		
										$video['title'] = htmlspecialchars($video['title']);
										$video['description'] = $__video_h->shorten_description($video['description'], 50);
								?>
								<li class="video-list-item "><a href="/watch?v=<?php echo $video['rid']; ?>" class="video-list-item-link yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-sptl%26cid%3Dinp-hs-ytg"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
									<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="yuTBQ86r8o0" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
									</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
									</span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat">by <span class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></span></span><span class="stat view-count">  <span class="viewcount"><?php echo $video['views']; ?> views</span>
									</span></a>
								</li>
								<?php } ?>
							</ul>
							<h3>
								Featured
							</h3>
							<ul>
								<?php
									$stmt = $__db->prepare("SELECT * FROM videos WHERE featured = 'v' AND visibility = 'n' ORDER BY id DESC LIMIT 4");
									$stmt->execute();
									while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
										$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
										$video['duration'] = $__time_h->timestamp($video['duration']);
										$video['views'] = $__video_h->fetch_video_views($video['rid']);
										$video['author'] = htmlspecialchars($video['author']);		
										$video['title'] = htmlspecialchars($video['title']);
										$video['description'] = $__video_h->shorten_description($video['description'], 50);
								?>
								<li class="video-list-item "><a href="/watch?v=<?php echo $video['rid']; ?>" class="video-list-item-link yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-sptl%26cid%3Dinp-hs-ytg"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
									<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="yuTBQ86r8o0" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
									</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
									</span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat">by <span class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></span></span><span class="stat view-count">  <span class="viewcount"><?php echo $video['views']; ?> views</span>
									</span></a>
								</li>
								<?php } ?>
							</ul>
						</div>
						<div id="feed">
							<div id="feed-system-youtube" class="individual-feed" data-loaded="true" data-feed-name="youtube" data-feed-type="system">
								<div class="feed-header no-metadata">
									<div class="feed-header-thumb">
										<img class="feed-header-icon youtube" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
									</div>
									<div class="feed-header-details">
										<h2>    From SubRocks</h2>
									</div>
								</div>
								<div class="feed-container" data-filter-type="" data-view-type="">
									<div class="feed-page">
										<ul>
											<?php
												$stmt = $__db->prepare("SELECT * FROM videos WHERE visibility = 'n' ORDER BY id DESC LIMIT 20");
												$stmt->execute();
												while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
													$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
													$video['duration'] = $__time_h->timestamp($video['duration']);
													$video['views'] = $__video_h->fetch_video_views($video['rid']);
													$video['author'] = htmlspecialchars($video['author']);		
													$video['title'] = htmlspecialchars($video['title']);
													$video['description'] = $__video_h->shorten_description($video['description'], 50);
													$video['pfp'] = $__user_h->fetch_pfp($video['author']);

													echo $__page_b->return_template_replace("index_video_1.module", $video);
												} 
											?>
										</ul>
									</div>
								</div>
							</div>
							<div id="feed-error" class="individual-feed hid">
								<p class="feed-message">
									We were unable to complete the request, please try again later.
								</p>
							</div>
							<div id="feed-loading-template" class="hid">
								<div class="feed-message">
									<p class="loading-spinner">
										<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
										Loading...
									</p>
								</div>
							</div>
						</div>
						<div id="feed-background"></div>
						<div id="footer-ads">
							<div id="ad_creative_3" class="ad-div " style="z-index: 1">
								<iframe id="ad_creative_iframe_3" height="1" width="1" scrolling="no" frameborder="0" style="z-index: 1" src="//ad-g.doubleclick.net/N6762/adi/mkt.ythome_1x1/;sz=1x1;tile=3;plat=pc;dc_dedup=1;kcr=us;kga=-1;kgg=-1;klg=en;kmyd=ad_creative_3;kt=K;ord=7554901073022560?"></iframe>
								<script>
									(function() {
									  var addTimestamp = (Math.floor(Math.random() * 1000) == 0);
									  if (addTimestamp) {
									    var kts = new Date().getTime();
									    var iframeSrc = "//ad-g.doubleclick.net/N6762/adi/mkt.ythome_1x1/;sz=1x1;tile=3;plat=pc;dc_dedup=1;kcr=us;kga=-1;kgg=-1;klg=en;kmyd=ad_creative_3;kt=K;kts=" + kts + ";ord=7554901073022560?";
									  } else {
									    var iframeSrc = "//ad-g.doubleclick.net/N6762/adi/mkt.ythome_1x1/;sz=1x1;tile=3;plat=pc;dc_dedup=1;kcr=us;kga=-1;kgg=-1;klg=en;kmyd=ad_creative_3;kt=K;ord=7554901073022560?";
									  }
									  var adIframe = document.getElementById("ad_creative_iframe_3");
									  adIframe.src = iframeSrc;
									})();
								</script>
							</div>
						</div>
					</div>
				</div>
				<!-- end content -->
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
<?php
/* MAKE THIS WAY LESS UGLY.... */

$__template = ob_get_clean();
$__template_inputs = [
	'header' => '',
	'test2' => '',
	'test3' => '',
];

foreach($__template_inputs as $key => $input) {
	$__template = 
		str_replace(
			"{{" . $key . "}}", 
			$input, 
			$__template
		);
}

echo $__template;

?>