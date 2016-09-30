/*
Navicat MySQL Data Transfer

Source Server         : 天成-52.78.37.253
Source Server Version : 50629
Source Host           : 52.78.37.253:3306
Source Database       : tiancheng

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2016-09-30 15:18:56
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

-- ----------------------------
-- Records of ek_member_day_cash
-- ----------------------------
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160620', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160706', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160712', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160719', '1670.00');
INSERT INTO `ek_member_day_cash` VALUES ('3', '20160719', '-85.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160719', '1636.10');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160720', '310.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160721', '10.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160721', '1600.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160801', '1000.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160804', '256.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160806', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('3', '20160807', '0.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160810', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160814', '500.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160815', '1700.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160816', '2101.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160817', '700.00');
INSERT INTO `ek_member_day_cash` VALUES ('3', '20160817', '-500.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160817', '4165.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160831', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160907', '101.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160907', '102.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160910', '200.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160910', '500.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160912', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160912', '110.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160913', '800.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160913', '300.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160913', '600.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160914', '1800.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160914', '2491.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160914', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160915', '2105.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160915', '700.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160915', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160916', '1400.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160916', '3124.00');
INSERT INTO `ek_member_day_cash` VALUES ('1', '20160916', '300.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160917', '300.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160917', '400.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160918', '600.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160919', '500.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160920', '11000.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160920', '700.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160921', '900.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160921', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160922', '400.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160922', '300.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160923', '600.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160924', '3500.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160925', '500.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160925', '746.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160926', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160927', '200.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160928', '950.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160928', '745.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160929', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160929', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('2', '20160930', '100.00');
INSERT INTO `ek_member_day_cash` VALUES ('11', '20160930', '150.00');
