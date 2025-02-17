CREATE TABLE IF NOT EXISTS `poi` (
	`poi_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`poi_name` varchar(25) NOT NULL,
	`poi_discription` varchar(255) NOT NULL,
	`coordinate_id` int NOT NULL,
	`landmark_id` int NOT NULL,
	`category_id` int NOT NULL,
	PRIMARY KEY (`poi_id`)
);

CREATE TABLE IF NOT EXISTS `landmark` (
	`landmark_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`landmark_discription` varchar(50) NOT NULL,
	PRIMARY KEY (`landmark_id`)
);

CREATE TABLE IF NOT EXISTS `rating` (
	`rating_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_id` int NOT NULL,
	`poi_id` int NOT NULL,
	`rating_comment` varchar(300) NOT NULL,
	`rating_star` int NOT NULL,
	PRIMARY KEY (`rating_id`)
);

CREATE TABLE IF NOT EXISTS `user` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_name` varchar(36) NOT NULL,
	`user_email` varchar(100) NOT NULL,
	`user_password` varchar(256) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `coordinate` (
	`coordinate_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`coordinate_latitude` double NOT NULL,
	`coordinate_longitude` double NOT NULL,
	PRIMARY KEY (`coordinate_id`)
);

CREATE TABLE IF NOT EXISTS `category` (
	`category_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`category_name` varchar(255) NOT NULL,
	PRIMARY KEY (`category_id`)
);

ALTER TABLE `poi` ADD CONSTRAINT `poi_fk3` FOREIGN KEY (`coordinate_id`) REFERENCES `coordinate`(`coordinate_id`);

ALTER TABLE `poi` ADD CONSTRAINT `poi_fk4` FOREIGN KEY (`landmark_id`) REFERENCES `landmark`(`landmark_id`);

ALTER TABLE `poi` ADD CONSTRAINT `poi_fk5` FOREIGN KEY (`category_id`) REFERENCES `category`(`category_id`);

ALTER TABLE `rating` ADD CONSTRAINT `rating_fk1` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `rating` ADD CONSTRAINT `rating_fk2` FOREIGN KEY (`poi_id`) REFERENCES `poi`(`poi_id`);


