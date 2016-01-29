-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 28 2016 г., 11:53
-- Версия сервера: 5.5.45
-- Версия PHP: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(1000) NOT NULL,
  `question_type` varchar(25) NOT NULL,
  `question_id` int(11) NOT NULL,
  `profile_id` varchar(25) DEFAULT NULL,
  `question_list_id` int(11) NOT NULL,
  `answer_date` date DEFAULT NULL,
  `answer` varchar(1000) NOT NULL,
  `answer_list_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `question_text`, `question_type`, `question_id`, `profile_id`, `question_list_id`, `answer_date`, `answer`, `answer_list_id`) VALUES
(60, 'Вопрос один ?', 'multiple', 267, 'igribov', 145, '2016-01-26', 'три', 7),
(61, 'Еще вопрос?', 'boolean', 268, 'igribov', 145, '2016-01-26', 'Нет', 7),
(62, 'Еще один вопрос?', 'text', 269, 'igribov', 145, '2016-01-26', 'Отвечаю!', 7),
(63, 'Вопрос то один', 'boolean', 270, 'manager', 146, '2016-01-27', 'Нет', 8),
(64, 'Вопрос то один', 'boolean', 270, 'manager2', 146, '2016-01-26', 'Да', 9),
(65, 'Вопрос то один', 'boolean', 270, 'manager', 146, '2016-01-27', 'Нет', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `answers_variants`
--

CREATE TABLE IF NOT EXISTS `answers_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

--
-- Дамп данных таблицы `answers_variants`
--

INSERT INTO `answers_variants` (`id`, `question_id`, `answer`) VALUES
(245, 267, 'два'),
(246, 267, 'три'),
(247, 267, 'один'),
(250, 271, 'Да, готов'),
(251, 271, 'Нет, не готов');

-- --------------------------------------------------------

--
-- Структура таблицы `answer_list`
--

CREATE TABLE IF NOT EXISTS `answer_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_list_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `do_id` int(11) NOT NULL,
  `list_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `answer_list`
--

