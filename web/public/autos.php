<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
	$__server->page_embeds->page_title = "SubRocks - Autos";
	$__server->page_embeds->page_description = "SubRocks is a site dedicated to bring back the 2012 layout of YouTube.";
	$__server->page_embeds->page_image = "/yt/imgbin/full-size-logo.png";
	$__server->page_embeds->page_url = "https://subrock.rocks/";
?>
<!DOCTYPE html>
<html dir="ltr">
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
		<link rel="stylesheet" href="/yt/cssbin/www-videos-nav-vflYGt27y.css">
		<script src="//s.ytimg.com/yt/jsbin/www-browse-vflu1nggJ.js" data-loaded="true"></script>
		<script>
			if (window.yt.timing) {yt.timing.tick("ct");}    
		</script>
	</head>
	<body id="" class="date-20120930 en_US ltr   ytg-old-clearfix guide-feed-v2 " dir="ltr">
		<form name="logoutForm" method="POST" action="/logout">
			<input type="hidden" name="action_logout" value="1">
		</form>
		<!-- begin page -->
		<div id="page" class="browse-base">
			<!-- begin pagetop -->
			<div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php"); ?></div>
			<!-- end pagetop -->
			<!-- begin pagemiddle -->
			<div id="content-container">
				<div id="baseDiv" class="date-20120930 video-info   browse-base browse-videos">
					<div id="alerts"></div>
					<div id="masthead-subnav" class="yt-nav yt-nav-dark ">
						<ul>
							<li class=" selected">
								<span class="yt-nav-item">
								Videos
								</span>
							</li>
						</ul>
					</div>
					<div class="browse-container ytg-wide ytg-box no-stage browse-bg-gradient">
						<div class="ytg-fl browse-content">
							<div id="browse-side-column" class="ytg-2col ytg-last">
								<ol class="navigation-menu">
									<li class="menu-item">
										<a class="" href="/videos">
										All Categories
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/recommended">
										Recommended for You
										</a>
									</li>
									<li class="menu-item">
										<a class="selected" href="/autos">
										Autos &amp; Vehicles
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/comedy">
										Comedy
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/entertainment">
										Entertainment
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/film">
										Film &amp; Animation
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/gaming">
										Gaming
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/howto">
										Howto &amp; Style
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/activism">
										Nonprofits &amp; Activism
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/people">
										People &amp; Blogs
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/pets">
										Pets &amp; Animals
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/science">
										Science &amp; Technology
										</a>
									</li>
									<li class="menu-item">
										<a class="" href="/travel">
										Travel &amp; Events
										</a>
									</li>
								</ol>
							</div>
							<div id="browse-main-column" style="float: right;margin: 0px 0 0 14px;" class="ytg-4col">
								<div class="browse-collection  has-box-ad">
									<div class="ytg-box collection-header with-icon">
										<a class="heading ytg-box" href="/recommended">
											<img class="header-icon autos" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
											<div class="header-container">
												<h2>Autos & Vehicles »</h2>
											</div>
										</a>
										<a class="yt-playall-link yt-playall-link-default yt-uix-sessionlink " style="display: none;"  href="/watch_videos?more_url=&amp;video_ids=rLHU-_OhT8g%2CZR6Cw_3q1Pg%2Cf6ZSZbNfSpk%2CCayMeza487M%2CaLxsLbl16IM%2CDkaUsBwe0fo%2CZg6iMDfOl9E%2CV-fRuoMIfpw&amp;type=0&amp;title=Most+Popular" data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D">
										<img class="small-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
										Play all
										</a>
									</div>
									<div class="browse-item-row ytg-box">
										<?php
											$stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Autos & Vehicles' ORDER BY rand() LIMIT 4");
											$stmt->execute();
											while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
												$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
												$video['duration'] = $__time_h->timestamp($video['duration']);
												$video['views'] = $__video_h->fetch_video_views($video['rid']);
												$video['author'] = htmlspecialchars($video['author']);		
												$video['title'] = htmlspecialchars($video['title']);
												$video['description'] = $__video_h->shorten_description($video['description'], 50);
										?>
										<div class="browse-item yt-tile-default ">
											<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv"><span class="video-thumb ux-thumb yt-thumb-default-194 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="194"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
											<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="rLHU-_OhT8g" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
											</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
											</a>
											<div class="browse-item-content">
												<h3 dir="ltr">
													<a href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>" class="yt-uix-sessionlink " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv">
													<?php echo $video['title']; ?>
													</a>  
												</h3>
												<div class="browse-item-info">
													<div class="metadata-line">
														<span class="viewcount"><?php echo $video['views']; ?> views</span>
														<span class="metadata-separator">|</span>
														<span class="video-date-added"><?php echo $video['age']; ?></span>
													</div>
													<a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D" dir="ltr"><?php echo $video['author']; ?></a>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
                                    <div class="browse-item-row ytg-box">
										<?php
											$stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Autos & Vehicles' ORDER BY rand() LIMIT 4");
											$stmt->execute();
											while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
												$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
												$video['duration'] = $__time_h->timestamp($video['duration']);
												$video['views'] = $__video_h->fetch_video_views($video['rid']);
												$video['author'] = htmlspecialchars($video['author']);		
												$video['title'] = htmlspecialchars($video['title']);
												$video['description'] = $__video_h->shorten_description($video['description'], 50);
										?>
										<div class="browse-item yt-tile-default ">
											<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv"><span class="video-thumb ux-thumb yt-thumb-default-194 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="194"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
											<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="rLHU-_OhT8g" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
											</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
											</a>
											<div class="browse-item-content">
												<h3 dir="ltr">
													<a href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>" class="yt-uix-sessionlink " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv">
													<?php echo $video['title']; ?>
													</a>  
												</h3>
												<div class="browse-item-info">
													<div class="metadata-line">
														<span class="viewcount"><?php echo $video['views']; ?> views</span>
														<span class="metadata-separator">|</span>
														<span class="video-date-added"><?php echo $video['age']; ?></span>
													</div>
													<a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D" dir="ltr"><?php echo $video['author']; ?></a>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
                                    <div class="browse-item-row ytg-box">
										<?php
											$stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Autos & Vehicles' ORDER BY rand() LIMIT 4");
											$stmt->execute();
											while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
												$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
												$video['duration'] = $__time_h->timestamp($video['duration']);
												$video['views'] = $__video_h->fetch_video_views($video['rid']);
												$video['author'] = htmlspecialchars($video['author']);		
												$video['title'] = htmlspecialchars($video['title']);
												$video['description'] = $__video_h->shorten_description($video['description'], 50);
										?>
										<div class="browse-item yt-tile-default ">
											<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv"><span class="video-thumb ux-thumb yt-thumb-default-194 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="194"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
											<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="rLHU-_OhT8g" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
											</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
											</a>
											<div class="browse-item-content">
												<h3 dir="ltr">
													<a href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>" class="yt-uix-sessionlink " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv">
													<?php echo $video['title']; ?>
													</a>  
												</h3>
												<div class="browse-item-info">
													<div class="metadata-line">
														<span class="viewcount"><?php echo $video['views']; ?> views</span>
														<span class="metadata-separator">|</span>
														<span class="video-date-added"><?php echo $video['age']; ?></span>
													</div>
													<a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D" dir="ltr"><?php echo $video['author']; ?></a>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
                                    <div class="browse-item-row ytg-box">
										<?php
											$stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Autos & Vehicles' ORDER BY rand() LIMIT 4");
											$stmt->execute();
											while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
												$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
												$video['duration'] = $__time_h->timestamp($video['duration']);
												$video['views'] = $__video_h->fetch_video_views($video['rid']);
												$video['author'] = htmlspecialchars($video['author']);		
												$video['title'] = htmlspecialchars($video['title']);
												$video['description'] = $__video_h->shorten_description($video['description'], 50);
										?>
										<div class="browse-item yt-tile-default ">
											<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv"><span class="video-thumb ux-thumb yt-thumb-default-194 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="194"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
											<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="rLHU-_OhT8g" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
											</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
											</a>
											<div class="browse-item-content">
												<h3 dir="ltr">
													<a href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>" class="yt-uix-sessionlink " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv">
													<?php echo $video['title']; ?>
													</a>  
												</h3>
												<div class="browse-item-info">
													<div class="metadata-line">
														<span class="viewcount"><?php echo $video['views']; ?> views</span>
														<span class="metadata-separator">|</span>
														<span class="video-date-added"><?php echo $video['age']; ?></span>
													</div>
													<a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D" dir="ltr"><?php echo $video['author']; ?></a>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
                                    <div class="browse-item-row ytg-box">
										<?php
											$stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Autos & Vehicles' ORDER BY rand() LIMIT 4");
											$stmt->execute();
											while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
												$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
												$video['duration'] = $__time_h->timestamp($video['duration']);
												$video['views'] = $__video_h->fetch_video_views($video['rid']);
												$video['author'] = htmlspecialchars($video['author']);		
												$video['title'] = htmlspecialchars($video['title']);
												$video['description'] = $__video_h->shorten_description($video['description'], 50);
										?>
										<div class="browse-item yt-tile-default ">
											<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv"><span class="video-thumb ux-thumb yt-thumb-default-194 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="194"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
											<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="rLHU-_OhT8g" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
											</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
											</a>
											<div class="browse-item-content">
												<h3 dir="ltr">
													<a href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>" class="yt-uix-sessionlink " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=b-mv">
													<?php echo $video['title']; ?>
													</a>  
												</h3>
												<div class="browse-item-info">
													<div class="metadata-line">
														<span class="viewcount"><?php echo $video['views']; ?> views</span>
														<span class="metadata-separator">|</span>
														<span class="video-date-added"><?php echo $video['age']; ?></span>
													</div>
													<a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D" dir="ltr"><?php echo $video['author']; ?></a>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- end pagemiddle -->
			<!-- begin pagebottom -->
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
									<li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fvideos%253Ffeature%253Dmh&amp;uilel=3&amp;hl=en_US&amp;service=youtube">sign in</a> to load a different list.</li>
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
						<!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__" class="yt-uix-sessionlink" data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=BFa"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
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
				<a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fvideos%253Ffeature%253Dmh&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
			</div>
			<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
				<div class="addto-menu">
					<div id="addto-list-panel" class="menu-panel active-panel">
						<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fvideos%253Ffeature%253Dmh&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
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
			<!-- end pagebottom -->
		</div>
		<!-- end page -->
