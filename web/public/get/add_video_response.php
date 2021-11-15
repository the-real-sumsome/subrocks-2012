<?php ob_start(); ?>
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

if($_user_fetch_utils->video_responded($_GET['reciever'], $_GET['sending']) == 0) {
    $stmt = $conn->prepare("INSERT INTO video_response (toid, author, video) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_GET['reciever'], $_SESSION['siteusername'], $_GET['sending']);
    $stmt->execute();
    $stmt->close();
}

header('Location: /watch?v=' . htmlspecialchars($_GET['reciever']));
?>