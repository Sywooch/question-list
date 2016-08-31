-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 172.17.145.49:3306
-- Время создания: Авг 31 2016 г., 07:52
-- Версия сервера: 5.6.22-log
-- Версия PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `questionlist`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '4', NULL),
('guest', '6', 1472569944),
('guest', '7', 1472573297);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администратор', NULL, NULL, 1472568620, 1472568620),
('createChecklist', 2, 'Создавать опросные листы', NULL, NULL, 1472548070, 1472548070),
('guest', 1, 'Гость', NULL, NULL, 1472568620, 1472568620),
('manager', 1, 'Управляющий', NULL, NULL, 1472568620, 1472568620),
('manageUsers', 2, 'Изменять данные пользователей', NULL, NULL, 1472548070, 1472548070);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('manager', 'guest'),
('admin', 'manager');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1470730872),
('m140506_102106_rbac_init', 1472473795),
('m140608_173539_create_user_table', 1470730879),
('m140611_133903_init_rbac', 1470730881),
('m140808_073114_create_auth_item_group_table', 1470730883),
('m140809_072112_insert_superadmin_to_user', 1470730884),
('m140809_073114_insert_common_permisison_to_auth_item', 1470730884),
('m141023_141535_create_user_visit_log', 1470730884),
('m141116_115804_add_bind_to_ip_and_registration_ip_to_user', 1470730885),
('m141121_194858_split_browser_and_os_column', 1470730886),
('m141201_220516_add_email_and_email_confirmed_to_user', 1470730886),
('m141207_001649_create_basic_user_permissions', 1470730886),
('m160201_084147_questionlist', 1470730917);

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_answers`
--

CREATE TABLE IF NOT EXISTS `questionlist_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `question_list_id` int(11) NOT NULL,
  `answer_date` date DEFAULT NULL,
  `answer` varchar(1000) NOT NULL,
  `answer_list_id` int(11) NOT NULL,
  `answer_comment` varchar(1000) DEFAULT NULL,
  `profile_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Дамп данных таблицы `questionlist_answers`
--

INSERT INTO `questionlist_answers` (`id`, `question_id`, `question_list_id`, `answer_date`, `answer`, `answer_list_id`, `answer_comment`, `profile_id`) VALUES
(1, 1, 1, '2016-08-12', '2', 1, 'hdfhdfs', ''),
(2, 2, 1, '2016-08-12', '4', 1, 'sdgsdg', ''),
(3, 3, 2, '2016-08-09', 'Смотрю телевизор', 2, 'Да, смотрю его.И чего?', ''),
(4, 4, 2, '2016-08-09', '16', 2, 'И вам советую!!!', ''),
(5, 16, 1, '2016-08-12', 'dfhfdhsfd', 1, '', ''),
(6, 18, 1, '2016-08-12', '1', 1, '', ''),
(7, 19, 1, '2016-08-12', '30', 1, 'sdgsdfh', ''),
(8, 22, 1, '2016-08-12', '42', 1, '', ''),
(9, 23, 1, '2016-08-12', '0', 1, '', ''),
(26, 1, 1, NULL, '2', 5, 'htht', ''),
(27, 2, 1, NULL, '4', 5, 'TEST', ''),
(28, 16, 1, NULL, 'ОЛООЛsdgsda', 5, '', ''),
(29, 18, 1, NULL, '1', 5, '', ''),
(30, 19, 1, NULL, '29', 5, '', ''),
(31, 22, 1, NULL, '32', 5, 'dfhfdhfd', ''),
(32, 23, 1, NULL, '1', 5, '', ''),
(33, 27, 1, NULL, 'шщдлвлвы', 5, '', ''),
(34, 3, 2, NULL, '5', 4, '', ''),
(35, 4, 2, NULL, '8', 4, 'jkadjkda', ''),
(36, 1, 1, NULL, '1', 10, '', ''),
(37, 2, 1, NULL, '4', 10, 'dffdshfd', ''),
(38, 16, 1, NULL, 'dfhfdsh', 10, '', ''),
(39, 18, 1, NULL, '1', 10, '', ''),
(40, 19, 1, NULL, '30', 10, 'sdgsad', ''),
(41, 22, 1, NULL, '42', 10, '', ''),
(42, 23, 1, NULL, '0', 10, '', ''),
(43, 27, 1, NULL, 'sdsdh', 10, '', ''),
(44, 1, 1, NULL, '1', 12, '', ''),
(45, 2, 1, NULL, '3', 12, '', ''),
(46, 16, 1, NULL, 'Ответ на вопрос', 12, '', ''),
(47, 18, 1, NULL, '1', 12, '', ''),
(48, 19, 1, NULL, '29', 12, '', ''),
(49, 22, 1, NULL, '42', 12, '', ''),
(50, 23, 1, NULL, '0', 12, '', ''),
(51, 27, 1, NULL, 'Ответ на вопрос 2', 12, '', ''),
(52, 27, 1, NULL, 'sdgsda', 1, '', ''),
(53, 28, 3, NULL, '44', 15, 'sdgds', ''),
(54, 30, 3, NULL, '1', 15, '', ''),
(55, 31, 3, NULL, 'kllkkl', 15, '', ''),
(56, 32, 3, NULL, '50', 15, '', ''),
(57, 33, 3, NULL, '1', 15, '', ''),
(58, 34, 3, NULL, ';l;jkp''oj;', 15, '', ''),
(59, 36, 3, NULL, 'kl;lh;lh', 15, '', ''),
(67, 36, 3, NULL, 'Изменено', 16, '', 'mb22319'),
(68, 30, 3, NULL, '0', 16, '', ''),
(69, 28, 3, NULL, '', 16, '', 'admin'),
(70, 32, 3, NULL, '49', 16, '', 'mb22318'),
(71, 33, 3, NULL, '0', 16, '', ''),
(72, 34, 3, NULL, ';kl', 16, '', 'admin'),
(73, 31, 3, NULL, 'Ответ на вопрос', 16, '', 'mb22319');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_answers_variants`
--

