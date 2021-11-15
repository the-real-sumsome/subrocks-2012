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
$request = (object) [
    "name" => $_GET['n'],
    "sender" => $_SESSION['siteusername'],

    "error" => (object) [
        "message" => "",
        "status" => "OK"
    ]
];

if(!$__user_h->if_subscribed(@$_SESSION['siteusername'], $request->name)) 
    { $request->error->message = "You aren't subscribed to this person!"; $request->error->status = ""; }

if($request->error->status == "OK") { 
    $stmt = $__db->prepare("DELETE FROM subscribers WHERE sender=:sender AND reciever=:reciever");
    $stmt->execute(array(
      ':sender' => $request->sender,
      ':reciever' => $request->name,
    ));

    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    echo json_encode($request->error);
}

?>