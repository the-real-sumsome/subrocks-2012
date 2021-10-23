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
	<script>
         var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "907722,906062,910102,927104,922401,920704,912806,927201,913546,913556,925109,919003,920201,912706,900816");yt.timing.wff = true;yt.timing.info('an', "");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
      </script>
      <script>var yt = yt || {};yt.preload = {};yt.preload.counter_ = 0;yt.preload.start = function(src) {var img = new Image();var counter = ++yt.preload.counter_;yt.preload[counter] = img;img.onload = img.onerror = function () {delete yt.preload[counter];};img.src = src;img = null;};yt.preload.start("\/\/o-o---preferred---sn-o097zne7---v18---lscache1.c.youtube.com\/crossdomain.xml");yt.preload.start("\/\/o-o---preferred---sn-o097zne7---v18---lscache1.c.youtube.com\/generate_204?ip=207.241.237.166\u0026upn=sWh0pzcodo0\u0026sparams=algorithm%2Cburst%2Ccp%2Cfactor%2Cgcr%2Cid%2Cip%2Cipbits%2Citag%2Csource%2Cupn%2Cexpire\u0026fexp=907722%2C906062%2C910102%2C927104%2C922401%2C920704%2C912806%2C927201%2C913546%2C913556%2C925109%2C919003%2C920201%2C912706%2C900816\u0026mt=1349916311\u0026key=yt1\u0026algorithm=throttle-factor\u0026burst=40\u0026ipbits=8\u0026itag=34\u0026sver=3\u0026signature=C397DCB00566E0FBB1551675B6108A4158C34557.CB3777882F05D65158C043C258FF8D4EBA90FA50\u0026mv=m\u0026source=youtube\u0026ms=au\u0026gcr=us\u0026expire=1349937946\u0026factor=1.25\u0026cp=U0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX\u0026id=a078394896111c0d");</script>
        <title><?php echo $__server->page_embeds->page_title; ?></title>
		<meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
		<script>
			var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="/yt/jsbin/plupload.full.min.js"></script>
		<link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
		<script src="/s/js/alert.js"></script>
		<link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
        <link rel="stylesheet" href="/yt/cssbin/www-channels3-vfl-wJB5W.css">
        <link rel="stylesheet" href="/yt/cssbin/www-the-rest-vflNb6rAI.css">
		<link rel="stylesheet" href="/yt/cssbin/www-extra.css">
		<style>
			#content-container {
				background-color: <?php echo $_user['primary_color'];  ?>;
				background-image: url(/dynamic/banners/<?php echo $_user['2009_bg']; ?>);
				background-repeat: repeat;
				background-position: center top;
			}
   		</style>
		   <script>
         var gYouTubePlayerReady = false;
         if (!window['onYouTubePlayerReady']) {
           window['onYouTubePlayerReady'] = function() {
             gYouTubePlayerReady = true;
           };
         }
      </script>
      <script>
         if (window.yt.timing) {yt.timing.tick("ct");}    
      </script>
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
											</div>
											<div class="upper-right-section">
												<div class="header-stats">
													<div class="stat-entry">
														<span class="stat-value"><?php echo $_user['subscribers']; ?></span>
														<span class="stat-name"><?php if($_user['subscribers'] == 1){ ?>subscriber<?php }else{ ?>subscribers<?php } ?></span>
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
												<li class="selected">
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/featured" class="gh-tab-100">
													Featured
													</a>
												</li>
												<li>
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/feed" class="gh-tab-102">
													Feed
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
								<div class="channel-tab-content channel-layout-two-column selected blogger-template">
									<div class="tab-content-body">
										<div class="primary-pane">
                                            <?php if($_user['featured'] != false && $__video_h->video_exists($_user['featured'])) { ?>
											<div class="channels-featured-video channel-module yt-uix-c3-module-container has-visible-edge">
												<div class="module-view featured-video-view-module">
												<div id="watch-video" >
          <script>
if (window.yt.timing) {yt.timing.tick("bf");}    </script>

          <div id="watch-player" class="flash-player"></div>
    <script>
      (function() {
        var swf = "      \u003cembed type=\"application\/x-shockwave-flash\"     s\u0072c=\"\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vfloWhEvq.swf\"     id=\"movie_player\"    flashvars=\"fexp=907722%2C906062%2C910102%2C927104%2C922401%2C920704%2C912806%2C927201%2C913546%2C913556%2C925109%2C919003%2C920201%2C912706%2C900816\u0026amp;ptk=youtube_multi\u0026amp;enablecsi=1\u0026amp;allow_embed=1\u0026amp;rvs=view_count%3D24%252C209%252C324%26feature_type%3Dfvwp%26author%3DProtoOfSnagem%26title%3DHEYYEYAAEYAAAEYAEYAA%26length_seconds%3D127%26featured%3D1%26id%3DZZ5LpwO-An4%2Cview_count%3D13%252C121%252C773%26author%3Ddersiraresmc%26length_seconds%3D365%26id%3Dkv4RIhMpV40%26title%3DCritical%2BHits%2BVol.2%2Cview_count%3D9%252C033%252C824%26author%3Dayazkhatrier%26length_seconds%3D204%26id%3Dr6VCnYkNYLo%26title%3D100%2BGreatest%2BInternet%2BVideos%2BIn%2B3%2BMinutes%2Cview_count%3D642%252C634%26author%3DFa1lsp3cxD%26length_seconds%3D48%26id%3D8e47ianJYGg%26title%3DFamily%2BGuy-%2BStewie%2Bgets%2Brick%2Broll%2527d%2Cview_count%3D861%252C498%26author%3DThePrimeCronus%26length_seconds%3D3749%26id%3DS3P2iaWma-Y%26title%3D1-Hour%2BEpic%2BMusic%2B%257C%2BTwo%2BSteps%2BFrom%2BHell%2BVol.%2B2%2Cview_count%3D2%252C285%252C240%26author%3Dlilsportsplaya69%26length_seconds%3D197%26id%3DWYLvdLWkhk8%26title%3DChuck%2BNorris%2Bhears%2Bhis%2Bown%2Bfacts...%2Cview_count%3D2%252C010%252C479%26author%3Dbeeerent%26length_seconds%3D230%26id%3DLjur6v7-yoc%26title%3DHitler%2Bfinds%2Bout%2BPokemon%2Baren%2527t%2Breal%2Cview_count%3D79%252C447%252C461%26author%3Dakhilkhatri0608%26length_seconds%3D350%26id%3DVSrAJsWvEIc%26title%3DOne%2Bof%2Bthe%2Bbest%2Binspirational%2Bvideos%2Bever%2B-%2BSusan%2BBoyle%2B-%2BBritains%2BGot%2BTalent%2B2009%2Cview_count%3D299%252C142%26author%3Druigejoostnl%26length_seconds%3D52%26id%3DnAElQjPx7LQ%26title%3DBest%2Bninja%2Bdefuse%2Bever%2521%2521%2521%2BSND%2BMW3%2Cview_count%3D10%252C582%252C034%26author%3DTheSonicParadoxTeam%26length_seconds%3D471%26id%3DTCvMARhbBu8%26title%3DSonic%2BShorts%2B-%2BVolume%2B4%2Cview_count%3D10%252C345%252C179%26author%3DZeljko9NS5Serbia%26length_seconds%3D373%26id%3D1jre6_FBBc0%26title%3DKid%2BCudi%2B-%2BPursuit%2Bof%2BHappiness%2B%2528Steve%2BAoki%2BRemix%2529%2B-%2BProject%2BX%2B%2528Party%2BTrailer%2BScene%2529%2BHD%2Cview_count%3D1%252C593%252C982%26author%3DLipigl%26length_seconds%3D42%26id%3DoB6bk5S2_Zc%26title%3DThey%2Bsee%2Bme%2Btrollin%2527%2BThey%2Bhatin%2527\u0026amp;vq=auto\u0026amp;account_playback_token=\u0026amp;autohide=2\u0026amp;csi_page_type=watch5\u0026amp;keywords=Cotter548%2CShawn%2CCotter%2Clol%2Cgamefaqs%2CCE%2Creddit%2Crettocs%2Cno%2Cbrb%2Cafk%2Clawl%2Cpwnt%2CRickroll%2CRickroll%27d%2CRick%2CRoll%2CDuckroll%2CDuck%2Crick%2Croll%2Castley%2Cnever%2Cgonna%2Cgive%2Cyou%2Cup%2Clet%2Cdown%2Crun%2Caround%2Cand%2Churt\u0026amp;cr=US\u0026amp;iv3_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv3_module-vflGCS_pr.swf\u0026amp;fmt_list=43%2F320x240%2F99%2F0%2F0%2C34%2F320x240%2F9%2F0%2F115%2C18%2F320x240%2F9%2F0%2F115%2C5%2F320x240%2F7%2F0%2F0%2C36%2F320x240%2F99%2F0%2F0%2C17%2F176x144%2F99%2F0%2F0\u0026amp;title=RickRoll%27D\u0026amp;length_seconds=212\u0026amp;enablejsapi=1\u0026amp;advideo=1\u0026amp;tk=o3_r7m6s_HAaFxeywi14S3qFcY4uSrEiWfZ8KVUoyEB_gj1rlrELuQ%3D%3D\u0026amp;iv_load_policy=1\u0026amp;iv_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv_module-vflBJ5PLc.swf\u0026amp;sdetail=p%3Abit.ly%2FdwMq4b\u0026amp;url_encoded_fmt_stream_map=itag%3D43%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7knek---v3---lscache4.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349937946%2526itag%253D43%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349916311%2526ip%253D207.241.237.166%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526id%253Da078394896111c0d%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v3.cache4.c.youtube.com%26sig%3DD879CD07A768B7D80A9C7D4E5DD16EDAC9DB4963.CDD2371FC76E7E959C559940842DC999573623D1%26quality%3Dmedium%2Citag%3D34%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-o097zne7---v18---lscache1.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D34%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v18.cache1.c.youtube.com%26sig%3DC397DCB00566E0FBB1551675B6108A4158C34557.CB3777882F05D65158C043C258FF8D4EBA90FA50%26quality%3Dmedium%2Citag%3D18%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7kned---v5---lscache6.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349937946%2526itag%253D18%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349916311%2526ip%253D207.241.237.166%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526id%253Da078394896111c0d%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v5.cache6.c.youtube.com%26sig%3D2A6196BFA95A0E8887CECC345A153937D8599592.5160A930EF6FDFF466FA41BAB7E76AD5CFE766B0%26quality%3Dmedium%2Citag%3D5%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7knek---v19---lscache4.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D5%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v19.cache4.c.youtube.com%26sig%3DA43F1CE03CC729FD57D1211C61F21AAB7C5AF20D.854D2A74C6CBA3160762D9FA75903D35A67382ED%26quality%3Dsmall%2Citag%3D36%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7kner---v4---lscache8.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D36%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v4.cache8.c.youtube.com%26sig%3D719E70BF679A7B41474D05D3706358168E217890.90B1765E62D594BEDEE837BB3F26FA82C0AC2C93%26quality%3Dsmall%2Citag%3D17%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-o097znee---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D17%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v9.cache5.c.youtube.com%26sig%3D8F24ED9FCC2500D100D1AAC9CD5A614B0C0FA5AA.6155DD5967D990C9F24D4862F7D70BCAF0914DA0%26quality%3Dsmall\u0026amp;watermark=%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_watermark-vflHX6b6E.png%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_hd_watermark-vflAzLcD6.png\u0026amp;sourceid=r\u0026amp;timestamp=1349916364\u0026amp;storyboard_spec=http%3A%2F%2Fi4.ytimg.com%2Fsb%2FoHg5SJYRHA0%2Fstoryboard3_L%24L%2F%24N.jpg%7C48%2327%23100%2310%2310%230%23default%23kFKafDpxazQDzs-N0NAkdH-jy_E%7C60%2345%23108%2310%2310%232000%23M%24M%233QCcFMpSH_MACnGTmY_ha2J8UU0%7C120%2390%23108%235%235%232000%23M%24M%23YJotj-gSka-wkwz-SF4GUW_h1Kk\u0026amp;plid=AATLveVba5g8mPZ8\u0026amp;showpopout=1\u0026amp;hl=en_US\u0026amp;tmi=1\u0026amp;iv_logging_level=4\u0026amp;st_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fst_module-vflCXoloO.swf\u0026amp;no_get_video_log=1\u0026amp;iv_close_button=0\u0026amp;endscreen_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fendscreen-vflK6XzTZ.swf\u0026amp;iv_read_url=http%3A%2F%2Fwww.youtube.com%2Fannotations_iv%2Fread2%3Fsparams%3Dexpire%252Cvideo_id%26expire%3D1349959800%26key%3Da1%26signature%3D815C68436F1E8F95A9283A421D758B7A6452EFD9.5029A9CC9CFCF79F0B17A60238447CA0FE7CA991%26video_id%3DoHg5SJYRHA0%26feat%3DCS\u0026amp;iv_queue_log_level=0\u0026amp;referrer=http%3A%2F%2Fbit.ly%2FdwMq4b\u0026amp;video_id=oHg5SJYRHA0\u0026amp;sw=1.0\u0026amp;sk=4md16KjsgYmUvVHOsiBQxSFIkPbju0d8C\u0026amp;pltype=contentugc\u0026amp;t=vjVQa1PpcFN8E8yJ1Q1BJFTy1GYmGAMgRZUyNC4FMBY%3D\u0026amp;loudness=-23.6900005341\"     allowscriptaccess=\"always\" allowfullscreen=\"true\" bgcolor=\"#000000\"\u003e\n  \u003cnoembed\u003e\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e\u003c\/noembed\u003e\n\n";
        document.getElementById('watch-player').innerHTML = swf;
      })()
    </script>

      <!-- begin watch-video-extra -->
      <div id="watch-video-extra">
        
        
      </div>
      <!-- end watch-video-extra -->
    </div>
													<div style="width: 615px;" class="channels-featured-video-details yt-tile-visible clearfix">
														<h3 class="title">
															<a href="/watch?v=<?php echo $video['rid']; ?>">
															<?php echo htmlspecialchars($video['title']); ?>
															</a>
															<div class="view-count-and-actions">
																<div class="view-count">
																	<span class="count">
																	<?php echo $__video_h->fetch_video_views($video['rid']); ?>
																	</span>
																	views
																</div>
															</div>
														</h3>
														<p class="channels-featured-video-metadata">
															<span>by <?php echo htmlspecialchars($_user['username']); ?></span>
															<span class="created-date"><?php echo $__time_h->time_elapsed_string($video['publish']); ?></span>
														</p>
													</div>
												</div>
											</div>
                                            <?php } ?>
											<div class="single-playlist channel-module yt-uix-c3-module-container">
												<div class="module-view single-playlist-view-module">
													<div class="blogger-playall">
                                                        <!--
                                                            <a class="yt-playall-link yt-playall-link-default " href="/watch?v=<?php echo $video['rid']; ?>&amp;list=UUIwFjwMjI0y7PDBVEO9-bkQ&amp;feature=plcp">
                                                            <img class="small-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
                                                            Play all
                                                            </a>
                                                        -->
													</div>
													<div class="playlist-info">
														<h2>Uploaded videos</h2>
														<div class="yt-horizontal-rule "><span class="first"></span><span class="second"></span><span class="third"></span></div>
														<?php if($_user['videos'] == 0) { ?>
															<h4>This user has not uploaded a video yet.</h4>
														<?php } ?>
													</div>
													<ul class="gh-single-playlist">
                                                        <?php 
                                                            $stmt = $__db->prepare("SELECT * FROM videos WHERE author = :username ORDER BY id DESC LIMIT 20");
                                                            $stmt->bindParam(":username", $_user['username']);
                                                            $stmt->execute();
                                                            while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                                                        ?>
														<li class="blogger-video">
															<div class="video yt-tile-visible">
																<a href="/watch?v=<?php echo $video['rid']; ?>">
																<span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-288 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" width="288"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $__time_h->timestamp($video['duration']); ?></span>
																<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="/watch?v=<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <span class="addto-label">
																Watch Later
																</span>
																<span class="addto-label-error" style="display: none;">
																Error
																</span>
																<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
																</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
																</span>
																<span class="video-item-content">
																<span class="video-overview">
																<span class="title video-title" title="<?php echo htmlspecialchars($video['title']); ?>"><?php echo htmlspecialchars($video['title']); ?></span>
																</span>
																<span class="video-details">
																<span class="yt-user-name video-owner" dir="ltr"><?php echo htmlspecialchars($_user['username']); ?></span>
																<span class="video-view-count">
																<?php echo $__video_h->fetch_video_views($video['rid']); ?> views
																</span>
																<span class="video-time-published"><?php echo $__time_h->time_elapsed_string($video['publish']); ?></span>
																<span class="video-item-description"><?php echo $__video_h->shorten_description($video['description'], 100); ?></span>
																</span>
																</span>
																</a>
															</div>
														</li>
                                                        <?php } ?>
													</ul>
												</div>
											</div>
										</div>
										<div class="secondary-pane">
											<div id="watch-longform-ad" style="display:none;">
												<div id="watch-longform-text">
													Advertisement
												</div>
												<div id="watch-longform-ad-placeholder"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" width="300" height="60"></div>
												<div id="instream_google_companion_ad_div"></div>
											</div>
											<div id="watch-channel-brand-div" class="companion-ads has-visible-edge channel-module yt-uix-c3-module-container hid">
												<div id="ad300x250"></div>
												<div id="google_companion_ad_div"></div>
												<div class="ad-label-text">
													Advertisement
												</div>
											</div>
											<div class="user-profile channel-module yt-uix-c3-module-container ">
												<div class="module-view profile-view-module" data-owner-external-id="IwFjwMjI0y7PDBVEO9-bkQ">
													<h2>About <?php echo htmlspecialchars($_user['username']); ?></h2>
													<div class="section first">
														<div class="user-profile-item profile-description">
															<p><?php echo $__video_h->shorten_description($_user['bio'], 5000); ?></p>
														</div>
														<div class="user-profile-item">
														</div>
														<div class="user-profile-item">
                                                            <!--
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://smarturl.it/boyfriend?IQid=youtube" rel="me nofollow" target="_blank" title="Get &quot;Boyfriend&quot; on iTunes" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=smarturl.it&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Get "Boyfriend" on iTunes
																</span>
																</a>
															</div>
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://bieberfever.com/" rel="me nofollow" target="_blank" title="Bieber Fever" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=bieberfever.com&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Bieber Fever
																</span>
																</a>
															</div>
                                                            -->
														</div>
														<hr class="yt-horizontal-rule ">
													</div>
													<?php if(!empty($_user['website'])) { ?>
														<div class="user-profile-item">
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="<?php echo addhttp(htmlspecialchars($_user['website'])); ?>" rel="me nofollow" target="_blank" title="<?php echo htmlspecialchars($_user['website']); ?>" class="yt-uix-redirect-link">
																<img src="/yt/imgbin/custom_site.png" class="favicon" alt="">
																<span class="link-text">
																<?php echo htmlspecialchars($_user['website']); ?>
																</span>
																</a>
															</div>
														</div>
														<div class="user-profile-item">
															<!--
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://smarturl.it/boyfriend?IQid=youtube" rel="me nofollow" target="_blank" title="Get &quot;Boyfriend&quot; on iTunes" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=smarturl.it&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Get "Boyfriend" on iTunes
																</span>
																</a>
															</div>
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://bieberfever.com/" rel="me nofollow" target="_blank" title="Bieber Fever" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=bieberfever.com&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Bieber Fever
																</span>
																</a>
															</div>
															-->
														</div>
														<hr class="yt-horizontal-rule ">
														<?php } ?>
													<div class="section created-by-section">
														<div class="user-profile-item">
															by <span class="yt-user-name " dir="ltr"><?php echo htmlspecialchars($_user['username']); ?></span>
														</div>
														<div class="user-profile-item ">
															<h5>Latest Activity</h5>
															<span class="value"><?php echo date("M d, Y", strtotime($_user['lastlogin'])); ?></span>
														</div>
														<div class="user-profile-item ">
															<h5>Date Joined</h5>
															<span class="value"><?php echo date("M d, Y", strtotime($_user['created'])); ?></span>
														</div>
														<div class="user-profile-item ">
															<h5>Country</h5>
															<span class="value"><?php echo htmlspecialchars($_user['country']); ?></span>
														</div>
														<?php if($_user['genre'] != "none") { ?>
															<div class="user-profile-item ">
																<h5>Channel Genre</h5>
																<span class="value"><?php echo htmlspecialchars($_user['genre']); ?></span>
															</div>
														<?php } ?>
													</div>
													<hr class="yt-horizontal-rule ">
												</div>
											</div>
											<div class="channel-module other-channels yt-uix-c3-module-container other-channels-compact">
												<?php $_user['featured_channels'] = explode(",", $_user['featured_channels']); ?>
												<?php if(count($_user['featured_channels']) != 0) { ?>
												<div class="module-view other-channels-view">
													<h2>Featured Channels</h2>
													<ul class="channel-summary-list ">
														<?php 
															foreach($_user['featured_channels'] as $user) {
																if($__user_h->user_exists($user)) {
														?>
															<li class="yt-tile-visible yt-uix-tile">
																<div class="channel-summary clearfix channel-summary-compact">
																	<div class="channel-summary-thumb">
																		<span class="video-thumb ux-thumb yt-thumb-square-46 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($user); ?>" width="46"><span class="vertical-align"></span></span></span></span>
																	</div>
																	<div class="channel-summary-info">
																		<h3 class="channel-summary-title">
																			<a href="/user/<?php echo htmlspecialchars($user); ?>" class="yt-uix-tile-link"><?php echo htmlspecialchars($user); ?></a>
																		</h3>
																		<span class="subscriber-count">
																		<strong><?php echo $__user_h->fetch_subs_count($user); ?></strong>
																		subscribers
																		</span>
																	</div>
																</div>
															</li>
														<?php } } ?>
													</ul>
												</div>
												<?php } ?>
											</div>

											<?php 
												$stmt = $__db->prepare("SELECT * FROM playlists WHERE author = :search ORDER BY id DESC LIMIT 10");
												$stmt->bindParam(":search", $_user['username']);
												$stmt->execute();

												if($stmt->rowCount() != 0) {
											?>
												<div class="playlists-narrow channel-module yt-uix-c3-module-container">
													<div class="module-view gh-featured">
														<h2>Featured Playlists</h2>     
														<?php
														while($playlist = $stmt->fetch(PDO::FETCH_ASSOC)) { 
															$playlist['videos'] = json_decode($playlist['videos']);
														?> 
															<div class="playlist yt-tile-visible yt-uix-tile">
																<a href="/view_playlist?v=<?php echo $playlist['rid']; ?>">
																<span class="playlist-thumb-strip playlist-thumb-strip-252"><span class="videos videos-4 horizontal-cutoff"><span class="clip"><span class="centering-offset"><span class="centering">
																	<span class="ie7-vertical-align-hack">&nbsp;</span>
																	<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" data-thumb="" alt="" class="thumb"></span></span></span>
																	<span class="clip"><span class="centering-offset"><span class="centering"><span class="ie7-vertical-align-hack">&nbsp;

																	</span><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="" class="thumb"></span></span></span>
																	<span class="clip"><span class="centering-offset"><span class="centering"><span class="ie7-vertical-align-hack">&nbsp;</span>
																	<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="" class="thumb"></span></span></span><span class="clip"><span class="centering-offset"><span class="centering"><span class="ie7-vertical-align-hack">&nbsp;</span><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" data-thumb="" alt="" class="thumb"></span></span></span></span><span class="resting-overlay"><img src="//s.ytimg.com/yt/img/channels/play-icon-resting-vflXxuFB8.png" class="play-button" alt="Play all">  <span class="video-count-box">
																<?php echo count($playlist['videos']); ?> videos
																</span>
																</span><span class="hover-overlay"><span class="play-all-container"><strong><img src="//s.ytimg.com/yt/img/channels/mini-play-all-vflZu1SBs.png" alt="">Play all</strong></span></span></span>
																</a>
																<h3>
																	<a href="/view_playlist?v=<?php echo $playlist['rid']; ?>" title="See all videos in playlist." class="yt-uix-tile-link">
																		<?php echo htmlspecialchars($playlist['title']); ?>
																	</a>
																</h3>
																<span class="playlist-author-attribution">
																by <?php echo htmlspecialchars($_user['username']); ?>
																</span>
															</div>
														<?php }  ?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
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
		<script id="www-core-js" src="//s.ytimg.com/yt/jsbin/www-core-vfl-1JTp7.js" data-loaded="true"></script>
		<script>
			yt.setConfig({
			'XSRF_TOKEN': 'sWZ0733z73lb8fEYAYSd84MaNV98MTM0OTEzMDExNUAxMzQ5MDQzNzE1',
			'XSRF_FIELD_NAME': 'session_token'
			});
			yt.pubsub.subscribe('init', yt.www.xsrf.populateSessionToken);
			
			yt.setConfig('XSRF_REDIRECT_TOKEN', '08fYRr2a9pjbx2VYZhoZtyl-4lh8MTM0OTEzMDExNUAxMzQ5MDQzNzE1');
			
			yt.setConfig({
			'EVENT_ID': "CJuY27ur3rICFaL4OgodEHRznw==",
			'CURRENT_URL': "\/\/www.youtube.com\/watch?v=<?php echo htmlspecialchars($_video['rid']); ?>\u0026feature=g-logo-xit",
			'LOGGED_IN': false,
			'SESSION_INDEX': null,
			
			'WATCH_CONTEXT_CLIENTSIDE': false,
			
			'FEEDBACK_LOCALE_LANGUAGE': "en",
			'FEEDBACK_LOCALE_EXTRAS': {"logged_in": false, "experiments": "906717,901803,907354,904448,901424,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,912706,900816", "guide_subs": "NA", "accept_language": null}    });
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_head");}    
		</script>
		<script>
			yt.setAjaxToken('subscription_ajax', "");
			yt.pubsub.subscribe('init', yt.www.subscriptions.SubscriptionButton.init);
			
		</script>
		<script>
			yt.setConfig({
			  'VIDEO_ID': "<?php echo htmlspecialchars($_video['rid']); ?>"    });
			yt.setAjaxToken('watch_actions_ajax', "");
			
			if (window['gYouTubePlayerReady']) {
			  yt.registerGlobal('gYouTubePlayerReady');
			}
		</script>
		<script>
    yt = yt || {};
      yt.playerConfig = {"assets": {"css_actions": "\/\/s.ytimg.com\/yt\/cssbin\/www-player-actions-vflWsl9n_.css", "html": "\/html5_player_template", "css": "\/\/s.ytimg.com\/yt\/cssbin\/www-player-vflE5bu0u.css", "js": "\/\/s.ytimg.com\/yt\/jsbin\/html5player-vfl1S0-AB.js"}, "url": "\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vfloWhEvq.swf", "min_version": "8.0.0", "args": {"fexp": "907722,906062,910102,927104,922401,920704,912806,927201,913546,913556,925109,919003,920201,912706,900816", "ptk": "youtube_multi", "enablecsi": "1", "allow_embed": 1, "rvs": "", "vq": "auto", "account_playback_token": "", "autohide": "2", "csi_page_type": "watch5", "keywords": "<?php echo htmlspecialchars($_video['tags']); ?>", "cr": "US", "iv3_module": "\/\/s.ytimg.com\/yt\/swfbin\/iv3_module-vflGCS_pr.swf", "fmt_list": "43\/320x240\/99\/0\/0,34\/320x240\/9\/0\/115,18\/320x240\/9\/0\/115,5\/320x240\/7\/0\/0,36\/320x240\/99\/0\/0,17\/176x144\/99\/0\/0", "title": "<?php echo htmlspecialchars($_video['title']); ?>", "length_seconds": <?php echo $_video['duration']; ?>, "enablejsapi": 1, "advideo": "1", "tk": "o3_r7m6s_HAaFxeywi14S3qFcY4uSrEiWfZ8KVUoyEB_gj1rlrELuQ==", "iv_load_policy": 1, "iv_module": "\/\/s.ytimg.com\/yt\/swfbin\/iv_module-vflBJ5PLc.swf", "sdetail": "p:bit.ly\/dwMq4b", "url_encoded_fmt_stream_map": "", "watermark": ",\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_watermark-vflHX6b6E.png,\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_hd_watermark-vflAzLcD6.png", "sourceid": "r", "timestamp": 1349916364, "storyboard_spec": "", "plid": "AATLveVba5g8mPZ8", "showpopout": 1, "hl": "en_US", "tmi": "1", "iv_logging_level": 4, "st_module": "\/\/s.ytimg.com\/yt\/swfbin\/st_module-vflCXoloO.swf", "no_get_video_log": "1", "iv_close_button": 0, "endscreen_module": "\/\/s.ytimg.com\/yt\/swfbin\/endscreen-vflK6XzTZ.swf", "iv_read_url": "\/\/www.youtube.com\/annotations_iv\/read2?sparams=expire%2Cvideo_id\u0026expire=1349959800\u0026key=a1\u0026signature=815C68436F1E8F95A9283A421D758B7A6452EFD9.5029A9CC9CFCF79F0B17A60238447CA0FE7CA991\u0026video_id=oHg5SJYRHA0\u0026feat=CS", "iv_queue_log_level": 0, "referrer": "\/\/bit.ly\/dwMq4b", "video_id": "<?php echo htmlspecialchars($_video['rid']); ?>", "sw": "1.0", "sk": "4md16KjsgYmUvVHOsiBQxSFIkPbju0d8C", "pltype": "contentugc", "t": "vjVQa1PpcFN8E8yJ1Q1BJFTy1GYmGAMgRZUyNC4FMBY=", "loudness": -23.6900005341}, "url_v9as2": "\/\/s.ytimg.com\/yt\/swfbin\/cps-vfl2Ur0rq.swf", "params": {"allowscriptaccess": "always", "allowfullscreen": "true", "bgcolor": "#000000"}, "attrs": {"id": "movie_player"}, "url_v8": "\/\/s.ytimg.com\/yt\/swfbin\/cps-vfl2Ur0rq.swf", "html5": true};
      yt.setConfig({
    'EMBED_HTML_TEMPLATE': "\u003ciframe width=\"__width__\" height=\"__height__\" src=\"__url__\" frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e",
    'EMBED_HTML_URL': "\/\/www.youtube.com\/embed\/__videoid__"
  });
    yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
  yt.setMsg('PLAYER_FALLBACK', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            The Adobe Flash Player or an HTML5 supported browser is required for video playback. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eGet the latest Flash Player\u003c\/a\u003e \u003cbr\u003e \u003ca href=\"\/html5\"\u003eLearn more about upgrading to an HTML5 browser\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
  yt.setMsg('QUICKTIME_FALLBACK', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            The Adobe Flash Player or QuickTime is required for video playback. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eGet the latest Flash Player\u003c\/a\u003e \u003cbr\u003e \u003ca href=\"\/\/www.apple.com\/quicktime\/download\/\"\u003eGet the latest version of QuickTime\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");


    (function() {
      var forceUpdate = yt.www.watch.player.updateConfig(yt.playerConfig);
      var youTubePlayer = yt.player.update('watch-player', yt.playerConfig,
          forceUpdate, gYouTubePlayerReady);
      yt.setConfig({'PLAYER_REFERENCE': youTubePlayer});
    })();
  </script>
		<script>
			yt.setConfig({
			  'SUBSCRIBE_AXC': "",
			
			  'IS_OWNER_VIEWING': null,
			  'IS_WIDESCREEN': false,
			  'PREFER_LOW_QUALITY': false,
			  'WIDE_PLAYER_STYLES': ["watch-wide-mode"],
			  'COMMENT_SHARE_URL': "\/\/www.youtube.com\/comment?lc=_COMMENT_ID_",
			  'ALLOW_EMBED': true,
			  'ALLOW_RATINGS': true,
			
			  'LIST_AUTO_PLAY_ON': false,
			  'LIST_AUTO_PLAY_VALUE': 1,
			  'SHUFFLE_VALUE': 0,
			  'SHUFFLE_ENABLED': false,
			  'YPC_CAN_RATE_VIDEO': true,
			  'YPC_SHOW_VPPA_CONFIRM_RATING': false,
			
			
			
			
			
			
			
			
			  'PLAYBACK_ID': "AATK8rd3IxlBnwIO",
			  'PLAY_ALL_MAX': 480    });
			
			yt.setMsg({
			  'LOADING': "Loading...",
			  'WATCH_ERROR_MESSAGE': "This feature is not available right now. Please try again later."    });
			
			
			
			  yt.setMsg({
			'UNBLOCK_USER': "Are you sure you want to unblock this user?",
			'BLOCK_USER': "Are you sure you want to block this user?"
			});
			yt.setConfig('BLOCK_USER_AJAX_XSRF', '');
			
			
			  yt.setConfig({
			'COMMENT_SHARE_URL': "\/\/www.youtube.com\/comment?lc=_COMMENT_ID_",
			'COMMENTS_SIGNIN_URL': "",
			'COMMENTS_THRESHHOLD': -5,
			'COMMENTS_PAGE_SIZE': 10,
			'COMMENTS_COUNT': 41353,
			'COMMENTS_YPC_CAN_POST_OR_REACT_TO_COMMENT': true,
			'COMMENT_VOTE_XSRF' : '',
			'COMMENT_ACTIONS_XSRF' : '',
			'COMMENT_SOURCE': "w",
			'ENABLE_LIVE_COMMENTS': true  });
			
			yt.setAjaxToken('link_ajax', "");
			yt.setAjaxToken('comment_servlet', "");
			yt.setAjaxToken('comment_voting', "");
			
			yt.setMsg({
			'COMMENT_OK': "OK",
			'COMMENT_BLOCKED': "You have been blocked by the owner of this video.",
			'COMMENT_CAPTCHAFAIL': "The response to the letters on the image was not correct, please try again.",
			'COMMENT_PENDING': "Comment Pending Approval!",
			'COMMENT_ERROR_EMAIL': "Error, account unverified (see email)",
			'COMMENT_ERROR': "Error, try again",
			'COMMENT_OWNER_LINKING': "Comments can't contain links, please put the link in your video description and refer to it in the comment."
			});
			
			yt.pubsub.subscribe('init', yt.www.comments.init);
			
			  yt.setConfig({
			'ENABLE_LIVE_COMMENTS': true,
			'COMMENTS_VIDEO_ID': "<?php echo htmlspecialchars($_video['rid']); ?>",
			'COMMENTS_LATEST_TIMESTAMP': 1349043702,
			'COMMENTS_POLLING_INTERVAL': 15000,
			'COMMENTS_FORCE_SCROLLING': false,
			'COMMENTS_PAGE_SIZE': 10  });
			
			yt.setMsg({
			'LC_COUNT_NEW_COMMENTS': "\u003ca href=\"#\" onclick=\"yt.www.watch.livecomments.showNewComments(); return false;\"\u003eShow $count new comments.\u003c\/a\u003e"
			});
			
			yt.pubsub.subscribe('init', function() {
			  yt.net.scriptloader.load("\/\/s.ytimg.com\/yt\/jsbin\/www-livecomments-vflCp_BeU.js", function() {
			    yt.www.watch.livecomments.init();
			  });
			});
			
			
			
			  yt.setConfig('ENABLE_AUTO_LARGE', true);
			  yt.www.watch.watch5.updatePlayerSize();
			  yt.pubsub.subscribe('init', function() {
			    yt.events.listen(window, 'resize',
			        yt.www.watch.watch5.handleResize);
			  });
			
			yt.pubsub.subscribe('init', yt.www.watch.activity.init);
			yt.pubsub.subscribe('init', yt.www.watch.player.init);
			yt.pubsub.subscribe('init', yt.www.watch.actions.init);
			yt.pubsub.subscribe('init', yt.www.watch.shortcuts.init);
			
			
			yt.pubsub.subscribe('init', function() {
			  var description = _gel('watch-description');
			  if (!_hasclass(description, 'yt-uix-expander-collapsed')) {
			    yt.www.watch.watch5.handleToggleDescription(description);
			  }
			});
			
			
			
			
			
			
			
			
			
			
		</script>
		<script>
			yt.setConfig('PYV_REQUEST', true);
			yt.setConfig('PYV_AFS', false);
		</script>
		<script>
			yt.www.ads.pyv.loadPyvIframe("\n  \u003cscript\u003e\n    var google_max_num_ads = '1';\n    var google_ad_output = 'js';\n    var google_ad_type = 'text';\n    var google_only_pyv_ads = true;\n    var google_video_doc_id = \"yt_<?php echo htmlspecialchars($_video['rid']); ?>\";\n      var google_ad_request_done = parent.yt.www.ads.pyv.pyvWatchAfcWithPpvCallback;\n    var google_ad_client = 'ca-pub-6219811747049371';\n    var google_ad_block = '3';\n      var google_ad_host = \"ca-host-pub-6813290291914109\";\n      var google_ad_host_tier_id = \"464885\";\n      var google_page_url = \"\\\/\\\/www.youtube.com\\\/video\\\/<?php echo htmlspecialchars($_video['rid']); ?>\";\n      var google_ad_channel = \"PyvWatchInRelated+PyvYTWatch+PyvWatchNoAdX+pw+non_lpw+afv_user_funker530+afv_user_id_<?php echo htmlspecialchars($_video['author']); ?>+yt_mpvid_AATK8rd3hYr5XSL9+yt_cid_676+ytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816\";\n      var google_language = \"en\";\n      var google_eids = ['56702372'];\n      var google_yt_pt = \"AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ\";\n  \u003c\/script\u003e\n\n  \u003cscript s\u0072c=\"\/\/pagead2.googlesyndication.com\/pagead\/show_ads.js\"\u003e\u003c\/script\u003e\n");
		</script>
		<script>
			window['google_language'] = "en";
			
			
			window['google_ad_type'] = 'image';
			window['google_ad_width'] = '300';
			window['google_ad_block'] = '2';
			window['google_ad_client'] = "ca-pub-6219811747049371";
			window['google_ad_host'] = "ca-host-pub-6813290291914109";
			window['google_ad_host_tier_id'] = "464885";
			window['google_ad_channel'] = "6031455484+6031455482+0854550288+afv_user_funker530+afv_user_id_<?php echo htmlspecialchars($_video['author']); ?>+yt_mpvid_AATK8rd3hYr5XSL9+yt_cid_676+ytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816+Vertical_397+Vertical_881+ytps_default+ytel_detailpage";
			window['google_video_doc_id'] = "yt_<?php echo htmlspecialchars($_video['rid']); ?>";
			window['google_color_border'] = 'FFFFFF';
			window['google_color_bg'] = 'FFFFFF';
			window['google_color_link'] = '0033CC';
			window['google_color_text'] = '444444';
			window['google_color_url'] = '0033CC';
			window['google_language'] = "en";
			window['google_alternate_ad_url'] = "\/\/www.youtube.com\/ad_frame?id=watch-channel-brand-div";
			window['google_yt_pt'] = "AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ";
			window['google_eids'] = ['56702371'];
			window['google_page_url'] = "\/\/www.youtube.com\/video\/<?php echo htmlspecialchars($_video['rid']); ?>";
		</script>
		<script>
			yt.pubsub.subscribe('init', function() {
			  var scriptEl = document.createElement('script');
			  scriptEl.src = "\/\/pagead2.googlesyndication.com\/pagead\/show_companion_ad.js";
			  var headEl = document.getElementsByTagName('head')[0];
			  headEl.appendChild(scriptEl);
			});
		</script>
		<script>
			function afcAdCall() {
			  var channels = "6031455484+6031455482+0854550288+afv_user_funker530+afv_user_id_<?php echo htmlspecialchars($_video['author']); ?>+yt_mpvid_AATK8rd3hYr5XSL9+yt_cid_676+ytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816+Vertical_397+Vertical_881+ytps_default+ytel_detailpage";
			  channels = channels.replace('0854550288', '0854550287');
			  channels = channels.replace('afv_brand_mpu', '0854550287');
			  channels = channels + '+afc_on_page';
			  window['google_ad_format'] = '300x250_as';
			  window['google_ad_height'] = '250';
			  window['google_page_url'] = "\/\/www.youtube.com\/video\/<?php echo htmlspecialchars($_video['rid']); ?>";
			    window['google_yt_pt'] = "AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ";
			
			
			  var afcOptions = {
			    'ad_type': 'image',
			    'format': '300x250_as',
			    'ad_block': '2',
			    'ad_client': "ca-pub-6219811747049371",
			    'ad_host': "ca-host-pub-6813290291914109",
			    'ad_host_tier_id': "464885",
			    'ad_channel': channels,
			    'video_doc_id': "yt_<?php echo htmlspecialchars($_video['rid']); ?>",
			    'color_border': 'FFFFFF',
			    'color_bg': 'FFFFFF',
			    'color_link': '0033CC',
			    'color_text': '444444',
			    'color_url': '0033CC',
			    'language': "en",
			    'alternate_ad_url': "\/\/www.youtube.com\/ad_frame?id=watch-channel-brand-div"
			  };
			  var afcCallback = function() {
			    if (window.google && google.ads && google.ads.Ad) {
			      yt.www.watch.ads.handleShowAfvCompanionAdDiv(false);
			      var ad = new google.ads.Ad("ca-pub-6219811747049371", 'google_companion_ad_div', afcOptions);
			    } else {
			      yt.setTimeout(afcCallback, 200);
			    }
			  };
			  afcCallback();
			}
		</script>
		<script>
			yt.pubsub.subscribe('init', function() {
			  var scriptEl = document.createElement('script');
			  scriptEl.src = "\/\/www.google.com\/jsapi?autoload=%7B%22modules%22%3A%5B%7B%22name%22%3A%22ads%22%2C%22version%22%3A%221%22%2C%22callback%22%3A%22(function()%7B%7D)%22%2C%22packages%22%3A%5B%22content%22%5D%7D%5D%7D";
			  var headEl = document.getElementsByTagName('head')[0];
			  headEl.appendChild(scriptEl);
			});
		</script>
		<script src="//www.googletagservices.com/tag/js/gpt.js"></script>
		<script>
			yt.www.watch.ads.createGutSlot("\/4061\/ytpwatch\/main_676");
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_page");}    
		</script>
		<script>
			yt.setConfig('TIMING_ACTION', "watch5ad");    
		</script>
		<script>yt.pubsub.subscribe('init', function() {yt.www.thumbnaildelayload.init(0);});</script>
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
			
			  yt.setAjaxToken('addto_ajax_logged_out', "KTlts1bRmBPkwoVCGIRuG79_hSF8MTM0OTEzMDExNUAxMzQ5MDQzNzE1");
			
			  yt.www.lists.init();
			
			
			
			
			
			
			
			
			
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
