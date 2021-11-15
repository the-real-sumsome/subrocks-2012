<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_user_insert_utils = new user_insert_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);

?>
<?php
$friend = $_user_fetch_utils->fetch_friend_id($_GET['id']);

$name = $friend['reciever'];

if($name != $_SESSION['siteusername'] || !isset($_GET['id'])) {
    die("You are not logged in or you did not put in an argument");
}

$stmt = $conn->prepare("UPDATE friends SET status = 'd' WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$stmt->close();

header('Location: /friends');
?>