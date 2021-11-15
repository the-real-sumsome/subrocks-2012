<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
$friend = $_user_fetch_utils->fetch_friend_id($_GET['id']);

$name = $friend['reciever'];

if($name != $_SESSION['siteusername'] || !isset($_GET['id'])) {
    die("You are not logged in or you did not put in an argument");
}

$stmt = $conn->prepare("UPDATE friends SET status = 'a' WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$stmt->close();

header('Location: /friends');
?>