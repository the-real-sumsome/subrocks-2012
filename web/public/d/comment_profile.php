<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
$_user = $__user_h->fetch_user_username($_GET['u']);
$error = array();
$request = (object) [
    "touser" => $_GET['u'],
    "comment" => $_POST['comment'],
    "username" => $_SESSION['siteusername'],

    "error" => (object) [
        "message" => "",
        "status" => "OK"
    ]
]; 

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!isset($request->username)){ $request->error->message = "you are not logged in"; $request->error->status = ""; }
    if(!$request->touser){ $request->error->message = "your comment cannot be blank"; $request->error->status = ""; }
    if(strlen($request->touser) > 1000){ $request->error->message = "your comment must be shorter than 1000 characters"; $request->error->status = ""; }
    if($__user_h->if_cooldown($request->username)) { $request->error->message = "You are on a cooldown! Wait for a minute before posting another comment."; $request->error->status = ""; }

    if($request->error->status == "OK") {
        $stmt = $__db->prepare("INSERT INTO profile_comments (toid, author, comment) VALUES (:username, :from, :comment)");
        $stmt->bindParam(":username", $request->touser);
        $stmt->bindParam(":from", $request->username);
        $stmt->bindParam(":comment", $request->comment);
        $stmt->execute();

        $__user_u->update_cooldown_time($request->username, "cooldown_comment");
        if(@$request->username != $_user['author'])
            $__user_i->send_message($request->username, "New profile comment", $_user['username'], "I commented \"" . $request->touser . "\" on your profile!", "", "nt");
        
        header("Location: /user/" . $request->touser . "/discussion");
    } else {
        $_SESSION['error'] = $request->error;
        header("Location: /user/" . $request->touser . "/discussion");
    }
}

