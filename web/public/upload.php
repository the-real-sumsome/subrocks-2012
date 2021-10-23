<?php
 
if (empty($_FILES) || $_FILES["file"]["error"]) {
  die('{"OK": 0}');
}
 
$fileName = $_FILES["file"]["name"];
move_uploaded_file($_FILES["file"]["tmp_name"], "dynamic/pfp/$fileName");
 
die('{"OK": 1}');
?>