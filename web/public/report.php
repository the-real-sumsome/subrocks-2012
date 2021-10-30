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
if(!isset($_SESSION['siteusername']))
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error=You have to be logged in to report videos.');

$_video = $__video_h->fetch_video_rid($_GET['v']);
$webhookurl = $__server->discord_webhook;
$timestamp = date("c", strtotime("now"));
$reason = "Spam";

$json_data = json_encode([
    "content" => "I reported '" . str_replace("@", "", $_video['title']) . "' [https://subrock.rocks/watch?v=" . $_video['rid'] . "]",
    "username" => str_replace("@", "", $_SESSION['siteusername']),
    // "avatar_url" => "https://subrock.rocks/dynamic/pfp/",
    "tts" => false,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
curl_close( $ch );
header('Location: ' . $_SERVER['HTTP_REFERER'] . '&success=Successfully reported this video.');
?>