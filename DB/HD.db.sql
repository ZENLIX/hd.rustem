# ************************************************************
# Sequel Pro SQL dump
# Версия 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Адрес: 127.0.0.1 (MySQL 5.6.16)
# Схема: hd
# Время создания: 2014-05-20 08:10:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы approved_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `approved_info`;

CREATE TABLE `approved_info` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fio` varchar(256) DEFAULT NULL,
  `tel` varchar(256) DEFAULT NULL,
  `login` varchar(256) DEFAULT NULL,
  `unit_desc` varchar(1024) DEFAULT NULL,
  `adr` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `posada` varchar(256) DEFAULT NULL,
  `user_from` int(11) DEFAULT NULL,
  `date_app` datetime DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fio` varchar(512) DEFAULT NULL,
  `tel` varchar(128) DEFAULT NULL,
  `login` varchar(256) DEFAULT NULL,
  `unit_desc` varchar(1024) DEFAULT NULL,
  `adr` varchar(128) DEFAULT NULL,
  `tel_ext` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `posada` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `t_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` varchar(2048) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы deps
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deps`;

CREATE TABLE `deps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `deps` WRITE;
/*!40000 ALTER TABLE `deps` DISABLE KEYS */;

INSERT INTO `deps` (`id`, `name`)
VALUES
	(0,'Все'),
	(1,'Отдел WEB-разработки'),
	(2,'Сектор хостинга'),
	(3,'Отдел SEO, рекламы и маркетинга'),
	(4,'Отдел безопастности сети'),
	(5,'Отдел поддержки пользователей');

/*!40000 ALTER TABLE `deps` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  `h_name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы helper
# ------------------------------------------------------------

DROP TABLE IF EXISTS `helper`;

CREATE TABLE `helper` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_init_id` int(11) DEFAULT NULL,
  `unit_to_id` varchar(11) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `title` varchar(1024) DEFAULT NULL,
  `message` longtext,
  `hashname` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `subj` varchar(512) DEFAULT NULL,
  `msg` varchar(1024) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `is_read` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы notes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notes`;

CREATE TABLE `notes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hashname` varchar(512) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` longtext,
  `dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы posada
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posada`;

CREATE TABLE `posada` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `posada` WRITE;
/*!40000 ALTER TABLE `posada` DISABLE KEYS */;

INSERT INTO `posada` (`id`, `name`)
VALUES
	(1,'администратор');

/*!40000 ALTER TABLE `posada` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы subj
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subj`;

CREATE TABLE `subj` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `subj` WRITE;
/*!40000 ALTER TABLE `subj` DISABLE KEYS */;

INSERT INTO `subj` (`id`, `name`)
VALUES
	(25,'Система'),
	(28,'Интернет и локальная сеть'),
	(30,'Телефония'),
	(31,'Другое'),
	(32,'Компьютеры и переферия'),
	(33,'Принтеры (обслуживание)'),
	(35,'Видеонаблюдение'),
	(36,'Установка ПО');

/*!40000 ALTER TABLE `subj` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы ticket_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ticket_log`;

CREATE TABLE `ticket_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_op` datetime DEFAULT NULL,
  `msg` varchar(512) CHARACTER SET latin1 DEFAULT NULL,
  `init_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `to_unit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы tickets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_init_id` int(11) DEFAULT NULL,
  `user_to_id` int(11) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `subj` varchar(512) DEFAULT NULL,
  `msg` varchar(1024) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `hash_name` varchar(512) DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `arch` int(11) DEFAULT '0',
  `is_read` int(11) DEFAULT '0',
  `lock_by` int(11) DEFAULT '0',
  `last_edit` datetime DEFAULT NULL,
  `ok_by` int(11) DEFAULT '0',
  `prio` int(4) NOT NULL DEFAULT '0',
  `ok_date` datetime NOT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы units
# ------------------------------------------------------------

DROP TABLE IF EXISTS `units`;

CREATE TABLE `units` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;

INSERT INTO `units` (`id`, `name`)
VALUES
	(1,'Бухгалтерия'),
	(2,'Кадры');

/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fio` varchar(512) DEFAULT NULL,
  `login` varchar(64) DEFAULT NULL,
  `pass` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `priv` int(11) DEFAULT '0',
  `unit` varchar(11) DEFAULT NULL,
  `is_admin` int(4) NOT NULL DEFAULT '0',
  `email` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `fio`, `login`, `pass`, `status`, `priv`, `unit`, `is_admin`, `email`)
VALUES
	(1,'Main system account','system','81dc9bdb52d04dc20036dbd8313ed055',1,2,'1,2,3',8,'');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
