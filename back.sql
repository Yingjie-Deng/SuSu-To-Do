/*
SQLyog Ultimate v10.00 Beta1
MySQL - 8.0.18 : Database - todo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`todo` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `todo`;

/*Table structure for table `direct` */

DROP TABLE IF EXISTS `direct`;

CREATE TABLE `direct` (
  `pid` varchar(50) NOT NULL,
  `login_name` varchar(50) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`pid`,`login_name`),
  CONSTRAINT `direct_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `direct` */

insert  into `direct`(`pid`,`login_name`,`password`) values ('1601797500','',''),('test09:37:39','12622222','22'),('test09:37:39','haha@hah.com','123456'),('哈哈呵呵1601739542','','123456'),('哈哈呵呵1601739542','123456789','123456'),('测试三1601739752','524524','123'),('测试三1601739752','LXTHLD@163.com','123'),('测试二1601739708','453452','123456'),('测试头像1601797500','56456','123'),('邓英杰1601719731','18608240560','123456'),('邓英杰1601719731','LXTHLD@Outlook.com','123456');

/*Table structure for table `list` */

DROP TABLE IF EXISTS `list`;

CREATE TABLE `list` (
  `lid` varchar(20) NOT NULL,
  `pid` varchar(50) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `pid` (`pid`),
  CONSTRAINT `list_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `list` */

insert  into `list`(`lid`,`pid`,`name`) values ('all_001',NULL,'任务'),('l16061491334901','邓英杰1601719731','数据库'),('l16077425188669','邓英杰1601719731','todo'),('p_001','邓英杰1601719731','数学'),('p_002','邓英杰1601719731','日常');

/*Table structure for table `person` */

DROP TABLE IF EXISTS `person`;

