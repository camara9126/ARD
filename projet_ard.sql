-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 15 juin 2026 à 13:26
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_ard`
--

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

CREATE TABLE `achats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `unite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `statut` enum('en_attente','annule','recu') NOT NULL DEFAULT 'recu',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `achats`
--

INSERT INTO `achats` (`id`, `reference`, `unite_id`, `fournisseur_id`, `total`, `statut`, `note`, `created_at`, `updated_at`) VALUES
(2, 'FAC-FHNIJB', 3, 1, 95000.00, 'recu', 'null', '2026-06-11 08:41:50', '2026-06-11 08:41:50');

-- --------------------------------------------------------

--
-- Structure de la table `achat_details`
--

CREATE TABLE `achat_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL,
  `achat_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `achat_details`
--

INSERT INTO `achat_details` (`id`, `unite_id`, `achat_id`, `produit_id`, `quantite`, `prix_unitaire`, `total`, `created_at`, `updated_at`) VALUES
(2, 3, 2, 4, 10, 3500.00, 35000.00, '2026-06-11 08:41:50', '2026-06-11 08:41:50'),
(3, 3, 2, 3, 15, 4000.00, 60000.00, '2026-06-11 08:41:50', '2026-06-11 08:41:50');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', '2026-06-09 10:07:07', '2026-06-09 10:07:07');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `telephone`, `email`, `adresse`, `created_at`, `updated_at`, `unite_id`) VALUES
(4, 'Ndiaye', '76845092', 'ndiaye1903oumar@gmail.com', NULL, '2026-06-09 13:00:27', '2026-06-09 13:00:27', 3),
(5, 'ousseynou ba', '7765437893', NULL, NULL, '2026-06-09 13:01:17', '2026-06-09 13:01:17', 3),
(6, 'Ndiaye', NULL, 'ndiaye1903oumar@gmail.com', NULL, '2026-06-12 10:14:43', '2026-06-12 10:14:43', 4);

-- --------------------------------------------------------

--
-- Structure de la table `depenses`
--

CREATE TABLE `depenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `montant` decimal(15,2) NOT NULL,
  `date_depense` date NOT NULL,
  `mode_paiement` enum('cash','orange_money','wave','cheque','autre') NOT NULL,
  `statut` enum('payee','annulee') NOT NULL DEFAULT 'payee',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `depenses`
--

INSERT INTO `depenses` (`id`, `user_id`, `reference`, `libelle`, `description`, `montant`, `date_depense`, `mode_paiement`, `statut`, `created_at`, `updated_at`, `unite_id`) VALUES
(1, 2, 'DEP-1781087621', 'achat marchandise', NULL, 7000.00, '2026-06-10', 'orange_money', 'payee', '2026-06-10 09:33:41', '2026-06-10 09:33:41', 3),
(2, 2, 'DEP-1781170910', 'Achat - FAC-FHNIJB', 'Achat produit', 95000.00, '2026-06-11', 'cash', 'payee', '2026-06-11 08:41:50', '2026-06-11 08:41:50', 3);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `unite_id`, `nom`, `telephone`, `email`, `adresse`, `statut`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Oumar Ndiaye', '7765437893', 'ndiayeoumar0@gmail.com', 'diawlingue, Saint-Louis', 1, '2026-06-09 10:38:19', '2026-06-09 10:42:28'),
(2, NULL, 'awa sy', '776003468', 'syeva34@gmail.com', NULL, 1, '2026-06-11 07:33:52', '2026-06-11 07:33:52');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_08_090840_add_multiples_columns_to_users_table', 2),
(5, '2026_06_08_091300_create_unites_table', 3),
(6, '2026_06_08_091611_add_column_to_users_table', 4),
(7, '2026_06_09_091406_create_fournisseurs_table', 5),
(8, '2026_06_09_091414_create_categories_table', 5),
(9, '2026_06_09_091417_create_produits_table', 6),
(10, '2026_06_09_092205_create_mouvement_stocks_table', 7),
(11, '2026_06_09_120726_create_clients_table', 8),
(12, '2026_06_09_120732_create_ventes_table', 9),
(13, '2026_06_09_120734_create_vente_items_table', 9),
(14, '2026_06_09_121328_create_paiements_table', 9),
(15, '2026_06_09_122153_create_recettes_table', 9),
(16, '2026_06_09_122203_create_depenses_table', 9),
(17, '2026_06_09_135655_add_column_to_ventes_table', 10),
(18, '2026_06_09_135810_add_column_to_clients_table', 11),
(19, '2026_06_09_141620_add_column_to_recettes_table', 12),
(20, '2026_06_11_080450_create_achats_table', 13),
(21, '2026_06_11_080544_create_achat_details_table', 13);

