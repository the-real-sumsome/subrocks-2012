<?php

/**
* @Auther: bhief
* @Version: 1.0
*
* Updates video information
*
**/
class video_updater {
    public $__db;

	public function __construct($conn){
        $this->__db = $conn;
	}

    function update_row($video, $rowName, $new) {
        $stmt = $this->__db->prepare("UPDATE videos SET ".$rowName." = :new WHERE rid = :rid");
        $stmt->bindParam(":new", $new);
        $stmt->bindParam(":rid", $video);
        $stmt->execute();
        
        return true;
    }

    function playlist_update_row($video, $rowName, $new) {
        $stmt = $this->__db->prepare("UPDATE playlists SET ".$rowName." = :new WHERE rid = :rid");
        $stmt->bindParam(":new", $new);
        $stmt->bindParam(":rid", $video);
        $stmt->execute();
        
        return true;
    }
}

?>