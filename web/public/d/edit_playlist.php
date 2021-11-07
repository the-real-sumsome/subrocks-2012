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
    $_playlist = $__video_h->fetch_playlist_rid($_GET['v']);
    if($_playlist['author'] != @$_SESSION['siteusername']) {
        die();
    }

    header("Content-type: application/json");

    $request = (object) [
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "tags" => $_POST['tags'],
        "thumbnail" => $_FILES['thumbnail'],
        "category" => $_POST['category'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $__video_u->playlist_update_row($_GET['v'], "title", $request->title);
    $__video_u->playlist_update_row($_GET['v'], "description", $request->description);

    echo json_encode($request, JSON_PRETTY_PRINT);
?>