-- --------------------------------------------------------

--
-- Structure de la table `mouvement_stocks`
--

CREATE TABLE `mouvement_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('entree','sortie') NOT NULL,
  `quantite` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mouvement_stocks`
--

INSERT INTO `mouvement_stocks` (`id`, `unite_id`, `produit_id`, `type`, `quantite`, `reference`, `note`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 3, 3, 'entree', 100, 'MVT-1781006251', NULL, 2, '2026-06-09 10:57:31', '2026-06-09 10:57:31'),
(4, 3, 4, 'entree', 50, 'MVT-1781006371', NULL, 2, '2026-06-09 10:59:31', '2026-06-09 10:59:31'),
(5, 3, 4, 'entree', 50, 'MVT-1781006557', NULL, 2, '2026-06-09 11:02:37', '2026-06-09 11:02:37'),
(6, 3, 3, 'entree', 50, 'MVT-1781006700', NULL, 2, '2026-06-09 11:05:00', '2026-06-09 11:05:00'),
(7, 3, 4, 'sortie', 1, 'MVT-1781081713', NULL, 2, '2026-06-10 07:55:13', '2026-06-10 07:55:13'),
(8, 3, 3, 'sortie', 1, 'MVT-1781081713', NULL, 2, '2026-06-10 07:55:13', '2026-06-10 07:55:13'),
(9, 3, 4, 'sortie', 2, 'MVT-1781081747', NULL, 2, '2026-06-10 07:55:47', '2026-06-10 07:55:47'),
(10, 3, 3, 'sortie', 1, 'MVT-1781081747', NULL, 2, '2026-06-10 07:55:47', '2026-06-10 07:55:47'),
(11, 3, 3, 'sortie', 10, 'MVT-1781084348', NULL, 2, '2026-06-10 08:39:08', '2026-06-10 08:39:08'),
(12, 3, 4, 'entree', 10, 'MVT-1781167645', NULL, 2, '2026-06-11 07:47:25', '2026-06-11 07:47:25'),
(13, 3, 4, 'sortie', 3, 'MVT-1781168969', NULL, 2, '2026-06-11 08:09:29', '2026-06-11 08:09:29'),
(14, 3, 3, 'sortie', 4, 'MVT-1781168969', NULL, 2, '2026-06-11 08:09:29', '2026-06-11 08:09:29'),
(15, 3, 4, 'entree', 10, 'MVT-1781170910', NULL, 2, '2026-06-11 08:41:50', '2026-06-11 08:41:50'),
(16, 3, 3, 'entree', 15, 'MVT-1781170910', NULL, 2, '2026-06-11 08:41:50', '2026-06-11 08:41:50'),
(17, 4, 5, 'entree', 10, 'MVT-1781262860', NULL, 3, '2026-06-12 10:14:20', '2026-06-12 10:14:20'),
(18, 4, 5, 'sortie', 3, 'MVT-1781262893', NULL, 3, '2026-06-12 10:14:53', '2026-06-12 10:14:53'),
(19, 4, 5, 'sortie', 1, 'MVT-1781262929', NULL, 3, '2026-06-12 10:15:29', '2026-06-12 10:15:29'),
(20, 3, 3, 'sortie', 100, 'MVT-1781517573', NULL, 2, '2026-06-15 08:59:33', '2026-06-15 08:59:33'),
(21, 3, 4, 'sortie', 1, 'MVT-1781517573', NULL, 2, '2026-06-15 08:59:33', '2026-06-15 08:59:33');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL,
  `vente_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `mode_paiement` enum('cash','wave','orange_money','cheque','autre') NOT NULL,
  `reference` varchar(255) NOT NULL,
  `date_paiement` date NOT NULL,
  `statut` enum('valide','annule') NOT NULL DEFAULT 'valide',
  `motif` text DEFAULT NULL,
  `annule_par` bigint(20) UNSIGNED DEFAULT NULL,
  `annule_le` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `unite_id`, `vente_id`, `user_id`, `montant`, `mode_paiement`, `reference`, `date_paiement`, `statut`, `motif`, `annule_par`, `annule_le`, `created_at`, `updated_at`) VALUES
(1, 3, 74, 2, 8850.00, 'cash', 'PAY-1781081713', '2026-06-10', 'valide', NULL, NULL, NULL, '2026-06-10 07:55:13', '2026-06-10 07:55:13'),
(2, 3, 75, 2, 12980.00, 'cash', 'PAY-1781081748', '2026-06-10', 'valide', NULL, NULL, NULL, '2026-06-10 07:55:48', '2026-06-10 07:55:48'),
(4, 3, 77, 2, 26500.00, 'cash', 'PAY-1781168969', '2026-06-11', 'valide', NULL, NULL, NULL, '2026-06-11 08:09:29', '2026-06-11 08:09:29'),
(5, 4, 78, 3, 9000.00, 'cash', 'PAY-1781262893', '2026-06-12', 'valide', NULL, NULL, NULL, '2026-06-12 10:14:53', '2026-06-12 10:14:53'),
(6, 4, 79, 3, 3500.00, 'cash', 'PAY-1781262930', '2026-06-12', 'valide', NULL, NULL, NULL, '2026-06-12 10:15:30', '2026-06-12 10:15:30'),
(7, 3, 80, 2, 403500.00, 'cash', 'PAY-1781517574', '2026-06-15', 'valide', NULL, NULL, NULL, '2026-06-15 08:59:34', '2026-06-15 08:59:34');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `prix_achat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `prix_vente` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_min` int(11) NOT NULL DEFAULT 0,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `categorie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `unite_id`, `fournisseur_id`, `nom`, `slug`, `code`, `prix_achat`, `prix_vente`, `stock`, `stock_min`, `statut`, `categorie_id`, `created_at`, `updated_at`) VALUES
(3, 3, 1, 'Gezner pur', 'gezner-pur', 'PRD-00001', 2500.00, 4000.00, 49, 10, 1, 1, '2026-06-09 10:57:31', '2026-06-15 09:04:12'),
(4, 3, 1, 'Bazin riche', 'bazin-riche', 'PRD-00002', 2000.00, 3500.00, 113, 5, 1, NULL, '2026-06-09 10:59:31', '2026-06-15 08:59:33'),
(5, 4, NULL, 'shawarma', 'shawarma', 'PRD-00001', 2000.00, 3000.00, 6, 5, 1, NULL, '2026-06-12 10:14:20', '2026-06-12 10:15:29');

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

