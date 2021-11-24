<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
	if(isset($_SESSION['siteusername']))
	    $_user_hp = $__user_h->fetch_user_username($_SESSION['siteusername']);

    if(!$__user_h->user_exists($_GET['n']))
        header("Location: /?userdoesntexist");

    $_user = $__user_h->fetch_user_username($_GET['n']);

	$stmt = $__db->prepare("SELECT * FROM bans WHERE username = :username ORDER BY id DESC");
	$stmt->bindParam(":username", $_user['username']);
	$stmt->execute();

	while($ban = $stmt->fetch(PDO::FETCH_ASSOC)) { 
		header("Location: /?error=This user has been terminated for violating SubRock's Community Guidelines.");
	}

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

	function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}

    function check_valid_colorhex($colorCode) {
        // If user accidentally passed along the # sign, strip it off
        $colorCode = ltrim($colorCode, '#');
    
        if (
              ctype_xdigit($colorCode) &&
              (strlen($colorCode) == 6 || strlen($colorCode) == 3))
                   return true;
    
        else return false;
    }

    $_user['subscribed'] = $__user_h->if_subscribed(@$_SESSION['siteusername'], $_user['username']);
    $_user['subscribers'] = $__user_h->fetch_subs_count($_user['username']);
    $_user['videos'] = $__user_h->fetch_user_videos($_user['username']);
    $_user['favorites'] = $__user_h->fetch_user_favorites($_user['username']);
    $_user['subscriptions'] = $__user_h->fetch_subscriptions($_user['username']);
    $_user['views'] = $__video_h->fetch_views_from_user($_user['username']);
    $_user['friends'] = $__user_h->fetch_friends_accepted($_user['username']);

    $_user['s_2009_user_left'] = $_user['2009_user_left'];
    $_user['s_2009_user_right'] = $_user['2009_user_right'];
    $_user['2009_user_left'] = explode(";", $_user['2009_user_left']);
    $_user['2009_user_right'] = explode(";", $_user['2009_user_right']);

    $_user['primary_color'] = substr($_user['primary_color'], 0, 7);
    $_user['secondary_color'] = substr($_user['secondary_color'], 0, 7);
    $_user['third_color'] = substr($_user['third_color'], 0, 7);
    $_user['text_color'] = substr($_user['text_color'], 0, 7);
    $_user['primary_color_text'] = substr($_user['primary_color_text'], 0, 7);
    $_user['2009_bgcolor'] = substr($_user['2009_bgcolor'], 0, 7);

    $_user['genre'] = strtolower($_user['genre']);
    $_user['subscribed'] = $__user_h->if_subscribed(@$_SESSION['siteusername'], $_user['username']);

    if(!check_valid_colorhex($_user['primary_color']) && strlen($_user['primary_color']) != 6) { $_user['primary_color'] = ""; }
    if(!check_valid_colorhex($_user['secondary_color']) && strlen($_user['secondary_color']) != 6) { $_user['secondary_color'] = ""; }
    if(!check_valid_colorhex($_user['third_color']) && strlen($_user['third_color']) != 6) { $_user['third_color'] = ""; }
    if(!check_valid_colorhex($_user['text_color']) && strlen($_user['text_color']) != 6) { $_user['text_color'] = ""; }
    if(!check_valid_colorhex($_user['primary_color_text']) && strlen($_user['primary_color_text']) != 6) { $_user['primary_color_text'] = ""; }
    if(!check_valid_colorhex($_user['2009_bgcolor']) && strlen($_user['2009_bgcolor']) != 6) { $_user['2009_bgcolor'] = ""; }

	if(isset($_SESSION['siteusername']))
    	$__user_i->check_view_channel($_user['username'], @$_SESSION['siteusername']);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array();

        if(!isset($_SESSION['siteusername'])){ $error['message'] = "you are not logged in"; $error['status'] = true; }
        if(!$_POST['comment']){ $error['message'] = "your comment cannot be blank"; $error['status'] = true; }
        if(strlen($_POST['comment']) > 1000){ $error['message'] = "your comment must be shorter than 1000 characters"; $error['status'] = true; }
        //if(!isset($_POST['g-recaptcha-response'])){ $error['message'] = "captcha validation failed"; $error['status'] = true; }
        //if(!$_user_insert_utils->validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error['message'] = "captcha validation failed"; $error['status'] = true; }
        if($__user_h->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for a minute before posting another comment."; $error['status'] = true; }
        //if(ifBlocked(@$_SESSION['siteusername'], $user['username'], $__db)) { $error = "This user has blocked you!"; $error['status'] = true; } 

        if(!isset($error['message'])) {
			$text = $_POST['comment'];
            $stmt = $__db->prepare("INSERT INTO profile_comments (toid, author, comment) VALUES (:id, :username, :comment)");
			$stmt->bindParam(":id", $_user['username']);
			$stmt->bindParam(":username", $_SESSION['siteusername']);
			$stmt->bindParam(":comment", $text);
            $stmt->execute();

            $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);

            if(@$_SESSION['siteusername'] != $_user['username']) { 
                $_user_insert_utils->send_message($_user['username'], "New comment", 'I commented "' . $_POST['comment'] . '" on your profile!', $_SESSION['siteusername']);
            }
        }
    }