<script id="www-core-js" src="/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
		<script>yt.www.thumbnaildelayload.init(0);</script>
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
			
			  yt.setAjaxToken('addto_ajax_logged_out', "rmWO31ZGdmAjKQm23MH57ZskA6Z8MTM0OTExMDQ0NkAxMzQ5MDI0MDQ2");
			
			  yt.pubsub.subscribe('init', yt.www.lists.init);
			
			
			
			
			
			
			
			
			
			  yt.setConfig({'SBOX_JS_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-searchbox-vflsHyn9f.js",'SBOX_SETTINGS': {"CLOSE_ICON_URL": "\/\/s.ytimg.com\/yt\/img\/icons\/close-vflrEJzIW.png", "SHOW_CHIP": false, "PSUGGEST_TOKEN": null, "REQUEST_DOMAIN": "us", "EXPERIMENT_ID": -1, "SESSION_INDEX": null, "HAS_ON_SCREEN_KEYBOARD": false, "CHIP_PARAMETERS": {}, "REQUEST_LANGUAGE": "en"},'SBOX_LABELS': {"SUGGESTION_DISMISS_LABEL": "Dismiss", "SUGGESTION_DISMISSED_LABEL": "Suggestion dismissed"}});
			
			
			
			
			
		</script>
		<script>
			yt.setMsg({
			  'ADDTO_WATCH_LATER_ADDED': "Added",
			  'ADDTO_WATCH_LATER_ERROR': "Error"
			});
		</script>
	</body>
</html>