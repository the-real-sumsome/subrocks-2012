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

    $video = $_video_fetch_utils->get_quicklist_video($_GET['id']);
?>
<?php
if($video['author'] == $_SESSION['siteusername']) {
    $stmt = $conn->prepare("DELETE FROM quicklist_videos WHERE id = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $stmt->close();
}

header('Location: /quicklist');
?>