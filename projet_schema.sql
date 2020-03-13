CREATE SCHEMA `exam_php` DEFAULT CHARACTER SET utf8mb4 ;

CREATE TABLE `exam_php`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `photo` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login` (`login` ASC));


CREATE TABLE `exam_php`.`messages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  `content` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC));

CREATE TABLE `exam_php`.`groups` (
   `id` INT NOT NULL AUTO_INCREMENT,
   `title` VARCHAR(255) NOT NULL,
   `creator_id` INT NOT NULL,
   `member_id` INT NOT NULL,
   PRIMARY KEY (`id`),
   INDEX `creator_id` (`creator_id` ASC));
