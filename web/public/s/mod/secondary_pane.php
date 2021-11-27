
<div class="user-profile channel-module yt-uix-c3-module-container ">
    <div class="module-view profile-view-module" data-owner-external-id="IwFjwMjI0y7PDBVEO9-bkQ">
        <h2>About <?php echo htmlspecialchars($_user['username']); ?></h2>
        <div class="section first">
            <div class="user-profile-item profile-description">
                <p id="bio-changeme"><?php echo $__video_h->shorten_description($_user['bio'], 5000, true); ?></p>
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
                    <span class="link-text" id="website_url_change">
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
                <span class="value" id="country_change"><?php echo htmlspecialchars($_user['country']); ?></span>
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
    <style>
        .box-gray {
            position: relative;
            padding: 10px;
            border: 1px solid #c5c5c5;
            background-color: #f7f7f7;
            border-radius: 5px;
        }
    </style>
    <?php $_user['featured_channels'] = explode(",", $_user['featured_channels']); ?>
    <?php if(count($_user['featured_channels']) != 0) { ?>
    <div class="module-view other-channels-view">
        <h2 <?php if(@$_SESSION['siteusername'] == $_user['username']) { ?>style="display: inline-block;position: relative;bottom: 10px;"<?php } ?>>Featured Channels</h2> 
        <?php if(@$_SESSION['siteusername'] == $_user['username']) { 
            echo "<a href='#' style='float:right;font-size:11px;color:black;' onclick=';open_featured_channels();return false;'>edit</a>"; 
        } ?>
        <div class="box-gray" style="display:none;" id="edit_featured_channels" style="margin-bottom: 8px;">
            <center>
                <button onclick="add_channel_form();" class="yt-uix-button yt-uix-button-default yt-uix-button-primary">
                    Add Featured Channel
                </button> &nbsp;
                <button onclick="finish_channel_featured();" class="yt-uix-button yt-uix-button-default">
                    Finish
                </button>
            </center>
            <hr class="yt-horizontal-rule " style="z-index:unset;">
            <ul id="added_channels">
                <li>
                    <input id="doocaca" class="yt-uix-form-input-text" type="text" style="width: 92%;margin-bottom:3px;" placeholder="Channel name">
                </li>
                <?php 
                    foreach($_user['featured_channels'] as $user) {
                        if($__user_h->user_exists($user)) { ?>
                    <li>
                        <input id="doocaca" class="yt-uix-form-input-text" type="text" style="width: 92%;margin-bottom:3px;" value="<?php echo htmlspecialchars($user); ?>" placeholder="Channel name">
                    </li>
                <?php    
                        }
                    }
                ?>
            </ul>
            <center>
                <span style="font-size:11px;color:grey;">Leave a spot blank to remove that channel.</span>
            </center>
        </div><br>

        <ul class="channel-summary-list">
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
<script>
    var channel_customization_module = {
        featured_channels_opened: true,
        current_featured_channels: "",
    };

    function finish_channel_featured() {
        a = "";
        $("#added_channels li").each(function(index) {
            b = $(this).find("#doocaca").val();
            if(b !== "") {
                a += b + ",";
            }
        });

        $.post("/d/channel_update",
        {
            featuredchannels: a
        },
        function(data, status){
            alerts++;
            addAlert("editsuccess_" + alerts, "Successfully updated your channel!");
            showAlert("#editsuccess_" + alerts);
        });

        channel_customization_module.current_featured_channels = a;
    }

    function open_featured_channels() {
        if(channel_customization_module.featured_channels_opened) 
            { $("#edit_featured_channels").fadeOut(100); 
              channel_customization_module.featured_channels_opened = false; }
        else
            { $("#edit_featured_channels").fadeIn(100); 
              channel_customization_module.featured_channels_opened = true; }
    }

    function add_channel_form() {
        $("#added_channels").prepend(
            `
            <li>
                <input id="doocaca"  class="yt-uix-form-input-text" type="text" style="width: 92%;margin-bottom:3px;" placeholder="Channel name">
            </li>
            `
        );
    }
</script>
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
