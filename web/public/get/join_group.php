<?php ob_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_user_insert_utils = new user_insert_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);

    $group = $_video_fetch_utils->fetch_group_id($_GET['id']);
?>
<?php

if(!$_user_fetch_utils->if_joined_group($_SESSION['siteusername'], $_GET['id'])) {
    $stmt = $conn->prepare("INSERT INTO group_members (togroup, username) VALUES (?, ?)");
    $stmt->bind_param("ss", $_GET['id'], $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->close();

    $_user_insert_utils->send_message($group['group_author'], "Joined Group", $_SESSION['siteusername'] . ' has joined your group.', $_SESSION['siteusername']);
}

header('Location: /view_group?v=' . htmlspecialchars($_GET['id']));
?>