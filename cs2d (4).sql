-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 11 2023 г., 14:12
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
  `rotation` double NOT NULL,
  `uniqId` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bullets`
--

INSERT INTO `bullets` (`id`, `gamerId`, `matchId`, `x`, `y`, `rotation`, `uniqId`) VALUES
(35607, 510, 399, 862.66666666666, 780, -1.5076993668961, '5490'),
(35608, 510, 399, 862.66666666666, 780, -2.9827985988991, '1433'),
(35611, 510, 399, 863.33333333334, 686.66666666667, -2.620839648183, '8555'),
(35630, 510, 399, 865, 496.80555555556, -0.51165989997667, '1086'),
(35663, 510, 399, 727.76947014337, 623.27013464169, -2.6414886946119, '8034');

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
  `lobbyId` int DEFAULT NULL,
  `matchId` int DEFAULT NULL,
  `statusInMatch` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `gamers`
--

INSERT INTO `gamers` (`id`, `userId`, `gamerName`, `characterId`, `score`, `X`, `Y`, `weapon`, `weaponX`, `weaponY`, `weaponRotation`, `lobbyId`, `matchId`, `statusInMatch`) VALUES
(510, 11, 'Bebey', 0, 666, 777.33333333334, 650, 'Pistol', 758.02761356903, 644.45063109081, -2.6414886946119, NULL, 399, 'alive'),
(511, 12, 'Sanya', 0, 666, 336.33333333333, 783.5, 'Pistol', 343.8426269077, 767.82125463153, -1.2224631898964, NULL, 398, 'alive'),
(514, 17, 'nig', 0, 666, 338.66666666667, 780, 'Pistol', 321.57365022578, 771.1497729639, -2.4606113264179, NULL, 392, 'alive');

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
  `timestemp` int NOT NULL,
  `hash` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `matches`
--

INSERT INTO `matches` (`id`, `ownerId`, `amountPlayers`, `time`, `endConditional`, `map`, `status`, `timestemp`, `hash`) VALUES
(398, 12, 3, 0, 0, 'city', 'open', 0, ' 65480cd1a2ecad41d954aafb2422aece '),
(399, 11, 3, 0, 0, 'city', 'open', 0, ' dc9f0ef61b9342e6e9f33662c94852fe '),
(400, 12, 3, 0, 0, 'city', 'open', 0, '0'),
(401, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(402, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(403, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(404, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(405, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(406, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(407, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(408, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(409, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(410, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(411, 11, 2, 0, 0, 'city', 'open', 0, '0'),
(412, 11, 2, 0, 0, 'city', 'open', 0, '0');

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
(216, 'dfg', 'Vasya'),
(217, 'Ghbdt', 'Petr');

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
(1, '3fd850153164068e81c6e429ab7d0f2e');

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
(11, 'PartyF1', '1', '561cd7ca7741a1a8f24e385f08b11850', 'Bebey'),
(12, 'bratik', '1', 'c2935de983b9d05199c48d7d00970e8d', 'Sanya'),
(17, 'nigger', '123', '344a45034b550ef8543519bea36a9d68', 'nig');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35664;

--
-- AUTO_INCREMENT для таблицы `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `gamers`
--
ALTER TABLE `gamers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT для таблицы `lobby`
--
ALTER TABLE `lobby`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=420;

--
-- AUTO_INCREMENT для таблицы `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=413;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `weapon`
--
ALTER TABLE `weapon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
