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
$name = $_GET['user'];
$author = $_SESSION['siteusername'];

if(!isset($_SESSION['siteusername']) || !isset($_GET['user'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if($name == $_SESSION['siteusername']) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$stmt = $conn->prepare("SELECT * FROM block WHERE sender = ? AND reciever = ?");
$stmt->bind_param("ss", $_SESSION['siteusername'], $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) die('You already blocked this person!');
$stmt->close();

$stmt = $conn->prepare("INSERT INTO block (sender, reciever) VALUES (?, ?)");
$stmt->bind_param("ss", $_SESSION['siteusername'], $name);

$stmt->execute();
$stmt->close();
$author = htmlspecialchars($_SESSION['siteusername']);
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>