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
        "action" => $_GET['action'],
        "users"  => $_POST['users'],
        "reason" => $_POST['ban_reason'],
        "videos" => $_POST['videos'],
        "from"   => $_SESSION['siteusername'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $request->users  = explode(",", $request->users);
    $request->videos = explode(",", $request->videos);
    $request->tables = array(
        "users"            => "username",
        "videos"           => "author",
        "channel_views"    => "viewer",
        "comments"         => "author",
        "comment_likes"    => "sender",
        "comment_reply"    => "author",
        "favorite_video"   => "sender",
        "friends"          => "sender",
        "likes"            => "sender",
        "playlists"        => "author",
        "pms"              => "owner",
        "profile_comments" => "author",
        "quicklist_videos" => "author",
        "reports"          => "sender",
        "subscribers"      => "sender",
        "views"            => "viewer",
    );
    $request->tables_increment = 0;

    if($request->action == "ban_users") {        
        foreach($request->users as $username) {
            $stmt = $__db->prepare("DELETE FROM users WHERE username=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            
            $stmt = $__db->prepare("DELETE FROM videos WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM channel_views WHERE viewer=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM comments WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM comment_likes WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM comment_reply WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM favorite_video WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM friends WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM likes WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM playlists WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM pms WHERE owner=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM profile_comments WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM quicklist_videos WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            
            $stmt = $__db->prepare("DELETE FROM reports WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM subscribers WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            $stmt = $__db->prepare("DELETE FROM views WHERE viewer=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));

            header("Location: /admin/bans");
        }
    } else if($request->action == "delete_videos") {
        foreach($request->videos as $video) {
            $stmt = $__db->prepare("DELETE FROM videos WHERE rid=:video");
            $stmt->execute(array(
                ':video' => $video,
            ));

            header("Location: /admin/bans");
        }
    } else if($request->action == "actually_just_ban") {
        $stmt = $__db->prepare("INSERT INTO bans (username, reason, expire, moderator) VALUES (:username, :reason, now(), :moderator)");
        $stmt->execute(array(
            ':username'  => $_POST['users'],
            ':moderator' => $_SESSION['siteusername'],
            ':reason'    => $request->reason,
        ));

        header("Location: /admin/bans");
    } else if($request->action == "actually_just_ban_ip") {
        $_user = $__user_h->fetch_user_username($_POST['users']);

        $stmt = $__db->prepare("INSERT INTO bans (username, reason, expire, moderator) VALUES (:username, :reason, now(), :moderator)");
        $stmt->execute(array(
            ':username'  => $_user['ip'],
            ':moderator' => $_SESSION['siteusername'],
            ':reason'    => "",
        ));
        
        header("Location: /admin/bans");
    }

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>