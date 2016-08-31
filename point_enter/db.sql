-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.38-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица v2_unicnews.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `FK_auth_assignment_users` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_auth_assignment_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.auth_assignment: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
REPLACE INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('admin', 14, NULL),
	('author', 36, 1439814925),
	('moderator', 37, 1439814932),
	('super_moderator', 38, 1439814938);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.auth_item
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.auth_item: ~25 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
REPLACE INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('admin', 1, NULL, NULL, NULL, 1433255707, 1433255707),
	('author', 1, NULL, NULL, NULL, 1433255707, 1433255707),
	('create', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('createNews', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('createQuestion', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('delete', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('deleteNews', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('deleteQuestion', 2, NULL, 'milestone', NULL, 1433255707, 1433255707),
	('deleteQuestionOwn', 2, NULL, 'userOwn', NULL, 1433255707, 1433255707),
	('management', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('moderator', 1, NULL, NULL, NULL, 1433255707, 1433255707),
	('super_moderator', 1, NULL, NULL, NULL, 1433255707, 1433255707),
	('update', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('updateNews', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('updateNewsModerator', 2, NULL, 'statusAllowUpdate', NULL, 1433255707, 1433255707),
	('updateNewsOwn', 2, NULL, 'userOwn', NULL, 1433255707, 1433255707),
	('updateQuestion', 2, NULL, 'milestone', NULL, 1433255707, 1433255707),
	('updateQuestionModerator', 2, NULL, 'statusAllowUpdate', NULL, 1433255707, 1433255707),
	('updateQuestionOwn', 2, NULL, 'userOwn', NULL, 1433255707, 1433255707),
	('view', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('viewNews', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('viewNewsModerator', 2, NULL, 'statusAllowUpdate', NULL, 1433255707, 1433255707),
	('viewNewsOwn', 2, NULL, 'userOwn', NULL, 1433255707, 1433255707),
	('viewQuestion', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('viewQuestionOwn', 2, NULL, 'userOwn', NULL, 1433255707, 1433255707);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.auth_item_child
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.auth_item_child: ~36 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
REPLACE INTO `auth_item_child` (`parent`, `child`) VALUES
	('moderator', 'author'),
	('createNews', 'create'),
	('createQuestion', 'create'),
	('author', 'createNews'),
	('author', 'createQuestion'),
	('admin', 'delete'),
	('deleteNews', 'delete'),
	('deleteQuestion', 'delete'),
	('admin', 'deleteQuestion'),
	('deleteQuestionOwn', 'deleteQuestion'),
	('author', 'deleteQuestionOwn'),
	('admin', 'management'),
	('delete', 'management'),
	('update', 'management'),
	('admin', 'moderator'),
	('super_moderator', 'moderator'),
	('updateNews', 'update'),
	('updateQuestion', 'update'),
	('updateNewsModerator', 'updateNews'),
	('updateNewsOwn', 'updateNews'),
	('moderator', 'updateNewsModerator'),
	('author', 'updateNewsOwn'),
	('admin', 'updateQuestion'),
	('updateQuestionModerator', 'updateQuestion'),
	('updateQuestionOwn', 'updateQuestion'),
	('moderator', 'updateQuestionModerator'),
	('author', 'updateQuestionOwn'),
	('admin', 'view'),
	('viewNews', 'view'),
	('viewQuestion', 'view'),
	('viewNewsModerator', 'viewNews'),
	('viewNewsOwn', 'viewNews'),
	('moderator', 'viewNewsModerator'),
	('author', 'viewNewsOwn'),
	('viewQuestionOwn', 'viewQuestion'),
	('author', 'viewQuestionOwn');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.auth_rule
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.auth_rule: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
REPLACE INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
	('milestone', 'O:28:"app\\components\\MilestoneRule":3:{s:4:"name";s:9:"milestone";s:9:"createdAt";i:1435051604;s:9:"updatedAt";i:1435051604;}', 1435051604, 1435051604),
	('statusAllowUpdate', 'O:36:"app\\components\\StatusAllowUpdateRule":3:{s:4:"name";s:17:"statusAllowUpdate";s:9:"createdAt";i:1435052105;s:9:"updatedAt";i:1435052105;}', 1435052105, 1435052105),
	('userOwn', 'O:26:"app\\components\\UserOwnRule":3:{s:4:"name";s:7:"userOwn";s:9:"createdAt";i:1433255707;s:9:"updatedAt";i:1433255707;}', 1433255707, 1433255707);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.categories: ~31 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`id`, `title`) VALUES
	(60, 'Депозиты'),
	(61, 'ПЛАСТИКОВЫЕ КАРТЫ'),
	(62, 'ИПОТЕКА'),
	(63, 'SME'),
	(65, 'Накопительные счета'),
	(66, 'ДБО.Банкоматы'),
	(67, 'Сейфы'),
	(68, 'ИНФОРМАЦИОННЫЕ СИСТЕМЫ И ПО'),
	(69, 'Автокредитование'),
	(70, 'КРЕДИТНЫЕ КАРТЫ'),
	(71, 'ПОТРЕБИТЕЛЬСКИЕ КРЕДИТЫ'),
	(72, 'Мотивационные программы'),
	(73, 'Нормативные документы'),
	(74, 'Текущие счета'),
	(75, 'ПИФЫ'),
	(76, 'Дебетовые карты'),
	(77, 'ЦИРКУЛЯРНЫЕ ПИСЬМА'),
	(78, 'КОНКУРСЫ'),
	(79, 'КАЧЕСТВО ОБСЛУЖИВАНИЯ'),
	(80, 'Страхование '),
	(81, 'ОФОРМЛЕНИЕ ДОКУМЕНТОВ'),
	(82, 'Кредитование'),
	(83, 'ОБРАЩЕНИЕ КЛИЕНТОВ'),
	(84, 'ПРОЧЕЕ'),
	(132, 'Изменения в Базе Знаний'),
	(150, 'Мерчандайзинг'),
	(151, 'Овердрафт'),
	(156, 'Affluent'),
	(161, 'Зарплатный проект'),
	(162, 'Проект оптимизации'),
	(163, 'Пакеты услуг');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dir` varchar(50) NOT NULL DEFAULT '0',
  `origin_file_name` varchar(300) DEFAULT '0',
  `file_name` varchar(300) DEFAULT '0',
  `ext` varchar(300) DEFAULT '0',
  `size` int(11) DEFAULT '0',
  `type` varchar(300) DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_files_news` (`news_id`),
  KEY `FK_files_users` (`user_id`),
  CONSTRAINT `FK_files_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  CONSTRAINT `FK_files_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.files: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.log
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `news_id` int(11) NOT NULL DEFAULT '0',
  `news_status` int(11) DEFAULT NULL,
  `model` mediumtext,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.log: ~46 rows (приблизительно)
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
REPLACE INTO `log` (`id`, `user_id`, `news_id`, `news_status`, `model`, `create_date`) VALUES
	(1, 14, 200, 4, '{"id":200,"user_id":14,"category_id":"69","start_date":"18.07.2015","stop_date":null,"title":"\\u043a\\u0432\\u043f","document":"","product":"","text":"<p>\\u044b\\u0432\\u0430\\u043f<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 11:28:10'),
	(2, 14, 200, 4, '{"id":200,"user_id":14,"category_id":"63","start_date":"20.07.2018","stop_date":null,"title":"\\u043a\\u0432\\u043f","document":"","product":"","text":"<p>\\u044b\\u0432\\u0430\\u043f<\\/p>\\r\\n","status":"4","why_bad":"","who_bad":null,"type":3,"create_date":"2015-07-17 11:28:10","publish_date":null}', '2015-07-17 11:28:18'),
	(3, 14, 200, 4, '{"id":200,"user_id":14,"category_id":"63","start_date":"20.07.2020","stop_date":null,"title":"\\u043a\\u0432\\u043f","document":"","product":"","text":"<p>\\u044b\\u0432\\u0430\\u043f<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":3,"create_date":"2015-07-17 11:28:10","publish_date":null}', '2015-07-17 11:28:23'),
	(4, 14, 200, 1, '{"id":200,"user_id":14,"category_id":"63","start_date":"20.07.2020","stop_date":null,"title":"\\u043a\\u0432\\u043f","document":"","product":"","text":"<p>\\u044b\\u0432\\u0430\\u043f<\\/p>\\r\\n","status":"1","why_bad":"","who_bad":null,"type":3,"create_date":"2015-07-17 11:28:10","publish_date":null}', '2015-07-17 11:57:33'),
	(5, 27, 201, 3, '{"id":201,"user_id":27,"category_id":"63","start_date":"2015-07-18","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"1","create_date":null,"publish_date":null}', '2015-07-17 12:42:11'),
	(6, 27, 202, 5, '{"id":202,"user_id":27,"category_id":"60","start_date":"21.07.2015","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:42:35'),
	(7, 27, 203, 4, '{"id":203,"user_id":27,"category_id":"78","start_date":"14.01.1999","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:43:22'),
	(8, 27, 204, 4, '{"id":204,"user_id":27,"category_id":"161","start_date":"02.07.2015","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:43:50'),
	(9, 27, 205, 4, '{"id":205,"user_id":27,"category_id":"60","start_date":"02.07.2015","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:44:10'),
	(10, 27, 206, 5, '{"id":206,"user_id":27,"category_id":"161","start_date":"2015-07-24","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":"1","create_date":null,"publish_date":null}', '2015-07-17 12:44:53'),
	(11, 27, 207, 4, '{"id":207,"user_id":27,"category_id":"161","start_date":"02.07.2015","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:45:16'),
	(12, 27, 208, 4, '{"id":208,"user_id":27,"category_id":"68","start_date":"2015-07-02","stop_date":"2015-07-03","title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"2","create_date":null,"publish_date":null}', '2015-07-17 12:45:54'),
	(13, 27, 209, 4, '{"id":209,"user_id":27,"category_id":"161","start_date":"2015-07-02","stop_date":null,"title":"fghj","document":"","product":"","text":"<p>fghk<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"1","create_date":null,"publish_date":null}', '2015-07-17 12:46:24'),
	(14, 27, 210, 4, '{"id":210,"user_id":27,"category_id":"76","start_date":"02.07.2015","stop_date":null,"title":"dfh","document":"","product":"","text":"<p>dfh<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:46:43'),
	(15, 27, 211, 4, '{"id":211,"user_id":27,"category_id":"76","start_date":"02.07.2015","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>qwef<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:48:16'),
	(16, 27, 212, 4, '{"id":212,"user_id":27,"category_id":"161","start_date":"02.07.2015","stop_date":null,"title":"qwef","document":"","product":"qwef","text":"<p>qwef<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:48:38'),
	(17, 27, 213, 4, '{"id":213,"user_id":27,"category_id":"76","start_date":"2015-07-02","stop_date":null,"title":"qwef","document":"","product":"","text":"<p>qwef<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"1","create_date":null,"publish_date":null}', '2015-07-17 12:50:03'),
	(18, 27, 214, 4, '{"id":214,"user_id":27,"category_id":"161","start_date":"02.07.2015","stop_date":null,"title":"sdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:50:47'),
	(19, 27, 215, 4, '{"id":215,"user_id":27,"category_id":"161","start_date":"","stop_date":null,"title":"sdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:53:45'),
	(20, 27, 216, 4, '{"id":216,"user_id":27,"category_id":"161","start_date":"","stop_date":null,"title":"sdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:53:49'),
	(21, 27, 217, 4, '{"id":217,"user_id":27,"category_id":"161","start_date":"2015-07-02","stop_date":null,"title":"sdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:53:56'),
	(22, 28, 218, 4, '{"id":218,"user_id":28,"category_id":"63","start_date":"","stop_date":null,"title":"zdf","document":"","product":"","text":"<p>gsdfg<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:56:26'),
	(23, 28, 219, 2, '{"id":219,"user_id":28,"category_id":"63","start_date":"2015-07-03","stop_date":null,"title":"werg","document":"","product":"","text":"<p>wegr<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 12:56:50'),
	(24, 28, 219, 5, '{"id":219,"user_id":28,"category_id":"63","start_date":"2015-07-18","stop_date":null,"title":"werg","document":"","product":"","text":"<p>wegr<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":3,"create_date":"2015-07-17 12:56:50","publish_date":null}', '2015-07-17 12:56:57'),
	(25, 14, 220, 4, '{"id":220,"user_id":14,"category_id":"76","start_date":"2015-07-03","stop_date":null,"title":"fd","document":"","product":"","text":"<p>asdfasdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-07-17 13:14:26'),
	(26, 14, 220, 4, '{"id":220,"user_id":14,"category_id":"76","start_date":"2015-07-03","stop_date":null,"title":"fd","document":"","product":"","text":"<p>asdfasdf<\\/p>\\r\\n","status":"4","why_bad":"","who_bad":null,"type":3,"create_date":"2015-07-17 13:14:26","publish_date":null}', '2015-07-17 13:40:02'),
	(27, 14, 220, 4, '{"id":220,"user_id":14,"category_id":"76","start_date":"2015-07-03","stop_date":null,"title":"fd","document":"","product":"","text":"<p>asdfasdf<\\/p>\\r\\n","status":"4","why_bad":"","who_bad":null,"type":3,"create_date":"2015-07-17 13:14:26","publish_date":null}', '2015-07-17 13:40:08'),
	(28, 33, 1, 2, '{"id":1,"user_id":33,"category_id":"69","start_date":"2015-08-05","stop_date":null,"title":"\\u0444\\u044b\\u0432\\u0430","document":"","product":"","text":"<p>\\u0444\\u044b\\u0432\\u0430<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-04 13:17:46'),
	(29, 33, 2, 5, '{"id":2,"user_id":33,"category_id":"63","start_date":"2015-08-07","stop_date":null,"title":"zsdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-04 13:35:54'),
	(30, 33, 3, 2, '{"id":3,"user_id":33,"category_id":"76","start_date":"2015-08-08","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-04 13:42:31'),
	(31, 14, 4, 4, '{"id":4,"user_id":14,"category_id":"66","start_date":"2015-08-15","stop_date":null,"title":"\\u0424\\u042b\\u0412\\u0410","document":"","product":"","text":"<p>\\u0424\\u042b\\u0412\\u0410<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-11 12:33:44'),
	(32, 14, 2, 3, '{"id":2,"user_id":27,"category_id":"63","start_date":"2015-08-07","stop_date":null,"title":"zsdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-04 13:35:54","publish_date":null}', '2015-08-12 10:38:25'),
	(33, 14, 2, 3, '{"id":2,"user_id":27,"category_id":"63","start_date":"2015-08-07","stop_date":null,"title":"zsdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-04 13:35:54","publish_date":null}', '2015-08-12 10:50:06'),
	(34, 28, 5, 2, '{"id":5,"user_id":28,"category_id":"63","start_date":"2015-08-08","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-12 11:35:32'),
	(35, 28, 5, 3, '{"id":5,"user_id":28,"category_id":"63","start_date":"2015-08-08","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-12 11:35:32","publish_date":null}', '2015-08-12 12:06:06'),
	(36, 27, 6, 2, '{"id":6,"user_id":27,"category_id":"156","start_date":"","stop_date":null,"title":"qwerqwer","document":"","product":"","text":"<p>qwerqwer<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-12 12:44:34'),
	(37, 27, 7, 4, '{"id":7,"user_id":27,"category_id":"66","start_date":"","stop_date":null,"title":"qwer","document":"","product":"","text":"<p>qwer<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-12 12:44:50'),
	(38, 27, 8, 3, '{"id":8,"user_id":27,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-12 12:45:18'),
	(39, 28, 8, 4, '{"id":8,"user_id":27,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-12 12:45:18","publish_date":null}', '2015-08-12 13:01:27'),
	(40, 27, 9, 3, '{"id":9,"user_id":27,"category_id":"63","start_date":"","stop_date":null,"title":"gyu","document":"","product":"","text":"<p>ighk<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-12 15:34:33'),
	(41, 32, 10, 2, '{"id":10,"user_id":32,"category_id":"76","start_date":"2015-08-15","stop_date":null,"title":"asd","document":"","product":"","text":"<p>fasdf<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-14 12:54:55'),
	(42, 32, 10, 3, '{"id":10,"user_id":32,"category_id":"63","start_date":"2015-08-15","stop_date":null,"title":"asd","document":"","product":"","text":"<p>fasdf<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-14 12:54:55","publish_date":null}', '2015-08-14 12:56:51'),
	(43, 28, 10, 5, '{"id":10,"user_id":32,"category_id":"63","start_date":"2015-08-15","stop_date":null,"title":"asd","document":"","product":"","text":"<p>fasdf<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-14 12:54:55","publish_date":null}', '2015-08-14 13:44:25'),
	(44, 32, 11, 2, '{"id":11,"user_id":32,"category_id":"63","start_date":"","stop_date":null,"title":"sdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 11:38:44'),
	(45, 28, 9, 4, '{"id":9,"user_id":27,"category_id":"63","start_date":"","stop_date":null,"title":"gyu","document":"","product":"","text":"<p>ighk<\\/p>\\r\\n","status":"4","why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-12 15:34:33","publish_date":null}', '2015-08-17 11:40:29'),
	(46, 28, 12, 2, '{"id":12,"user_id":28,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 12:39:58'),
	(47, 28, 12, 4, '{"id":12,"user_id":28,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-17 12:39:58","publish_date":null}', '2015-08-17 15:33:56'),
	(48, 36, 13, 3, '{"id":13,"user_id":36,"category_id":"63","start_date":"","stop_date":null,"title":"test1 sme","document":"","product":"","text":"<p>test1 sme<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 15:39:18'),
	(49, 36, 14, 3, '{"id":14,"user_id":36,"category_id":"156","start_date":"2015-08-17","stop_date":null,"title":"test1 aff","document":"","product":"","text":"<p>test1 aff<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 15:39:51'),
	(50, 36, 15, 5, '{"id":15,"user_id":36,"category_id":"66","start_date":"","stop_date":null,"title":"test1 dbo","document":"","product":"","text":"<p>test1 dbo<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 15:40:30'),
	(51, 36, 16, 3, '{"id":16,"user_id":36,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:23:03'),
	(52, 36, 17, 3, '{"id":17,"user_id":36,"category_id":"156","start_date":"2015-08-13","stop_date":null,"title":"serg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:23:26'),
	(53, 36, 18, 4, '{"id":18,"user_id":36,"category_id":"156","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:43:13'),
	(54, 36, 19, 3, '{"id":19,"user_id":36,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:43:38'),
	(55, 36, 20, 4, '{"id":20,"user_id":36,"category_id":"156","start_date":"2015-08-13","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdfasdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:44:26'),
	(56, 36, 21, 5, '{"id":21,"user_id":36,"category_id":"161","start_date":"2015-08-13","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:44:49'),
	(57, 37, 19, 4, '{"id":19,"user_id":36,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":"4","why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-17 16:43:38","publish_date":null}', '2015-08-17 16:45:24'),
	(58, 37, 16, 5, '{"id":16,"user_id":36,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-17 16:23:03","publish_date":null}', '2015-08-17 16:45:59'),
	(59, 37, 13, 3, '{"id":13,"user_id":36,"category_id":"63","start_date":"","stop_date":null,"title":"test1 sme","document":"","product":"","text":"<p>test1 sme<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":3,"create_date":"2015-08-17 15:39:18","publish_date":null}', '2015-08-17 16:46:17'),
	(60, 37, 22, 4, '{"id":22,"user_id":37,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:47:11'),
	(61, 37, 23, 4, '{"id":23,"user_id":37,"category_id":"156","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:47:31'),
	(62, 37, 24, 5, '{"id":24,"user_id":37,"category_id":"82","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdf<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-17 16:47:50'),
	(63, 38, 25, 3, '{"id":25,"user_id":38,"category_id":"63","start_date":"","stop_date":null,"title":"sdfg","document":"","product":"","text":"<p>sdfg<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-18 08:58:04'),
	(64, 38, 26, 4, '{"id":26,"user_id":38,"category_id":"156","start_date":"","stop_date":null,"title":"ag","document":"","product":"","text":"<p>asg<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-18 08:58:28'),
	(65, 38, 27, 3, '{"id":27,"user_id":38,"category_id":"63","start_date":"","stop_date":null,"title":"asdf","document":"","product":"","text":"<p>asdfg<\\/p>\\r\\n","status":"3","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-18 09:56:57'),
	(66, 38, 28, 4, '{"id":28,"user_id":38,"category_id":"156","start_date":"","stop_date":null,"title":"ryuy","document":"","product":"","text":"<p>fyku<\\/p>\\r\\n","status":4,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-18 09:57:49'),
	(67, 38, 29, 5, '{"id":29,"user_id":38,"category_id":"156","start_date":"","stop_date":null,"title":"l[","document":"","product":"","text":"<p>iop&#39;<\\/p>\\r\\n","status":5,"why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-18 10:02:12'),
	(68, 38, 28, 10, '{"id":28,"user_id":38,"category_id":"156","start_date":"","stop_date":null,"title":"ryuy","document":"","product":"","text":"<p>fyku<\\/p>\\r\\n","status":"10","why_bad":"af","who_bad":null,"type":3,"create_date":"2015-08-18 09:57:49","publish_date":null}', '2015-08-18 10:02:28'),
	(69, 38, 26, 10, '{"id":26,"user_id":38,"category_id":"156","start_date":"","stop_date":null,"title":"ag","document":"","product":"","text":"<p>asg<\\/p>\\r\\n","status":"10","why_bad":"sdfgsdfg","who_bad":38,"type":3,"create_date":"2015-08-18 08:58:28","publish_date":null}', '2015-08-18 10:11:33'),
	(70, 38, 28, 5, '{"id":28,"user_id":38,"category_id":"156","start_date":"","stop_date":null,"title":"ryuy","document":"","product":"","text":"<p>fyku<\\/p>\\r\\n","status":5,"why_bad":"af","who_bad":null,"type":3,"create_date":"2015-08-18 09:57:49","publish_date":null}', '2015-08-18 10:12:24'),
	(71, 14, 30, 2, '{"id":30,"user_id":14,"category_id":"63","start_date":"","stop_date":null,"title":"sfag","document":"","product":"","text":"<p>asfd<\\/p>\\r\\n","status":"2","why_bad":"","who_bad":null,"type":"3","create_date":null,"publish_date":null}', '2015-08-18 10:13:34');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.milestone
CREATE TABLE IF NOT EXISTS `milestone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL DEFAULT '1',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `close_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.milestone: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `milestone` DISABLE KEYS */;
REPLACE INTO `milestone` (`id`, `active`, `create_date`, `close_date`) VALUES
	(8, 0, '2015-06-26 10:34:01', NULL),
	(9, 0, '2015-06-26 10:35:58', NULL),
	(10, 0, '2015-06-26 10:39:28', NULL),
	(11, 0, '2015-06-29 16:53:34', NULL),
	(13, 0, '2015-06-29 17:45:31', NULL),
	(14, 0, '2015-07-10 12:54:47', NULL),
	(15, 0, '2015-07-10 15:34:34', NULL),
	(16, 1, '2015-07-29 15:11:07', NULL);
/*!40000 ALTER TABLE `milestone` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `stop_date` date DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `document` char(150) DEFAULT NULL,
  `product` char(150) DEFAULT NULL,
  `text` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `why_bad` char(255) DEFAULT NULL,
  `who_bad` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `publish_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_news_users` (`user_id`),
  KEY `FK_news_categories` (`category_id`),
  KEY `FK_news_users_2` (`who_bad`),
  CONSTRAINT `FK_news_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `FK_news_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_news_users_2` FOREIGN KEY (`who_bad`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.news: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
REPLACE INTO `news` (`id`, `user_id`, `category_id`, `start_date`, `stop_date`, `title`, `document`, `product`, `text`, `status`, `why_bad`, `who_bad`, `type`, `create_date`, `publish_date`) VALUES
	(13, 36, 63, NULL, NULL, 'test1 sme', '', '', '<p>test1 sme</p>\r\n', 3, '', NULL, 3, '2015-08-17 15:39:18', NULL),
	(14, 36, 156, '2015-08-17', NULL, 'test1 aff', '', '', '<p>test1 aff</p>\r\n', 3, '', NULL, 3, '2015-08-17 15:39:51', NULL),
	(15, 36, 66, NULL, NULL, 'test1 dbo', '', '', '<p>test1 dbo</p>\r\n', 5, '', NULL, 3, '2015-08-17 15:40:30', NULL),
	(16, 36, 63, NULL, NULL, 'asdf', '', '', '<p>asdf</p>\r\n', 5, '', NULL, 3, '2015-08-17 16:23:03', NULL),
	(17, 36, 156, '2015-08-13', NULL, 'serg', '', '', '<p>sdfg</p>\r\n', 3, '', NULL, 3, '2015-08-17 16:23:26', NULL),
	(18, 36, 156, NULL, NULL, 'asdf', '', '', '<p>asdf</p>\r\n', 4, '', NULL, 3, '2015-08-17 16:43:13', NULL),
	(19, 36, 63, NULL, NULL, 'asdf', '', '', '<p>asdf</p>\r\n', 4, '', NULL, 3, '2015-08-17 16:43:38', NULL),
	(20, 36, 156, '2015-08-13', NULL, 'asdf', '', '', '<p>asdfasdf</p>\r\n', 4, '', NULL, 3, '2015-08-17 16:44:26', NULL),
	(21, 36, 161, '2015-08-13', NULL, 'asdf', '', '', '<p>asdf</p>\r\n', 5, '', NULL, 3, '2015-08-17 16:44:49', NULL),
	(22, 37, 63, NULL, NULL, 'asdf', '', '', '<p>asdf</p>\r\n', 4, '', NULL, 3, '2015-08-17 16:47:11', NULL),
	(23, 37, 156, NULL, NULL, 'asdf', '', '', '<p>asdf</p>\r\n', 4, '', NULL, 3, '2015-08-17 16:47:31', NULL),
	(24, 37, 82, NULL, NULL, 'asdf', '', '', '<p>asdf</p>\r\n', 5, '', NULL, 3, '2015-08-17 16:47:50', NULL),
	(25, 38, 63, NULL, NULL, 'sdfg', '', '', '<p>sdfg</p>\r\n', 3, '', NULL, 3, '2015-08-18 08:58:04', NULL),
	(26, 38, 156, NULL, NULL, 'ag', '', '', '<p>asg</p>\r\n', 10, 'sdfgsdfg', 38, 3, '2015-08-18 08:58:28', NULL),
	(27, 38, 63, NULL, NULL, 'asdf', '', '', '<p>asdfg</p>\r\n', 3, '', NULL, 3, '2015-08-18 09:56:57', NULL),
	(28, 38, 156, NULL, NULL, 'ryuy', '', '', '<p>fyku</p>\r\n', 5, 'af', NULL, 3, '2015-08-18 09:57:49', NULL),
	(29, 38, 156, NULL, NULL, 'l[', '', '', '<p>iop&#39;</p>\r\n', 5, '', NULL, 3, '2015-08-18 10:02:12', NULL),
	(30, 14, 63, NULL, NULL, 'sfag', '', '', '<p>asfd</p>\r\n', 2, '', NULL, 3, '2015-08-18 10:13:34', NULL);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.question
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `bad_answers` text NOT NULL,
  `outlet_managers` int(11) DEFAULT NULL COMMENT 'Outlet managers',
  `mass_seller` int(11) DEFAULT NULL COMMENT 'Mass seller',
  `affluent` int(11) DEFAULT NULL COMMENT 'Affluent',
  `car_lending_partnership` int(11) DEFAULT NULL COMMENT 'Car lending partnership',
  `dsa_credit_products_sales` int(11) DEFAULT NULL COMMENT 'DSA Credit Products Sales',
  `mortgage_lending_rm` int(11) DEFAULT NULL COMMENT 'Mortgage lending RM',
  `sme_hunter` int(11) DEFAULT NULL COMMENT 'SME Hunter',
  `sme_prime` int(11) DEFAULT NULL COMMENT 'SME Prime',
  `easy_rm` int(11) DEFAULT NULL COMMENT 'Easy RM',
  `milestone_id` int(11) DEFAULT NULL COMMENT 'контрольная точка',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_question_milestone` (`milestone_id`),
  KEY `FK_question_users` (`user_id`),
  KEY `FK_question_news` (`news_id`),
  CONSTRAINT `FK_question_milestone` FOREIGN KEY (`milestone_id`) REFERENCES `milestone` (`id`),
  CONSTRAINT `FK_question_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  CONSTRAINT `FK_question_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.question: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
REPLACE INTO `question` (`id`, `news_id`, `user_id`, `question`, `answer`, `bad_answers`, `outlet_managers`, `mass_seller`, `affluent`, `car_lending_partnership`, `dsa_credit_products_sales`, `mortgage_lending_rm`, `sme_hunter`, `sme_prime`, `easy_rm`, `milestone_id`, `date`) VALUES
	(22, 13, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 0, 0, 1, 0, 0, 1, 0, 0, 16, '2015-08-17 15:39:18'),
	(23, 14, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 1, 1, 0, 0, 0, 0, 0, 0, 16, '2015-08-17 15:39:51'),
	(24, 15, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 1, 0, 1, 0, 0, 0, 0, 0, 16, '2015-08-17 15:40:30'),
	(25, 16, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 1, 0, 0, 0, 0, 0, 1, 0, 16, '2015-08-17 16:23:04'),
	(26, 17, 36, 'sdfg', 'sdfgsd', '{"ba1":"sdfg"}', 0, 0, 0, 0, 1, 0, 0, 0, 0, 16, '2015-08-17 16:23:26'),
	(27, 18, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 0, 0, 0, 1, 0, 0, 0, 0, 16, '2015-08-17 16:43:13'),
	(28, 19, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 0, 0, 0, 0, 0, 0, 1, 0, 16, '2015-08-17 16:43:38'),
	(29, 20, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 0, 1, 0, 1, 0, 0, 0, 0, 16, '2015-08-17 16:44:26'),
	(30, 21, 36, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 0, 0, 1, 0, 1, 0, 0, 0, 16, '2015-08-17 16:44:49'),
	(31, 22, 37, 'fasdf', 'asd', '{"ba1":"asdf"}', 0, 0, 1, 0, 1, 0, 0, 0, 0, 16, '2015-08-17 16:47:11'),
	(32, 23, 37, 'asdf', 'asdf', '{"ba1":"asdf"}', 0, 0, 0, 1, 0, 1, 0, 0, 0, 16, '2015-08-17 16:47:31'),
	(33, 24, 37, 'asdf', 'asdf', '{"ba1":"sadf"}', 0, 1, 0, 0, 1, 0, 0, 0, 0, 16, '2015-08-17 16:47:50'),
	(34, 25, 38, 'dfg', 'sfgh', '{"ba1":"dfgj"}', 0, 1, 0, 0, 0, 0, 0, 0, 1, 16, '2015-08-18 08:58:04'),
	(35, 26, 38, 'erg', 'sdbg', '{"ba1":"sdfh"}', 0, 1, 0, 0, 1, 0, 0, 0, 0, 16, '2015-08-18 08:58:28'),
	(36, 27, 38, 'gul', 'hkl;', '{"ba1":"hk;l"}', 0, 0, 0, 0, 1, 0, 1, 0, 0, 16, '2015-08-18 09:56:57'),
	(37, 28, 38, 'ftyu', 'ftu', '{"ba1":"yjl"}', 0, 0, 0, 1, 1, 0, 0, 0, 0, 16, '2015-08-18 09:57:49'),
	(38, 29, 38, 'ip[\'', 'ip[\'', '{"ba1":"ip[\'"}', 0, 0, 1, 0, 0, 1, 0, 0, 0, 16, '2015-08-18 10:02:12'),
	(39, 30, 14, 'sdfg', 'sdfg', '{"ba1":"sdfg","ba2":"sdfg"}', 0, 0, 0, 1, 0, 1, 0, 0, 0, 16, '2015-08-18 10:13:34');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.relation_categories
CREATE TABLE IF NOT EXISTS `relation_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK__categories` (`category_id`),
  KEY `FK_relation_cat_moder_users` (`user_id`),
  CONSTRAINT `FK__categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.relation_categories: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `relation_categories` DISABLE KEYS */;
REPLACE INTO `relation_categories` (`id`, `user_id`, `category_id`, `create_user_id`, `create_date`) VALUES
	(5, 37, 63, 14, '2015-08-17 15:36:17'),
	(6, 38, 63, 14, '2015-08-17 15:36:26'),
	(7, 38, 156, 14, '2015-08-17 15:36:28');
/*!40000 ALTER TABLE `relation_categories` ENABLE KEYS */;


-- Дамп структуры для таблица v2_unicnews.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) DEFAULT NULL,
  `name_ru` varchar(100) DEFAULT NULL,
  `name_en` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы v2_unicnews.users: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `login`, `name_ru`, `name_en`, `email`, `date_reg`) VALUES
	(14, 'admin', 'admin', NULL, NULL, '2015-06-26 09:03:28'),
	(36, 'author', 'author', NULL, NULL, '2015-08-17 15:35:25'),
	(37, 'moder', 'moder', NULL, NULL, '2015-08-17 15:35:32'),
	(38, 'smoder', 'smoder', NULL, NULL, '2015-08-17 15:35:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
