/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : pg

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-09-19 00:46:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for kv_admin
-- ----------------------------
DROP TABLE IF EXISTS `kv_admin`;
CREATE TABLE `kv_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'uid',
  `username` varchar(32) NOT NULL COMMENT '帐号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `brand_id` mediumint(10) NOT NULL COMMENT '品牌id',
  `group_id` tinyint(3) NOT NULL DEFAULT '1' COMMENT '分组id',
  `maxmoney` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '管理员组，每天最大金额操作',
  `operatemoney` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作金额',
  `operatettime` int(11) NOT NULL DEFAULT '0' COMMENT '最后操作时间',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT '状态,Y启用，N禁用',
  `is_luck` char(1) NOT NULL DEFAULT 'N' COMMENT '锁定状态,Y锁定，N未锁定',
  `lucktime` int(11) DEFAULT NULL COMMENT '账号被锁定时间',
  `unlucktime` int(11) DEFAULT NULL COMMENT '解锁时间',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of kv_admin
-- ----------------------------
INSERT INTO `kv_admin` VALUES ('1', 'admin', 'c61719fc185a47d0ab80a350898a78ff', '1', '1', '0.00', '0.00', '0', 'Y', 'N', null, '1474198935', '0', 'N');

-- ----------------------------
-- Table structure for kv_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `kv_admin_group`;
CREATE TABLE `kv_admin_group` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '组名',
  `brand_id` mediumint(10) NOT NULL COMMENT '品牌id',
  `maxtotalcash` float(12,2) NOT NULL DEFAULT '0.00' COMMENT '允许最大操作总金额',
  `maxdaycash` float(12,2) DEFAULT '0.00' COMMENT '允许每天最大操作金额',
  `menus_sel` varchar(255) DEFAULT NULL COMMENT '查看权限，菜单id,用逗号分割',
  `menus_add` varchar(255) DEFAULT NULL COMMENT '添加权限，菜单id,用逗号分割',
  `menus_edit` varchar(255) DEFAULT NULL COMMENT '编辑权限，菜单id,用逗号分割',
  `menus_del` varchar(255) DEFAULT NULL COMMENT '删除权限，菜单id,用逗号分割',
  `menus_undo` char(1) DEFAULT 'N' COMMENT '冲正负,Y有，N无',
  `menus_exam` char(1) DEFAULT 'N' COMMENT '资金审核,Y有，N无',
  `menus_conf` char(1) DEFAULT 'N' COMMENT '资金确认,Y有，N无',
  `menus_admin` char(1) DEFAULT 'N' COMMENT '是否有超级权限',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理权限组';

-- ----------------------------
-- Records of kv_admin_group
-- ----------------------------
INSERT INTO `kv_admin_group` VALUES ('1', '超级管理员', '1', '0.00', '0.00', '', null, null, null, 'N', 'N', 'N', 'Y', 'N');
INSERT INTO `kv_admin_group` VALUES ('2', '品牌超级管理员', '1', '0.00', '0.00', null, null, null, null, 'N', 'N', 'N', 'N', 'N');

-- ----------------------------
-- Table structure for kv_brand
-- ----------------------------
DROP TABLE IF EXISTS `kv_brand`;
CREATE TABLE `kv_brand` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '品牌id',
  `name` varchar(50) NOT NULL COMMENT '品牌名称',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='品牌列表';

-- ----------------------------
-- Records of kv_brand
-- ----------------------------
INSERT INTO `kv_brand` VALUES ('1', 'ABC', '1460373364', 'N');

-- ----------------------------
-- Table structure for kv_brand_host
-- ----------------------------
DROP TABLE IF EXISTS `kv_brand_host`;
CREATE TABLE `kv_brand_host` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '品牌url id',
  `host` varchar(255) NOT NULL COMMENT 'url',
  `app` varchar(20) NOT NULL COMMENT '域名类型',
  `brand_id` int(10) NOT NULL COMMENT '品牌id',
  `agent_id` int(10) NOT NULL DEFAULT '0' COMMENT '代理id',
  `template_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '模板id',
  `addtime` int(11) NOT NULL,
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,N否，Y是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='品牌url表';

-- ----------------------------
-- Records of kv_brand_host
-- ----------------------------
INSERT INTO `kv_brand_host` VALUES ('1', 'www.pg.com', 'home', '1', '0', '2', '1460373364', 'N');
INSERT INTO `kv_brand_host` VALUES ('2', 'admin.pg.com', 'admin', '1', '0', '1', '1460373364', 'N');

-- ----------------------------
-- Table structure for kv_brand_template
-- ----------------------------
DROP TABLE IF EXISTS `kv_brand_template`;
CREATE TABLE `kv_brand_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '模板',
  `is_admin` char(1) NOT NULL DEFAULT 'N' COMMENT 'Y后台管理员,N前台会员',
  `addtime` int(11) NOT NULL,
  `del` varchar(255) NOT NULL DEFAULT 'N' COMMENT '是否已删除,N否，Y是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='网站模板';

-- ----------------------------
-- Records of kv_brand_template
-- ----------------------------
INSERT INTO `kv_brand_template` VALUES ('1', 'MA201609171', 'Y', '0', 'N');
INSERT INTO `kv_brand_template` VALUES ('2', 'MW201609171', 'N', '0', 'N');

-- ----------------------------
-- Table structure for kv_developer_action
-- ----------------------------
DROP TABLE IF EXISTS `kv_developer_action`;
CREATE TABLE `kv_developer_action` (
  `action` varchar(30) NOT NULL COMMENT '操作方式',
  `name` varchar(20) NOT NULL COMMENT '操作名称',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除',
  PRIMARY KEY (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作方式表';

-- ----------------------------
-- Records of kv_developer_action
-- ----------------------------
INSERT INTO `kv_developer_action` VALUES ('add', '添加', 'N');
INSERT INTO `kv_developer_action` VALUES ('del', '删除', 'N');
INSERT INTO `kv_developer_action` VALUES ('edit', '修改', 'N');
INSERT INTO `kv_developer_action` VALUES ('list', '列表', 'N');

-- ----------------------------
-- Table structure for kv_developer_menu
-- ----------------------------
DROP TABLE IF EXISTS `kv_developer_menu`;
CREATE TABLE `kv_developer_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '菜单名称',
  `url` varchar(100) DEFAULT NULL COMMENT '菜单链接',
  `action` varchar(100) DEFAULT NULL COMMENT '操作',
  `parent_id` int(10) DEFAULT '0' COMMENT '父类id',
  `sort` smallint(4) DEFAULT '0' COMMENT '从大到小',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜单级别',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y启用，N关闭',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除，Y已删除，N未删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of kv_developer_menu
