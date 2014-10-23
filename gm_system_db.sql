-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 �?10 �?23 �?13:40
-- 服务器版本: 5.6.14-log
-- PHP 版本: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `gm_system_db`
--
CREATE DATABASE IF NOT EXISTS `gm_system_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gm_system_db`;

-- --------------------------------------------------------

--
-- 表的结构 `report_permission`
--

DROP TABLE IF EXISTS `report_permission`;
CREATE TABLE IF NOT EXISTS `report_permission` (
  `permission_level` int(11) NOT NULL,
  `permission_name` char(16) NOT NULL,
  `permission_list` text NOT NULL,
  PRIMARY KEY (`permission_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `report_permission`
--

INSERT INTO `report_permission` (`permission_level`, `permission_name`, `permission_list`) VALUES
(999, '超级管理员', 'All');

-- --------------------------------------------------------

--
-- 表的结构 `report_user`
--

DROP TABLE IF EXISTS `report_user`;
CREATE TABLE IF NOT EXISTS `report_user` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30016078106 ;

--
-- 转存表中的数据 `report_user`
--

INSERT INTO `report_user` (`guid`, `user_name`, `user_pass`, `user_founder`, `user_lastlogin`, `permission_level`, `permission_name`, `user_fromwhere`, `user_status`) VALUES
(30016078101, 'johnnyeven', 'b40714d351a35e8f0d2f15ee977da4a9f5a7e2cd', 1, 0, 999, '超级管理员', 'en_default', 1);

-- --------------------------------------------------------

--
-- 表的结构 `system_log`
--

DROP TABLE IF EXISTS `system_log`;
CREATE TABLE IF NOT EXISTS `system_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_action` varchar(64) NOT NULL,
  `log_uri` varchar(128) NOT NULL,
  `log_parameter` text NOT NULL,
  `log_time` int(11) NOT NULL,
  `log_guid` bigint(20) NOT NULL,
  `log_name` char(16) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `system_permission`
--

DROP TABLE IF EXISTS `system_permission`;
CREATE TABLE IF NOT EXISTS `system_permission` (
  `permission_level` int(11) NOT NULL,
  `permission_name` char(16) NOT NULL,
  `permission_list` text NOT NULL,
  PRIMARY KEY (`permission_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `system_permission`
--

INSERT INTO `system_permission` (`permission_level`, `permission_name`, `permission_list`) VALUES
(999, '超级管理员', 'All');

-- --------------------------------------------------------

--
-- 表的结构 `system_user`
--

DROP TABLE IF EXISTS `system_user`;
CREATE TABLE IF NOT EXISTS `system_user` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30016078105 ;

--
-- 转存表中的数据 `system_user`
--

INSERT INTO `system_user` (`guid`, `user_name`, `user_pass`, `user_founder`, `user_lastlogin`, `permission_level`, `permission_name`, `user_fromwhere`, `user_status`) VALUES
(30016078101, 'johnnyeven', 'b40714d351a35e8f0d2f15ee977da4a9f5a7e2cd', 1, 0, 999, '超级管理员', 'en_default', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
