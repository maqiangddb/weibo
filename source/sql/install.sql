-- 创建数据库

CREATE DATABASE IF NOT EXISTS weibo CHARACTER SET UTF8 COLLATE utf8_general_ci;

USE weibo;

-- 用户表 其实就是角色
CREATE TABLE IF NOT EXISTS `role`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `name` CHAR(100) NOT NULL DEFAULT '',
    `avatar` CHAR(100) NOT NULL DEFAULT '',
    is_v TINYINT(1) NOT NULL DEFAULT 0,
    hot INT(10) NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 微博表
CREATE TABLE IF NOT EXISTS `twit`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    will_del TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, -- 是否即将被删除
    origin INT(10) UNSIGNED NOT NULL DEFAULT 0, -- 原微博，0表示没有
    scene INT(10) UNSIGNED NOT NULL DEFAULT 0, -- 场景，0表示默认的微博
    `text` CHAR(255) NOT NULL DEFAULT '',
    `image` CHAR(255) NOT NULL DEFAULT '',
    `time` DATETIME NOT NULL,
    `author` INT(10) NOT NULL,
    `comment_num` INT(10) NOT NULL DEFAULT 0,
    `retweet_num` INT(10) NOT NULL DEFAULT 0,
    `hot` INT(10) NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY(author) REFERENCES `user`(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 评论表
CREATE TABLE IF NOT EXISTS `comment`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    twit INT(10) UNSIGNED NOT NULL, -- 所评论的微博的id
    `text` CHAR(255) NOT NULL DEFAULT '',
    `time` DATETIME NOT NULL,
    `author` INT(10) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(twit) REFERENCES `twit`(id),
    FOREIGN KEY(author) REFERENCES `user`(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 用户表
CREATE TABLE IF NOT EXISTS `user`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `open_id` INT(10) UNSIGNED NOT NULL, -- 默认id
    `kind` ENUM('admin', 'normal') NOT NULL DEFAULT 'normal', -- 默认id
    `create_time` DATETIME NOT NULL,
    `active_time` DATETIME NOT NULL,
    PRIMARY KEY(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- open id
CREATE TABLE IF NOT EXISTS `open_id`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `user` INT(10) UNSIGNED NOT NULL,
    platform ENUM('QQ','新浪微博', 'cookie') NOT NULL, -- 平台名称，如果qq weibo等等
    `open_id` CHAR(128) NOT NULL DEFAULT '', -- 平台名称，如果qq weibo等等
    `time` DATETIME NOT NULL, -- 创建时间
    PRIMARY KEY(id),
    FOREIGN KEY(`user`) REFERENCES `user`(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- watch list
CREATE TABLE IF NOT EXISTS `watch` -- user is watching role
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `user` INT(10) UNSIGNED NOT NULL, -- user id
    `role` INT(10) UNSIGNED NOT NULL, -- role id
    PRIMARY KEY(id),
    UNIQUE KEY(`user`, `role`)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- scene 场景
CREATE TABLE IF NOT EXISTS `scene`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    will_del TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `name` CHAR(100) NOT NULL DEFAULT '',
    `description` TEXT NOT NULL, -- role id
    `hot` INT(10) NOT NULL DEFAULT 0, -- how hot it is
    PRIMARY KEY(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 演员表
CREATE TABLE IF NOT EXISTS `actor`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    ip CHAR(20) NOT NULL DEFAULT '',
    `role` INT(10) UNSIGNED NOT NULL,
    hit INT(10) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    UNIQUE KEY(ip, `role`),
    FOREIGN KEY(`role`) REFERENCES `role`(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 角色标签
CREATE TABLE IF NOT EXISTS `role_tag`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    tag CHAR(100) NOT NULL DEFAULT '',
    PRIMARY KEY(id),
    UNIQUE KEY(`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 角色和标签关系表
CREATE TABLE IF NOT EXISTS `role_tag_relation`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    tag INT(10) UNSIGNED NOT NULL,
    `role` INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY(`tag`, `role`)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 用户顶伪博
CREATE TABLE IF NOT EXISTS `user_up_twit`
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `user` INT(10) UNSIGNED NOT NULL,
    `twit` INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY(`user`, `twit`),
    FOREIGN KEY(`user`) REFERENCES `user`(id),
    FOREIGN KEY(`twit`) REFERENCES `twit`(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

--- ===================未发布================
-- 用户扮演某个角色，在这里有记录
CREATE TABLE IF NOT EXISTS `user_act_role` -- user is watching role
(
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `user` INT(10) UNSIGNED NOT NULL, -- user id
    `role` INT(10) UNSIGNED NOT NULL, -- role id
    PRIMARY KEY(id),
    UNIQUE KEY(`user`, `role`)
) ENGINE=MyISAM AUTO_INCREMENT=101;