-- ----------------------------
INSERT INTO `kv_developer_menu` VALUES ('1', '系统设置', '', null, '0', '11', '1', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('2', '菜单设置', 'setting-menu.html', null, '1', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('3', '会员管理', '', null, '0', '3', '1', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('4', '会员列表', 'users-list.html', null, '3', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('18', '管理组管理', 'setting-group.html', null, '1', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('19', '管理员管理', 'setting-manager.html', null, '1', '96', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('23', '代理管理', '', null, '0', '5', '1', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('24', '代理列表', 'agent-list.html', null, '23', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('25', '会员级别', 'users-group.html', null, '3', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('27', '资金管理', '', null, '0', '4', '1', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('28', '资金记录', 'money-note.html', null, '27', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('29', '资金类型', 'money-type.html', null, '27', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('30', '日志记录', '', null, '0', '13', '1', 'N', 'N');
INSERT INTO `kv_developer_menu` VALUES ('31', '操作记录', 'log-operate.html', null, '30', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('32', '管理登录', 'log-login_admin.html', null, '30', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('33', '会员登录', 'log-login_users.html', null, '30', '95', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('34', '代理登录', 'log-login_agent.html', null, '30', '93', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('35', '开发管理', '', null, '0', '1', '1', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('36', '菜单管理', 'developer-menus.html', 'list', '35', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('37', '游戏管理', '', null, '0', '98', '1', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('38', '推广管理', '', null, '0', '10', '1', 'N', 'N');
INSERT INTO `kv_developer_menu` VALUES ('39', '推广统计', '', null, '38', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('40', '来源统计', '', null, '38', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('41', '好友推荐', '', null, '38', '95', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('42', '活动管理', '', null, '0', '8', '1', 'N', 'N');
INSERT INTO `kv_developer_menu` VALUES ('43', '优惠活动', '', null, '42', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('44', '信息管理', '', null, '0', '9', '1', 'N', 'N');
INSERT INTO `kv_developer_menu` VALUES ('45', '运营公告', '', null, '44', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('46', '系统通知', '', null, '44', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('47', '站内信息', '', null, '44', '95', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('48', '短信发送', '', null, '44', '93', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('49', '用户留言', '', null, '44', '91', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('50', '资金记录', '/log-money.html', null, '30', '91', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('51', '银行卡管理', '/money-bank.html', null, '27', '95', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('55', '管理登录', '/log-login_admin.html', null, '30', '96', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('58', 'IP黑白名单', '/setting-ip.html', null, '1', '93', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('59', 'API设置', '/setting-api.html', null, '1', '91', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('60', '网站设置', '/setting-web.html', null, '1', '89', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('61', 'URL管理', '', null, '0', '7', '1', 'N', 'N');
INSERT INTO `kv_developer_menu` VALUES ('62', 'URL设置', '/url-setting.html', null, '61', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('63', 'URL列表', '/url-list.html', null, '61', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('64', '会员银行卡', '/users-bank.html', null, '3', '95', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('65', '游戏管理', '', null, '0', '6', '1', 'N', 'N');
INSERT INTO `kv_developer_menu` VALUES ('66', '游戏类型', '/game-type.html', null, '65', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('67', '代理设置', '/agent-host.html', null, '23', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('68', '网站版本', '/agent-version.html', null, '23', '93', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('69', '游戏设置', '/agent-game.html', null, '23', '97', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('70', '服务器设置', '/setting-server.html', null, '1', '98', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('71', '优惠设置', '/setting-sale.html', null, '1', '89', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('72', '网站管理', '', null, '0', '2', '1', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('73', '网站域名', '/web-list.html', null, '72', '99', '2', 'Y', 'N');
INSERT INTO `kv_developer_menu` VALUES ('74', '浏览记录', '/log-view.html', null, '30', '96', '2', 'Y', 'N');

-- ----------------------------
-- Table structure for kv_log_login
-- ----------------------------
DROP TABLE IF EXISTS `kv_log_login`;
CREATE TABLE `kv_log_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '登录帐号',
  `explain` varchar(50) NOT NULL DEFAULT '' COMMENT '登录日志说明',
  `operate_no` varchar(20) NOT NULL COMMENT '操作编码',
  `ip` varchar(50) NOT NULL COMMENT '登陆ip',
  `brand_id` int(10) NOT NULL COMMENT '品牌id',
  `is_admin` char(1) NOT NULL DEFAULT 'N' COMMENT 'Y后台管理员,N前台会员',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y登录成功，N登录失败',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT 'Y后台管理员,N前台会员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 COMMENT='会员和管理员登陆日志';

-- ----------------------------
-- Records of kv_log_login
-- ----------------------------
INSERT INTO `kv_log_login` VALUES ('4', 'abc', '账号不存在', 'd468fon3a05bw65c92', '127.0.0.1', '1', 'Y', 'N', '1461670678', 'N');
INSERT INTO `kv_log_login` VALUES ('5', 'admin', '登录成功', '19i39jb6qe9k5i4282', '127.0.0.1', '1', 'Y', 'Y', '1461670891', 'N');
INSERT INTO `kv_log_login` VALUES ('6', 'admin', '登录成功', 'jdf4864oi205dfdgx1', '127.0.0.1', '1', 'Y', 'Y', '1461670934', 'N');
INSERT INTO `kv_log_login` VALUES ('7', 'admin', '登录成功', '22jmw272329240667b', '192.168.88.90', '1', 'Y', 'Y', '1461683560', 'N');
INSERT INTO `kv_log_login` VALUES ('8', 'admin', '登录成功', 'fjxlz001v079dr5e97', '192.168.88.90', '1', 'Y', 'Y', '1461683642', 'N');
INSERT INTO `kv_log_login` VALUES ('9', 'admin', '登录成功', '8ca8qy51xu475mzc2x', '192.168.88.90', '1', 'Y', 'Y', '1461683722', 'N');
INSERT INTO `kv_log_login` VALUES ('10', 'admin', 'session错误', '163a7fd0df0dr05m5v', '192.168.88.90', '1', 'Y', 'N', '1461685609', 'N');
INSERT INTO `kv_log_login` VALUES ('11', 'admin', 'session错误', '44c5v5np297776514b', '192.168.88.90', '1', 'Y', 'N', '1461685713', 'N');
INSERT INTO `kv_log_login` VALUES ('12', 'admin', '登录失败', '89n578f768xg588af5', '192.168.88.90', '1', 'Y', 'N', '1461686162', 'N');
INSERT INTO `kv_log_login` VALUES ('13', 'admin', '登录失败', 'fwj2f470e977osit8z', '192.168.88.90', '1', 'Y', 'N', '1461686164', 'N');
INSERT INTO `kv_log_login` VALUES ('14', 'admin', '登录失败', '1af5u5a7v9ci015o55', '192.168.88.90', '1', 'Y', 'N', '1461686172', 'N');
INSERT INTO `kv_log_login` VALUES ('15', 'admin', '登录成功', 'dd751m43ez300k51t3', '192.168.88.90', '1', 'Y', 'Y', '1461686251', 'N');
INSERT INTO `kv_log_login` VALUES ('16', 'admin', '登录成功', 'jffda0tc58q26tf4c9', '127.0.0.1', '1', 'Y', 'Y', '1462182407', 'N');
INSERT INTO `kv_log_login` VALUES ('17', 'admin', '登录成功', 'ltdie9e9oo7w2s4954', '127.0.0.1', '1', 'Y', 'Y', '1462182425', 'N');
INSERT INTO `kv_log_login` VALUES ('18', 'admin', '登录失败', 'e8dta5q48v2w3n234z', '127.0.0.1', '1', 'Y', 'N', '1462188115', 'N');
INSERT INTO `kv_log_login` VALUES ('19', 'admin', '登录失败', 'fbe113c803k7sb95qf', '127.0.0.1', '1', 'Y', 'N', '1462188118', 'N');
INSERT INTO `kv_log_login` VALUES ('20', 'admin', '登录失败', '4cwv29019yf606f538', '127.0.0.1', '1', 'Y', 'N', '1462188123', 'N');
INSERT INTO `kv_log_login` VALUES ('21', 'admin', '登录成功', '1gah25a4of15by0ac5', '127.0.0.1', '1', 'Y', 'Y', '1462258847', 'N');
INSERT INTO `kv_log_login` VALUES ('22', 'admin', '登录成功', 'ahb126v9i0bk50t579', '127.0.0.1', '1', 'Y', 'Y', '1462259550', 'N');
INSERT INTO `kv_log_login` VALUES ('23', 'admin', '登录成功', '8e0x5n07t6745fi8rs', '127.0.0.1', '1', 'Y', 'Y', '1462272541', 'N');
INSERT INTO `kv_log_login` VALUES ('24', 'admin', '登录成功', '44c127b886lsq55536', '127.0.0.1', '1', 'Y', 'Y', '1462335907', 'N');
INSERT INTO `kv_log_login` VALUES ('25', 'admin', '密码错误', 'habm5635u5y8zu2d8c', '127.0.0.1', '1', 'Y', 'N', '1462355042', 'N');
INSERT INTO `kv_log_login` VALUES ('26', 'admin', '密码错误', '10303dlfak004w53fl', '127.0.0.1', '1', 'Y', 'N', '1462356605', 'N');
INSERT INTO `kv_log_login` VALUES ('27', 'admin', '密码错误', 'b4n5497c32c29an3dq', '127.0.0.1', '1', 'Y', 'N', '1462356608', 'N');
INSERT INTO `kv_log_login` VALUES ('28', 'admin', '密码错误', '13b928e971165321gk', '127.0.0.1', '1', 'Y', 'N', '1462356612', 'N');
INSERT INTO `kv_log_login` VALUES ('29', 'admin', '密码错误', '994tvd0ep081555n43', '127.0.0.1', '1', 'Y', 'N', '1462356615', 'N');
INSERT INTO `kv_log_login` VALUES ('30', 'admin', '密码错误', '6vb7acfe2u6h87t4ka', '127.0.0.1', '1', 'Y', 'N', '1462356617', 'N');
INSERT INTO `kv_log_login` VALUES ('31', 'admin', '密码错误', 'r1862885pexnos4r45', '127.0.0.1', '1', 'Y', 'N', '1462356619', 'N');
INSERT INTO `kv_log_login` VALUES ('32', 'admin', '密码错误', '7d0nhaebkfb9bu56cd', '127.0.0.1', '1', 'Y', 'N', '1462356621', 'N');
INSERT INTO `kv_log_login` VALUES ('33', 'admin', '密码错误', 'v46x432c9o154fbl2t', '127.0.0.1', '1', 'Y', 'N', '1462356873', 'N');
INSERT INTO `kv_log_login` VALUES ('34', 'admin', '密码错误', '73e38ccsfy7rc9571v', '127.0.0.1', '1', 'Y', 'N', '1462359881', 'N');
INSERT INTO `kv_log_login` VALUES ('35', 'admin', '密码错误', 't001zzdt7nq09gm945', '127.0.0.1', '1', 'Y', 'N', '1462359983', 'N');
INSERT INTO `kv_log_login` VALUES ('36', 'admin', '登录失败', 'x2265kd72y77059279', '127.0.0.1', '1', 'Y', 'N', '1462360026', 'N');
INSERT INTO `kv_log_login` VALUES ('37', 'admin', '登录失败', '1794508zc3yev7n87c', '127.0.0.1', '1', 'Y', 'N', '1462360029', 'N');
INSERT INTO `kv_log_login` VALUES ('38', 'admin', '登录失败', '8dbook81j7h4b4w4m9', '127.0.0.1', '1', 'Y', 'N', '1462360035', 'N');
INSERT INTO `kv_log_login` VALUES ('39', 'admin', '登录失败', '2766g0ix0a32bdfo4d', '127.0.0.1', '1', 'Y', 'N', '1462360096', 'N');
INSERT INTO `kv_log_login` VALUES ('40', 'admin', '登录失败', '939244ovsks0y0298a', '127.0.0.1', '1', 'Y', 'N', '1462360099', 'N');
INSERT INTO `kv_log_login` VALUES ('41', 'admin', '登录失败', '02nqua427621z3d989', '127.0.0.1', '1', 'Y', 'N', '1462360102', 'N');
INSERT INTO `kv_log_login` VALUES ('42', 'admin', '登录失败', 'v714b2ue6f58ot8543', '127.0.0.1', '1', 'Y', 'N', '1462360132', 'N');
INSERT INTO `kv_log_login` VALUES ('43', 'admin', '密码错误', '9cueck9rx821b41l9m', '127.0.0.1', '1', 'Y', 'N', '1462360149', 'N');
INSERT INTO `kv_log_login` VALUES ('44', 'admin', '密码错误', '47e348u05c40cw4p1z', '127.0.0.1', '1', 'Y', 'N', '1462360156', 'N');
INSERT INTO `kv_log_login` VALUES ('45', 'admin', '密码错误', 'b3ky70d7c6163c6qh4', '127.0.0.1', '1', 'Y', 'N', '1462360158', 'N');
INSERT INTO `kv_log_login` VALUES ('46', 'admin', '密码错误', '95bbn740afiz549cje', '127.0.0.1', '1', 'Y', 'N', '1462360202', 'N');
INSERT INTO `kv_log_login` VALUES ('47', 'admin', '密码错误', 'j71f8v8ay6d3i7706u', '127.0.0.1', '1', 'Y', 'N', '1462360213', 'N');
INSERT INTO `kv_log_login` VALUES ('48', 'admin', '登录失败', '8f5f8bdq0z1e378p0b', '127.0.0.1', '1', 'Y', 'N', '1462360300', 'N');
INSERT INTO `kv_log_login` VALUES ('49', 'admin', '密码错误', 'd9748eh5b5g57c5942', '127.0.0.1', '1', 'Y', 'N', '1462360372', 'N');
INSERT INTO `kv_log_login` VALUES ('50', 'admin', '密码错误', '2po358vmk6019ta01g', '127.0.0.1', '1', 'Y', 'N', '1462360390', 'N');
INSERT INTO `kv_log_login` VALUES ('51', 'admin', '密码错误', '6a2au974v5ci329o1c', '127.0.0.1', '1', 'Y', 'N', '1462360443', 'N');
INSERT INTO `kv_log_login` VALUES ('52', 'admin', '密码错误', 'fd711m7b1z582kfeta', '127.0.0.1', '1', 'Y', 'N', '1462360477', 'N');
INSERT INTO `kv_log_login` VALUES ('53', 'admin', '密码错误', '974o69lw0rs13c6730', '127.0.0.1', '1', 'Y', 'N', '1462360490', 'N');
INSERT INTO `kv_log_login` VALUES ('54', 'admin', '密码错误', 'a9f588629s6i5c163v', '127.0.0.1', '1', 'Y', 'N', '1462360493', 'N');
INSERT INTO `kv_log_login` VALUES ('55', 'admin', '密码错误', '9811a61c52x6f5n258', '127.0.0.1', '1', 'Y', 'N', '1462360503', 'N');
INSERT INTO `kv_log_login` VALUES ('56', 'admin', '密码错误', 'e2j170n26por23aajd', '127.0.0.1', '1', 'Y', 'N', '1462360506', 'N');
INSERT INTO `kv_log_login` VALUES ('57', 'admin', '登录失败', 'f0285p3jeh9d7hc957', '127.0.0.1', '1', 'Y', 'N', '1462360508', 'N');
INSERT INTO `kv_log_login` VALUES ('58', 'admin', '登录失败', '3304a7pj973d767ga6', '127.0.0.1', '1', 'Y', 'N', '1462360511', 'N');
INSERT INTO `kv_log_login` VALUES ('59', 'admin', '密码错误', '7x5bevyccj800d797b', '127.0.0.1', '1', 'Y', 'N', '1462598027', 'N');
INSERT INTO `kv_log_login` VALUES ('60', 'admin', '密码错误', 'd7vs5az747bukfziqi', '127.0.0.1', '1', 'Y', 'N', '1462598032', 'N');
INSERT INTO `kv_log_login` VALUES ('61', 'admin', '登录成功', 'e5cc59c0889fedw89r', '127.0.0.1', '1', 'Y', 'Y', '1462598038', 'N');
INSERT INTO `kv_log_login` VALUES ('62', 'admin', '密码错误', 'n6882gq93d5749bd72', '127.0.0.1', '1', 'Y', 'N', '1462598069', 'N');
INSERT INTO `kv_log_login` VALUES ('63', 'admin', '密码错误', '06a130226xa5x08172', '127.0.0.1', '1', 'Y', 'N', '1462598072', 'N');
INSERT INTO `kv_log_login` VALUES ('64', 'admin', '登录失败', 'm226wv92y98oel0w7p', '127.0.0.1', '1', 'Y', 'N', '1462598075', 'N');
INSERT INTO `kv_log_login` VALUES ('65', 'admin', '登录失败', 'y4k3292ap3f65b5cqc', '127.0.0.1', '1', 'Y', 'N', '1462598077', 'N');
INSERT INTO `kv_log_login` VALUES ('66', 'admin', '登录失败', '94ygtnicz9m1g66d43', '127.0.0.1', '1', 'Y', 'N', '1462598080', 'N');
INSERT INTO `kv_log_login` VALUES ('67', 'admin', '登录失败', '09dg1uwz0p52ed8f9v', '127.0.0.1', '1', 'Y', 'N', '1462598082', 'N');
INSERT INTO `kv_log_login` VALUES ('68', 'admin', '密码错误', '012697272cok1g5dn1', '127.0.0.1', '1', 'Y', 'N', '1462598182', 'N');
INSERT INTO `kv_log_login` VALUES ('69', 'admin', '密码错误', '2cdr6x3px9hak7413j', '127.0.0.1', '1', 'Y', 'N', '1462598203', 'N');
INSERT INTO `kv_log_login` VALUES ('70', 'admin', '登录成功', 't81efde7708vq183p2', '127.0.0.1', '1', 'Y', 'Y', '1462598419', 'N');
INSERT INTO `kv_log_login` VALUES ('71', 'admin', '登录成功', 'jd2xt09fx0y23dp7ab', '127.0.0.1', '1', 'Y', 'Y', '1462771957', 'N');
INSERT INTO `kv_log_login` VALUES ('72', 'admin', '登录成功', 'mgnwag96151884d4nr', '127.0.0.1', '1', 'Y', 'Y', '1464151901', 'N');
INSERT INTO `kv_log_login` VALUES ('73', '123123', '账号不存在', '95251f6v79ss715x1p', '127.0.0.1', '1', 'Y', 'N', '1470896562', 'N');
INSERT INTO `kv_log_login` VALUES ('74', '2323', '账号不存在', '2941581z6oa0r3q7f5', '127.0.0.1', '1', 'Y', 'N', '1470896580', 'N');
INSERT INTO `kv_log_login` VALUES ('75', '2323', '账号不存在', 'w60183f6k6f006g915', '127.0.0.1', '1', 'Y', 'N', '1470896584', 'N');
INSERT INTO `kv_log_login` VALUES ('76', '2323', '账号不存在', '3e4d1p8s35va9d51el', '127.0.0.1', '1', 'Y', 'N', '1470896588', 'N');
INSERT INTO `kv_log_login` VALUES ('77', '2323', '账号不存在', '4m993c8886inx2c74b', '127.0.0.1', '1', 'Y', 'N', '1470896591', 'N');
INSERT INTO `kv_log_login` VALUES ('78', 'admin', '登录失败', '31bumdnu4i3n94f6ea', '127.0.0.1', '1', 'Y', 'N', '1470898384', 'N');
INSERT INTO `kv_log_login` VALUES ('79', 'admin', '登录失败', '1p3688t7bk97d7b342', '127.0.0.1', '1', 'Y', 'N', '1470898388', 'N');
INSERT INTO `kv_log_login` VALUES ('80', 'admin', '登录成功', '863f6b08592dwit86f', '127.0.0.1', '1', 'Y', 'Y', '1470898414', 'N');
INSERT INTO `kv_log_login` VALUES ('81', 'admin', '登录成功', 'd8f90c6s3w59q62er7', '127.0.0.1', '1', 'Y', 'Y', '1470900811', 'N');
INSERT INTO `kv_log_login` VALUES ('82', 'admin', '登录成功', '2m26nd6e3d7yznvtpo', '127.0.0.1', '1', 'Y', 'Y', '1470901642', 'N');
INSERT INTO `kv_log_login` VALUES ('83', 'admin', '登录成功', 'yy6aad571ac6288ar9', '127.0.0.1', '1', 'Y', 'Y', '1470901774', 'N');
INSERT INTO `kv_log_login` VALUES ('84', 'admin', '登录成功', 'a366xs006rltp8dm0e', '127.0.0.1', '1', 'Y', 'Y', '1470901876', 'N');
INSERT INTO `kv_log_login` VALUES ('85', 'admin', '登录成功', 'q74p7xt7lv4ocj4b5d', '127.0.0.1', '1', 'Y', 'Y', '1470902073', 'N');
INSERT INTO `kv_log_login` VALUES ('86', 'admin', '登录成功', 'k349sh1okn1x348fcu', '127.0.0.1', '1', 'Y', 'Y', '1471055833', 'N');
INSERT INTO `kv_log_login` VALUES ('87', 'admin', '登录成功', '4ft5130e9202mnkp0n', '127.0.0.1', '1', 'Y', 'Y', '1471243580', 'N');
INSERT INTO `kv_log_login` VALUES ('88', 'admin', '登录成功', '276z419r0y5cahebd3', '127.0.0.1', '1', 'Y', 'Y', '1471401912', 'N');
INSERT INTO `kv_log_login` VALUES ('89', 'admin', '登录成功', 'm2h8va5349388o7lf7', '127.0.0.1', '1', 'Y', 'Y', '1473386786', 'N');
INSERT INTO `kv_log_login` VALUES ('90', 'admin', '登录成功', 'gw903gu73fva9737fa', '127.0.0.1', '1', 'Y', 'Y', '1473386898', 'N');
INSERT INTO `kv_log_login` VALUES ('91', 'admin', '登录成功', '8m9653rcf6h01y4694', '127.0.0.1', '1', 'Y', 'Y', '1473387029', 'N');
INSERT INTO `kv_log_login` VALUES ('92', 'admin', '登录成功', '6rxy263529b7o224q3', '127.0.0.1', '1', 'Y', 'Y', '1473387104', 'N');
INSERT INTO `kv_log_login` VALUES ('93', 'admin', '登录成功', '9c8735z652kkc95as4', '127.0.0.1', '1', 'Y', 'Y', '1473387388', 'N');
INSERT INTO `kv_log_login` VALUES ('94', 'admin', '登录成功', '63dw5wgfbt77m8bq13', '127.0.0.1', '1', 'Y', 'Y', '1473387431', 'N');
INSERT INTO `kv_log_login` VALUES ('95', 'admin', '登录成功', 'r27ci4e959c8v2a19p', '127.0.0.1', '1', 'Y', 'Y', '1473387518', 'N');
INSERT INTO `kv_log_login` VALUES ('96', 'admin', '登录成功', '93fw958d4743stcb45', '127.0.0.1', '1', 'Y', 'Y', '1473387602', 'N');
INSERT INTO `kv_log_login` VALUES ('97', 'admin', '登录成功', 'o696md09dlf44c5d06', '127.0.0.1', '1', 'Y', 'Y', '1473387719', 'N');
INSERT INTO `kv_log_login` VALUES ('98', 'admin', '登录成功', '78c50t997zc395airq', '127.0.0.1', '1', 'Y', 'Y', '1473387740', 'N');
INSERT INTO `kv_log_login` VALUES ('99', 'admin', '登录成功', '4d0y7k05ula757xd8m', '127.0.0.1', '1', 'Y', 'Y', '1473387753', 'N');
INSERT INTO `kv_log_login` VALUES ('100', 'admin', '登录成功', '2006yf3z36n022c8sk', '127.0.0.1', '1', 'Y', 'Y', '1473387796', 'N');
INSERT INTO `kv_log_login` VALUES ('101', 'admin', '登录成功', '722qj8e7s234521qyb', '127.0.0.1', '1', 'Y', 'Y', '1473393493', 'N');
INSERT INTO `kv_log_login` VALUES ('102', 'admin', '登录成功', 'oj23eampw613769888', '127.0.0.1', '1', 'Y', 'Y', '1473393535', 'N');
INSERT INTO `kv_log_login` VALUES ('103', 'admin', '登录成功', 'bjrr3aw6151884xd5c', '127.0.0.1', '1', 'Y', 'Y', '1473393554', 'N');
INSERT INTO `kv_log_login` VALUES ('104', 'admin', '登录成功', '3u7882z4054a21k394', '127.0.0.1', '1', 'Y', 'Y', '1473393645', 'N');
INSERT INTO `kv_log_login` VALUES ('105', 'admin', '登录成功', 'zzpf6590yq7f3j3de8', '127.0.0.1', '1', 'Y', 'Y', '1473393715', 'N');
INSERT INTO `kv_log_login` VALUES ('106', 'admin', '登录成功', '094i0flwf3z5g3obu4', '127.0.0.1', '1', 'Y', 'Y', '1473393822', 'N');
INSERT INTO `kv_log_login` VALUES ('107', 'admin', '登录成功', 'ui51r263a46bc8dph0', '127.0.0.1', '1', 'Y', 'Y', '1473399455', 'N');
INSERT INTO `kv_log_login` VALUES ('108', 'admin', '登录成功', '6395w2225u18bf8144', '127.0.0.1', '1', 'Y', 'Y', '1473399494', 'N');
INSERT INTO `kv_log_login` VALUES ('109', 'admin', '登录成功', '8c9d38n9i486fco32x', '127.0.0.1', '1', 'Y', 'Y', '1473399518', 'N');
INSERT INTO `kv_log_login` VALUES ('110', 'admin', '登录成功', 'dar3055f50c0c5y6l4', '127.0.0.1', '1', 'Y', 'Y', '1473399915', 'N');
INSERT INTO `kv_log_login` VALUES ('111', 'admin', '登录成功', 'zekw01521f49u53s60', '127.0.0.1', '1', 'Y', 'Y', '1473399944', 'N');
INSERT INTO `kv_log_login` VALUES ('112', 'admin', '登录成功', '92025190j4133ctd54', '127.0.0.1', '1', 'Y', 'Y', '1473399972', 'N');
INSERT INTO `kv_log_login` VALUES ('113', 'admin', '登录成功', '6v5odqybcc1439r4ai', '127.0.0.1', '1', 'Y', 'Y', '1473399996', 'N');
INSERT INTO `kv_log_login` VALUES ('114', 'admin', '登录成功', '3n67p11de4a071ld40', '127.0.0.1', '1', 'Y', 'Y', '1473525202', 'N');
INSERT INTO `kv_log_login` VALUES ('115', 'admin', '登录成功', '57f7wntdx1yep1t20c', '127.0.0.1', '1', 'Y', 'Y', '1473583681', 'N');
INSERT INTO `kv_log_login` VALUES ('116', 'admin', '登录成功', '7e31u45469f8g4wxfl', '127.0.0.1', '1', 'Y', 'Y', '1473597882', 'N');
INSERT INTO `kv_log_login` VALUES ('117', 'admin', '登录成功', '67819i77qbi26yfa3x', '127.0.0.1', '1', 'Y', 'Y', '1474029307', 'N');
INSERT INTO `kv_log_login` VALUES ('118', 'admin', '登录成功', 'j6r6m9cfg68w287t30', '127.0.0.1', '1', 'Y', 'Y', '1474029369', 'N');
INSERT INTO `kv_log_login` VALUES ('119', 'admin', '登录成功', 'sl6yf1q1wmrb130cfd', '127.0.0.1', '1', 'Y', 'Y', '1474029386', 'N');
INSERT INTO `kv_log_login` VALUES ('120', 'admin', '登录成功', '4a2322xlf5854cg56i', '127.0.0.1', '1', 'Y', 'Y', '1474032728', 'N');
INSERT INTO `kv_log_login` VALUES ('121', 'admin', '登录成功', '279721xm725zl1v5e6', '127.0.0.1', '1', 'Y', 'Y', '1474113779', 'N');
INSERT INTO `kv_log_login` VALUES ('122', 'admin', '登录成功', 'mr76d571zt346i6cb4', '127.0.0.1', '1', 'Y', 'Y', '1474119997', 'N');
INSERT INTO `kv_log_login` VALUES ('123', 'admin', '登录成功', 'j440ifpth109afcdx6', '127.0.0.1', '1', 'Y', 'Y', '1474120059', 'N');
INSERT INTO `kv_log_login` VALUES ('124', 'admin', '登录成功', '88aq9prmhd5a59gnxc', '127.0.0.1', '1', 'Y', 'Y', '1474123490', 'N');
INSERT INTO `kv_log_login` VALUES ('125', 'admin', '登录成功', '7d1f69858b6d7b1npv', '127.0.0.1', '1', 'Y', 'Y', '1474125314', 'N');
INSERT INTO `kv_log_login` VALUES ('126', 'admin', '登录成功', 'o66ehem99u1393nf42', '127.0.0.1', '1', 'Y', 'Y', '1474125641', 'N');
INSERT INTO `kv_log_login` VALUES ('127', 'admin', '登录成功', '321n8r38ael3sf10yj', '127.0.0.1', '1', 'Y', 'Y', '1474194203', 'N');
INSERT INTO `kv_log_login` VALUES ('128', 'admin', '登录成功', '355fye2b0nf318axbb', '127.0.0.1', '1', 'Y', 'Y', '1474198935', 'N');

-- ----------------------------
-- Table structure for kv_log_notes
-- ----------------------------
DROP TABLE IF EXISTS `kv_log_notes`;
CREATE TABLE `kv_log_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(10) NOT NULL COMMENT '品牌id',
  `uid` int(11) NOT NULL COMMENT '操作人uid',
  `operator` varchar(100) NOT NULL COMMENT '操作人',
  `content` varchar(200) NOT NULL COMMENT '操作内容',
  `ip` varchar(50) NOT NULL COMMENT '操作ip',
  `is_admin` char(1) NOT NULL DEFAULT 'N' COMMENT 'Y后台管理员,N前台会员',
  `addtime` int(11) NOT NULL COMMENT '操作时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='操作记录表';

-- ----------------------------
-- Records of kv_log_notes
-- ----------------------------
INSERT INTO `kv_log_notes` VALUES ('1', '1', '1', '<span class=\'red\'>[超]</span>[超级管理员组]admin', '修改登录密码', '127.0.0.1', 'N', '1462339062', 'N');
INSERT INTO `kv_log_notes` VALUES ('4', '1', '1', '<span class=\'red\'>[超]</span>[超级管理员组]admin', '修改登录密码', '127.0.0.1', 'N', '1462598536', 'N');

-- ----------------------------
-- Table structure for kv_log_view
-- ----------------------------
DROP TABLE IF EXISTS `kv_log_view`;
CREATE TABLE `kv_log_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(10) NOT NULL COMMENT '品牌id',
  `uid` int(11) DEFAULT NULL COMMENT '用户ui',
  `username` varchar(32) DEFAULT NULL COMMENT '登录帐号',
  `content` varchar(100) DEFAULT NULL COMMENT '浏览记录',
  `ip` varchar(50) NOT NULL COMMENT '登陆ip',
  `is_admin` char(1) NOT NULL DEFAULT 'N' COMMENT 'Y后台管理员,N前台会员',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT 'Y后台管理员,N前台会员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员和管理员登陆日志';

-- ----------------------------
-- Records of kv_log_view
-- ----------------------------

-- ----------------------------
-- Table structure for kv_member
-- ----------------------------
DROP TABLE IF EXISTS `kv_member`;
CREATE TABLE `kv_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '登录帐号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `brand_id` mediumint(10) NOT NULL COMMENT '品牌id',
  `group_id` tinyint(2) DEFAULT '1' COMMENT '用户级别',
  `money` float(10,2) DEFAULT '0.00' COMMENT '账户余额',
  `transpassword` varchar(32) DEFAULT NULL COMMENT '取款密码',
  `parentid` int(11) DEFAULT '0' COMMENT '直属父类',
  `parenttree` varchar(200) DEFAULT ',' COMMENT '上级所有父类树，使用逗号分割(,1,2,3,....,n,)',
  `subordinatecount` mediumint(8) DEFAULT '0' COMMENT '直属下级会员个数',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT '帐号状态N冻结，Y正常',
  `is_luck` char(1) NOT NULL DEFAULT 'N' COMMENT '锁定状态,Y锁定，N未锁定',
  `truname` varchar(20) DEFAULT NULL COMMENT '用户姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号码',
  `email` varchar(50) DEFAULT NULL COMMENT '电子邮件',
  `birth` varchar(20) DEFAULT NULL COMMENT '出生日期Y-m-d',
  `registertime` int(11) DEFAULT NULL COMMENT '注册时间',
  `registerip` varchar(20) DEFAULT NULL COMMENT '注册ip',
  `logincount` int(11) DEFAULT '0' COMMENT '登录次数',
  `loginip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `logintime` int(11) DEFAULT NULL COMMENT '登录时间',
  `lastip` varchar(20) DEFAULT NULL COMMENT '最后一次登录ip',
  `lasttime` int(11) DEFAULT NULL COMMENT '最后一次登录时间',
  `firstmoney` float(10,2) DEFAULT '0.00' COMMENT '首存金额',
  `firsttime` int(11) DEFAULT NULL COMMENT '首存时间',
  `rebate` float(10,2) DEFAULT '0.00' COMMENT '返利总金额',
  `rebatetime` int(11) DEFAULT NULL COMMENT '最后返利时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`id`),
  KEY `user_agent_key` (`username`,`brand_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of kv_member
-- ----------------------------

-- ----------------------------
-- Table structure for kv_member_monitor
-- ----------------------------
DROP TABLE IF EXISTS `kv_member_monitor`;
CREATE TABLE `kv_member_monitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(10) NOT NULL COMMENT '品牌id',
  `username` varchar(50) NOT NULL COMMENT '用户账号',
  `title` varchar(100) NOT NULL COMMENT '用户浏览页面',
  `ip` varchar(50) NOT NULL COMMENT '用户ip',
  `pc_no` varchar(50) NOT NULL COMMENT '电脑记录编号',
  `lasttime` int(11) NOT NULL COMMENT '最后时间',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kv_member_monitor
-- ----------------------------

-- ----------------------------
-- Table structure for kv_session
-- ----------------------------
DROP TABLE IF EXISTS `kv_session`;
CREATE TABLE `kv_session` (
  `token` varchar(40) NOT NULL COMMENT 'cookie',
  `session` text NOT NULL COMMENT 'session',
  `uid` int(11) NOT NULL COMMENT '用户uid，用户或管理员',
  `is_admin` char(1) NOT NULL DEFAULT 'N' COMMENT 'Y后台管理员,N前台会员',
  `lasttime` int(11) NOT NULL COMMENT '最后修改时间',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kv_session
-- ----------------------------
INSERT INTO `kv_session` VALUES ('8u5mc2846a6h0ow4142ap07e3q97ab4b', '{\"user\":{\"id\":\"1\",\"username\":\"admin\",\"brand_id\":\"1\",\"group_id\":\"1\",\"maxmoney\":\"0.00\",\"operatemoney\":\"0.00\",\"operatettime\":\"0\",\"status\":\"Y\",\"is_luck\":\"N\",\"lucktime\":null,\"unlucktime\":\"1474123490\",\"addtime\":\"0\",\"del\":\"N\"},\"group\":{\"id\":\"1\",\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"brand_id\":\"1\",\"maxtotalcash\":\"0.00\",\"maxdaycash\":\"0.00\",\"menus_sel\":\"\",\"menus_add\":null,\"menus_edit\":null,\"menus_del\":null,\"menus_undo\":\"N\",\"menus_exam\":\"N\",\"menus_conf\":\"N\",\"menus_admin\":\"Y\",\"del\":\"N\"}}', '1', 'Y', '1474125314', '1474125314', 'N');
INSERT INTO `kv_session` VALUES ('c636rsk8660b4f22198fjoi1521fcv8s', '{\"user\":{\"id\":\"1\",\"username\":\"admin\",\"brand_id\":\"1\",\"group_id\":\"1\",\"maxmoney\":\"0.00\",\"operatemoney\":\"0.00\",\"operatettime\":\"0\",\"status\":\"Y\",\"is_luck\":\"N\",\"lucktime\":null,\"unlucktime\":\"1474125314\",\"addtime\":\"0\",\"del\":\"N\"},\"group\":{\"id\":\"1\",\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"brand_id\":\"1\",\"maxtotalcash\":\"0.00\",\"maxdaycash\":\"0.00\",\"menus_sel\":\"\",\"menus_add\":null,\"menus_edit\":null,\"menus_del\":null,\"menus_undo\":\"N\",\"menus_exam\":\"N\",\"menus_conf\":\"N\",\"menus_admin\":\"Y\",\"del\":\"N\"}}', '1', 'Y', '1474127033', '1474125641', 'N');
INSERT INTO `kv_session` VALUES ('q7bw24e2anj473578ef282ceh4b338a4', '{\"user\":{\"id\":\"1\",\"username\":\"admin\",\"brand_id\":\"1\",\"group_id\":\"1\",\"maxmoney\":\"0.00\",\"operatemoney\":\"0.00\",\"operatettime\":\"0\",\"status\":\"Y\",\"is_luck\":\"N\",\"lucktime\":null,\"unlucktime\":\"1474194203\",\"addtime\":\"0\",\"del\":\"N\"},\"group\":{\"id\":\"1\",\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"brand_id\":\"1\",\"maxtotalcash\":\"0.00\",\"maxdaycash\":\"0.00\",\"menus_sel\":\"\",\"menus_add\":null,\"menus_edit\":null,\"menus_del\":null,\"menus_undo\":\"N\",\"menus_exam\":\"N\",\"menus_conf\":\"N\",\"menus_admin\":\"Y\",\"del\":\"N\"}}', '1', 'Y', '1474215243', '1474198935', 'N');
INSERT INTO `kv_session` VALUES ('v785vdzj5d315q43595cfm34895fum9n', '{\"user\":{\"id\":\"1\",\"username\":\"admin\",\"brand_id\":\"1\",\"group_id\":\"1\",\"maxmoney\":\"0.00\",\"operatemoney\":\"0.00\",\"operatettime\":\"0\",\"status\":\"Y\",\"is_luck\":\"N\",\"lucktime\":null,\"unlucktime\":\"1474120059\",\"addtime\":\"0\",\"del\":\"N\"},\"group\":{\"id\":\"1\",\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"brand_id\":\"1\",\"maxtotalcash\":\"0.00\",\"maxdaycash\":\"0.00\",\"menus_sel\":\"\",\"menus_add\":null,\"menus_edit\":null,\"menus_del\":null,\"menus_undo\":\"N\",\"menus_exam\":\"N\",\"menus_conf\":\"N\",\"menus_admin\":\"Y\",\"del\":\"N\"}}', '1', 'Y', '1474124874', '1474123490', 'N');
INSERT INTO `kv_session` VALUES ('x6558omka9cgn9z58axfh64fu40y7b89', '{\"user\":{\"id\":\"1\",\"username\":\"admin\",\"brand_id\":\"1\",\"group_id\":\"1\",\"maxmoney\":\"0.00\",\"operatemoney\":\"0.00\",\"operatettime\":\"0\",\"status\":\"Y\",\"is_luck\":\"N\",\"lucktime\":null,\"unlucktime\":\"1474125641\",\"addtime\":\"0\",\"del\":\"N\"},\"group\":{\"id\":\"1\",\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"brand_id\":\"1\",\"maxtotalcash\":\"0.00\",\"maxdaycash\":\"0.00\",\"menus_sel\":\"\",\"menus_add\":null,\"menus_edit\":null,\"menus_del\":null,\"menus_undo\":\"N\",\"menus_exam\":\"N\",\"menus_conf\":\"N\",\"menus_admin\":\"Y\",\"del\":\"N\"}}', '1', 'Y', '1474198532', '1474194203', 'N');

-- ----------------------------
-- Table structure for kv_setting
-- ----------------------------
DROP TABLE IF EXISTS `kv_setting`;
CREATE TABLE `kv_setting` (
  `kvkey` varchar(50) NOT NULL COMMENT 'key字段',
  `kvvalue` text COMMENT '值',
  `type` varchar(20) DEFAULT 'default' COMMENT '设置类型',
  `brand_id` int(10) NOT NULL COMMENT '品牌id',
  `del` char(1) NOT NULL DEFAULT 'N' COMMENT '是否已删除,Y是，N否',
  PRIMARY KEY (`kvkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置表';

-- ----------------------------
-- Records of kv_setting
-- ----------------------------
