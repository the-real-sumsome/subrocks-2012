<?php

/**
* @Auther: bhief
* @Version: 1.0
*
* Gets info from videos 
*
**/
class video_helper {
    public $__db;

    public function sh_exec(string $cmd, string $outputfile = "", string $pidfile = "", bool $mergestderror = true, bool $bg = false) {
        $fullcmd = $cmd;
        if(strlen($outputfile) > 0) $fullcmd .= " >> " . $outputfile;
        if($mergestderror) $fullcmd .= " 2>&1";
        
        if($bg) {
            $fullcmd = "nohup " . $fullcmd . " &";
            if(strlen($pidfile)) $fullcmd .= " echo $! > " . $pidfile;
        } else {
            if(strlen($pidfile) > 0) $fullcmd .= "; echo $$ > " . $pidfile;
        }
        shell_exec($fullcmd);
    }

    function file_get_contents_chunked($file, $chunk_size, $callback) {
        try {
            $handle = fopen($file, "r");
            $i = 0;
            while (!feof($handle)) {
                call_user_func_array($callback,array(fread($handle,$chunk_size),&$handle,$i));
                $i++;
            }
    
            fclose($handle);
        }
        catch(Exception $e) {
            trigger_error("file_get_contents_chunked::" . $e->getMessage(),E_USER_NOTICE);
            return false;
        }

        return true;
    }

	public function __construct($conn){
        $this->__db = $conn;
	}

    function fetch_video_views(string $id) {
        $stmt = $this->__db->prepare("SELECT * FROM views WHERE videoid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->rowCount();
    }

    function fetch_views_from_user($user) {
        $stmt = $this->__db->prepare("SELECT `rid` FROM videos WHERE author = :username");
        $stmt->bindParam(":username", $user);
        $stmt->execute();
        
        $views = 0;
        while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            $views = $views + $this->fetch_video_views($video['rid']);
        }
        return $views;
        $stmt->close();
    }

    function get_comments_from_video($id) {
        $stmt = $this->__db->prepare("SELECT * FROM comments WHERE toid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        return $stmt->rowCount();
    }

    /* Function by daylin */
    function timeToSeekEquation($time) { 
        $times = preg_split('/:/', $time);
        $timesc = count($times);
        $final = '';
        if ($times[0] != 0) {
            for ($i = 0; $i < $timesc; $i++) {
                $remaining = $timesc - $i - 1;
                if ($i < $timesc - 1) {
                    $final.=$times[$i].'*'.(60 ** $remaining).'+';
                } else {
                    $final.=$times[$i];
                }
            }
        } else {
            $final = $times[1];
        }
        return $final;
    }

    function shorten_description(string $description, int $limit, bool $newlines = false) {
        $description = trim($description);
        if(strlen($description) >= $limit) {
            $description = substr($description, 0, $limit) . "...";
        } 

        $description = htmlspecialchars($description);
        if($newlines) { $description = str_replace(PHP_EOL, "<br>", $description); }
        $description = preg_replace("/@([a-zA-Z0-9-]+|\\+\\])/", "<a href='/user/$1'>@$1</a>", $description);
        $description = preg_replace("/((\d{1,2}:)+\d{2})/", "<a onclick=\"yt.www.watch.player.seekTo('$1', false)\">$1</a>", $description);
        return $description;
    }

    function get_video_responses($id) {
        $stmt = $this->__db->prepare("SELECT * FROM video_response WHERE toid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        return $stmt->rowCount();
    }

    function get_video_likes($reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT `sender` FROM likes WHERE reciever = :reciever AND type = 'l'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount();
        } else {
            $stmt = $this->__db->prepare("SELECT `sender` FROM likes WHERE reciever = :reciever AND type = 'd'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount();
        }
    }

    function check_view($vidid, $user) {
        $stmt = $this->__db->prepare("SELECT * FROM views WHERE viewer = :viewer AND videoid = :rid");
        $stmt->bindParam(":viewer", $user);
        $stmt->bindParam(":rid", $vidid);
        $stmt->execute();
        if($stmt->rowCount() === 0) {
            $this->add_view($vidid, $user);
        }
    }

    function add_view($vidid, $user) {
        $stmt = $this->__db->prepare("INSERT INTO views (viewer, videoid) VALUES (:user, :vidid)");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":vidid", $vidid);
        $stmt->execute();
    }

    function get_comment_likes($reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT `sender` FROM comment_likes WHERE reciever = :reciever AND type = 'l'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount();
        } else {
            $stmt = $this->__db->prepare("SELECT `sender` FROM comment_likes WHERE reciever = :reciever AND type = 'd'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount();
        }
    }

    function if_liked($user, $reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT `sender` FROM likes WHERE sender = :sender AND reciever = :reciever AND type = 'l'");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount() === 1;
        } else {
            $stmt = $this->__db->prepare("SELECT `sender` FROM likes WHERE sender = :sender AND reciever = :reciever AND type = 'd'");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount() === 1;
        }
    }

    function if_comment_liked($user, $reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT `sender` FROM comment_likes WHERE sender = :sender AND reciever = :reciever AND type = 'l'");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount() === 1;
        } else {
            $stmt = $this->__db->prepare("SELECT `sender` FROM comment_likes WHERE sender = :sender AND reciever = :reciever AND type = 'd'");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

            return $stmt->rowCount() === 1;
        }
    }

    function fetch_video_rid(string $rid) {
        $stmt = $this->__db->prepare("SELECT * FROM videos WHERE rid = :rid");
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));
    }

    function fetch_playlist_rid(string $rid) {
        $stmt = $this->__db->prepare("SELECT * FROM playlists WHERE rid = :rid");
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));
    }

    function fetch_comment_id(string $id) {
        $stmt = $this->__db->prepare("SELECT * FROM comments WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));
    }

    function get_video_stars_level($id, $level) {
        $stmt = $this->__db->prepare("SELECT * FROM stars WHERE reciever = :id AND type = :lvl");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":lvl", $level, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->rowCount();
    }

    function video_exists($video) {
        $stmt = $this->__db->prepare("SELECT rid FROM videos WHERE rid = :rid");
        $stmt->bindParam(":rid", $video);
        $stmt->execute();
        
        return $stmt->rowCount() === 1;
    }

    function if_favorited($user, $reciever) {
        $stmt = $this->__db->prepare("SELECT `reciever` FROM favorite_video WHERE sender = :user AND reciever = :reciever");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":reciever", $reciever);
        $stmt->execute();
        
        return $stmt->rowCount() === 1;
    }

    function fetch_user_videos($v) {
        $stmt = $this->__db->prepare("SELECT rid FROM videos WHERE author = :v");
        $stmt->bindParam(":v", $v);
        $stmt->execute(); 
    
        return $stmt->rowCount();
    }
}


/* SHITTY FIX INCOMING FOR EMBEDS - MOVE SO IT'S IN EVERY PAGE WHEN POSSIBLE AND NOT LAZY */
$__server->page_embeds->page_title = "SubRocks - " . $__server->page_title;
$__server->page_embeds->page_description = "Welcome to a Youtube recreation dedicated to replecating 2012's YouTube layout.";
$__server->page_embeds->page_url = "https://subrock.rocks/";
?>