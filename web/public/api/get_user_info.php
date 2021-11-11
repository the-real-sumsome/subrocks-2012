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
/* VERY BASIC API V1 .000010101010 PROBABL Y WILL NEVER GET TOUCHED AGAIN */
header("Content-type: application/json");
$response = (object) [
    "status" => 201,
];

if(!isset($_GET['u']))                  { $response->status = 400; die(json_encode($response)); } 
if(!$__user_h->user_exists($_GET['u'])) { $response->status = 400; die(json_encode($response)); }

$_user = $__user_h->fetch_user_username($_GET['u']);
$response = (object) [
    "status" => 201,
    "user_info" => (object) [
        "username" => $_user['username'],
        "created" => $_user['created'],
        "lastlogin" => $_user['lastlogin'],
        "bio" => $_user['bio'],
        "pfp" => $_user['pfp'],
        "featured_video" => $_user['featured'],
        "status" => $_user['status'],
        "country" => $_user['country'],
        "website" => $_user['website'],
        "featured_channels" => $_user['featured_channels'],
        "genre" => $_user['genre'],
        "partner" => $_user['partner'],
        "layout" => $_user['layout'],
    ]
];

$_user['featured_channels'] = explode($_user['featured_channels'], ",");
$_user['featured_channels_object'] = (object) [];
$i = 0;
foreach($_user['featured_channels'] as $channel) {
    $_user['featured_channels_object']->$i = $channel;
}

die(json_encode($response));