CREATE TABLE `mamona` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `data` date DEFAULT current_timestamp(),
  `foto` longblob DEFAULT NULL,
  `descricao` longblob DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
