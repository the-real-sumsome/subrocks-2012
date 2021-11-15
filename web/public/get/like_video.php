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

$stmt = $__db->prepare("SELECT * FROM likes WHERE sender = :username AND reciever = :reciever AND type = 'l'");
$stmt->bindParam(":username", $_SESSION['siteusername']);
$stmt->bindParam(":reciever", $name);
$stmt->execute();
while($comment = $stmt->fetch(PDO::FETCH_ASSOC)) { 
    $stmt = $__db->prepare("DELETE FROM likes WHERE sender = :username AND reciever = :reciever");
    $stmt->execute(array(
      ':username' => $_SESSION['siteusername'],
      ':reciever' => $name,
    ));
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$stmt = $__db->prepare("SELECT * FROM likes WHERE sender = :username AND reciever = :reciever AND type = 'd'");
$stmt->bindParam(":username", $_SESSION['siteusername']);
$stmt->bindParam(":reciever", $name);
$stmt->execute();
while($comment = $stmt->fetch(PDO::FETCH_ASSOC)) { 
    $stmt = $__db->prepare("DELETE FROM likes WHERE sender = :username AND reciever = :reciever");
    $stmt->execute(array(
      ':username' => $_SESSION['siteusername'],
      ':reciever' => $name,
    ));
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$stmt = $__db->prepare("INSERT INTO likes (sender, reciever, type) VALUES (:sender, :reciever, 'l')");
$stmt->bindParam(":sender", $_SESSION['siteusername']);
$stmt->bindParam(":reciever", $name);
$stmt->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>