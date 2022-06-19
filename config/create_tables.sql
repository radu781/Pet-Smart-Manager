CREATE TABLE `group_members` (
    `id` int NOT NULL AUTO_INCREMENT,
    `group_id` int NOT NULL,
    `user_id` int NOT NULL,
    `flags` int DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `groups` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `owned_pets` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `pet_id` int NOT NULL,
    `user_id` int NOT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `pet_info` (
    `id` int NOT NULL,
    `name` varchar(255) NOT NULL,
    `restrictions` varchar(255) DEFAULT NULL,
    `medical_history` varchar(255) DEFAULT NULL,
    `relationships` varchar(255) DEFAULT NULL,
    `breed` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `pet_meals` (
    `id` int NOT NULL AUTO_INCREMENT,
    `pet_id` int NOT NULL,
    `feed_time` time NOT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `pet_media` (
    `id` int NOT NULL AUTO_INCREMENT,
    `pet_id` int NOT NULL,
    `filename` varchar(255) NOT NULL,
    `description` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `firstname` varchar(255) NOT NULL,
    `middlename` varchar(255) DEFAULT NULL,
    `lastname` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);
