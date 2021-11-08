<?php
    $__tabs = (object) [
        "inbox" => (object) [
            "label" => "Inbox",
            "url" => "/inbox/",
            "selected" => false,
        ],

        "sent" => (object) [
            "label" => "Sent",
            "url" => "/inbox/sent",
            "selected" => false,
        ],

        "notifications" => (object) [
            "label" => "Notifications",
            "url" => "/inbox/notifications",
            "selected" => false,
        ],

        "pms" => (object) [
            "label" => "Personal Messages",
            "url" => "/inbox/pm",
            "selected" => false,
        ],  
    ];
?>

<div id="browse-side-column" class="ytg-2col ytg-last">
    <div id="inbox_compose">
    <a href="/inbox/compose">
        <button id="inbox_compose_button" class="yt-uix-button yt-uix-button-default">
            Compose
        </button>
    </a>
</div>
    <ol class="navigation-menu">
        <?php foreach($__tabs as $_tab) { 
            if($_SERVER['REQUEST_URI'] != $_tab->url)
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
