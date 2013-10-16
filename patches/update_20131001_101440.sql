DROP TABLE IF EXISTS `user_config`;

CREATE TABLE `user_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `user` ADD `user_config` INT  NULL  DEFAULT NULL  AFTER `test_column1`;
