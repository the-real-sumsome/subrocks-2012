<?php ob_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
  $_user_fetch_utils = new user_fetch_utils();
  $_user_insert_utils = new user_insert_utils();
  $_video_fetch_utils = new video_fetch_utils();
  $_base_utils = new config_setup();
 
  $_base_utils->initialize_db_var($conn);
  $_video_fetch_utils->initialize_db_var($conn);
  $_user_insert_utils->initialize_db_var($conn);
  $_user_fetch_utils->initialize_db_var($conn);
?>
<?php
session_start();
$name = $_GET['v'];

if(!isset($_SESSION['siteusername']) || !isset($_GET['v'])) {
    die("You are not logged in or you did not put in an argument");
}

if(!is_int((int)$_GET['rating'])) {
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if((1 <= (int)$_GET['rating']) && ((int)$_GET['rating']) <= 5) {
    $stmt = $conn->prepare("SELECT * FROM stars WHERE sender = ? AND reciever = ?");
    $stmt->bind_param("ss", $_SESSION['siteusername'], $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $_user_insert_utils->remove_star_video($_SESSION['siteusername'], $name);
            goto skip;
        }

    $stmt = $conn->prepare("INSERT INTO stars (sender, reciever, type) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $_SESSION['siteusername'], $name, $_GET['rating']);

    $stmt->execute();
    $stmt->close();
}


// sendIt($_SESSION['siteusername'], "New like", 'You have recieved a new like on ' . $name, "System Message", $conn);
skip:
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>