<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_updater.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__video_u = new video_updater($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
    $_video = $__video_h->fetch_video_rid($_GET['v']);
    if($_video['author'] != @$_SESSION['siteusername']) {
        die();
    }

    header("Content-type: application/json");

    $request = (object) [
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "tags" => $_POST['tags'],
        "thumbnail" => $_FILES['thumbnail'],
        "category" => $_POST['category'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $__video_u->update_row($_GET['v'], "title", $request->title);
    $__video_u->update_row($_GET['v'], "description", $request->description);
    $__video_u->update_row($_GET['v'], "tags", $request->tags);
    $__video_u->update_row($_GET['v'], "thumbnail", $request->thumbnail);
    $__video_u->update_row($_GET['v'], "category", $request->category);

    if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_FILES['thumbnail']) {
        if(!empty($_FILES["thumbnail"]["name"])) {
            $target_dir = "dynamic/thumbs/";
            $imageFileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
            $target_name = md5_file($_FILES["thumbnail"]["tmp_name"]) . "." . $imageFileType;
    
            $target_file = $target_dir . $target_name;
    
            $uploadOk = true;
            $movedFile = false;
    
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                $fileerror = 'unsupported file type. must be jpg, png, jpeg, or gif';
                $uploadOk = false;
                goto skip;
            }
    
            if (file_exists($target_file)) {
                $movedFile = true;
            } else {
                $movedFile = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file);
            }
    
            if ($uploadOk) {
                if ($movedFile) {
                    $stmt = $__db->prepare("UPDATE videos SET thumbnail = :thumbnail WHERE rid = :rid");
                    $stmt->bindParam(":thumbnail", $target_name);
                    $stmt->bindParam(":rid", $_video['rid']);
                    $stmt->execute();
                } else {
                    $fileerror = 'fatal error';
                }
            }
        }
    } 

    skip:

    echo json_encode($request, JSON_PRETTY_PRINT);
?>