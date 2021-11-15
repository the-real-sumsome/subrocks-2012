<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/delete.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_delete_utils = new video_delete_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_video_delete_utils->initialize_db_var($conn);

    $group = $_video_fetch_utils->fetch_group_id($_GET['id']);
?>
<?php

if($group['group_author'] == $_SESSION['siteusername']) {
    $stmt = $conn->prepare("DELETE FROM user_groups WHERE id = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $stmt->close();
}

header('Location: /groups');
?>