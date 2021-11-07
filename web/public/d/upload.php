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
    $rid = "";
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_';
    for ($i = 0; $i < 11; $i++)
        $rid .= $characters[mt_rand(0, 63)];

    $video_properties = (object) [
        'video_rid' => $rid,
        'video_title' => $_POST['title'],
        'video_description' => $_POST['description'],
        'video_tags' => $_POST['tags'],
        'video_category' => $_POST['category'],
        'video_availability' => $_POST['privacy'],
        'video_filename' => "", // we will update this later
        'video_thumbnail' => "",
        'video_xml' => "",
        'video_duration' => 0,
        'video_author' => $_SESSION['siteusername']
    ];

    $video_validation = (object) [
        'upload_ok' => true,
        'upload_error' => "",
        'moved_files' => true,
        'video_file_type' => "." . strtolower(pathinfo($_FILES["video_file"]["name"], PATHINFO_EXTENSION)),
        'target_upload_name' => md5_file($_FILES["video_file"]["tmp_name"]) . ".mp4",
    ];

    // $_FILES['video_file']['tmp_name'] = substr_replace($_FILES['video_file']['tmp_name'], '/', 8, 0);
    /* -- /tmp/phpfAN4Xu -- Why in the fuck does this happen? I love PHP */

    if($__user_h->if_upload_cooldown($_SESSION['siteusername'])) { 
        $video_validation->upload_error = "Under an upload cooldown";
        $video_validation->upload_ok = 0;
    }

    if(move_uploaded_file(
        $_FILES['video_file']['tmp_name'], 
        "../dynamic/temp/" . $video_properties->video_rid . $video_validation->video_file_type
    )) {
        $video_properties->video_filename = "../dynamic/temp/" . $video_properties->video_rid . $video_validation->video_file_type;
    } else {
        $video_validation->upload_error = "Failed to move temp file to dynamic folder. Pottential IO/permission problem." . $_FILES['video_file']['error'];
        $video_validation->upload_ok = 0;
    }

    if( $video_validation->video_file_type == ".png" || 
        $video_validation->video_file_type == ".jpg" || 
        $video_validation->video_file_type == ".jpeg" || 
        $video_validation->video_file_type == ".gif"
    ) {
        $video_validation->upload_error = "You cannot upload an image as a video." . $_FILES['video_file']['error'];
        $video_validation->upload_ok = 0;
    }
        

    /* 
        I'm going to hopefully guess that
        user input is fine because I moved
        the temp video name to a randomly 
        generated video ID.....
    */

    if ($video_validation->upload_ok == true) {

        /* Get the video duration. */
        $video_properties->video_duration = shell_exec('
            ' . $__server->ffprobe_binary . ' -i "' . $video_properties->video_filename . '" -show_entries format=duration -v quiet -of csv="p=0" 2>&1
        ');

        $video_properties->video_duration = round($video_properties->video_duration);

        /* Process the video... */
        $video_validation->video_processing_logs = shell_exec('
            ' . $__server->ffmpeg_binary . ' -hide_banner -loglevel error -i "' . $video_properties->video_filename . '" -vcodec h264 -acodec aac -pix_fmt yuv420p -threads 2 -preset medium -vf "scale=-1:480,pad=ceil(iw/2)*2:ceil(ih/2)*2" -b:v 1500k "../dynamic/videos/' . $video_properties->video_rid . '.mp4" 2>&1
        ');


        /* Process the thumbnail... */
        $video_properties->video_thumbnail = shell_exec('
            ' . $__server->ffmpeg_binary . ' -hide_banner -loglevel error -i "../dynamic/videos/' . $video_properties->video_rid . '.mp4" -vf "select=eq(n\\,34),scale=-1:360" -vframes 1 "../dynamic/thumbs/' . $video_properties->video_rid . '.png" 2>&1
        ');
        
        /* For some reason, I have to do this manually for only the thumbnail */
        
        /* TODO: fetch 3 pngs' from video stream and somehow get them to the 
           ploader and let the user select which auto-gen thumbnail is best */
        $video_properties->video_thumbnail = $video_properties->video_rid . '.png';
        $video_properties->video_filename = $video_properties->video_rid . '.mp4';

        $stmt = $__db->prepare("INSERT INTO videos 
                                    (title, author, filename, thumbnail, description, tags, rid, duration, xml, category) 
                                VALUES 
                                    (:title, :author, :filename, :thumbnail, :description, :tags, :rid, :duration, :xml, :category)");
        $stmt->bindParam(":title", $video_properties->video_title);
        $stmt->bindParam(":author", $video_properties->video_author);
        $stmt->bindParam(":filename", $video_properties->video_filename);
        $stmt->bindParam(":thumbnail", $video_properties->video_thumbnail);
        $stmt->bindParam(":description", $video_properties->video_description);
        $stmt->bindParam(":tags", $video_properties->video_tags);
        $stmt->bindParam(":rid", $video_properties->video_rid);
        $stmt->bindParam(":duration", $video_properties->video_duration);
        $stmt->bindParam(":xml", $video_properties->video_xml);
        $stmt->bindParam(":category", $video_properties->video_category);
        $stmt->execute();

        $__user_u->update_cooldown_time($_SESSION['siteusername'], "upload_cooldown");
        echo($video_properties->video_rid);
    } else {
        die($video_validation->upload_error);
    }
?>