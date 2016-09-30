/*
Navicat MySQL Data Transfer

Source Server         : 33-119.9.90.26
Source Server Version : 50542
Source Host           : 119.9.90.26:3306
Source Database       : 33gew_db

Target Server Type    : MYSQL
Target Server Version : 50542
File Encoding         : 65001

Date: 2016-09-30 14:22:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ek_member_day_cash
-- ----------------------------
DROP TABLE IF EXISTS `ek_member_day_cash`;
CREATE TABLE `ek_member_day_cash` (
  `type` int(11) NOT NULL,
  `daytime` varchar(30) NOT NULL,
  `cash` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`type`,`daytime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
