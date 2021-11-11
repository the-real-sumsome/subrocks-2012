<?php
	if(isset($_SESSION['siteusername'])) {
        $stmt = $__db->prepare("UPDATE users SET ip = :ip WHERE username = :username");
        $stmt->bindParam(":username", $_SESSION['siteusername']);
		$stmt->bindParam(":ip",       $_SERVER["HTTP_CF_CONNECTING_IP"]);
        $stmt->execute();
	}
?>
<!-- begin masthead -->
<div id="masthead" class="" dir="ltr">
	<a id="logo-container" href="/" title="SubRocks home">
	<img id="logo" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="SubRocks home">
	</a>
	<?php if(!isset($_SESSION['siteusername'])) { ?>
	<div id="yt-masthead-signin">
		<div id="masthead-user-display"><span id="masthead-user-wrapper"><button href="/sign_in" type="button" id="masthead-user-button" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button yt-uix-button-text" role="button"><span class="yt-uix-button-content">  <span id="masthead-user-image">
			<span class="clip">
			<span class="clip-center">
				<img src="//s.ytimg.com/yts/img/silhouette48-vflLdu7sh.png" alt="">
				<span class="vertical-center"></span>
			</span>
			</span>
		</span>
		<span class="masthead-user-username">Sign In</span>
		</span></button></span></div>
	</div>
	<?php } else { ?>
	<div id="yt-masthead-user" style="position: relative;top: 4px;">
		<span id="yt-masthead-user-displayname" dir="ltr" class="yt-valign-container" onclick="yt.www.masthead.toggleExpandedMasthead();">
		<?php echo htmlspecialchars($_SESSION['siteusername']); ?>
		</span>
		<?php if($__user_h->fetch_unread_pms($_SESSION['siteusername']) != 0) { ?>
		<a style="border-radius:2px;font-weight:bold;border:1px solid #CE4D34;position:relative;top:1px;color: white;text-decoration: none;background-color: #E26148;padding: 7px;padding-left: 10px;margin-right: 12px;display: inline;" href="/inbox/">
		<?php echo $__user_h->fetch_unread_pms($_SESSION['siteusername']); ?> 
		</a>
		<?php } else { ?>
		<a style="border-radius:2px;font-weight:bold;border:1px solid #D5D5D5;position:relative;top:1px;color: #939393;text-decoration: none;background-color: #DADADA;padding: 7px;padding-left: 10px;margin-right: 12px;display: inline;" href="/inbox/">
		<?php echo $__user_h->fetch_unread_pms($_SESSION['siteusername']); ?> 
		</a>
		<?php } ?>
		<img onclick="yt.www.masthead.toggleExpandedMasthead();;return false;" alt="Thumbnail" src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" style="width:31px;height:31px;vertical-align:middle;border-radius:2px;">
		<span id="yt-masthead-dropdown" onclick="yt.www.masthead.toggleExpandedMasthead();" class=""></span>
	</div>
	<?php } ?>
	<div id="masthead-search-bar-container">
		<div id="masthead-search-bar">
			<div id="masthead-nav"><a href="/videos?feature=mh">Browse</a><span class="masthead-link-separator">|</span><a id="masthead-upload-link" class="" data-upsell="upload" href="/upload_video">Upload</a></div>
			<form id="masthead-search" class="search-form consolidated-form" action="/results" onsubmit="if (_gel('masthead-search-term').value == '') return false;">
				<button class="search-btn-compontent search-button yt-uix-button yt-uix-button-default" onclick="if (_gel('masthead-search-term').value == '') return false; _gel('masthead-search').submit(); return false;;return true;" type="submit" id="search-btn" dir="ltr" tabindex="2" role="button"><span class="yt-uix-button-content">Search </span></button>
				<div id="masthead-search-terms" class="masthead-search-terms-border" dir="ltr"><label><input id="masthead-search-term" autocomplete="off" class="search-term" name="search_query" value="" type="text" tabindex="1" onkeyup="goog.i18n.bidi.setDirAttribute(event,this)" title="Search"></label></div>
			</form>
		</div>
	</div></div>
