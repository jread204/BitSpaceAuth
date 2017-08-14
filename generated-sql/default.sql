
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- groups
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `groupId` INTEGER NOT NULL,
    `role` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `roles_ibfi_1` (`groupId`),
    CONSTRAINT `roles_ibfk_1`
        FOREIGN KEY (`groupId`)
        REFERENCES `groups` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usergroup
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usergroup`;

CREATE TABLE `usergroup`
(
    `User_Id` INTEGER NOT NULL,
    `Group_Id` INTEGER NOT NULL,
    `Role_id` INTEGER,
    PRIMARY KEY (`User_Id`,`Group_Id`),
    INDEX `fi_ups_FK` (`Group_Id`),
    INDEX `fi_ething_FK` (`Role_id`),
    CONSTRAINT `Groups_FK`
        FOREIGN KEY (`Group_Id`)
        REFERENCES `groups` (`id`),
    CONSTRAINT `Users_FK`
        FOREIGN KEY (`User_Id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `something_FK`
        FOREIGN KEY (`Role_id`)
        REFERENCES `roles` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `remember_me` VARCHAR(255),
    `enrollmentId` VARCHAR(255),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username` (`username`),
    UNIQUE INDEX `email` (`email`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
