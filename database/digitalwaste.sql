/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : digitalwaste

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-01-26 22:24:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dropbox_files
-- ----------------------------
DROP TABLE IF EXISTS `dropbox_files`;
CREATE TABLE `dropbox_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `bytes` int(11) NOT NULL,
  `size` varchar(30) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created` varchar(100) NOT NULL,
  `updated` varchar(100) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `write_path` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=425 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dropbox_files
-- ----------------------------

-- ----------------------------
-- Table structure for dropbox_results
-- ----------------------------
DROP TABLE IF EXISTS `dropbox_results`;
CREATE TABLE `dropbox_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `verd_extensies` text NOT NULL,
  `gem_bestandsgrootte` float NOT NULL,
  `eerst_geupload` varchar(255) NOT NULL,
  `gem_rating` float NOT NULL,
  `verd_rating` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dropbox_results
-- ----------------------------
INSERT INTO `dropbox_results` VALUES ('0', '0', '{\"document\":0,\"image\":0,\"video\":0}', '0', '', '0', '{\"document\":3.3768272934173,\"image\":2.6250000000002,\"video\":0}');
INSERT INTO `dropbox_results` VALUES ('37', '98', '{\"document\":2,\"image\":0,\"video\":0}', '575112', '2010-06-09 19:39:30', '3.5', '{\"document\":3.5,\"image\":0,\"video\":0}');

-- ----------------------------
-- Table structure for dropbox_users
-- ----------------------------
DROP TABLE IF EXISTS `dropbox_users`;
CREATE TABLE `dropbox_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dropbox_users
-- ----------------------------
INSERT INTO `dropbox_users` VALUES ('98', 'Bart van \'t Ende');