INSERT INTO `answer_list` (`id`, `question_list_id`, `date_from`, `date_to`, `status`, `do_id`, `list_name`) VALUES
(8, 147, '2016-01-03', '2016-01-07', 'done', 2, 'Про жизнь'),
(9, 146, '2016-01-01', '2016-01-30', 'done', 2, 'sgdsd'),
(10, 146, '2016-01-01', '2016-01-01', 'answered', 1, 'Новый опрос'),
(11, 146, '2016-01-08', '2016-01-24', 'answered', 1, 'Новый опрос'),
(16, 146, '2016-01-01', '2016-01-31', 'clear', 2, 'Новый опрос'),
(17, 146, '2016-01-01', '2016-01-01', 'clear', 1, 'Новый опрос');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', 1, 1453799056),
('unicredQuestionListSystemAdmin', 3, 1453881250),
('unicredQuestionListSystemCommercialDirector', 2, 1453881511),
('unicredQuestionListSystemManager', 4, 1453883636),
('unicredQuestionListSystemManager', 5, 1453883673);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `group_code` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  KEY `fk_auth_item_group_code` (`group_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`, `group_code`) VALUES
('/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/debug/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/debug/default/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/debug/default/db-explain', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/debug/default/download-mail', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/debug/default/index', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/debug/default/toolbar', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/debug/default/view', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/gii/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/gii/default/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/gii/default/action', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/gii/default/diff', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/gii/default/index', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/gii/default/preview', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/gii/default/view', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/gridview/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/gridview/export/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/gridview/export/download', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/about', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/captcha', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/contact', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/error', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/index', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/login', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/site/logout', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/answer-list/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/answer-list/create', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/answer-list/delete', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/answer-list/index', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/answer-list/update', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/answer-list/view', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/default/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/default/index', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/office/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/office/create', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/office/delete', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/office/index', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/office/update', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/office/view', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/question-list-constructor/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/question-list-constructor/create', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/question-list-constructor/delete', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/question-list-constructor/index', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/question-list-constructor/update', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/question-list-constructor/view', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/users-offices/*', 3, NULL, NULL, NULL, 1453815854, 1453815854, NULL),
('/unicred/users-offices/bulk-delete', 3, NULL, NULL, NULL, 1453815854, 1453815854, NULL),
('/unicred/users-offices/create', 3, NULL, NULL, NULL, 1453815854, 1453815854, NULL),
('/unicred/users-offices/delete', 3, NULL, NULL, NULL, 1453815854, 1453815854, NULL),
('/unicred/users-offices/index', 3, NULL, NULL, NULL, 1453815854, 1453815854, NULL),
('/unicred/users-offices/update', 3, NULL, NULL, NULL, 1453815854, 1453815854, NULL),
('/unicred/users-offices/view', 3, NULL, NULL, NULL, 1453815854, 1453815854, NULL),
('/unicred/write-test/*', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/write-test/create', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/write-test/index', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/write-test/update', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/unicred/write-test/view', 3, NULL, NULL, NULL, 1453798831, 1453798831, NULL),
('/user-management/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/bulk-activate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/bulk-deactivate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/bulk-delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/create', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/grid-page-size', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/grid-sort', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/index', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/toggle-attribute', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/update', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth-item-group/view', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/captcha', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/change-own-password', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/confirm-email', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/confirm-email-receive', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/confirm-registration-email', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/login', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/logout', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/password-recovery', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/password-recovery-receive', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/auth/registration', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/bulk-activate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/bulk-deactivate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/bulk-delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/create', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/grid-page-size', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/grid-sort', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/index', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/refresh-routes', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/set-child-permissions', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/set-child-routes', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/toggle-attribute', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/update', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/permission/view', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/bulk-activate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/bulk-deactivate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/bulk-delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/create', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/grid-page-size', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/grid-sort', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/index', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/set-child-permissions', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/set-child-roles', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/toggle-attribute', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/update', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/role/view', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-permission/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-permission/set', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-permission/set-roles', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/bulk-activate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/bulk-deactivate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/bulk-delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/create', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/grid-page-size', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/grid-sort', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/index', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/toggle-attribute', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/update', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user-visit-log/view', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/*', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/bulk-activate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/bulk-deactivate', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/bulk-delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/change-password', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/create', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/delete', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/grid-page-size', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/grid-sort', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/index', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/toggle-attribute', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/update', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('/user-management/user/view', 3, NULL, NULL, NULL, 1453797953, 1453797953, NULL),
('Admin', 1, 'Admin', NULL, NULL, 1453797953, 1453797953, NULL),
('assignRolesToUsers', 2, 'Assign roles to users', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('bindUserToIp', 2, 'Bind user to IP', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('changeOwnPassword', 2, 'Change own password', NULL, NULL, 1453797953, 1453797953, 'userCommonPermissions'),
('changeUserPassword', 2, 'Change user password', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('commonPermission', 2, 'Common permission', NULL, NULL, 1453797951, 1453797951, NULL),
('createUsers', 2, 'Create users', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('deleteUsers', 2, 'Delete users', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('editUserEmail', 2, 'Edit user email', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('editUsers', 2, 'Edit users', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('site/index', 2, 'Главная страница', NULL, NULL, 1453807580, 1453807983, 'userManagement'),
('unicredQuestionListConstructor', 2, 'Конструктор опросов', NULL, NULL, 1453881091, 1453881091, 'unicredQuestionListSystem'),
('unicredQuestionListSystemAdmin', 1, 'Админ системы опросов', NULL, NULL, 1453881154, 1453881154, NULL),
('unicredQuestionListSystemCommercialDirector', 1, 'Коммерческий директор в системе опросов', NULL, NULL, 1453881391, 1453881391, NULL),
('unicredQuestionListSystemHome', 2, 'Главная страница системы опросов', NULL, NULL, 1453881201, 1453881201, 'unicredQuestionListSystem'),
('unicredQuestionListSystemManager', 1, 'Управляющий отделением в системе опросов', NULL, NULL, 1453883495, 1453883495, NULL),
('unicredQuestionListSystemQuestionListToOfficesManagemant', 2, 'Назначение опросов отделениям', NULL, NULL, 1453881830, 1453881830, 'unicredQuestionListSystem'),
('unicredQuestionListSystemStatistic', 2, 'Просмотр статистики по опросам', NULL, NULL, 1453881692, 1453881692, 'unicredQuestionListSystem'),
('unicredQuestionListSystemUserRoleManagement', 2, 'Пользоватлеи и роли системы опросов', NULL, NULL, 1453881582, 1453881582, 'unicredQuestionListSystem'),
('unicredQuestionListSystemWriteTest', 2, 'Прохождение опросов от лица отделения', NULL, NULL, 1453883557, 1453883557, 'unicredQuestionListSystem'),
('unicreQuestionListSystemUpdateQLStatus', 2, 'Обновление статуса опроса, пройденного отделением.', NULL, NULL, 1453901207, 1453901207, 'unicredQuestionListSystem'),
('viewRegistrationIp', 2, 'View registration IP', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('viewUserEmail', 2, 'View user email', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('viewUserRoles', 2, 'View user roles', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('viewUsers', 2, 'View users', NULL, NULL, 1453797953, 1453797953, 'userManagement'),
('viewVisitLog', 2, 'View visit log', NULL, NULL, 1453797953, 1453797953, 'userManagement');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('site/index', '/site/*'),
('site/index', '/site/about'),
('site/index', '/site/captcha'),
('site/index', '/site/contact'),
('site/index', '/site/error'),
('site/index', '/site/index'),
('site/index', '/site/login'),
('site/index', '/site/logout'),
('unicredQuestionListSystemQuestionListToOfficesManagemant', '/unicred/answer-list/*'),
('unicredQuestionListSystemStatistic', '/unicred/answer-list/index'),
('unicreQuestionListSystemUpdateQLStatus', '/unicred/answer-list/update'),
('unicredQuestionListSystemStatistic', '/unicred/answer-list/view'),
('unicredQuestionListSystemHome', '/unicred/default/*'),
('unicredQuestionListConstructor', '/unicred/question-list-constructor/*'),
('unicredQuestionListSystemUserRoleManagement', '/unicred/users-offices/*'),
('unicredQuestionListSystemWriteTest', '/unicred/write-test/*'),
('changeOwnPassword', '/user-management/auth/change-own-password'),
('assignRolesToUsers', '/user-management/user-permission/set'),
('assignRolesToUsers', '/user-management/user-permission/set-roles'),
('viewVisitLog', '/user-management/user-visit-log/grid-page-size'),
('viewVisitLog', '/user-management/user-visit-log/index'),
('viewVisitLog', '/user-management/user-visit-log/view'),
('editUsers', '/user-management/user/bulk-activate'),
('editUsers', '/user-management/user/bulk-deactivate'),
('deleteUsers', '/user-management/user/bulk-delete'),
('changeUserPassword', '/user-management/user/change-password'),
('createUsers', '/user-management/user/create'),
('deleteUsers', '/user-management/user/delete'),
('viewUsers', '/user-management/user/grid-page-size'),
('viewUsers', '/user-management/user/index'),
('editUsers', '/user-management/user/update'),
('viewUsers', '/user-management/user/view'),
('Admin', 'assignRolesToUsers'),
('Admin', 'changeOwnPassword'),
('Admin', 'editUsers'),
('Admin', 'site/index'),
('unicredQuestionListSystemAdmin', 'unicredQuestionListConstructor'),
('unicredQuestionListSystemAdmin', 'unicredQuestionListSystemHome'),
('unicredQuestionListSystemCommercialDirector', 'unicredQuestionListSystemHome'),
('unicredQuestionListSystemManager', 'unicredQuestionListSystemHome'),
('unicredQuestionListSystemAdmin', 'unicredQuestionListSystemQuestionListToOfficesManagemant'),
('unicredQuestionListSystemCommercialDirector', 'unicredQuestionListSystemStatistic'),
('unicredQuestionListSystemCommercialDirector', 'unicredQuestionListSystemUserRoleManagement'),
('unicredQuestionListSystemManager', 'unicredQuestionListSystemWriteTest'),
('unicredQuestionListSystemCommercialDirector', 'unicreQuestionListSystemUpdateQLStatus'),
('editUserEmail', 'viewUserEmail'),
('assignRolesToUsers', 'viewUserRoles'),
('Admin', 'viewUsers'),
('assignRolesToUsers', 'viewUsers'),
('changeUserPassword', 'viewUsers'),
('createUsers', 'viewUsers'),
('deleteUsers', 'viewUsers'),
('editUsers', 'viewUsers');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_group`
--

CREATE TABLE IF NOT EXISTS `auth_item_group` (
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item_group`
--

INSERT INTO `auth_item_group` (`code`, `name`, `created_at`, `updated_at`) VALUES
('unicredQuestionListSystem', 'Система опросов', 1453881054, 1453881054),
('userCommonPermissions', 'User common permission', 1453797953, 1453797953),
('userManagement', 'User management', 1453797953, 1453797953);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('m000000_000000_base', 1453451490),
('m140209_132017_init', 1453451499),
('m140403_174025_create_account_table', 1453451499),
('m140504_113157_update_tables', 1453451502),
('m140504_130429_create_token_table', 1453451502),
('m140506_102106_rbac_init', 1453452157),
('m140608_173539_create_user_table', 1453797950),
('m140611_133903_init_rbac', 1453797950),
('m140808_073114_create_auth_item_group_table', 1453797951),
('m140809_072112_insert_superadmin_to_user', 1453797951),
('m140809_073114_insert_common_permisison_to_auth_item', 1453797951),
('m140830_171933_fix_ip_field', 1453451502),
('m140830_172703_change_account_table_name', 1453451502),
('m141023_141535_create_user_visit_log', 1453797951),
('m141116_115804_add_bind_to_ip_and_registration_ip_to_user', 1453797952),
('m141121_194858_split_browser_and_os_column', 1453797952),
('m141201_220516_add_email_and_email_confirmed_to_user', 1453797953),
('m141207_001649_create_basic_user_permissions', 1453797953),
('m141222_110026_update_ip_field', 1453451502),
('m160126_140412_day26_01', 1453819545),
('m160126_141644_unicred_question_list_system', 1453819619);

-- --------------------------------------------------------

--
-- Структура таблицы `office`
--

CREATE TABLE IF NOT EXISTS `office` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `office`
--

INSERT INTO `office` (`id`, `region_id`, `name`) VALUES
(1, 1, 'Офис Номер Одын'),
(2, 1, 'Офис Номер Дыва');

-- --------------------------------------------------------

--
-- Структура таблицы `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `quest_text` varchar(1000) NOT NULL,
  `answer` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=273 ;

--
-- Дамп данных таблицы `question`
--

INSERT INTO `question` (`id`, `type`, `quest_text`, `answer`) VALUES
(270, 'boolean', 'Вопрос то одинddd', ''),
(271, 'multiple', 'Еще один вопрос, готовы?', ''),
(272, 'boolean', 'ЧТо?', '');

-- --------------------------------------------------------

--
-- Структура таблицы `questions_qlists`
--

CREATE TABLE IF NOT EXISTS `questions_qlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=324 ;

--
-- Дамп данных таблицы `questions_qlists`
--

INSERT INTO `questions_qlists` (`id`, `list_id`, `question_id`) VALUES
(321, 146, 270),
(322, 147, 271),
(323, 147, 272);

-- --------------------------------------------------------

--
-- Структура таблицы `question_list`
--

CREATE TABLE IF NOT EXISTS `question_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=148 ;

--
-- Дамп данных таблицы `question_list`
--

INSERT INTO `question_list` (`id`, `title`) VALUES
(146, 'Новый опрос'),
(147, 'Про жизнь');

-- --------------------------------------------------------

--
-- Структура таблицы `test_table`
--

CREATE TABLE IF NOT EXISTS `test_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `test_table`
--

INSERT INTO `test_table` (`id`, `title`, `content`) VALUES
(1, 'test 1', 'content 1');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `superadmin` smallint(6) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `registration_ip` varchar(15) DEFAULT NULL,
  `bind_to_ip` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `email_confirmed` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `confirmation_token`, `status`, `superadmin`, `created_at`, `updated_at`, `registration_ip`, `bind_to_ip`, `email`, `email_confirmed`) VALUES
(1, 'superadmin', 'UnVFS_UhFpoIfw5_OizZRrRE81IVPk26', '$2y$13$S2qVph5TS08eO9JwULwmLOKmRMCvyA/AKrYnG5IS6X0ho2lC6.nUC', NULL, 1, 1, 1453797951, 1453797951, NULL, NULL, NULL, 0),
(2, 'comdir', 'VNwTiTjVvzLvQ3Hk-dqcEIDcFZWEgkpE', '$2y$13$NNWWo./un4dXbSZ7N7DwFurCnUohSQFkiWg6YCi2cGd/bz7fwrdeC', NULL, 1, 0, 1453799032, 1453799032, '127.0.0.1', '', 'comdir@comdir.comdir', 1),
(3, 'admin', 'dxK5ouStZkuDmq-pNWDV7uH5ZwgbKkCk', '$2y$13$ZSRPa9wncBCj5/vKCVRoAeP3kkqQgDHFm0EIZtG1mYGE7H.VgTjsW', NULL, 1, 0, 1453807394, 1453807412, '127.0.0.1', '', 'sdgds@sdgsd.ry', 1),
(4, 'manager', 'RsS18U8hZ-TAVCz2ITYnMO3IhlLSaGMJ', '$2y$13$PpYjAwgNZU68B7eLjiKX/OIxvxYPEHcM7qa0jKcqKB7nN7Pbhmxvq', NULL, 1, 0, 1453808781, 1453808781, '127.0.0.1', '', 'dsfgsdf@sadg.ry', 1),
(5, 'manager2', '6alyR61_DhiCSL5MHtoJ-vXg1XAjYnSf', '$2y$13$LQsQr3xj/9A77xu2eMH0yubMYia2J.MMNTTEkLbJOZrTfLaGGGxVa', NULL, 1, 0, 1453813556, 1453813556, '127.0.0.1', '', 'sdgds@sdgsd.rysfds', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users_offices`
--

CREATE TABLE IF NOT EXISTS `users_offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` varchar(50) NOT NULL,
  `office_id` int(11) NOT NULL,
  `profile_office_role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `users_offices`
--

INSERT INTO `users_offices` (`id`, `profile_id`, `office_id`, `profile_office_role`) VALUES
(1, 'manager', 1, 'manager'),
(3, 'manager2', 2, 'manager'),
(4, 'manager', 2, 'manager');

-- --------------------------------------------------------

--
-- Структура таблицы `user_visit_log`
--

CREATE TABLE IF NOT EXISTS `user_visit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `language` char(2) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `visit_time` int(11) NOT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

--
-- Дамп данных таблицы `user_visit_log`
--

INSERT INTO `user_visit_log` (`id`, `token`, `ip`, `language`, `user_agent`, `user_id`, `visit_time`, `browser`, `os`) VALUES
(1, '56a733b98b039', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453798329, 'Chrome', 'Windows'),
(2, '56a7380430194', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453799428, 'Chrome', 'Windows'),
(3, '56a7387001d2c', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453799536, 'Chrome', 'Windows'),
(4, '56a7428def9f7', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453802125, 'Chrome', 'Windows'),
(5, '56a742d2f0364', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453802194, 'Chrome', 'Windows'),
(6, '56a745c96e04b', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453802953, 'Chrome', 'Windows'),
(7, '56a745fe08abe', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453803006, 'Chrome', 'Windows'),
(8, '56a746861f32f', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453803142, 'Chrome', 'Windows'),
(9, '56a74dc482163', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453804996, 'Chrome', 'Windows'),
(10, '56a74e7f48841', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453805183, 'Chrome', 'Windows'),
(11, '56a74ebe09ab4', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453805246, 'Chrome', 'Windows'),
(12, '56a74eef3da13', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453805295, 'Chrome', 'Windows'),
(13, '56a74f340f16d', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453805364, 'Chrome', 'Windows'),
(14, '56a74fd6c8d3d', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453805526, 'Chrome', 'Windows'),
(15, '56a7500a73a38', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453805578, 'Chrome', 'Windows'),
(16, '56a75167485fa', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453805927, 'Chrome', 'Windows'),
(17, '56a751b85f9be', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453806008, 'Chrome', 'Windows'),
(18, '56a753700e1bc', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453806448, 'Chrome', 'Windows'),
(19, '56a753c9ee990', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453806537, 'Chrome', 'Windows'),
(20, '56a7576e0de8d', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453807470, 'Chrome', 'Windows'),
(21, '56a75777a2f86', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453807479, 'Chrome', 'Windows'),
(22, '56a758541ea19', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453807700, 'Chrome', 'Windows'),
(23, '56a758697cdd7', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453807721, 'Chrome', 'Windows'),
(24, '56a7590c514dc', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453807884, 'Chrome', 'Windows'),
(25, '56a75934565e5', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453807924, 'Chrome', 'Windows'),
(26, '56a75a315c3e8', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453808177, 'Chrome', 'Windows'),
(27, '56a75c5b28348', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453808731, 'Chrome', 'Windows'),
(28, '56a75ca516201', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453808805, 'Chrome', 'Windows'),
(29, '56a760b174d96', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453809841, 'Chrome', 'Windows'),
(30, '56a7629b5d4f2', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453810331, 'Chrome', 'Windows'),
(31, '56a762c27c643', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453810370, 'Chrome', 'Windows'),
(32, '56a76f1a57a19', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453813530, 'Chrome', 'Windows'),
(33, '56a76f545c70e', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 5, 1453813588, 'Chrome', 'Windows'),
(34, '56a76fb6180a9', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453813686, 'Chrome', 'Windows'),
(35, '56a776b58ba8e', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453815477, 'Chrome', 'Windows'),
(36, '56a776d430385', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453815508, 'Chrome', 'Windows'),
(37, '56a776eef38d8', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453815534, 'Chrome', 'Windows'),
(38, '56a777dd896ee', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453815773, 'Chrome', 'Windows'),
(39, '56a777f7a8bf8', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453815799, 'Chrome', 'Windows'),
(40, '56a7787fa6e5a', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453815935, 'Chrome', 'Windows'),
(41, '56a86a3b6f6d9', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453877819, 'Chrome', 'Windows'),
(42, '56a87124b1bf1', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453879588, 'Chrome', 'Windows'),
(43, '56a871c79252a', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453879751, 'Chrome', 'Windows'),
(44, '56a871f55f599', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453879797, 'Chrome', 'Windows'),
(45, '56a872482ee91', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0', 1, 1453879880, 'Firefox', 'Windows'),
(46, '56a872fbba111', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453880059, 'Chrome', 'Windows'),
(47, '56a873dc49e18', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453880284, 'Chrome', 'Windows'),
(48, '56a8748ab759f', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453880458, 'Chrome', 'Windows'),
(49, '56a874b28f21a', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453880498, 'Chrome', 'Windows'),
(50, '56a8760d6a7c8', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453880845, 'Chrome', 'Windows'),
(51, '56a877be22051', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0', 1, 1453881278, 'Firefox', 'Windows'),
(52, '56a877cc124a1', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453881292, 'Chrome', 'Windows'),
(53, '56a877daf20a5', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0', 1, 1453881306, 'Firefox', 'Windows'),
(54, '56a87859b78cc', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453881433, 'Chrome', 'Windows'),
(55, '56a8786d321f9', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453881453, 'Chrome', 'Windows'),
(56, '56a87f044a56e', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453883140, 'Chrome', 'Windows'),
(57, '56a8800d5b5d9', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453883405, 'Chrome', 'Windows'),
(58, '56a881286c846', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453883688, 'Chrome', 'Windows'),
(59, '56a8816257e2a', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453883746, 'Chrome', 'Windows'),
(60, '56a8818ba3954', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 5, 1453883787, 'Chrome', 'Windows'),
(61, '56a882b701e29', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453884087, 'Chrome', 'Windows'),
(62, '56a8a804c8b77', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 3, 1453893636, 'Chrome', 'Windows'),
(63, '56a8a891346e8', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 3, 1453893777, 'Chrome', 'Windows'),
(64, '56a8b50d86175', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 1, 1453896973, 'Chrome', 'Windows'),
(65, '56a8b5682a59b', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 4, 1453897064, 'Chrome', 'Windows'),
(66, '56a8b74552083', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 3, 1453897541, 'Chrome', 'Windows'),
(67, '56a8bbafb156c', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 2, 1453898671, 'Chrome', 'Windows'),
(68, '56a8bbe385f52', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 4, 1453898723, 'Chrome', 'Windows'),
(69, '56a8bbec5a9e1', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 4, 1453898732, 'Chrome', 'Windows'),
(70, '56a8bd5c6fc2f', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 3, 1453899100, 'Chrome', 'Windows'),
(71, '56a8c086d39f0', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 2, 1453899910, 'Chrome', 'Windows'),
(72, '56a8c29eb1434', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 3, 1453900446, 'Chrome', 'Windows'),
(73, '56a8c559220f2', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 1, 1453901145, 'Chrome', 'Windows'),
(74, '56a8c560b2632', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 1, 1453901152, 'Chrome', 'Windows'),
(75, '56a8c5bc96b2b', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 2, 1453901244, 'Chrome', 'Windows'),
(76, '56a8c6ae1f115', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 1, 1453901486, 'Chrome', 'Windows'),
(77, '56a8c6e04267d', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 2, 1453901536, 'Chrome', 'Windows'),
(78, '56a8c6e8777f2', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 2, 1453901544, 'Chrome', 'Windows'),
(79, '56a8d69fd0e85', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453905567, 'Chrome', 'Windows'),
(80, '56a8d6aabf396', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453905578, 'Chrome', 'Windows'),
(81, '56a8d6dc367e1', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 2, 1453905628, 'Chrome', 'Windows'),
(82, '56a9b0aec9995', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 3, 1453961390, 'Chrome', 'Windows'),
(83, '56a9b1bf9cfc9', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 4, 1453961663, 'Chrome', 'Windows'),
(84, '56a9bfbf245fc', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 3, 1453965247, 'Chrome', 'Windows'),
(85, '56a9c113660d7', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36', 4, 1453965587, 'Chrome', 'Windows'),
(86, '56a9c1b0d30c2', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453965744, 'Chrome', 'Windows'),
(87, '56a9c88d57526', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1, 1453967501, 'Chrome', 'Windows'),
(88, '56a9ca17b1715', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453967895, 'Chrome', 'Windows'),
(89, '56a9cc47ad20e', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 3, 1453968455, 'Chrome', 'Windows'),
(90, '56a9cd848e595', '127.0.0.1', 'ru', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 4, 1453968772, 'Chrome', 'Windows');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `fk_auth_item_group_code` FOREIGN KEY (`group_code`) REFERENCES `auth_item_group` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_visit_log`
--
ALTER TABLE `user_visit_log`
  ADD CONSTRAINT `user_visit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