<?php if(isset($_SESSION['siteusername'])) { ?>
<div id="masthead-expanded" class="hid" style="display: none;">
	<div id="masthead-expanded-container" class="with-sandbar">
	<div class="yt-uix-slider yt-rounded" id="watch-channel-discoverbox" data-slider-slide-selected="3" data-slider-slides="4"
		style="
		width: 580px;
		position: absolute;
		top: -9px;
		left: 1px;
		height: 134px;
		"
	>
	<button class="yt-uix-button yt-uix-button-default yt-uix-slider-prev" rel="prev"><img class="yt-uix-slider-prev-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="previous"></button>
	<button class="yt-uix-button yt-uix-button-default yt-uix-slider-next" rel="next"><img class="yt-uix-slider-next-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="next"></button>
	<div class="yt-uix-slider-body" style="width: 525px;">
		<div class="yt-uix-slider-slides">
			<ul class="yt-uix-slider-slide ">
                <?php 
                    $stmt = $__db->prepare("SELECT * FROM videos WHERE author = :username ORDER BY id DESC LIMIT 20");
                    $stmt->bindParam(":username", $_SESSION['siteusername']);
                    $stmt->execute();
                    while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                        $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                        $video['duration'] = $__time_h->timestamp($video['duration']);
                        $video['views'] = $__video_h->fetch_video_views($video['rid']);
                        $video['author'] = htmlspecialchars($video['author']);		
                        $video['title'] = htmlspecialchars($video['title']);
                        $video['description'] = $__video_h->shorten_description($video['description'], 50);
                ?>
                    <li class="yt-uix-slider-slide-item ">
                        <div class="video-list-item  yt-tile-default ">
                            <a href="/watch?v=<?php echo $video['rid']; ?>" class="related-video yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="feature=channel&amp;ei=COeB-Y25jrUCFdWNIQodzR51Jg%3D%3D"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img alt="<?php echo $video['title']; ?>" src="http://s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>"  onerror=";this.src='/dynamic/thumbs/default.jpg';" width="120" ><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
                            <button type="button" onclick=";return false;" title="Watch Later" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="8C-1MRFr4s0" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                            </span></button>
                            </span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat attribution">by <span class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></span></span><span class="stat view-count"><?php echo $video['views']; ?> views</span></a>
                        </div>
                    </li>
                <?php } ?>
				<li>
					<hr >
				</li>
			</ul>
		</div>
	</div>
