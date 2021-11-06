<?php
    $__tabs = (object) [
        "admin" => (object) [
            "label" => "Home",
            "url" => "/admin/",
            "selected" => false,
        ],

        "ban" => (object) [
            "label" => "Ban Accounts",
            "url" => "/admin/bans",
            "selected" => false,
        ],

        "stats" => (object) [
            "label" => "Stats",
            "url" => "/admin/status",
            "selected" => false,
        ],

        "reports" => (object) [
            "label" => "Reports",
            "url" => "/inbox/reports",
            "selected" => false,
        ],

        "logs" => (object) [
            "label" => "Admin Logs",
            "url" => "/inbox/logs",
            "selected" => false,
        ],
    ];
?>
<div id="browse-side-column" class="ytg-2col ytg-last">
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