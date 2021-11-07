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
    if(!$__user_h->if_admin($_SESSION['siteusername'])) { die(); }

    $request = (object) [
        "username" => $_GET['v'],
        "from" => $_SESSION['siteusername'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $stmt = $__db->prepare("DELETE FROM users WHERE username=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));
    
    $stmt = $__db->prepare("DELETE FROM videos WHERE author=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM channel_views WHERE viewer=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM comments WHERE author=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM comment_likes WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM comment_reply WHERE author=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM favorite_video WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM friends WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM likes WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM playlists WHERE author=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM pms WHERE owner=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM profile_comments WHERE author=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM quicklist_videos WHERE author=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));
    
    $stmt = $__db->prepare("DELETE FROM reports WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM subscribers WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    $stmt = $__db->prepare("DELETE FROM views WHERE viewer=:username");
    $stmt->execute(array(
        ':username' => $request->username,
    ));

    header("Location: /?success=User deleted success");

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>