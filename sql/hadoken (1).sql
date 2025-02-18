-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 07, 2022 alle 11:54
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hadoken`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `account`
--

CREATE TABLE `account` (
  `Accountid` int(11) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `stat` varchar(2000) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `account`
--

INSERT INTO `account` (`Accountid`, `user`, `hash`, `stat`, `email`, `pic`) VALUES
(1, 'Pykner', '$2y$10$fHcbP6AGEMTWRqaupaxg8.NRSOZ8OUlFQ5xbG8Fu7dnWmDAuPBlwS', 'Hello! i am an hadoken forums user.', 'emasonic2@gmail.com', 'img/profile/profilepic1.jpg'),
(2, 'gamering69420', '$2y$10$UPBR8brRLIM.ugixYSQ4K.TmuY52FPZJNV/UwsebIfS5kFbfIjkXW', 'Hello! i am an hadoken forums user.', 'gamering69420@gmail.com', 'img/profile/profilepic1.jpg'),
(3, 'Ky_main', '$2y$10$.hfO1RHqnarFNDi7rG2LheiMD3n2H0B9JyvRZZHhJxI2/yamPNngm', 'Hello! i am an hadoken forums user.', 'runupgrab@gmail.com', 'img/profile/profilepic1.jpg'),
(4, 'Baiken_main', '$2y$10$.QWG.NZOoFrgsd7yEPMwZege93x4A6xgRMrgEj6w.s6VJUx2YVuWy', 'I like f.s into 2h', 'booba@booba.com', 'img/profile/profilepic2.jpg'),
(5, 'jin_main', '$2y$10$EHmtV1Ihps2SObkZ5Y4X8u6won1V3b/4kKJ4dDXR7h8laBQq7.3oK', 'Hello! i am an hadoken forums user.', 'electric@mishima.com', 'img/profile/profilepic1.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `category`
--

CREATE TABLE `category` (
  `Categoryid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(8000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `category`
--

INSERT INTO `category` (`Categoryid`, `title`, `description`) VALUES
(1, 'Website feedback', 'Have you noticed something wrong with the site? Do you have any ideas on how to improve Hadokenforums? Drop a post in here and let us know!'),
(2, 'Guilty Gear general', 'The forum for general topics about Guilty Gear. Discussions on techniques, strategies, glitches, and match info, should be posted in their specific forums!'),
(3, 'Strive matchup discussion', 'A place to discuss Guilty Gear Strive matchups'),
(4, 'Tekken general', 'The forum for general topics about tekken. Discussions on techniques, strategies, glitches, and match info, should be posted in their specific forums!'),
(5, 'Tekken matchup discussion', 'A place to discuss Tekken matchups'),
(6, 'Street Fighter V general', 'The forum for general topics about Street Fighter V. Discussions on techniques, strategies, glitches, and match info, should be posted in their specific forums!'),
(7, 'Street Fighter matchup discussion', 'A place to discuss Street Fighter matchups');

-- --------------------------------------------------------

--
-- Struttura della tabella `game`
--

CREATE TABLE `game` (
  `Gameid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `game`
--

INSERT INTO `game` (`Gameid`, `title`) VALUES
(1, 'Guilty Gear Strive'),
(2, 'Street Fighter V'),
(3, 'Tekken 7');

-- --------------------------------------------------------

--
-- Struttura della tabella `matchmaking`
--

CREATE TABLE `matchmaking` (
  `Matchmakingid` int(11) NOT NULL,
  `skill_level` varchar(50) DEFAULT NULL,
  `play_hour` varchar(50) DEFAULT NULL,
  `communication` varchar(200) DEFAULT NULL,
  `txt` varchar(255) DEFAULT NULL,
  `FkAccountid` int(11) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `FkGameid` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `sys` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `matchmaking`
--

INSERT INTO `matchmaking` (`Matchmakingid`, `skill_level`, `play_hour`, `communication`, `txt`, `FkAccountid`, `region`, `FkGameid`, `active`, `sys`) VALUES
(1, 'Intermediate', '150', 'Baikenb', 'Looking for someone to practice with', 4, 'Europe', 1, 0, 'Steam');

-- --------------------------------------------------------

--
-- Struttura della tabella `posts`
--

CREATE TABLE `posts` (
  `Postid` int(11) NOT NULL,
  `txt` varchar(8000) DEFAULT NULL,
  `date_post` datetime DEFAULT NULL,
  `FkTopicid` int(11) DEFAULT NULL,
  `FkAccountid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `posts`
--

INSERT INTO `posts` (`Postid`, `txt`, `date_post`, `FkTopicid`, `FkAccountid`) VALUES
(2, 'test post', '2022-05-25 06:22:07', 4, 2),
(3, 'test post', '2022-05-28 09:39:35', 4, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `resources`
--

CREATE TABLE `resources` (
  `Resourceid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `txt` varchar(8000) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  `FkAccountid` int(11) DEFAULT NULL,
  `FkGameid` int(11) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `resources`
--

INSERT INTO `resources` (`Resourceid`, `title`, `txt`, `valid`, `FkAccountid`, `FkGameid`, `link`) VALUES
(1, 'Various layers of Baiken pressure and how to beat it', 'Here is an in-depth video by parry appreciator on the various layers of basic optimal Baiken pressure and a proper breakdown of what each option entails.', 1, 4, 1, 'https://www.youtube.com/watch?v=7h4zMrmukkM'),
(5, 'Test resource', 'test', 0, 4, 1, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');

-- --------------------------------------------------------

--
-- Struttura della tabella `topics`
--

CREATE TABLE `topics` (
  `Topicid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `txt` varchar(8000) DEFAULT NULL,
  `date_post` datetime DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `FkCategory` int(11) DEFAULT NULL,
  `FkAccount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `topics`
--

INSERT INTO `topics` (`Topicid`, `title`, `txt`, `date_post`, `likes`, `FkCategory`, `FkAccount`) VALUES
(1, 'What do you think will be unvailed in the may 25th season 2 announcement?', 'What do you guys think arcsys will show off on the 25th? i\'m expecting a release date for cross-play and at least one character reveal.\r\nI hope it\'s sin.', '2022-05-22 21:26:28', 32, 2, 3),
(4, 'TEST TOPIC', 'test', '2022-05-24 06:37:40', NULL, 2, 2),
(5, 'What is your favourite strive song?', 'What is your favorite new track from strive?', '2022-05-25 08:43:45', NULL, 2, 4),
(7, 'Fix the forum ui', 'Please fix the forum ui.', '2022-05-25 10:43:01', NULL, 1, 4),
(8, 'Happy chaos zoning', 'I do not understand how to beat happy chaos zoning i just keep getting focus shot to death in the corner', '2022-05-26 11:25:06', NULL, 3, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `tournament`
--

CREATE TABLE `tournament` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `txt` varchar(8000) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `data_inizio` date DEFAULT NULL,
  `data_fine` date DEFAULT NULL,
  `FkAccountid` int(11) DEFAULT NULL,
  `major` tinyint(1) DEFAULT NULL,
  `online` tinyint(1) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `address` varchar(125) DEFAULT NULL,
  `FkGameid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tournament`
--

INSERT INTO `tournament` (`id`, `title`, `link`, `txt`, `likes`, `data_inizio`, `data_fine`, `FkAccountid`, `major`, `online`, `region`, `address`, `FkGameid`) VALUES
(1, 'HoHs', 'https://challonge.com/it/Hoesoncino', 'Gaming', 0, '2022-05-14', '2022-05-14', 1, 0, 0, 'Europe', 'Italy, Soncino, Via XXV aprile, 4', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `webupdate`
--

CREATE TABLE `webupdate` (
  `Webupdateid` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `txt` varchar(8000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `webupdate`
--

INSERT INTO `webupdate` (`Webupdateid`, `title`, `txt`) VALUES
(1, '28/05/2022 update', '-Added resource tab <br>\r\n-Added forum tab <br>\r\n-Added resource posting <br>\r\n-Added forum posting <br>\r\n-Added ability to view other users profiles <br>\r\n-Added latest topics section <br>');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`Accountid`);

--
-- Indici per le tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Categoryid`);

--
-- Indici per le tabelle `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`Gameid`);

--
-- Indici per le tabelle `matchmaking`
--
ALTER TABLE `matchmaking`
  ADD PRIMARY KEY (`Matchmakingid`),
  ADD KEY `FkAccountid` (`FkAccountid`),
  ADD KEY `F` (`FkGameid`);

--
-- Indici per le tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Postid`),
  ADD KEY `FkTopicid` (`FkTopicid`),
  ADD KEY `FkAccountid` (`FkAccountid`);

--
-- Indici per le tabelle `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`Resourceid`),
  ADD KEY `FkAccountid` (`FkAccountid`),
  ADD KEY `FkGameid` (`FkGameid`);

--
-- Indici per le tabelle `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`Topicid`),
  ADD KEY `FkCategory` (`FkCategory`),
  ADD KEY `FkAccount` (`FkAccount`);

--
-- Indici per le tabelle `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FkAccountid` (`FkAccountid`),
  ADD KEY `FkGameid` (`FkGameid`);

--
-- Indici per le tabelle `webupdate`
--
ALTER TABLE `webupdate`
  ADD PRIMARY KEY (`Webupdateid`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `account`
--
ALTER TABLE `account`
  MODIFY `Accountid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `game`
--
ALTER TABLE `game`
  MODIFY `Gameid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `matchmaking`
--
ALTER TABLE `matchmaking`
  MODIFY `Matchmakingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `posts`
--
ALTER TABLE `posts`
  MODIFY `Postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `resources`
--
ALTER TABLE `resources`
  MODIFY `Resourceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `topics`
--
ALTER TABLE `topics`
  MODIFY `Topicid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `tournament`
--
ALTER TABLE `tournament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `webupdate`
--
ALTER TABLE `webupdate`
  MODIFY `Webupdateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `matchmaking`
--
ALTER TABLE `matchmaking`
  ADD CONSTRAINT `F` FOREIGN KEY (`FkGameid`) REFERENCES `game` (`Gameid`),
  ADD CONSTRAINT `matchmaking_ibfk_1` FOREIGN KEY (`FkAccountid`) REFERENCES `account` (`Accountid`);

--
-- Limiti per la tabella `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`FkTopicid`) REFERENCES `topics` (`Topicid`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`FkAccountid`) REFERENCES `account` (`Accountid`);

--
-- Limiti per la tabella `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`FkAccountid`) REFERENCES `account` (`Accountid`),
  ADD CONSTRAINT `resources_ibfk_2` FOREIGN KEY (`FkGameid`) REFERENCES `game` (`Gameid`);

--
-- Limiti per la tabella `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`FkCategory`) REFERENCES `category` (`Categoryid`),
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`FkAccount`) REFERENCES `account` (`Accountid`);

--
-- Limiti per la tabella `tournament`
--
ALTER TABLE `tournament`
  ADD CONSTRAINT `FkGameid` FOREIGN KEY (`FkGameid`) REFERENCES `game` (`Gameid`),
  ADD CONSTRAINT `tournament_ibfk_1` FOREIGN KEY (`FkAccountid`) REFERENCES `account` (`Accountid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
