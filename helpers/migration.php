<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/helpers/db.php';

$db->query("CREATE TABLE IF NOT EXISTS `cities` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(64) NOT NULL , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB;");

$db->query("CREATE TABLE IF NOT EXISTS `sightseen` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
    `name_sightseen` VARCHAR(128) NOT NULL , 
    `city_id` INT UNSIGNED NOT NULL , 
    `distance` TINYINT UNSIGNED NOT NULL , 
    `average` TINYINT UNSIGNED NULL DEFAULT NULL , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB;");

$db->query("CREATE TABLE IF NOT EXISTS `traveler` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(128) NOT NULL , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB;");

$db->query("CREATE TABLE IF NOT EXISTS `city_sight` ( 
    `id_city` INT UNSIGNED NOT NULL , 
    `id_sightseen` INT UNSIGNED NOT NULL , 
    PRIMARY KEY (`id_city`, `id_sightseen`)) ENGINE = InnoDB;");

$db->query("CREATE TABLE IF NOT EXISTS `visited_sight` ( 
    `id_traveler` INT UNSIGNED NOT NULL , 
    `id_sightseen` INT UNSIGNED NOT NULL ,
    `rating` TINYINT UNSIGNED NOT NULL , 
    PRIMARY KEY (`id_traveler`, `id_sightseen`)) ENGINE = InnoDB;");

$db->query("CREATE TABLE IF NOT EXISTS `traveler_route` ( 
    `id_city` INT UNSIGNED NOT NULL , 
    `id_traveler` INT UNSIGNED NOT NULL , 
    PRIMARY KEY (`id_city`, `id_traveler`)) ENGINE = InnoDB;");

$db->query("INSERT INTO `sightseen` (`id`, `name_sightseen`, `city_id`, `distance`, `average`) VALUES
(1, 'Saint Pietro', 5, 10, NULL),
(2, 'Colosseum', 5, 3, NULL),
(3, 'Big Ben', 1, 7, NULL),
(4, 'Kremlin', 3, 1, NULL),
(5, 'Eifel tower', 2, 8, NULL),
(6, 'Hermitage', 6, 7, NULL),
(7, 'Red square', 3, 1, NULL),
(8, 'Central park', 4, 5, NULL),
(9, 'Statue of Liberty', 4, 22, NULL);");

$db->query("INSERT INTO `traveler` (`id`, `name`) VALUES
(1, 'John'),
(2, 'Alex'),
(3, 'Dima'),
(4, 'Octavian');");

$db->query("INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'London'),
(2, 'Paris'),
(3, 'Moscow'),
(4, 'New-York'),
(5, 'Rome'),
(6, 'Saint-Petersburg');");

$db->query("INSERT INTO `traveler_route` (`id_city`, `id_traveler`) VALUES
(5, 1),
(2, 1),
(3, 1),
(5, 2),
(1, 3),
(4, 3),
(3, 3),
(6, 3),
(3, 4),
(4, 4);");

$db->query("INSERT INTO `city_sight` (`id_city`, `id_sightseen`) VALUES
(1, 3),
(2, 5),
(3, 4),
(3, 7),
(4, 8),
(4, 9),
(5, 1),
(5, 2),
(6, 6);");

$db->query("INSERT INTO `visited_sight` (`id_traveler`, `id_sightseen`, `rating`) VALUES
(1, 1, 9),
(3, 3, 6),
(4, 4, 10),
(1, 5, 8),
(3, 6, 7),
(3, 7, 4),
(3, 8, 7),
(4, 9, 9),
(1, 4, 3),
(1, 2, 5),
(2, 2, 9),
(2, 1, 10),
(1, 7, 9);");

$db = null;
