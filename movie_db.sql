/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : movie_db

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2025-07-30 11:37:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for movies
-- ----------------------------
DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of movies
-- ----------------------------
INSERT INTO `movies` VALUES ('1', '肖申克的救赎', '剧情', '美国', '1994', '9.7', '肖申克的救赎.jpg', 'https://movie.douban.com/subject/1292052/');
INSERT INTO `movies` VALUES ('2', '阿甘正传', '剧情', '美国', '1994', '9.5', '阿甘正传.jpg', 'https://movie.douban.com/subject/1292720/');
INSERT INTO `movies` VALUES ('3', '泰坦尼克号', '爱情', '美国', '1997', '9.4', '泰坦尼克号.jpg', 'https://movie.douban.com/subject/1292722/');
INSERT INTO `movies` VALUES ('4', '霸王别姬', '剧情', '中国', '1993', '9.6', '霸王别姬.jpg', 'https://movie.douban.com/subject/1291546/');
INSERT INTO `movies` VALUES ('5', '这个杀手不太冷', '动作', '法国', '1994', '9.4', '这个杀手不太冷.jpg', 'https://movie.douban.com/subject/1295644/');
INSERT INTO `movies` VALUES ('6', '星际穿越', '科幻', '美国', '2014', '9.3', '星际穿越.jpg', 'https://movie.douban.com/subject/1889243/');
INSERT INTO `movies` VALUES ('9', '盗梦空间', '科幻', '美国', '2010', '9.3', '盗梦空间.jpg', 'https://movie.douban.com/subject/3541415/');
INSERT INTO `movies` VALUES ('10', '熔炉', '剧情', '韩国', '2013', '9.2', '熔炉.jpg', 'https://movie.douban.com/subject/6786002/');
INSERT INTO `movies` VALUES ('11', '摔跤吧！爸爸', '运动', '印度', '2016', '9.0', '摔跤吧！爸爸.jpg', 'https://movie.douban.com/subject/26387939/');
INSERT INTO `movies` VALUES ('12', '楚门的世界', '剧情', '美国', '1998', '9.2', '楚门的世界.jpg', 'https://movie.douban.com/subject/1292064/');
INSERT INTO `movies` VALUES ('13', '海上钢琴师', '音乐', '意大利', '1998', '9.3', '海上钢琴师.jpg', 'https://movie.douban.com/subject/1292001/');
INSERT INTO `movies` VALUES ('14', '寄生虫', '剧情', '韩国', '2019', '8.8', '寄生虫.jpg', 'https://movie.douban.com/subject/27010768/');
INSERT INTO `movies` VALUES ('15', '寻梦环游记', '动画', '美国', '2017', '9.1', '寻梦环游记.jpg', 'https://movie.douban.com/subject/20495023/');
INSERT INTO `movies` VALUES ('17', '你的名字', '动画', '日本', '2016', '8.9', '你的名字.jpg', 'https://movie.douban.com/subject/26683290/');

-- ----------------------------
-- Table structure for recommendations
-- ----------------------------
DROP TABLE IF EXISTS `recommendations`;
CREATE TABLE `recommendations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reason` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of recommendations
-- ----------------------------
INSERT INTO `recommendations` VALUES ('5', '3', '灌篮高手', '体育');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', '1', '$2y$10$/2OOjyr.z.Douk1rcVoF7OlJOfS1/JaJuIfwZ2/1ZWww6vXsimAmS');
INSERT INTO `users` VALUES ('3', 'admin1', '$2y$10$6eu/0N5SNi4phGrl3boE6uZ4aJYYpUSRF92XQE.VRSgpNTE.quh6G');
INSERT INTO `users` VALUES ('4', 'lkh', '$2y$10$10TeKsMRCP/vGJtZfORNKuBcdAJ6zBibCoV96lLJPYnIum8t9a2ue');
INSERT INTO `users` VALUES ('5', 'admin0', '$2y$10$yfzGc8z4gGc7TGkkZt.DdOg5sd7mpVgYzVqbOat5itF4Be5jL6QZq');
