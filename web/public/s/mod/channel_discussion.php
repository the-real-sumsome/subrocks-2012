
								<div class="channel-tab-content channel-layout-two-column selected blogger-template">
									<div class="tab-content-body">
										<div class="primary-pane">
                                            <div class="channel-activity-feeds " data-module-id="10500">
                                                <div class="activity-feeds-container">
                                                    <div class="activity-feeds-header clearfix">
                                                        <ul>
                                                        <li class="user-feed-filter">
                                                                <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/feed">
                                                                Activity
                                                                </a>
                                                            </li>

                                                            <li class="user-feed-filter selected">
                                                                <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/discussion">
                                                                Profile Comments
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div id="channel-feed-post-form">
                                                    </div>
                                                    <div class="yt-horizontal-rule channel-section-hr"><span class="first"></span><span class="second"></span><span class="third"></span></div>
                                                    <div class="activity-feed">
                                                        <div class="feed-list-container">
                                                            <div class="feed-item-list">
                                                            <?php if(isset($_SESSION['siteusername'])) { ?>
                                                            <form method="post" action="/d/comment_profile?u=<?php echo htmlspecialchars($_user['username']); ?>">
                                                                <img style="width: 50px;" src="">
                                                                <textarea style="resize:none;padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3; width: 577px; resize: none;"cols="32" id="com" placeholder="Share your thoughts" name="comment"></textarea><br>
                                                                <input style="float: none; margin-right: 0px; margin-top: 0px;" class="yt-uix-button yt-uix-button-default" type="submit" value="Post" name="replysubmit">
                                                            </form><br>
                                                            <?php } ?>
                                                            <ul class="comment-list" id="live_comments">
                                                                <?php
                                                                $results_per_page = 20;

                                                                $stmt = $__db->prepare("SELECT * FROM profile_comments WHERE toid = :rid ORDER BY id DESC");
                                                                $stmt->bindParam(":rid", $_user['username']);
                                                                $stmt->execute();

                                                                $number_of_result = $stmt->rowCount();
                                                                $number_of_page = ceil ($number_of_result / $results_per_page);  

                                                                if (!isset ($_GET['page']) ) {  
                                                                    $page = 1;  
                                                                } else {  
                                                                    $page = (int)$_GET['page'];  
                                                                }  

                                                                $page_first_result = ($page - 1) * $results_per_page;  

                                                                $stmt = $__db->prepare("SELECT * FROM profile_comments WHERE toid = :rid ORDER BY id DESC LIMIT :pfirst, :pper");
                                                                $stmt->bindParam(":rid", $_user['username']);
                                                                $stmt->bindParam(":pfirst", $page_first_result);
                                                                $stmt->bindParam(":pper", $results_per_page);
                                                                $stmt->execute();

                                                                while($comment = $stmt->fetch(PDO::FETCH_ASSOC)) { 

                                                            ?>

                                                                <li class="comment yt-tile-default " data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="<?php echo $comment['id']; ?>" data-score="0">
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
                                                                                    <?php if($comment['likes'] != 0) { ?>
                                                                                    <span dir="ltr" class="comments-rating-positive" title="9 up, 1 down">
                                                                                        <?php echo $comment['likes']; ?>
                                                                                        <img class="comments-rating-thumbs-up" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
                                                                                    </span>
                                                                                    <?php } ?>
                                                                                </p>
                                                                            </div>
                                                                            <div class="comment-actions hid">
                                                                                <span class="yt-uix-button-group hid" style="display:none;"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span>
                                                                                <span class="yt-uix-button-group hid" style="display:none;">
                                                                                    <button type="button" 
                                                                                            class="start comment-action yt-uix-button yt-uix-button-default" 
                                                                                            onclick=";$('#reply_to_<?php echo $comment['id']; ?>').show();return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply</span>
                                                                                    </button><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant="">
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
                                                                        <?php if(isset($_SESSION['siteusername'])) { ?> 
                                                                            <li id="reply_to_<?php echo $comment['id']; ?>" style="display: none;" class="comment yt-tile-default  child" data-tag="O" data-author-viewing="" data-id="iRV7EkT9us81mDLFDSB6FAsB156Fdn13HUmTm26C3PE" data-score="34" data-author="<?php echo htmlspecialchars($row['author']); ?>">

                                                                            <div class="comment-body">
                                                                                <div class="content-container">
                                                                                <div class="content">
                                                                                    <div class="comment-text" dir="ltr">
                                                                                    <form method="post" action="/d/reply?id=<?php echo $comment['id']; ?>&v=<?php echo $_GET['v']; ?>">
                                                                                        <img style="width: 50px;" src="">
                                                                                        <textarea style="resize:none;padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3; width: 577px; resize: none;"cols="32" id="com" placeholder="Share your thoughts" name="comment"></textarea><br><br>
                                                                                        <input style="float: none; margin-right: 0px; margin-top: 0px;" class="yt-uix-button yt-uix-button-default" type="submit" value="Reply" name="replysubmit">
                                                                                        <input style="display: none;" name="id" value="<?php echo $row['id']; ?>">
                                                                                        
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                
                                                            <?php } ?>
                                                        </ul>
                                                            </div>
                                                        </div>
                                                    </div>
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
																<span class="value"><?php echo htmlspecialchars(ucfirst($_user['genre'])); ?></span>
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
													<h2 <?php if(@$_SESSION['siteusername'] == $_user['username']) { ?>style="display: inline-block;position: relative;bottom: 10px;"<?php } ?>>Featured Channels</h2> 
													<?php if(@$_SESSION['siteusername'] == $_user['username']) { 
														echo "<a href='#' style='float:right;font-size:11px;color:black;' onclick=';open_featured_channels();return false;'>edit</a>"; 
													} ?>
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
							