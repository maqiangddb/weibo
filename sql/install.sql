-- 创建数据库

CREATE DATABASE IF NOT EXISTS weibo CHARACTER SET UTF8 COLLATE utf8_general_ci;

USE weibo;

-- 用户表 其实就是角色
CREATE TABLE IF NOT EXISTS `role`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `name` CHAR(100) NOT NULL DEFAULT '',
    `avatar` CHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 微博表
CREATE TABLE IF NOT EXISTS `twit`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    origin INT(10) UNSIGNED NOT NULL DEFAULT 0 comment '原微博，0表示没有',
    `text` CHAR(255) NOT NULL DEFAULT '',
    `role_id` INT(10) NOT NULL,
    `created` timestamp NOT NULL,
    PRIMARY KEY(id),
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 评论表
CREATE TABLE IF NOT EXISTS `comment`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    twit_id INT(10) UNSIGNED NOT NULL comment '所评论的微博的id',
    `text` CHAR(255) NOT NULL DEFAULT '',
    `created` DATETIME NOT NULL,
    `role_id` INT(10) NOT NULL,
    PRIMARY KEY(id),
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 记录
CREATE TABLE IF NOT EXISTS `log` -- user is watching role
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `ip` INT(10) UNSIGNED NOT NULL, -- user id
    `role_id` INT(10) UNSIGNED NOT NULL, -- user id
    `twit_id` INT(10) UNSIGNED NOT NULL, -- role id
    `comment_id` INT(10) UNSIGNED NOT NULL, -- role id
    `origin_id` INT(10) UNSIGNED NOT NULL, -- role id
    PRIMARY KEY(id),
    UNIQUE KEY(`user`, `role`)
) ENGINE=MyISAM AUTO_INCREMENT=101;
