<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!$__video_h->video_exists($_GET['v'])) { header("Location: /?error=This video doesn't exist!"); } ?>
<?php $_video = $__video_h->fetch_video_rid($_GET['v']); ?>
<?php $_video['comments'] = $__video_h->get_comments_from_video($_video['rid']); ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array();

        if(!isset($_SESSION['siteusername'])){ $error['message'] = "you are not logged in"; $error['status'] = true; }
        if(!$_POST['comment']){ $error['message'] = "your comment cannot be blank"; $error['status'] = true; }
        if(strlen($_POST['comment']) > 1000){ $error['message'] = "your comment must be shorter than 1000 characters"; $error['status'] = true; }
        if($__user_h->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for a minute before posting another comment."; $error['status'] = true; }

        if(!isset($error['message'])) {
			$text = $_POST['comment'];
            $stmt = $__db->prepare("INSERT INTO comments (toid, author, comment) VALUES (:v, :username, :comment)");
            $stmt->bindParam(":v", $_GET['v']);
			$stmt->bindParam(":username", $_SESSION['siteusername']);
			$stmt->bindParam(":comment", $text);
            $stmt->execute();

			$__user_u->update_cooldown_time($_SESSION['siteusername'], "cooldown_comment");
        }
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $__server->page_embeds->page_title; ?></title>
		<meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="/s/js/alert.js"></script>
		<script>
			var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
		</script>
		<link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
		<link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
		<script>
			if (window.yt.timing) {yt.timing.tick("ct");}    
		</script>
		<?php
			$_video['dislikes'] =  $__video_h->get_video_stars_level($_video['rid'], 1);
			$_video['dislikes'] += $__video_h->get_video_stars_level($_video['rid'], 2);

			$_video['likes'] =     $__video_h->get_video_stars_level($_video['rid'], 4);
			$_video['likes'] +=    $__video_h->get_video_stars_level($_video['rid'], 5);

			$_video['dislikes'] += $__video_h->get_video_likes($_video['rid'], false);
			$_video['likes'] += $__video_h->get_video_likes($_video['rid'], true);

			if($_video['likes'] == 0 && $_video['dislikes'] == 0) {
				$_video['likeswidth'] = 50;
				$_video['dislikeswidth'] = 50;
			} else {
				$_video['likeswidth'] = $_video['likes'] / ($_video['likes'] + $_video['dislikes']) * 100;
				$_video['dislikeswidth'] = 100 - $_video['likeswidth'];
			}

			$_video['liked'] = $__video_h->if_liked(@$_SESSION['siteusername'], $_video['rid'], true);
			$_video['disliked'] = $__video_h->if_liked(@$_SESSION['siteusername'], $_video['rid'], false);
			$_video['author_videos'] = $__video_h->fetch_user_videos($_video['author']);
			$_video['subscribed'] = $__user_h->if_subscribed(@$_SESSION['siteusername'], $_video['author']);
		?>
	</head>
	<body id="" class="date-20120927 en_US ltr   ytg-old-clearfix guide-feed-v2 gecko gecko-15" dir="ltr">
		<form name="logoutForm" method="POST" action="/logout">
			<input type="hidden" name="action_logout" value="1">
		</form>
		<!-- begin page -->
		<div id="page" class="  watch  ">
			<div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php") ?></div>
			<div id="content-container">
				<!-- begin content -->
				<div id="content">
					<div id="watch-container" itemscope="" itemtype="http://schema.org/VideoObject">
						<!-- begin watch-headline-container -->
						<div id="watch-headline-container">
							<div id="watch-headline" class="watch-headline">
								<div id="watch-longform-ad" style="display:none;">
									<div id="watch-longform-text" style="visibility:hidden">
										Advertisement
									</div>
									<div id="watch-longform-ad-placeholder">
										<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" width="300" height="60">
									</div>
									<div id="instream_google_companion_ad_div"></div>
								</div>
								<?php if(@$_SESSION['siteusername'] == $_video['author']) { ?>
									<div id="watch-owner-container">
										<div id="masthead-subnav" class="yt-nav yt-nav-dark ">
											<ul class="yt-nav-aside">
												<li>
													<a href="/my_videos" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Video Manager</span></a>
												</li>
											</ul>
											<ul>
												<li>
													<a href="/edit_video?id=<?php echo $_video['rid']; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Edit</span></a>
												</li>
												<li>
													<a href="/get/delete_video?v=<?php echo $_video['rid']; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Delete Video</span></a>
												</li>
											</ul>
										</div>
									</div><br>
								<?php } ?>
								<h1 id="watch-headline-title">
									<span id="eow-title" class="long-title " dir="ltr" title="<?php echo htmlspecialchars($_video['title']); ?>">
									<?php echo htmlspecialchars($_video['title']); ?>
									</span>
								</h1>
								<div id="watch-headline-user-info">
									<button style="margin-right: -5px;" href="/user/<?php echo htmlspecialchars($_video['author']); ?>" type="button" class="start yt-uix-button yt-uix-button-default" onclick=";window.location.href=this.getAttribute('href');return false;" role="button">
										<span class="yt-uix-button-content"><?php echo htmlspecialchars($_video['author']); ?></span>
									</button>
									<div class="yt-subscription-button-hovercard yt-uix-hovercard">
										<span class="yt-uix-button-context-light yt-uix-button-subscription-container">
										<button 
											onclick=";subscribe();return false;" 
											title="" 
											id="subscribe-button"
											type="button" 
											class="<?php if($_video['subscribed']) { echo "subscribed "; } ?>yt-subscription-button  yt-uix-button yt-uix-button-subscription yt-uix-tooltip" 
											role="button">
											<span class="yt-uix-button-icon-wrapper">
												<img class="yt-uix-button-icon yt-uix-button-icon-subscribe" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
												<span class="yt-valign-trick"></span>
											</span>
											<span class="yt-uix-button-content">
												<span class="subscribe-label">Subscribe</span>
												<span class="subscribed-label">Subscribed</span>
												<span class="unsubscribe-label">Unsubscribe</span>
											</span>
										</button>
										<span class="yt-subscription-button-disabled-mask"></span></span>
										<div class="yt-uix-hovercard-content hid">
											<p class="loading-spinner">
												<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
												Loading...
											</p>
										</div>
									</div>
									<button onclick="_toggleclass(this,'yt-uix-expander-collapsed');return false;" type="button" id="watch-mfu-button" class="yt-uix-expander-collapsed yt-uix-button yt-uix-button-default" data-button-toggle="true" data-video-user-id="<?php echo htmlspecialchars($_video['author']); ?>" data-button-menu-id="some-nonexistent-menu" data-video-id="<?php echo htmlspecialchars($_video['rid']); ?>" data-button-action="yt.www.watch.watch5.handleToggleMoreFromUser" role="button"><span class="yt-uix-button-content"><?php echo $_video['author_videos']; ?> videos </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
								</div>
								<div id="watch-more-from-user" class="collapsed">
									<div id="watch-channel-discoverbox" class="yt-rounded">
										<span id="watch-channel-loading">Loading...</span>
									</div>
								</div>
							</div>
						</div>
						<!-- end watch-headline-container -->
						<div id="watch-video-container">
							<div id="watch-video">
								<!--
								<script>
									if (window.yt.timing) {yt.timing.tick("bf");}    
								</script>
								<div id="watch-player" class="flash-player">
									<embed type="application/x-shockwave-flash" src="http://s.ytimg.com/yt/swfbin/watch_as3-vflrx8gtr.swf" id="movie_player" flashvars="account_playback_token=&amp;ptk=machinima&amp;enablecsi=1&amp;iv_close_button=0&amp;mpvid=AATK8rd3hYr5XSL9&amp;autohide=2&amp;csi_page_type=watch5ad&amp;keywords=yt%3Acrop%3D4%3A3%2CFirefight%2Ctaliban%2Cambush%2CArmy%2CMilitary%2Cshot%2Cmachine%2Cgun&amp;cr=US&amp;host_language=en&amp;iv3_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv3_module-vflEMFREp.swf&amp;ad_flags=0&amp;fmt_list=45%2F1280x720%2F99%2F0%2F0%2C22%2F1280x720%2F9%2F0%2F115%2C44%2F854x480%2F99%2F0%2F0%2C35%2F854x480%2F9%2F0%2F115%2C43%2F640x360%2F99%2F0%2F0%2C34%2F640x360%2F9%2F0%2F115%2C18%2F640x360%2F9%2F0%2F115%2C5%2F320x240%2F7%2F0%2F0%2C36%2F320x240%2F99%2F0%2F0%2C17%2F176x144%2F99%2F0%2F0&amp;platform=None&amp;loeid=906717%2C901803%2C907354%2C904448%2C901424&amp;invideo=True&amp;afv_ad_tag=http%3A%2F%2Fgoogleads.g.doubleclick.net%2Fpagead%2Fads%3Fdescription_url%3Dhttp%253A%252F%252Fwww.youtube.com%252Fvideo%252F<?php echo htmlspecialchars($_video['rid']); ?>%26ht_id%3D464885%26video_cpm%3D6000000%26ad_type%3Dskippablevideo%26loeid%3D906717%252C901803%252C907354%252C904448%252C901424%26host%3Dca-host-pub-6813290291914109%26client%3Dca-pub-6219811747049371%26hl%3Den%26max_ad_duration%3D15000%26channel%3Dafv_instream%252CVertical_397%252CVertical_881%252Cafv_instream_us%252Cafv_user_funker530%252Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%252Cyt_mpvid_AATK8rd3hYr5XSL9%252Cyt_cid_676%252Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%252Cytps_default%252Cytel_detailpage&amp;tk=pluFCw5PmNPcKWZJHaDotXzHY_eAKpMxHA0FIGLWpvnrxAWhNVwaaw%3D%3D&amp;sffb=True&amp;ad_channel_code_instream=afv_instream%2CVertical_397%2CVertical_881%2Cafv_instream_us%2Cafv_user_funker530%2Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%2Cyt_mpvid_AATK8rd3hYr5XSL9%2Cyt_cid_676%2Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%2Cytps_default%2Cytel_detailpage&amp;sdetail=f%3Ag-logo-xit%2Cp%3A%2F&amp;url_encoded_fmt_stream_map=itag%3D45%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D45%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v11.cache3.c.youtube.com%26sig%3D4D0B68C89CD0F30F64C7E040D12F2028A1F2D1E6.A167CCC00C7BEBAD022A63BFE6216147BDBF40CE%26quality%3Dhd720%2Citag%3D22%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D22%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.64001F%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v17.cache8.c.youtube.com%26sig%3DBA6118048C09BA1B2703900C99207338AF612392.63ABCB15F1835342EA2B20B61401016FE6C60647%26quality%3Dhd720%2Citag%3D44%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D44%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v5.cache8.c.youtube.com%26sig%3D82417ED76D17D4D880D76A3CFA4A7B49B799E056.49880E4AC9834DF3CC3438F2F43C028BA2813862%26quality%3Dlarge%2Citag%3D35%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D35%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v19.cache1.c.youtube.com%26sig%3D55B0162403D6C46EC083BFCB344505AF35EEF01F.9FF2FCCA4B674C63E492DBAFA0F519777318B08E%26quality%3Dlarge%2Citag%3D43%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D43%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v6.cache7.c.youtube.com%26sig%3D9A1F563BE6D0EEE47E0095CFBEE32F68304BE27C.8E00D30F94B572E9306D6CFE60B545279B2AEEF7%26quality%3Dmedium%2Citag%3D34%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D34%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v9.cache5.c.youtube.com%26sig%3D4C7A33428D93B260BDD36407C89B82AE269AE2CE.5EF06FF4AAF1E3584C48717A8033720F37746B12%26quality%3Dmedium%2Citag%3D18%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D18%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v12.cache5.c.youtube.com%26sig%3D1511F1115B1EB94452A28F71FF143B617DF2EB51.CB6CE4A5885735A2FA2625E632D4CCA0744F2DC7%26quality%3Dmedium%2Citag%3D5%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D5%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v10.cache5.c.youtube.com%26sig%3D5340EDCCB38578F4C44F10600D41FA8CA2078DD7.02AABD135EB44084237C9D5C8410F4F48D6CAC18%26quality%3Dsmall%2Citag%3D36%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D36%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v15.cache6.c.youtube.com%26sig%3D4C5B60BD483DA710FBA1457946FF9DC7A68CAE8E.CB4186AC20FDFF30229C32A2C22F50EC593D7EC5%26quality%3Dsmall%2Citag%3D17%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D17%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v8.cache2.c.youtube.com%26sig%3DB059261056F959A2BE9C6D25B4D4592E2E805418.0B8D5EADD055CCE96C746129629F4F13AF72D7CD%26quality%3Dsmall&amp;cafe_experiment_id=56702370&amp;sourceid=y&amp;timestamp=1349043715&amp;storyboard_spec=http%3A%2F%2Fi3.ytimg.com%2Fsb%2F<?php echo htmlspecialchars($_video['rid']); ?>%2Fstoryboard3_L%24L%2F%24N.jpg%7C48%2327%23100%2310%2310%230%23default%23guov8K5GbEijp3_mWvQCsC8b3KU%7C80%2345%23106%2310%2310%232000%23M%24M%232-rhosBWAp4uX752TX50_OeoZ8U%7C160%2390%23106%235%235%232000%23M%24M%23rQ5-ZvOHqaxICOVmMBTz4zcKL2o&amp;iv_load_policy=1&amp;ad_host=ca-host-pub-6813290291914109&amp;ad_eurl=http%3A%2F%2Fwww.youtube.com%2Fvideo%2F<?php echo htmlspecialchars($_video['rid']); ?>&amp;showpopout=1&amp;mpu=True&amp;hl=en_US&amp;tmi=1&amp;iv_logging_level=4&amp;st_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fst_module-vflBfOYbW.swf&amp;no_get_video_log=1&amp;endscreen_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fendscreen-vflFXd--E.swf&amp;iv_read_url=http%3A%2F%2Fwww.youtube.com%2Fannotations_iv%2Fread2%3Fsparams%3Dexpire%252Cvideo_id%26expire%3D1349087040%26key%3Da1%26signature%3D927C3067D1CF3C5696A672D838EA4519F6D9DC9B.703A7169FB065EBDDDBECD18F78FE056AD8DEAAA%26video_id%3D<?php echo htmlspecialchars($_video['rid']); ?>%26feat%3DCS&amp;cid=676&amp;referrer=http%3A%2F%2Fwww.youtube.com%2F%3Ftab%3Dyy&amp;ad_channel_code_overlay=invideo_overlay_480x70_cat25%2Cafv_overlay%2CVertical_397%2CVertical_881%2Cafv_user_funker530%2Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%2Cyt_mpvid_AATK8rd3hYr5XSL9%2Cyt_cid_676%2Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%2Cytps_default%2Cytel_detailpage&amp;afv_instream_max=15000&amp;pyv_in_related_cafe_experiment_id=56702372&amp;t=vjVQa1PpcFMS6aQZETnG-Y9CUzspv2S9Oh2KkE16-Rw%3D&amp;afv_ad_tag_restricted_to_instream=http%3A%2F%2Fgoogleads.g.doubleclick.net%2Fpagead%2Fads%3Fdescription_url%3Dhttp%253A%252F%252Fwww.youtube.com%252Fvideo%252F<?php echo htmlspecialchars($_video['rid']); ?>%26ht_id%3D464885%26video_cpm%3D6000000%26ad_type%3Dskippablevideo%26loeid%3D906717%252C901803%252C907354%252C904448%252C901424%26host%3Dca-host-pub-6813290291914109%26client%3Dca-pub-6219811747049371%26hl%3Den%26max_ad_duration%3D15000%26channel%3Dafv_instream%252CVertical_397%252CVertical_881%252Cafv_instream_us%252Cafv_user_funker530%252Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%252Cyt_mpvid_AATK8rd3hYr5XSL9%252Cyt_cid_676%252Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%252Cytps_default%252Cytel_detailpage&amp;fexp=906717%2C901803%2C907354%2C904448%2C901424%2C922401%2C920704%2C912806%2C913419%2C913546%2C913556%2C919349%2C919351%2C925109%2C919003%2C912706%2C900816&amp;no_afv_instream=1&amp;shortform=True&amp;dclk=True&amp;inactive_skippable_threshold=600000&amp;allow_embed=1&amp;ad_host_tier=464885&amp;rvs=view_count%3D643%252C930%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D154%26id%3DgyAaIKF6tSQ%26title%3DMINIGUN%2BSPECIAL%2BFORCES%2BFIREFIGHT%2BIN%2BAFGHANISTAN%2Cview_count%3D304%252C638%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D98%26id%3Dp9Lx3dODzd4%26title%3DM777%2BHowitzers%2BEngage%2BFiring%2BPosition%2Bin%2BAfghanistan%2Cview_count%3D46%252C578%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D82%26id%3DSqz5P4d-azM%26title%3DBreaking%2BThe%2BSilence%2B%257C%2BEpisode%2B4%2Cview_count%3D256%252C886%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D177%26id%3DPeqZPjuLtlw%26title%3DAirstrike%2Bin%2BAghanistan%2B-%2B3%2BJDAM%2BTACP%2Cview_count%3D15%252C691%26author%3DBuddhaCharlieShow%26length_seconds%3D92%26id%3Dvt2bdWh3BPM%26title%3DUS%2BSoldier%2BSurvives%2BTaliban%2BMachine%2BGun%2BFire%2BDuring%2BFirefight%2BMy%2BThoughts%2Cview_count%3D1%252C406%252C236%26author%3DNighthawkinlight%26length_seconds%3D183%26id%3Dr_8wRpgvhyg%26title%3DHow%2Bto%2BMake%2Ban%2BAirsoft%2BMachine%2BGun%2Bfrom%2Ba%2BSoda%2BBottle%2Cview_count%3D828%252C367%26author%3DDqwon%26length_seconds%3D285%26id%3D00PdHIPjaWQ%26title%3DPortishead%2B-%2BMachine%2BGun%2Cview_count%3D465%252C071%26author%3DAmericanCountryMan%26length_seconds%3D206%26id%3D7hPjatgRjL4%26title%3D%2522taliban%2Bsong%2522%2B-%2Btoby%2Bkeith%2Cview_count%3D254%26author%3Dlloyd%2Byoung%26length_seconds%3D78%26id%3Da8YixbzpVgc%26title%3DUS%2BSoldier%2BSurvives%2BTaliban%2BMachine%2BGun%2BFire%2BDuring%2BFirefight%2Cview_count%3D12%252C773%252C980%26author%3DFPSRussia%26length_seconds%3D312%26id%3DSNPJMk2fgJU%26title%3DPrototype%2BQuadrotor%2Bwith%2BMachine%2BGun%2521%2Cview_count%3D1%252C104%26author%3DTheAquariusAlex%26length_seconds%3D389%26id%3Du5YE5DsT2E4%26title%3DEasy%2B%2521%2BMob%2BGrinder%2BTutorial%2Cview_count%3D1%252C800%252C418%26author%3Dnikhilrohatgi%26length_seconds%3D296%26id%3DIA0kx9ZbOzI%26title%3Dzakk%2Bwylde%2B-%2Bmachine%2Bgun%2Bman%2B%2528live%2529&amp;vq=auto&amp;yt_pt=AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ&amp;excluded_ads=2%3D2_2_1&amp;ad3_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fad3-vflSndU9R.swf&amp;gut_tag=%2F4061%2Fytpwatch%2Fmain_676&amp;ptchn=<?php echo htmlspecialchars($_video['author']); ?>&amp;ad_logging_flag=1&amp;length_seconds=209&amp;feature=g-logo-xit&amp;enablejsapi=1&amp;plid=AATK8rd3IxlBnwIO&amp;iv_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv_module-vflQKTkFU.swf&amp;afv=True&amp;ad_tag=http%3A%2F%2Fad-g.doubleclick.net%2FN4061%2Fpfadx%2Fcom.ytpwatch.newsandpolitics%2Fmain_676%3Bsz%3DWIDTHxHEIGHT%3Bkvid%3D<?php echo htmlspecialchars($_video['rid']); ?>%3Bkpu%3D<?php echo htmlspecialchars($_video['author']); ?>%3Bkpid%3D676%3Bu%3D<?php echo htmlspecialchars($_video['rid']); ?>%7C676%3Bmpvid%3DAATK8rd3hYr5XSL9%3Bplat%3Dpc%3Bkpeid%3D<?php echo htmlspecialchars($_video['author']); ?>%3Bafct%3Dsite_content%3Bafv%3D1%3Bdc_dedup%3D1%3Bk5%3D397_881%3Bkbz%3D1%3Bkclt%3D1%3Bkcr%3Dus%3Bkga%3D-1%3Bkgg%3D-1%3Bklg%3Den%3Bkmsrd%3D1%3Bko%3Dp%3Bkr%3DF%3Bkt%3DK%3Bkvz%3D205%3Bshortform%3D1%3Btves%3D2%3Bytcat%3D25%3Bytexp%3D906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%3Bytps%3Ddefault%3Bytvt%3Dw%3B%21c%3D676%3Bk2%3D397%3Bk2%3D881%3Bkvlg%3Den%3B&amp;ad_video_pub_id=ca-pub-6219811747049371&amp;ad_slots=0&amp;watermark=%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_watermark-vflHX6b6E.png%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_hd_watermark-vflAzLcD6.png&amp;oid=Ub4HVMaNS3_bFHc6MYUOiw&amp;afv_video_min_cpm=6000000&amp;afv_inslate_ad_tag=http%3A%2F%2Fgoogleads.g.doubleclick.net%2Fpagead%2Fads%3Fdescription_url%3Dhttp%253A%252F%252Fwww.youtube.com%252Fvideo%252F<?php echo htmlspecialchars($_video['rid']); ?>%26ht_id%3D464885%26ad_type%3Duserchoice%26loeid%3D906717%252C901803%252C907354%252C904448%252C901424%26host%3Dca-host-pub-6813290291914109%26client%3Dca-pub-6219811747049371%26hl%3Den%26max_ad_duration%3D15000&amp;iv_queue_log_level=0&amp;as_launched_in_country=1&amp;title=U.S.+Soldier+Survives+Taliban+Machine+Gun+Fire+During+Firefight&amp;sw=0.1&amp;sk=bGQU2KbiGvGxNpDhkR1VC_WZ9DAZFSYvC&amp;pltype=content&amp;video_id=<?php echo htmlspecialchars($_video['rid']); ?>" allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" width="640" height="390">
									<noembed>
										<div class="yt-alert yt-alert-default yt-alert-error  yt-alert-player">
											<div class="yt-alert-icon">
												<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
											</div>
											<div class="yt-alert-buttons"></div>
											<div class="yt-alert-content" role="alert">
												<span class="yt-alert-vertical-trick"></span>
												<div class="yt-alert-message">
													You need Adobe Flash Player to watch this video. <br> <a href="http://get.adobe.com/flashplayer/">Download it from Adobe.</a>
												</div>
											</div>
										</div>
									</noembed>
								</div>
								<script>
									(function() {
									  var swf = "      \u003cembed type=\"application\/x-shockwave-flash\"     s\u0072c=\"http:\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vflrx8gtr.swf\"     w\u0069dth=\"640\" id=\"movie_player\" h\u0065ight=\"390\"    flashvars=\"account_playback_token=\u0026amp;ptk=machinima\u0026amp;enablecsi=1\u0026amp;iv_close_button=0\u0026amp;mpvid=AATK8rd3hYr5XSL9\u0026amp;autohide=2\u0026amp;csi_page_type=watch5ad\u0026amp;keywords=yt%3Acrop%3D4%3A3%2CFirefight%2Ctaliban%2Cambush%2CArmy%2CMilitary%2Cshot%2Cmachine%2Cgun\u0026amp;cr=US\u0026amp;host_language=en\u0026amp;iv3_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv3_module-vflEMFREp.swf\u0026amp;ad_flags=0\u0026amp;fmt_list=45%2F1280x720%2F99%2F0%2F0%2C22%2F1280x720%2F9%2F0%2F115%2C44%2F854x480%2F99%2F0%2F0%2C35%2F854x480%2F9%2F0%2F115%2C43%2F640x360%2F99%2F0%2F0%2C34%2F640x360%2F9%2F0%2F115%2C18%2F640x360%2F9%2F0%2F115%2C5%2F320x240%2F7%2F0%2F0%2C36%2F320x240%2F99%2F0%2F0%2C17%2F176x144%2F99%2F0%2F0\u0026amp;platform=None\u0026amp;loeid=906717%2C901803%2C907354%2C904448%2C901424\u0026amp;invideo=True\u0026amp;afv_ad_tag=http%3A%2F%2Fgoogleads.g.doubleclick.net%2Fpagead%2Fads%3Fdescription_url%3Dhttp%253A%252F%252Fwww.youtube.com%252Fvideo%252F<?php echo htmlspecialchars($_video['rid']); ?>%26ht_id%3D464885%26video_cpm%3D6000000%26ad_type%3Dskippablevideo%26loeid%3D906717%252C901803%252C907354%252C904448%252C901424%26host%3Dca-host-pub-6813290291914109%26client%3Dca-pub-6219811747049371%26hl%3Den%26max_ad_duration%3D15000%26channel%3Dafv_instream%252CVertical_397%252CVertical_881%252Cafv_instream_us%252Cafv_user_funker530%252Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%252Cyt_mpvid_AATK8rd3hYr5XSL9%252Cyt_cid_676%252Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%252Cytps_default%252Cytel_detailpage\u0026amp;tk=pluFCw5PmNPcKWZJHaDotXzHY_eAKpMxHA0FIGLWpvnrxAWhNVwaaw%3D%3D\u0026amp;sffb=True\u0026amp;ad_channel_code_instream=afv_instream%2CVertical_397%2CVertical_881%2Cafv_instream_us%2Cafv_user_funker530%2Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%2Cyt_mpvid_AATK8rd3hYr5XSL9%2Cyt_cid_676%2Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%2Cytps_default%2Cytel_detailpage\u0026amp;sdetail=f%3Ag-logo-xit%2Cp%3A%2F\u0026amp;url_encoded_fmt_stream_map=itag%3D45%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D45%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v11.cache3.c.youtube.com%26sig%3D4D0B68C89CD0F30F64C7E040D12F2028A1F2D1E6.A167CCC00C7BEBAD022A63BFE6216147BDBF40CE%26quality%3Dhd720%2Citag%3D22%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D22%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.64001F%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v17.cache8.c.youtube.com%26sig%3DBA6118048C09BA1B2703900C99207338AF612392.63ABCB15F1835342EA2B20B61401016FE6C60647%26quality%3Dhd720%2Citag%3D44%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D44%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v5.cache8.c.youtube.com%26sig%3D82417ED76D17D4D880D76A3CFA4A7B49B799E056.49880E4AC9834DF3CC3438F2F43C028BA2813862%26quality%3Dlarge%2Citag%3D35%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D35%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v19.cache1.c.youtube.com%26sig%3D55B0162403D6C46EC083BFCB344505AF35EEF01F.9FF2FCCA4B674C63E492DBAFA0F519777318B08E%26quality%3Dlarge%2Citag%3D43%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D43%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v6.cache7.c.youtube.com%26sig%3D9A1F563BE6D0EEE47E0095CFBEE32F68304BE27C.8E00D30F94B572E9306D6CFE60B545279B2AEEF7%26quality%3Dmedium%2Citag%3D34%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D34%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v9.cache5.c.youtube.com%26sig%3D4C7A33428D93B260BDD36407C89B82AE269AE2CE.5EF06FF4AAF1E3584C48717A8033720F37746B12%26quality%3Dmedium%2Citag%3D18%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349068425%2526itag%253D18%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349043671%2526ip%253D98.114.43.169%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v12.cache5.c.youtube.com%26sig%3D1511F1115B1EB94452A28F71FF143B617DF2EB51.CB6CE4A5885735A2FA2625E632D4CCA0744F2DC7%26quality%3Dmedium%2Citag%3D5%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D5%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v10.cache5.c.youtube.com%26sig%3D5340EDCCB38578F4C44F10600D41FA8CA2078DD7.02AABD135EB44084237C9D5C8410F4F48D6CAC18%26quality%3Dsmall%2Citag%3D36%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D36%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v15.cache6.c.youtube.com%26sig%3D4C5B60BD483DA710FBA1457946FF9DC7A68CAE8E.CB4186AC20FDFF30229C32A2C22F50EC593D7EC5%26quality%3Dsmall%2Citag%3D17%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DBiwYGDaJ9qA%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D906717%25252C901803%25252C907354%25252C904448%25252C901424%25252C922401%25252C920704%25252C912806%25252C913419%25252C913546%25252C913556%25252C919349%25252C919351%25252C925109%25252C919003%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D98.114.43.169%2526itag%253D17%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349043671%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%2526expire%253D1349068425%2526id%253Dacb1d4fbf3a14fc8%2526newshard%253Dyes%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v8.cache2.c.youtube.com%26sig%3DB059261056F959A2BE9C6D25B4D4592E2E805418.0B8D5EADD055CCE96C746129629F4F13AF72D7CD%26quality%3Dsmall\u0026amp;cafe_experiment_id=56702370\u0026amp;sourceid=y\u0026amp;timestamp=1349043715\u0026amp;storyboard_spec=http%3A%2F%2Fi3.ytimg.com%2Fsb%2F<?php echo htmlspecialchars($_video['rid']); ?>%2Fstoryboard3_L%24L%2F%24N.jpg%7C48%2327%23100%2310%2310%230%23default%23guov8K5GbEijp3_mWvQCsC8b3KU%7C80%2345%23106%2310%2310%232000%23M%24M%232-rhosBWAp4uX752TX50_OeoZ8U%7C160%2390%23106%235%235%232000%23M%24M%23rQ5-ZvOHqaxICOVmMBTz4zcKL2o\u0026amp;iv_load_policy=1\u0026amp;ad_host=ca-host-pub-6813290291914109\u0026amp;ad_eurl=http%3A%2F%2Fwww.youtube.com%2Fvideo%2F<?php echo htmlspecialchars($_video['rid']); ?>\u0026amp;showpopout=1\u0026amp;mpu=True\u0026amp;hl=en_US\u0026amp;tmi=1\u0026amp;iv_logging_level=4\u0026amp;st_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fst_module-vflBfOYbW.swf\u0026amp;no_get_video_log=1\u0026amp;endscreen_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fendscreen-vflFXd--E.swf\u0026amp;iv_read_url=http%3A%2F%2Fwww.youtube.com%2Fannotations_iv%2Fread2%3Fsparams%3Dexpire%252Cvideo_id%26expire%3D1349087040%26key%3Da1%26signature%3D927C3067D1CF3C5696A672D838EA4519F6D9DC9B.703A7169FB065EBDDDBECD18F78FE056AD8DEAAA%26video_id%3D<?php echo htmlspecialchars($_video['rid']); ?>%26feat%3DCS\u0026amp;cid=676\u0026amp;referrer=http%3A%2F%2Fwww.youtube.com%2F%3Ftab%3Dyy\u0026amp;ad_channel_code_overlay=invideo_overlay_480x70_cat25%2Cafv_overlay%2CVertical_397%2CVertical_881%2Cafv_user_funker530%2Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%2Cyt_mpvid_AATK8rd3hYr5XSL9%2Cyt_cid_676%2Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%2Cytps_default%2Cytel_detailpage\u0026amp;afv_instream_max=15000\u0026amp;pyv_in_related_cafe_experiment_id=56702372\u0026amp;t=vjVQa1PpcFMS6aQZETnG-Y9CUzspv2S9Oh2KkE16-Rw%3D\u0026amp;afv_ad_tag_restricted_to_instream=http%3A%2F%2Fgoogleads.g.doubleclick.net%2Fpagead%2Fads%3Fdescription_url%3Dhttp%253A%252F%252Fwww.youtube.com%252Fvideo%252F<?php echo htmlspecialchars($_video['rid']); ?>%26ht_id%3D464885%26video_cpm%3D6000000%26ad_type%3Dskippablevideo%26loeid%3D906717%252C901803%252C907354%252C904448%252C901424%26host%3Dca-host-pub-6813290291914109%26client%3Dca-pub-6219811747049371%26hl%3Den%26max_ad_duration%3D15000%26channel%3Dafv_instream%252CVertical_397%252CVertical_881%252Cafv_instream_us%252Cafv_user_funker530%252Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%252Cyt_mpvid_AATK8rd3hYr5XSL9%252Cyt_cid_676%252Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%252Cytps_default%252Cytel_detailpage\u0026amp;fexp=906717%2C901803%2C907354%2C904448%2C901424%2C922401%2C920704%2C912806%2C913419%2C913546%2C913556%2C919349%2C919351%2C925109%2C919003%2C912706%2C900816\u0026amp;no_afv_instream=1\u0026amp;shortform=True\u0026amp;dclk=True\u0026amp;inactive_skippable_threshold=600000\u0026amp;allow_embed=1\u0026amp;ad_host_tier=464885\u0026amp;rvs=view_count%3D643%252C930%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D154%26id%3DgyAaIKF6tSQ%26title%3DMINIGUN%2BSPECIAL%2BFORCES%2BFIREFIGHT%2BIN%2BAFGHANISTAN%2Cview_count%3D304%252C638%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D98%26id%3Dp9Lx3dODzd4%26title%3DM777%2BHowitzers%2BEngage%2BFiring%2BPosition%2Bin%2BAfghanistan%2Cview_count%3D46%252C578%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D82%26id%3DSqz5P4d-azM%26title%3DBreaking%2BThe%2BSilence%2B%257C%2BEpisode%2B4%2Cview_count%3D256%252C886%26author%3D<?php echo htmlspecialchars($_video['author']); ?>%26length_seconds%3D177%26id%3DPeqZPjuLtlw%26title%3DAirstrike%2Bin%2BAghanistan%2B-%2B3%2BJDAM%2BTACP%2Cview_count%3D15%252C691%26author%3DBuddhaCharlieShow%26length_seconds%3D92%26id%3Dvt2bdWh3BPM%26title%3DUS%2BSoldier%2BSurvives%2BTaliban%2BMachine%2BGun%2BFire%2BDuring%2BFirefight%2BMy%2BThoughts%2Cview_count%3D1%252C406%252C236%26author%3DNighthawkinlight%26length_seconds%3D183%26id%3Dr_8wRpgvhyg%26title%3DHow%2Bto%2BMake%2Ban%2BAirsoft%2BMachine%2BGun%2Bfrom%2Ba%2BSoda%2BBottle%2Cview_count%3D828%252C367%26author%3DDqwon%26length_seconds%3D285%26id%3D00PdHIPjaWQ%26title%3DPortishead%2B-%2BMachine%2BGun%2Cview_count%3D465%252C071%26author%3DAmericanCountryMan%26length_seconds%3D206%26id%3D7hPjatgRjL4%26title%3D%2522taliban%2Bsong%2522%2B-%2Btoby%2Bkeith%2Cview_count%3D254%26author%3Dlloyd%2Byoung%26length_seconds%3D78%26id%3Da8YixbzpVgc%26title%3DUS%2BSoldier%2BSurvives%2BTaliban%2BMachine%2BGun%2BFire%2BDuring%2BFirefight%2Cview_count%3D12%252C773%252C980%26author%3DFPSRussia%26length_seconds%3D312%26id%3DSNPJMk2fgJU%26title%3DPrototype%2BQuadrotor%2Bwith%2BMachine%2BGun%2521%2Cview_count%3D1%252C104%26author%3DTheAquariusAlex%26length_seconds%3D389%26id%3Du5YE5DsT2E4%26title%3DEasy%2B%2521%2BMob%2BGrinder%2BTutorial%2Cview_count%3D1%252C800%252C418%26author%3Dnikhilrohatgi%26length_seconds%3D296%26id%3DIA0kx9ZbOzI%26title%3Dzakk%2Bwylde%2B-%2Bmachine%2Bgun%2Bman%2B%2528live%2529\u0026amp;vq=auto\u0026amp;yt_pt=AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ\u0026amp;excluded_ads=2%3D2_2_1\u0026amp;ad3_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fad3-vflSndU9R.swf\u0026amp;gut_tag=%2F4061%2Fytpwatch%2Fmain_676\u0026amp;ptchn=<?php echo htmlspecialchars($_video['author']); ?>\u0026amp;ad_logging_flag=1\u0026amp;length_seconds=209\u0026amp;feature=g-logo-xit\u0026amp;enablejsapi=1\u0026amp;plid=AATK8rd3IxlBnwIO\u0026amp;iv_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv_module-vflQKTkFU.swf\u0026amp;afv=True\u0026amp;ad_tag=http%3A%2F%2Fad-g.doubleclick.net%2FN4061%2Fpfadx%2Fcom.ytpwatch.newsandpolitics%2Fmain_676%3Bsz%3DWIDTHxHEIGHT%3Bkvid%3D<?php echo htmlspecialchars($_video['rid']); ?>%3Bkpu%3D<?php echo htmlspecialchars($_video['author']); ?>%3Bkpid%3D676%3Bu%3D<?php echo htmlspecialchars($_video['rid']); ?>%7C676%3Bmpvid%3DAATK8rd3hYr5XSL9%3Bplat%3Dpc%3Bkpeid%3D<?php echo htmlspecialchars($_video['author']); ?>%3Bafct%3Dsite_content%3Bafv%3D1%3Bdc_dedup%3D1%3Bk5%3D397_881%3Bkbz%3D1%3Bkclt%3D1%3Bkcr%3Dus%3Bkga%3D-1%3Bkgg%3D-1%3Bklg%3Den%3Bkmsrd%3D1%3Bko%3Dp%3Bkr%3DF%3Bkt%3DK%3Bkvz%3D205%3Bshortform%3D1%3Btves%3D2%3Bytcat%3D25%3Bytexp%3D906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%3Bytps%3Ddefault%3Bytvt%3Dw%3B%21c%3D676%3Bk2%3D397%3Bk2%3D881%3Bkvlg%3Den%3B\u0026amp;ad_video_pub_id=ca-pub-6219811747049371\u0026amp;ad_slots=0\u0026amp;watermark=%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_watermark-vflHX6b6E.png%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_hd_watermark-vflAzLcD6.png\u0026amp;oid=Ub4HVMaNS3_bFHc6MYUOiw\u0026amp;afv_video_min_cpm=6000000\u0026amp;afv_inslate_ad_tag=http%3A%2F%2Fgoogleads.g.doubleclick.net%2Fpagead%2Fads%3Fdescription_url%3Dhttp%253A%252F%252Fwww.youtube.com%252Fvideo%252F<?php echo htmlspecialchars($_video['rid']); ?>%26ht_id%3D464885%26ad_type%3Duserchoice%26loeid%3D906717%252C901803%252C907354%252C904448%252C901424%26host%3Dca-host-pub-6813290291914109%26client%3Dca-pub-6219811747049371%26hl%3Den%26max_ad_duration%3D15000\u0026amp;iv_queue_log_level=0\u0026amp;as_launched_in_country=1\u0026amp;title=U.S.+Soldier+Survives+Taliban+Machine+Gun+Fire+During+Firefight\u0026amp;sw=0.1\u0026amp;sk=bGQU2KbiGvGxNpDhkR1VC_WZ9DAZFSYvC\u0026amp;pltype=content\u0026amp;video_id=<?php echo htmlspecialchars($_video['rid']); ?>\"     allowscriptaccess=\"always\" allowfullscreen=\"true\" bgcolor=\"#000000\"\u003e\n  \u003cnoembed\u003e\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e\u003c\/noembed\u003e\n\n";
									  document.getElementById('watch-player').innerHTML = swf;
									})()
								</script>
								<div id="watch-video-extra">
								</div>
								-->
								<video style="background-color: black;" controls width="640" height="400" src="/dynamic/videos/<?php echo $_video['filename']; ?>">
							</div>
						</div>
						<!-- begin watch-main-container -->
						<div id="watch-main-container">
							<div id="watch-main">
								<div id="watch-panel">
									<div class="yt-alert yt-alert-default yt-alert-warn hid " id="flash10-promo-div">
										<div class="yt-alert-icon">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
										</div>
										<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
										<div class="yt-alert-content" role="alert">
											<span class="yt-alert-vertical-trick"></span>
											<div class="yt-alert-message">
												Upgrade to the latest Flash Player for improved playback performance. <a href="http://www.adobe.com/go/getflashplayer/" onmousedown="urchinTracker('/Events/VideoWatch/GetFlashUpgrade');">Upgrade now</a> or <a href="//support.google.com/youtube/bin/answer.py?answer=95402">more info</a>.
											</div>
										</div>
									</div>
									<div id="watch-actions">
										<div id="watch-actions-right">
											<span class="watch-view-count">
											<strong><?php echo $__video_h->fetch_video_views($_video['rid']); ?></strong>
											</span>
											<button onclick=";return false;" title="Show video statistics" type="button" id="watch-insight-button" class="yt-uix-tooltip yt-uix-tooltip-reverse yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" data-button-action="yt.www.watch.actions.stats" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-insight" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Show video statistics"><span class="yt-valign-trick"></span></span></button>
										</div>
										<span id="watch-like-unlike" class="yt-uix-button-group " data-button-toggle-group="optional">
											<button onclick=";window.location.href=this.getAttribute('href');return false;"
											title="I like this" 
											type="button" 
											class="start <?php if($_video['liked']) { echo "liked "; } ?>yt-uix-tooltip-reverse  yt-uix-button yt-uix-button-default yt-uix-tooltip" 
											id="watch-like"  
											href="/get/like_video?v=<?php echo $_video['rid']; ?>"
											role="button"><span class="yt-uix-button-icon-wrapper">
												<img class="yt-uix-button-icon yt-uix-button-icon-watch-like" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="I like this">
												<span class="yt-valign-trick"></span></span><span class="yt-uix-button-content">Like </span>
											</button>
											
											<button 
											onclick=";window.location.href=this.getAttribute('href');return false;"
											title="I dislike this" 
											type="button" 
											style="margin-left: -2px;"
											href="/get/dislike_video?v=<?php echo $_video['rid']; ?>"
											class="end yt-uix-tooltip-reverse <?php if($_video['disliked']) { echo "unliked "; } ?>  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" 
											id="watch-unlike" 
											role="button">
												<span class="yt-uix-button-icon-wrapper">
													<img class="yt-uix-button-icon yt-uix-button-icon-watch-unlike" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="I dislike this">
													<span class="yt-valign-trick"></span>
												</span>
											</button></span>
										<button type="button" class="yt-uix-tooltip-reverse  yt-uix-button yt-uix-button-default yt-uix-tooltip" onclick=";return false;" title="Add to favorites or playlist" data-upsell="playlist" data-button-action="yt.www.watch.actions.addto" role="button"><span class="yt-uix-button-content"><span class="addto-label">Add to</span> </span></button>
										<button onclick=";return false;" title="Share or embed this video" type="button" class="yt-uix-tooltip-reverse yt-uix-button yt-uix-button-default yt-uix-tooltip" id="watch-share" data-button-action="yt.www.watch.actions.share" role="button"><span class="yt-uix-button-content">Share </span></button>
										<button onclick=";return false;" title="Flag as inappropriate" type="button" class="yt-uix-tooltip-reverse  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" id="watch-flag" data-button-action="yt.www.watch.actions.flag" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-flag" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Flag as inappropriate"><span class="yt-valign-trick"></span></span></button>
									</div>
									<div id="watch-actions-area-container" class="hid">
										<div id="watch-actions-area" class="yt-rounded">
											<div id="watch-actions-loading" class="watch-actions-panel hid">
												Loading...
											</div>
											<div id="watch-actions-logged-out" class="watch-actions-panel hid">
												<div class="yt-alert yt-alert-naked yt-alert-warn  ">
													<div class="yt-alert-icon">
														<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
													</div>
													<div class="yt-alert-content" role="alert">
														<span class="yt-alert-vertical-trick"></span>
														<div class="yt-alert-message">
															<strong><a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dlike%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fwatch%253Fv%253D<?php echo htmlspecialchars($_video['rid']); ?>%2526feature%253Dg-logo-xit&amp;uilel=3&amp;hl=en_US&amp;service=youtube">Sign in</a> or <a href="/signup?next=%2Fwatch%3Fv%3D<?php echo htmlspecialchars($_video['rid']); ?>%26feature%3Dg-logo-xit">sign up</a> now!
															</strong>
														</div>
													</div>
												</div>
											</div>
											<div id="watch-actions-error" class="watch-actions-panel hid">
												<div class="yt-alert yt-alert-naked yt-alert-error  ">
													<div class="yt-alert-icon">
														<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
													</div>
													<div class="yt-alert-content" role="alert" id="watch-error-string"></div>
												</div>
											</div>
											<div id="watch-actions-addto" class="watch-actions-panel hid"></div>
											<div id="watch-actions-share" class="watch-actions-panel hid">
												<div id="watch-actions-share-loading">
													Loading...
												</div>
												<div id="watch-actions-share-panel" class="hid"></div>
											</div>
											<div id="watch-actions-ajax" class="watch-actions-panel hid"></div>
											<div class="close">
												<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="close-button" onclick="yt.www.watch.actions.hide();">
											</div>
										</div>
									</div>
									<div id="watch-info">
										<div id="watch-description" class="yt-uix-expander  yt-uix-expander-collapsed" data-expander-action="yt.www.watch.watch5.handleToggleDescription">
											<div id="watch-description-clip">
												<p id="watch-uploader-info">
													Published on <span id="eow-date" class="watch-video-date"><?php echo date("M d, Y", strtotime($_video['publish'])); ?></span> by     <a href="/user/<?php echo htmlspecialchars($_video['author']); ?>" class="yt-uix-sessionlink yt-user-name author" rel="author" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" dir="ltr"><?php echo htmlspecialchars($_video['author']); ?></a>
												</p>
												<div id="watch-description-text">
													<p id="eow-description"><?php echo $__video_h->shorten_description($_video['description'], 400000, true); ?></p>
												</div>
												<div id="watch-description-extras">
													<h4>
														Category:
													</h4>
													<p id="eow-category"><a href="/videos?c=<?php echo htmlspecialchars($_video['category']); ?>"><?php echo htmlspecialchars($_video['category']); ?></a></p>
													<h4>License:</h4>
													<p id="eow-reuse">
														None
													</p>
												</div>
											</div>
											<ul id="watch-description-extra-info">
												<li>
													<div class="video-extras-sparkbars">
														<div class="video-extras-sparkbar-likes" style="width: <?php echo $_video['likeswidth']; ?>%"></div>
														<div class="video-extras-sparkbar-dislikes" style="width: <?php echo $_video['dislikeswidth']; ?>%"></div>
													</div>
													<span class="video-extras-likes-dislikes">
													<span class="likes"><?php echo $_video['likes']; ?></span> likes, <span class="dislikes"><?php echo $_video['dislikes']; ?></span> dislikes
													</span>
												</li>
											</ul>
											<div class="yt-horizontal-rule "><span class="first"></span><span class="second"></span><span class="third"></span></div>
											<div id="watch-description-toggle" class="yt-uix-expander-head">
												<div id="watch-description-expand" class="expand">
													<button type="button" class="metadata-inline yt-uix-button yt-uix-button-text" onclick=";return false;" role="button"><span class="yt-uix-button-content">Show more <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Show more">
													</span></button>
												</div>
												<div id="watch-description-collapse" class="collapse">
													<button type="button" class="metadata-inline yt-uix-button yt-uix-button-text" onclick=";return false;" role="button"><span class="yt-uix-button-content">Show less <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Show less">
													</span></button>
												</div>
											</div>
										</div>
									</div>
									<div id="watch-discussion">
										<div style="display: none"><iframe src="https://plus.google.com/_/s/c2?first_party_property=YOUTUBE&amp;href=http%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D<?php echo htmlspecialchars($_video['rid']); ?>&amp;yt_owner_id=<?php echo htmlspecialchars($_video['author']); ?>"></iframe></div>
										<div id="comments-view" data-type="highlights" class="">
											<div id="comment-share-area" class="comment-share-area yt-rounded hid">
												<div class="comment-share-content">
													<h4>Link to this comment:</h4>
													<div>
														<input type="text" class="comment-share-url yt-uix-form-input-text">
													</div>
													<div>
														<span>Share to:</span>
														<img alt="" title="Facebook" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon-comment-share icon-comment-share-facebook" action="yt.window.popup('http:\/\/www.facebook.com\/sharer.php?u=http%3A%2F%2Fwww.youtube.com%2Fcomment%3Flc%3D_COMMENT_ID_&amp;t=_COMMENT_TEXT_', {height:440, width:620, scrollbars:true});">
														<img alt="" title="Twitter" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon-comment-share icon-comment-share-twitter" action="yt.window.popup('http:\/\/twitter.com\/share?url=http%3A%2F%2Fwww.youtube.com%2Fcomment%3Flc%3D_COMMENT_ID_&amp;text=_COMMENT_TEXT_%3A&amp;via=youtube', {height:650, width:1024, scrollbars:true});">
														<img alt="" title="Google+" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon-comment-share icon-comment-share-googleplus" action="yt.window.popup('https:\/\/plus.google.com\/share?url=http%3A%2F%2Fwww.youtube.com%2Fcomment%3Flc%3D_COMMENT_ID_&amp;source=yt', {height:620, width:620, scrollbars:true});">
													</div>
												</div>
												<div class="close comment-action" data-action="close-share">
													<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="close-button">
												</div>
											</div>
											<?php 
												$stmt = $__db->prepare("SELECT * FROM video_response WHERE toid = :v ORDER BY id DESC LIMIT 4");
												$stmt->bindParam(":v", $_GET['v']);
												$stmt->execute();
											?>

											<?php if($stmt->rowCount() != 0) { ?>
												<div class="comments-section">
													<a class="comments-section-see-all" href="/video_response_view_all?v=<?php echo htmlspecialchars($_video['rid']); ?>">
													see all
													</a>
													<h4>Video Responses</h4>
													<ul class="video-list">
													<?php 
														while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
															if($__video_h->video_exists($video['video'])) { 
																$video = $__video_h->fetch_video_rid($video['video']);
																$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
																$video['duration'] = $__time_h->timestamp($video['duration']);
																$video['views'] = $__video_h->fetch_video_views($video['rid']);
																$video['author'] = htmlspecialchars($video['author']);		
																$video['title'] = htmlspecialchars($video['title']);
																$video['description'] = $__video_h->shorten_description($video['description'], 50);
													?>
														<li class="video-list-item yt-tile-default">
															<a href="/watch?v=<?php echo $video['rid']; ?>" class="related-video yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>&amp;feature=watch_response"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
															<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="cjls0QsHOBE" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
															</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
															</span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat attribution">by <span class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></span></span><span class="stat view-count"><?php echo $video['views']; ?> views</span></a>
														</li>
													<?php } } ?>
													</ul>
												</div>
											<?php } ?>
											<div class="comments-section " onmouseover="if (yt.www &amp;&amp; yt.www.watch &amp;&amp; yt.www.watch.livecomments) yt.www.watch.livecomments.handleCommentMouseEvent(this, event);" onmouseout="if (yt.www &amp;&amp; yt.www.watch &amp;&amp; yt.www.watch.livecomments) yt.www.watch.livecomments.handleCommentMouseEvent(this, event);">
												<div id="comments-header-container">
													<div id="comments-header">
														<a class="comments-section-see-all" href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>">
														see all
														</a>
														<h4>
															All Comments
															<span class="comments-section-stat">(<?php echo $_video['comments']; ?>)</span>
														</h4>
													</div>
												</div>
												<?php if(!isset($_SESSION['siteusername'])) { ?>
													<div class="comments-post-container clearfix">
														<div class="comments-post-alert">
															<a href="/sign_in">Sign In</a> or <a href="/sign_up">Sign Up</a><span class="comments-post-form-rollover-text"> now to post a comment!</span>
														</div>
													</div>
												<?php } else if($_video['commenting'] == "d") { ?>
													<div class="comments-post-container clearfix">
														<div class="comments-post-alert">
															This video has comemnting disabled!
														</div>
													</div>
												<?php } else if($__user_h->if_blocked($_video['author'], $_SESSION['siteusername'])) { ?>
													<div class="comments-post-container clearfix">
														<div class="comments-post-alert">
															This user has blocked you!
														</div>
													</div>
												<?php } else { ?>
													<div class="comments-post-container clearfix">
														<form class="comments" method="post" action="/watch?v=<?php echo $_GET['v']; ?>">
															<div class="yt-alert yt-alert-default yt-alert-error hid comments-post-message">
																<div class="yt-alert-icon">
																	<img src="./intro to RUCA - YouTube_files/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
																</div>
																<div class="yt-alert-buttons"></div>
																<div class="yt-alert-content" role="alert"></div>
															</div>
															<input type="hidden" name="form_id" value="">
															<input type="hidden" name="source" value="w">
															<input type="hidden" value="" name="reply_parent_id">
															<a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" class="yt-user-photo comments-post-profile"><span class="video-thumb ux-thumb yt-thumb-square-46 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" alt="<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" width="46"><span class="vertical-align"></span></span></span></span></a>
															<div class="comments-textarea-container" onclick="yt.www.comments.initForm(this, true, false);">
																<img src="./intro to RUCA - YouTube_files/pixel-vfl3z5WfW.gif" alt="" class="comments-textarea-tip"><label class="comments-textarea-label" data-upsell="comment">Respond to this video...</label>  
																<div class="yt-uix-form-input-fluid yt-grid-fluid ">
																	<textarea id="" class="yt-uix-form-textarea comments-textarea" onfocus="yt.www.comments.initForm(this, false, false);" data-upsell="comment" name="comment"></textarea>
																</div>
															</div>
															<p class="comments-remaining">
																<span class="comments-remaining-count" data-max-count="500"></span> characters remaining
															</p>
															<p class="comments-threshold-countdown hid">
																<span class="comments-threshold-count"></span> seconds remaining before you can post
															</p>
															<p class="comments-post-buttons">
																<span class="comments-post-video-response-link"><a href="/video_response_upload?v=<?php echo $_GET['v']; ?>">Create a video response</a>&nbsp;or&nbsp;</span><button type="submit" class="comments-post yt-uix-button yt-uix-button-default" role="button"><span class="yt-uix-button-content">Post </span></button>    
															</p>
														</form>
													</div>
												<?php } ?><br>
												<div id="live-comments-setting-scroll" class="live-comments-setting hid">
													<span id="live-comments-count"></span>
													<a onclick="yt.www.watch.livecomments.setScroll(true); return false;">Update automatically</a>
												</div>
												<div id="live-comments-setting-no-scroll" class="live-comments-setting hid">
													<a onclick="yt.www.watch.livecomments.setScroll(false); return false;">Disable automatic updates</a>
												</div>
												<ul class="comment-list" id="live_comments">
														<?php
														$results_per_page = 20;

														$stmt = $__db->prepare("SELECT * FROM comments WHERE toid = :rid ORDER BY id DESC");
														$stmt->bindParam(":rid", $_video['rid']);
														$stmt->execute();

														$number_of_result = $stmt->rowCount();
														$number_of_page = ceil ($number_of_result / $results_per_page);  

														if (!isset ($_GET['page']) ) {  
															$page = 1;  
														} else {  
															$page = (int)$_GET['page'];  
														}  

														$page_first_result = ($page - 1) * $results_per_page;  

														$stmt = $__db->prepare("SELECT * FROM comments WHERE toid = :rid ORDER BY id DESC LIMIT :pfirst, :pper");
														$stmt->bindParam(":rid", $_video['rid']);
														$stmt->bindParam(":pfirst", $page_first_result);
														$stmt->bindParam(":pper", $results_per_page);
														$stmt->execute();

														while($comment = $stmt->fetch(PDO::FETCH_ASSOC)) { 
													?>

													<li class="comment yt-tile-default " data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="HdQrMeklJ_5hd_uPDRcvtdaMk2pMVS8d9sufcfiGx0U" data-score="0">
														<div class="comment-body">
															<div class="content-container">
																<div class="content">
																	<div class="comment-text" dir="ltr">
																		<p><?php echo $__video_h->shorten_description($comment['comment'], 3000, true); ?></p>
																	</div>
																	<p class="metadata">
																		<span class="author ">
																		<a href="/user/<?php echo htmlspecialchars($comment['author']); ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="<?php echo htmlspecialchars($comment['author']); ?>" dir="ltr"><?php echo htmlspecialchars($comment['author']); ?></a>
																		</span>
																		<span class="time" dir="ltr">
																		<span dir="ltr"><?php echo $__time_h->time_elapsed_string($comment['date']); ?><span>
																		</span>
																		</span></span>
																	</p>
																</div>
																<div class="comment-actions">
																	<span class="yt-uix-button-group"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span>
																	<span class="yt-uix-button-group">
																		<button type="button" class="start comment-action yt-uix-button yt-uix-button-default" onclick=";return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply </span></button>
																		<button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant="">
																			<img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
																			<div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;">
																				<ul>
																					<li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li>
																					<li class="comment-action-remove comment-action" data-action="remove"><span class="yt-uix-button-menu-item">Remove</span></li>
																					<li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li>
																					<li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li>
																					<li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li>
																				</ul>
																			</div>
																		</button>
																	</span>
																</div>
															</div>
														</div>
													</li>
													<?php } ?>
												</ul>
											</div>
											<div class="comments-section">
												<!--
												<div class="comments-pagination" data-ajax-enabled="true">
													<div class="yt-uix-pager" role="navigation">
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=1" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button yt-uix-button-toggled yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="1" aria-label="Go to page 1"><span class="yt-uix-button-content">1</span></a>&nbsp;
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=2" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="2" aria-label="Go to page 2"><span class="yt-uix-button-content">2</span></a>&nbsp;
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=3" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="3" aria-label="Go to page 3"><span class="yt-uix-button-content">3</span></a>&nbsp;
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=4" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="4" aria-label="Go to page 4"><span class="yt-uix-button-content">4</span></a>&nbsp;
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=5" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="5" aria-label="Go to page 5"><span class="yt-uix-button-content">5</span></a>&nbsp;
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=6" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="6" aria-label="Go to page 6"><span class="yt-uix-button-content">6</span></a>&nbsp;
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=7" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="7" aria-label="Go to page 7"><span class="yt-uix-button-content">7</span></a>&nbsp;
														<a href="/all_comments?v=<?php echo htmlspecialchars($_video['rid']); ?>&amp;page=2" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-next yt-uix-pager-button yt-uix-button-default" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" data-page="2"><span class="yt-uix-button-content">Next »</span></a>&nbsp;
													</div>
												</div>
														-->
											</div>
											<ul>
												<li class="hid" id="parent-comment-loading"> Loading comment...</li>
											</ul>
											<div id="comments-loading" class="hid">Loading...</div>
										</div>
									</div>
								</div>
								<div id="watch-sidebar">
									<div id="watch-channel-brand-div" style="display: none;" class="watch-sidebar-section">
										<div id="ad300x250" class="alignR"></div>
										<div id="google_companion_ad_div" class="alignR"></div>
										<div style="padding-top: 3px; display:none;">
											Advertisement
										</div>
									</div>
									<div class="watch-sidebar-section">
										<div id="watch-related-container" class="watch-sidebar-body">
											<ul id="watch-related" class="video-list">
												<div id="ppv-container" class="hid"></div>
												<?php
													$stmt = $__db->prepare("SELECT * FROM videos ORDER BY rand() LIMIT 20");
													$stmt->execute();
													while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
														$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
														$video['duration'] = $__time_h->timestamp($video['duration']);
														$video['views'] = $__video_h->fetch_video_views($video['rid']);
														$video['author'] = htmlspecialchars($video['author']);		
														$video['title'] = htmlspecialchars($video['title']);
														$video['description'] = $__video_h->shorten_description($video['description'], 50);
												?>
												<li class="video-list-item"><a href="/watch?v=<?php echo $video['rid']; ?>" class="related-video yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="ved=CAIQzRooAA%3D%3D&amp;<?php echo htmlspecialchars($_video['author']); ?>&amp;feature=relmfu"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
													<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions addto-watch-later-button-sign-in yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="gyAaIKF6tSQ" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
													</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
													</span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat attribution">by <span class="yt-user-name " dir="ltr"><?php echo htmlspecialchars($video['author']); ?></span></span><span class="stat view-count"><?php echo $video['views']; ?> views</span></a>
												</li>
												<?php } ?>
											</ul>
											<ul id="watch-more-related" class="video-list hid">
												<li id="watch-more-related-loading">Loading more suggestions...</li>
											</ul>
										</div>
										<div class="watch-sidebar-foot">
											<p class="content"><button type="button" id="watch-more-related-button" onclick=";return false;" class=" yt-uix-button yt-uix-button-default" data-button-action="yt.www.watch.watch5.handleLoadMoreRelated" role="button"><span class="yt-uix-button-content">Load more suggestions </span></button></p>
										</div>
									</div>
									<span class="yt-vertical-rule-main"></span>
									<span class="yt-vertical-rule-corner-top"></span>
									<span class="yt-vertical-rule-corner-bottom"></span>
								</div>
								<div class="clear"></div>
							</div>
							<div style="visibility: hidden; height: 0px; padding: 0px; overflow: hidden;">
								<img src="//www.youtube-nocookie.com/gen_204?attributionpartner=machinima" width="1" height="1" border="0">
							</div>
						</div>
						<!-- end watch-main-container -->
					</div>
				</div>
				<!-- end content -->
			</div>
			<div id="footer-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/footer.php") ?></div>
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
									<li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fwatch%253Fv%253D<?php echo htmlspecialchars($_video['rid']); ?>%2526feature%253Dg-logo-xit&amp;uilel=3&amp;hl=en_US&amp;service=youtube">sign in</a> to load a different list.</li>
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
						<!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__" class="yt-uix-sessionlink" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>&amp;feature=BFa"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
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
				<a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fwatch%253Fv%253D<?php echo htmlspecialchars($_video['rid']); ?>%2526feature%253Dg-logo-xit&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
			</div>
			<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
				<div class="addto-menu">
					<div id="addto-list-panel" class="menu-panel active-panel">
						<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fwatch%253Fv%253D<?php echo htmlspecialchars($_video['rid']); ?>%2526feature%253Dg-logo-xit&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
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
			'XSRF_TOKEN': 'sWZ0733z73lb8fEYAYSd84MaNV98MTM0OTEzMDExNUAxMzQ5MDQzNzE1',
			'XSRF_FIELD_NAME': 'session_token'
			});
			yt.pubsub.subscribe('init', yt.www.xsrf.populateSessionToken);
			
			yt.setConfig('XSRF_REDIRECT_TOKEN', '08fYRr2a9pjbx2VYZhoZtyl-4lh8MTM0OTEzMDExNUAxMzQ5MDQzNzE1');
			
			yt.setConfig({
			'EVENT_ID': "CJuY27ur3rICFaL4OgodEHRznw==",
			'CURRENT_URL': "http:\/\/www.youtube.com\/watch?v=<?php echo htmlspecialchars($_video['rid']); ?>\u0026feature=g-logo-xit",
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
			  yt.playerConfig = {"assets": {"html": "\/html5_player_template", "css": "http:\/\/s.ytimg.com\/yt\/cssbin\/www-player-vfl6Vk7Gd.css", "js": "http:\/\/s.ytimg.com\/yt\/jsbin\/html5player-vfll6vNym.js"}, "url": "http:\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vflrx8gtr.swf", "min_version": "8.0.0", "args": {"account_playback_token": "", "ptk": "machinima", "enablecsi": "1", "iv_close_button": 0, "mpvid": "AATK8rd3hYr5XSL9", "autohide": "2", "csi_page_type": "watch5ad", "keywords": "yt:crop=4:3,Firefight,taliban,ambush,Army,Military,shot,machine,gun", "cr": "US", "host_language": "en", "iv3_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/iv3_module-vflEMFREp.swf", "ad_flags": 0, "fmt_list": "45\/1280x720\/99\/0\/0,22\/1280x720\/9\/0\/115,44\/854x480\/99\/0\/0,35\/854x480\/9\/0\/115,43\/640x360\/99\/0\/0,34\/640x360\/9\/0\/115,18\/640x360\/9\/0\/115,5\/320x240\/7\/0\/0,36\/320x240\/99\/0\/0,17\/176x144\/99\/0\/0", "platform": null, "loeid": "906717,901803,907354,904448,901424", "invideo": true, "afv_ad_tag": "http:\/\/googleads.g.doubleclick.net\/pagead\/ads?description_url=http%3A%2F%2Fwww.youtube.com%2Fvideo%2F<?php echo htmlspecialchars($_video['rid']); ?>\u0026ht_id=464885\u0026video_cpm=6000000\u0026ad_type=skippablevideo\u0026loeid=906717%2C901803%2C907354%2C904448%2C901424\u0026host=ca-host-pub-6813290291914109\u0026client=ca-pub-6219811747049371\u0026hl=en\u0026max_ad_duration=15000\u0026channel=afv_instream%2CVertical_397%2CVertical_881%2Cafv_instream_us%2Cafv_user_funker530%2Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%2Cyt_mpvid_AATK8rd3hYr5XSL9%2Cyt_cid_676%2Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%2Cytps_default%2Cytel_detailpage", "tk": "pluFCw5PmNPcKWZJHaDotXzHY_eAKpMxHA0FIGLWpvnrxAWhNVwaaw==", "sffb": true, "ad_channel_code_instream": "afv_instream,Vertical_397,Vertical_881,afv_instream_us,afv_user_funker530,afv_user_id_<?php echo htmlspecialchars($_video['author']); ?>,yt_mpvid_AATK8rd3hYr5XSL9,yt_cid_676,ytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816,ytps_default,ytel_detailpage", "sdetail": "f:g-logo-xit,p:\/", "url_encoded_fmt_stream_map": "itag=45\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dcp%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26expire%3D1349068425%26itag%3D45%26ipbits%3D8%26gcr%3Dus%26sver%3D3%26ratebypass%3Dyes%26mt%3D1349043671%26ip%3D98.114.43.169%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fwebm%3B+codecs%3D%22vp8.0%2C+vorbis%22\u0026fallback_host=tc.v11.cache3.c.youtube.com\u0026sig=4D0B68C89CD0F30F64C7E040D12F2028A1F2D1E6.A167CCC00C7BEBAD022A63BFE6216147BDBF40CE\u0026quality=hd720,itag=22\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dcp%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26expire%3D1349068425%26itag%3D22%26ipbits%3D8%26gcr%3Dus%26sver%3D3%26ratebypass%3Dyes%26mt%3D1349043671%26ip%3D98.114.43.169%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fmp4%3B+codecs%3D%22avc1.64001F%2C+mp4a.40.2%22\u0026fallback_host=tc.v17.cache8.c.youtube.com\u0026sig=BA6118048C09BA1B2703900C99207338AF612392.63ABCB15F1835342EA2B20B61401016FE6C60647\u0026quality=hd720,itag=44\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dcp%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26expire%3D1349068425%26itag%3D44%26ipbits%3D8%26gcr%3Dus%26sver%3D3%26ratebypass%3Dyes%26mt%3D1349043671%26ip%3D98.114.43.169%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fwebm%3B+codecs%3D%22vp8.0%2C+vorbis%22\u0026fallback_host=tc.v5.cache8.c.youtube.com\u0026sig=82417ED76D17D4D880D76A3CFA4A7B49B799E056.49880E4AC9834DF3CC3438F2F43C028BA2813862\u0026quality=large,itag=35\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26algorithm%3Dthrottle-factor%26burst%3D40%26ip%3D98.114.43.169%26itag%3D35%26gcr%3Dus%26sver%3D3%26mt%3D1349043671%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26expire%3D1349068425%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fx-flv\u0026fallback_host=tc.v19.cache1.c.youtube.com\u0026sig=55B0162403D6C46EC083BFCB344505AF35EEF01F.9FF2FCCA4B674C63E492DBAFA0F519777318B08E\u0026quality=large,itag=43\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dcp%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26expire%3D1349068425%26itag%3D43%26ipbits%3D8%26gcr%3Dus%26sver%3D3%26ratebypass%3Dyes%26mt%3D1349043671%26ip%3D98.114.43.169%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fwebm%3B+codecs%3D%22vp8.0%2C+vorbis%22\u0026fallback_host=tc.v6.cache7.c.youtube.com\u0026sig=9A1F563BE6D0EEE47E0095CFBEE32F68304BE27C.8E00D30F94B572E9306D6CFE60B545279B2AEEF7\u0026quality=medium,itag=34\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26algorithm%3Dthrottle-factor%26burst%3D40%26ip%3D98.114.43.169%26itag%3D34%26gcr%3Dus%26sver%3D3%26mt%3D1349043671%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26expire%3D1349068425%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fx-flv\u0026fallback_host=tc.v9.cache5.c.youtube.com\u0026sig=4C7A33428D93B260BDD36407C89B82AE269AE2CE.5EF06FF4AAF1E3584C48717A8033720F37746B12\u0026quality=medium,itag=18\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dcp%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26expire%3D1349068425%26itag%3D18%26ipbits%3D8%26gcr%3Dus%26sver%3D3%26ratebypass%3Dyes%26mt%3D1349043671%26ip%3D98.114.43.169%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fmp4%3B+codecs%3D%22avc1.42001E%2C+mp4a.40.2%22\u0026fallback_host=tc.v12.cache5.c.youtube.com\u0026sig=1511F1115B1EB94452A28F71FF143B617DF2EB51.CB6CE4A5885735A2FA2625E632D4CCA0744F2DC7\u0026quality=medium,itag=5\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26algorithm%3Dthrottle-factor%26burst%3D40%26ip%3D98.114.43.169%26itag%3D5%26gcr%3Dus%26sver%3D3%26mt%3D1349043671%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26expire%3D1349068425%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2Fx-flv\u0026fallback_host=tc.v10.cache5.c.youtube.com\u0026sig=5340EDCCB38578F4C44F10600D41FA8CA2078DD7.02AABD135EB44084237C9D5C8410F4F48D6CAC18\u0026quality=small,itag=36\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26algorithm%3Dthrottle-factor%26burst%3D40%26ip%3D98.114.43.169%26itag%3D36%26gcr%3Dus%26sver%3D3%26mt%3D1349043671%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26expire%3D1349068425%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2F3gpp%3B+codecs%3D%22mp4v.20.3%2C+mp4a.40.2%22\u0026fallback_host=tc.v15.cache6.c.youtube.com\u0026sig=4C5B60BD483DA710FBA1457946FF9DC7A68CAE8E.CB4186AC20FDFF30229C32A2C22F50EC593D7EC5\u0026quality=small,itag=17\u0026url=http%3A%2F%2Fo-o---preferred---sn-ab5e6nl7---v9---lscache5.c.youtube.com%2Fvideoplayback%3Fupn%3DBiwYGDaJ9qA%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cgcr%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D906717%252C901803%252C907354%252C904448%252C901424%252C922401%252C920704%252C912806%252C913419%252C913546%252C913556%252C919349%252C919351%252C925109%252C919003%252C912706%252C900816%26ms%3Dau%26algorithm%3Dthrottle-factor%26burst%3D40%26ip%3D98.114.43.169%26itag%3D17%26gcr%3Dus%26sver%3D3%26mt%3D1349043671%26mv%3Dm%26source%3Dyoutube%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hTTlBRVl9HT0NOM19IS1pFOlJDcUxlRUdEVzZK%26expire%3D1349068425%26id%3Dacb1d4fbf3a14fc8%26newshard%3Dyes\u0026type=video%2F3gpp%3B+codecs%3D%22mp4v.20.3%2C+mp4a.40.2%22\u0026fallback_host=tc.v8.cache2.c.youtube.com\u0026sig=B059261056F959A2BE9C6D25B4D4592E2E805418.0B8D5EADD055CCE96C746129629F4F13AF72D7CD\u0026quality=small", "cafe_experiment_id": 56702370, "sourceid": "y", "timestamp": 1349043715, "storyboard_spec": "http:\/\/i3.ytimg.com\/sb\/<?php echo htmlspecialchars($_video['rid']); ?>\/storyboard3_L$L\/$N.jpg|48#27#100#10#10#0#default#guov8K5GbEijp3_mWvQCsC8b3KU|80#45#106#10#10#2000#M$M#2-rhosBWAp4uX752TX50_OeoZ8U|160#90#106#5#5#2000#M$M#rQ5-ZvOHqaxICOVmMBTz4zcKL2o", "iv_load_policy": 1, "ad_host": "ca-host-pub-6813290291914109", "ad_eurl": "http:\/\/www.youtube.com\/video\/<?php echo htmlspecialchars($_video['rid']); ?>", "showpopout": 1, "mpu": true, "hl": "en_US", "tmi": "1", "iv_logging_level": 4, "st_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/st_module-vflBfOYbW.swf", "no_get_video_log": "1", "endscreen_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/endscreen-vflFXd--E.swf", "iv_read_url": "http:\/\/www.youtube.com\/annotations_iv\/read2?sparams=expire%2Cvideo_id\u0026expire=1349087040\u0026key=a1\u0026signature=927C3067D1CF3C5696A672D838EA4519F6D9DC9B.703A7169FB065EBDDDBECD18F78FE056AD8DEAAA\u0026video_id=<?php echo htmlspecialchars($_video['rid']); ?>\u0026feat=CS", "cid": 676, "referrer": "http:\/\/www.youtube.com\/?tab=yy", "ad_channel_code_overlay": "invideo_overlay_480x70_cat25,afv_overlay,Vertical_397,Vertical_881,afv_user_funker530,afv_user_id_<?php echo htmlspecialchars($_video['author']); ?>,yt_mpvid_AATK8rd3hYr5XSL9,yt_cid_676,ytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816,ytps_default,ytel_detailpage", "afv_instream_max": 15000, "pyv_in_related_cafe_experiment_id": 56702372, "t": "vjVQa1PpcFMS6aQZETnG-Y9CUzspv2S9Oh2KkE16-Rw=", "afv_ad_tag_restricted_to_instream": "http:\/\/googleads.g.doubleclick.net\/pagead\/ads?description_url=http%3A%2F%2Fwww.youtube.com%2Fvideo%2F<?php echo htmlspecialchars($_video['rid']); ?>\u0026ht_id=464885\u0026video_cpm=6000000\u0026ad_type=skippablevideo\u0026loeid=906717%2C901803%2C907354%2C904448%2C901424\u0026host=ca-host-pub-6813290291914109\u0026client=ca-pub-6219811747049371\u0026hl=en\u0026max_ad_duration=15000\u0026channel=afv_instream%2CVertical_397%2CVertical_881%2Cafv_instream_us%2Cafv_user_funker530%2Cafv_user_id_<?php echo htmlspecialchars($_video['author']); ?>%2Cyt_mpvid_AATK8rd3hYr5XSL9%2Cyt_cid_676%2Cytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816%2Cytps_default%2Cytel_detailpage", "fexp": "906717,901803,907354,904448,901424,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,912706,900816", "no_afv_instream": "1", "shortform": true, "dclk": true, "inactive_skippable_threshold": 600000, "allow_embed": 1, "ad_host_tier": "464885", "rvs": "view_count=643%2C930\u0026author=<?php echo htmlspecialchars($_video['author']); ?>\u0026length_seconds=154\u0026id=gyAaIKF6tSQ\u0026title=MINIGUN+SPECIAL+FORCES+FIREFIGHT+IN+AFGHANISTAN,view_count=304%2C638\u0026author=<?php echo htmlspecialchars($_video['author']); ?>\u0026length_seconds=98\u0026id=p9Lx3dODzd4\u0026title=M777+Howitzers+Engage+Firing+Position+in+Afghanistan,view_count=46%2C578\u0026author=<?php echo htmlspecialchars($_video['author']); ?>\u0026length_seconds=82\u0026id=Sqz5P4d-azM\u0026title=Breaking+The+Silence+%7C+Episode+4,view_count=256%2C886\u0026author=<?php echo htmlspecialchars($_video['author']); ?>\u0026length_seconds=177\u0026id=PeqZPjuLtlw\u0026title=Airstrike+in+Aghanistan+-+3+JDAM+TACP,view_count=15%2C691\u0026author=BuddhaCharlieShow\u0026length_seconds=92\u0026id=vt2bdWh3BPM\u0026title=US+Soldier+Survives+Taliban+Machine+Gun+Fire+During+Firefight+My+Thoughts,view_count=1%2C406%2C236\u0026author=Nighthawkinlight\u0026length_seconds=183\u0026id=r_8wRpgvhyg\u0026title=How+to+Make+an+Airsoft+Machine+Gun+from+a+Soda+Bottle,view_count=828%2C367\u0026author=Dqwon\u0026length_seconds=285\u0026id=00PdHIPjaWQ\u0026title=Portishead+-+Machine+Gun,view_count=465%2C071\u0026author=AmericanCountryMan\u0026length_seconds=206\u0026id=7hPjatgRjL4\u0026title=%22taliban+song%22+-+toby+keith,view_count=254\u0026author=lloyd+young\u0026length_seconds=78\u0026id=a8YixbzpVgc\u0026title=US+Soldier+Survives+Taliban+Machine+Gun+Fire+During+Firefight,view_count=12%2C773%2C980\u0026author=FPSRussia\u0026length_seconds=312\u0026id=SNPJMk2fgJU\u0026title=Prototype+Quadrotor+with+Machine+Gun%21,view_count=1%2C104\u0026author=TheAquariusAlex\u0026length_seconds=389\u0026id=u5YE5DsT2E4\u0026title=Easy+%21+Mob+Grinder+Tutorial,view_count=1%2C800%2C418\u0026author=nikhilrohatgi\u0026length_seconds=296\u0026id=IA0kx9ZbOzI\u0026title=zakk+wylde+-+machine+gun+man+%28live%29", "vq": "auto", "yt_pt": "AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ", "excluded_ads": "2=2_2_1", "ad3_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/ad3-vflSndU9R.swf", "gut_tag": "\/4061\/ytpwatch\/main_676", "ptchn": "<?php echo htmlspecialchars($_video['author']); ?>", "ad_logging_flag": 1, "length_seconds": 209, "feature": "g-logo-xit", "enablejsapi": 1, "plid": "AATK8rd3IxlBnwIO", "iv_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/iv_module-vflQKTkFU.swf", "afv": true, "ad_tag": "http:\/\/ad-g.doubleclick.net\/N4061\/pfadx\/com.ytpwatch.newsandpolitics\/main_676;sz=WIDTHxHEIGHT;kvid=<?php echo htmlspecialchars($_video['rid']); ?>;kpu=<?php echo htmlspecialchars($_video['author']); ?>;kpid=676;u=<?php echo htmlspecialchars($_video['rid']); ?>|676;mpvid=AATK8rd3hYr5XSL9;plat=pc;kpeid=<?php echo htmlspecialchars($_video['author']); ?>;afct=site_content;afv=1;dc_dedup=1;k5=397_881;kbz=1;kclt=1;kcr=us;kga=-1;kgg=-1;klg=en;kmsrd=1;ko=p;kr=F;kt=K;kvz=205;shortform=1;tves=2;ytcat=25;ytexp=906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816;ytps=default;ytvt=w;!c=676;k2=397;k2=881;kvlg=en;", "ad_video_pub_id": "ca-pub-6219811747049371", "ad_slots": "0", "watermark": ",http:\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_watermark-vflHX6b6E.png,http:\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_hd_watermark-vflAzLcD6.png", "oid": "Ub4HVMaNS3_bFHc6MYUOiw", "afv_video_min_cpm": 6000000, "afv_inslate_ad_tag": "http:\/\/googleads.g.doubleclick.net\/pagead\/ads?description_url=http%3A%2F%2Fwww.youtube.com%2Fvideo%2F<?php echo htmlspecialchars($_video['rid']); ?>\u0026ht_id=464885\u0026ad_type=userchoice\u0026loeid=906717%2C901803%2C907354%2C904448%2C901424\u0026host=ca-host-pub-6813290291914109\u0026client=ca-pub-6219811747049371\u0026hl=en\u0026max_ad_duration=15000", "iv_queue_log_level": 0, "as_launched_in_country": "1", "title": "<?php echo htmlspecialchars($_video['title']); ?>", "sw": "0.1", "sk": "bGQU2KbiGvGxNpDhkR1VC_WZ9DAZFSYvC", "pltype": "content", "video_id": "<?php echo htmlspecialchars($_video['rid']); ?>"}, "url_v9as2": "http:\/\/s.ytimg.com\/yt\/swfbin\/cps-vfluwguGx.swf", "params": {"allowscriptaccess": "always", "allowfullscreen": "true", "bgcolor": "#000000"}, "attrs": {"width": "640", "id": "movie_player", "height": "390"}, "url_v8": "http:\/\/s.ytimg.com\/yt\/swfbin\/cps-vfluwguGx.swf", "html5": false};
			  yt.setConfig({
			'EMBED_HTML_TEMPLATE': "\u003ciframe width=\"__width__\" height=\"__height__\" src=\"__url__\" frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e",
			'EMBED_HTML_URL': "http:\/\/www.youtube.com\/embed\/__videoid__"
			});
			yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
			yt.setMsg('PLAYER_FALLBACK', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            The Adobe Flash Player or an HTML5 supported browser is required for video playback. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eGet the latest Flash Player\u003c\/a\u003e \u003cbr\u003e \u003ca href=\"\/html5\"\u003eLearn more about upgrading to an HTML5 browser\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
			yt.setMsg('QUICKTIME_FALLBACK', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            The Adobe Flash Player or QuickTime is required for video playback. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eGet the latest Flash Player\u003c\/a\u003e \u003cbr\u003e \u003ca href=\"http:\/\/www.apple.com\/quicktime\/download\/\"\u003eGet the latest version of QuickTime\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
			
			
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
			  'COMMENT_SHARE_URL': "http:\/\/www.youtube.com\/comment?lc=_COMMENT_ID_",
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
			'COMMENT_SHARE_URL': "http:\/\/www.youtube.com\/comment?lc=_COMMENT_ID_",
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
			yt.www.ads.pyv.loadPyvIframe("\n  \u003cscript\u003e\n    var google_max_num_ads = '1';\n    var google_ad_output = 'js';\n    var google_ad_type = 'text';\n    var google_only_pyv_ads = true;\n    var google_video_doc_id = \"yt_<?php echo htmlspecialchars($_video['rid']); ?>\";\n      var google_ad_request_done = parent.yt.www.ads.pyv.pyvWatchAfcWithPpvCallback;\n    var google_ad_client = 'ca-pub-6219811747049371';\n    var google_ad_block = '3';\n      var google_ad_host = \"ca-host-pub-6813290291914109\";\n      var google_ad_host_tier_id = \"464885\";\n      var google_page_url = \"http:\\\/\\\/www.youtube.com\\\/video\\\/<?php echo htmlspecialchars($_video['rid']); ?>\";\n      var google_ad_channel = \"PyvWatchInRelated+PyvYTWatch+PyvWatchNoAdX+pw+non_lpw+afv_user_funker530+afv_user_id_<?php echo htmlspecialchars($_video['author']); ?>+yt_mpvid_AATK8rd3hYr5XSL9+yt_cid_676+ytexp_906717.901803.907354.904448.901424.922401.920704.912806.913419.913546.913556.919349.919351.925109.919003.912706.900816\";\n      var google_language = \"en\";\n      var google_eids = ['56702372'];\n      var google_yt_pt = \"AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ\";\n  \u003c\/script\u003e\n\n  \u003cscript s\u0072c=\"\/\/pagead2.googlesyndication.com\/pagead\/show_ads.js\"\u003e\u003c\/script\u003e\n");
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
			window['google_alternate_ad_url'] = "http:\/\/www.youtube.com\/ad_frame?id=watch-channel-brand-div";
			window['google_yt_pt'] = "AD1B29l_Eb6GvswrtaJp3Xbg-8Cen9ZYRkIWEEZsAd6dGBgqPd1L2hDoHNZ3vsezXxxrRKglcrLrvmR_xDdeypbUNSFkZJs63DRNWYRvVQ";
			window['google_eids'] = ['56702371'];
			window['google_page_url'] = "http:\/\/www.youtube.com\/video\/<?php echo htmlspecialchars($_video['rid']); ?>";
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
			  window['google_page_url'] = "http:\/\/www.youtube.com\/video\/<?php echo htmlspecialchars($_video['rid']); ?>";
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
			    'alternate_ad_url': "http:\/\/www.youtube.com\/ad_frame?id=watch-channel-brand-div"
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
		<script>
			var subscribed = <?php echo($_video['subscribed'] ? 'true' : 'false') ?>;
			var loggedIn = <?php echo(isset($_SESSION['siteusername']) ? 'true' : 'false') ?>;
			var alerts = 0;
 
			function subscribe() {
				if(loggedIn == true) { 
					if(subscribed == false) { 
						$.ajax({
							url: "/get/subscribe?n=<?php echo htmlspecialchars($_video['author']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").addClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully added <?php echo htmlspecialchars($_video['author']); ?> to your subscriptions!");
								showAlert("#editsuccess_" + alerts);
								console.log("DEBUG: " + res);
								subscribed = true;
							}
						});
					} else {
						$.ajax({
							url: "/get/unsubscribe?n=<?php echo htmlspecialchars($_video['author']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").removeClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully removed <?php echo htmlspecialchars($_video['author']); ?> from your subscriptions!");
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
	</body>
</html>