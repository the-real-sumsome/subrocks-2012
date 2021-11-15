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

    $comment = $_user_fetch_utils->fetch_reply_id($_GET['id']);
    $to = $_user_fetch_utils->fetch_comment_id($comment['toid']);
    $video = $_video_fetch_utils->fetch_video_rid($to['toid']);
?>
<?php
if($video['author'] == $_SESSION['siteusername']) {
    $stmt = $conn->prepare("DELETE FROM comment_reply WHERE id = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $stmt->close();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>