CREATE TABLE IF NOT EXISTS `questionlist_answers_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `scores` int(11) DEFAULT NULL,
  `html_attributes` varchar(1000) NOT NULL DEFAULT '{}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Дамп данных таблицы `questionlist_answers_variants`
--

INSERT INTO `questionlist_answers_variants` (`id`, `question_id`, `answer`, `scores`, `html_attributes`) VALUES
(1, 1, 'Вариант 1', 4, '{"showcomment":"0"}'),
(2, 1, 'вариант 2', 23, '{"showcomment":"1"}'),
(3, 2, 'TETS', 0, '{"showcomment":"0"}'),
(4, 2, 'sdahdash', 234, '{"showcomment":"1"}'),
(5, 3, 'Смотрю телевизор!', 3, '{}'),
(6, 3, 'Иду гулять', 1, '{}'),
(7, 4, '18', 1, '{"showcomment":"0"}'),
(8, 4, '16', 2, '{"showcomment":"1"}'),
(9, 4, 'Не курю', 100, '{"showcomment":"1"}'),
(10, 11, '21', 1212, '{}'),
(11, 12, 'fsdhfdhs', 12, '{}'),
(12, 12, '1dsgasdg', 213, '{}'),
(13, 13, 'sdahds', 23, '{}'),
(25, 3, 'А что?', 100, '{}'),
(29, 19, 'Да, обожаю их!', 100, '{}'),
(30, 19, 'Нет, они меня бесят!', 50, '{"showcomment":"1"}'),
(31, 21, '1221', 211, '{}'),
(32, 22, 'ДА, вижу', 3324, '{"showcomment":"1"}'),
(39, 23, '1', 100, '{}'),
(42, 22, 'Вот такой вариант', 100, '{"showcomment":"0"}'),
(43, 1, 'Jndtn asdgsd', 23, '{"showcomment":"0"}'),
(44, 28, 'hfsdhsdf', 213, '{"showcomment":"1"}'),
(45, 28, 'asgsadgsfdhgdsah', 23, '{"showcomment":"0"}'),
(48, 30, '1', 100, '{}'),
(49, 32, 'sdag', 423, '{"showcomment":"0"}'),
(50, 32, 'wadgawdsg', 23, '{"showcomment":"0"}'),
(51, 33, '1', 213, '{}');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_answer_list`
--

