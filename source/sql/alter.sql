-- 2012-7-19 已经发布
ALTER TABLE `weibo`.`twit` ADD COLUMN `origin` INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `id`;

-- 2012-7-20 已经发布
ALTER TABLE `weibo`.`user` ADD COLUMN `avatar` CHAR(100)  NOT NULL DEFAULT '' AFTER `name`;

-- 2012-7-22 已经发布
ALTER TABLE `weibo`.`user` RENAME TO `weibo`.`role`;

-- 2012-7-26 已经发布
ALTER TABLE `weibo`.`twit` ADD COLUMN `scene` INT(10)  NOT NULL DEFAULT 0 AFTER `origin`;

-- 2012-7-26 已经发布
ALTER TABLE `weibo`.`twit` ADD COLUMN `will_del` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `id`;
ALTER TABLE `weibo`.`user` ADD COLUMN `kind` ENUM('admin','normal')  NOT NULL DEFAULT 'normal' AFTER `open_id`;

-- 2012-7-26 已经发布
ALTER TABLE `weibo`.`scene` ADD COLUMN `will_del` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `id`;

-- 2012-7-27 已经发布
ALTER TABLE `weibo`.`scene` ADD COLUMN `hot` INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `description`;
-- 已经发布
ALTER TABLE `weibo`.`twit` ADD COLUMN `hot` INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `retweet_num`;
ALTER TABLE `weibo`.`open_id` MODIFY COLUMN `platform` ENUM('cookie','QQ','新浪微博')  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, AUTO_INCREMENT = 184;

-- 2012-7-27 已经发布
ALTER TABLE `weibo`.`role` ADD COLUMN `hot` INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `is_v`;
