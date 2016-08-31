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

-- Дамп данных таблицы v2_unicnews.auth_item: ~24 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
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
	('updateNewsModerator', 2, NULL, 'statusAllowUpdateNews', NULL, 1433255707, 1433255707),
	('updateNewsOwn', 2, NULL, 'userOwn', NULL, 1433255707, 1433255707),
	('updateQuestion', 2, NULL, 'milestone', NULL, 1433255707, 1433255707),
	('updateQuestionOwn', 2, NULL, 'userOwn', NULL, 1433255707, 1433255707),
	('view', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('viewNews', 2, NULL, NULL, NULL, 1433255707, 1433255707),
	('viewNewsModerator', 2, NULL, 'statusAllowUpdateNews', NULL, 1433255707, 1433255707),
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

-- Дамп данных таблицы v2_unicnews.auth_item_child: ~32 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
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
	('updateQuestionOwn', 'updateQuestion'),
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
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
