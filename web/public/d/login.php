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
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['username']) {
        $request = (object) [
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "password_hash" => password_hash($_POST['password'], PASSWORD_DEFAULT),
            "returned_password" => "",

            "error" => (object) [
                "message" => "",
                "status" => "OK"
            ]
        ]; 

        $stmt = $__db->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(":username", $request->username);
        $stmt->execute();

        if(!$stmt->rowCount()){ 
            { $request->error->message = "Incorrect username or password!"; $request->error->status = ""; } }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!isset($row['password'])) 
            { $request->error->message = "Incorrect username or password!"; $request->error->status = ""; } 
        else 
            { $request->returned_password = $row['password']; }

        if(!password_verify($request->password, $request->returned_password)) 
            { $request->error->message = "Incorrect username or password!"; $request->error->status = ""; }
        
        if($request->error->status == "OK") {
            $_SESSION['siteusername'] = $request->username;
            header("Location: /");
        } else {
            $_SESSION['error'] = $request->error;
            header("Location: /sign_in");
        }
    }
?>