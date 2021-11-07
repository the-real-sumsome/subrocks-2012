<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
$request = (object) [
    "to_id" => $_GET['id'],
    "comment" => $_POST['comment'],
    "sender" => $_SESSION['siteusername'],

    "error" => (object) [
        "message" => "",
        "status" => "OK"
    ]
];

if(empty(trim($request->comment))) { header("Location: /watch?v=" . $_GET['v']); }
if(empty(trim($request->to_id  ))) { header("Location: /"); }
if(isset($_SESSION['siteusername'])) {
    $stmt = $__db->prepare("INSERT INTO comment_reply (toid, author, comment) VALUES (:to_id, :author, :comment)");
    $stmt->bindParam(":to_id",   $request->to_id);
    $stmt->bindParam(":author",  $request->sender);
    $stmt->bindParam(":comment", $request->comment);
    $stmt->execute();

    header("Location: /watch?v=" . $_GET['v']);
}