CREATE TABLE IF NOT EXISTS `questionlist_answer_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_list_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `do_id` int(11) NOT NULL,
  `scores` int(11) DEFAULT NULL,
  `comment` text,
  `author` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `questionlist_answer_list`
--

INSERT INTO `questionlist_answer_list` (`id`, `question_list_id`, `date_from`, `date_to`, `date`, `status`, `do_id`, `scores`, `comment`, `author`) VALUES
(1, 1, '2016-08-09', '2016-08-10', '2016-08-12', 'answered', 1, 407, 'Что за ответы????', 'mb22318'),
(2, 2, '2016-08-09', '2016-09-09', '2016-08-09', 'send', 1, 5, 'Перезаполните!', 'mb22318'),
(4, 2, '2016-08-10', '2016-09-10', '2016-08-14', 'send', 1, 5, NULL, 'mb22318'),
(5, 1, '2016-08-13', '2016-09-13', '2016-08-14', 'send', 1, 3681, NULL, 'mb22318'),
(7, 2, '2016-08-15', '2016-09-15', '2016-08-15', 'archive', 1, NULL, NULL, NULL),
(10, 1, '2016-08-18', '2016-09-18', '2016-08-18', 'archive', 1, 388, 'В архиве\r\n', 'mb22318'),
(12, 1, '2016-08-18', '2016-09-17', '2016-08-18', 'archive', 3, 204, NULL, 'mb22318'),
(15, 3, '2016-08-27', '2016-09-27', '2016-08-27', 'answered', 1, 236, NULL, 'admin'),
(16, 3, '2016-08-29', '2016-09-29', '2016-08-29', 'answered', 1, 423, NULL, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_office`
--

CREATE TABLE IF NOT EXISTS `questionlist_office` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `region_id` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `questionlist_office`
--

INSERT INTO `questionlist_office` (`id`, `region_id`, `name`) VALUES
(1, 1, 'ДО Московский'),
(2, 1, 'ДО Водный стадион'),
(3, 2, 'Офис 3'),
(4, 3, 'Офис из 3го региона');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_question`
--

CREATE TABLE IF NOT EXISTS `questionlist_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `quest_text` varchar(1000) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `visible_condition` varchar(1000) DEFAULT NULL,
  `visible_condition_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `list_id` (`list_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Дамп данных таблицы `questionlist_question`
--

