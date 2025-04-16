-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 16, 2025 lúc 12:04 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `comic_db1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `mangadex_tag_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `mangadex_tag_id`, `name`) VALUES
(1, '0234a31e-a729-4e28-9d6a-3f87c4966b9e', 'Oneshot'),
(2, '07251805-a27e-4d59-b488-f0bfbec15168', 'Thriller'),
(3, '0a39b5a1-b235-4886-a747-1d05d216532d', 'Award Winning'),
(4, '0bc90acb-ccc1-44ca-a34a-b9f3a73259d0', 'Reincarnation'),
(5, '256c8bd9-4904-4360-bf4f-508a76d67183', 'Sci-Fi'),
(6, '292e862b-2d17-4062-90a2-0356caa4ae27', 'Time Travel'),
(7, '2bd2e8d0-f146-434a-9b51-fc9ff2c5fe6a', 'Genderswap'),
(8, '2d1f5d56-a1e5-4d0d-a961-2193588b08ec', 'Loli'),
(9, '31932a7e-5b8e-49a6-9f12-2afa39dc544c', 'Traditional Games'),
(10, '320831a8-4026-470b-94f6-8353740e6f04', 'Official Colored'),
(11, '33771934-028e-4cb3-8744-691e866a923e', 'Historical'),
(12, '36fd93ea-e8b8-445e-b836-358f02b3d33d', 'Monsters'),
(13, '391b0423-d847-456f-aff0-8b0cfc03066b', 'Action'),
(14, '39730448-9a5f-48a2-85b0-a70db87b1233', 'Demons'),
(15, '3b60b75c-a2d7-4860-ab56-05f391bb889c', 'Psychological'),
(16, '3bb26d85-09d5-4d2e-880c-c34b974339e9', 'Ghosts'),
(17, '3de8c75d-8ee3-48ff-98ee-e20a65c86451', 'Animals'),
(18, '3e2b8dae-350e-4ab8-a8ce-016e844b9f0d', 'Long Strip'),
(19, '423e2eae-a7a2-4a8b-ac03-a8351462d71d', 'Romance'),
(20, '489dd859-9b61-4c37-af75-5b18e88daafc', 'Ninja'),
(21, '4d32cc48-9f00-4cca-9b5a-a839f0764984', 'Comedy'),
(22, '50880a9d-5440-4732-9afb-8f457127e836', 'Mecha'),
(23, '51d83883-4103-437c-b4b1-731cb73d786c', 'Anthology'),
(25, '5bd0e105-4481-44ca-b6e7-7544da56b1a3', 'Incest'),
(27, '5fff9cde-849c-4d78-aab0-0d52b2ee1d25', 'Survival'),
(28, '631ef465-9aba-4afb-b0fc-ea10efe274a8', 'Zombies'),
(29, '65761a2a-415e-47f3-bef2-a9dababba7a6', 'Reverse Harem'),
(30, '69964a64-2f90-4d33-beeb-f3ed2875eb4c', 'Sports'),
(31, '7064a261-a137-4d3a-8848-2d385de3a99c', 'Superhero'),
(32, '799c202e-7daa-44eb-9cf7-8a3c0441531e', 'Martial Arts'),
(33, '7b2ce280-79ef-4c09-9b58-12b7c23a9b78', 'Fan Colored'),
(34, '81183756-1453-4c81-aa9e-f6e1b63be016', 'Samurai'),
(35, '81c836c9-914a-4eca-981a-560dad663e73', 'Magical Girls'),
(36, '85daba54-a71c-4554-8a28-9901a8b0afad', 'Mafia'),
(37, '87cc87cd-a395-47af-b27a-93258283bbc6', 'Adventure'),
(38, '891cf039-b895-47f0-9229-bef4c96eccd4', 'Self-Published'),
(39, '8c86611e-fab7-4986-9dec-d1a2f44acdd5', 'Virtual Reality'),
(40, '92d6d951-ca5e-429c-ac78-451071cbf064', 'Office Workers'),
(41, '9438db5a-7e2a-4ac0-b39e-e0d95a34b8a8', 'Video Games'),
(42, '9467335a-1b83-4497-9231-765337a00b96', 'Post-Apocalyptic'),
(43, '97893a4c-12af-4dac-b6be-0dffb353568e', 'Sexual Violence'),
(44, '9ab53f92-3eed-4e9b-903a-917c86035ee3', 'Crossdressing'),
(45, 'a1f53773-c69a-4ce5-8cab-fffcd90b1565', 'Magic'),
(46, 'a3c67850-4684-404e-9b7f-c69850ee5da6', 'Girls\' Love'),
(47, 'aafb99c1-7f60-43fa-b75f-fc9502ce29c7', 'Harem'),
(48, 'ac72833b-c4e9-4878-b9db-6c8a4a99444a', 'Military'),
(49, 'acc803a4-c95a-4c22-86fc-eb6b582d82a2', 'Wuxia'),
(50, 'ace04997-f6bd-436e-b261-779182193d3d', 'Isekai'),
(51, 'b11fda93-8f1d-4bef-b2ed-8803d3733170', '4-Koma'),
(52, 'b13b2a48-c720-44a9-9c77-39c9979373fb', 'Doujinshi'),
(53, 'b1e97889-25b4-4258-b28b-cd7f4d28ea9b', 'Philosophical'),
(54, 'b29d6a3d-1569-4e7a-8caf-7557bc92cd5d', 'Gore'),
(55, 'b9af3a63-f058-46de-a9a0-e0c13906197a', 'Drama'),
(56, 'c8cbe35b-1b2b-4a3f-9c37-db84c4514856', 'Medical'),
(57, 'caaa44eb-cd40-4177-b930-79d3ef2afe87', 'School Life'),
(58, 'cdad7e68-1419-41dd-bdce-27753074a640', 'Horror'),
(59, 'cdc58593-87dd-415e-bbc0-2ec27bf404cc', 'Fantasy'),
(60, 'd14322ac-4d6f-4e9b-afd9-629d5f4d8a41', 'Villainess'),
(61, 'd7d1730f-6eb0-4ba6-9437-602cac38664c', 'Vampires'),
(62, 'da2d50ca-3018-4cc0-ac7a-6b7d472a29ea', 'Delinquents'),
(63, 'dd1f77c5-dea9-4e2b-97ae-224af09caf99', 'Monster Girls'),
(64, 'ddefd648-5140-4e5f-ba18-4eca4071d19b', 'Shota'),
(65, 'df33b754-73a3-4c54-80e6-1a74a8058539', 'Police'),
(66, 'e197df38-d0e7-43b5-9b09-2842d0c326dd', 'Web Comic'),
(67, 'e5301a23-ebd9-49dd-a0cb-2add944c7fe9', 'Slice of Life'),
(68, 'e64f6742-c834-471d-8d72-dd51fc02b835', 'Aliens'),
(69, 'ea2bc92d-1c26-4930-9b7c-d5c0dc1b6869', 'Cooking'),
(70, 'eabc5b4c-6aff-42f3-b657-3e90cbd00b75', 'Supernatural'),
(71, 'ee968100-4191-4968-93d3-f82d72be7e46', 'Mystery'),
(72, 'f4122d1c-3b44-44d0-9936-ff7502c39ad3', 'Adaptation'),
(73, 'f42fbf9e-188a-447b-9fdc-f19dc1e4d685', 'Music'),
(74, 'f5ba408b-0e7a-484d-8d49-4e9125ac96de', 'Full Color'),
(75, 'f8f62932-27da-4fe4-8ee1-6779a8c5edba', 'Tragedy'),
(76, 'fad12b5e-68ba-460e-b933-9ae8318f5b65', 'Gyaru'),
(100, '5920b825-4181-4a17-beeb-9918b0ff7a30', 'Boys\' Love'),
(102, '5ca48985-9a9d-4bd8-be29-80dc0303db72', 'Crime');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `mangadex_id` varchar(255) NOT NULL,
  `manga_id` int(11) NOT NULL,
  `chapter_number` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT 'Untitled',
  `volume` varchar(50) DEFAULT NULL,
  `language` varchar(10) DEFAULT 'en',
  `publish_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chapters`
--

