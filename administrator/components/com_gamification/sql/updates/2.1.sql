ALTER TABLE `#__gfy_badges` ADD `activity_text` VARCHAR(256) NULL DEFAULT NULL AFTER `note`;
ALTER TABLE `#__gfy_ranks` ADD `activity_text` VARCHAR(256) NULL DEFAULT NULL AFTER `note`;

CREATE TABLE IF NOT EXISTS `#__gfy_achievements` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `context` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(64) DEFAULT NULL,
  `image_small` varchar(64) DEFAULT NULL,
  `image_square` varchar(64) DEFAULT NULL,
  `activity_text` varchar(256) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ordering` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `custom_data` varchar(256) NOT NULL DEFAULT '{}',
  `rewards` varchar(256) NOT NULL DEFAULT '{}',
  `group_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__gfy_challenges` (
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

CREATE TABLE IF NOT EXISTS `#__gfy_rewards` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(64) DEFAULT NULL,
  `image_small` varchar(64) DEFAULT NULL,
  `image_square` varchar(64) DEFAULT NULL,
  `activity_text` varchar(256) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `number` tinyint(3) UNSIGNED DEFAULT NULL,
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `points` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `points_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `group_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__gfy_userachievements` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `achievement_id` int(10) UNSIGNED NOT NULL,
  `accomplished` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `accomplished_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;