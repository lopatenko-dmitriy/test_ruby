/*
Navicat MySQL Data Transfer

Source Server         : denver
Source Server Version : 50545
Source Host           : localhost:3306
Source Database       : ruby

Target Server Type    : MYSQL
Target Server Version : 50545
File Encoding         : 65001

Date: 2016-09-01 01:33:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ru_projects`
-- ----------------------------
DROP TABLE IF EXISTS `ru_projects`;
CREATE TABLE `ru_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `create` int(11) DEFAULT NULL,
  `update` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ru_tasks`
-- ----------------------------
DROP TABLE IF EXISTS `ru_tasks`;
CREATE TABLE `ru_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `create` int(11) DEFAULT NULL,
  `update` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order` (`order`),
  KEY `order` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


