-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: shopcz
-- ------------------------------------------------------
-- Server version	5.6.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cz_address`
--

DROP TABLE IF EXISTS `cz_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_address` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '地址编号',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地址所属用户ID',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `province` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '省份，保存是ID',
  `city` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '市',
  `district` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `street` varchar(100) NOT NULL DEFAULT '' COMMENT '街道地址',
  `zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `telephone` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '移动电话',
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_address`
--

LOCK TABLES `cz_address` WRITE;
/*!40000 ALTER TABLE `cz_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_admin`
--

DROP TABLE IF EXISTS `cz_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_admin` (
  `admin_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `admin_name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_admin`
--

LOCK TABLES `cz_admin` WRITE;
/*!40000 ALTER TABLE `cz_admin` DISABLE KEYS */;
INSERT INTO `cz_admin` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','admin@itcast.cn',0),(2,'test','098f6bcd4621d373cade4e832627b4f6','',0);
/*!40000 ALTER TABLE `cz_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_attribute`
--

DROP TABLE IF EXISTS `cz_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性ID',
  `attr_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性名称',
  `type_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '商品属性所属类型ID',
  `attr_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性是否可选 0 为唯一，1为单选，2为多选',
  `attr_input_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性录入方式 0为手工录入，1为从列表中选择，2为文本域',
  `attr_value` text COMMENT '属性的值',
  `sort_order` tinyint(4) NOT NULL DEFAULT '50' COMMENT '属性排序依据',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_attribute`
--

LOCK TABLES `cz_attribute` WRITE;
/*!40000 ALTER TABLE `cz_attribute` DISABLE KEYS */;
INSERT INTO `cz_attribute` VALUES (4,'ttt',2,0,1,'ggdg\r\nggd',50),(5,'ss',2,0,0,'',50),(6,'rrr',2,2,2,'',50);
/*!40000 ALTER TABLE `cz_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_brand`
--

DROP TABLE IF EXISTS `cz_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_brand` (
  `brand_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品品牌ID',
  `brand_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品品牌名称',
  `brand_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品品牌描述',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '商品品牌网址',
  `logo` varchar(500) NOT NULL DEFAULT '' COMMENT '品牌logo',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '商品品牌排序依据',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_brand`
--

LOCK TABLES `cz_brand` WRITE;
/*!40000 ALTER TABLE `cz_brand` DISABLE KEYS */;
INSERT INTO `cz_brand` VALUES (12,'Nike','','http://www.nike.com','2017012421/brandOri5888111eb5c239.75600441.gif',50,1);
/*!40000 ALTER TABLE `cz_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_cart`
--

DROP TABLE IF EXISTS `cz_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_cart` (
  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交价格',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '小计',
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_cart`
--

LOCK TABLES `cz_cart` WRITE;
/*!40000 ALTER TABLE `cz_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_category`
--

DROP TABLE IF EXISTS `cz_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类别ID',
  `cat_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品类别名称',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类别父ID',
  `cat_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品类别描述',
  `sort_order` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序依据',
  `unit` varchar(15) NOT NULL DEFAULT '' COMMENT '单位',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`cat_id`),
  KEY `pid` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_category`
--

LOCK TABLES `cz_category` WRITE;
/*!40000 ALTER TABLE `cz_category` DISABLE KEYS */;
INSERT INTO `cz_category` VALUES (1,'家用电器',0,'',50,'',1),(2,'手机/数码',0,'',50,'',1),(3,'电脑办公',0,'',50,'',1),(4,'服装',0,'',50,'',1),(5,'运动',0,'',50,'',1),(6,'食品',0,'',50,'',1),(7,'书籍、音像',0,'',50,'',1),(8,'家庭护理',0,'',50,'',1),(9,'汽车',0,'',50,'',1),(10,'电视',1,'',50,'',1),(11,'空调',1,'',50,'',1),(12,'国产',10,'',50,'',1),(13,'挂式',11,'',50,'',1),(14,'手机通信',2,'',50,'',1),(15,'运行商',2,'',50,'',1),(16,'手机',14,'',50,'',1),(17,'笔记本',3,'',50,'',1),(18,'国产',17,'',50,'',1),(19,'男装',4,'',50,'',1),(20,'夹克',19,'',50,'',1),(21,'体育用品',5,'',50,'',1),(22,'羽毛器',21,'',50,'',1),(23,'保健',6,'',50,'',1),(24,'进口',23,'',50,'',1),(25,'外文',7,'',50,'',1),(26,'经典',25,'',50,'',1),(27,'面部护肤',8,'',50,'',1),(28,'补水',27,'',50,'',1),(29,'车型',9,'',50,'',1);
/*!40000 ALTER TABLE `cz_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_galary`
--

DROP TABLE IF EXISTS `cz_galary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_galary` (
  `img_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片编号',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `img_url` varchar(50) NOT NULL DEFAULT '' COMMENT '图片URL',
  `thumb_url` varchar(50) NOT NULL DEFAULT '' COMMENT '缩略图URL',
  `img_desc` varchar(50) NOT NULL DEFAULT '' COMMENT '图片描述',
  PRIMARY KEY (`img_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_galary`
--

LOCK TABLES `cz_galary` WRITE;
/*!40000 ALTER TABLE `cz_galary` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_galary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_goods`
--

DROP TABLE IF EXISTS `cz_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `goods_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '商品货号',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_brief` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简单描述',
  `goods_desc` text COMMENT '商品详情',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属类别ID',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属品牌ID',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销起始时间',
  `promote_end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销截止时间',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型ID',
  `is_promote` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否促销，默认为0不促销',
  `is_best` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否精品,默认为0',
  `is_new` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否新品，默认为0',
  `is_hot` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否热卖,默认为0',
  `is_onsale` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架,默认为1',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`goods_id`),
  KEY `cat_id` (`cat_id`),
  KEY `brand_id` (`brand_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_goods`
--

LOCK TABLES `cz_goods` WRITE;
/*!40000 ALTER TABLE `cz_goods` DISABLE KEYS */;
INSERT INTO `cz_goods` VALUES (15,'33423','xiaomi','','',2,12,0.00,1232.00,0.00,0,2017,'2017012715/goodsOri588bae6b28acd7.62680274.gif','2017012715/thumb_goodsOri588bae6b28acd7.62680274.gif',0,0,0,0,1,0,0,1,0),(16,'1231','nike','','',4,12,3242.00,234.00,0.00,0,2017,'2017012715/goodsOri588bae88930b13.94933108.gif','2017012715/thumb_goodsOri588bae88930b13.94933108.gif',0,0,0,0,1,0,0,1,0);
/*!40000 ALTER TABLE `cz_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_goods_attr`
--

DROP TABLE IF EXISTS `cz_goods_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_goods_attr` (
  `goods_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `attr_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '属性价格',
  PRIMARY KEY (`goods_attr_id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_goods_attr`
--

LOCK TABLES `cz_goods_attr` WRITE;
/*!40000 ALTER TABLE `cz_goods_attr` DISABLE KEYS */;
INSERT INTO `cz_goods_attr` VALUES (2,3,4,'ggdg\r\n',0.00),(3,3,5,'11212',0.00),(4,3,6,'101121',0.00);
/*!40000 ALTER TABLE `cz_goods_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_goods_type`
--

DROP TABLE IF EXISTS `cz_goods_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_goods_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型ID',
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_goods_type`
--

LOCK TABLES `cz_goods_type` WRITE;
/*!40000 ALTER TABLE `cz_goods_type` DISABLE KEYS */;
INSERT INTO `cz_goods_type` VALUES (2,'书'),(3,'电子产品'),(4,'电子');
/*!40000 ALTER TABLE `cz_goods_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_order`
--

DROP TABLE IF EXISTS `cz_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `address_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址id',
  `order_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态 1 待付款 2 待发货 3 已发货 4 已完成',
  `postscripts` varchar(255) NOT NULL DEFAULT '' COMMENT '订单附言',
  `shipping_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '送货方式ID',
  `pay_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付方式ID',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `order_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `address_id` (`address_id`),
  KEY `pay_id` (`pay_id`),
  KEY `shipping_id` (`shipping_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_order`
--

LOCK TABLES `cz_order` WRITE;
/*!40000 ALTER TABLE `cz_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_order_goods`
--

DROP TABLE IF EXISTS `cz_order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_order_goods` (
  `rec_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交价格',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '购买数量',
  `goods_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品小计',
  PRIMARY KEY (`rec_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_order_goods`
--

LOCK TABLES `cz_order_goods` WRITE;
/*!40000 ALTER TABLE `cz_order_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_payment`
--

DROP TABLE IF EXISTS `cz_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_payment` (
  `pay_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '支付方式ID',
  `pay_name` varchar(30) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `pay_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '支付方式描述',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用，默认启用',
  PRIMARY KEY (`pay_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_payment`
--

LOCK TABLES `cz_payment` WRITE;
/*!40000 ALTER TABLE `cz_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_region`
--

DROP TABLE IF EXISTS `cz_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '地区ID',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `region_name` varchar(30) NOT NULL DEFAULT '' COMMENT '地区名称',
  `region_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '地区类型 1 省份 2 市 3 区(县)',
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_region`
--

LOCK TABLES `cz_region` WRITE;
/*!40000 ALTER TABLE `cz_region` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_shipping`
--

DROP TABLE IF EXISTS `cz_shipping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_shipping` (
  `shipping_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `shipping_name` varchar(30) NOT NULL DEFAULT '' COMMENT '送货方式名称',
  `shipping_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '送货方式描述',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '送货费用',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用，默认启用',
  PRIMARY KEY (`shipping_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_shipping`
--

LOCK TABLES `cz_shipping` WRITE;
/*!40000 ALTER TABLE `cz_shipping` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_shipping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cz_user`
--

DROP TABLE IF EXISTS `cz_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cz_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码,md5加密',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户注册时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cz_user`
--

LOCK TABLES `cz_user` WRITE;
/*!40000 ALTER TABLE `cz_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `cz_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-01 13:38:06