?>
<?php
	$__server->page_embeds->page_title = "SubRocks - " . htmlspecialchars($_user['username']);
	$__server->page_embeds->page_description = htmlspecialchars($_user['bio']);
	$__server->page_embeds->page_image = "/dynamic/pfp/" . htmlspecialchars($_user['pfp']);
	$__server->page_embeds->page_url = "https://subrock.rocks/";
?>
<!DOCTYPE html>
<html dir="ltr" xmlns:og="http://opengraphprotocol.org/schema/" lang="en">
	<!-- machid: sNW5tN3Z2SWdXaDRqNGxuNEF5MFBxM1BxWXd0VGo0Rkg3UXNTTTNCUGRDWjR0WGpHR3R1YzFR -->
	<head>
        <title><?php echo $__server->page_embeds->page_title; ?></title>
		<meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
		<script src="/s/js/alert.js"></script>
		<script>
			var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="/yt/jsbin/plupload.full.min.js"></script>
		<link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
		<link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
        <link rel="stylesheet" href="/yt/cssbin/www-channels3-vfl-wJB5W.css">
        <link rel="stylesheet" href="/yt/cssbin/www-the-rest-vflNb6rAI.css">
		<link rel="stylesheet" href="/yt/cssbin/www-extra.css">
		<style>
			#content-container {
				background-color: <?php echo $_user['primary_color'];  ?>;
				background-image: url(/dynamic/banners/<?php echo $_user['2012_bg']; ?>);
				background-repeat: repeat;
				<?php
					switch($_user['2012_bgoption']) {
						case "stretch":
						echo "background-size: cover;";
						break;
						case "solid":
						echo "";
						break;
						case "norepeat":
						echo "background-repeat: no-repeat !important;";
						break;
						case "repeatxy":
						echo "background-repeat: repeat;";
						break;
						case "repeaty":
						echo "background-repeat: repeat-y;";
						break;
						case "repeatx":
						echo "background-repeat: repeat-x;";
						break;
					}
				?>
			}
   		</style>
	</head>
	<body id="" class="date-20120614 en_US ltr   ytg-old-clearfix " dir="ltr">
		<form name="logoutForm" method="POST" action="/logout">
			<input type="hidden" name="action_logout" value="1">
		</form>
		<!-- begin page -->
		<div id="page" class="  branded-page channel ">
			<div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php"); ?></div>
			<div id="content-container">
				<!-- begin content -->
				<?php if(isset($_SESSION['siteusername']) && $_user['username'] == $_SESSION['siteusername']) { ?>
					<div class="channel_customization"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/channel_customization.php"); ?></div>
				<?php } ?> 
				<?php
					if(empty(trim($_user['bio'])))
						$_user['bio'] = "This user has no description.";
				?>
				<div id="content">
					<div class="subscription-menu-expandable subscription-menu-expandable-channels3 yt-rounded ytg-wide hid">
						<div class="content" id="recommended-channels-list"></div>
						<button class="close" type="button">close</button>
					</div>
					<div class="hid">
						<div class="yt-alert yt-alert-default yt-alert-success  " id="success-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-error  " id="error-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-warn  " id="warn-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-info  " id="info-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-status  " id="status-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
					</div>
					<div class="hid">
						<div id="message-container-template" class="message-container"></div>
					</div>
					<div id="branded-page-default-bg" class="ytg-base">
						<div id="branded-page-body-container" class="ytg-base clearfix">
							<div id="branded-page-header-container" class="ytg-wide banner-displayed-mode">
								<div id="branded-page-header" class="ytg-wide">
									<div id="channel-header-main">
										<div class="upper-section clearfix">
											<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">
											<span class="profile-thumb">
											<span class="centering-wrap">
											<img src="/dynamic/pfp/<?php echo htmlspecialchars($_user['pfp']); ?>" title="<?php echo htmlspecialchars($_user['username']); ?>" alt="<?php echo htmlspecialchars($_user['username']); ?>">
											</span>
											</span>
											</a>
											<div class="upper-left-section ">
												<h1><?php echo htmlspecialchars($_user['username']); ?></h1>
											</div>
											<div class="upper-left-section enable-fancy-subscribe-button">
											<?php if($_user['username'] != @$_SESSION['siteusername']) { ?>
													<div class="yt-subscription-button-hovercard yt-uix-hovercard">
														<button 
															href="#" 
															onclick=";subscribe();return false;" 
															title="" 
															id="subscribe-button"
															type="button" 
															class="yt-subscription-button <?php if($_user['subscribed']) { echo "subscribed "; } ?>  yt-uix-button yt-uix-button-subscription yt-uix-tooltip" 
															role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-subscribe" 
															src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span><span class="yt-uix-button-content">  <span class="subscribe-label">Subscribe</span>
														<span class="subscribed-label">Subscribed</span>
														<span class="unsubscribe-label">Unsubscribe</span>
														</span></button>
														<div class="yt-uix-hovercard-content hid">
															<p class="loading-spinner">
																<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
																Loading...
															</p>
														</div>
													</div>
												<?php } else { ?>

												<?php } ?>
												<?php if($__user_h->if_partner($_user['username'])) { ?>
													<img style="width: 29px;vertical-align: middle;margin-left: 10px;" title="This user is a SubRocks partner" src="/yt/imgbin/RenderedImage.png">
												<?php } ?>
											</div>
											<div class="upper-right-section">
												<div class="header-stats">
													<div class="stat-entry">
														<span class="stat-value"><?php echo $_user['subscribers']; ?></span>
														<span class="stat-name">subscribers</span>
													</div>
													<div class="stat-entry">
														<span class="stat-value"><?php echo $_user['views']; ?></span>
														<span class="stat-name">video views</span>
													</div>
												</div>
												<span class="valign-shim"></span>
											</div>
										</div>
										<div class="channel-horizontal-menu clearfix">
											<ul>
												<li>
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/featured" class="gh-tab-100">
													Featured
													</a>
												</li>
												<li class="selected">
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/feed" class="gh-tab-102">
													Feed
													</a>
												</li>
												<li>
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/discussion" class="gh-tab-101">
													Discussion
													</a>
												</li>
												<li>
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos" class="gh-tab-101">
													Videos
													</a>
												</li>
											</ul>
											<form id="channel-search" action="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos">
												<input name="query" type="text" maxlength="100" class="search-field" placeholder="Search Channel" value="">
												<button class="search-btn" type="submit">
												<span class="search-btn-content">
												Search
												</span>
												</button>
												<a class="search-dismiss-btn" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos?view=0">
												<span class="search-btn-content">
												Clear
												</span>
												</a>
											</form>
										</div>
									</div>
								</div>
							</div>
                            <?php if($_user['featured'] != "None") { $video = $__video_h->fetch_video_rid($_user['featured']); } else { $_user['featured'] = false; } ?>
							<div id="branded-page-body">
								<div class="channel-tab-content channel-layout-two-column selected blogger-template"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/channel_feed.php"); ?></div>
							</div>
						</div>
					</div>
				</div>
				<!-- end content -->
			</div>
			<div id="footer-container">
				<!-- begin footer -->
				<script>
					if (window.yt.timing) {yt.timing.tick("foot_begin");}    
				</script>
				<div id="footer"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/footer.php"); ?></div>
				<script>
					if (window.yt.timing) {yt.timing.tick("foot_end");}    
				</script>
				<!-- end footer -->
			</div>
			<div id="playlist-bar" class="hid passive editable" data-video-url="/watch?v=&amp;feature=BFql&amp;playnext=1&amp;list=QL" data-list-id="" data-list-type="QL">
				<div id="playlist-bar-bar-container">
					<div id="playlist-bar-bar">
						<div class="yt-alert yt-alert-naked yt-alert-success hid " id="playlist-bar-notifications">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<span id="playlist-bar-info"><span class="playlist-bar-active playlist-bar-group"><button onclick=";return false;" title="Previous video" type="button" id="playlist-bar-prev-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-prev" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"></span></button><span class="playlist-bar-count"><span class="playing-index">0</span> / <span class="item-count">0</span></span><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-next-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-next" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button></span><span class="playlist-bar-active playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-autoplay-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-autoplay" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-shuffle-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-shuffle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button></span><span class="playlist-bar-passive playlist-bar-group"><button onclick=";return false;" title="Play videos" type="button" id="playlist-bar-play-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-play" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Play videos"></span></button><span class="playlist-bar-count"><span class="item-count">0</span></span></span><span id="playlist-bar-title" class="yt-uix-button-group"><span class="playlist-title">Unsaved Playlist</span></span></span>
						<a id="playlist-bar-lists-back" href="#">
						Return to active list
						</a>
						<span id="playlist-bar-controls"><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-text yt-uix-button-empty" onclick=";return false;" id="playlist-bar-toggle-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-toggle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button></span><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked yt-uix-button-reverse flip yt-uix-button yt-uix-button-text" onclick=";return false;" data-button-menu-id="playlist-bar-options-menu" data-button-has-sibling-menu="true" role="button"><span class="yt-uix-button-content">Options </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button></span></span>      
					</div>
				</div>
				<div id="playlist-bar-tray-container">
					<div id="playlist-bar-tray" class="yt-uix-slider yt-uix-slider-fluid">
						<button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-prev" onclick="return false;"><img class="yt-uix-slider-prev-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"></button><button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-next" onclick="return false;"><img class="yt-uix-slider-next-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Next video"></button>
						<div class="yt-uix-slider-body">
							<div id="playlist-bar-tray-content" class="yt-uix-slider-slide">
								<ol class="video-list"></ol>
								<ol id="playlist-bar-help">
									<li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="https://accounts.google.com/ServiceLogin?uilel=3&amp;service=youtube&amp;passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fuser%252F<?php echo htmlspecialchars($_user['username']); ?>%253Ffeature%253Dg-logo-xit&amp;hl=en_US&amp;ltmpl=sso">sign in</a> to load a different list.</li>
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
						<!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
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
				<a href="https://accounts.google.com/ServiceLogin?uilel=3&amp;service=youtube&amp;passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fuser%252F<?php echo htmlspecialchars($_user['username']); ?>%253Ffeature%253Dg-logo-xit&amp;hl=en_US&amp;ltmpl=sso" class="sign-in-link">Sign in</a> to add this to a playlist
			</div>
			<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
				<div class="addto-menu">
					<div id="addto-list-panel" class="menu-panel active-panel">
						<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="https://accounts.google.com/ServiceLogin?uilel=3&amp;service=youtube&amp;passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fuser%252F<?php echo htmlspecialchars($_user['username']); ?>%253Ffeature%253Dg-logo-xit&amp;hl=en_US&amp;ltmpl=sso" class="sign-in-link">Sign in</a> to add this to a playlist
						</span>
					</div>
					<div id="addto-list-saved-panel" class="menu-panel">
						<div class="panel-content">
							<div class="yt-alert yt-alert-naked yt-alert-success  ">
								<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
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
								<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
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
		<script id="www-core-js" src="//s.ytimg.com/yt/jsbin/www-core-vfl-1JTp7.js" data-loaded="true"></script>
		<script>
			yt.setConfig({
			'XSRF_TOKEN': 'HxVja_B7VM4N8Luf5v0rMCobR658MTMzOTgwODA4MkAxMzM5NzIxNjgy',
			'XSRF_FIELD_NAME': 'session_token'
			});
			yt.pubsub.subscribe('init', yt.www.xsrf.populateSessionToken);
			
			yt.setConfig('XSRF_REDIRECT_TOKEN', 'DsikobgaHVx4FiaLsFlCk4-dGCt8MTMzOTgwODA4MkAxMzM5NzIxNjgy');
			
			yt.setConfig('LOGGED_IN', false);
			yt.setConfig('SESSION_INDEX', null);
			
			yt.setConfig('FEEDBACK_LOCALE_LANGUAGE', "en");
			yt.setConfig('FEEDBACK_LOCALE_EXTRAS', {"experiments": "904001,907342,904824,910206,908620,907217,907335,921602,919306,922600,919316,920704,912804,913542,919324,912706", "accept_language": null});
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_head");}    
		</script>
		<script src="//s.ytimg.com/yt/jsbin/www-channels3-vflCdEY9I.js" data-loaded="true"></script>
		<script>
			yt.setConfig('CHANNEL_ID', "IwFjwMjI0y7PDBVEO9-bkQ");
			yt.setAjaxToken('channel_ajax', "");
			
			yt.setMsg({
			'UNBLOCK_USER': "Are you sure you want to unblock this user?",
			'BLOCK_USER': "Are you sure you want to block this user?"
			});
			yt.setConfig('BLOCK_USER_AJAX_XSRF', '');
			
			
			yt.setMsg({
			'GENERIC_EDITOR_ERROR': "An error occurred. Please try again later."
			});
			yt.pubsub.subscribe('init', yt.www.channels3.channel.init);
			
		</script>
		<script>
			var subscribed = <?php echo($_user['subscribed'] ? 'true' : 'false') ?>;
			var loggedIn = <?php echo(isset($_SESSION['siteusername']) ? 'true' : 'false') ?>;
			var alerts = 0;
 
			function subscribe() {
				if(loggedIn == true) { 
					if(subscribed == false) { 
						$.ajax({
							url: "/get/subscribe?n=<?php echo htmlspecialchars($_user['username']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").addClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully added <?php echo htmlspecialchars($_user['username']); ?> to your subscriptions!");
								showAlert("#editsuccess_" + alerts);
								console.log("DEBUG: " + res);
								subscribed = true;
							}
						});
					} else {
						$.ajax({
							url: "/get/unsubscribe?n=<?php echo htmlspecialchars($_user['username']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").removeClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully removed <?php echo htmlspecialchars($_user['username']); ?> from your subscriptions!");
								showAlert("#editsuccess_" + alerts);
								console.log("DEBUG: " + res);
								subscribed = false;
							}
						});
					}
				} else {
					alerts++;
					addAlert("editsuccess_" + alerts, "You need to log in to add subscriptions!");
					showAlert("#editsuccess_" + alerts);
				}
			}
		</script>
		<script>
			yt.setAjaxToken('subscription_ajax', "");
			  yt.pubsub.subscribe('init', yt.www.subscriptions.SubscriptionButton.init);
		</script>
		<script src="//s.ytimg.com/yt/jsbin/www-watch-livestreaming-vfliBd-IQ.js" data-loaded="true"></script>
		<script>
			yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e\u003cdiv class=\"yt-alert-icon\"\u003e\u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
			yt.setConfig({
			'PLAYER_CONFIG': {"assets": {"html": "\/html5_player_template", "css": "http:\/\/s.ytimg.com\/yt\/cssbin\/www-player-vfllhw7HB.css", "js": "http:\/\/s.ytimg.com\/yt\/jsbin\/html5player-vflzTrRqK.js"}, "url": "http:\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vflbPspVE.swf", "min_version": "8.0.0", "args": {"ttsurl": "http:\/\/www.youtube.com\/api\/timedtext?sparams=asr_langs%2Ccaps%2Cv%2Cexpire\u0026asr_langs=en%2Cko%2Cja%2Ces\u0026v=/watch?v=<?php echo $video['rid']; ?>\u0026caps=asr\u0026expire=1339746882\u0026key=yttt1\u0026signature=A1B858FF427B45672676C7403417ED1F4091A806.C347A6021C0F843E46F2056AEBA38FC93A0A47B8\u0026hl=en_US", "el": "profilepage", "fexp": "904001,907342,904824,910206,908620,907217,907335,921602,919306,922600,919316,920704,912804,913542,919324,912706", "url_encoded_fmt_stream_map": "url=http%3A%2F%2Fo-o.preferred.nuq04s10.v1.lscache4.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dcp%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26ms%3Dau%26itag%3D44%26ip%3D207.0.0.0%26signature%3D9B9B5ECF02F2F66BDCCB0ACED26D3406F9F83241.1B2CC833461E3D2C4D081B7DFBC65B0948C61FB9%26sver%3D3%26mt%3D1339721111%26ratebypass%3Dyes%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=large\u0026fallback_host=tc.v1.cache4.c.youtube.com\u0026type=video%2Fwebm%3B+codecs%3D%22vp8.0%2C+vorbis%22\u0026itag=44,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v14.lscache1.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D35%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3DB702D7CA72653169BDC2C945B5A35F4A23A3FEBF.ACC660CDAB11901FF8D3DA8D384D61F0AB0F0125%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=large\u0026fallback_host=tc.v14.cache1.c.youtube.com\u0026type=video%2Fx-flv\u0026itag=35,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v24.lscache3.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dcp%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26ms%3Dau%26itag%3D43%26ip%3D207.0.0.0%26signature%3D9FABDD8C013AA137B87DF2D154D1B90E6827A2A3.880FECDEC066236D85FCF223CF472B62B8F9B3A4%26sver%3D3%26mt%3D1339721111%26ratebypass%3Dyes%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=medium\u0026fallback_host=tc.v24.cache3.c.youtube.com\u0026type=video%2Fwebm%3B+codecs%3D%22vp8.0%2C+vorbis%22\u0026itag=43,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v3.lscache7.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D34%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3D1BA326B784DAA9F62FD789CBB5C2FABFCD5D351C.C4618E3AB2AB08C61C6A982A36F405DA886B5D5A%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=medium\u0026fallback_host=tc.v3.cache7.c.youtube.com\u0026type=video%2Fx-flv\u0026itag=34,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v14.lscache1.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dcp%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26ms%3Dau%26itag%3D18%26ip%3D207.0.0.0%26signature%3D8806EA8FAE16557A2F9732068442133EA0A0760F.D91694A47E6B0BF627965CDA46010F36105A28FE%26sver%3D3%26mt%3D1339721111%26ratebypass%3Dyes%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=medium\u0026fallback_host=tc.v14.cache1.c.youtube.com\u0026type=video%2Fmp4%3B+codecs%3D%22avc1.42001E%2C+mp4a.40.2%22\u0026itag=18,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v4.lscache1.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D5%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3D011CB6739AB60ED79D032DE2F62EB016D8A8E462.C2C0ABE42F26DBA18F2BC6E0D074EB99A95C0DF0%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=small\u0026fallback_host=tc.v4.cache1.c.youtube.com\u0026type=video%2Fx-flv\u0026itag=5,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v12.lscache3.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D36%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3D988FDD37CBA8DB74C1148EE17921D8549434297C.A2C1796F2BA0427C9FE370BFB6B3B09BA1D81B07%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=small\u0026fallback_host=tc.v12.cache3.c.youtube.com\u0026type=video%2F3gpp\u0026itag=36", "allow_embed": 1, "vq": "auto", "account_playback_token": "", "allow_ratings": 1, "keywords": "Rehearsal,Dance,justin,bieber,believe,as,long,you,love,me,rodney,jerkins,pattie,mallette,jeremy,dad,mom,scooter,braun,island,def,jam,usher,rbmg,making,of,the,album,webisode,june,19th,19,new,amazing,song,big,sean,hit,record,<?php echo htmlspecialchars($_user['username']); ?>,always,still,studio,singing,kuk,harrell,producer,sing,boy,guy,man,smash,single,nick,demoura,dancers,sweat,beliebers,hard,work,tour,band", "cc3_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/subtitles3_module-vflu_Qeod.swf", "track_embed": 0, "is_purchased": false, "ps": "default", "fmt_list": "44\/854x480\/99\/0\/0,35\/854x480\/9\/0\/115,43\/640x360\/99\/0\/0,34\/640x360\/9\/0\/115,18\/640x360\/9\/0\/115,5\/320x240\/7\/0\/0,36\/320x240\/99\/0\/0", "author": "<?php echo htmlspecialchars($_user['username']); ?>", "muted": "0", "cc_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/subtitle_module-vflq8KnSi.swf", "length_seconds": 82, "feature": "g-logo-xit", "enablejsapi": 1, "rel": 0, "plid": "AATCeEL9eg3Ls9t-", "cc_font": "Arial Unicode MS, arial, verdana, _sans", "ftoken": "", "sdetail": "f:g-logo-xit,p:\/", "status": "ok", "cc_asr": 1, "watermark": ",http:\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_watermark-vflHX6b6E.png,http:\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_hd_watermark-vflAzLcD6.png", "sourceid": "y", "timestamp": 1339721682, "has_cc": true, "view_count": 2600, "quality_cap": "highres", "hl": "en_US", "tmi": "1", "no_get_video_log": "1", "eurl": "http:\/\/www.youtube.com\/user\/<?php echo htmlspecialchars($_user['username']); ?>", "iurl": "http:\/\/i3.ytimg.com\/vi\//watch?v=<?php echo $video['rid']; ?>\/hqdefault.jpg", "endscreen_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/endscreen-vflJBKwqC.swf", "referrer": "http:\/\/www.youtube.com\/", "avg_rating": 4.97805486284, "video_id": "/watch?v=<?php echo $video['rid']; ?>", "sendtmp": "1", "sk": "bwv_lGOGF4u1g0p7puy7ERICN8NZ5cVFC", "is_video_preview": false, "token": "vjVQa1PpcFMSYb-unvOiIgSL8pW9tObJUMfrEc1mxfE=", "thumbnail_url": "http:\/\/i3.ytimg.com\/vi\//watch?v=<?php echo $video['rid']; ?>\/default.jpg", "iurlsd": "http:\/\/i3.ytimg.com\/vi\//watch?v=<?php echo $video['rid']; ?>\/sddefault.jpg", "autoplay": "1"}, "url_v9as2": "http:\/\/s.ytimg.com\/yt\/swfbin\/cps-vflhvG6F4.swf", "params": {"allowscriptaccess": "always", "allowfullscreen": "true", "bgcolor": "#000000"}, "attrs": {"width": "640", "id": "movie_player", "height": "390"}, "url_v8": "http:\/\/s.ytimg.com\/yt\/swfbin\/cps-vflhvG6F4.swf", "html5": false}
			});
			
		</script>
		<script>
			yt.pubsub.subscribe('init', function() {
			  yt.setAjaxToken('watch_actions_ajax', "");
			});
			yt.setMsg({
			    'CHANNELS3_FEATURED_PLAYER_GENERIC_ERROR': "This feature is not available right now. Please try again later."
			})
			  yt.pubsub.subscribe('init', function () {
			    yt.www.livestreaming.ConcurrentViewers(30000)
			  });
		</script>
		<script>
			yt.pubsub.subscribe('init', yt.www.channels3.channel.initBloggerLayout);
		</script>
		<script>
			var channel_customization_toggled = false;

			function open_channel_customization() {
				console.log("fuck");
				if(channel_customization_toggled == false) {
					console.log("fuck1");
					$("#masthead-customization").fadeIn(300);
					channel_customization_toggled = true;
				} else {
					console.log("fuck2");
					$("#masthead-customization").fadeOut(300);
					channel_customization_toggled = false;	
				}
			}
		</script>
		<div id="ad_creative_1" class="ad-div " style="z-index: 1">
			<iframe id="ad_creative_iframe_1" scrolling="no" style="z-index: 1" src="//ad-g.doubleclick.net/adi/com.ytbc/<?php echo htmlspecialchars($_user['username']); ?>;sz=1x1;kpu=<?php echo htmlspecialchars($_user['username']); ?>;tile=1;plat=pc;dc_dedup=1;kcr=us;kga=-1;kgg=-1;klg=en;kmyd=ad_creative_1;kt=K;ord=211420892612853?" pu2kj6459="" width="1" height="1" frameborder="0"></iframe>
			<div style="font-size: 10px; padding-top: 3px;" class="alignC grayText">
				<a href="/t/ads_preferences">
				Advertisement
				</a>
			</div>
			<script>
				(function() {
				  var addTimestamp = (Math.floor(Math.random() * 1000) == 0);
				  if (addTimestamp) {
				    var kts = new Date().getTime();
				    var iframeSrc = "//ad-g.doubleclick.net/adi/com.ytbc/<?php echo htmlspecialchars($_user['username']); ?>;sz=1x1;kpu=<?php echo htmlspecialchars($_user['username']); ?>;tile=1;plat=pc;dc_dedup=1;kcr=us;kga=-1;kgg=-1;klg=en;kmyd=ad_creative_1;kt=K;kts=" + kts + ";ord=211420892612853?";
				  } else {
				    var iframeSrc = "//ad-g.doubleclick.net/adi/com.ytbc/<?php echo htmlspecialchars($_user['username']); ?>;sz=1x1;kpu=<?php echo htmlspecialchars($_user['username']); ?>;tile=1;plat=pc;dc_dedup=1;kcr=us;kga=-1;kgg=-1;klg=en;kmyd=ad_creative_1;kt=K;ord=211420892612853?";
				  }
				  var adIframe = document.getElementById("ad_creative_iframe_1");
				  adIframe.src = iframeSrc;
				})();
			</script>
		</div>
		<script src="//www.googletagservices.com/tag/js/gpt.js"></script>
		<script>
			(function() {
			  if (!window.googletag) {
			    return;
			  }
			  var gutSlot = googletag.defineSlot("/4061/com.youtube/default", [[300, 250], [300, 60]], 'yt-gut-content');
			  gutSlot.set('ad_type', 'flash');
			  gutSlot.addService(googletag.companionAds());
			  googletag.enableServices();
			
			  yt.setConfig('gut_slot', gutSlot);
			  yt.setConfig('yt_gut_invideo_size', gutSlot.getSizes()[0]);
			  yt.setConfig('yt_gut_instream_size', gutSlot.getSizes()[1]);
			})();
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_page");}    
		</script>
		<script>
			yt.setConfig('TIMING_ACTION', "channels3");    
		</script>
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
			  'DRAGDROP_BINARY_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-dragdrop-vflM9ls_8.js",
			  'PLAYLIST_BAR_PLAYING_INDEX': -1,
			  'LIST_COPY_ON_EDIT_ENABLED': false  });
			
			  yt.setAjaxToken('addto_ajax_logged_out', "FFGgxx_wEgpAnRrnvI2vI_uxiJd8MEAxMzM5NzIxNjgy");
			
			  yt.pubsub.subscribe('init', yt.www.lists.init);
			
			
			
			
			
			
			
			
			    yt.pubsub.subscribe('init', function() {
			      yt.net.scriptloader.load("\/\/s.ytimg.com\/yt\/jsbin\/www-searchbox-vflVGQHuy.js", function() {
			        
			    if (_gel('masthead-search')) {
			      yt.setTimeout(function() {
			        searchbox.yt.install(_gel('masthead-search'),
			            _gel('masthead-search')["search_query"],
			            "en",
			            "us",
			            false,
			            '',
			            '',
			            null,
			            null,
			            "Suggestion dismissed",
			            "Dismiss",
			            -1,
			            {});
			      }, 100);
			    }
			
			      });
			    });
			
			
			
		</script>
		<script>
			yt.setMsg({
			  'ADDTO_WATCH_LATER_ADDED': "Added",
			  'ADDTO_WATCH_LATER_ERROR': "Error"
			});
			
			yt.pubsub.subscribe('init', yt.www.lists.addtowatchlater.init);
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_foot");}    
		</script>
	</body>
</html>