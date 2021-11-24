<?php

/**
* @Auther: bhief
* @Version: 1.0
* @Added Base
*
* Use this class for getting user information
*
**/
class user_helper {
    public $__db;

	public function __construct($conn){
        $this->__db = $conn;
	}

    function fetch_pfp($username) {
        $stmt = $this->__db->prepare("SELECT pfp FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pfp = $row['pfp'];
        } // why the while statement? just remove it (i cant be bothered to)

        return (isset($pfp) ? $pfp : "default.png");
    }

    
    function fetch_unread_pms($user) {
        $stmt = $this->__db->prepare("SELECT * FROM pms WHERE touser = :user AND readed = 'y'");
        $stmt->bindParam(":user", $user);
        $stmt->execute();
    
        return $stmt->rowCount();
    }

    function if_blocked($user, $reciever) {
        $stmt = $this->__db->prepare("SELECT reciever FROM block WHERE sender = :user AND reciever = :reciever");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":reciever", $reciever);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }    

    function if_admin($user) {
        $stmt = $this->__db->prepare("SELECT status FROM users WHERE username = :user AND status = 'admin'");
        $stmt->bindParam(":user", $user);;
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }    

    function if_partner($user) {
        $stmt = $this->__db->prepare("SELECT partner FROM users WHERE username = :user AND partner = 'y'");
        $stmt->bindParam(":user", $user);;
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }    
    
    function if_cooldown($user) {
        $stmt = $this->__db->prepare("SELECT * FROM users WHERE username = :username AND cooldown_comment >= NOW() - INTERVAL 1 MINUTE");
        $stmt->bindParam(":username", $user);
        $stmt->execute();
        
        return $stmt->rowCount() === 1;
    }

    function if_upload_cooldown($user) {
        $stmt = $this->__db->prepare("SELECT * FROM users WHERE username = :username AND upload_cooldown >= NOW() - INTERVAL 10 MINUTE");
        $stmt->bindParam(":username", $user);
        $stmt->execute();
        
        return $stmt->rowCount() === 1;
    }

    function fetch_user_username($username) {
        $stmt = $this->__db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));
    }

    function user_exists($user) {
        $stmt = $this->__db->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(":username", $user);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    function if_subscribed($user, $reciever) {
        $stmt = $this->__db->prepare("SELECT reciever FROM subscribers WHERE sender = :sender AND reciever = :reciever");
        $stmt->bindParam(":sender", $user);
        $stmt->bindParam(":reciever", $reciever);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    function fetch_subs_count($username) {
        $stmt = $this->__db->prepare("SELECT * FROM subscribers WHERE reciever = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->rowCount();
    }

    function fetch_user_videos(string $id) {
        $stmt = $this->__db->prepare("SELECT rid FROM videos WHERE author = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->rowCount();
    }

    function fetch_user_favorites(string $username) {
        $stmt = $this->__db->prepare("SELECT reciever FROM favorite_video WHERE sender = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute(); 
    
        return $stmt->rowCount();
    }

    function fetch_subscriptions($username) {
        $stmt = $this->__db->prepare("SELECT * FROM subscribers WHERE sender = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    
        return $stmt->rowCount();
    }

    function get_channel_views(string $rid) {
        $stmt = $this->__db->prepare("SELECT * FROM channel_views WHERE channel = :rid");
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();
        
        return $stmt->rowCount();
    }

    function fetch_friends_accepted($username) {
        $stmt = $this->__db->prepare("SELECT * FROM friends WHERE reciever = :username AND status = 'a'");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    
        $friends = $stmt->rowCount();

        $stmt = $this->__db->prepare("SELECT * FROM friends WHERE sender = :username AND status = 'a'");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    
        return $friends + $stmt->rowCount();
    }
}

?>