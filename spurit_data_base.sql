-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 14 2018 г., 17:56
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `spurit_data_base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) NOT NULL,
  `Description` varchar(256) NOT NULL,
  `Status` int(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`ID`, `Name`, `Description`, `Status`) VALUES
(1, 'Task1', 'Desk 1', 1),
(2, 'Task2', 'Desk 2', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `task_comments`
--

CREATE TABLE IF NOT EXISTS `task_comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Task_ID` int(11) NOT NULL,
  `Comments` varchar(256) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Task_ID` (`Task_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `task_comments`
--

INSERT INTO `task_comments` (`ID`, `Task_ID`, `Comments`) VALUES
(1, 1, 'Comm 11'),
(2, 1, 'Comm12'),
(3, 2, 'Comm 21'),
(4, 2, 'Comm 22'),
(5, 2, 'Comm 23');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `task_comments`
--
ALTER TABLE `task_comments`
  ADD CONSTRAINT `task_comments_ibfk_1` FOREIGN KEY (`Task_ID`) REFERENCES `task` (`ID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
