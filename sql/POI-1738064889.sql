CREATE TABLE IF NOT EXISTS `c8m6k_poi` (
	`poi_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`poi_name` varchar(25) NOT NULL,
	`poi_discription` varchar(255) NOT NULL,
	`coordinate_id` int NOT NULL,
	`landmark_id` int NOT NULL,
	`category_id` int NOT NULL,
	`user_id` int NOT NULL,
	PRIMARY KEY (`poi_id`)
);

CREATE TABLE IF NOT EXISTS `c8m6k_landmark` (
	`landmark_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`landmark_discription` varchar(50) NOT NULL,
	PRIMARY KEY (`landmark_id`)
);

CREATE TABLE IF NOT EXISTS `c8m6k_rating` (
	`rating_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_id` int NOT NULL,
	`poi_id` int NOT NULL,
	`rating_comment` varchar(300) NOT NULL,
	`rating_star` int NOT NULL,
	PRIMARY KEY (`rating_id`)
);

CREATE TABLE IF NOT EXISTS `c8m6k_user` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_name` varchar(36) NOT NULL,
	`user_email` varchar(100) NOT NULL,
	`user_password` varchar(256) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `c8m6k_coordinate` (
	`coordinate_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`coordinate_latitude` double NOT NULL,
	`coordinate_longitude` double NOT NULL,
	PRIMARY KEY (`coordinate_id`)
);

CREATE TABLE IF NOT EXISTS `c8m6k_category` (
	`category_id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`category_name` varchar(30) NOT NULL,
	PRIMARY KEY (`category_id`)
);

ALTER TABLE `c8m6k_poi` ADD CONSTRAINT `poi_fk3` FOREIGN KEY (`coordinate_id`) REFERENCES `c8m6k_coordinate`(`coordinate_id`);

ALTER TABLE `c8m6k_poi` ADD CONSTRAINT `poi_fk4` FOREIGN KEY (`landmark_id`) REFERENCES `c8m6k_landmark`(`landmark_id`);

ALTER TABLE `c8m6k_poi` ADD CONSTRAINT `poi_fk5` FOREIGN KEY (`category_id`) REFERENCES `c8m6k_category`(`category_id`);

ALTER TABLE `c8m6k_poi` ADD CONSTRAINT `poi_fk6` FOREIGN KEY (`user_id`) REFERENCES `c8m6k_user`(`user_id`);

ALTER TABLE `c8m6k_rating` ADD CONSTRAINT `rating_fk1` FOREIGN KEY (`user_id`) REFERENCES `c8m6k_user`(`id`);

ALTER TABLE `c8m6k_rating` ADD CONSTRAINT `rating_fk2` FOREIGN KEY (`poi_id`) REFERENCES `c8m6k_poi`(`poi_id`);


