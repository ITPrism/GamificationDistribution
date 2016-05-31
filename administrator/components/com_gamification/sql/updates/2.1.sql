CREATE TABLE IF NOT EXISTS `#__gfy_rewards` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(64) NOT NULL DEFAULT '',
  `note` varchar(255) DEFAULT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `points` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `points_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `group_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__gfy_achievements` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(64) NOT NULL DEFAULT '',
  `note` varchar(255) DEFAULT NULL,
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `params` varchar(2048) NOT NULL DEFAULT '{}',
  `group_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__gfy_goals` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `context` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(64) NOT NULL DEFAULT '',
  `activity_text` varchar(256) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ordering` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `params` varchar(2048) NOT NULL DEFAULT '{}',
  `group_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_gfygoals_context` (`context`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__gfy_usergoals` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `goal_id` int(10) UNSIGNED NOT NULL,
  `accomplished` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `accomplished_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;