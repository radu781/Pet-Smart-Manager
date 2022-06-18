CREATE TABLE `group_members` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `group_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `flags` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `owned_pets` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `pet_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `pet_info` (
    `id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `restrictions` varchar(255) DEFAULT NULL,
    `medical_history` varchar(255) DEFAULT NULL,
    `relationships` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `pet_meals` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `pet_id` int(11) NOT NULL,
    `feed_time` time NOT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `pet_media` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `pet_id` int(11) NOT NULL,
    `filename` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `firstname` varchar(255) NOT NULL,
    `middlename` varchar(255) DEFAULT NULL,
    `lastname` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);
