CREATE TABLE `Groupe`(
    `group_id` INT NOT NULL,
    `score` INT NOT NULL,
    `member_id` CHAR(36) NOT NULL,
    PRIMARY KEY(`group_id`)
);

CREATE TABLE `Membre`(
    `member_id` CHAR(36) NOT NULL,
    `pseudo` CHAR(255) NOT NULL,
    `email` CHAR(255) NOT NULL,
    `password` CHAR(255) NOT NULL,
    `profile_picture` CHAR(255) NOT NULL,
    `group_id` INT NULL,
    PRIMARY KEY(`member_id`),
    FOREIGN KEY(`group_id`) REFERENCES `Groupe`(`group_id`) ON DELETE SET NULL
);

CREATE TABLE `Habitude`(
    `habit_id` INT NOT NULL,
    `label` CHAR(255) NOT NULL,
    `difficulty` SMALLINT NOT NULL,
    `color` CHAR(255) NOT NULL,
    `member_id` CHAR(36) NOT NULL,
    PRIMARY KEY(`habit_id`),
    FOREIGN KEY(`member_id`) REFERENCES `Membre`(`member_id`) ON DELETE CASCADE
);