INSERT INTO `questionlist_question` (`id`, `list_id`, `type`, `quest_text`, `ordering`, `visible_condition`, `visible_condition_value`) VALUES
(1, 1, 'select_one', 'Вопрос 10, очень длинный. Вопрос 10, очень длинный.Вопрос 10, очень длинный.Вопрос 10, очень длинный.Вопрос 10, очень длинный.Вопрос 10, очень длинный.Вопрос 10, очень длинный.Вопрос 10, очень длинный.Вопрос 10, очень длинный.????', NULL, '', NULL),
(2, 1, 'radio', 'Вопрос 1sdgdsagds', NULL, '', NULL),
(3, 2, 'select_one', 'Что делаете после работы?АА?', NULL, '', NULL),
(4, 2, 'select_one', 'Во сколько лет Вы начали курить?', NULL, '', NULL),
(16, 1, 'text', 'Вот такой вот вопрос!', NULL, '', NULL),
(18, 1, 'checkbox', 'Согласен на все условия', NULL, '', NULL),
(19, 1, 'radio', 'Вам нравятся радио кнопки?', NULL, '', NULL),
(22, 1, 'select_one', 'Вы что видите эти опросы?', NULL, '', NULL),
(23, 1, 'checkbox', 'Вы хотите установить чек-бокс?', NULL, '', NULL),
(27, 1, 'text', 'klskldfklgf', NULL, '', NULL),
(28, 3, 'select_one', 'Как джыфдфваырджафвырдфдпджарвджфы ?', 3, '30', '1'),
(30, 3, 'checkbox', 'Полывароаывровадравдрдав', 2, '', NULL),
(31, 3, 'text', 'fshsdf', 8, '', ''),
(32, 3, 'radio', 'zsdfsdhfd', 4, '', ''),
(33, 3, 'checkbox', 'sdhsdfhdf', 5, '', ''),
(34, 3, 'text', 'ывпвыпыв', 6, '', ''),
(36, 3, 'text', 'YFYFYF', 1, '', ''),
(37, 4, 'text', 'ВОпрос номер 1', 1, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_question_list`
--

CREATE TABLE IF NOT EXISTS `questionlist_question_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `questionlist_question_list`
--

INSERT INTO `questionlist_question_list` (`id`, `title`) VALUES
(1, 'Тестирование'),
(2, 'Вопросник 2'),
(3, 'Новый список опросов для отделений'),
(4, 'NEW BABY');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_region`
--

CREATE TABLE IF NOT EXISTS `questionlist_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `questionlist_region`
--

INSERT INTO `questionlist_region` (`id`, `name`) VALUES
(2, 'Звенигород'),
(1, 'Москва'),
(3, 'Регион 3');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_users`
--

CREATE TABLE IF NOT EXISTS `questionlist_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` varchar(100) NOT NULL,
  `fullname` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `reg_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `questionlist_users`
--

INSERT INTO `questionlist_users` (`id`, `profile_id`, `fullname`, `email`, `reg_date`) VALUES
(4, 'mb22318', 'Грибов Илья Андреевич', 'Ilya.Gribov@unicredit.ru', '0000-00-00'),
(6, 'mb22319', '', '', '0000-00-00'),
(7, 'dfsjdjkf', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_users_offices`
--

CREATE TABLE IF NOT EXISTS `questionlist_users_offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` varchar(50) NOT NULL,
  `office_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `profile_office_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Дамп данных таблицы `questionlist_users_offices`
--

INSERT INTO `questionlist_users_offices` (`id`, `profile_id`, `office_id`, `region_id`, `profile_office_role`) VALUES
(2, 'mb22318', 3, 1, 'manager'),
(4, 'mb22319', 0, 1, 'commercial_director'),
(5, 'mb22321', 0, 2, 'commercial_director'),
(6, 'admin', 0, 0, 'admin'),
(7, 'mb22320', 3, 2, 'commercial_director'),
(15, 'mb22321', 0, 1, 'commercial_director'),
(29, 'mvxnbfd', 2, 1, 'manager'),
(30, 'mb22319', 0, 2, 'commercial_director'),
(31, 'dssds', 0, 0, 'manager'),
(32, 'sdg', 1, 2, 'manager'),
(33, 'sdgsdg', 2, 2, 'admin'),
(34, 'sfsdgsd', 1, 1, 'manager'),
(35, 'dsh', 1, 1, 'admin'),
(36, 'admin', 1, 1, 'manager');

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_users_to_offices`
--

CREATE TABLE IF NOT EXISTS `questionlist_users_to_offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `office_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `office_id` (`office_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `questionlist_users_to_offices`
--

INSERT INTO `questionlist_users_to_offices` (`id`, `user_id`, `office_id`) VALUES
(1, 4, 1),
(2, 4, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `questionlist_users_to_regions`
--

CREATE TABLE IF NOT EXISTS `questionlist_users_to_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `region_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`region_id`),
  KEY `region_id` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questionlist_office`
--
ALTER TABLE `questionlist_office`
  ADD CONSTRAINT `questionlist_office_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `questionlist_region` (`id`);

--
-- Ограничения внешнего ключа таблицы `questionlist_users_to_offices`
--
ALTER TABLE `questionlist_users_to_offices`
  ADD CONSTRAINT `questionlist_users_to_offices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `questionlist_users` (`id`),
  ADD CONSTRAINT `questionlist_users_to_offices_ibfk_2` FOREIGN KEY (`office_id`) REFERENCES `questionlist_office` (`id`);

--
-- Ограничения внешнего ключа таблицы `questionlist_users_to_regions`
--
ALTER TABLE `questionlist_users_to_regions`
  ADD CONSTRAINT `questionlist_users_to_regions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `questionlist_users` (`id`),
  ADD CONSTRAINT `questionlist_users_to_regions_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `questionlist_region` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
