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
    $group_member_status = $_video_fetch_utils->fetch_group_membership_id($_GET['id']);
?>
<?php

if($_user_fetch_utils->if_joined_group($_SESSION['siteusername'], $_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM group_members WHERE togroup = ? AND username = ?");
    $stmt->bind_param("ss", $_GET['id'], $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->close();
}

header('Location: /view_group?v=' . $_GET['id']);
?>