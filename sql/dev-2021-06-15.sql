/*
 Navicat Premium Data Transfer

 Source Server         : localhost my
 Source Server Type    : MySQL
 Source Server Version : 100410
 Source Host           : localhost:3306
 Source Schema         : sahabat-nits

 Target Server Type    : MySQL
 Target Server Version : 100410
 File Encoding         : 65001

 Date: 15/06/2021 09:52:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for campaign_agents
-- ----------------------------
DROP TABLE IF EXISTS `campaign_agents`;
CREATE TABLE `campaign_agents`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `campaign_agents_campaign_id_foreign`(`campaign_id`) USING BTREE,
  INDEX `campaign_agents_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `campaign_agents_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `campaign_agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of campaign_agents
-- ----------------------------
INSERT INTO `campaign_agents` VALUES (1, 7, 13, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (2, 7, 14, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (3, 7, 15, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (4, 7, 16, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (5, 8, 8, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (6, 8, 9, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (7, 8, 10, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (8, 8, 11, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (9, 9, 2, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (10, 9, 3, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (11, 9, 4, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (12, 9, 5, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_agents` VALUES (13, 9, 6, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);

-- ----------------------------
-- Table structure for campaign_photos
-- ----------------------------
DROP TABLE IF EXISTS `campaign_photos`;
CREATE TABLE `campaign_photos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `nama_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekstensi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `campaign_photos_campaign_id_foreign`(`campaign_id`) USING BTREE,
  CONSTRAINT `campaign_photos_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of campaign_photos
-- ----------------------------
INSERT INTO `campaign_photos` VALUES (1, 7, 'wecare-default-campaign-foto-test.jpg', 'campaign_assets\\photos\\wecare-default-campaign-foto-test.jpg', 'jpg', 117, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_photos` VALUES (2, 8, 'wecare-default-campaign-foto-000000000.jpg', 'campaign_assets\\photos\\wecare-default-campaign-foto-000000000.jpg', 'jpg', 117, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_photos` VALUES (3, 9, 'wecare-default-campaign-foto-11111111.jpg', 'campaign_assets\\photos\\wecare-default-campaign-foto-11111111.jpg', 'jpg', 117, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_photos` VALUES (4, 10, 'Screenshot_3.png', 'campaign_assets\\photos\\Screenshot_3-60a12c7e066e5-1621175422.png', 'png', 242084, '2021-05-16 21:30:16', '2021-05-16 21:30:22', NULL);

-- ----------------------------
-- Table structure for campaign_qr_codes
-- ----------------------------
DROP TABLE IF EXISTS `campaign_qr_codes`;
CREATE TABLE `campaign_qr_codes`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `nama_linkaja` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekstensi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `campaign_qr_codes_campaign_id_foreign`(`campaign_id`) USING BTREE,
  CONSTRAINT `campaign_qr_codes_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of campaign_qr_codes
-- ----------------------------
INSERT INTO `campaign_qr_codes` VALUES (1, 7, 'testlinkaja', 'qr-code-default.png', 'campaign_assets\\qr_codes\\qr-code-default.png', 'png', 5040, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_qr_codes` VALUES (2, 8, 'testlinkaja11', 'qr-code-default.png', 'campaign_assets\\qr_codes\\qr-code-default.png', 'png', 5040, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_qr_codes` VALUES (3, 9, 'testlinkaja22', 'qr-code-default.png', 'campaign_assets\\qr_codes\\qr-code-default.png', 'png', 5040, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaign_qr_codes` VALUES (4, 10, 'aipnurhayadi08', 'Screenshot_9.png', 'campaign_assets\\qr_codes\\Screenshot_9-60a12c7e0803c-1621175422.png', 'png', 995335, '2021-05-16 21:30:16', '2021-05-16 21:30:22', NULL);

-- ----------------------------
-- Table structure for campaigns
-- ----------------------------
DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE `campaigns`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NULL DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_publish` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of campaigns
-- ----------------------------
INSERT INTO `campaigns` VALUES (7, '#Ramadhan WeCare Buka Puasa Gratis', '2021-05-01', NULL, 'Assalamualaikum warrahmatullahi wabarakaatuh\n\n        Bapak/Ibu/Rekan FU NITS yang baik dan semoga senantiasa dalam keadaan sehat walafiat..\n\n        Dengan ini kami infokan bahwa telah dicanangkan program Sahabat We Care FU NITS dimana Program ini merupakan bentuk kepedulian jajaran NITS terhadap masyarakat di sekitar melalui partisipasi karyawan NITS maupun donatur lainnya.\n\n        Adapun scope Program Sahabat WeCare ini fokus pada penyaluran bantuan berupa Berbagi Makanan Gratis yang disalurkan kepada masyarakat khususnya yang terkena dampak Covid-19.\n\n        Program ini diawali dengan Program #Ramadhan WeCare, yaitu penyaluran donasi melalui penyediaan makanan setiap hari untuk Berbuka Puasa Gratis kepada masyarakat disekitar selama bulan suci Ramadhan.\n\n        Kegiatan Amal ini, akan dilakukan secara rutin dan berkelanjutan setelah Ramadhan berakhir dengan memberikan sarapan gratis setiap hari kepada yg membutuhkan.  Panitia telah membentuk Tim Sahabat We Care (Subdit/UBIS) yang akan mengelola kegiatan amal ini.\n\n        Untuk itu kami mengajak Bapak/Ibu/Rekan untuk bergabung dalam kegiatan #Ramadhan WeCare ini, dengan cara ikut berdonasi yang dapat disalurkan ke rekening diatas atau Link Aja, penggalangan dana paling lambat tanggal 6 Mei 2021\n\n        Demikian kami infokan...kiranya dapat bermanfaat bagi orang2 yang membutuhkan.\n\n        Terima kasih\n\n        #Sedekahituindah#\n        #salamberbagi#', 1, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaigns` VALUES (8, 'Amal Jariyah - Madrasah Kami Belum Juga Selesai', '2021-05-06', NULL, 'Bismillahirohmanirohim\n\n        berbuat baiklah selagi kita masih di beri kesempatan untuk bisa memberi dan berbagi karena orang yang sudah wafat mereka ingin kembali lagi hanya untuk ingin berbagi dan beribadah kepada ALLAH SWT.\n\n        Assalmualaikum #orang baik\n\n        Alhamdulilah wasyukirillah kita semua dalam keadaan sehat hingga bisa berbagi kebaikan di jalan yang allah ridhoi.\n\n        Perkenalkan nama saya rose rosmawati yang menjadi salah satu wakil panitia pembangunan atau yang ditunjuk sama masyarakat sekitar pesantren madrasah untuk mencai dana bantuan lewat online /internet karena susahnya mencari bantuan di sekitara lingkungan kami', 1, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaigns` VALUES (9, 'Jastip Menempuh Jarak 50 km Demi Kesembuhan Anak', '2021-05-06', NULL, '“Pekerjaan apapun saya lakoni agar jantung buah hati saya tetap berdenyut kencang hingga nanti..”\n        ***\n        Sahabat, familiar dengan kata “jastip” atau bahkan ada yang baru pertama kali mendengarnya? Jastip adalah singkatan dari jasa titip dan menjadi mata pencaharian populer di era digital ini.\n        Jastip adalah layanan yang menawarkan bantuan kepada orang-orang yang ingin membeli sesuatu tetapi tidak dapat pergi ke tempat yang diinginkan, karena berbagai alasan.\n\n        Singkatnya, bila kita tinggal di kota A dan sedang rindu dengan jajanan khas kota B. Seorang kurir jastip akan membelikannya untuk kita, tanpa harus kita keluar kota.', 1, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `campaigns` VALUES (10, 'euy werrrrrr', '2021-04-19', '2021-04-25', 'ini deskripsi', 1, '2021-05-16 21:30:16', '2021-05-16 21:30:22', NULL);

-- ----------------------------
-- Table structure for contributors
-- ----------------------------
DROP TABLE IF EXISTS `contributors`;
CREATE TABLE `contributors`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `handphone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agreement` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contributors_campaign_id_foreign`(`campaign_id`) USING BTREE,
  CONSTRAINT `contributors_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribution_types
-- ----------------------------
DROP TABLE IF EXISTS `distribution_types`;
CREATE TABLE `distribution_types`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of distribution_types
-- ----------------------------
INSERT INTO `distribution_types` VALUES (1, 'Warteg', NULL, NULL, NULL);
INSERT INTO `distribution_types` VALUES (2, 'Mesjid', NULL, NULL, NULL);
INSERT INTO `distribution_types` VALUES (3, 'Distribusi Langsung', NULL, NULL, NULL);
INSERT INTO `distribution_types` VALUES (4, 'Lain-lain', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for income_details
-- ----------------------------
DROP TABLE IF EXISTS `income_details`;
CREATE TABLE `income_details`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `income_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_donasi` datetime(0) NOT NULL,
  `no_referensi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `handphone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `keterangan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `income_details_income_id_foreign`(`income_id`) USING BTREE,
  CONSTRAINT `income_details_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `incomes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of income_details
-- ----------------------------
INSERT INTO `income_details` VALUES (1, 1, '2021-05-09 00:00:00', '81305918510', 'Test Nama 1', '082742599405', 50000, NULL, NULL, NULL, NULL);
INSERT INTO `income_details` VALUES (2, 1, '2021-05-08 00:00:00', '91848130593', 'Test Nama 2', '081275399421', 150000, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for incomes
-- ----------------------------
DROP TABLE IF EXISTS `incomes`;
CREATE TABLE `incomes`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `sumber_dana` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `incomes_campaign_id_foreign`(`campaign_id`) USING BTREE,
  CONSTRAINT `incomes_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of incomes
-- ----------------------------
INSERT INTO `incomes` VALUES (1, 7, 'Link Aja', 'Contoh Rekap LinkAja Update-60a12c8e955e3-1621175438.xlsx', '..\\uploads\\incomes\\Contoh Rekap LinkAja Update-60a12c8e955e3-1621175438.xlsx', 8703, '2021-05-16 21:30:38', '2021-05-16 21:30:38', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 65 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (49, '2018_01_01_000000_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (50, '2021_04_14_073932_create_users_table', 1);
INSERT INTO `migrations` VALUES (51, '2021_04_15_061848_create_campaigns_table', 1);
INSERT INTO `migrations` VALUES (52, '2021_04_15_075057_create_campaign_photos_table', 1);
INSERT INTO `migrations` VALUES (53, '2021_04_15_075108_create_campaign_qr_codes_table', 1);
INSERT INTO `migrations` VALUES (54, '2021_04_15_080235_create_campaign_agents_table', 1);
INSERT INTO `migrations` VALUES (55, '2021_04_15_081509_create_user_informations_table', 1);
INSERT INTO `migrations` VALUES (56, '2021_04_22_034653_create_contributors_table', 1);
INSERT INTO `migrations` VALUES (57, '2021_05_03_063157_create_incomes_table', 1);
INSERT INTO `migrations` VALUES (58, '2021_05_03_063208_create_income_details_table', 1);
INSERT INTO `migrations` VALUES (59, '2021_05_05_024437_create_distribution_types_table', 1);
INSERT INTO `migrations` VALUES (60, '2021_05_06_025410_create_outcomes_table', 1);
INSERT INTO `migrations` VALUES (61, '2021_05_06_025619_create_outcome_distributions_table', 1);
INSERT INTO `migrations` VALUES (62, '2021_05_06_030348_create_outcome_distribution_points_table', 1);
INSERT INTO `migrations` VALUES (63, '2021_05_06_030658_create_outcome_distribution_point_evidences_table', 1);
INSERT INTO `migrations` VALUES (64, '2021_05_06_041216_create_rekapitulasi_pendanaan', 1);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 4);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 5);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 6);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 7);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 8);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 9);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 10);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 11);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 12);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 13);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 14);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 15);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 16);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 17);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 18);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 19);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 20);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 21);

-- ----------------------------
-- Table structure for outcome_distribution_point_evidences
-- ----------------------------
DROP TABLE IF EXISTS `outcome_distribution_point_evidences`;
CREATE TABLE `outcome_distribution_point_evidences`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `outcome_distribution_point_id` bigint(20) UNSIGNED NOT NULL,
  `nama_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekstensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `odp_id_foreign`(`outcome_distribution_point_id`) USING BTREE,
  CONSTRAINT `odp_id_foreign` FOREIGN KEY (`outcome_distribution_point_id`) REFERENCES `outcome_distribution_points` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outcome_distribution_point_evidences
-- ----------------------------
INSERT INTO `outcome_distribution_point_evidences` VALUES (1, 1, 'wecare.jpg', '..\\uploads\\outcome_evidences\\wecare-60a12ca77e32f-1621175463.jpg', 'jpg', 120753, '2021-05-16 21:31:03', '2021-05-16 21:31:03', NULL);
INSERT INTO `outcome_distribution_point_evidences` VALUES (2, 2, 'Arknights_Screenshot_2020.08.02_20.34.27.jpg', '..\\uploads\\outcome_evidences\\Arknights_Screenshot_2020.08.02_20.34.27-60a23b526639b-1621244754.jpg', 'jpg', 149437, '2021-05-16 21:36:43', '2021-05-20 16:12:32', '2021-05-20 16:12:32');
INSERT INTO `outcome_distribution_point_evidences` VALUES (4, 5, '132005548_621049881942418_1758620476966465549_n.png', '..\\uploads\\outcome_evidences\\132005548_621049881942418_1758620476966465549_n-60a5e9c7c6358-1621486023.png', 'png', 505042, '2021-05-20 11:47:03', '2021-05-20 11:47:03', NULL);
INSERT INTO `outcome_distribution_point_evidences` VALUES (5, 5, 'Screenshot (7).png', '..\\uploads\\outcome_evidences\\Screenshot (7)-60a5e9c7c76da-1621486023.png', 'png', 520815, '2021-05-20 11:47:03', '2021-05-20 11:47:03', NULL);
INSERT INTO `outcome_distribution_point_evidences` VALUES (10, 2, 'Screenshot (5).png', '..\\uploads\\outcome_evidences\\Screenshot (5)-60a62800bf726-1621501952.png', 'png', 495615, '2021-05-20 16:12:32', '2021-05-20 16:12:32', NULL);

-- ----------------------------
-- Table structure for outcome_distribution_points
-- ----------------------------
DROP TABLE IF EXISTS `outcome_distribution_points`;
CREATE TABLE `outcome_distribution_points`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `outcome_distribution_id` bigint(20) UNSIGNED NOT NULL,
  `distribution_type_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `nama_point` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `jumlah_dana` int(11) NOT NULL,
  `jumlah_paket` int(11) NULL DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `od_foreign`(`outcome_distribution_id`) USING BTREE,
  INDEX `jd_foreign`(`distribution_type_id`) USING BTREE,
  CONSTRAINT `jd_foreign` FOREIGN KEY (`distribution_type_id`) REFERENCES `distribution_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `od_foreign` FOREIGN KEY (`outcome_distribution_id`) REFERENCES `outcome_distributions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outcome_distribution_points
-- ----------------------------
INSERT INTO `outcome_distribution_points` VALUES (1, 5, NULL, 'Yayasan Al-Hakim', NULL, 50000, NULL, NULL, '2021-05-16 21:31:03', '2021-05-16 21:31:03', NULL);
INSERT INTO `outcome_distribution_points` VALUES (2, 1, 1, 'Test', '2021-05-14', 30000, 2, 'test desc', '2021-05-16 21:36:43', '2021-05-17 16:45:54', NULL);
INSERT INTO `outcome_distribution_points` VALUES (5, 1, 1, 'Test', '2021-05-14', 40000, 2, 'test desc', '2021-05-20 11:47:03', '2021-05-20 11:47:03', NULL);

-- ----------------------------
-- Table structure for outcome_distributions
-- ----------------------------
DROP TABLE IF EXISTS `outcome_distributions`;
CREATE TABLE `outcome_distributions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `outcome_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('agen','yayasan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `campaign_agent_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `nominal` int(11) NOT NULL,
  `biaya_administrasi` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `outcome_distributions_outcome_id_foreign`(`outcome_id`) USING BTREE,
  INDEX `outcome_distributions_campaign_agent_id_foreign`(`campaign_agent_id`) USING BTREE,
  CONSTRAINT `outcome_distributions_campaign_agent_id_foreign` FOREIGN KEY (`campaign_agent_id`) REFERENCES `campaign_agents` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `outcome_distributions_outcome_id_foreign` FOREIGN KEY (`outcome_id`) REFERENCES `outcomes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outcome_distributions
-- ----------------------------
INSERT INTO `outcome_distributions` VALUES (1, 1, 'agen', 1, 50000, 25000, 0, '2021-05-16 21:31:03', '2021-05-20 16:12:32', NULL);
INSERT INTO `outcome_distributions` VALUES (2, 1, 'agen', 2, 75000, 25000, 0, '2021-05-16 21:31:03', '2021-05-16 21:31:03', NULL);
INSERT INTO `outcome_distributions` VALUES (3, 1, 'agen', 3, 50000, 25000, 0, '2021-05-16 21:31:03', '2021-05-16 21:31:03', NULL);
INSERT INTO `outcome_distributions` VALUES (4, 1, 'agen', 4, 105000, 25000, 0, '2021-05-16 21:31:03', '2021-05-16 21:31:03', NULL);
INSERT INTO `outcome_distributions` VALUES (5, 1, 'yayasan', NULL, 50000, 25000, 1, '2021-05-16 21:31:03', '2021-05-16 21:31:03', NULL);
INSERT INTO `outcome_distributions` VALUES (6, 2, 'agen', 1, 50000, 25000, 0, '2021-05-17 09:44:17', '2021-05-17 09:44:17', NULL);
INSERT INTO `outcome_distributions` VALUES (7, 2, 'agen', 2, 75000, 25000, 0, '2021-05-17 09:44:17', '2021-05-17 09:44:17', NULL);
INSERT INTO `outcome_distributions` VALUES (8, 2, 'agen', 3, 50000, 25000, 0, '2021-05-17 09:44:17', '2021-05-17 09:44:17', NULL);
INSERT INTO `outcome_distributions` VALUES (9, 2, 'agen', 4, 105000, 25000, 0, '2021-05-17 09:44:17', '2021-05-17 09:44:17', NULL);

-- ----------------------------
-- Table structure for outcomes
-- ----------------------------
DROP TABLE IF EXISTS `outcomes`;
CREATE TABLE `outcomes`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `outcomes_campaign_id_foreign`(`campaign_id`) USING BTREE,
  CONSTRAINT `outcomes_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outcomes
-- ----------------------------
INSERT INTO `outcomes` VALUES (1, 7, '2021-05-16 21:31:03', '2021-05-16 21:31:03', NULL);
INSERT INTO `outcomes` VALUES (2, 7, '2021-05-17 09:44:17', '2021-05-17 09:44:17', NULL);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'list-agent', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (2, 'assign-agent', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (3, 'create-campaign', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (4, 'update-campaign', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (5, 'delete-campaign', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (6, 'create-income', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (7, 'view-income', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (8, 'create-outcome', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (9, 'view-outcome', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (10, 'list-rekapitulasi', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (11, 'list-campaign-agent', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `permissions` VALUES (12, 'create-distribution-point', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (4, 1);
INSERT INTO `role_has_permissions` VALUES (5, 1);
INSERT INTO `role_has_permissions` VALUES (6, 1);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (8, 1);
INSERT INTO `role_has_permissions` VALUES (9, 1);
INSERT INTO `role_has_permissions` VALUES (10, 1);
INSERT INTO `role_has_permissions` VALUES (11, 2);
INSERT INTO `role_has_permissions` VALUES (12, 2);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Administrator', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');
INSERT INTO `roles` VALUES (2, 'Agen', 'api', '2021-05-16 21:28:07', '2021-05-16 21:28:07');

-- ----------------------------
-- Table structure for user_informations
-- ----------------------------
DROP TABLE IF EXISTS `user_informations`;
CREATE TABLE `user_informations`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `alamat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_informations_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `user_informations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_informations
-- ----------------------------
INSERT INTO `user_informations` VALUES (1, 1, 'Default Administrator', NULL, NULL, '2021-05-16 21:28:07', '2021-05-16 21:28:07', NULL);
INSERT INTO `user_informations` VALUES (2, 2, 'Default Agent 0', NULL, NULL, '2021-05-16 21:28:07', '2021-05-16 21:28:07', NULL);
INSERT INTO `user_informations` VALUES (3, 3, 'Default Agent 1', NULL, NULL, '2021-05-16 21:28:07', '2021-05-16 21:28:07', NULL);
INSERT INTO `user_informations` VALUES (4, 4, 'Default Agent 2', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (5, 5, 'Default Agent 3', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (6, 6, 'Default Agent 4', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (7, 7, 'Default Agent 5', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (8, 8, 'Default Agent 6', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (9, 9, 'Default Agent 7', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (10, 10, 'Default Agent 8', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (11, 11, 'Default Agent 9', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (12, 12, 'Default Agent 10', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (13, 13, 'Default Agent 11', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (14, 14, 'Default Agent 12', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (15, 15, 'Default Agent 13', NULL, NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `user_informations` VALUES (16, 16, 'Default Agent 14', NULL, NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `user_informations` VALUES (17, 17, 'Default Agent 15', NULL, NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `user_informations` VALUES (18, 18, 'Default Agent 16', NULL, NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `user_informations` VALUES (19, 19, 'Default Agent 17', NULL, NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `user_informations` VALUES (20, 20, 'Default Agent 18', NULL, NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `user_informations` VALUES (21, 21, 'Default Agent 19', NULL, NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '930071', NULL, NULL, '$2y$10$7hIW5dc0U..zpXGubjmhS.svinv6hEjHuB2Fx6ROPJNXskeMIJpjq', NULL, '2021-05-16 21:28:07', '2021-05-16 21:28:07', NULL);
INSERT INTO `users` VALUES (2, '900001', NULL, NULL, '$2y$10$rtX61edt9s5AAJURrBIO7.Grt26PF251owZLUowC.8/jrJYTvbBJi', NULL, '2021-05-16 21:28:07', '2021-05-16 21:28:07', NULL);
INSERT INTO `users` VALUES (3, '900002', NULL, NULL, '$2y$10$pJStm/lnjm0immFIayyYSenP1n9sH21048X/qCFNXYKlDqkYfTJMq', NULL, '2021-05-16 21:28:07', '2021-05-16 21:28:07', NULL);
INSERT INTO `users` VALUES (4, '900003', NULL, NULL, '$2y$10$7zOvVTNUWTXpBIDV.zJ9Z.Xmp3BbdkAU2hWx0JY8x.9CFqHuobe/q', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (5, '900004', NULL, NULL, '$2y$10$6aC0vi3qr46inxm6d5iyleqJTGM1GTaZNKRLzqgejvmFf8T4GtXO.', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (6, '900005', NULL, NULL, '$2y$10$5y/R9kFu3xlQZk2IXyzIsO872edVskMWV139IcyNMSZ4vOIDuG1zS', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (7, '900006', NULL, NULL, '$2y$10$Ea1Ks8Ke3qsw9BvMcLwxteyT4klPcSE0TWjJIkPuNVP27OZevDzIi', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (8, '900007', NULL, NULL, '$2y$10$nXax.0U2pBS0hcDoEJZpoeqwcwtyioBkW9FpRfCHM83azownKai/u', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (9, '900008', NULL, NULL, '$2y$10$//iDA3QzT4Q5OER.5nKDnevXSQHD.b7RItjt4pSckey24OuN.SKqS', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (10, '900009', NULL, NULL, '$2y$10$e36leUSJmzOm8qhFnLUyJOMUMxIMpbxs.hB2WMIiqd2uBZLqeUqz2', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (11, '900010', NULL, NULL, '$2y$10$EGhwzbMd8zgzU09NKcRWb.5gaPSCbt1LpOlGJ2vdOP2d0/aCCnrq.', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (12, '900011', NULL, NULL, '$2y$10$t.Ul3BGoFNOYVoz02gE5ceP/9T7FsiHs2v97VQwxhuoGC/Zw2pVc2', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (13, '900012', NULL, NULL, '$2y$10$VnnRiHMVT4ue2IBpgDxZZuwwvEBZ/nbDjhZ0XuG5zJX9mb781CMUW', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (14, '900013', NULL, NULL, '$2y$10$HFvpEDOLco5hFXR1lP3wxeL9EVsg/IghMVqgLNtQJjI6MiJx8ThgC', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (15, '900014', NULL, NULL, '$2y$10$8L8TWGBW0OMdDYyzY1RXDeJZ.0rWTjTvLNPmu0IgaMsrzeyGaBcTW', NULL, '2021-05-16 21:28:08', '2021-05-16 21:28:08', NULL);
INSERT INTO `users` VALUES (16, '900015', NULL, NULL, '$2y$10$C5CtuQr58sVCjx9G/ckqyOy5ruY.DlZ77mg0JMxM.iGSx7EqNx.gW', NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `users` VALUES (17, '900016', NULL, NULL, '$2y$10$50.f2Ck3Q4h/CzfwMgku6e6A4/FQMAlQC8RapSmSBlb.Rkoq8mH2y', NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `users` VALUES (18, '900017', NULL, NULL, '$2y$10$T9wl4HhuPt.ahY6mYaQEPOhclFIujI3JPnqaiwVGsRod3mCLP1BR2', NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `users` VALUES (19, '900018', NULL, NULL, '$2y$10$tXbK2x.yNACTkCv9tb.YoO20izvm0/h6t.FaDn7807pTd2yJy6G6K', NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `users` VALUES (20, '900019', NULL, NULL, '$2y$10$3v0aZtGR1iM7WRqRO0zMR.efNOufDq2i.w7g6qEyL/rPgpirWdA.a', NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);
INSERT INTO `users` VALUES (21, '900020', NULL, NULL, '$2y$10$Alu3jUCG7LKU.gCR8zvf.OZS1Y.kb0Fatxf0WPRLkFB4gVNaMTSrC', NULL, '2021-05-16 21:28:09', '2021-05-16 21:28:09', NULL);

-- ----------------------------
-- View structure for rekapitulasi_pendanaan
-- ----------------------------
DROP VIEW IF EXISTS `rekapitulasi_pendanaan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `rekapitulasi_pendanaan` AS select distinct 'income' AS `type`,`a`.`campaign_id` AS `campaign_id`,sum(`b`.`nominal`) AS `nominal`,`a`.`sumber_dana` AS `sumber_dana`,`a`.`id` AS `pendanaan_id`,`a`.`created_at` AS `created_at` from (`incomes` `a` join `income_details` `b` on(`b`.`income_id` = `a`.`id`)) group by `a`.`campaign_id`,`a`.`id`,`a`.`sumber_dana`,`a`.`created_at` union select distinct 'outcome' AS `type`,`a`.`campaign_id` AS `campaign_id`,sum(`b`.`nominal`) + sum(`b`.`biaya_administrasi`) AS `nominal`,'' AS `sumber_dana`,`a`.`id` AS `pendanaan_id`,`a`.`created_at` AS `created_at` from (`outcomes` `a` left join `outcome_distributions` `b` on(`b`.`outcome_id` = `a`.`id`)) group by `a`.`campaign_id`,`a`.`id`,`a`.`created_at`;

SET FOREIGN_KEY_CHECKS = 1;
