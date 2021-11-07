SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `fulptube` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `fulptube`;

CREATE TABLE `admin_logs` (
  `id` int NOT NULL,
  `log` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `bans` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `reason` varchar(1024) NOT NULL,
  `expire` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `moderator` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `block` (
  `id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `channel_views` (
  `id` int NOT NULL,
  `viewer` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `viewed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `toid` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comment_likes` (
  `id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL,
  `type` varchar(1) NOT NULL DEFAULT 'l'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comment_reply` (
  `id` int NOT NULL,
  `toid` int NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` varchar(1024) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `favorite_video` (
  `id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `forum_category` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `lastmodified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `forum_replies` (
  `id` int NOT NULL,
  `contents` varchar(1000) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(255) NOT NULL,
  `toid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `forum_thread` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `contents` varchar(1024) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `friends` (
  `id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `group_discussion` (
  `id` int NOT NULL,
  `toid` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `group_members` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `togroup` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `history` (
  `id` int NOT NULL,
  `video` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL,
  `type` varchar(1) NOT NULL DEFAULT 'l'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `playlists` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `rid` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `videos` varchar(10000) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pms` (
  `id` int NOT NULL,
  `touser` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `readed` varchar(1) NOT NULL DEFAULT 'n',
  `video_attribute` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(2) NOT NULL DEFAULT 'nm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `profile_comments` (
  `id` int NOT NULL,
  `toid` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` varchar(512) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `quicklist_videos` (
  `id` int NOT NULL,
  `video` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `report` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `sender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `stars` (
  `id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL,
  `type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ugc_ads` (
  `id` int NOT NULL,
  `approved` varchar(1) NOT NULL DEFAULT 'n',
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bio` varchar(2000) NOT NULL DEFAULT '',
  `pfp` varchar(255) NOT NULL DEFAULT 'default.png',
  `featured` varchar(255) NOT NULL DEFAULT 'None',
  `status` varchar(255) NOT NULL DEFAULT 'normal',
  `channel_layout` varchar(512) NOT NULL DEFAULT '{"0":"Recent Videos","1":"All Playlists"}',
  `2012_bg` varchar(255) NOT NULL DEFAULT 'default.png',
  `2012_bgoption` varchar(10) NOT NULL DEFAULT 'repeatxy',
  `2012_bgcolor` varchar(25) NOT NULL DEFAULT '#ffffff',
  `channellayout2012` varchar(2) NOT NULL DEFAULT 'de',
  `primary_color` varchar(255) NOT NULL DEFAULT '#666',
  `secondary_color` varchar(255) NOT NULL DEFAULT '#e6e6e6',
  `third_color` varchar(255) NOT NULL DEFAULT '#fff',
  `text_color` varchar(255) NOT NULL DEFAULT '#fff',
  `primary_color_text` varchar(255) NOT NULL DEFAULT '#000',
  `banner` varchar(255) NOT NULL DEFAULT '',
  `subbutton` varchar(255) NOT NULL DEFAULT '',
  `2009_bg` varchar(255) NOT NULL DEFAULT 'default.png',
  `2009_bgoption` varchar(255) NOT NULL DEFAULT 'repeatxy',
  `2009_bgcolor` varchar(255) NOT NULL DEFAULT '#ffffff ',
  `2009_user_left` varchar(255) NOT NULL DEFAULT 'main;stat;subscription',
  `2009_user_right` varchar(255) NOT NULL DEFAULT 'recent;subscribers;friends;discussion',
  `layout` varchar(5) NOT NULL DEFAULT '1',
  `cooldown_comment` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upload_cooldown` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `border_color` varchar(255) NOT NULL DEFAULT '#000',
  `country` varchar(255) NOT NULL DEFAULT 'None',
  `website` varchar(64) NOT NULL DEFAULT '',
  `custom_header` varchar(255) NOT NULL DEFAULT '',
  `custom_text` varchar(512) NOT NULL DEFAULT '',
  `featured_channels` varchar(255) NOT NULL DEFAULT '',
  `transparency` varchar(3) NOT NULL DEFAULT '1.0',
  `genre` varchar(255) NOT NULL DEFAULT 'None',
  `css` varchar(2048) NOT NULL DEFAULT '',
  `partner` varchar(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `user_groups` (
  `id` int NOT NULL,
  `group_title` varchar(255) NOT NULL,
  `group_description` varchar(1024) NOT NULL,
  `group_author` varchar(255) NOT NULL,
  `group_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `group_picture` varchar(255) NOT NULL DEFAULT 'default.png',
  `group_category` varchar(255) NOT NULL DEFAULT 'None'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `videos` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(8192) NOT NULL,
  `tags` varchar(1024) NOT NULL,
  `rid` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL DEFAULT '0',
  `visibility` varchar(1) NOT NULL DEFAULT 'n',
  `commenting` varchar(1) NOT NULL DEFAULT 'a',
  `xml` longtext NOT NULL,
  `captions` varchar(255) NOT NULL DEFAULT 'sample.vtt',
  `category` varchar(60) NOT NULL DEFAULT 'None',
  `featured` varchar(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `video_response` (
  `id` int NOT NULL,
  `toid` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `views` (
  `id` int NOT NULL,
  `viewer` varchar(255) NOT NULL,
  `videoid` varchar(255) NOT NULL,
  `viewed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `block`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `channel_views`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comment_reply`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `favorite_video`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_replies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_thread`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `group_discussion`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `profile_comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quicklist_videos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stars`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ugc_ads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `video_response`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `admin_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `bans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `block`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `channel_views`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `comment_likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `comment_reply`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `favorite_video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `forum_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `forum_replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `forum_thread`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `friends`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `group_discussion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `group_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `playlists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `pms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `profile_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `quicklist_videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `stars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `ugc_ads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `video_response`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `views`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
