-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.23 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных host1764621
CREATE DATABASE IF NOT EXISTS `u804764g3n_tasktracker` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `u804764g3n_tasktracker`;

-- Дамп структуры для таблица host1764621.status
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` tinyint(4) NOT NULL,
  `status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u804764g3n_tasktracker.status: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`status_id`, `status_name`) VALUES
	(1, 'выполнена'),
	(2, 'не выполнена'),
	(3, 'тестовая');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Дамп структуры для таблица u804764g3n_tasktracker.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(250) DEFAULT '0',
  `description` text,
  `id_user` int(11) DEFAULT NULL,
  `id_status` tinyint(4) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `dead_line` int(11) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u804764g3n_tasktracker.tasks: ~16 rows (приблизительно)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`task_id`, `task_name`, `description`, `id_user`, `id_status`, `created_at`, `dead_line`) VALUES
	(106, '1', '27\n\n', 14, 1, 1591448619, 1593249120),
	(107, '2+', '26\n\n', 16, 2, 1591449398, 1656407520),
	(108, '3 update', '28 ready+\n', 11, 1, 1591449418, 1593249120),
	(109, '4', '30', 15, 1, 1591535507, 1593508320),
	(110, '5', '1', 5, 1, 1591547539, 1593594720),
	(111, '6', '2', 14, 1, 1591547564, 1593681120),
	(112, '7', '3', 3, 2, 1591547588, 1593767520),
	(113, '8', '4', 3, 1, 1591547603, 1593853920),
	(116, '9', 'pagination', 3, 2, 1592992066, 1593076320),
	(117, '10', 'pagination 2', 14, 2, 1593014348, 1593162720),
	(118, '3+', '28', NULL, 2, 1594466915, 1593076320),
	(126, '3 task_id', '28', 11, 2, 1594755552, 1593076320),
	(127, 'Create', 'Create', 12, 2, 1595081280, 1595236320),
	(128, 'User', 'User', 14, 2, 1595081363, 1595581920),
	(132, 'qw', 'qw', 12, 2, 1595082517, 1595149920),
	(133, 'user', 'user', 12, 2, 1595082691, 1596186720);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Дамп структуры для таблица u804764g3n_tasktracker.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u804764g3n_tasktracker.users: ~19 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `login`, `user_name`, `password`, `email`) VALUES
	(3, 'Serge', 'Serge', '$2a$08$YTM4YTZlYWI1OTBhYjQxYOp6hN.zMl6773kgUGCk2hqwLAzWfZTwu', 's@ya.ru'),
	(5, 'admin', 'admin', '$2a$08$N2IyYWI1ZmIwODJkZWQ4Yepl4OB5a2UdWPs0AL1YTcK9wKlcxblbS', 'admin@gmail.com'),
	(11, 'user', 'user', '$2a$08$MzU1ZjI2MGJiNWMyNTA3ZevVK.rFYEEbm.PfchgiN5lzy36tyIAf6', 'user@gmail.com'),
	(12, 'registered', 'registered', '$2a$08$ZDYxOTM2MTI4NTBjMzQwZeUeyKk1mm3pbgkvbM6DPvrdYhs/eEuoi', 'reg@ya.ru'),
	(13, 'reg2', 'reg2', '$2a$08$NDZlNDE4Mzc3OGRhMzA1YeS84SuS/qNCOpMU1Opxooev/vlw.hEcC', 'reg2@ya.ru'),
	(14, 'reg3', 'reg3', '$2a$08$MjVkNWZjODc2YjUyZjI0O.Ete2ACcMZnwicD4.O/Sp4LmKhfF.KhS', 'reg3@ya.ru'),
	(15, 'reg4', 'reg4', '$2a$08$Nzk4MzY4ZWZmMzgwYmVlZeEFsTV.K/7v4DJwTAZ0FzV9/Nauq0gG6', 'reg4@ya.ru'),
	(16, 'reg5', 'reg5', '$2a$08$MDc4NjRlOTNkMTA2OTlkYOBihvNPmIEwAm57F5d63lxEGR8426iD6', 'reg5@ya.ru'),
	(17, 'reg6', 'reg6', '$2a$08$NjBhMGIwN2QzYzY1MjNlZeZhDOioHQHD41/7MgT1.zy0Xekvvp.1a', 'reg6@ya.ru'),
	(18, 'dff', 'testJs', '$2a$08$YzY4ZTEyMGNhZWY2Njg0M.eDbgYee..evik.v8170G2kqs5lblsie', 'testJs@gmail.com'),
	(19, 'ыы', 'ывыыв', '$2a$08$YjEyMWE2OTZiNGY3YjRkN.5J/lgfEVEHPcOMLkxx0H/WvlrLhxCWe', 'SAA@ASA.COM'),
	(20, 'dsdds', 'ss', '$2a$08$MjFiZGQwYWQ3YjdkMzczYun/pCBH00GOFyk3ugqPhyX8eyH42VVji', 'sergeymitkin@gmail.com'),
	(21, 'fdssdssd', 'ddsd', '$2a$08$M2JlZmU2YmM2YWY0NzUyMeIUfYU8H7qhSvgClbbckSl.YYWSF7wIK', 'sdsd@g.com'),
	(22, 'dsfdf', 'sddasd', '$2a$08$NGYyYzJjMTc4NmFkNjhiO.ub8/XG3S0quLT9mlknhUdQBaJB3shbq', 'sergeymitkin@gmail.com'),
	(23, 'sdff', 'ew', '$2a$08$YzEzMTUxOGQ2MGUzN2UzYufDpd97pzJKBysclXQxpCQAiK31/wuVm', 'sergeymitkin@gmail.com'),
	(24, 'dddddd', 'qq2222', '$2a$08$NzhhZDRhM2JmYWVjMTJmMeqSAl8q3amgZHNrrAuRaO/IkOsCZcTp2', 'sergeymitkin@gmail.com'),
	(25, 'fff', 'fff', '$2a$08$ZDJiNWVmMDk2YmJhM2U1Me28kZCfY2RGPBIxzoo1nKK/Qxz9oUwVu', 'fff@gmail.com'),
	(26, 'Gimly', 'Gimly', '$2a$08$MWUwNmNiMWU5NGQ5NDFkYut0iiIxMLHkWKDbZCUGc4CNuf2ACHJYS', 'Gimly@gmail.com'),
	(27, 'reg_again', 'reg_again', '$2a$08$M2NkNWQ2NDAxNDkzNDRmO..ax29cXejbbHaBywGOkqdABjC0fpnhC', 'reg_again@gmail.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
