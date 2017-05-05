/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : newspaperdb

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2017-05-05 09:09:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hd_message
-- ----------------------------
DROP TABLE IF EXISTS `hd_message`;
CREATE TABLE `hd_message` (
  `mid` int(10) NOT NULL AUTO_INCREMENT COMMENT '留言ID',
  `uid` int(10) NOT NULL COMMENT '用户ID',
  `username` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `content` varchar(1024) CHARACTER SET utf8 NOT NULL COMMENT '留言内容',
  `createdate` int(10) NOT NULL COMMENT '发表时间',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for hd_newsoffice
-- ----------------------------
DROP TABLE IF EXISTS `hd_newsoffice`;
CREATE TABLE `hd_newsoffice` (
  `noid` int(10) NOT NULL AUTO_INCREMENT,
  `noname` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`noid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for hd_newspaper
-- ----------------------------
DROP TABLE IF EXISTS `hd_newspaper`;
CREATE TABLE `hd_newspaper` (
  `nsid` int(10) NOT NULL AUTO_INCREMENT COMMENT '报纸ID',
  `noid` int(10) NOT NULL COMMENT '报社ID',
  `nsname` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '报纸名',
  `imgPath` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT '图片路径',
  `url` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT '抓取的URL',
  `way` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '抓取方法',
  `about` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `createdata` int(10) NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`nsid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='报纸表';

-- ----------------------------
-- Table structure for hd_notes
-- ----------------------------
DROP TABLE IF EXISTS `hd_notes`;
CREATE TABLE `hd_notes` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '笔记显示id',
  `usname` varchar(16) NOT NULL COMMENT '用户名',
  `note` varchar(1024) NOT NULL COMMENT '笔记内容',
  `date` int(10) NOT NULL COMMENT '添加时间',
  `noname` varchar(16) NOT NULL COMMENT '报纸名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for hd_show
-- ----------------------------
DROP TABLE IF EXISTS `hd_show`;
CREATE TABLE `hd_show` (
  `showid` int(10) NOT NULL AUTO_INCREMENT COMMENT '展示ID',
  `nsid` int(10) NOT NULL COMMENT '报纸id',
  `noname` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '报社名',
  `nsname` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '报社名',
  `path` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT 'HTML存储位置',
  `layout` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT '版面名称',
  `layoutindex` int(3) NOT NULL COMMENT '版面索引',
  `date` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`showid`),
  UNIQUE KEY `path` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=1853 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for hd_skin
-- ----------------------------
DROP TABLE IF EXISTS `hd_skin`;
CREATE TABLE `hd_skin` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `sname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `spath` varchar(32) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COMMENT='特效管理表';

-- ----------------------------
-- Table structure for hd_users
-- ----------------------------
DROP TABLE IF EXISTS `hd_users`;
CREATE TABLE `hd_users` (
  `uid` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(16) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 DEFAULT NULL COMMENT '密码',
  `power` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT '权限，0为管理员1为普通用户。',
  `createdate` int(10) NOT NULL COMMENT '创建时间',
  `sex` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT '性别',
  `QQ` varchar(128) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COMMENT='用户管理表';
SET FOREIGN_KEY_CHECKS=1;
