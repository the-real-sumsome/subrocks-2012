<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
$name = $_GET['v'];
$author = $_SESSION['siteusername'];

$stmt = $__db->prepare("SELECT * FROM favorite_video WHERE sender = :sender AND reciever = :reciever");
$stmt->bindParam(":sender", $_SESSION['siteusername']);
$stmt->bindParam(":reciever", $name);
$stmt->execute();

if($stmt->rowCount() == 1) { 
    $_SESSION['error']->message = "You have already favorited this video.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

$stmt = $__db->prepare("INSERT INTO favorite_video (sender, reciever) VALUES (:sender, :reciever)");
$stmt->bindParam(":sender", $_SESSION['siteusername']);
$stmt->bindParam(":reciever", $name);
$stmt->execute();
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>