CREATE TABLE `person` (
  `pid` varchar(50) NOT NULL,
  `name` varchar(15) NOT NULL,
  `head_sculpture` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'http://localhost/todo/application/views/favicon.ico',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `person` */

insert  into `person`(`pid`,`name`,`head_sculpture`) values ('1601797500','','http://localhost/todo/application/views/favicon.ico'),('test09:37:39','test','http://empty.xxx'),('哈哈呵呵1601739542','哈哈呵呵','http://enpty.com/'),('测试三1601739752','测试三','http://enpty.com/'),('测试二1601739708','测试二','http://enpty.com/'),('测试头像1601797500','测试头像','http://localhost/todo/application/views/favicon.ico'),('邓英杰1601719731','邓英杰','http://localhost/todo/application/views/favicon.ico');

/*Table structure for table `step` */

DROP TABLE IF EXISTS `step`;

CREATE TABLE `step` (
  `sid` varchar(20) NOT NULL,
  `tid` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `number` tinyint(4) NOT NULL,
  `found_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`),
  KEY `tid` (`tid`),
  CONSTRAINT `step_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `task` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `step` */

/*Table structure for table `task` */

DROP TABLE IF EXISTS `task`;

CREATE TABLE `task` (
  `tid` varchar(20) NOT NULL,
  `pid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `lid` varchar(20) DEFAULT 'all_001',
  `content` text,
  `found_time` datetime NOT NULL,
  `start_time` datetime NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT '0000-00-00 00:00:00',
  `my_day` tinyint(1) NOT NULL,
  `important` tinyint(1) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `task_ibfk_1` (`pid`),
  KEY `task_ibfk_2` (`lid`),
  CONSTRAINT `task_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_ibfk_2` FOREIGN KEY (`lid`) REFERENCES `list` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `task` */

insert  into `task`(`tid`,`pid`,`lid`,`content`,`found_time`,`start_time`,`deadline`,`end_time`,`my_day`,`important`) values ('t16056205215719','邓英杰1601719731','p_001','一阶微分方程','2020-11-17 21:42:00','2020-11-17 21:41:00','2020-11-22 21:41:00','0000-00-00 00:00:00',1,0),('t16056206602217','邓英杰1601719731','p_002','早起','2020-11-17 21:44:00','2020-11-18 21:43:00','2020-11-19 00:26:00','0000-00-00 00:00:00',1,1),('t16056207999187','邓英杰1601719731','all_001','测试当天晚上结束','2020-11-17 21:46:00','2020-11-17 21:46:00','2020-11-18 00:00:00','0000-00-00 00:00:00',1,1),('t16056287578576','邓英杰1601719731','all_001','完成重要性切换','2020-11-17 23:59:00','2020-11-17 23:59:00','2020-11-18 00:00:00','0000-00-00 00:00:00',1,1),('t16056289617920','邓英杰1601719731','all_001','加油','2020-11-18 00:02:00','2020-11-18 00:01:00','2020-11-19 00:00:00','2020-11-19 20:11:34',1,1),('t16056290325290','邓英杰1601719731','p_002','哈哈呵呵嘿嘿','2020-11-18 00:03:00','2020-11-18 00:03:00','2020-11-19 00:03:00','2020-11-18 21:26:58',1,1),('t16056803834545','邓英杰1601719731','all_001','测试模块','2020-11-18 14:19:00','2020-11-18 14:19:00','2020-11-19 14:19:00','2020-11-19 20:11:35',1,0),('t16056803924360','邓英杰1601719731','all_001','大风歌','2020-11-18 14:19:00','2020-11-18 14:19:00','2020-11-19 00:00:00','0000-00-00 00:00:00',1,1),('t16056804277278','邓英杰1601719731','all_001','发过很多','2020-11-18 14:20:00','2020-11-18 14:20:00','2020-11-19 00:00:00','0000-00-00 00:00:00',1,1),('t16056805194666','邓英杰1601719731','all_001','豆腐干豆腐上个','2020-11-18 14:21:59','2020-11-18 14:21:59','2020-11-19 00:00:00','0000-00-00 00:00:00',1,1),('t16056805284717','邓英杰1601719731','all_001','发的规划法','2020-11-18 14:22:08','2020-11-18 14:22:08','2020-11-19 00:00:00','0000-00-00 00:00:00',1,1),('t16056875564582','邓英杰1601719731','all_001','豆腐干豆腐头发海天佛国法规规划滚滚滚','2020-11-18 16:19:16','2020-11-18 16:19:16','2020-11-19 00:00:00','0000-00-00 00:00:00',1,0),('t16056908043707','邓英杰1601719731','all_001','大范甘迪','2020-11-18 17:13:23','2020-11-18 17:13:23','2020-11-19 00:00:00','0000-00-00 00:00:00',1,1),('t16056908062779','邓英杰1601719731','all_001','大风歌','2020-11-18 17:13:26','2020-11-18 17:13:26','2020-11-19 00:00:00','2020-12-13 11:39:13',1,1),('t16057038136876','邓英杰1601719731','all_001','第三方进口量','2020-11-18 20:50:13','2020-11-18 20:50:13','2020-11-19 00:00:00','2020-11-18 21:53:52',1,0),('t16057038241514','邓英杰1601719731','p_001','第三方个个都是','2020-11-18 20:50:24','2020-11-18 20:50:24','2020-11-22 20:50:20','2020-11-18 21:53:52',1,0),('t16057038443525','邓英杰1601719731','p_002','哈哈哈哈哈哈哈哈哈哈哈啊哈哈哈哈','2020-11-18 20:50:44','2020-11-18 20:50:44','2020-11-19 20:50:41','2020-11-18 21:26:59',1,0),('t16057743053817','邓英杰1601719731','p_002','邓英杰日常','2020-11-19 16:25:05','2020-11-19 16:25:05','2020-11-20 00:00:00','2020-11-19 17:00:12',1,1),('t16057743307195','邓英杰1601719731','p_002','哈哈','2020-11-19 16:25:30','2020-11-19 16:25:26','2020-11-20 16:25:27','2020-11-19 16:56:14',1,0),('t16057743489161','邓英杰1601719731','all_001','来一个完成的','2020-11-19 16:25:48','2020-11-19 16:25:43','2020-11-22 16:25:46','2020-12-06 12:57:04',1,1),('t16057845667529','邓英杰1601719731','all_001','大风歌大风歌明天','2020-11-19 19:16:06','2020-11-20 19:16:00','2020-11-22 19:16:04','2020-12-13 11:39:12',0,0),('t16057877169070','邓英杰1601719731','p_001','很反感','2020-11-19 20:08:36','2020-11-19 20:08:26','2020-11-22 20:08:30','0000-00-00 00:00:00',1,0),('t16057891786349','邓英杰1601719731','all_001','广发华福','2020-11-19 20:32:58','2020-11-19 20:32:58','2020-11-20 00:00:00','2020-12-06 15:10:39',0,0),('t16057895605564','邓英杰1601719731','p_001','发过火','2020-11-19 20:39:20','2020-11-22 20:38:48','2020-12-03 00:05:02','0000-00-00 00:00:00',0,1),('t16057909766199','邓英杰1601719731','all_001','高度符合','2020-11-19 21:02:56','2020-11-19 21:02:56','2020-11-19 21:02:29','2020-12-13 11:39:11',0,1),('t16061326338931','邓英杰1601719731','all_001','法国恢复规划','2020-11-23 19:57:13','2020-11-23 19:57:13','2020-11-24 00:00:00','2020-12-13 11:34:15',0,0),('t16061326436369','邓英杰1601719731','p_002','地方各个风格','2020-11-23 19:57:23','2020-11-24 19:57:18','2020-11-29 19:57:19','2020-11-23 22:46:16',0,0),('t16061326629296','邓英杰1601719731','all_001','法规和法国','2020-11-23 19:57:42','2020-11-23 19:57:42','2020-11-24 00:00:00','2020-12-13 11:34:15',0,1),('t16061327215873','邓英杰1601719731','all_001','法国恢复规划','2020-11-23 19:58:41','2020-11-23 19:58:41','2020-11-24 00:00:00','2020-11-24 00:28:55',1,0),('t16061327668920','邓英杰1601719731','all_001','法国恢复规划 法规的划分和法规和法国二等功海富通电视广告还让他','2020-11-23 19:59:26','2020-11-23 19:59:26','2020-11-24 00:00:00','2020-12-06 15:10:36',0,1),('t16061488984667','邓英杰1601719731','all_001','我的一天','2020-11-24 00:28:18','2020-11-24 00:28:18','2020-11-25 00:00:00','2020-12-06 15:10:35',1,0),('t16061489081327','邓英杰1601719731','all_001','重要的我的一天','2020-11-24 00:28:28','2020-11-24 00:28:28','2020-11-25 00:00:00','2020-12-06 15:10:34',1,1),('t16061490039509','邓英杰1601719731','all_001','明天的事','2020-11-24 00:30:03','2020-11-25 00:29:58','2020-11-29 00:29:59','2020-12-06 15:10:33',0,0),('t16061490262205','邓英杰1601719731','p_002','早起吃早饭','2020-11-24 00:30:26','2020-11-25 00:29:58','2020-11-29 00:29:59','0000-00-00 00:00:00',0,0),('t16061490516956','邓英杰1601719731','p_002','早起吃早饭','2020-11-24 00:30:51','2020-11-24 00:30:51','2020-11-25 00:00:00','2020-11-24 11:00:04',0,0),('t16061490977073','邓英杰1601719731','p_001','高数练习册（微分方程）','2020-11-24 00:31:37','2020-11-24 00:31:37','2020-11-25 00:00:00','0000-00-00 00:00:00',0,0),('t16061491395447','邓英杰1601719731','l16061491334901','数据库（第二章）','2020-11-24 00:32:19','2020-11-24 00:32:19','2020-11-25 00:00:00','0000-00-00 00:00:00',0,0),('t16061868639608','邓英杰1601719731','p_002','规范梵蒂冈','2020-11-24 11:01:03','2020-11-24 11:01:03','2020-11-25 00:00:00','2020-12-06 22:29:13',0,0),('t16066654794137','邓英杰1601719731','p_002','早起记单词','2020-11-29 23:57:59','2020-11-30 23:57:55','2020-11-30 23:57:57','2020-11-30 00:50:35',1,1),('t16066655047533','邓英杰1601719731','p_001','全微分','2020-11-29 23:58:24','2020-11-30 23:58:21','2020-11-30 23:58:22','2020-11-30 22:54:32',1,1),('t16066655691725','邓英杰1601719731','l16061491334901','数据库','2020-11-29 23:59:29','2020-11-30 00:00:00','2020-11-30 23:58:22','2020-11-30 00:54:21',1,0),('t16067480718061','邓英杰1601719731','all_001','占个位置','2020-11-30 22:54:31','2020-11-30 22:54:31','2020-12-01 00:00:00','2020-12-06 12:41:05',1,0),('t16067481703383','邓英杰1601719731','p_002','早起记单词','2020-11-30 22:56:10','2020-12-01 22:56:07','2020-12-01 22:56:08','0000-00-00 00:00:00',0,0),('t16067482185903','邓英杰1601719731','p_001','复合函数、隐函数求导','2020-11-30 22:56:58','2020-12-01 22:56:54','2020-12-01 22:56:55','2020-12-06 22:07:51',0,0),('t16067482526646','邓英杰1601719731','all_001','改盒子夜市','2020-11-30 22:57:32','2020-12-01 22:56:54','2020-12-01 22:56:55','2020-12-13 11:34:14',0,1),('t16067546944030','邓英杰1601719731','all_001','测试我的一天添加任务','2020-12-01 00:44:54','2020-12-01 00:44:54','2020-12-02 00:00:00','2020-12-06 15:10:26',1,0),('t16072295551766','邓英杰1601719731','l16061491334901','完成SQL笔记','2020-12-06 12:39:15','2020-12-06 12:39:15','2020-12-07 00:00:00','0000-00-00 00:00:00',1,1),('t16072317753659','邓英杰1601719731','all_001','测试修复后的item','2020-12-06 13:16:15','2020-12-06 13:16:15','2020-12-07 00:00:00','2020-12-06 22:47:01',1,1),('t16072317814088','邓英杰1601719731','all_001','再来一条','2020-12-06 13:16:21','2020-12-06 13:16:21','2020-12-07 00:00:00','2020-12-13 11:34:14',1,0),('t16072317873436','邓英杰1601719731','all_001','多几条','2020-12-06 13:16:27','2020-12-06 13:16:27','2020-12-07 00:00:00','2020-12-13 11:39:11',1,1),('t16072317904334','邓英杰1601719731','all_001','用于测试','2020-12-06 13:16:30','2020-12-06 13:16:30','2020-12-07 00:00:00','2020-12-06 15:38:08',1,0),('t16072728411796','邓英杰1601719731','p_002','早起','2020-12-07 00:40:41','2020-12-07 00:40:41','2020-12-08 00:00:00','0000-00-00 00:00:00',1,1),('t16072728948721','邓英杰1601719731','p_001','二重积分','2020-12-07 00:41:34','2020-12-07 00:41:34','2020-12-08 00:00:00','0000-00-00 00:00:00',1,1),('t16072729533893','邓英杰1601719731','l16061491334901','数据库安全','2020-12-07 00:42:33','2020-12-07 00:42:33','2020-12-08 00:00:00','0000-00-00 00:00:00',1,0),('t16072749255596','邓英杰1601719731','p_002','在任务下添加一条任务到日常','2020-12-07 01:15:25','2020-12-07 01:15:25','2020-12-08 00:00:00','0000-00-00 00:00:00',0,0),('t16072749672291','邓英杰1601719731','all_001','在重要下添加的任务都是“重要”的','2020-12-07 01:16:07','2020-12-07 01:16:07','2020-12-08 00:00:00','2020-12-13 11:34:10',0,1),('t16077425252061','邓英杰1601719731','l16077425188669','完成用户功能','2020-12-12 11:08:45','2020-12-12 11:08:45','2020-12-13 00:00:00','2020-12-12 14:19:47',1,1),('t16077481987017','邓英杰1601719731','l16061491334901','看数据库第五章','2020-12-12 12:43:18','2020-12-12 12:43:18','2020-12-13 00:00:00','0000-00-00 00:00:00',1,0),('t16078258651172','邓英杰1601719731','l16077425188669','完成信息修改部分','2020-12-13 10:17:45','2020-12-13 10:17:45','2020-12-14 00:00:00','0000-00-00 00:00:00',1,1);

/*Table structure for table `all` */

DROP TABLE IF EXISTS `all`;

/*!50001 DROP VIEW IF EXISTS `all` */;
/*!50001 DROP TABLE IF EXISTS `all` */;

/*!50001 CREATE TABLE  `all`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `my_day` tinyint(1) ,
 `import` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*Table structure for table `completed` */

DROP TABLE IF EXISTS `completed`;

/*!50001 DROP VIEW IF EXISTS `completed` */;
/*!50001 DROP TABLE IF EXISTS `completed` */;

/*!50001 CREATE TABLE  `completed`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `my_day` tinyint(1) ,
 `import` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*Table structure for table `important` */

DROP TABLE IF EXISTS `important`;

/*!50001 DROP VIEW IF EXISTS `important` */;
/*!50001 DROP TABLE IF EXISTS `important` */;

/*!50001 CREATE TABLE  `important`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `my_day` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*Table structure for table `myday` */

DROP TABLE IF EXISTS `myday`;

/*!50001 DROP VIEW IF EXISTS `myday` */;
/*!50001 DROP TABLE IF EXISTS `myday` */;

/*!50001 CREATE TABLE  `myday`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `import` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*Table structure for table `mystery` */

DROP TABLE IF EXISTS `mystery`;

/*!50001 DROP VIEW IF EXISTS `mystery` */;
/*!50001 DROP TABLE IF EXISTS `mystery` */;

/*!50001 CREATE TABLE  `mystery`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `my_day` tinyint(1) ,
 `import` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*Table structure for table `overdue` */

DROP TABLE IF EXISTS `overdue`;

/*!50001 DROP VIEW IF EXISTS `overdue` */;
/*!50001 DROP TABLE IF EXISTS `overdue` */;

/*!50001 CREATE TABLE  `overdue`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `my_day` tinyint(1) ,
 `import` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*Table structure for table `personinfo` */

DROP TABLE IF EXISTS `personinfo`;

/*!50001 DROP VIEW IF EXISTS `personinfo` */;
/*!50001 DROP TABLE IF EXISTS `personinfo` */;

/*!50001 CREATE TABLE  `personinfo`(
 `pid` varchar(50) ,
 `name` varchar(15) ,
 `head_sculpture` varchar(200) ,
 `login_name` varchar(50) 
)*/;

/*Table structure for table `today` */

DROP TABLE IF EXISTS `today`;

/*!50001 DROP VIEW IF EXISTS `today` */;
/*!50001 DROP TABLE IF EXISTS `today` */;

/*!50001 CREATE TABLE  `today`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `my_day` tinyint(1) ,
 `import` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*Table structure for table `yesterday` */

DROP TABLE IF EXISTS `yesterday`;

/*!50001 DROP VIEW IF EXISTS `yesterday` */;
/*!50001 DROP TABLE IF EXISTS `yesterday` */;

/*!50001 CREATE TABLE  `yesterday`(
 `tid` varchar(20) ,
 `pid` varchar(50) ,
 `content` text ,
 `my_day` tinyint(1) ,
 `import` tinyint(1) ,
 `listName` varchar(30) ,
 `found_time` datetime ,
 `deadline` datetime ,
 `start_time` datetime ,
 `end_time` datetime 
)*/;

/*View structure for view all */

/*!50001 DROP TABLE IF EXISTS `all` */;
/*!50001 DROP VIEW IF EXISTS `all` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`my_day` AS `my_day`,`task`.`important` AS `import`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where ((0 = `task`.`end_time`) and (`task`.`deadline` >= now())) order by `list`.`lid` desc,`task`.`found_time` desc */;

/*View structure for view completed */

/*!50001 DROP TABLE IF EXISTS `completed` */;
/*!50001 DROP VIEW IF EXISTS `completed` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `completed` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`my_day` AS `my_day`,`task`.`important` AS `import`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where (0 <> `task`.`end_time`) */;

/*View structure for view important */

/*!50001 DROP TABLE IF EXISTS `important` */;
/*!50001 DROP VIEW IF EXISTS `important` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `important` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`my_day` AS `my_day`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where ((`task`.`important` = true) and (`task`.`start_time` between curdate() and (curdate() + interval 1 day))) */;

/*View structure for view myday */

/*!50001 DROP TABLE IF EXISTS `myday` */;
/*!50001 DROP VIEW IF EXISTS `myday` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `myday` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`important` AS `import`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where ((`task`.`my_day` = true) and (`task`.`start_time` between curdate() and (curdate() + interval 1 day))) */;

/*View structure for view mystery */

/*!50001 DROP TABLE IF EXISTS `mystery` */;
/*!50001 DROP VIEW IF EXISTS `mystery` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mystery` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`my_day` AS `my_day`,`task`.`important` AS `import`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where (`task`.`start_time` between (curdate() + interval 1 day) and (curdate() + interval 2 day)) */;

/*View structure for view overdue */

/*!50001 DROP TABLE IF EXISTS `overdue` */;
/*!50001 DROP VIEW IF EXISTS `overdue` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `overdue` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`my_day` AS `my_day`,`task`.`important` AS `import`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where ((0 = `task`.`end_time`) and (`task`.`deadline` < now())) order by `list`.`name`,`task`.`found_time` desc */;

/*View structure for view personinfo */

/*!50001 DROP TABLE IF EXISTS `personinfo` */;
/*!50001 DROP VIEW IF EXISTS `personinfo` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `personinfo` AS select `person`.`pid` AS `pid`,`person`.`name` AS `name`,`person`.`head_sculpture` AS `head_sculpture`,`direct`.`login_name` AS `login_name` from (`person` join `direct` on((`person`.`pid` = `direct`.`pid`))) */;

/*View structure for view today */

/*!50001 DROP TABLE IF EXISTS `today` */;
/*!50001 DROP VIEW IF EXISTS `today` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `today` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`my_day` AS `my_day`,`task`.`important` AS `import`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where (`task`.`start_time` between curdate() and (curdate() + interval 1 day)) */;

/*View structure for view yesterday */

/*!50001 DROP TABLE IF EXISTS `yesterday` */;
/*!50001 DROP VIEW IF EXISTS `yesterday` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `yesterday` AS select `task`.`tid` AS `tid`,`task`.`pid` AS `pid`,`task`.`content` AS `content`,`task`.`my_day` AS `my_day`,`task`.`important` AS `import`,`list`.`name` AS `listName`,`task`.`found_time` AS `found_time`,`task`.`deadline` AS `deadline`,`task`.`start_time` AS `start_time`,`task`.`end_time` AS `end_time` from (`task` join `list` on((`task`.`lid` = `list`.`lid`))) where (`task`.`start_time` between (curdate() - interval 1 day) and curdate()) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
