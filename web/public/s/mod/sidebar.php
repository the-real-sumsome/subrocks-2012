<?php
    $__tabs = (object) [
        "video_manager" => (object) [
            "label" => "Video Manager",
            "url" => "/my_videos",
            "selected" => false,
        ],

        "favorite_videos" => (object) [
            "label" => "Favorites",
            "url" => "/favorite_videos",
            "selected" => false,
        ],

        "subscriptions" => (object) [
            "label" => "Subscriptions",
            "url" => "/subscriptions",
            "selected" => false,
        ],

        "playlists" => (object) [
            "label" => "Playlists",
            "url" => "/playlists",
            "selected" => false,
        ],

        "friends" => (object) [
            "label" => "Friends",
            "url" => "/friends",
            "selected" => false,
        ],

        "watchlist" => (object) [
            "label" => "Watchlist",
            "url" => "/watchlist",
            "selected" => false,
        ],
    ];
?>
<div id="browse-side-column" class="ytg-2col ytg-last">
    <ol class="navigation-menu">
        <?php foreach($__tabs as $_tab) { 
            if(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) != $_tab->url)
                $_tab->selected = true;
            ?>
            <li class="menu-item">
                <a class="<?php echo $_tab->selected ? true : "selected"; ?>" href="<?php echo $_tab->url; ?>">
                    <?php echo $_tab->label; ?>
                </a>
            </li>
        <?php } ?>
    </ol>
</div>