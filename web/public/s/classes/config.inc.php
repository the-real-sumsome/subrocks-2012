<?php
    $__server = (object) [
        "page_title" => "",
        "featured_channels" => array("bhief", "Xx_WalterWhite420_xX", "zulc22", "SuperKamekArea"),
        "ffmpeg_binary" => "ffmpeg", 
        "ffprobe_binary" => "ffprobe", 
        "ffmpeg_threads" => 2, 

        "page_embeds" => (object) [
            "page_title" => "",
            "page_description" => "",
            "page_url" => "",
            "page_image" => "",
        ],

        "db_properties" => (object) [
            "db_user" => "root",
            "db_password" => "root",
            "db_host" => "mysql",
            "db_database" => "fulptube",
            "db_connected" => false,
        ], 

        "video_properties" => (object) [ "status" => "unloaded" ],
        "user_properties"  => (object) [ "status" => "unloaded" ],
        "group_properties" => (object) [ "status" => "unloaded" ],
        "forum_properties" => (object) [ "status" => "unloaded" ],
    ];

    try
    {
        $__db = new PDO("mysql:host=".$__server->db_properties->db_host.";dbname=".$__server->db_properties->db_database.";charset=utf8mb4",
            $__server->db_properties->db_user,
            $__server->db_properties->db_password,
            [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        $__server->db_properties->db_connected = true;
    }
    catch(PDOException $e)
    {
        die("An error occured connecting to the database: ".$e->getMessage());
    }

    session_start();
?>