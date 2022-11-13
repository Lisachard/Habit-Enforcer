CREATE TABLE `Party`(
    `party_id` INT NOT NULL,
    `score` INT NOT NULL,
    PRIMARY KEY(`party_id`)
);

CREATE TABLE `Member`(
    `member_id` CHAR(36) NOT NULL,
    `pseudo` CHAR(255) NOT NULL,
    `email` CHAR(255) NOT NULL,
    `password` CHAR(255) NOT NULL,
    `profile_picture` CHAR(255) NOT NULL,
    `party_id` INT NULL,
    PRIMARY KEY(`member_id`),
    FOREIGN KEY(`party_id`) REFERENCES `Party`(`party_id`) ON DELETE SET NULL
);

CREATE TABLE `Habit`(
    `habit_id` INT NOT NULL,
    `label` CHAR(255) NOT NULL,
    `difficulty` SMALLINT NOT NULL,
    `color` CHAR(255) NOT NULL,
    `member_id` CHAR(36) NOT NULL,
    PRIMARY KEY(`habit_id`),
    FOREIGN KEY(`member_id`) REFERENCES `Membre`(`member_id`) ON DELETE CASCADE
);