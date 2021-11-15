<?php
    $__tabs = (object) [
        "about" => (object) [
            "label" => "About SubRocks",
            "url" => "/t/about_subrocks",
            "selected" => false,
        ],

        "community" => (object) [
            "label" => "Community Guidelines",
            "url" => "/t/community_guidelines",
            "selected" => false,
        ],

        "copyright" => (object) [
            "label" => "Copyright",
            "url" => "/t/copyright_center",
            "selected" => false,
        ],

        "terms" => (object) [
            "label" => "Terms & Conditions",
            "url" => "/t/terms",
            "selected" => false,
        ],  

        "partners" => (object) [
            "label" => "Partner System",
            "url" => "/t/partners",
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
