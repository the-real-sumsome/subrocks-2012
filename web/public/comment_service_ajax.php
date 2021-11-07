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
$_video = $__video_h->fetch_video_rid($_SESSION['current_video']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();

    if(!isset($_SESSION['siteusername'])){ $error['message'] = "you are not logged in"; $error['status'] = true; }
    if(!$_POST['comment']){ $error['message'] = "your comment cannot be blank"; $error['status'] = true; }
    if(strlen($_POST['comment']) > 1000){ $error['message'] = "your comment must be shorter than 1000 characters"; $error['status'] = true; }
    if($__user_h->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for a minute before posting another comment."; $error['status'] = true; }

    if(!isset($error['message'])) {
        $text = $_POST['comment'];
        $stmt = $__db->prepare("INSERT INTO comments (toid, author, comment) VALUES (:v, :username, :comment)");
        $stmt->bindParam(":v", $_SESSION['current_video']);
        $stmt->bindParam(":username", $_SESSION['siteusername']);
        $stmt->bindParam(":comment", $text);
        $stmt->execute();

        $__user_u->update_cooldown_time($_SESSION['siteusername'], "cooldown_comment");
        if(@$_SESSION['siteusername'] != $_video['author'])
            $__user_i->send_message($_SESSION['siteusername'], "New comment", $_video['author'], "I commented \"" . $_POST['comment'] . "\" on your video!", $_video['rid'], "nt");
    }
}

header("Content-type: text/xml");
// ugly solution
if(!isset($error['status'])) {
    $xml = '<?xml version="1.0" encoding="utf-8"?><root><str_code><![CDATA[OK]]></str_code><html_content><![CDATA[<li class="comment yt-tile-default " data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="420" data-score="0"><div class="comment-body"><div class="content-container"><div class="content"><div class="comment-text" dir="ltr"><p>' . $__video_h->shorten_description($_POST['comment'], 2048, true) . '</p></div><p class="metadata"><span class="author "><a href="/user/' . htmlspecialchars($_SESSION['siteusername']) . '" class="yt-uix-sessionlink yt-user-name " data-sessionlink="' . htmlspecialchars($_SESSION['siteusername']) . '" dir="ltr">' . htmlspecialchars($_SESSION['siteusername']) . '</a></span><span class="time" dir="ltr"><span dir="ltr">just now<span></span></span></span></p></div><div class="comment-actions"><span class="yt-uix-button-group"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span><span class="yt-uix-button-group"><!--<button type="button" class="start comment-action yt-uix-button yt-uix-button-default" onclick=";return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply </span></button>--><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant=""><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;"><ul><li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li><li class="comment-action-remove comment-action" data-action="remove"><span class="yt-uix-button-menu-item">Remove</span></li><li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li><li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li><li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li></ul></div></button></span></div></div></div></li>]]></html_content><return_code><![CDATA[0]]></return_code></root>';
} else {
    $xml = '<?xml version="1.0" encoding="utf-8"?><root><str_code><![CDATA[OK]]></str_code><html_content><![CDATA[<div class="yt-alert yt-alert-default yt-alert-error ">  <div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div><div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert"><span class="yt-alert-vertical-trick"></span><div class="yt-alert-message">You are under a cooldown!</div></div></div>]]></html_content><return_code><![CDATA[0]]></return_code></root>';
}

echo str_replace(PHP_EOL, "", $xml);
?>