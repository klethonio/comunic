-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 07, 2023 at 08:59 PM
-- Server version: 5.7.33
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comunic`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuc_categories`
--

CREATE TABLE `cuc_categories` (
  `id` int(11) NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cuc_gallery`
--

CREATE TABLE `cuc_gallery` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuc_posts`
--

CREATE TABLE `cuc_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` int(11) NOT NULL DEFAULT '1',
  `cat_parent` int(11) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date` timestamp NOT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `tags` varchar(255) NOT NULL,
  `views` float NOT NULL DEFAULT '0',
  `level` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cuc_posts`
--

INSERT INTO `cuc_posts` (`id`, `title`, `content`, `category`, `cat_parent`, `author`, `url`, `date`, `update_date`, `type`, `thumb`, `tags`, `views`, `level`, `status`) VALUES
(3, 'Ative sua conta', '<p>Cadastro realizado com <strong>sucesso</strong>!</p>\r\n<p>&nbsp;</p>\r\n<p>Verifique seu e-mail para poder ativar sua conta.</p>', 0, NULL, 1, 'ative-sua-conta', '2023-01-07 20:43:11', NULL, 'page', NULL, 'cadastro, sucesso', 0, 0, 1),
(4, 'Erro ao ativar', '<p>Ocorreu algum erro na ativa&ccedil;&atilde;o da sua conta.</p>\r\n<p>Entre em contato com a nossa equipe.</p>', 0, NULL, 1, 'erro-ao-ativar', '2023-01-07 20:44:08', NULL, 'page', NULL, 'erro, ativação', 1, 0, 1),
(5, 'Sucesso ao ativar', '<p>Conta ativada com sucesso.</p>\r\n<p>&nbsp;</p>\r\n<p>Em breve teremos se&ccedil;&atilde;o de coment&aacute;rios.</p>\r\n<p>&nbsp;</p>\r\n<p>Navegue a vontade.</p>', 0, NULL, 1, 'sucesso-ao-ativar', '2023-01-07 20:44:42', NULL, 'page', NULL, 'sucesso, ativação', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuc_regions`
--

CREATE TABLE `cuc_regions` (
  `id` int(11) NOT NULL,
  `region` int(1) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cuc_users`
--

CREATE TABLE `cuc_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pswd` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `cel` varchar(255) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `reg_date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cuc_users`
--

INSERT INTO `cuc_users` (`id`, `name`, `cpf`, `email`, `pswd`, `address`, `cep`, `district`, `city`, `state`, `cel`, `tel`, `avatar`, `level`, `status`, `reg_date`) VALUES
(1, 'Admin', '000.000.000-00', 'admin@admin.com', 'e10ad2UDNzITMf883e', 'First Street', '58660000', 'Centro', 'São Paulo', 'SP', '(11) 99999-9999', NULL, NULL, 1, 1, '2016-09-16 22:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `cuc_viewers_online`
--

CREATE TABLE `cuc_viewers_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_end` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuc_views`
--

CREATE TABLE `cuc_views` (
  `id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `views` int(11) NOT NULL,
  `page_views` int(11) NOT NULL,
  `viewers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuc_categories`
--
ALTER TABLE `cuc_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuc_gallery`
--
ALTER TABLE `cuc_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuc_posts`
--
ALTER TABLE `cuc_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuc_regions`
--
ALTER TABLE `cuc_regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuc_users`
--
ALTER TABLE `cuc_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuc_viewers_online`
--
ALTER TABLE `cuc_viewers_online`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuc_views`
--
ALTER TABLE `cuc_views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cuc_categories`
--
ALTER TABLE `cuc_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuc_gallery`
--
ALTER TABLE `cuc_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuc_posts`
--
ALTER TABLE `cuc_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cuc_regions`
--
ALTER TABLE `cuc_regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuc_users`
--
ALTER TABLE `cuc_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cuc_viewers_online`
--
ALTER TABLE `cuc_viewers_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuc_views`
--
ALTER TABLE `cuc_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