CREATE TABLE `recettes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `montant` decimal(15,2) NOT NULL,
  `date_recette` date NOT NULL,
  `paiement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mode_paiement` enum('cash','orange_money','wave','cheque','autre') NOT NULL,
  `statut` enum('recu','annule') NOT NULL DEFAULT 'recu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recettes`
--

INSERT INTO `recettes` (`id`, `user_id`, `reference`, `libelle`, `description`, `montant`, `date_recette`, `paiement_id`, `mode_paiement`, `statut`, `created_at`, `updated_at`, `unite_id`) VALUES
(1, 2, 'REC-1781081713', 'Paiement vente VNT-1781081713', NULL, 8850.00, '2026-06-10', 1, 'cash', 'recu', '2026-06-10 07:55:13', '2026-06-10 07:55:13', 3),
(2, 2, 'REC-1781081748', 'Paiement vente VNT-1781081747', NULL, 12980.00, '2026-06-10', 2, 'cash', 'recu', '2026-06-10 07:55:48', '2026-06-10 07:55:48', 3),
(5, 2, 'REC-1781168969', 'Paiement vente VNT-1781168968', NULL, 26500.00, '2026-06-11', 4, 'cash', 'recu', '2026-06-11 08:09:29', '2026-06-11 08:09:29', 3),
(6, 2, 'REC-1781181299', 'cadeau', 'bonus de satisfaction vente', 5000.00, '2026-05-09', NULL, 'orange_money', 'recu', '2026-05-09 11:34:59', '2026-05-09 11:34:59', 3),
(7, 3, 'REC-1781262893', 'Paiement vente VNT-1781262893', NULL, 9000.00, '2026-06-12', 5, 'cash', 'recu', '2026-06-12 10:14:53', '2026-06-12 10:14:53', 4),
(8, 3, 'REC-1781262930', 'Paiement vente VNT-1781262929', NULL, 3500.00, '2026-06-12', 6, 'cash', 'recu', '2026-06-12 10:15:30', '2026-06-12 10:15:30', 4),
(9, 2, 'REC-1781517574', 'Paiement vente VNT-1781517573', NULL, 403500.00, '2026-06-15', 7, 'cash', 'recu', '2026-06-15 08:59:34', '2026-06-15 08:59:34', 3);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('wFK9AVa56IvRYwsicpOXnctKovMmGczanjcYg5xJ', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZDI3bWdJUzhyMUw4dUZvdU5rbEJmSFJNUVlqcmJvTHk2bmR6U3FQUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4uaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1781522587);

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

