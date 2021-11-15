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
<?php $playlist = $__video_h->fetch_playlist_rid($_GET['id']); ?>
<?php
if($playlist['author'] == $_SESSION['siteusername']) {
    $stmt = $__db->prepare("DELETE FROM playlists WHERE rid=:rid AND author=:author");
    $stmt->execute(array(
        ':author' => $_SESSION['siteusername'],
        ':rid' => $playlist['rid'],
    ));
}

header('Location: /playlists');
?>