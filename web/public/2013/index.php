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
	$__server->page_embeds->page_title = "SubRocks";
	$__server->page_embeds->page_description = "Share your videos with friends, family, and the world";
	$__server->page_embeds->page_image = "/yt/imgbin/full-size-logo.png";
	$__server->page_embeds->page_url = "https://subrock.rocks/";
?>
<html lang="en">
	<head>
		<script>
			var yt = yt || {};yt.timing = yt.timing || {};yt.timing.data_ = yt.timing.data_ || {};yt.timing.tick = function(label, opt_time) {var tick = yt.timing.data_['tick'] || {};tick[label] = opt_time || new Date().getTime();yt.timing.data_['tick'] = tick;};yt.timing.info = function(label, value) {var info = yt.timing.data_['info'] || {};info[label] = value;yt.timing.data_['info'] = info;};yt.timing.reset = function() {yt.timing.data_ = {};};if (document.webkitVisibilityState == 'prerender') {yt.timing.info('prerender', 1);document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');try {var externalPt = (window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT);if (externalPt) {yt.timing.info('pt', externalPt);}} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing.info('pt', Math.floor(window.chrome.csi().pageT));}    
		</script>
		<title><?php echo $__server->page_embeds->page_title; ?></title>
		<link rel="search" type="application/opensearchdescription+xml" href="http://www.youtube.com/opensearch?locale=en_US" title="YouTube Video Search">
		<link rel="shortcut icon" href="/yts/img/favicon-vfldLzJxy.ico" type="image/x-icon">
		<link rel="icon" href="//s.ytimg.com/yts/img/favicon_32-vflWoMFGx.png" sizes="32x32">
		<link rel="alternate" media="handheld" href="http://m.youtube.com/index?&amp;desktop_uri=%2F">
		<link rel="alternate" media="only screen and (max-width: 640px)" href="http://m.youtube.com/index?&amp;desktop_uri=%2F">
		<meta name="description" content="<?php echo $__server->page_embeds->page_description; ?>">
		<meta property="og:image" content="/yts/imgbin/www-embed.png">
		<link id="css-2955892050" rel="stylesheet" href="/yts/cssbin/www-core-vflEJosKh.css">
		<link id="css-151587203" rel="stylesheet" href="/yts/cssbin/www-home-vfl_Eri60.css">
		<script>
			if (window.yt.timing) {yt.timing.tick("ct");}    
		</script>
	</head>
	<body dir="ltr" class="  ltr      site-left-aligned  exp-new-site-width  exp-watch7-comment-ui  hitchhiker-enabled      guide-enabled    guide-expanded  ">
		<div id="body-container">
			<form name="logoutForm" method="POST" action="/logout"><input type="hidden" name="action_logout" value="1"></form>
			<?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/2013_header.php"); ?>
			<div id="alerts"></div>
			<div id="header">
				<div id="masthead_child_div"></div>
				<div id="ad_creative_expand_btn_1" class="masthead-ad-control masthead-ad-control-lohp open hid">
					<a onclick="masthead.expand_ad(); return false;">
					<span>Show ad</span>
					<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="">
					</a>
				</div>
			</div>
			<div id="page-container">
				<div id="page" class="  home     branded-page-v2-detached-top  clearfix">
					<div id="guide"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/2013_guide.php"); ?></div>
					<div id="content" class="">
						<div class="branded-page-v2-container enable-fancy-subscribe-button  branded-page-v2-secondary-column-hidden">
							<div class="branded-page-v2-col-container clearfix">
								<div class="branded-page-v2-primary-col">
									<div class="branded-page-v2-primary-col-header-container">
										<div id="context-source-container" data-context-source="Popular on YouTube" style="display:none;"></div>
									</div>
									<div class="branded-page-v2-body" id="gh-activityfeed">
										<div class="context-data-container">
											<div class="lohp-newspaper-shelf">
												<div class="lohp-large-shelf-container">
                                                    <?php
                                                        $stmt = $__db->prepare("SELECT * FROM videos WHERE featured = 'v' ORDER BY id DESC LIMIT 1");
                                                        $stmt->execute();
                                                        while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                            $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                            $video['duration'] = $__time_h->timestamp($video['duration']);
                                                            $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                            $video['author'] = htmlspecialchars($video['author']);		
                                                            $video['title'] = htmlspecialchars($video['title']);
                                                            $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                    ?>
                                                        <div class="context-data-item" data-context-item-id="<?php echo $video['rid'];  ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title'];  ?>" data-context-item-views="<?php echo $video['views'];  ?> views" data-context-item-user="<?php echo $video['author'];  ?>" data-context-item-time="6:58">
                                                            <a href="/watch?v=<?php echo $video['rid'];  ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAMQ0x4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-370 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" alt="Thumbnail" width="370"><span class="vertical-align"></span></span></span></span><span class="video-time">6:58</span>
                                                            <button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid'];  ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                                                            </span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
                                                            </button>
                                                            </a>
                                                            <a class="lohp-video-link max-line-2 yt-uix-sessionlink" data-sessionlink="ved=CAMQ0x4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid'];  ?>" title="<?php echo $video['title'];  ?>"><?php echo $video['title'];  ?></a>
                                                            <div class="lohp-video-metadata attached">
                                                                <span class="content-uploader">
                                                                <span class="username-prepend">by</span> <a href="/user/<?php echo $video['author'];  ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=7pFAUZzAG52shAGGr4DACw" dir="ltr"><?php echo $video['author'];  ?></a>
                                                                </span>
                                                            </div>
                                                            <p title="<?php echo $video['description'];  ?>" class="lohp-blog-headline">
                                                                <?php echo $video['description'];  ?>
                                                            </p>
                                                            <a title="Trending" href="#" class="lohp-blog-attribution">
                                                            <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" class="lohp-blog-decoration">Trending & Featured: SubRocks
                                                            </a>
                                                        </div>
                                                    <?php } ?>
												</div>
												<div class="lohp-medium-shelves-container">
                                                    <?php
                                                        $stmt = $__db->prepare("SELECT * FROM videos WHERE featured = 'v' ORDER BY id DESC LIMIT 1, 3");
                                                        $stmt->execute();
                                                        while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                            $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                            $video['duration'] = $__time_h->timestamp($video['duration']);
                                                            $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                            $video['author'] = htmlspecialchars($video['author']);		
                                                            $video['title'] = htmlspecialchars($video['title']);
                                                            $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                    ?>
													<div class="lohp-medium-shelf context-data-item" data-context-item-id="<?php echo $video['rid'];  ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title'];  ?>" data-context-item-views="5,761,446 views" data-context-item-user="<?php echo $video['author'];  ?>" data-context-item-time="<?php echo $video['duration'];  ?>">
														<div class="lohp-media-object">
															<a href="/watch?v=<?php echo $video['rid'];  ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAQQ0x4oAQ&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-128 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $video['thumbnail'];  ?>" alt="Thumbnail" width="128"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration'];  ?></span>
															<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid'];  ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
															</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
															</button>
															</a>
														</div>
														<div class="lohp-media-object-content lohp-medium-shelf-content">
															<a class="lohp-video-link max-line-1 yt-uix-sessionlink" data-sessionlink="ved=CAQQ0x4oAQ&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid'];  ?>" title="<?php echo $video['title'];  ?>"><?php echo $video['title'];  ?></a>
															<div class="lohp-video-metadata attached">
																<span class="content-uploader">
																<span class="username-prepend">by</span> <a href="/user/<?php echo $video['author'];  ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=7pFAUZzAG52shAGGr4DACw" dir="ltr"><?php echo $video['author'];  ?></a>
																</span>
															</div>
															<p title="<?php echo $video['title'];  ?>" class="lohp-blog-headline">
																<?php echo $video['title'];  ?>
															</p>
														</div>
													</div>
                                                    <?php } ?>
												</div>
											</div>
											<div class="lohp-vbox-list lohp-left-vbox-list">
												<div>
													<div class="lohp-shelf-cell-container lohp-category-shelf last-shelf-in-line recent-videos">
														<div class="lohp-category-shelf-item-list lohp-shelf-size-3">
															<h2 class="branded-page-module-title">
																<a class="spf-link yt-uix-sessionlink" href="/channel/HCxAJ-ON2kZuw?feature=g-logo" title="Entertainment" data-sessionlink="ved=CAoQzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
																Recent Videos
																</a>
															</h2>
                                                            <?php
                                                                $stmt = $__db->prepare("SELECT * FROM videos ORDER BY id DESC LIMIT 6");
                                                                $stmt->execute();
                                                                while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                                    $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                                    $video['duration'] = $__time_h->timestamp($video['duration']);
                                                                    $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                                    $video['author'] = htmlspecialchars($video['author']);		
                                                                    $video['title'] = htmlspecialchars($video['title']);
                                                                    $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                            ?>
															<div class="lohp-category-shelf-item context-data-item first-shelf-item" style="margin-right:3.3px;margin-bottom:20px;" data-context-item-id="<?php echo $video['rid']; ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title']; ?>" data-context-item-views="<?php echo $video['views']; ?> views" data-context-item-user="WarnerBrosPictures" data-context-item-time="<?php echo $video['timestamp']; ?>">
																<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-189 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="189"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
																<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
																</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
																</button>
																</a>
																<a class="lohp-video-link max-line-2 yt-uix-sessionlink" data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></a>
																<div class="lohp-video-metadata">
																	<span class="view-count">
																	<?php echo $video['views']; ?> views
																	</span>
																	<span class="content-item-time-created" title="<?php echo $video['age']; ?>">
																	<?php echo $video['age']; ?>
																	</span>
																</div>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<div>
													<div class="lohp-shelf-cell-container lohp-category-shelf last-shelf-in-line">
														<div class="lohp-category-shelf-item-list lohp-shelf-size-3">
															<h2 class="branded-page-module-title">
																<a class="spf-link yt-uix-sessionlink" href="/channel/HCOvlZkU39tdk?feature=g-logo" title="Entertainment" data-sessionlink="ved=CBAQzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
																Entertainment
																</a>
															</h2>
															<?php
                                                                $stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Entertainment' ORDER BY rand() LIMIT 3");
                                                                $stmt->execute();
                                                                while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                                    $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                                    $video['duration'] = $__time_h->timestamp($video['duration']);
                                                                    $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                                    $video['author'] = htmlspecialchars($video['author']);		
                                                                    $video['title'] = htmlspecialchars($video['title']);
                                                                    $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                            ?>
															<div class="lohp-category-shelf-item context-data-item first-shelf-item" style="margin-right:3.3px;margin-bottom:20px;" data-context-item-id="<?php echo $video['rid']; ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title']; ?>" data-context-item-views="<?php echo $video['views']; ?> views" data-context-item-user="WarnerBrosPictures" data-context-item-time="<?php echo $video['timestamp']; ?>">
																<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-189 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="189"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
																<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
																</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
																</button>
																</a>
																<a class="lohp-video-link max-line-2 yt-uix-sessionlink" data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></a>
																<div class="lohp-video-metadata">
																	<span class="view-count">
																	<?php echo $video['views']; ?> views
																	</span>
																	<span class="content-item-time-created" title="<?php echo $video['age']; ?>">
																	<?php echo $video['age']; ?>
																	</span>
																</div>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<div>
													<div class="lohp-shelf-cell-container lohp-category-shelf last-shelf-in-line">
														<div class="lohp-category-shelf-item-list lohp-shelf-size-3">
															<h2 class="branded-page-module-title">
																<a class="spf-link yt-uix-sessionlink" href="/channel/HC7Dr1BKwqctY?feature=g-logo" title="Sports" data-sessionlink="ved=CBYQzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
																Sports
																</a>
															</h2>
															<?php
                                                                $stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Sports' ORDER BY rand() LIMIT 3");
                                                                $stmt->execute();
                                                                while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                                    $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                                    $video['duration'] = $__time_h->timestamp($video['duration']);
                                                                    $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                                    $video['author'] = htmlspecialchars($video['author']);		
                                                                    $video['title'] = htmlspecialchars($video['title']);
                                                                    $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                            ?>
															<div class="lohp-category-shelf-item context-data-item first-shelf-item" style="margin-right:3.3px;margin-bottom:20px;" data-context-item-id="<?php echo $video['rid']; ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title']; ?>" data-context-item-views="<?php echo $video['views']; ?> views" data-context-item-user="WarnerBrosPictures" data-context-item-time="<?php echo $video['timestamp']; ?>">
																<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-189 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="189"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
																<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
																</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
																</button>
																</a>
																<a class="lohp-video-link max-line-2 yt-uix-sessionlink" data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></a>
																<div class="lohp-video-metadata">
																	<span class="view-count">
																	<?php echo $video['views']; ?> views
																	</span>
																	<span class="content-item-time-created" title="<?php echo $video['age']; ?>">
																	<?php echo $video['age']; ?>
																	</span>
																</div>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<div>
													<div class="lohp-shelf-cell-container lohp-category-shelf ">
														<div class="lohp-category-shelf-item-list lohp-shelf-size-1">
															<h2 class="branded-page-module-title">
																<a class="spf-link yt-uix-sessionlink" href="/channel/UC9qMYlwD57jSfVPDJLySy9g?feature=g-logo" title="MaryHDennis3" data-sessionlink="ved=CBwQzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
																    bhief
																</a>
															</h2>
                                                            <?php
                                                                $stmt = $__db->prepare("SELECT * FROM videos WHERE author = 'bhief' ORDER BY rand() LIMIT 1");
                                                                $stmt->execute();
                                                                while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                                    $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                                    $video['duration'] = $__time_h->timestamp($video['duration']);
                                                                    $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                                    $video['author'] = htmlspecialchars($video['author']);		
                                                                    $video['title'] = htmlspecialchars($video['title']);
                                                                    $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                            ?>
															<div class="lohp-category-shelf-item context-data-item first-shelf-item last-shelf-item" data-context-item-id="<?php echo $video['rid']; ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title']; ?>" data-context-item-views="<?php echo $video['views']; ?> views" data-context-item-user="WarnerBrosPictures" data-context-item-time="<?php echo $video['timestamp']; ?>">
																<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-189 " style="width:172px;"><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="189"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
																<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
																</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
																</button>
																</a>
																<a class="lohp-video-link max-line-2 yt-uix-sessionlink" data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></a>
																<div class="lohp-video-metadata">
																	<span class="view-count">
																	<?php echo $video['views']; ?> views
																	</span>
																	<span class="content-item-time-created" title="<?php echo $video['age']; ?>">
																	<?php echo $video['age']; ?>
																	</span>
																</div>
															</div>
															<?php } ?>
														</div>
													</div>
													<div class="lohp-shelf-cell-container lohp-category-shelf last-shelf-in-line">
														<div class="lohp-category-shelf-item-list lohp-shelf-size-2">
															<h2 class="branded-page-module-title">
																<a class="spf-link yt-uix-sessionlink" href="/channel/HCp-Rdqh3z4Uc?feature=g-logo" title="Music" data-sessionlink="ved=CB8Qzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
																Music
																</a>
															</h2>
															<?php
                                                                $stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Music' ORDER BY rand() LIMIT 2");
                                                                $stmt->execute();
                                                                while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                                    $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                                    $video['duration'] = $__time_h->timestamp($video['duration']);
                                                                    $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                                    $video['author'] = htmlspecialchars($video['author']);		
                                                                    $video['title'] = htmlspecialchars($video['title']);
                                                                    $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                            ?>
															<div class="lohp-category-shelf-item context-data-item first-shelf-item last-shelf-item" data-context-item-id="<?php echo $video['rid']; ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title']; ?>" data-context-item-views="<?php echo $video['views']; ?> views" data-context-item-user="WarnerBrosPictures" data-context-item-time="<?php echo $video['timestamp']; ?>">
																<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-189 " style="width:172px;"><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="189"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
																<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
																</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
																</button>
																</a>
																<a class="lohp-video-link max-line-2 yt-uix-sessionlink" data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></a>
																<div class="lohp-video-metadata">
																	<span class="view-count">
																	<?php echo $video['views']; ?> views
																	</span>
																	<span class="content-item-time-created" title="<?php echo $video['age']; ?>">
																	<?php echo $video['age']; ?>
																	</span>
																</div>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<div>
													<div class="lohp-shelf-cell-container lohp-category-shelf last-shelf-in-line">
														<div class="lohp-category-shelf-item-list lohp-shelf-size-3">
															<h2 class="branded-page-module-title">
																<a class="spf-link yt-uix-sessionlink" href="/channel/HChfZhJdhTqX8?feature=g-logo" title="Gaming" data-sessionlink="ved=CCQQzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
																Gaming
																</a>
															</h2>
                                                            <?php
                                                                $stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Gaming' ORDER BY rand() LIMIT 3");
                                                                $stmt->execute();
                                                                while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                                    $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                                    $video['duration'] = $__time_h->timestamp($video['duration']);
                                                                    $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                                    $video['author'] = htmlspecialchars($video['author']);		
                                                                    $video['title'] = htmlspecialchars($video['title']);
                                                                    $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                            ?>
															<div class="lohp-category-shelf-item context-data-item first-shelf-item" style="margin-right:3.3px;margin-bottom:20px;" data-context-item-id="<?php echo $video['rid']; ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title']; ?>" data-context-item-views="<?php echo $video['views']; ?> views" data-context-item-user="WarnerBrosPictures" data-context-item-time="<?php echo $video['timestamp']; ?>">
																<a href="/watch?v=<?php echo $video['rid']; ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-189 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="189"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
																<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
																</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
																</button>
																</a>
																<a class="lohp-video-link max-line-2 yt-uix-sessionlink" data-sessionlink="ved=CAsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid']; ?>" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></a>
																<div class="lohp-video-metadata">
																	<span class="view-count">
																	<?php echo $video['views']; ?> views
																	</span>
																	<span class="content-item-time-created" title="<?php echo $video['age']; ?>">
																	<?php echo $video['age']; ?>
																	</span>
																</div>
															</div>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
											<div class="lohp-vbox-list lohp-right-vbox-list">
												<div class="lohp-vertical-shelf">
													<h2 class="branded-page-module-title">
														<a class="spf-link yt-uix-sessionlink" href="/channel/HCPvDBPPFfuaM?feature=g-logo" title="Gaming" data-sessionlink="ved=CCoQzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
														Gaming
														</a>
													</h2>
                                                    <?php
                                                        $stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Gaming' ORDER BY rand() LIMIT 2");
                                                        $stmt->execute();
                                                        while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                            $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                            $video['duration'] = $__time_h->timestamp($video['duration']);
                                                            $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                            $video['author'] = htmlspecialchars($video['author']);		
                                                            $video['title'] = htmlspecialchars($video['title']);
                                                            $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                    ?>	
													<div class="lohp-vertical-shelf-item context-data-item" data-context-item-id="<?php echo $video['rid'];  ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title'];  ?>" data-context-item-views="303 views" data-context-item-user="<?php echo $video['author'];  ?>" data-context-item-time="<?php echo $video['duration'];  ?>">
                                                        <div class="lohp-media-object">
															<a href="/watch?v=<?php echo $video['rid'];  ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CCsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-64 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="64"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration'];  ?></span>
															<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid'];  ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
															</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
															</button>
															</a>
														</div>
														<div class="lohp-vertical-shelf-item-content lohp-media-object-content">
															<a class="lohp-video-link max-line-3 yt-uix-sessionlink" data-sessionlink="ved=CCsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid'];  ?>" title="<?php echo $video['title'];  ?>"><?php echo $video['title'];  ?></a>
															<div class="lohp-video-metadata attached">
																<span class="content-uploader">
																<span class="username-prepend">by</span> <a href="/user/<?php echo $video['author'];  ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=7pFAUZzAG52shAGGr4DACw" dir="ltr"><?php echo $video['author'];  ?></a>
																</span>
															</div>
														</div>
													</div>
                                                    <?php } ?>
												</div>
												<div class="lohp-vertical-shelf">
													<h2 class="branded-page-module-title">
														<a class="spf-link yt-uix-sessionlink" href="/channel/HCp-Rdqh3z4Uc?feature=g-logo" title="Music" data-sessionlink="ved=CC4Qzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
														Music
														</a>
													</h2>
                                                    <?php
                                                        $stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Music' ORDER BY rand() LIMIT 4");
                                                        $stmt->execute();
                                                        while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                            $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                            $video['duration'] = $__time_h->timestamp($video['duration']);
                                                            $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                            $video['author'] = htmlspecialchars($video['author']);		
                                                            $video['title'] = htmlspecialchars($video['title']);
                                                            $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                    ?>	
													<div class="lohp-vertical-shelf-item context-data-item" data-context-item-id="<?php echo $video['rid'];  ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title'];  ?>" data-context-item-views="303 views" data-context-item-user="<?php echo $video['author'];  ?>" data-context-item-time="<?php echo $video['duration'];  ?>">
                                                        <div class="lohp-media-object">
															<a href="/watch?v=<?php echo $video['rid'];  ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CCsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-64 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="64"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration'];  ?></span>
															<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid'];  ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
															</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
															</button>
															</a>
														</div>
														<div class="lohp-vertical-shelf-item-content lohp-media-object-content">
															<a class="lohp-video-link max-line-3 yt-uix-sessionlink" data-sessionlink="ved=CCsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid'];  ?>" title="<?php echo $video['title'];  ?>"><?php echo $video['title'];  ?></a>
															<div class="lohp-video-metadata attached">
																<span class="content-uploader">
																<span class="username-prepend">by</span> <a href="/user/<?php echo $video['author'];  ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=7pFAUZzAG52shAGGr4DACw" dir="ltr"><?php echo $video['author'];  ?></a>
																</span>
															</div>
														</div>
													</div>
                                                    <?php } ?>
												</div>
												<div class="lohp-vertical-shelf">
													<h2 class="branded-page-module-title">
														<a class="spf-link yt-uix-sessionlink" href="/channel/HC4qRk91tndwg?feature=g-logo" title="Most Popular" data-sessionlink="ved=CDQQzh4&amp;ei=7pFAUZzAG52shAGGr4DACw">
                                                            Trending
														</a>
													</h2>
                                                    <?php
                                                        $stmt = $__db->prepare("SELECT * FROM videos WHERE category = 'Trending' ORDER BY rand() LIMIT 4");
                                                        $stmt->execute();
                                                        while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                                                            $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                                                            $video['duration'] = $__time_h->timestamp($video['duration']);
                                                            $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                                            $video['author'] = htmlspecialchars($video['author']);		
                                                            $video['title'] = htmlspecialchars($video['title']);
                                                            $video['description'] = $__video_h->shorten_description($video['description'], 50);
                                                    ?>	
													<div class="lohp-vertical-shelf-item context-data-item" data-context-item-id="<?php echo $video['rid'];  ?>" data-context-item-type="video" data-context-item-title="<?php echo $video['title'];  ?>" data-context-item-views="303 views" data-context-item-user="<?php echo $video['author'];  ?>" data-context-item-time="<?php echo $video['duration'];  ?>">
                                                        <div class="lohp-media-object">
															<a href="/watch?v=<?php echo $video['rid'];  ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="ved=CCsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo"><span class="video-thumb ux-thumb yt-thumb-default-64 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="64"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration'];  ?></span>
															<button onclick=";return false;" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" title="Watch Later" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid'];  ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
															</span>  <img class="yt-uix-button-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="" title="">
															</button>
															</a>
														</div>
														<div class="lohp-vertical-shelf-item-content lohp-media-object-content">
															<a class="lohp-video-link max-line-3 yt-uix-sessionlink" data-sessionlink="ved=CCsQzx4oAA&amp;ei=7pFAUZzAG52shAGGr4DACw&amp;feature=g-logo" href="/watch?v=<?php echo $video['rid'];  ?>" title="<?php echo $video['title'];  ?>"><?php echo $video['title'];  ?></a>
															<div class="lohp-video-metadata attached">
																<span class="content-uploader">
																<span class="username-prepend">by</span> <a href="/user/<?php echo $video['author'];  ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=7pFAUZzAG52shAGGr4DACw" dir="ltr"><?php echo $video['author'];  ?></a>
																</span>
															</div>
														</div>
													</div>
                                                    <?php } ?>
												</div>
											</div>
											<div style="clear:both;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="footer-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/2013_footer.php"); ?></div>
		<div class="yt-dialog hid" id="feed-privacy-lb">
			<div class="yt-dialog-base">
				<span class="yt-dialog-align"></span>
				<div class="yt-dialog-fg">
					<div class="yt-dialog-fg-content">
						<div class="yt-dialog-loading">
							<div class="yt-dialog-waiting-content">
								<div class="yt-spinner-img"></div>
								<div class="yt-dialog-waiting-text">Loading...</div>
							</div>
						</div>
						<div class="yt-dialog-content">
							<div id="feed-privacy-dialog">
							</div>
						</div>
						<div class="yt-dialog-working">
							<div id="yt-dialog-working-overlay">
							</div>
							<div id="yt-dialog-working-bubble">
								<div class="yt-dialog-waiting-content">
									<div class="yt-spinner-img"></div>
									<div class="yt-dialog-waiting-text">Working...</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="shared-addto-watch-later-login" class="hid">
			<a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26hl%3Den_US%26next%3D%252F%26nomobiletemp%3D1&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
		</div>
		<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
			<div class="addto-menu">
				<div id="addto-list-panel" class="menu-panel active-panel">
					<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26hl%3Den_US%26next%3D%252F%26nomobiletemp%3D1&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
					</span>
				</div>
				<div id="addto-list-saved-panel" class="menu-panel">
					<div class="panel-content">
						<div class="yt-alert yt-alert-naked yt-alert-success  ">
							<div class="yt-alert-icon">
								<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
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
						<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
						<span class="error-details"></span>
						<a class="show-menu-link">Back to list</a>
					</div>
				</div>
				<div id="addto-note-input-panel" class="menu-panel">
					<div class="panel-content">
						<div class="yt-alert yt-alert-naked yt-alert-success  ">
							<div class="yt-alert-icon">
								<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
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
						<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
						<span>Saving note...</span>
					</div>
				</div>
				<div id="addto-note-saved-panel" class="menu-panel">
					<div class="panel-content">
						<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
						<span class="message">Note added to:</span>
					</div>
				</div>
				<div id="addto-note-error-panel" class="menu-panel">
					<div class="panel-content">
						<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
						<span class="message">Error adding note:</span>
						<ul class="error-details"></ul>
						<a class="add-note-link">Click to add a new note</a>
					</div>
				</div>
				<div class="close-note hid">
					<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" class="close-button">
				</div>
			</div>
		</div>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_head");}    
		</script>
		<script id="js-3960859142" src="//s.ytimg.com/yts/jsbin/www-core-vflKz5-wF.js" data-loaded="true"></script>
		<script>
			var searchBox = document.getElementById('masthead-search-term');
			if (searchBox) {
			  searchBox.focus();
			}
			  yt.setConfig('FEED_DEBUG', true);
			
		</script>
		<script>
			// yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yts\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
			yt.setConfig({
			'PLAYER_CONFIG': {"url": "\/\/s.ytimg.com\/yts\/swf\/masthead_child-vflRMMO6_.swf", "url_v9as2": "", "url_v8": "", "params": {"bgcolor": "#FFFFFF", "allowfullscreen": "false", "allowscriptaccess": "always"}, "attrs": {"width": "1", "id": "masthead_child", "height": "1"}, "min_version": "8.0.0", "args": {"enablejsapi": 1}, "html5": false}
			});
			
			// yt.flash.embed("masthead_child_div", yt.getConfig('PLAYER_CONFIG'));
		</script>
		<script id="js-90506381" src="//s.ytimg.com/yts/jsbin/www-home-vflk-sIPg.js" data-loaded="true"></script>
		<script>
			yt.setConfig({
			  'GUIDE_SELECTED_ITEM': "youtube"
			});
		</script>
		<script>yt.setConfig({'EVENT_ID': "7pFAUZzAG52shAGGr4DACw",'LOGGED_IN': false,'SESSION_INDEX': null,'CURRENT_URL': "http:\/\/www.youtube.com\/",'SAFETY_MODE_PENDING': false,'WATCH_CONTEXT_CLIENTSIDE': true,'FEEDBACK_BUCKET_ID': "Home",'FEEDBACK_LOCALE_LANGUAGE': "en",'FEEDBACK_LOCALE_EXTRAS': {"logged_in": false, "guide_subs": 8, "accept_language": null, "experiments": "906378,925005,919359,910207,914061,916611,920704,912806,902000,919512,929901,913605,925006,906938,931202,931401,908529,930803,920201,930101,930603,906834,926403", "is_branded": "", "is_partner": ""}});yt.setMsg({'ADDTO_WATCH_LATER_ADDED': "Added",'ADDTO_WATCH_LATER_ERROR': "Error"});yt.setAjaxToken('addto_ajax_logged_out', "H6seGTii3HNcaaSYiOcuR3-DGLF8MTM2MzI3MjU1OEAxMzYzMTg2MTU4");yt.setAjaxToken('channel_details_ajax', "TwF1IzDuM74TMIFat4yLZSiVCVB8MTM2MzI3MjU1OEAxMzYzMTg2MTU4");  yt.setConfig('FEED_PRIVACY_CSS_URL', "\/\/s.ytimg.com\/yts\/cssbin\/www-feedprivacydialog-vflQ4FT2R.css");
			yt.setAjaxToken('feed_privacy_ajax', "");
			  yt.pubsub.subscribe('init', yt.www.account.FeedPrivacyDialog.init);
			yt.setConfig({'SBOX_JS_URL': "\/\/s.ytimg.com\/yts\/jsbin\/www-searchbox-vflzZmr_k.js",'SBOX_SETTINGS': {"SESSION_INDEX": null, "SHOW_CHIP": false, "USE_HTTPS": false, "PSUGGEST_TOKEN": null, "HAS_ON_SCREEN_KEYBOARD": false, "REQUEST_LANGUAGE": "en", "IS_HH": true, "EXPERIMENT_ID": -1, "REQUEST_DOMAIN": "us", "CHIP_PARAMETERS": {}, "CLOSE_ICON_URL": "\/\/s.ytimg.com\/yts\/img\/icons\/close-vflrEJzIW.png"},'SBOX_LABELS': {"SUGGESTION_DISMISS_LABEL": "Dismiss", "SUGGESTION_DISMISSED_LABEL": "Suggestion dismissed"}});
		</script>    <script>
			yt.setConfig({'TIMING_ACTION': "glo",'TIMING_INFO': {"mod_li": 0, "mod_spf": 0, "e": "906378,925005,919359,910207,914061,916611,920704,912806,902000,919512,929901,913605,925006,906938,931202,931401,908529,930803,920201,930101,930603,906834,926403", "mod_lt": "cold"}});    
		</script>
		<script>yt.setConfig({'XSRF_TOKEN': "S0uwk0EgvxoAOX_v0c0U9_twFVh8MTM2MzI3MjU1OEAxMzYzMTg2MTU4",'XSRF_REDIRECT_TOKEN': "5MaT5zwJCAslCgglIiPwGx8NqXZ8MTM2MzIwMDU1OEAxMzYzMTg2MTU4",'XSRF_FIELD_NAME': "session_token"});</script><script>yt.setConfig('THUMB_DELAY_LOAD_BUFFER', 300);</script>    <script>
			if (window.yt.timing) {yt.timing.tick("js_foot");}    
		</script>
		<div id="debug"></div>
	</body>
</html>
