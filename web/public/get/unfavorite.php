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

/*
$stmt = $conn->prepare("SELECT * FROM favorite_video WHERE sender = ? AND reciever = ?");
$stmt->bind_param("ss", $_SESSION['siteusername'], $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0) die('You already are not subscribed to this person!');
$stmt->close();

is this needed?
*/

$stmt = $__db->prepare("DELETE FROM favorite_video WHERE sender = :sender AND reciever = :reciever");
$stmt->execute(array(
  ':sender' => $_SESSION['siteusername'],
  ':reciever' => $name,
));

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>