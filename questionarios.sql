-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 18/06/2021 às 17:10
-- Versão do servidor: 10.4.18-MariaDB
-- Versão do PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `questionarios`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas_questionarios`
--

CREATE TABLE `perguntas_questionarios` (
  `id` int(11) NOT NULL,
  `questionario_id` int(11) DEFAULT NULL,
  `pergunta` varchar(255) NOT NULL,
  `tipo_resposta` tinyint(2) NOT NULL,
  `pergunta_obrigatoria` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `perguntas_questionarios`
--

INSERT INTO `perguntas_questionarios` (`id`, `questionario_id`, `pergunta`, `tipo_resposta`, `pergunta_obrigatoria`, `created_at`, `updated_at`) VALUES
(6, NULL, 'Where can I get some?', 3, 0, '2021-06-17 19:36:59', '2021-06-17 19:36:59'),
(7, NULL, 'Why do we use it?', 4, 0, '2021-06-17 19:36:59', '2021-06-17 19:36:59'),
(8, NULL, 'Where can I get some?', 3, 0, '2021-06-17 19:37:13', '2021-06-17 19:37:13'),
(9, NULL, 'Why do we use it?', 4, 0, '2021-06-17 19:37:13', '2021-06-17 19:37:13'),
(10, NULL, 'Where can I get some?', 3, 0, '2021-06-17 19:37:32', '2021-06-17 19:37:32'),
(11, NULL, 'Why do we use it?', 4, 0, '2021-06-17 19:37:32', '2021-06-17 19:37:32'),
(12, NULL, 'Where can I get some?', 3, 0, '2021-06-17 19:38:03', '2021-06-17 19:38:03'),
(13, NULL, 'Why do we use it?', 4, 0, '2021-06-17 19:38:03', '2021-06-17 19:38:03'),
(26, 24, 'What is Lorem Ipsum?', 1, 1, '2021-06-18 18:02:48', '2021-06-18 18:02:48'),
(27, 24, 'Why do we use it?', 2, 1, '2021-06-18 18:02:48', '2021-06-18 18:02:48'),
(28, 24, 'Where does it come from?', 3, 0, '2021-06-18 18:02:48', '2021-06-18 18:02:48'),
(29, 24, 'Where can I get some?', 4, 1, '2021-06-18 18:02:48', '2021-06-18 18:02:55'),
(30, 25, 'Tipo de Texto', 2, 0, '2021-06-18 18:06:01', '2021-06-18 18:06:01'),
(31, 25, 'lorem ipsum', 4, 0, '2021-06-18 18:06:01', '2021-06-18 18:06:01'),
(32, 25, 'modern lorem ipsum', 3, 1, '2021-06-18 18:06:01', '2021-06-18 18:06:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionarios`
--

CREATE TABLE `questionarios` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `instrucoes` varchar(2000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `questionarios`
--

INSERT INTO `questionarios` (`id`, `titulo`, `instrucoes`, `user_id`, `created_at`, `updated_at`) VALUES
(24, 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2021-06-18 18:02:48', '2021-06-18 18:02:48'),
(25, 'Texto Lorem Ipsum', 'Aenean mollis in quis est aenean taciti rhoncus, odio consectetur posuere mauris amet donec lectus varius, vel euismod conubia per tortor ullamcorper. inceptos nibh et primis duis fermentum etiam netus tempor vel nulla egestas quis nunc, magna aliquam accumsan habitasse dictumst ante nibh enim senectus turpis aliquet curabitur. himenaeos hendrerit malesuada justo donec lectus eu aliquam lorem ipsum, varius cras est facilisis lorem nec fames nam interdum, nulla inceptos vestibulum neque himenaeos convallis cursus posuere. magna augue tempus varius neque ornare amet dui sit urna duis, lorem maecenas curabitur congue facilisis libero velit mi.', 2, '2021-06-18 18:06:01', '2021-06-18 18:06:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_perguntas`
--

CREATE TABLE `respostas_perguntas` (
  `id` int(11) NOT NULL,
  `pergunta_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `texto` varchar(4000) DEFAULT NULL,
  `data` varchar(20) DEFAULT NULL,
  `numerico` int(11) DEFAULT NULL,
  `latitude` varchar(500) DEFAULT NULL,
  `longitude` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Fernando Soares Franco', 'email@email.com', NULL, '$2y$10$jLoezs.OsZJ6sQEbjkTSx.3xTu2NBSkkDAWD/2Bxjjsc6QLH.fslK', 'WTMnyrT2mQCHhwh8PL0NNJb7uaPtMIeeOjFzx97xlz6i9YQzyqIZWLQLfXlG', '2021-06-16 17:37:19', '2021-06-16 17:37:19'),
(2, 'Franco', 'franco@email.com', NULL, '$2y$10$N6Pq.QORmLwaPpsc/ltJseLW7xHN6mLdDjkFnMiE5ganKXHgtGd6e', NULL, '2021-06-17 20:19:24', '2021-06-17 20:19:24');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Índices de tabela `perguntas_questionarios`
--
ALTER TABLE `perguntas_questionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionario_id` (`questionario_id`);

--
-- Índices de tabela `questionarios`
--
ALTER TABLE `questionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `respostas_perguntas`
--
ALTER TABLE `respostas_perguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pergunta_id` (`pergunta_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `perguntas_questionarios`
--
ALTER TABLE `perguntas_questionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `questionarios`
--
ALTER TABLE `questionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `respostas_perguntas`
--
ALTER TABLE `respostas_perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `perguntas_questionarios`
--
ALTER TABLE `perguntas_questionarios`
  ADD CONSTRAINT `perguntas_questionarios_ibfk_1` FOREIGN KEY (`questionario_id`) REFERENCES `questionarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `questionarios`
--
ALTER TABLE `questionarios`
  ADD CONSTRAINT `questionarios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `respostas_perguntas`
--
ALTER TABLE `respostas_perguntas`
  ADD CONSTRAINT `respostas_perguntas_ibfk_1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas_questionarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_perguntas_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
