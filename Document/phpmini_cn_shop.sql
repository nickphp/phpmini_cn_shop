/*
SQLyog Ultimate v12.08 (64 bit)
MySQL - 5.6.24 : Database - phpmini_cn_shop
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`phpmini_cn_shop` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `phpmini_cn_shop`;

/*Table structure for table `goods` */

DROP TABLE IF EXISTS `goods`;

CREATE TABLE `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品信息表主键',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属分类ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '商品名称',
  `description` varchar(64) DEFAULT '' COMMENT '商品描述',
  `market_price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `discount_price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣价',
  `duscount_rate` decimal(3,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣率',
  `details` text NOT NULL COMMENT '商品详情',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

/*Data for the table `goods` */

/*Table structure for table `goods_category` */

DROP TABLE IF EXISTS `goods_category`;

CREATE TABLE `goods_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类表主键',
  `name` char(10) NOT NULL DEFAULT '' COMMENT '分类名称',
  `help_code` char(10) NOT NULL DEFAULT '' COMMENT '助记码',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父类ID',
  `pxid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序id',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商品分类表 ';

/*Data for the table `goods_category` */

insert  into `goods_category`(`id`,`name`,`help_code`,`pid`,`pxid`,`add_time`,`update_time`) values (1,'服装','fz',0,1,1380000000,1380000000),(2,'美食','ms',0,2,1380000000,1380000000);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表主键ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_sn` char(20) NOT NULL DEFAULT '' COMMENT '订单流水号',
  `total_amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `total_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单总数量',
  `discount_amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单折扣总金额',
  `discount_rate` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单折扣率',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

/*Data for the table `orders` */

/*Table structure for table `orders_details` */

DROP TABLE IF EXISTS `orders_details`;

CREATE TABLE `orders_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单明细表主键ID',
  `gid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `buy_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `buy_price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '购买价格',
  `market_price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `total_price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总价',
  `discount_rate` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣率',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单明细表';

/*Data for the table `orders_details` */

/*Table structure for table `shopping_cart` */

DROP TABLE IF EXISTS `shopping_cart`;

CREATE TABLE `shopping_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车表主键ID',
  `gid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `buy_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `buy_price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '购买价格',
  `market_price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `total_price` decimal(9,2) DEFAULT '0.00' COMMENT '商品总价(购买数量*购买价格)',
  `discount_rate` decimal(3,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣率',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车表';

/*Data for the table `shopping_cart` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表主键',
  `username` varchar(16) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(40) NOT NULL DEFAULT '' COMMENT '密码',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别 1:男 2:女',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
