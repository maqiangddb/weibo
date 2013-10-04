delimiter $$

CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `twit_id` int(10) unsigned NOT NULL COMMENT '所评论的微博的id',
  `text` char(255) NOT NULL DEFAULT '',
  `role_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='评论表'$$

delimiter $$

CREATE TABLE `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ip` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `twit_id` int(10) unsigned NOT NULL,
  `comment_id` int(10) unsigned NOT NULL,
  `origin_id` int(10) unsigned NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COMMENT='记录'$$

delimiter $$

CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` char(100) NOT NULL DEFAULT '',
  `avatar` char(100) NOT NULL DEFAULT '',
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COMMENT='用户表 其实就是角色'$$

delimiter $$

CREATE TABLE `twit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `origin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '原微博，0表示没有',
  `text` char(255) NOT NULL DEFAULT '',
  `role_id` int(10) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COMMENT='微博表'$$