</div>


		<div id="masthead-expanded-menus-container">
			<span id="masthead-expanded-menu-shade"></span>
			<div id="masthead-expanded-menu" class="">
				<span class="masthead-expanded-menu-header">SubRocks</span>
				<ul id="masthead-expanded-menu-list">
					<li class="masthead-expanded-menu-item">
						<a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">My channel</a>
					</li>
					<li class="masthead-expanded-menu-item">
						<a href="/my_videos" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">
						Video Manager
						</a>
					</li>
					<li class="masthead-expanded-menu-item">
						<a href="#" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">Subscriptions</a>
					</li>
					<li class="masthead-expanded-menu-item">
						<a href="/inbox/" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">Inbox</a>
					</li>
				</ul>
			</div>
			<div id="masthead-expanded-google-menu">
				<span class="masthead-expanded-menu-header">
				Account
				</span>
				<div id="masthead-expanded-menu-google-container">
					<div id="masthead-expanded-menu-google-column1">
						<ul>
							<li class="masthead-expanded-menu-item"><a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>">Profile</a></li>
							<li class="masthead-expanded-menu-item"><a href="#">SubRocks+</a></li>
							<li class="masthead-expanded-menu-item">
								<a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>">
								Settings
								</a>
							</li>
						</ul>
					</div>
					<div id="masthead-expanded-menu-google-column2">
						<div id="masthead-expanded-menu-account-container">
							<img id="masthead-expanded-menu-gaia-photo" alt="" data-src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>">
							<div id="masthead-expanded-menu-account-info" class="email-only">
								<p><?php echo htmlspecialchars($_SESSION['siteusername']); ?></p>
								<p id="masthead-expanded-menu-email">This is you.</p>
							</div>
						</div>
						<ul>
							<li class="masthead-expanded-menu-item">
								<a class="end" href="/logout">
								Sign out
								</a>
							</li>
							<li class="masthead-expanded-menu-item">
								<div class="yt-uix-clickcard masthead-expanded-menu-switch" data-card-class="masthead-card-switch-account">
									<button onclick=";return false;" class="yt-uix-clickcard-target yt-uix-button yt-uix-button-link yt-uix-button-size-default" type="button" data-position="rightbottom" data-orientation="vertical" role="button">    
									</button>
									<div class="yt-uix-clickcard-content">
										<ul id="yt-masthead-multilogin">
											<li>
												<a class="yt-masthead-multilogin-user yt-valign" href="/sign_in">
												<span class="video-thumb yt-masthead-multilogin-user-icon yt-thumb yt-thumb-46">
												<span class="yt-thumb-square">
												<span class="yt-thumb-clip">
												<span class="yt-thumb-clip-inner">
												<img alt="<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" src="https://lh3.googleusercontent.com/-fkHTNWtyMoM/AAAAAAAAAAI/AAAAAAAAAAA/dZZ7bn_kmxE/s46-c-k/photo.jpg" width="46">
												<span class="vertical-align"></span>
												</span>
												</span>
												</span>
												</span>
												<span class="yt-masthead-multilogin-user-content yt-valign-container">
												<span class="yt-masthead-multilogin-user-link" dir="ltr"><?php echo htmlspecialchars($_SESSION['siteusername']); ?></span><br>
												jamie@vid.io
												</span>
												</a>
											</li>
											<li>
												<a class="yt-masthead-multilogin-user yt-valign" href="/sign_in">
													<span class="video-thumb yt-masthead-multilogin-user-icon yt-thumb yt-thumb-46">
													<span class="yt-thumb-square">
													<span class="yt-thumb-clip">
													<span class="yt-thumb-clip-inner">
													<img alt="<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" src="https://lh4.googleusercontent.com/-jGr7ddTE474/AAAAAAAAAAI/AAAAAAAAAAA/nO6xbnZniy0/s46-c-k/photo.jpg" width="46">
													<span class="vertical-align"></span>
													</span>
													</span>
													</span>
													</span>
													<span class="yt-masthead-multilogin-user-content yt-valign-container">
													<span class="yt-masthead-multilogin-user-link" dir="ltr"><?php echo htmlspecialchars($_SESSION['siteusername']); ?></span><br>
													</span>
													<div class="yt-alert yt-alert-naked yt-alert-success">
														<div class="yt-alert-icon">
															<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
														</div>
													</div>
												</a>
											</li>
										</ul>
										<div id="yt-masthead-multilogin-actions" class="yt-grid-box">
											<button id="yt-masthead-multilogin-sign-out" onclick="document.logoutForm.submit();return false;" class=" yt-uix-button yt-uix-button-link yt-uix-button-size-default" type="button" role="button">    <span class="yt-uix-button-content">
											Sign out 
											</span>
											</button>
											<a href="https://accounts.google.com/AddSession?service=youtube&amp;uilel=0&amp;cont…er%252Bballoon%252Bfight%26nomobiletemp%3D1&amp;hl=en_US&amp;passive=false">Add account</a>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>
</div>
<div id="alerts">
	<?php if(isset($error['status'])) { ?>
		<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-error  yt-alert-player">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo $error['message']; ?>
			</div>
		</div></div></div>
	<?php } ?>
	<?php if(isset($_GET['error'])) { ?>
		<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-error ">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo htmlspecialchars($_GET['error']); ?>
			</div>
		</div></div></div>
	<?php } ?>
	<?php if(isset($_GET['success'])) { ?>
		<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-success ">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo htmlspecialchars($_GET['success']); ?>
			</div>
		</div></div></div>
	<?php } ?>
	<?php if(isset($_SESSION['error'])) { ?>
		<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-error">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo $_SESSION['error']->message; ?>
			</div>
		</div></div></div>
		<?php unset($_SESSION['error']); ?>
	<?php } ?>
</div>
<!-- end masthead -->
<div class="alerts-2012">
	
</div>
