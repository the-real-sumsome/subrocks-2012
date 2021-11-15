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

if($_SESSION['siteusername'] == $_GET['sending'])
    die("You can't friend yourself!");

$stmt = $conn->prepare("SELECT * FROM friends WHERE sender = ? AND reciever = ?");
$stmt->bind_param("ss", $_SESSION['siteusername'], $_GET['sending']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) die('You already sent a friend request to this person');
$stmt->close();

$stmt = $conn->prepare("INSERT INTO friends (sender, reciever, status) VALUES (?, ?, 'u')");
$stmt->bind_param("ss", $_SESSION['siteusername'], $_GET['sending']);

$stmt->execute();
$stmt->close();

$_user_insert_utils->send_message($_GET['sending'], "New friend request", 'I sent you a new friend request!', $_SESSION['siteusername']);
header('Location: /friends');
?>