CREATE TABLE `unites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `taux_tva` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id`, `nom`, `contact`, `adresse`, `logo`, `statut`, `taux_tva`, `created_at`, `updated_at`) VALUES
(3, 'Laye Tissus', '703345754', 'sanar, saint-louis', 'logo/1781169993logos.jpeg', 1, 0.00, '2026-06-09 10:29:56', '2026-06-11 08:27:48'),
(4, 'O\'food', '759821349', 'Diawlingue, saint-louis', '759821349', 1, 0.00, '2026-06-12 07:15:21', '2026-06-12 07:15:21'),
(5, 'ARD', '334575424', 'Saint-Louis, SENEGAL', '334575424', 1, 0.00, '2026-06-12 07:37:35', '2026-06-12 07:37:35');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','commercial') NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `unite_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `telephone`, `unite_id`) VALUES
(2, 'Amadou Camara', 'amadou@ard.com', NULL, '$2y$12$RW3PEiTRlYCSWzcbSGaWXOy4p40GrFlr9lcPplqr9IJnahyMagkLW', NULL, '2026-06-09 10:28:32', '2026-06-09 10:29:56', 'commercial', NULL, 3),
(3, 'Oumar Ndiaye', 'oumar@ard.com', NULL, '$2y$12$LfWw4J/R38ptOSALoBPEj.oy0AdOebAEOAW0C2FJ.yBN4H6/hs/eW', NULL, '2026-06-12 07:12:17', '2026-06-12 07:15:21', 'commercial', NULL, 4),
(4, 'Amadou ba', 'admin@ard.com', NULL, '$2y$12$DzeK95nFcigQOX9oMKO5PuJlh/texMepdCr/xR9zD2OnMdE9LOGs.', NULL, '2026-06-12 07:31:04', '2026-06-12 07:37:35', 'admin', NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `statut` enum('payee','impayee','partielle') NOT NULL DEFAULT 'impayee',
  `total_tva` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_ttc` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `user_id`, `client_id`, `reference`, `date`, `total`, `statut`, `total_tva`, `total_ttc`, `created_at`, `updated_at`, `unite_id`) VALUES
(74, 2, NULL, 'VNT-1781081713', '2026-06-10', 7500.00, 'payee', 1350.00, 8850.00, '2026-06-10 07:55:13', '2026-06-10 07:55:13', 3),
(75, 2, NULL, 'VNT-1781081747', '2026-06-10', 11000.00, 'payee', 1980.00, 12980.00, '2026-06-10 07:55:47', '2026-06-10 07:55:48', 3),
(77, 2, NULL, 'VNT-1781168968', '2026-06-11', 26500.00, 'payee', 0.00, 26500.00, '2026-06-11 08:09:28', '2026-06-11 08:09:29', 3),
(78, 3, 6, 'VNT-1781262893', '2026-06-12', 9000.00, 'payee', 0.00, 9000.00, '2026-06-12 10:14:53', '2026-06-12 10:14:53', 4),
(79, 3, NULL, 'VNT-1781262929', '2026-06-12', 3500.00, 'payee', 0.00, 3500.00, '2026-06-12 10:15:29', '2026-06-12 10:15:30', 4),
(80, 2, NULL, 'VNT-1781517573', '2026-06-15', 403500.00, 'payee', 0.00, 403500.00, '2026-06-15 08:59:33', '2026-06-15 08:59:34', 3);

-- --------------------------------------------------------

--
-- Structure de la table `vente_items`
--

CREATE TABLE `vente_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vente_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `taux_tva` decimal(5,2) DEFAULT 18.00,
  `montant_tva` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_ttc` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vente_items`
--

INSERT INTO `vente_items` (`id`, `vente_id`, `produit_id`, `quantite`, `prix_unitaire`, `total`, `taux_tva`, `montant_tva`, `total_ttc`, `created_at`, `updated_at`, `unite_id`) VALUES
(27, 74, 4, 1, 3500.00, 3500.00, 18.00, 630.00, 4130.00, '2026-06-10 07:55:13', '2026-06-10 07:55:13', 3),
(28, 74, 3, 1, 4000.00, 4000.00, 18.00, 720.00, 4720.00, '2026-06-10 07:55:13', '2026-06-10 07:55:13', 3),
(29, 75, 4, 2, 3500.00, 7000.00, 18.00, 1260.00, 8260.00, '2026-06-10 07:55:47', '2026-06-10 07:55:47', 3),
(30, 75, 3, 1, 4000.00, 4000.00, 18.00, 720.00, 4720.00, '2026-06-10 07:55:47', '2026-06-10 07:55:47', 3),
(32, 77, 4, 3, 3500.00, 10500.00, 0.00, 0.00, 10500.00, '2026-06-11 08:09:28', '2026-06-11 08:09:28', 3),
(33, 77, 3, 4, 4000.00, 16000.00, 0.00, 0.00, 16000.00, '2026-06-11 08:09:29', '2026-06-11 08:09:29', 3),
(34, 78, 5, 3, 3000.00, 9000.00, 0.00, 0.00, 9000.00, '2026-06-12 10:14:53', '2026-06-12 10:14:53', 4),
(35, 79, 5, 1, 3500.00, 3500.00, 0.00, 0.00, 3500.00, '2026-06-12 10:15:29', '2026-06-12 10:15:29', 4),
(36, 80, 3, 100, 4000.00, 400000.00, 0.00, 0.00, 400000.00, '2026-06-15 08:59:33', '2026-06-15 08:59:33', 3),
(37, 80, 4, 1, 3500.00, 3500.00, 0.00, 0.00, 3500.00, '2026-06-15 08:59:33', '2026-06-15 08:59:33', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achats`
--
ALTER TABLE `achats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `achats_reference_unique` (`reference`),
  ADD KEY `achats_unite_id_foreign` (`unite_id`),
  ADD KEY `achats_fournisseur_id_foreign` (`fournisseur_id`);

--
-- Index pour la table `achat_details`
--
ALTER TABLE `achat_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achat_details_unite_id_foreign` (`unite_id`),
  ADD KEY `achat_details_achat_id_foreign` (`achat_id`),
  ADD KEY `achat_details_produit_id_foreign` (`produit_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_unite_id_foreign` (`unite_id`);

--
-- Index pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `depenses_reference_unique` (`reference`),
  ADD KEY `depenses_user_id_foreign` (`user_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fournisseurs_unite_id_foreign` (`unite_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mouvement_stocks`
--
ALTER TABLE `mouvement_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mouvement_stocks_unite_id_foreign` (`unite_id`),
  ADD KEY `mouvement_stocks_produit_id_foreign` (`produit_id`),
  ADD KEY `mouvement_stocks_user_id_foreign` (`user_id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paiements_reference_unique` (`reference`),
  ADD KEY `paiements_unite_id_foreign` (`unite_id`),
  ADD KEY `paiements_vente_id_foreign` (`vente_id`),
  ADD KEY `paiements_user_id_foreign` (`user_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produits_unite_id_foreign` (`unite_id`),
  ADD KEY `produits_fournisseur_id_foreign` (`fournisseur_id`),
  ADD KEY `produits_categorie_id_foreign` (`categorie_id`);

--
-- Index pour la table `recettes`
--
ALTER TABLE `recettes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recettes_reference_unique` (`reference`),
  ADD KEY `recettes_user_id_foreign` (`user_id`),
  ADD KEY `recettes_paiement_id_foreign` (`paiement_id`),
  ADD KEY `recettes_unite_id_foreign` (`unite_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `unites`
--
ALTER TABLE `unites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_unite_id_foreign` (`unite_id`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ventes_reference_unique` (`reference`),
  ADD KEY `ventes_user_id_foreign` (`user_id`),
  ADD KEY `ventes_client_id_foreign` (`client_id`),
  ADD KEY `ventes_unite_id_foreign` (`unite_id`);

--
-- Index pour la table `vente_items`
--
ALTER TABLE `vente_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vente_items_vente_id_foreign` (`vente_id`),
  ADD KEY `vente_items_produit_id_foreign` (`produit_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achats`
--
ALTER TABLE `achats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `achat_details`
--
ALTER TABLE `achat_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `depenses`
--
ALTER TABLE `depenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `mouvement_stocks`
--
ALTER TABLE `mouvement_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `recettes`
--
ALTER TABLE `recettes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `unites`
--
ALTER TABLE `unites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT pour la table `vente_items`
--
ALTER TABLE `vente_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achats`
--
ALTER TABLE `achats`
  ADD CONSTRAINT `achats_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `achats_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `achat_details`
--
ALTER TABLE `achat_details`
  ADD CONSTRAINT `achat_details_achat_id_foreign` FOREIGN KEY (`achat_id`) REFERENCES `achats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `achat_details_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `achat_details_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD CONSTRAINT `depenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD CONSTRAINT `fournisseurs_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mouvement_stocks`
--
ALTER TABLE `mouvement_stocks`
  ADD CONSTRAINT `mouvement_stocks_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mouvement_stocks_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mouvement_stocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `paiements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `paiements_vente_id_foreign` FOREIGN KEY (`vente_id`) REFERENCES `ventes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produits_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produits_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recettes`
--
ALTER TABLE `recettes`
  ADD CONSTRAINT `recettes_paiement_id_foreign` FOREIGN KEY (`paiement_id`) REFERENCES `paiements` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recettes_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recettes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `ventes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventes_unite_id_foreign` FOREIGN KEY (`unite_id`) REFERENCES `unites` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vente_items`
--
ALTER TABLE `vente_items`
  ADD CONSTRAINT `vente_items_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vente_items_vente_id_foreign` FOREIGN KEY (`vente_id`) REFERENCES `ventes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
