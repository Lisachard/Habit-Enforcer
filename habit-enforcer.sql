CREATE TABLE `Party`(
    `party_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `score` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `Member`(
    `member_id` CHAR(36) NOT NULL PRIMARY KEY,
    `pseudo` CHAR(255) NOT NULL UNIQUE,
    `email` CHAR(255) NOT NULL UNIQUE,
    `password` CHAR(255) NOT NULL,
    `profile_picture` CHAR(255) NOT NULL,
    `party_id` INT NULL,
    FOREIGN KEY(`party_id`) REFERENCES `Party`(`party_id`) ON DELETE SET NULL
);

CREATE TABLE `Habit`(
    `habit_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `label` CHAR(255) NOT NULL UNIQUE,
    `difficulty` SMALLINT NOT NULL,
    `color` CHAR(255) NOT NULL,
    `member_id` CHAR(36) NOT NULL,
    `is_daily` BOOLEAN NOT NULL,
    `checked` BOOLEAN NOT NULL DEFAULT FALSE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(`member_id`) REFERENCES `Member`(`member_id`) ON DELETE CASCADE
);

CREATE TABLE `Invitation`(
    `email` CHAR(255) NOT NULL,
    `invite_party_id` INT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(`email`) REFERENCES `Member`(`email`),
    FOREIGN KEY(`invite_party_id`) REFERENCES `Party`(`party_id`)
);