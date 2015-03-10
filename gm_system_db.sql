/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : gm_system_db

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2015-03-10 11:04:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for report_permission
-- ----------------------------
DROP TABLE IF EXISTS `report_permission`;
CREATE TABLE `report_permission` (
  `permission_level` int(11) NOT NULL,
  `permission_name` char(16) NOT NULL,
  `permission_list` text NOT NULL,
  PRIMARY KEY (`permission_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of report_permission
-- ----------------------------
INSERT INTO `report_permission` VALUES ('999', '超级管理员', 'All');

-- ----------------------------
-- Table structure for report_user
-- ----------------------------
DROP TABLE IF EXISTS `report_user`;
CREATE TABLE `report_user` (
  `guid` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` char(32) NOT NULL,
  `user_pass` char(64) NOT NULL,
  `user_founder` tinyint(4) NOT NULL DEFAULT '0',
  `user_lastlogin` int(11) NOT NULL DEFAULT '0',
  `permission_level` int(11) NOT NULL,
  `permission_name` char(16) NOT NULL,
  `user_fromwhere` char(16) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB AUTO_INCREMENT=30016078102 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of report_user
-- ----------------------------
INSERT INTO `report_user` VALUES ('30016078101', 'johnnyeven', 'b40714d351a35e8f0d2f15ee977da4a9f5a7e2cd', '1', '0', '999', '超级管理员', 'default', '1');

-- ----------------------------
-- Table structure for system_log
-- ----------------------------
DROP TABLE IF EXISTS `system_log`;
CREATE TABLE `system_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_action` varchar(64) NOT NULL,
  `log_uri` varchar(128) NOT NULL,
  `log_parameter` text NOT NULL,
  `log_time` int(11) NOT NULL,
  `log_guid` bigint(20) NOT NULL,
  `log_name` char(16) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_log
-- ----------------------------

-- ----------------------------
-- Table structure for system_permission
-- ----------------------------
DROP TABLE IF EXISTS `system_permission`;
CREATE TABLE `system_permission` (
  `permission_level` int(11) NOT NULL,
  `permission_name` char(16) NOT NULL,
  `permission_list` text NOT NULL,
  PRIMARY KEY (`permission_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_permission
-- ----------------------------
INSERT INTO `system_permission` VALUES ('999', '超级管理员', 'All');

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user` (
  `guid` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` char(32) NOT NULL,
  `user_pass` char(64) NOT NULL,
  `user_founder` tinyint(4) NOT NULL DEFAULT '0',
  `user_lastlogin` int(11) NOT NULL DEFAULT '0',
  `permission_level` int(11) NOT NULL,
  `permission_name` char(16) NOT NULL,
  `user_fromwhere` char(16) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB AUTO_INCREMENT=30016078102 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES ('30016078101', 'johnnyeven', 'b40714d351a35e8f0d2f15ee977da4a9f5a7e2cd', '1', '0', '999', '超级管理员', 'default', '1');
