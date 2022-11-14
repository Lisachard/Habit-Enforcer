CREATE TABLE `Party`(
    `party_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `score` INT NOT NULL
);

CREATE TABLE `Member`(
    `member_id` CHAR(36) NOT NULL PRIMARY KEY,
    `pseudo` CHAR(255) NOT NULL,
    `email` CHAR(255) NOT NULL,
    `password` CHAR(255) NOT NULL,
    `profile_picture` CHAR(255) NOT NULL,
    `party_id` INT NULL,
    FOREIGN KEY(`party_id`) REFERENCES `Party`(`party_id`) ON DELETE SET NULL
);

CREATE TABLE `Habit`(
    `habit_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `label` CHAR(255) NOT NULL,
    `difficulty` SMALLINT NOT NULL,
    `color` CHAR(255) NOT NULL,
    `member_id` CHAR(36) NOT NULL,
    FOREIGN KEY(`member_id`) REFERENCES `Member`(`member_id`) ON DELETE CASCADE
);