INSERT INTO `chapters` (`id`, `mangadex_id`, `manga_id`, `chapter_number`, `title`, `volume`, `language`, `publish_at`, `created_at`, `updated_at`) VALUES
(1, 'e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3', 1, '200', 'Side Story 21', '3', 'en', '2023-06-16 21:27:38', '2025-03-20 04:03:02', '2025-03-20 04:03:02'),
(2, 'f29a22c8-32ec-4e4b-8b29-5ac972b284da', 1, '199', 'Side Story 20', '3', 'en', '2023-06-16 21:24:52', '2025-03-20 04:03:04', '2025-03-20 04:03:04'),
(3, '04d28372-974a-496b-8bc5-b020be9d89fc', 1, '198', 'Side Story 19', '3', 'en', '2023-06-16 21:08:51', '2025-03-20 04:03:05', '2025-03-20 04:03:05'),
(4, '18852ab2-cbec-42c7-8155-f82ffac3b768', 1, '197', 'Side Story 18', '3', 'en', '2023-06-16 21:05:05', '2025-03-20 04:03:05', '2025-03-20 04:03:05'),
(5, '551847b6-5bdf-4d1e-bf50-637099606e35', 1, '196', 'Side Story 17', '3', 'en', '2023-06-07 05:24:43', '2025-03-20 04:03:06', '2025-03-20 04:03:06'),
(194, '6ef750d9-d38e-4c35-bd74-2279fc13fdd3', 2, '71.2', 'Untitled', NULL, 'en', '2025-03-03 01:46:44', '2025-03-27 15:02:27', '2025-03-27 15:02:27'),
(195, 'b4321c89-b022-43a4-98ee-d82c9e8399b3', 3, '106', 'Formal Audiences', '24', 'en', '2023-05-02 22:06:42', '2025-03-27 15:02:41', '2025-03-27 15:02:41'),
(201, 'd08901e2-9d12-4d0f-9b97-4820ed94da9f', 4, '140', 'The Ball', NULL, 'en', '2024-12-24 23:16:37', '2025-03-27 15:05:09', '2025-03-27 15:05:09'),
(202, '9e8f9182-bcf4-420f-b433-96aa45f86df5', 5, '417', 'Untitled', '32', 'en', '2023-12-12 10:29:15', '2025-03-27 15:05:27', '2025-03-27 15:05:27'),
(203, '8e7ca2bc-592a-4d96-8f94-3465dc8327a3', 6, '73.2', 'Untitled', NULL, 'en', '2025-03-06 10:55:32', '2025-03-27 15:05:46', '2025-03-27 15:05:46'),
(204, '1f36da9a-2e24-4842-b41d-374aabe4ffaa', 7, '64.5', 'Volume 12 Extras', '12', 'en', '2025-03-21 18:53:34', '2025-03-27 15:06:00', '2025-03-27 15:06:00'),
(205, 'd8c26bcc-d621-446a-b82d-c034c2fe1e4a', 8, '21.3', 'Untitled', NULL, 'en', '2024-11-11 23:18:10', '2025-03-27 15:06:13', '2025-03-27 15:06:13'),
(206, '6c4a2671-c0dc-49aa-855d-d75ff6cf1226', 9, '271', 'From Here on Out', '30', 'en', '2024-09-29 15:14:50', '2025-03-27 15:06:32', '2025-03-27 15:06:32'),
(207, '5e2d3ca7-0d56-4d22-b8af-e986c3c8278f', 520, '78.2', 'The Stronghold (Part 2)', '15', 'en', '2025-02-19 23:56:33', '2025-03-27 15:06:51', '2025-03-27 15:06:51'),
(290, 'e9ba48d7-4bee-4ff8-b569-332996719047', 520, '79.1', 'The Pit (Part 1)', NULL, 'en', '2025-03-28 21:22:29', '2025-03-30 08:07:01', '2025-03-30 08:07:01'),
(568, '1cd905c1-0c56-496b-99c9-b907cfc41610', 7, '64.6', 'Intermission Apparition \"Laundromat\"', NULL, 'en', '2025-03-22 14:35:50', '2025-03-31 05:51:06', '2025-03-31 05:51:06'),
(683, '410a7e8f-2398-48a4-a8c0-94fe41a3d6aa', 2, '72.1', 'Untitled', NULL, 'en', '2025-04-01 04:25:18', '2025-04-05 08:39:07', '2025-04-05 08:39:07'),
(686, 'ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75', 5, '500.5', 'Omake', '37', 'en', '2025-04-04 14:39:24', '2025-04-05 08:42:31', '2025-04-05 08:42:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chapter_images`
--

CREATE TABLE `chapter_images` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `page_number` int(11) NOT NULL,
  `image_url` varchar(512) NOT NULL,
  `local_path` varchar(512) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chapter_images`
--

INSERT INTO `chapter_images` (`id`, `chapter_id`, `page_number`, `image_url`, `local_path`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/1-433e18916aaed6d80b6e9055bfbffafa19acba1a1ae44fd8afa09662c497ac27.jpg', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_1.jpg', '2025-03-20 04:03:03', '2025-03-20 04:03:03'),
(188, 1, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/2-ce83346732b0e73b35c45498ba069330565156dcdffdc004e5ed683efffa1d8c.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_2.jpg', '2025-03-27 15:01:22', '2025-03-27 15:01:22'),
(189, 1, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/3-e4828c0c21144bfdb166202937f3c18ca11a36d5de73c33dd56e29b80590804b.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_3.jpg', '2025-03-27 15:01:23', '2025-03-27 15:01:23'),
(190, 1, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/4-d91dde5ec9b5d6e04d70a500e74bf41cf4bfe0fa8dc0cd6b3a20bdcb7f1d07d8.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_4.jpg', '2025-03-27 15:01:23', '2025-03-27 15:01:23'),
(191, 1, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/5-77db4a268a7fca477c6d57b8e6e02c24be62785b41c035cd3cd300422bf3af3d.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_5.jpg', '2025-03-27 15:01:24', '2025-03-27 15:01:24'),
(192, 1, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/6-8b711ac51e72d3b9b2b2fe917771d1698d54588a8012a6ecac10ba63a4842801.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_6.jpg', '2025-03-27 15:01:25', '2025-03-27 15:01:25'),
(193, 1, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/7-d357f0283652c13bd26a120e79ffe374a9046454ba8120c0516522e7eaa13e4e.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_7.jpg', '2025-03-27 15:01:25', '2025-03-27 15:01:25'),
(194, 1, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/8-5d09c044a875f94a5803c2b777485b1b262c02769efc850c96435f8c4a73d7f6.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_8.jpg', '2025-03-27 15:01:26', '2025-03-27 15:01:26'),
(195, 1, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/9-a71e6480eb62f86651503816558f907a291752983fbd233e898fe93270db171d.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_9.jpg', '2025-03-27 15:01:27', '2025-03-27 15:01:27'),
(196, 1, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/10-1cd41c86458774ed64ddef2b353b1a3d8c631843455718f09b6887cade5beb62.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_10.jpg', '2025-03-27 15:01:27', '2025-03-27 15:01:27'),
(197, 1, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/11-72a0d2dff463de0e986a93eae9e70f31e1abdb70883ab68d63c7e8d0c7d27da5.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_11.jpg', '2025-03-27 15:01:28', '2025-03-27 15:01:28'),
(198, 1, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/12-a61919a526ece6cd6d65e863aee20350870a0ffbfc85e47570062a1b82589643.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_12.jpg', '2025-03-27 15:01:29', '2025-03-27 15:01:29'),
(199, 1, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/13-e7d1a7ea65cdf665473ab6478eb44a6a69f4b6151fd5fb7cfb9fc9e2162377ad.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_13.jpg', '2025-03-27 15:01:30', '2025-03-27 15:01:30'),
(200, 1, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/14-54e401e9eaf0d5e8253af13bdac1a4278ad5dc3e0994c981822eeb79a688af0c.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_14.jpg', '2025-03-27 15:01:30', '2025-03-27 15:01:30'),
(201, 1, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/15-134f52992fbde3fd8c8e1185c01d7394bdd5248f08b9ca24d3c040e4803f4ae2.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_15.jpg', '2025-03-27 15:01:31', '2025-03-27 15:01:31'),
(202, 1, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/16-7046ed0f0ad96eb72cda797583790a44d8d46f3458a899f1b61d57839d9d6182.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_16.jpg', '2025-03-27 15:01:32', '2025-03-27 15:01:32'),
(203, 1, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/17-2d96351af45b22fba70bf4a116822b60d58c7cccd0c1ac23c91d2862d71321bb.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_17.jpg', '2025-03-27 15:01:32', '2025-03-27 15:01:32'),
(204, 1, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/18-55398d8056e1eb773c592b11b56efa31b98086ac6a2a7d8ed7198e6e57323174.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_18.jpg', '2025-03-27 15:01:33', '2025-03-27 15:01:33'),
(205, 1, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/19-1e06dc1b09d332c4eca6429e668a3f099cea598c82c3e603b682bd4e8680dc20.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_19.jpg', '2025-03-27 15:01:34', '2025-03-27 15:01:34'),
(206, 1, 20, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/20-a054769d6001c2601c9a5d4cd5486966c2d01a4975b3d60db7debb71064ceb71.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_20.jpg', '2025-03-27 15:01:35', '2025-03-27 15:01:35'),
(207, 1, 21, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/21-bea978bf10ff884759872bc6a083c8ebf0435137029b1b29af6af17a4d0d434b.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_21.jpg', '2025-03-27 15:01:35', '2025-03-27 15:01:35'),
(208, 1, 22, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/22-6595953cdc2d27eceaa7fa331385405d16d35efe4fa4ab6a1a9088eea5be7ce1.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_22.jpg', '2025-03-27 15:01:36', '2025-03-27 15:01:36'),
(209, 1, 23, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/23-34677667ab942fed69ac1c9e8daaacdcd2f2e63fb28c924df46c9211a0c68dd5.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_23.jpg', '2025-03-27 15:01:37', '2025-03-27 15:01:37'),
(210, 1, 24, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/24-81db4fca5903e9d357a786c2dd7c25db74a6be044adb2ce9edac34c65d2da91f.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_24.jpg', '2025-03-27 15:01:38', '2025-03-27 15:01:38'),
(211, 1, 25, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/25-5187477e6cd98a35a8eb5caa0efdc21f5b95fb9a8b7789dcbeb1744c6ccdf456.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_25.jpg', '2025-03-27 15:01:38', '2025-03-27 15:01:38'),
(212, 1, 26, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/26-4832ec8a417469257f688ffb5891b2141315cb582201d60f8fc82f02574b3561.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_26.jpg', '2025-03-27 15:01:39', '2025-03-27 15:01:39'),
(213, 1, 27, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/27-ad22ed8f0f9fd1ee3875cde41fa49e9925d44e5626b7bd42a665503b0cb5dd83.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_27.jpg', '2025-03-27 15:01:40', '2025-03-27 15:01:40'),
(214, 1, 28, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/28-a552761e3e014e44c1e492e59219f9005e7db92f4903cf6808d84f1ff64101c1.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_28.jpg', '2025-03-27 15:01:40', '2025-03-27 15:01:40'),
(215, 1, 29, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/29-d8f07c2428336bc15509067e7d7312a778bad97d5344ad753b9cd5e073a33c65.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_29.jpg', '2025-03-27 15:01:41', '2025-03-27 15:01:41'),
(216, 1, 30, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/30-156b5b39a5038947feb8934d8bab02a75551d3c7c38f7191ecffce38caf37d90.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_30.jpg', '2025-03-27 15:01:42', '2025-03-27 15:01:42'),
(217, 1, 31, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/31-a7ff7e38fd476f4c1d55f709df268066f8277399bad53cdd1880cc6eb1ccdf9e.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_31.jpg', '2025-03-27 15:01:42', '2025-03-27 15:01:42'),
(218, 1, 32, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/32-6dbdfd2e3a90c332940520c52060416929785acfc1983b0a511293425c298cee.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_32.jpg', '2025-03-27 15:01:43', '2025-03-27 15:01:43'),
(219, 1, 33, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/33-ee117b6bf7ed6738a25488ca7b9ffbb571de2d285b7b6da46babb10b4d89abe6.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_33.jpg', '2025-03-27 15:01:44', '2025-03-27 15:01:44'),
(220, 1, 34, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/34-7fe29873d74ec8d1e5e460d90b2699fbf22f9584304dacccd4273178584f58d3.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_34.jpg', '2025-03-27 15:01:45', '2025-03-27 15:01:45'),
(221, 1, 35, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/35-c28bd1b0373c263b3541d079fd4ee8d86e58b6d2913c0bf1af61e9fc621f442b.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_35.jpg', '2025-03-27 15:01:45', '2025-03-27 15:01:45'),
(222, 1, 36, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/36-8a4369fd312a91a98d25abf1f8efe00c7c7b6b63829836c61229534ef0ada775.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_36.jpg', '2025-03-27 15:01:46', '2025-03-27 15:01:46'),
(223, 1, 37, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/37-f1efae60f46d14fe3fd98d9460de84e94b3bb638be1a285e0d47df0427557a47.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_37.jpg', '2025-03-27 15:01:47', '2025-03-27 15:01:47'),
(224, 1, 38, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/38-fc7ca8caa2133cf9ea1d405ff16f813c627bebf221d0245748e67795fc622433.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_38.jpg', '2025-03-27 15:01:47', '2025-03-27 15:01:47'),
(225, 1, 39, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/39-a07e21fc87c20bdc212903ea290853c2ebb66cbde23728fe7635f31f421df0b1.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_39.jpg', '2025-03-27 15:01:48', '2025-03-27 15:01:48'),
(226, 1, 40, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/40-9de534bbf7a2e6bc62c82d5ff2e52f67b182f854f2fef046ba78c15637be218a.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_40.jpg', '2025-03-27 15:01:49', '2025-03-27 15:01:49'),
(227, 1, 41, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/41-7497fbf53fab9eff873929baae10b9428a65c79ad04dde0b89ae6c54170cbd41.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_41.jpg', '2025-03-27 15:01:50', '2025-03-27 15:01:50'),
(228, 1, 42, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/42-042e8ee304e63a07a3d1d970b0e508b2274940e90435b3d1946b6a96026124f1.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_42.jpg', '2025-03-27 15:01:51', '2025-03-27 15:01:51'),
(229, 1, 43, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/43-8a181b80c42ac1294a4c4db03081e6ed995cd073312ef1e917c822e22df2c8eb.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_43.jpg', '2025-03-27 15:01:52', '2025-03-27 15:01:52'),
(230, 1, 44, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/44-9d64c4691b0cd16b6b2134d1b95396614ac342a184715d20173349d0d88422a9.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_44.jpg', '2025-03-27 15:01:52', '2025-03-27 15:01:52'),
(231, 1, 45, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/45-ad5c45990094f2c26437cd3f5562aee4919da072f406443bc2b56a6722ba9903.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_45.jpg', '2025-03-27 15:01:53', '2025-03-27 15:01:53'),
(232, 1, 46, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/46-aa35ad0ac3a398244d2defd9e259ff3fc78329d17d79697d80409d73a5c9ff27.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_46.jpg', '2025-03-27 15:01:54', '2025-03-27 15:01:54'),
(233, 1, 47, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/47-9a4b445847db2be8001bcab3743e0bb1f2f29dcacf921f7e99296dc1ecf2affb.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_47.jpg', '2025-03-27 15:01:55', '2025-03-27 15:01:55'),
(234, 1, 48, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/48-7ed27480a438df23d0b107012ed52b9cc9104a099e45659a0a7444b7e7f2c50e.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_48.jpg', '2025-03-27 15:01:55', '2025-03-27 15:01:55'),
(236, 1, 49, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/49-6cef610fe7f9567fb7dece0a9c4e62c058c0a60a709f96409c7389b98654846b.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_49.jpg', '2025-03-27 15:01:56', '2025-03-27 15:01:56'),
(238, 1, 50, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/50-ae3a57397fe5c91f3f6d66516f9c7a2c80068a7d533bacc657db4d0e91d681c9.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_50.jpg', '2025-03-27 15:01:57', '2025-03-27 15:01:57'),
(240, 1, 51, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/51-82918f62f104f26abe262496c407cd41592a102529f3396ceca755e6b325dd0a.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_51.jpg', '2025-03-27 15:01:57', '2025-03-27 15:01:57'),
(242, 1, 52, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/52-e82d27b2886188fb5b96b6d0c123b3e383fc0f2358cfebdc0e9dc59436ae76ba.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_52.jpg', '2025-03-27 15:01:58', '2025-03-27 15:01:58'),
(244, 1, 53, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/53-b90444cfa3e24b6797e2c35dd92656c457bd19687c029d7ac18fdd75b15d559b.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_53.jpg', '2025-03-27 15:01:59', '2025-03-27 15:01:59'),
(246, 1, 54, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/54-e7ec61935ea97b2a751ff8ca167299fa36510a72f98d27b3887629f31a86dce0.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_54.jpg', '2025-03-27 15:02:00', '2025-03-27 15:02:00'),
(248, 1, 55, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/55-8c1314037a8d38f7b65950217b7198a00320c3391af8544e7877299ea17dab8d.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_55.jpg', '2025-03-27 15:02:00', '2025-03-27 15:02:00'),
(250, 1, 56, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/56-9a3d04364bb26a32cbe6efc5efbca5af8bb419d7f0dd5f3e9db24f5b84ecd120.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_56.jpg', '2025-03-27 15:02:01', '2025-03-27 15:02:01'),
(252, 1, 57, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/57-aac04e5679ccdb6acd7aa69eccc4a65a72fc44f79c7518891ec282031656623c.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_57.jpg', '2025-03-27 15:02:02', '2025-03-27 15:02:02'),
(254, 1, 58, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/58-48055c8b6463355cb42f5a060a905219155de5cd15fab3b2c9f4ce515173f311.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_58.jpg', '2025-03-27 15:02:02', '2025-03-27 15:02:02'),
(257, 1, 59, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/59-ea78840060f248e6668b8caad4a95e15d26e233a86b78a542be9f514f7086348.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_59.jpg', '2025-03-27 15:02:03', '2025-03-27 15:02:03'),
(259, 1, 60, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/60-402d52eab9fa53e9c7ec5071656a75559988b0ff960a27222138c75428acc9c9.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_60.jpg', '2025-03-27 15:02:04', '2025-03-27 15:02:04'),
(261, 1, 61, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/61-99a4ce43afdccfbc08a17163c02ad791c868500f4088dbfc0f164d6fc4803607.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_61.jpg', '2025-03-27 15:02:05', '2025-03-27 15:02:05'),
(263, 1, 62, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/62-65bb7410f9c901a9602e4708a08d63704078eb47d6ce49ab11a29af5443c5088.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_62.jpg', '2025-03-27 15:02:05', '2025-03-27 15:02:05'),
(265, 1, 63, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/63-699a23fa2fdbaf0da0b4a5ed41aed01fbb85c684bdad50104a7e571f592ab5d8.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_63.jpg', '2025-03-27 15:02:06', '2025-03-27 15:02:06'),
(267, 1, 64, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/64-e1a2aad4c0ef91239ac654ef3200a4e5c8b3e5af559439bb8727472757e722e8.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_64.jpg', '2025-03-27 15:02:07', '2025-03-27 15:02:07'),
(269, 1, 65, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/65-488bffa5a7a20360132dcf0e752ecc9aec701efe8db4b0c4336b3309f76f6e19.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_65.jpg', '2025-03-27 15:02:08', '2025-03-27 15:02:08'),
(271, 1, 66, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/66-97b2c1e20fa2c95c6d35c8092b73c874b7c37c14c004713dfa812eb6018fcfe3.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_66.jpg', '2025-03-27 15:02:09', '2025-03-27 15:02:09'),
(273, 1, 67, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/67-9394c05eec931539665c4eade40aef954887822c76fb45d3996a21e4cf848987.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_67.jpg', '2025-03-27 15:02:09', '2025-03-27 15:02:09'),
(274, 1, 68, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/68-a8672215e6b3d677b0a2c622203138765dec6e1acfe5e8df6ca3128fa9c5328e.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_68.jpg', '2025-03-27 15:02:10', '2025-03-27 15:02:10'),
(276, 1, 69, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/69-1b1bd2e7bbee1e4c55a2f84bce97ab39346e94ec06536cb332af8ab7f6271c72.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_69.jpg', '2025-03-27 15:02:11', '2025-03-27 15:02:11'),
(278, 1, 70, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/70-94c726e1bf15271f7ad680007366fb6b243c960df5fe8bbb510e4d3f13561020.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_70.jpg', '2025-03-27 15:02:12', '2025-03-27 15:02:12'),
(280, 1, 71, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/71-569359b36ddd0833e97558f4fac016f91a8f819fa9555c805412cadb352d8eb7.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_71.jpg', '2025-03-27 15:02:12', '2025-03-27 15:02:12'),
(282, 1, 72, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/72-5706d44fde1f9bec7f6c7f20a7334f8ae4c4360ae401d38a6b6967118837b109.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_72.jpg', '2025-03-27 15:02:13', '2025-03-27 15:02:13'),
(284, 1, 73, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/73-7da886e28485833ae993883af81cefee0a208cf9fe5670c2a7ab26813b0a6f56.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_73.jpg', '2025-03-27 15:02:14', '2025-03-27 15:02:14'),
(286, 1, 74, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/74-04d444372422dc8336ccca90bb3b4fa6f065e56db9c4e02bc540ecc3663fc974.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_74.jpg', '2025-03-27 15:02:14', '2025-03-27 15:02:14'),
(288, 1, 75, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/75-b1188864cb92a3894f40c49d96c315b09ceb90cfcb8886c8836e7f1d2597d67d.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_75.jpg', '2025-03-27 15:02:15', '2025-03-27 15:02:15'),
(290, 1, 76, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/76-f4440a9f0bfa11cd51a1bd97d6a1e161120aac75c9f61e2e4412cfd0b785b2a8.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_76.jpg', '2025-03-27 15:02:16', '2025-03-27 15:02:16'),
(292, 1, 77, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/77-318d6c9242d357ec032cd7953268cc48c67521fc27d7de09a5fee198fe3ce792.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_77.jpg', '2025-03-27 15:02:16', '2025-03-27 15:02:16'),
(294, 1, 78, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/78-208d93823de893c63bba17e936a00344299baf144a438681190884a049c41dc4.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_78.jpg', '2025-03-27 15:02:17', '2025-03-27 15:02:17'),
(296, 1, 79, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/79-c05540177fe73c7472c25c6f6504546103e6fd9fb528fe776bec2c1886cdfad0.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_79.jpg', '2025-03-27 15:02:18', '2025-03-27 15:02:18'),
(298, 1, 80, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/80-a3ce3b9aa608ed6dd21002316efaf04899e8c1491fe4624250fccc77f04f886d.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_80.jpg', '2025-03-27 15:02:19', '2025-03-27 15:02:19'),
(301, 1, 81, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/81-f4f5089b91d0f4d4f22b1de72b2dd5aeba8c6f96c6f8035aa1c421dac3ea5189.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_81.jpg', '2025-03-27 15:02:20', '2025-03-27 15:02:20'),
(303, 1, 82, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/82-18eea54be50ad3cff973dca12323dc70445b28bf0c5e81e8664d8013f08f600a.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_82.jpg', '2025-03-27 15:02:21', '2025-03-27 15:02:21'),
(305, 1, 83, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/83-f054749f55a9a2b7ba620565d2621a0cc6baf7d35dd6fa34ca42e441e075189d.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_83.jpg', '2025-03-27 15:02:21', '2025-03-27 15:02:21'),
(307, 1, 84, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/84-9d4cea37c21a8ce8787eab54f2a152ef4525ac130509fd187bbe7d35b9621450.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_84.jpg', '2025-03-27 15:02:22', '2025-03-27 15:02:22'),
(309, 1, 85, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/85-ce1356e40be6590f70f4ae93a12d260022471c76b6648eb2b187daf479b8f179.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_85.jpg', '2025-03-27 15:02:23', '2025-03-27 15:02:23'),
(311, 1, 86, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/86-c80e5b348cfe08192db23e2e2c2f288027f233cff4d1a068d11e1e6fb229cfab.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_86.jpg', '2025-03-27 15:02:23', '2025-03-27 15:02:23'),
(312, 1, 87, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/87-cce73cbbca96b60fcbf08f6f376f8dcd3cbc88384ae8c50c5ebe8356e513260b.png', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_87.jpg', '2025-03-27 15:02:24', '2025-03-27 15:02:24'),
(314, 1, 88, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/88-92a538ee5feff896a0445a4649ec9e47d29e60fb447ed9bf6da1c186dbd0af35.jpg', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_88.jpg', '2025-03-27 15:02:25', '2025-03-27 15:02:25'),
(316, 1, 89, 'https://cmdxd98sb0x3yprd.mangadex.network/data/110ba656bc89ee7dbbc2e6e66b2a3614/89-bdc123e6d16c406fee54f463c7be0d478ce6a6d819912755695b3a91ed9f4b0a.jpg', 'images/chapters/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3_page_89.jpg', '2025-03-27 15:02:25', '2025-03-27 15:02:25'),
(321, 194, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/1-67ff3726ed514bb29a7d334def4f62e8a79a145761bba0ebe42b4d34df8d05c9.jpg', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_1.jpg', '2025-03-27 15:02:29', '2025-03-27 15:02:29'),
(323, 194, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/2-460658a4e9d6fd62b3af353325d550deea69d33ce05b1584e2c741ac4caaacdb.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_2.jpg', '2025-03-27 15:02:29', '2025-03-27 15:02:29'),
(325, 194, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/3-69d48835771813dbb47c5269e415b3e34b02df8a3b1fa20b31222320006c4a35.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_3.jpg', '2025-03-27 15:02:30', '2025-03-27 15:02:30'),
(327, 194, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/4-a798148f3b44f7f87766c9173920e75b7bee699b6a539508dedfa58f422b28d9.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_4.jpg', '2025-03-27 15:02:31', '2025-03-27 15:02:31'),
(329, 194, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/5-a26002ddb29f7decf525c08f5a366b526499bd5632c9a7102065caa5e4cc5761.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_5.jpg', '2025-03-27 15:02:31', '2025-03-27 15:02:31'),
(331, 194, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/6-9c831eb3cff71de2dadfe9592d98d58b8385c7c148e4b84aa07719b4d4df776d.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_6.jpg', '2025-03-27 15:02:32', '2025-03-27 15:02:32'),
(333, 194, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/7-45719ee258b6fbeffe313e88d14f5054e1cba91d65dc1e1a4101838c5742866a.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_7.jpg', '2025-03-27 15:02:33', '2025-03-27 15:02:33'),
(335, 194, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/8-33ee221f6fc7a0a44df2b49d0414310ba2acfabac6be8b7a46f50aef2b78afd1.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_8.jpg', '2025-03-27 15:02:33', '2025-03-27 15:02:33'),
(337, 194, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/9-5f0b900dccbf64a311873834955618f1827d71543a2707c18757d4232fbedeb0.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_9.jpg', '2025-03-27 15:02:34', '2025-03-27 15:02:34'),
(339, 194, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/10-19c8b86958668b520a6ddfcb3e341c851e3e4148e70885bc14647b95998ded67.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_10.jpg', '2025-03-27 15:02:35', '2025-03-27 15:02:35'),
(341, 194, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/11-69f3131f0d08848b9b9717b6c7fe073726567d6c05f5ee0ce4ff43d98ca9d366.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_11.jpg', '2025-03-27 15:02:35', '2025-03-27 15:02:35'),
(342, 194, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/12-280b1916e501a86237f20f2083507fac9746d2f051f367174c6bf0197f7a8500.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_12.jpg', '2025-03-27 15:02:36', '2025-03-27 15:02:36'),
(344, 194, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/13-6dcf2fa21a4d4cde281f85b868540afabe98946697c503a8d5d5d15c2702df03.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_13.jpg', '2025-03-27 15:02:37', '2025-03-27 15:02:37'),
(346, 194, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/14-e696a34a62b36077cf4bfb8907f3df2226196dfead6e48fb3c8b7d90add9f739.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_14.jpg', '2025-03-27 15:02:38', '2025-03-27 15:02:38'),
(348, 194, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/15-a8c3fd9ac4580bc38cd5e705367e9d2fae38d7e2f85f73909b471746675afe24.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_15.jpg', '2025-03-27 15:02:38', '2025-03-27 15:02:38'),
(350, 194, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/16-da296fbfc2f456701e3bde32a0ed3d3d8ab051034dc321875b8577e75df0a245.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_16.jpg', '2025-03-27 15:02:39', '2025-03-27 15:02:39'),
(352, 194, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d275fd5ea260dce4f05d00f4abe24497/17-6a1d919dc0788982c0f4a9d88465c38eb269a93a28f7310f22c31a3b07107732.png', 'images/chapters/6ef750d9-d38e-4c35-bd74-2279fc13fdd3_page_17.jpg', '2025-03-27 15:02:40', '2025-03-27 15:02:40'),
(357, 195, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/1-5c32881144499379d5bd9411bec8c7c4c1abaa7692d9d76c37335d5570b9ba36.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_1.jpg', '2025-03-27 15:02:43', '2025-03-27 15:02:43'),
(359, 195, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/2-946979fbe0bbbf741c1d58871aac1aff73a4ecc8eb46170ec81eb387314a0275.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_2.jpg', '2025-03-27 15:02:44', '2025-03-27 15:02:44'),
(361, 195, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/3-d9a96d22c2d321fdce217f691c995ab4f331d2170858bb703af4cbff617fa180.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_3.jpg', '2025-03-27 15:02:44', '2025-03-27 15:02:44'),
(363, 195, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/4-310ca1c598286000fd0f4ccf9fd2c4ebe96569200574325fa42fa398cd9d3417.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_4.jpg', '2025-03-27 15:02:45', '2025-03-27 15:02:45'),
(365, 195, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/5-b9e82759d1162b236997ecb6c93cc9a59d3542a7cddbf39f9652afe4b1516823.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_5.jpg', '2025-03-27 15:02:46', '2025-03-27 15:02:46'),
(367, 195, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/6-86e89c75fef32b79a6d650a2bc2bb052c6c17dea665fdca8a9034c29a874e08f.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_6.jpg', '2025-03-27 15:02:46', '2025-03-27 15:02:46'),
(369, 195, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/7-32473ee23f536f5bf9af7113fcc247fe4e58904ce72efd89903c1afc087afbab.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_7.jpg', '2025-03-27 15:02:47', '2025-03-27 15:02:47'),
(371, 195, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/8-04f8948954fa0b92d370974d9697fb7f1b6661ed7298442a08f2f36c635be15b.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_8.jpg', '2025-03-27 15:02:48', '2025-03-27 15:02:48'),
(373, 195, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/9-f87e67c021c54861b3ecdf1d1b44d9947c29b05312dbea4cb7d68a68ccd8d947.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_9.jpg', '2025-03-27 15:02:48', '2025-03-27 15:02:48'),
(375, 195, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/10-2384a83394dbe1ad7b1ec6b1b1b20b38b0cee310ea52eead0129812b87e7cb98.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_10.jpg', '2025-03-27 15:02:49', '2025-03-27 15:02:49'),
(377, 195, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/11-5977fa471092ed607f0b4759b45563f501e09d704376710b358c4f4226939dae.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_11.jpg', '2025-03-27 15:02:50', '2025-03-27 15:02:50'),
(379, 195, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/12-edde3ceced035c7755217bdab248ad4b8d6d378a1216113b4449b1c4acccd0f8.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_12.jpg', '2025-03-27 15:02:51', '2025-03-27 15:02:51'),
(381, 195, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/13-31ca1b659dca7cf10b80f311401c93f81ef6183feaddee3f1886572824a1640d.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_13.jpg', '2025-03-27 15:02:51', '2025-03-27 15:02:51'),
(383, 195, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/14-64de3a52b9c8fe1c88ff240a61816062bcdcb94588205501b67ce871d11d1572.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_14.jpg', '2025-03-27 15:02:52', '2025-03-27 15:02:52'),
(385, 195, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/15-44da53be8fedab93355def305cf6798140d4c06c12dd38f3ab72b2c04e3a968b.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_15.jpg', '2025-03-27 15:02:53', '2025-03-27 15:02:53'),
(387, 195, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/16-4d93038b566124bc237fdab85453266af732c52292817930239547ebcbe79d9d.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_16.jpg', '2025-03-27 15:02:54', '2025-03-27 15:02:54'),
(389, 195, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/17-8d138438debe96d6e78c2481a6dab81d3cbcd2f1469440d5a00664e0c4894966.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_17.jpg', '2025-03-27 15:02:54', '2025-03-27 15:02:54'),
(391, 195, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/18-70c6481e11720f3c96e0b812a3d146d13bc23eec337cb2abc6f83659a26b8112.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_18.jpg', '2025-03-27 15:02:55', '2025-03-27 15:02:55'),
(393, 195, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/19-cd482b52b57dad88a3ce2b67df42e520531496aa315de06ce58eacdb78de333c.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_19.jpg', '2025-03-27 15:02:56', '2025-03-27 15:02:56'),
(395, 195, 20, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/20-ccee94f06135a2e0aa76daa654a3e6dea8484c2ac0a012bf3e728b1e2c5eb927.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_20.jpg', '2025-03-27 15:02:57', '2025-03-27 15:02:57'),
(397, 195, 21, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/21-0fdc79710bd1ac0a7bf05eb0d35e32bfd7c6e841384018d7eae713ddca684940.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_21.jpg', '2025-03-27 15:02:58', '2025-03-27 15:02:58'),
(399, 195, 22, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/22-bde442c6ef93ca47f6b0e78687b1bda60221d24f99a3c7c737a30f012a73c1c6.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_22.jpg', '2025-03-27 15:02:58', '2025-03-27 15:02:58'),
(401, 195, 23, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/23-44530f9432a0f4db9a7b01869a4f91c4ca2361d0407c363dbaddfcc363d6e4d7.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_23.jpg', '2025-03-27 15:02:59', '2025-03-27 15:02:59'),
(403, 195, 24, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/24-ca9a63b1edab98367e37bca6052669a788520958c0fb489de15a91cddf243f30.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_24.jpg', '2025-03-27 15:03:00', '2025-03-27 15:03:00'),
(405, 195, 25, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/25-879d4ed1b0ffc4bce8494d6c07ca70f44cb809d8ddecdbb00e401506c94c0262.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_25.jpg', '2025-03-27 15:03:01', '2025-03-27 15:03:01'),
(407, 195, 26, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/26-bcf107c98466ee62ecba6215e223d12e107b543c07246f1f930efb53a074c15f.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_26.jpg', '2025-03-27 15:03:02', '2025-03-27 15:03:02'),
(408, 195, 27, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/27-b79ee8019433486842529b224c17e3ff58d1e9c270a3fc7c6b16224298f42288.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_27.jpg', '2025-03-27 15:03:03', '2025-03-27 15:03:03'),
(410, 195, 28, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/28-b1374e3d2229b2f4f647e8a3f3fd0b0f3f4b5dbaf7573f5374909299494df322.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_28.jpg', '2025-03-27 15:03:04', '2025-03-27 15:03:04'),
(413, 195, 29, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/29-686f46466b6d25b52b3917a54787d08329f88bd10b8fcb24db7f452895655f07.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_29.jpg', '2025-03-27 15:03:05', '2025-03-27 15:03:05'),
(416, 195, 30, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/30-779d632b5dfb4cc80a62e52e0a8d1e7380a3ffc314aa4dea6cd69590dc974cea.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_30.jpg', '2025-03-27 15:03:06', '2025-03-27 15:03:06'),
(419, 195, 31, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/31-49c697ca05c88f7dc05ed8380312a9d2648a411da068ddf995060c43794a1e0d.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_31.jpg', '2025-03-27 15:03:07', '2025-03-27 15:03:07'),
(421, 195, 32, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/32-13f6ad9d907888def4034952f78c0d3cf3428aa7e6da413937b00bf39f7bb3d5.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_32.jpg', '2025-03-27 15:03:07', '2025-03-27 15:03:07'),
(424, 195, 33, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/33-a2c2b6eb2aa8f01365a52389efa88b96e8c4300427cb1dd640c9bf8306193445.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_33.jpg', '2025-03-27 15:03:08', '2025-03-27 15:03:08'),
(427, 195, 34, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/34-0306a9e4d7e50ac8b1438f99f3fc62febbed93d4fe8a7a04b17181ea7d77ed85.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_34.jpg', '2025-03-27 15:03:09', '2025-03-27 15:03:09'),
(430, 195, 35, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/35-12a508b8976ca7bd2f35b42c6dd606f556787da8fb5747cae265df52cc88d519.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_35.jpg', '2025-03-27 15:03:10', '2025-03-27 15:03:10'),
(433, 195, 36, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/36-3ff9012b08a737f14f0268e6a8a6470fdab9a3550c5cbf464f996bc8505d424a.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_36.jpg', '2025-03-27 15:03:11', '2025-03-27 15:03:11'),
(436, 195, 37, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/37-c6ef32551ba28f818507a27e62265e61d8f8707697b5375ac22e5700a874f474.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_37.jpg', '2025-03-27 15:03:12', '2025-03-27 15:03:12'),
(439, 195, 38, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/38-1ff5149ef083c8437fa8c6cbf4aa1d15521f2c8211b688137413b9c99acc29c8.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_38.jpg', '2025-03-27 15:03:13', '2025-03-27 15:03:13'),
(442, 195, 39, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/39-0581f486f9556128ac9f67245cdc9b5707834d36db6ddfc7963688965fb5e1c2.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_39.jpg', '2025-03-27 15:03:14', '2025-03-27 15:03:14'),
(617, 195, 40, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/40-8acccf5fcae39457ee4b9c22df61653388a0a5a268a3b359845eab91317b9d47.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_40.jpg', '2025-03-27 15:05:03', '2025-03-27 15:05:03'),
(618, 195, 41, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/41-b19bb6991d8cb34bc2980940f28917c5ad74217a13f26794dfd957e04bfc111c.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_41.jpg', '2025-03-27 15:05:04', '2025-03-27 15:05:04'),
(619, 195, 42, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/42-dab4591b1d767bfaf1db5955ed1028c8afd3000786023882418663ef01fdbe45.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_42.jpg', '2025-03-27 15:05:05', '2025-03-27 15:05:05'),
(620, 195, 43, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/43-183d1a8d2e1bacfff2f50f19059c53925eda2ef1baf231c185d13462704a895a.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_43.jpg', '2025-03-27 15:05:06', '2025-03-27 15:05:06'),
(621, 195, 44, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/44-ba6cf3e568596de3a4c14d8613d89397b832c728464c4ea5371f48d5c6d9d047.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_44.jpg', '2025-03-27 15:05:07', '2025-03-27 15:05:07'),
(622, 195, 45, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bb1a41200962648ff1b769ada3e4ac54/45-8bd6604c5f21211badaa3da88f46ec96520d1eb3df6f9aee9dd70f4f8b5700d2.png', 'images/chapters/b4321c89-b022-43a4-98ee-d82c9e8399b3_page_45.jpg', '2025-03-27 15:05:08', '2025-03-27 15:05:08'),
(623, 201, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/1-81077d87024532f1f63089abf5a19af3f50e88f500c13926df87ea5fbbe8127b.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_1.jpg', '2025-03-27 15:05:11', '2025-03-27 15:05:11'),
(624, 201, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/2-9f90a915887f9fd77b4392c7bcc6eb24a02df651284a9f425f28a9cb05dfd804.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_2.jpg', '2025-03-27 15:05:12', '2025-03-27 15:05:12'),
(625, 201, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/3-816231c1b8d35e2d0059098d83ffaa2b36ed45eb1eae74c906378401f37599d0.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_3.jpg', '2025-03-27 15:05:12', '2025-03-27 15:05:12'),
(626, 201, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/4-11fc2d4e6b45c75493d440891101137aa157d2014639833bf3cf7334322ed4af.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_4.jpg', '2025-03-27 15:05:13', '2025-03-27 15:05:13'),
(627, 201, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/5-9f1b32ec21bb9f3102b0e57ef9c49de13d54dba2fb1c9b78dd804a90e0f56df0.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_5.jpg', '2025-03-27 15:05:14', '2025-03-27 15:05:14'),
(628, 201, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/6-bb24d185796f746fd907c07928c39d5daa54cca4792040b968882b497be88c7d.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_6.jpg', '2025-03-27 15:05:15', '2025-03-27 15:05:15'),
(629, 201, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/7-cb76a1e5bffb126df1eb0b93a5ae02156b2a93058f5296001be953c397bf1715.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_7.jpg', '2025-03-27 15:05:16', '2025-03-27 15:05:16'),
(630, 201, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/8-9407ca8e83820bd5f153cd2dce65ec9dc9a871005cfec3785d9002267e238e3b.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_8.jpg', '2025-03-27 15:05:17', '2025-03-27 15:05:17'),
(631, 201, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/9-718c1cd17331a916eb40f47485a117b6b8a6d28b4b30e2ef8dda2404b392189c.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_9.jpg', '2025-03-27 15:05:18', '2025-03-27 15:05:18'),
(632, 201, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/10-1c13d765db379ea9d3aca9cc9afd95a98fba09fc88126bfe8f17574addad3b5c.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_10.jpg', '2025-03-27 15:05:18', '2025-03-27 15:05:18'),
(633, 201, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/11-9f5d159ae7558a11d391693e34b15f7c3524c3b590061322650a09fcaf03d452.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_11.jpg', '2025-03-27 15:05:19', '2025-03-27 15:05:19'),
(634, 201, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/12-5f23327b88043add1f898799e05eb181e3f8873eb8b8f2fdd0a12a49467639a6.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_12.jpg', '2025-03-27 15:05:20', '2025-03-27 15:05:20'),
(635, 201, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/13-b056bc2bf72d125180d177782b633c7c6fd54bf9378aa0920a862a7be996ae09.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_13.jpg', '2025-03-27 15:05:21', '2025-03-27 15:05:21'),
(636, 201, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/14-94df797988800fdd300501c207147970f4edc8b0d0b8e3393e30485b62e4c6d9.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_14.jpg', '2025-03-27 15:05:21', '2025-03-27 15:05:21'),
(637, 201, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/15-4e1c312492086f9a7e13b97fe6221025aa90f99ac1f8d6f58ef90cff73ed8ff5.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_15.jpg', '2025-03-27 15:05:22', '2025-03-27 15:05:22'),
(638, 201, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/16-6d06a49dc9b7d0fa181b1d03cae49603d825308fb40ac40ee22dd48a40eff82a.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_16.jpg', '2025-03-27 15:05:23', '2025-03-27 15:05:23'),
(639, 201, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/17-47823c72c9899893293ba43451778b3e6d86fdb47b9455531cdc0c8602468190.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_17.jpg', '2025-03-27 15:05:24', '2025-03-27 15:05:24'),
(640, 201, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/18-5803c018d9e28639070e6c06dc7eb8edae62f22e83f1e4b2fdca9da115a9fdaa.png', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_18.jpg', '2025-03-27 15:05:25', '2025-03-27 15:05:25'),
(641, 201, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/4f621b1f34d0d5dc46c5be37aca646b0/19-d56b2fe09d50f52c66943a460478d37329ceb5ff2be08232b3958199c38a56f3.jpg', 'images/chapters/d08901e2-9d12-4d0f-9b97-4820ed94da9f_page_19.jpg', '2025-03-27 15:05:26', '2025-03-27 15:05:26'),
(642, 202, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/1-552ff214bd0d9cf6802c1000b52c0263490fff6005127a32cdbf3f407c251b08.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_1.jpg', '2025-03-27 15:05:29', '2025-03-27 15:05:29'),
(643, 202, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/2-6511810aa2a07ad9e28e30e9da1c8aff27aa7a2e029f40f787bb9ff71c18ed45.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_2.jpg', '2025-03-27 15:05:29', '2025-03-27 15:05:29'),
(644, 202, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/3-0a498a15274d5ddc40e2d510650337a89e5f3fade7623c4f94dde75c6d7d17b4.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_3.jpg', '2025-03-27 15:05:30', '2025-03-27 15:05:30'),
(645, 202, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/4-d876c831f7e509388e693dc57b5a523b54365ac2f27a6cedf840b5aff8a32b57.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_4.jpg', '2025-03-27 15:05:31', '2025-03-27 15:05:31'),
(646, 202, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/5-91f1bafb9d60b5fa8e318e765b5452efcac0f541532bc921854e091d47e71aa0.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_5.jpg', '2025-03-27 15:05:31', '2025-03-27 15:05:31'),
(647, 202, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/6-063d71737ced80b0c5425293095220e2f7dc6021b4bcc45c822136094eec0da5.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_6.jpg', '2025-03-27 15:05:32', '2025-03-27 15:05:32'),
(648, 202, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/7-c30807dda9c58e20d0db7f89e80a428e6e041ff549a47c26024c31aacc3975e0.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_7.jpg', '2025-03-27 15:05:33', '2025-03-27 15:05:33');
INSERT INTO `chapter_images` (`id`, `chapter_id`, `page_number`, `image_url`, `local_path`, `created_at`, `updated_at`) VALUES
(649, 202, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/8-fc6a59fa62ec97b59d432cbb83fba3015a863b8757a0b48acfb6fd4515a79498.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_8.jpg', '2025-03-27 15:05:33', '2025-03-27 15:05:33'),
(650, 202, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/9-99c3e0cd22bc41fbc289b403ab8ad76588e427d7a23bea9865da53a90523d1f5.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_9.jpg', '2025-03-27 15:05:35', '2025-03-27 15:05:35'),
(651, 202, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/10-a7d0770c1d0638cb2141efca6318bc5818ccb7f41ce2da5089a3f95dee430fb5.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_10.jpg', '2025-03-27 15:05:36', '2025-03-27 15:05:36'),
(652, 202, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/11-e0b2846999920bd05cc1ae8d4154bc54a09b287a97e6c79b4883fb25f765ebe6.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_11.jpg', '2025-03-27 15:05:37', '2025-03-27 15:05:37'),
(653, 202, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/12-368b69acb4ac9b800630493da8c2e47c3c6b6cea2c70495b5dbe71a2c6a28161.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_12.jpg', '2025-03-27 15:05:37', '2025-03-27 15:05:37'),
(654, 202, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/13-310d15690e64eb3333227951e4a87d57ea570273f29625cb490213a649bce884.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_13.jpg', '2025-03-27 15:05:38', '2025-03-27 15:05:38'),
(655, 202, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/14-411ae4ca34b5914af05f97076a8a0f09a5fd4645d2c8c4204f6052f33ae88239.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_14.jpg', '2025-03-27 15:05:39', '2025-03-27 15:05:39'),
(656, 202, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/15-74d49e9dcab3350fa184e3d155980e6ed38e3b4f488eafafcec59797109c2c7c.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_15.jpg', '2025-03-27 15:05:39', '2025-03-27 15:05:39'),
(657, 202, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/16-417427a842faa09a55a48b320d022aeab139149afd8539ab319c9e66426280f6.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_16.jpg', '2025-03-27 15:05:40', '2025-03-27 15:05:40'),
(658, 202, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/17-7e4404220d92944245d31e6be01c9874b56a735706b17d024313c9b1890893ac.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_17.jpg', '2025-03-27 15:05:41', '2025-03-27 15:05:41'),
(659, 202, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/18-ba0fd462cac3035cdc5be97400535fe48e15ac264d83075775353895ef8a7d79.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_18.jpg', '2025-03-27 15:05:42', '2025-03-27 15:05:42'),
(660, 202, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/19-f4d9a94f55fef08118424bdbffd1ff9fc4c14835eb3b3449db681c7044c98388.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_19.jpg', '2025-03-27 15:05:42', '2025-03-27 15:05:42'),
(661, 202, 20, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/20-1a499dd723e4c9fc484a648c4617eb95fc43d851fa3c266342648c31263f159e.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_20.jpg', '2025-03-27 15:05:43', '2025-03-27 15:05:43'),
(662, 202, 21, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/21-d37d5707ab040d748033b2cda1ba7c7907d5fddec77c779d0838aa3b8821911a.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_21.jpg', '2025-03-27 15:05:44', '2025-03-27 15:05:44'),
(663, 202, 22, 'https://cmdxd98sb0x3yprd.mangadex.network/data/26d3f0f0187abc2f7f0810bac0e10fe5/22-b95c1001f78ffa551c2a2233dc4aca9adf748dd1aee5e35b3cc900651c7eb42c.png', 'images/chapters/9e8f9182-bcf4-420f-b433-96aa45f86df5_page_22.jpg', '2025-03-27 15:05:45', '2025-03-27 15:05:45'),
(664, 203, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/1-1eb80b8c4d74c0cb3d5b8bbf1e44bcdf57766fea8914295902c14f0e8eed0d7a.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_1.jpg', '2025-03-27 15:05:48', '2025-03-27 15:05:48'),
(665, 203, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/2-f3becf8f5f97b63619466d1c93f4e46a2e2a67d2f65093e8db8081dec343d1b3.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_2.jpg', '2025-03-27 15:05:48', '2025-03-27 15:05:48'),
(666, 203, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/3-25c33f7c555954249681908779364f0838fa63dd2a7a569d8c4888cf368c702e.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_3.jpg', '2025-03-27 15:05:49', '2025-03-27 15:05:49'),
(667, 203, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/4-9f3bb9faffea057bee5d53797b1a97b9a073b4498cf856ab4c075322ac8a03a7.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_4.jpg', '2025-03-27 15:05:50', '2025-03-27 15:05:50'),
(668, 203, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/5-877ca60392fbd9fa9558c75b4949a89cba56b4ea12970602739452d3e8063065.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_5.jpg', '2025-03-27 15:05:50', '2025-03-27 15:05:50'),
(669, 203, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/6-4b51eed7dcc8432591b0176208e4eeeb607b21acd7a7bd8f9ccc4ea4585f51bf.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_6.jpg', '2025-03-27 15:05:51', '2025-03-27 15:05:51'),
(670, 203, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/7-9c5e071e89ffa8e6eb9682cd3196ff810a3dda3b6a26879461b827f499dfbc65.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_7.jpg', '2025-03-27 15:05:52', '2025-03-27 15:05:52'),
(671, 203, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/8-49674f4ccf3e1a2bb847a37eb1904994f4a7110cf6c13a61290c0fb0f5c97e1b.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_8.jpg', '2025-03-27 15:05:53', '2025-03-27 15:05:53'),
(672, 203, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/9-4daba6b82e0e5ba508cd7ca14e444ed29e3e6a09d14c48d72bf274240a4ceb3e.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_9.jpg', '2025-03-27 15:05:53', '2025-03-27 15:05:53'),
(673, 203, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/10-51dd56b39ad662e9883004af81c6aefc5fbca3128e2c98cfe1cffb88e692b687.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_10.jpg', '2025-03-27 15:05:54', '2025-03-27 15:05:54'),
(674, 203, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/11-6d1a9b12ef4339528a8d6e33f3fc391bc356395a97318255a5f0535ebe81493b.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_11.jpg', '2025-03-27 15:05:55', '2025-03-27 15:05:55'),
(675, 203, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/12-e076a6513d499a1cbe816d5ce2c89cc7815461e06eaf469f15244384a950d3a1.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_12.jpg', '2025-03-27 15:05:55', '2025-03-27 15:05:55'),
(676, 203, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/13-c3609c80a5f560fcbeb706d79a3bd3cfe651ce86abf383c03217ac2e943c0175.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_13.jpg', '2025-03-27 15:05:56', '2025-03-27 15:05:56'),
(677, 203, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/14-59353b2926fa715836dfc8b950a3b0e0bcfa0131bfdc9e3c20e5098d936d2a78.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_14.jpg', '2025-03-27 15:05:57', '2025-03-27 15:05:57'),
(678, 203, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/15-7aa27e8b1f3887b1beab0be2b0739e831509556aef31b93abd7a28ef9ee98e7f.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_15.jpg', '2025-03-27 15:05:57', '2025-03-27 15:05:57'),
(679, 203, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/c3f1500b0d51bad136d8251d0bb366e2/16-d13b09da865cada143f395ff2852a1aa37eb69be08b663c235b6bd1a85e2f8dc.jpg', 'images/chapters/8e7ca2bc-592a-4d96-8f94-3465dc8327a3_page_16.jpg', '2025-03-27 15:05:58', '2025-03-27 15:05:58'),
(680, 204, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/1-a414d81bf8d42a49597d639aaab3fc39b358791f700058a2ffc4159eafd43d8d.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_1.jpg', '2025-03-27 15:06:01', '2025-03-27 15:06:01'),
(681, 204, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/2-18e98d4d43808df5f76dd24e2193471023c4f6c7371873ec88e81ceb0afe810b.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_2.jpg', '2025-03-27 15:06:02', '2025-03-27 15:06:02'),
(682, 204, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/3-b06768e4e0ba9b3be73eea2382b929fad4bbf4f95a0fa774c548ff134dc49f8c.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_3.jpg', '2025-03-27 15:06:02', '2025-03-27 15:06:02'),
(683, 204, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/4-a4cad7242fd805f8b798c0244b2debff64263b21163cf9ffc10f4dabe0084484.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_4.jpg', '2025-03-27 15:06:03', '2025-03-27 15:06:03'),
(684, 204, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/5-64bbdc8b9a20f8528493ca8b520224d64a334722ddf083b4ec79aeacc7441a7e.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_5.jpg', '2025-03-27 15:06:04', '2025-03-27 15:06:04'),
(685, 204, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/6-6e6bf05e5b37fa1368e63c9af5c88be3217dc43c0802b846b4b7aec7f3350963.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_6.jpg', '2025-03-27 15:06:04', '2025-03-27 15:06:04'),
(686, 204, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/7-8a01cbddd7b30fad193c0c0c5507f72626da35255381e8ff763e4bcd9f735475.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_7.jpg', '2025-03-27 15:06:05', '2025-03-27 15:06:05'),
(687, 204, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/8-51067f58b1e95737f11fbf792159a443e8c76f268320eed098a40dcada072c3e.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_8.jpg', '2025-03-27 15:06:06', '2025-03-27 15:06:06'),
(688, 204, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/9-6dc97ef1b70e14060ed4526e68795f6c176e4283f7af743af40cdac925a0355a.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_9.jpg', '2025-03-27 15:06:06', '2025-03-27 15:06:06'),
(689, 204, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/10-cedebff69de3195e890c066479201fc1fde26983c1165d834dc563574453ba62.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_10.jpg', '2025-03-27 15:06:07', '2025-03-27 15:06:07'),
(690, 204, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/11-b4b47531dccb4f3ed1b4d9ac3808bedbd0666a39508fa07836de5589ae4300c5.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_11.jpg', '2025-03-27 15:06:08', '2025-03-27 15:06:08'),
(691, 204, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/12-f1720c8186394dae5c29ad093201a9c5629e79ad8242deb165311e2807917fe5.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_12.jpg', '2025-03-27 15:06:08', '2025-03-27 15:06:08'),
(692, 204, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/13-52614c8b17f5576bf306786cf167953a03dc44ced9145b1a189f52dafce98db7.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_13.jpg', '2025-03-27 15:06:09', '2025-03-27 15:06:09'),
(693, 204, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/14-b7a45bfce93a93fed0c7b1037db29a314ffd7368c9905bbf6e8916969820d790.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_14.jpg', '2025-03-27 15:06:10', '2025-03-27 15:06:10'),
(694, 204, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/15-5253f47199ef8c9ca3cb782062c78aba51ac9d303bff9b36db153c7131825349.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_15.jpg', '2025-03-27 15:06:10', '2025-03-27 15:06:10'),
(695, 204, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/16-71d8b358251be29c2322eace96ee2a9f976498972a09c8228b9102562b249e0e.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_16.jpg', '2025-03-27 15:06:11', '2025-03-27 15:06:11'),
(696, 204, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/b246fac11e85c69c7b2a4ed57faeb0f3/17-b4f807d7d3bd0a366a3d770ad7b0938628a703f1a26dd2842ffc934b6482648c.jpg', 'images/chapters/1f36da9a-2e24-4842-b41d-374aabe4ffaa_page_17.jpg', '2025-03-27 15:06:11', '2025-03-27 15:06:11'),
(697, 205, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/1-b7bbac030fa402f3125615365a92af02a38c58479548a901295a97bc88eb6be5.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_1.jpg', '2025-03-27 15:06:14', '2025-03-27 15:06:14'),
(698, 205, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/2-563e5984716da83266da7215f5fec759dbedeec5f3aec9336b863162c276e263.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_2.jpg', '2025-03-27 15:06:15', '2025-03-27 15:06:15'),
(699, 205, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/3-dd5bcd1470425355b2ff3d6628f8250f1cfb0ef4afec8c196e30ececc583819b.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_3.jpg', '2025-03-27 15:06:16', '2025-03-27 15:06:16'),
(700, 205, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/4-ef781becb58ca9d5282fe3aa74f419c8148d942d7aabb38adb01e2797fe202fd.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_4.jpg', '2025-03-27 15:06:16', '2025-03-27 15:06:16'),
(701, 205, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/5-bf1718891efb0cc44e59940dafedb99fbad4857142c5a15334de00f9b53d661c.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_5.jpg', '2025-03-27 15:06:17', '2025-03-27 15:06:17'),
(702, 205, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/6-320bd60ad83092a67fa917d726b5baf7607ef1f3d9cbec07a4521680948df4ba.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_6.jpg', '2025-03-27 15:06:18', '2025-03-27 15:06:18'),
(703, 205, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/7-7092295b7e469b76a193949a7021a5c0f4b0c222283a55194df065c8668bc1b4.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_7.jpg', '2025-03-27 15:06:18', '2025-03-27 15:06:18'),
(704, 205, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/8-429e302716bec7dae4a190d2b39e0d69c930cfe8399bd895205e4319e0804236.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_8.jpg', '2025-03-27 15:06:19', '2025-03-27 15:06:19'),
(705, 205, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/9-d6a040268362e740568c8cc35c4d7db91a7b40c3293e4ae56ed368f021bdeefd.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_9.jpg', '2025-03-27 15:06:20', '2025-03-27 15:06:20'),
(706, 205, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/10-2f9785aee8de5e2591e8336ad9bcad2aef7698ed1fd276e1fa34903fdbd0af0c.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_10.jpg', '2025-03-27 15:06:21', '2025-03-27 15:06:21'),
(707, 205, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/11-59287de603e3d40f20b4f5ccae5408b391f96acdd90e264517f429ce30177c7c.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_11.jpg', '2025-03-27 15:06:21', '2025-03-27 15:06:21'),
(708, 205, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/12-4d6b896d26cfaff7052eef3ca35c1203b36a409c5eb15ec14c03914055340722.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_12.jpg', '2025-03-27 15:06:22', '2025-03-27 15:06:22'),
(709, 205, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/13-556cd5572031c9a9e485d1adfc62c5881c28897701914cb9ccdb48b0e35b52b2.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_13.jpg', '2025-03-27 15:06:23', '2025-03-27 15:06:23'),
(710, 205, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/14-a43860c1eec9e3550a6aad8d8fdd8eae6cf330f0cc730c3386406aa76d86430f.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_14.jpg', '2025-03-27 15:06:24', '2025-03-27 15:06:24'),
(711, 205, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/15-74709c54100691ffef5fc0a04b8b957332d3a499c6f80ea5c6e3b53f3af2d5ea.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_15.jpg', '2025-03-27 15:06:24', '2025-03-27 15:06:24'),
(712, 205, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/16-3ce7ac9355c904aa2ccad492a5f39739bf03ae2c91b0ecf61bcf4beda2f4499d.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_16.jpg', '2025-03-27 15:06:25', '2025-03-27 15:06:25'),
(713, 205, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/17-cb98dd6dcdec988900189ec86527b93b933b454d11622162f3f49d8bcf701eac.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_17.jpg', '2025-03-27 15:06:26', '2025-03-27 15:06:26'),
(714, 205, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/18-3979a68d4541a278f4a63d530a7ef074dde972433bb9db66a47752f5a5f2a26e.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_18.jpg', '2025-03-27 15:06:26', '2025-03-27 15:06:26'),
(715, 205, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/19-7a02217c54f2b994388884cd61a84df79e89b4c5b440cbf09745ad81702ab2ac.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_19.jpg', '2025-03-27 15:06:27', '2025-03-27 15:06:27'),
(716, 205, 20, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/20-f35fd32608538528ff7a629ca187c9719d74ad529d4e06b00f211bc3d74f26b6.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_20.jpg', '2025-03-27 15:06:28', '2025-03-27 15:06:28'),
(717, 205, 21, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/21-1e1503051752a314d9babd7aa8b51ed2b90119efc400ee120a3bc3fb3710e613.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_21.jpg', '2025-03-27 15:06:29', '2025-03-27 15:06:29'),
(718, 205, 22, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/22-17692236a5e653a5159de5fc9729a3982c32bd02849ad512b6b6296e91cc1e05.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_22.jpg', '2025-03-27 15:06:29', '2025-03-27 15:06:29'),
(719, 205, 23, 'https://cmdxd98sb0x3yprd.mangadex.network/data/5b0b88b0ed13218765fccf52115336aa/23-165a6b64f990b8c2321172860f0a2e65afd056bdcbc499f134d852609c51b459.jpg', 'images/chapters/d8c26bcc-d621-446a-b82d-c034c2fe1e4a_page_23.jpg', '2025-03-27 15:06:30', '2025-03-27 15:06:30'),
(720, 206, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/1-294b3c53b967692042ea4192e95de898fb717bf83a0862181c166f48e6056ad1.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_1.jpg', '2025-03-27 15:06:33', '2025-03-27 15:06:33'),
(721, 206, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/2-0bf65ee3ca622000116d877533bbfdbd9dac45016a9e446b66f4454ba525de2a.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_2.jpg', '2025-03-27 15:06:34', '2025-03-27 15:06:34'),
(722, 206, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/3-3fe2ae3063d7b53fc507eec4e4effaf25bdcf7ba6a238cd06a0fa018ab8e60c3.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_3.jpg', '2025-03-27 15:06:35', '2025-03-27 15:06:35'),
(723, 206, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/4-56383b6f91ff7474ccba67bbc946b90818cf3d347dc896b5986a36d81d8ad432.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_4.jpg', '2025-03-27 15:06:36', '2025-03-27 15:06:36'),
(724, 206, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/5-0e7ccfd8e0a5a12955b5d72cb598f01bdd30ceb6b690a006d2c933d98fc1c50d.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_5.jpg', '2025-03-27 15:06:37', '2025-03-27 15:06:37'),
(725, 206, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/6-4433865f8935b29f010e1fb3b274bc2c83f0a33a2f5f9236b5b9db2622e98494.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_6.jpg', '2025-03-27 15:06:38', '2025-03-27 15:06:38'),
(726, 206, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/7-f2ea872af9fa67e42bdb02b9e266cc3206142f357de1e9be77b31739385a5e71.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_7.jpg', '2025-03-27 15:06:38', '2025-03-27 15:06:38'),
(727, 206, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/8-1395de12b69e975268558806fed39145fe9de7d77a9e2eea3e593719917122b2.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_8.jpg', '2025-03-27 15:06:39', '2025-03-27 15:06:39'),
(728, 206, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/9-54434a4fd97063a14bdd2e455aec7e70a0eac94f0c121c6925acb3637192e9e3.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_9.jpg', '2025-03-27 15:06:40', '2025-03-27 15:06:40'),
(729, 206, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/10-9b65c2c318ceb558a7e5698b6a38d98e2bfa911e2de58dfd5b9e62866492c1e3.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_10.jpg', '2025-03-27 15:06:41', '2025-03-27 15:06:41'),
(730, 206, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/11-01504d7056b07f32de6553b63bfb0ae29cfef1b729cbf5d43c94f8e0f4375579.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_11.jpg', '2025-03-27 15:06:42', '2025-03-27 15:06:42'),
(731, 206, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/12-48dee7fc38f153ee3699b907be8e7b112d0fa16c6f74f28973c738aaf3229d57.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_12.jpg', '2025-03-27 15:06:43', '2025-03-27 15:06:43'),
(732, 206, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/13-05860c22162115cf352996cf05d20680d6c762339fcecca116abb096bca3e407.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_13.jpg', '2025-03-27 15:06:43', '2025-03-27 15:06:43'),
(733, 206, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/14-c08ad24fda875cbe7af50991f3f06ab8820fa5bb35383cb7f6a81e780b4c69bb.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_14.jpg', '2025-03-27 15:06:44', '2025-03-27 15:06:44'),
(734, 206, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/15-d3bb094a39baefaa672d3b1871d8604e8af2dd531e5c69e4a154e85e61de8271.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_15.jpg', '2025-03-27 15:06:45', '2025-03-27 15:06:45'),
(735, 206, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/16-5520e8ccc977c132dcc0b9400f927f5e6c1eed31a88d6d2041c057dbc472464c.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_16.jpg', '2025-03-27 15:06:46', '2025-03-27 15:06:46'),
(736, 206, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/17-0fd058e9d1a123f9da50757b93a0d076af553e6751c5a69a44c8e34559512f32.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_17.jpg', '2025-03-27 15:06:46', '2025-03-27 15:06:46'),
(737, 206, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/18-ca124746ffc63ad8627434cd6456ec842c5c415f9b8f7b15a97dc50848ed7f99.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_18.jpg', '2025-03-27 15:06:47', '2025-03-27 15:06:47'),
(738, 206, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/19-04e765685c8ac28c7cd5dc18487e111ec1082b7926d9a4207badadaf6fde95ac.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_19.jpg', '2025-03-27 15:06:48', '2025-03-27 15:06:48'),
(739, 206, 20, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/20-59830d08972c338fd677230279c59015d6d223a84424bac55dae141519e9efef.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_20.jpg', '2025-03-27 15:06:49', '2025-03-27 15:06:49'),
(740, 206, 21, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d925950ce89e1fa4a808945dfa8ef998/21-6de989fd7b72a87859b91a913e296a435479b89d2af1f27d571c9bc5cf441f57.png', 'images/chapters/6c4a2671-c0dc-49aa-855d-d75ff6cf1226_page_21.jpg', '2025-03-27 15:06:50', '2025-03-27 15:06:50'),
(741, 207, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/1-1f6b867afc7eff1ed73715cf0260e7a478d5e11fab893cd1224eb179520121d2.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_1.jpg', '2025-03-27 15:06:53', '2025-03-27 15:06:53'),
(742, 207, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/2-3c7d3a47d54f71f8f52f4f0b5d3537bf48ea80eeada467d310bfea73307d75b8.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_2.jpg', '2025-03-27 15:06:53', '2025-03-27 15:06:53'),
(743, 207, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/3-16b5a7f7c7b549799fb4242fffcad7dd83a6344bcaadd3f09290ed2561b6d57a.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_3.jpg', '2025-03-27 15:06:54', '2025-03-27 15:06:54'),
(744, 207, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/4-b0e0edf2bc939b5013425c1dbd2181d6e19ba581cc52321c4ac164d75b272f33.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_4.jpg', '2025-03-27 15:06:55', '2025-03-27 15:06:55'),
(745, 207, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/5-9dbc01df8f902081aa66f5e7f42ad645acec6f5de6ff2491f4242669aa6c55ae.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_5.jpg', '2025-03-27 15:06:55', '2025-03-27 15:06:55'),
(746, 207, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/6-59e4ce512a2c1ea46fa675014ea5f505e71b714aaee41956f6f53edaf6e89464.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_6.jpg', '2025-03-27 15:06:56', '2025-03-27 15:06:56'),
(747, 207, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/7-339e80c6db5fcddf9c09848705dc1f932f16aadd99f0e83e6126e0e5329d5377.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_7.jpg', '2025-03-27 15:06:57', '2025-03-27 15:06:57'),
(748, 207, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/8-958bbe6ac876fbb3b17dcc22d1e984f01e94f27cda9f85136dcf1e01f13d7c3a.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_8.jpg', '2025-03-27 15:06:58', '2025-03-27 15:06:58'),
(749, 207, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/9-cd40326361fba904957eba71139c13392ce47da18abf8cbb2a3b796b99c421d1.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_9.jpg', '2025-03-27 15:06:58', '2025-03-27 15:06:58'),
(750, 207, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/10-1422220ba15a64149d694c5f5aef65f1a4291f652696ef0c5c0af580459d962e.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_10.jpg', '2025-03-27 15:06:59', '2025-03-27 15:06:59'),
(751, 207, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/11-216cb6e3322a87f39186fe44ef7aaf5833edba37b4840a7e0ccaebe28e9518c0.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_11.jpg', '2025-03-27 15:07:00', '2025-03-27 15:07:00'),
(752, 207, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/12-bf437fd56c087916b3eb6a1337dcb9b691935127e75380c89fee6c20cbab1c07.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_12.jpg', '2025-03-27 15:07:00', '2025-03-27 15:07:00'),
(753, 207, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/13-8e66378103304aa9ae977b7a43f21f3d0a57a7982ff9cb2afa0029612ad2536c.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_13.jpg', '2025-03-27 15:07:01', '2025-03-27 15:07:01'),
(754, 207, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/14-9629cc71d9c2088420c64811914be7afd95b30b12a8c64a279474bfd2cbfae9e.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_14.jpg', '2025-03-27 15:07:02', '2025-03-27 15:07:02'),
(755, 207, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/15-73c5ff1a8a616e33cf3f578d66aaa3934ad953c6ab3794fec5f08b4e1fe4e822.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_15.jpg', '2025-03-27 15:07:02', '2025-03-27 15:07:02'),
(756, 207, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/16-88fa11bf622b5ce014e7a19127aeb9d0a85f3e6b3052a4748f68f92e6bb6c632.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_16.jpg', '2025-03-27 15:07:03', '2025-03-27 15:07:03'),
(757, 207, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/17-6a96311588502b53f51339147efd285fb1b5d354b2fae2f89bd795a30300c513.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_17.jpg', '2025-03-27 15:07:04', '2025-03-27 15:07:04'),
(758, 207, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/18-6083125beb633c84daa3fc75090806009eb198ac47a18889a460950ea1330624.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_18.jpg', '2025-03-27 15:07:05', '2025-03-27 15:07:05'),
(759, 207, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/19-45989377669a9021043f7ec6e505066e6aaf8e62d32e1cf912076ddc6b6ac513.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_19.jpg', '2025-03-27 15:07:05', '2025-03-27 15:07:05'),
(760, 207, 20, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/20-7e9ec934609dcd5273e9db235cc07777030d905d848ec32192e51fcc2ec6a973.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_20.jpg', '2025-03-27 15:07:06', '2025-03-27 15:07:06'),
(761, 207, 21, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/21-ce6976cbf7895422e2ff5a5225db1a678dc9fb96074b8b69028742832ab7a6fd.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_21.jpg', '2025-03-27 15:07:07', '2025-03-27 15:07:07'),
(762, 207, 22, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/22-d4f5f39b0be031114217a87545796c470f621d5f78a41e74f50ee09d04997f8f.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_22.jpg', '2025-03-27 15:07:08', '2025-03-27 15:07:08'),
(763, 207, 23, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/23-9c2a2b590f4d5507ae4de0dca6aae2ff0b600bdc0ad81d5a79fca6fe3dd1e02b.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_23.jpg', '2025-03-27 15:07:08', '2025-03-27 15:07:08'),
(764, 207, 24, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/24-8c4997f6929c2eb58968e06401c9d17bbe3233bb72f92fa26989b11ef319fd1b.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_24.jpg', '2025-03-27 15:07:09', '2025-03-27 15:07:09'),
(765, 207, 25, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/25-413529840701b9f0f37d4d73877319a098cb8f14d69e0373021a87a2e0a911b9.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_25.jpg', '2025-03-27 15:07:10', '2025-03-27 15:07:10'),
(766, 207, 26, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/26-57bbda62276b07b8b7a2748d53f1f690c37286986a9d56b459322c4a1297dd37.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_26.jpg', '2025-03-27 15:07:10', '2025-03-27 15:07:10'),
(767, 207, 27, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/27-eae9cbb758831aa958d342bed64e852f5d6b3dd29da948267080cce2a68deae4.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_27.jpg', '2025-03-27 15:07:11', '2025-03-27 15:07:11'),
(768, 207, 28, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/28-f7f8ebb0d57eacee339f6348a70ffcce898ebfec448bde2ce2edcf9db12a63b5.gif', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_28.jpg', '2025-03-27 15:07:12', '2025-03-27 15:07:12'),
(769, 207, 29, 'https://cmdxd98sb0x3yprd.mangadex.network/data/71839c95305632ca5f600af65a6ccb92/29-2b551fb9e331115f987fa0b5d5f94aa4a19d63e2efa5a0c329c89d6ed1d31c4b.jpg', 'images/chapters/5e2d3ca7-0d56-4d22-b8af-e986c3c8278f_page_29.jpg', '2025-03-27 15:07:13', '2025-03-27 15:07:13'),
(3241, 290, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/1-79107fb617e198dc1db839a6d58f351a67323950d06d9c7209d21dd1cd9da633.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_1.jpg', '2025-03-30 08:07:03', '2025-03-30 08:07:03'),
(3242, 290, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/2-2365e87ba5345e81aac5ee98421b3a474d9e09c037ee0a7f5bd20dd61b38eae5.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_2.jpg', '2025-03-30 08:07:04', '2025-03-30 08:07:04'),
(3243, 290, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/3-799b48c3e57551e58309146ee84102f1ef13f20177c213ed62699c0f526acf26.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_3.jpg', '2025-03-30 08:07:06', '2025-03-30 08:07:06'),
(3244, 290, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/4-47f64b127b82bd8dd624b8ad0b55db33a8a04877fecd902aa40045e3f89caece.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_4.jpg', '2025-03-30 08:07:07', '2025-03-30 08:07:07'),
(3245, 290, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/5-6d471a4107aecc7edd07b1b3ca65d4d070c62f197646c0a209f03209d05beff1.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_5.jpg', '2025-03-30 08:07:08', '2025-03-30 08:07:08'),
(3246, 290, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/6-d6977877ed8530746841c1cf9adb5a0adc28acb2f09aa40bd7f327eb5d0a5f66.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_6.jpg', '2025-03-30 08:07:09', '2025-03-30 08:07:09'),
(3247, 290, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/7-5f57394d5f2040c9adde7a24d78a3885d1b3ec7258e91e5ac2b11f78098effd0.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_7.jpg', '2025-03-30 08:07:11', '2025-03-30 08:07:11'),
(3248, 290, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/8-d0167aa4986d6531aa880c6970f60789eb0bbed27a95c25ea67f30114f01cb37.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_8.jpg', '2025-03-30 08:07:12', '2025-03-30 08:07:12'),
(3249, 290, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/9-b80e143c05d56e6163e21891866b8aaac4689864757a8a14b9664139e028dab4.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_9.jpg', '2025-03-30 08:07:13', '2025-03-30 08:07:13'),
(3250, 290, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/10-9e30afe8500e43b9aabfbb8f5d67abb515ed5d18e09ec15c9b72c11fdc2d8f07.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_10.jpg', '2025-03-30 08:07:14', '2025-03-30 08:07:14'),
(3251, 290, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/11-2a5c94d357d3697d9ba316583f5efdf52dc964a0bf19e897ad9c20963ebbb524.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_11.jpg', '2025-03-30 08:07:16', '2025-03-30 08:07:16'),
(3252, 290, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/12-7b8f094f5332d25405b57b7574af979110e20d98d99c055aec6bf27e7aa11833.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_12.jpg', '2025-03-30 08:07:17', '2025-03-30 08:07:17'),
(3253, 290, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/13-285f6b8ddfd15720bb53f0d825f9f746a819629f6c6ba98bb229a6b42259b1bb.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_13.jpg', '2025-03-30 08:07:18', '2025-03-30 08:07:18'),
(3254, 290, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/14-8e56b1c466edffaa8e4a394a171d04667f36a10f224836b59c5c5d4753e2b318.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_14.jpg', '2025-03-30 08:07:19', '2025-03-30 08:07:19'),
(3255, 290, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/15-0cdadccb72941a2a0d749c63e51aeaee42ac496eea9f80855f1d0c5a4d491451.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_15.jpg', '2025-03-30 08:07:21', '2025-03-30 08:07:21'),
(3256, 290, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/16-24bf69955fe144db1fed51babb62693796c44f5a883cc79bec3fd04ca342cc91.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_16.jpg', '2025-03-30 08:07:22', '2025-03-30 08:07:22'),
(3257, 290, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/17-b5bdfe2d0debff652497d693372cc5f310eab38e2aa16c9796443a9c581ff00e.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_17.jpg', '2025-03-30 08:07:23', '2025-03-30 08:07:23'),
(3258, 290, 18, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/18-c1fda06198fed67b6d0459b8c189e812c905c5ae58363525a9053dbab7932f81.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_18.jpg', '2025-03-30 08:07:25', '2025-03-30 08:07:25'),
(3259, 290, 19, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/19-89b076cd68162213101e2c9825693e4aecdbe85fec17ef6c53efccb5640e72ec.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_19.jpg', '2025-03-30 08:07:26', '2025-03-30 08:07:26'),
(3260, 290, 20, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/20-cbc6bcb06290e12bbadbeb62969963e5a2de00401d76342119425ea969df34dc.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_20.jpg', '2025-03-30 08:07:27', '2025-03-30 08:07:27'),
(3261, 290, 21, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/21-b2b456f57cdbde96d7e06df1e09c9577723cff83fa0ca28a1a33260a79806710.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_21.jpg', '2025-03-30 08:07:28', '2025-03-30 08:07:28'),
(3262, 290, 22, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/22-570f75e67e9e50fbdb3c097b3d41e00b6662bb2496c84e015c8c1ad4e5c90d87.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_22.jpg', '2025-03-30 08:07:30', '2025-03-30 08:07:30'),
(3263, 290, 23, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/23-b8286ec5bb9c51f2400d017ad13115d4945f7f03c8a954994f55d9010929762a.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_23.jpg', '2025-03-30 08:07:31', '2025-03-30 08:07:31'),
(3264, 290, 24, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/24-7908fe217b04ce22101c271708d13c749377afb0b9a8a2f9e83a2dca9f7c80b2.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_24.jpg', '2025-03-30 08:07:33', '2025-03-30 08:07:33'),
(3265, 290, 25, 'https://cmdxd98sb0x3yprd.mangadex.network/data/bfc7ae312f686c86587d5dc6151e89f5/25-4f5acb4d0d810d66d11598965f0879c7de8ed1cd79403bb578ff059f211e1f96.jpg', 'images/chapters/e9ba48d7-4bee-4ff8-b569-332996719047_page_25.jpg', '2025-03-30 08:07:34', '2025-03-30 08:07:34'),
(11501, 568, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/1-2e409cbb922a87611fa20011bb6633595ce2fd75025e9178d7350462b8a0ea86.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_1.jpg', '2025-03-31 05:51:07', '2025-03-31 05:51:07'),
(11502, 568, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/2-6f58ff124f1c1d5e40e585c1ee4bdde6fc8ba433002750e42bb8a5ced6e64ab9.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_2.jpg', '2025-03-31 05:51:08', '2025-03-31 05:51:08'),
(11503, 568, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/3-c339f129eca462d7fd40eca0ef039abcc8799fa9a7ece398e9da8184bc75b7fd.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_3.jpg', '2025-03-31 05:51:08', '2025-03-31 05:51:08'),
(11504, 568, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/4-efcfe94d52cbc851440c476499424c32d19e1563b861bdbe41ec69a83d158e1c.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_4.jpg', '2025-03-31 05:51:09', '2025-03-31 05:51:09'),
(11505, 568, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/5-cc31c442cc5b2240e13d5b29fc7bf0744886a4e72e7aee6ff9248b8d3d3206a9.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_5.jpg', '2025-03-31 05:51:10', '2025-03-31 05:51:10'),
(11506, 568, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/6-6d3568054db310bddf0fb1a92b4653e3688d81d119b3980dab6eeafeaed29b15.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_6.jpg', '2025-03-31 05:51:10', '2025-03-31 05:51:10'),
(11507, 568, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/7-ebafcb08782c9329071843c9156ca829f83e8c8fdfb87eaf071ba6a6fa34f7f7.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_7.jpg', '2025-03-31 05:51:11', '2025-03-31 05:51:11'),
(11508, 568, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/8-7abb12daafdf2e5321bbbe60cf28888e5256a29467df7e00b6db7142bca6591e.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_8.jpg', '2025-03-31 05:51:12', '2025-03-31 05:51:12'),
(11509, 568, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/d08841a2fb93886fc62d5ce44325d0bd/9-53ebe2742c33fb4e17b4b003ca82ec84635d9d617f6299feb17924f10114dc3c.jpg', 'images/chapters/1cd905c1-0c56-496b-99c9-b907cfc41610_page_9.jpg', '2025-03-31 05:51:12', '2025-03-31 05:51:12'),
(14528, 683, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/1-67ff3726ed514bb29a7d334def4f62e8a79a145761bba0ebe42b4d34df8d05c9.jpg', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_1.jpg', '2025-04-05 08:39:09', '2025-04-05 08:39:09'),
(14529, 683, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/2-e543d1b7e3d4ad52e25881e2f3c60cc012a82d04b85e111b5e4a4087753359b6.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_2.jpg', '2025-04-05 08:39:12', '2025-04-05 08:39:12'),
(14530, 683, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/3-601b3306fdeeb0e9808901eb4f468ccc0606bcba5b77603ce179aac7b5c1aa58.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_3.jpg', '2025-04-05 08:39:14', '2025-04-05 08:39:14'),
(14531, 683, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/4-5dd080f08ec203cbcc289ab57cb9959df6d9671f44a1e4eee4103bb342555a98.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_4.jpg', '2025-04-05 08:39:16', '2025-04-05 08:39:16'),
(14532, 683, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/5-2b4e3e675845e652cc2f130b3ee19b0fc039d0b2c0b0a227adcaf2de01a03a4e.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_5.jpg', '2025-04-05 08:39:18', '2025-04-05 08:39:18'),
(14533, 683, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/6-615409be7af7e568c7c56aa6a990e09e56e5c03bf7d6e260d08c187ba6dfc105.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_6.jpg', '2025-04-05 08:39:19', '2025-04-05 08:39:19'),
(14534, 683, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/7-148fbce1fbb84793ff57739be5a8122f46d08880d433be5b886a3666ca3c12e7.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_7.jpg', '2025-04-05 08:39:21', '2025-04-05 08:39:21'),
(14535, 683, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/8-b962b6a6e779a8dc7b3c434f15b618f50ef26d604663e0ae9a40669361e4d943.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_8.jpg', '2025-04-05 08:39:23', '2025-04-05 08:39:23'),
(14536, 683, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/9-fca3843e931363d4314e03fd26505f192e83759c960081327e01073ca52b6869.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_9.jpg', '2025-04-05 08:39:25', '2025-04-05 08:39:25'),
(14537, 683, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/10-2f8a874780adf8bf3fbcf3884fb720b053ad6ab537299fa63aef6aed53abdfe5.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_10.jpg', '2025-04-05 08:39:27', '2025-04-05 08:39:27'),
(14538, 683, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/11-017f06e7c4909587a3ff475218ca07f9ceb781158d5a3e5bb281bc41d5f613f2.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_11.jpg', '2025-04-05 08:39:29', '2025-04-05 08:39:29'),
(14539, 683, 12, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/12-087910e30a2813593d5c26690120a803e4545c7c3eed541c72910386e1b441cd.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_12.jpg', '2025-04-05 08:39:31', '2025-04-05 08:39:31'),
(14540, 683, 13, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/13-bee67bd60b14965c8048e1bd507d0348a1cb45318659a76cf5e5c79e3dba5f32.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_13.jpg', '2025-04-05 08:39:33', '2025-04-05 08:39:33'),
(14541, 683, 14, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/14-64cb3b10181281a1cbf7732f6cb2923990155fe4c4fe81d8fd6a6f5e31fb670c.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_14.jpg', '2025-04-05 08:39:35', '2025-04-05 08:39:35'),
(14542, 683, 15, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/15-db51546e33025b610394140c9b247fd8b1e47dd63090760eac55c6efddc82255.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_15.jpg', '2025-04-05 08:39:37', '2025-04-05 08:39:37'),
(14543, 683, 16, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/16-b4444d44f2c4015d2a3cbea59d4e8696bba0f6f93cf9aee634f4d1a64b14019e.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_16.jpg', '2025-04-05 08:39:40', '2025-04-05 08:39:40'),
(14544, 683, 17, 'https://cmdxd98sb0x3yprd.mangadex.network/data/f97f12936d25f2c96f5d33bbebd8a3fd/17-fa517fb20978a0e6318a40e44e74bb2835eab67bb47579254c93a681a752868e.png', 'images/chapters/410a7e8f-2398-48a4-a8c0-94fe41a3d6aa_page_17.jpg', '2025-04-05 08:39:42', '2025-04-05 08:39:42'),
(14609, 686, 1, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/1-2068caf0d7af3ce8b9a3fcf51638c42be36366cfd1b6c60359a58ba9b863612e.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_1.jpg', '2025-04-05 08:42:35', '2025-04-05 08:42:35'),
(14610, 686, 2, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/2-8bada2e70e86533c945b1290e5c732061c4a3e241dd2e267dae60cfe55b39bd8.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_2.jpg', '2025-04-05 08:42:35', '2025-04-05 08:42:35'),
(14611, 686, 3, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/3-7b39c45b45149a10ddc1a97623d4cab733d7212c5d394356d6ddcf24cc175978.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_3.jpg', '2025-04-05 08:42:36', '2025-04-05 08:42:36'),
(14612, 686, 4, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/4-e1825eecfc274e3a4309992175783d3f2d66fc27ab92081959b7e106ac074808.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_4.jpg', '2025-04-05 08:42:37', '2025-04-05 08:42:37');
INSERT INTO `chapter_images` (`id`, `chapter_id`, `page_number`, `image_url`, `local_path`, `created_at`, `updated_at`) VALUES
(14613, 686, 5, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/5-1e79a810fba5bafa1e02f173520bb47a0a8ac54179d1a45768421f2cd970445d.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_5.jpg', '2025-04-05 08:42:38', '2025-04-05 08:42:38'),
(14614, 686, 6, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/6-9268e3dd6266b470513fe226df5c2e42ee1c18fb559fe421601d0ba6598b0146.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_6.jpg', '2025-04-05 08:42:39', '2025-04-05 08:42:39'),
(14615, 686, 7, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/7-d90e57a5758550e2b7d513680631c02f6ee906f8d71880f44b5a8f4f1cd11a90.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_7.jpg', '2025-04-05 08:42:40', '2025-04-05 08:42:40'),
(14616, 686, 8, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/8-84a2b29a27fc38c71486e76b63520d38bf87899ecf38b1c81741c2b05bdf17fb.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_8.jpg', '2025-04-05 08:42:41', '2025-04-05 08:42:41'),
(14617, 686, 9, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/9-c4386a3a73aca6fbf85edb3a4fa9a1ca25115cabf0503d8f94392d6066bb8b45.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_9.jpg', '2025-04-05 08:42:42', '2025-04-05 08:42:42'),
(14618, 686, 10, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/10-3c83e953a07dc1ec1573903ba3571fcf7b9624efeb5dfbc5a00f9b61ba46fd7c.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_10.jpg', '2025-04-05 08:42:44', '2025-04-05 08:42:44'),
(14619, 686, 11, 'https://cmdxd98sb0x3yprd.mangadex.network/data/ebeb975ad3f75031a03df72d162d73c6/11-0e6b51c9c202aac7f884f759b825a242ecbf0401f5c71295ed86b76c0ee9f087.png', 'images/chapters/ec6d3763-a6c0-4bac-bb19-e5ac1e53ae75_page_11.jpg', '2025-04-05 08:42:46', '2025-04-05 08:42:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manga`
--

CREATE TABLE `manga` (
  `id` int(11) NOT NULL,
  `mangadex_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('ongoing','completed','hiatus','cancelled','unknown') DEFAULT 'unknown',
  `year` int(11) DEFAULT NULL,
  `content_rating` enum('safe','suggestive','erotica','pornographic','unknown') DEFAULT 'unknown',
  `cover_url` varchar(512) DEFAULT 'http://localhost/Comic/assets/images/default.jpg',
  `author` varchar(255) DEFAULT 'Unknown Author',
  `latest_chapter` varchar(50) DEFAULT NULL,
  `newest_upload_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `followed_count` int(11) DEFAULT 0,
  `average_rating` float DEFAULT 0,
  `background_gif` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `manga`
--

INSERT INTO `manga` (`id`, `mangadex_id`, `title`, `description`, `status`, `year`, `content_rating`, `cover_url`, `author`, `latest_chapter`, `newest_upload_date`, `created_at`, `updated_at`, `followed_count`, `average_rating`, `background_gif`) VALUES
(1, '32d76d19-8a05-4db0-9fc2-e0b0648fe9d0', 'Solo Leveling', '10 years ago, after “the Gate” that connected the real world with the monster world opened, some of the ordinary, everyday people received the power to hunt monsters within the Gate. They are known as “Hunters”. However, not all Hunters are powerful. My name is Sung Jin-Woo, an E-rank Hunter. I’m someone who has to risk his life in the lowliest of dungeons, the “World’s Weakest”. Having no skills whatsoever to display, I barely earned the required money by fighting in low-leveled dungeons… at least until I found a hidden dungeon with the hardest difficulty within the D-rank dungeons! In the end, as I was accepting death, I suddenly received a strange power, a quest log that only I could see, a secret to leveling up that only I know about! If I trained in accordance with my quests and hunted monsters, my level would rise. Changing from the weakest Hunter to the strongest S-rank Hunter!\n\n---\n**Links:**\n\n- Official English Translation [<Pocket Comics>](https://www.pocketcomics.com/comic/320) | [<WebNovel>](https://www.webnovel.com/comic/only-i-level-up-(solo-leveling)_15227640605485101) | [<Tapas>](https://tapas.io/series/solo-leveling-comic/info)\n- Alternate Official Raw - [Kakao Webtoon](https://webtoon.kakao.com/content/나-혼자만-레벨업/2320)', 'completed', 2018, 'safe', 'https://uploads.mangadex.org/covers/32d76d19-8a05-4db0-9fc2-e0b0648fe9d0/e90bdc47-c8b9-4df7-b2c0-17641b645ee1.jpg', 'h-goon (현군)', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:37:06', 304515, 9.3576, 'action.gif'),
(2, '77bee52c-d2d6-44ad-a33a-1734c1fe696a', 'Kage no Jitsuryokusha ni Naritakute!', 'Just like how everyone adored heroes in their childhood, a certain young man adored those powers hidden in shadows. Ninjas, rogues, shadowy mentor types, that sort of deal.  \r\nAfter hiding his strength and living the mediocre life of a NPC by day while undergoing frenzied training by night, he finally reincarnates into a different world and gains ultimate power.  \r\nThe young man who is only pretending to be a power in the shadows… his subordinates who took him more seriously than he expected… and a giant organization in the shadows that gets accidentally trampled…  \r\nThis is the story of a young boy who had adored powers in shadows possibly eventually reigning over the world of shadows in another world.', 'ongoing', 2018, 'safe', 'https://uploads.mangadex.org/covers/77bee52c-d2d6-44ad-a33a-1734c1fe696a/3e07507b-3425-48ee-baf0-83603a098487.jpg', 'Sakano Anri', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:30:12', 219649, 9.1861, 'action.gif'),
(3, 'e78a489b-6632-4d61-b00b-5206f5b8b22b', 'Tensei Shitara Slime Datta Ken', 'The ordinary Mikami Satoru found himself dying after being stabbed by a slasher. It should have been the end of his meager 37 years, but he found himself deaf and blind after hearing a mysterious voice.  \nHe had been reincarnated into a slime!  \n  \nWhile complaining about becoming the weak but famous slime and enjoying the life of a slime at the same time, Mikami Satoru met with the Catastrophe-level monster “Storm Dragon Veldora”, and his fate began to move.\n\n---\n**Links:**\n- Alternative Official English - [K MANGA](https://kmanga.kodansha.com/title/10044/episode/317350) (U.S. Only), [INKR](https://comics.inkr.com/title/233-that-time-i-got-reincarnated-as-a-slime), [Azuki](https://www.azuki.co/series/that-time-i-got-reincarnated-as-a-slime), [Coolmic](https://coolmic.me/titles/587), [Manga Planet](https://mangaplanet.com/comic/618e32db10673)', 'ongoing', 2015, 'safe', 'https://uploads.mangadex.org/covers/e78a489b-6632-4d61-b00b-5206f5b8b22b/67de8b2f-c080-4006-91dd-a3b87abdb7fd.jpg', 'Fuse', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:30:13', 204344, 9.2971, 'action.gif'),
(4, 'b0b721ff-c388-4486-aa0f-c2b0bb321512', 'Sousou no Frieren', 'The adventure is over but life goes on for an elf mage just beginning to learn what living is all about. Elf mage Frieren and her courageous fellow adventurers have defeated the Demon King and brought peace to the land. With the great struggle over, they all go their separate ways to live a quiet life. But as an elf, Frieren, nearly immortal, will long outlive the rest of her former party. How will she come to terms with the mortality of her friends? How can she find fulfillment in her own life, and can she learn to understand what life means to the humans around her? Frieren begins a new journey to find the answer.', 'hiatus', 2020, 'safe', 'https://uploads.mangadex.org/covers/b0b721ff-c388-4486-aa0f-c2b0bb321512/f6fb40bf-f4e5-4163-a2c7-f103200873c3.jpg', 'Yamada Kanehito', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:37:08', 190098, 9.5423, 'fantasy.gif'),
(5, 'a96676e5-8ae2-425e-b549-7f15dd34a6d8', 'Komi-san wa Komyushou Desu.', 'Komi-san is a beautiful and admirable girl that no one can take their eyes off of. Almost the whole school sees her as the cold beauty that\'s out of their league, but Tadano Hitohito knows the truth: she\'s just really bad at communicating with others.\n\nKomi-san, who wishes to fix this bad habit of hers, tries to improve it with the help of Tadano-kun by achieving her goal of having 100 friends.\n\n---\n**Links:**\n- Alternative Official English - [VIZ Manga Chapters](https://www.viz.com/vizmanga/chapters/komi-cant-communicate)', 'completed', 2016, 'safe', 'https://uploads.mangadex.org/covers/a96676e5-8ae2-425e-b549-7f15dd34a6d8/f8f44329-1dd7-4301-9ec7-a4a76182e8eb.jpg', 'Oda Tomohito', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:40:55', 171683, 8.9729, 'romance.gif'),
(6, 'eb2d1a45-d4e7-4e32-a171-b5b029c5b0cb', 'Kumo Desu ga, Nani ka?', 'When a mysterious explosion killed an entire class full of high school students, the souls of everyone in class were transported into a fantasy world and reincarnated. While some students were reincarnated as princes or prodigies, others were not as blessed.  \nOur heroine, who was the lowest in the class, discovered that she was reincarnated as a spider! Now at the bottom of the food chain, she needs to adapt to the current situation with willpower in order to live. Stuck in a dangerous labyrinth filled with monsters, it\'s eat or be eaten!  \nThis is the story of a spider doing whatever she can in order to survive!', 'ongoing', 2015, 'safe', 'https://uploads.mangadex.org/covers/eb2d1a45-d4e7-4e32-a171-b5b029c5b0cb/1c3917ec-7cb3-4786-bcf2-d259c89562d7.jpg', 'Baba Okina', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:30:14', 153163, 8.9631, 'action.gif'),
(7, '6670ee28-f26d-4b61-b49c-d71149cd5a6e', 'Mieruko-chan', 'All of a sudden, Miko is able to see grotesque monsters all around her; but no one else can. Rather than trying to run away or face them, she instead musters all of her courage and... ignores them. Join in on her day-to-day life as she keeps up her best poker face despite the supernatural goings-on.\n___\n**Alt Official Raw:** [niconico Manga](http://manga.nicovideo.jp/comic/37662)', 'ongoing', 2018, 'safe', 'https://uploads.mangadex.org/covers/6670ee28-f26d-4b61-b49c-d71149cd5a6e/bd7e79a1-5a29-46e8-b402-765e7f01ff9b.jpg', 'Izumi Tomoki', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:37:10', 134822, 9.3123, 'comedy.gif'),
(8, '878634d2-ea39-4001-a4bf-31458020d16a', 'Akuyaku Reijou Level 99: Watashi wa UraBoss desu ga Maou de wa Arimasen', 'I reincarnated as the \"Villainess Eumiella\" from an RPG Otome game. In the main story, Eumiella is merely a side character, but after the ending, she re-enters the story as the Hidden Boss, a character boasting high stats on par with the heroes! \n\nLighting a fire in my gamer\'s soul, and taking advantage of being left on my own in my parent\'s territory, I trained, trained, and trained! As a result of my training… by the time I enrolled in the academy, I managed to reach level 99. \n\nThough I had planned to live out my days as inconspicuously and peacefully as possible, soon after entering the school, I\'m suspected by the Heroine and Love Interests of being the \"Demon Lord\"…?  \n  \nBased on a popular web novel of seeking a peaceful life, a fantasy story of the strongest villainess!\n\n---\n**Links:**\n- Alternative Official Raw - [Niconico](https://manga.nicovideo.jp/comic/46067)', 'ongoing', 2020, 'safe', 'https://uploads.mangadex.org/covers/878634d2-ea39-4001-a4bf-31458020d16a/ab903f92-b3d9-4ce3-9332-d5cffa35cf67.jpg', 'Tanabata Satori', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:40:56', 135804, 8.87, 'action.gif'),
(9, 'c52b2ce3-7f95-469c-96b0-479524fb7a1a', 'Jujutsu Kaisen', 'For some strange reason, Yuji Itadori, despite his insane athleticism would rather just hang out with the Occult Club. However, he soon finds out that the occult is as real as it gets when his fellow club members are attacked!\n\nMeanwhile, the mysterious Megumi Fushiguro is tracking down a special-grade cursed object, and his search leads him to Itadori…\n___\n**Alt Official English:** [VIZ](https://www.viz.com/shonenjump/chapters/jujutsu-kaisen)', 'completed', 2018, 'safe', 'https://uploads.mangadex.org/covers/c52b2ce3-7f95-469c-96b0-479524fb7a1a/6d9134b2-21ea-4d02-ac2b-7c0d1c6a2aaa.jpg', 'Akutami Gege', NULL, NULL, '2025-03-20 04:03:01', '2025-04-07 05:37:10', 129709, 8.9328, 'action.gif'),
(10, '6b958848-c885-4735-9201-12ee77abcb3c', 'SPY×FAMILY', 'The master spy codenamed <Twilight> has spent most of his life on undercover missions, all for the dream of a better world. Yet one day he receives a particularly difficult order from command. For his mission, he must form a temporary family and start a new life?! \n\nA Spy/Action/Comedy manga about a one-of-a-kind family!', 'ongoing', 2019, 'safe', 'https://uploads.mangadex.org/covers/6b958848-c885-4735-9201-12ee77abcb3c/11c2207c-6886-43d2-90fd-c765127579c7.jpg', 'Endou Tatsuya', NULL, NULL, '2025-03-20 04:03:01', '2025-03-20 04:03:01', 0, 0, NULL),
(520, 'e18fe8c6-f6dc-4f05-8462-7b2083ff9a6c', 'Kusuriya no Hitorigoto', 'Maomao, a young woman trained in the art of herbal medicine, is forced to work as a lowly servant in the inner palace. Though she yearns for life outside its perfumed halls, she isn’t long for a life of drudgery! Using her wits to break a “curse” afflicting the imperial heirs, Maomao attracts the attentions of the handsome eunuch Jinshi and is promoted to attendant food taster. But Jinshi has other plans for the erstwhile apothecary, and soon Maomao is back to brewing potions and…solving mysteries?!', 'ongoing', 2017, 'safe', 'https://uploads.mangadex.org/covers/e18fe8c6-f6dc-4f05-8462-7b2083ff9a6c/0f5b4b6f-fe4c-49f9-834a-a9a441b99493.jpg', 'Hyuuga Natsu', NULL, NULL, '2025-03-21 16:55:22', '2025-04-07 05:37:11', 129626, 9.5061, 'romance.gif');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_history`
--

CREATE TABLE `reading_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `manga_id` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cover_url` text DEFAULT NULL,
  `last_read` datetime DEFAULT current_timestamp(),
  `chapter_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reading_history`
--

INSERT INTO `reading_history` (`id`, `user_id`, `manga_id`, `title`, `cover_url`, `last_read`, `chapter_id`) VALUES
(0, 2, '6670ee28-f26d-4b61-b49c-d71149cd5a6e', 'Chương 64.6', 'https://uploads.mangadex.org/covers/6670ee28-f26d-4b61-b49c-d71149cd5a6e/bd7e79a1-5a29-46e8-b402-765e7f01ff9b.jpg.256.jpg', '2025-04-16 14:07:21', '1cd905c1-0c56-496b-99c9-b907cfc41610'),
(0, 2, 'a77742b1-befd-49a4-bff5-1ad4e6b0ef7b', 'Chương 73', 'https://uploads.mangadex.org/covers/a77742b1-befd-49a4-bff5-1ad4e6b0ef7b/bf31b6c3-9075-4c1e-95be-b6a38ffed10f.jpg.256.jpg', '2025-04-16 15:51:44', '8a264bf6-df07-490c-8a32-1f032f4b8fed'),
(0, 2, '64113fcd-4f8c-41bc-8fa4-18a83076da2e', 'Chương 16', 'https://uploads.mangadex.org/covers/64113fcd-4f8c-41bc-8fa4-18a83076da2e/8a8d42b9-86f3-4856-b41f-cbae24199884.jpg.256.jpg', '2025-04-16 15:25:08', '4e66877e-8841-4ad6-a0e9-f6654183dbf6');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar_url` varchar(512) DEFAULT 'http://localhost/Comic/assets/images/default_avatar.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `login_method` varchar(50) DEFAULT 'manual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar_url`, `created_at`, `login_method`) VALUES
(1, 'ductranvip', 'tranduc123@gmail.com', '$2y$10$S3xcWErdpHdSgsv/VRpw.OzKQc61WO6MmtBmGDUn4rxbeYbXKHOnO', 'http://localhost/Comic/assets/avatars/avatar_1_1742463294.jpg', '2025-03-20 04:05:11', 'manual'),
(2, '9568_ Trần Thiên Đức', 'ductran06629@gmail.com', '', 'https://lh3.googleusercontent.com/a/ACg8ocI_Vi3p5vUvvqBrXKgiiVjRiLZddNn14s-K2N5_hZUprQgmWbV0=s96-c', '2025-03-26 12:54:55', 'google'),
(3, 'Tachi Nguyễn', 'tachinguyen01@gmail.com', '', 'http://localhost/Comic/assets/avatars/avatar_3_1743349162.png', '2025-03-26 13:34:03', 'google'),
(4, 'Asus NQB', 'ngqbinh123@gmail.com', '', 'http://localhost/Comic/assets/avatars/avatar_4_1743133616.jpg', '2025-03-28 03:44:44', 'google'),
(14, 'tranducc113', 'dubaivippro@gmail.com', '$2y$10$hHPbNlf.R0PONeER2pbn6uKNxK3jQkQPlHuRc5XNGhgmF6ZpKvMOi', 'http://localhost/Comic/assets/avatars/avatar_14_1744270311.png', '2025-03-30 14:11:57', 'manual'),
(15, 'ductran34356', 'tranduc21@gmail.com', '$2y$10$WDp34c.jDWwW2YhbKfIavuHIfgd4xX4GK04HWcFZY2EG/gx/cx6Uq', 'http://localhost/Comic/assets/avatars/avatar_15_1743346499.jpg', '2025-03-30 14:54:29', 'manual'),
(16, 'Nguyễn Quang Bình ', 'ngqbinh456@gmail.com', '', 'http://localhost/Comic/assets/avatars/avatar_16_1744260488.png', '2025-04-10 04:30:43', 'facebook');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mangadex_tag_id` (`mangadex_tag_id`);

--
-- Chỉ mục cho bảng `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mangadex_id` (`mangadex_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Chỉ mục cho bảng `chapter_images`
--
ALTER TABLE `chapter_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_chapter_page` (`chapter_id`,`page_number`);

--
-- Chỉ mục cho bảng `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mangadex_id` (`mangadex_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT cho bảng `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=772;

--
-- AUTO_INCREMENT cho bảng `chapter_images`
--
ALTER TABLE `chapter_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16914;

--
-- AUTO_INCREMENT cho bảng `manga`
--
ALTER TABLE `manga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2541;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chapter_images`
--
ALTER TABLE `chapter_images`
  ADD CONSTRAINT `chapter_images_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
