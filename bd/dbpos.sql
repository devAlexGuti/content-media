-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-07-2024 a las 19:52:03
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbpos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_07_20_163039_create_pos_clients_table', 3),
(8, '2024_07_20_163338_create_pos_books_table', 4),
(9, '2024_07_20_164619_create_pos_orders_table', 5),
(10, '2024_07_20_170451_create_pos_order_details_table', 6),
(12, '2024_07_21_215806_add_payment_status_to_pos_order_table', 7),
(13, '2024_07_22_024337_add_image_to_pos_book_table', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pos_book`
--

CREATE TABLE `pos_book` (
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `isbn` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `current_price` decimal(10,2) DEFAULT NULL,
  `image_book` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pos_book`
--

INSERT INTO `pos_book` (`book_id`, `isbn`, `name`, `stock`, `current_price`, `image_book`, `created_at`, `updated_at`) VALUES
(1, '1234567891023', 'el caballero', 14, '15.00', 'images/books/1721618105-libro2.jpg', '2024-07-21 08:50:03', '2024-07-22 03:34:31'),
(3, '1234567891039', 'el oscuro 4', 18, '14.99', 'images/books/1721618105-libro2.jpg', '2024-07-21 08:54:09', '2024-07-22 10:06:59'),
(4, '3334567891039', 'metamorfosis', 34, '17.99', 'images/books/1721618105-libro1.jpg', '2024-07-22 08:15:05', '2024-07-23 08:31:32'),
(5, '1231231231231', 'motrola', 23, '19.99', 'images/books/1721686140-motorola.jpg', '2024-07-23 03:09:00', '2024-07-23 03:09:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pos_client`
--

CREATE TABLE `pos_client` (
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `doc_type` tinyint(4) DEFAULT NULL,
  `doc_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pos_client`
--

INSERT INTO `pos_client` (`client_id`, `doc_type`, `doc_number`, `first_name`, `last_name`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 1, '92345679', 'holawe', 'floreeeq', '919999777', 'qwe@gmail.com', '2024-07-21 02:54:35', '2024-07-22 11:12:23'),
(2, 2, '20345678222', 'holawe', 'floreee', '919999777', 'e@gmail.com', '2024-07-21 02:55:28', '2024-07-21 02:55:28'),
(4, 3, '12212', 'holawe', 'floreee', '919999777', 'e2@gmail.com', '2024-07-21 02:56:18', '2024-07-21 02:56:18'),
(10, 3, '252345678', 'holawe', 'floreee', '919999777', 'ewqwq@gmail.com', '2024-07-21 03:21:09', '2024-07-21 03:21:09'),
(11, 1, '92345629', 'holawe', 'floreee', '919999737', 'qwqe@gmail.com', '2024-07-21 11:02:41', '2024-07-21 11:02:41'),
(12, 1, '12345231', 'Metal', 'slug', '983456342', 'm@gmail.com', '2024-07-22 20:41:47', '2024-07-22 20:41:47'),
(13, 1, '23456678', 'Brisa', 'Flores', '987343454', 'awq@gmail.com', '2024-07-22 21:54:32', '2024-07-22 21:54:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pos_order`
--

CREATE TABLE `pos_order` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `doc_type` tinyint(4) DEFAULT NULL,
  `doc_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pos_order`
--

INSERT INTO `pos_order` (`order_id`, `client_id`, `total`, `doc_type`, `doc_number`, `last_name`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, '45.00', 1, '92345679', 'floreee', 'paid', '2024-07-22 03:28:08', '2024-07-22 03:35:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pos_order_detail`
--

CREATE TABLE `pos_order_detail` (
  `order_detail_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `detail_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pos_order_detail`
--

INSERT INTO `pos_order_detail` (`order_detail_id`, `order_id`, `book_id`, `detail_price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '15.00', 3, '2024-07-22 03:33:56', '2024-07-22 03:34:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `pos_book`
--
ALTER TABLE `pos_book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `pos_book_isbn_unique` (`isbn`);

--
-- Indices de la tabla `pos_client`
--
ALTER TABLE `pos_client`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `pos_client_doc_number_unique` (`doc_number`),
  ADD UNIQUE KEY `pos_client_email_unique` (`email`);

--
-- Indices de la tabla `pos_order`
--
ALTER TABLE `pos_order`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `pos_order_client_id_unique` (`client_id`);

--
-- Indices de la tabla `pos_order_detail`
--
ALTER TABLE `pos_order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `pos_order_detail_order_id_foreign` (`order_id`),
  ADD KEY `pos_order_detail_book_id_foreign` (`book_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pos_book`
--
ALTER TABLE `pos_book`
  MODIFY `book_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pos_client`
--
ALTER TABLE `pos_client`
  MODIFY `client_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `pos_order`
--
ALTER TABLE `pos_order`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pos_order_detail`
--
ALTER TABLE `pos_order_detail`
  MODIFY `order_detail_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pos_order`
--
ALTER TABLE `pos_order`
  ADD CONSTRAINT `pos_order_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `pos_client` (`client_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pos_order_detail`
--
ALTER TABLE `pos_order_detail`
  ADD CONSTRAINT `pos_order_detail_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `pos_book` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_order_detail_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `pos_order` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
