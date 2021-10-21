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
            "email" => $_POST['email'],
            "password_hash" => password_hash($_POST['password'], PASSWORD_DEFAULT),

            "error" => (object) [
                "message" => "",
                "status" => "OK"
            ]
        ]; 

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) 
            { $request->error->message = "Your email is invalid!"; $request->error->status = "";  }
        if(strlen($request->username) > 21) 
            { $request->error->message = "Your username must be shorter than 21 characters."; $request->error->status = ""; }
        if(strlen($request->password) < 8) 
            { $request->error->message = "Your password must at least be 8 characters long."; $request->error->status = ""; }
        if(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $request->password)) 
            { $request->error->message = "Include numbers and letters in your password!"; $request->error->status = ""; }
        if(!preg_match('/^\S+\w\S{1,}/', $request->username)) 
            { $request->error->message = "Your username cannot contain any special characters!"; $request->error->status = ""; }
        if(empty(trim($request->username))) 
            { $request->error->message = "Your username cannot be empty!"; $request->error->status = ""; }
        
        $stmt = $__db->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(":username", $request->username);
        $stmt->execute();
        if($stmt->rowCount()) 
            { $request->error->message = "There's already a user with that same username!"; $request->error->status = ""; }
        
        if($request->error->status == "OK") {
            $stmt = $__db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(":username", $request->username);
            $stmt->bindParam(":email", $request->email);
            $stmt->bindParam(":password", $request->password_hash);
            $stmt->execute();

            $_SESSION['siteusername'] = $request->username;
            header("Location: /");
        } else {
            $_SESSION['error'] = $request->error;
            header("Location: /sign_up");
        }
    }
?>