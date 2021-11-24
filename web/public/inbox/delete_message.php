<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_updater.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__video_u = new video_updater($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
    if(!isset($_SESSION['siteusername'])) { die(); }

    $request = (object) [
        "id" => $_GET['id'],
        "from" => $_SESSION['siteusername'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $stmt = $__db->prepare("UPDATE pms SET readed = 'r' WHERE id = :id AND touser = :username");
    $stmt->execute(array(
        ':id' => $request->id,
        ':username' => $request->from
    ));

    header('Location: ' . $_SERVER['HTTP_REFERER']);

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>