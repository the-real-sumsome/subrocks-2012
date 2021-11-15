<?php ob_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/delete.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
  $_user_fetch_utils = new user_fetch_utils();
  $_user_insert_utils = new user_insert_utils();
  $_video_fetch_utils = new video_fetch_utils();
  $_user_delete_utils = new user_delete_utils();
  $_base_utils = new config_setup();
 
  $_base_utils->initialize_db_var($conn);
  $_video_fetch_utils->initialize_db_var($conn);
  $_user_insert_utils->initialize_db_var($conn);
  $_user_fetch_utils->initialize_db_var($conn);
  $_user_delete_utils->initialize_db_var($conn);
?>
<?php
$name = $_GET['id'];

if(!isset($_SESSION['siteusername']) || !isset($_GET['id'])) {
    die("You are not logged in or you did not put in an argument");
}

$stmt = $conn->prepare("SELECT * FROM comment_likes WHERE sender = ? AND reciever = ? AND type = 'd'");
$stmt->bind_param("ss", $_SESSION['siteusername'], $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) {
        $_user_delete_utils->remove_comment_like($_SESSION['siteusername'], $name);
    }

$stmt = $conn->prepare("SELECT * FROM comment_likes WHERE sender = ? AND reciever = ? AND type = 'l'");
$stmt->bind_param("ss", $_SESSION['siteusername'], $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) {
        $_user_delete_utils->remove_comment_like($_SESSION['siteusername'], $name);
    } else {
        $_user_insert_utils->add_comment_dislike($_SESSION['siteusername'], $name);
    }
$stmt->close();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>