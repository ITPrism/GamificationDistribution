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