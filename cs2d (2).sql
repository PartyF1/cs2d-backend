-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 09 2022 г., 21:29
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cs2d`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bullets`
--

CREATE TABLE `bullets` (
  `id` int NOT NULL,
  `gamerId` int NOT NULL,
  `matchId` int NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `rotation` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bullets`
--

INSERT INTO `bullets` (`id`, `gamerId`, `matchId`, `x`, `y`, `rotation`) VALUES
(8, 148, 1, 1.5, 1.5, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `characters`
--

CREATE TABLE `characters` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `ability` varchar(256) NOT NULL,
  `speed` int NOT NULL,
  `sizeX` int NOT NULL,
  `sizeY` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `gamers`
--

CREATE TABLE `gamers` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `gamerName` varchar(256) NOT NULL,
  `characterId` int NOT NULL,
  `score` int NOT NULL,
  `X` double NOT NULL,
  `Y` double NOT NULL,
  `weapon` varchar(256) NOT NULL,
  `weaponX` double NOT NULL,
  `weaponY` double NOT NULL,
  `weaponRotation` double NOT NULL,
  `weaponFlipY` double NOT NULL,
  `lobbyId` int DEFAULT NULL,
  `matchId` int DEFAULT NULL,
  `statusInMatch` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `gamers`
--

INSERT INTO `gamers` (`id`, `userId`, `gamerName`, `characterId`, `score`, `X`, `Y`, `weapon`, `weaponX`, `weaponY`, `weaponRotation`, `weaponFlipY`, `lobbyId`, `matchId`, `statusInMatch`) VALUES
(148, 1, 'Vasya', 0, 666, 6, 15, '', 0, 0, 0, 0, NULL, 1, 0),
(150, 2, 'Petr', 0, 666, 0, 0, '', 0, 0, 0, 0, NULL, 1, 0),
(151, 3, 'Maria', 0, 666, 0, 0, '', 0, 0, 0, 0, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `lobby`
--

CREATE TABLE `lobby` (
  `id` int NOT NULL,
  `ownerId` int NOT NULL,
  `ownerName` varchar(256) NOT NULL,
  `amountPlayers` int NOT NULL,
  `maxAmountPlayers` int NOT NULL,
  `mode` varchar(256) NOT NULL,
  `map` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `lobby`
--

INSERT INTO `lobby` (`id`, `ownerId`, `ownerName`, `amountPlayers`, `maxAmountPlayers`, `mode`, `map`) VALUES
(19, 1, 'Vasya', 1, 2, 'time', 'city '),
(20, 1, 'Vasya', 1, 24, 'time', 'city '),
(21, 1, 'Vasya', 1, 245, 'time', 'city ');

-- --------------------------------------------------------

--
-- Структура таблицы `maps`
--

CREATE TABLE `maps` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `map` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `matches`
--

CREATE TABLE `matches` (
  `id` int NOT NULL,
  `ownerId` int NOT NULL,
  `amountPlayers` int NOT NULL,
  `time` int NOT NULL,
  `endConditional` int NOT NULL,
  `map` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL,
  `timestemp` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `matches`
--

INSERT INTO `matches` (`id`, `ownerId`, `amountPlayers`, `time`, `endConditional`, `map`, `status`, `timestemp`) VALUES
(28, 1, 6, 0, 0, 'city', 'open', 0),
(29, 1, 6, 0, 0, 'city', 'open', 0),
(30, 1, 6, 0, 0, 'city', 'open', 0),
(31, 1, 6, 0, 0, 'city', 'open', 0),
(32, 1, 6, 0, 0, 'city', 'open', 0),
(33, 1, 6, 0, 0, 'city', 'open', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `message` varchar(256) NOT NULL,
  `userName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `message`, `userName`) VALUES
(198, 'всем привет, кто в чате?', 'Vasya'),
(199, 'Да, привет, я здесь', 'Petr'),
(200, 'Го поиграем', 'Vasya'),
(201, 'Да, можно, мама сейчас уйдёт', 'Petr'),
(202, 'Всё, давай, я за сову буду играть, она моя любимоя', 'Vasya'),
(203, 'Хорошо, а я за лису тогда, у неё есть крюк-кошка', 'Petr'),
(204, 'Хорошо, до встречи', 'Vasya'),
(205, 'Давай, Вася, и тебе', 'Petr'),
(206, 'babababa', 'Vasya'),
(207, '123456', 'Petr'),
(208, '654321', 'Vasya'),
(209, '10001', 'Petr'),
(210, 'lhkjg', 'Petr'),
(211, 'asdhj', 'Vasya'),
(212, '123', 'Vasya'),
(213, 'фыввфы', 'Vasya'),
(214, 'sdf', 'Vasya'),
(215, 'fgjh', 'Vasya'),
(216, 'dfg', 'Vasya');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int NOT NULL,
  `chat_hash` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `chat_hash`) VALUES
(1, '2e4f4a50b5c9c9cf531f31cd327d99ed');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `token` varchar(256) DEFAULT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `token`, `name`) VALUES
(1, 'vas', '123', '1', 'Vasya'),
(2, 'pet', '2', 'b67e30a262865ce6d6fdfeb39f5607b9', 'Petr'),
(3, 'mar', '3', '5bc37ce9a3951fe04347d8791660ae91', 'Maria'),
(10, 'kris123', '0000', NULL, 'kris');

-- --------------------------------------------------------

--
-- Структура таблицы `weapon`
--

CREATE TABLE `weapon` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `fireRate` int NOT NULL,
  `speed` int NOT NULL,
  `fireRange` int NOT NULL,
  `ammo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bullets`
--
ALTER TABLE `bullets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gamers`
--
ALTER TABLE `gamers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lobby`
--
ALTER TABLE `lobby`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `weapon`
--
ALTER TABLE `weapon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bullets`
--
ALTER TABLE `bullets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `gamers`
--
ALTER TABLE `gamers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT для таблицы `lobby`
--
ALTER TABLE `lobby`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `weapon`
--
ALTER TABLE `weapon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
