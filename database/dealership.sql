-- MySQL Script generated by MySQL Workbench
-- Tue Mar  3 23:46:58 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
/*CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;*/



-- -----------------------------------------------------
-- Table `mydb`.`buyers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `buyers` ;

CREATE TABLE IF NOT EXISTS `buyers` (
  `buyers_id` INT NOT NULL AUTO_INCREMENT,
  `last_name` VARCHAR(255)  NULL DEFAULT 'Null',
  `first_name` VARCHAR(32) NULL DEFAULT 'Null',
  `phone` INT NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT 'Null',
  `address` VARCHAR(255) NULL,
  `address_two` VARCHAR(255) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(2) NULL,
  `zip` INT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`buyers_id`),
  CONSTRAINT UNIQUE (`last_name`, `first_name`)
  );


-- -----------------------------------------------------
-- Table `mydb`.`cars_sold`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cars_sold` ;

CREATE TABLE IF NOT EXISTS `cars_sold` (
  `car_id` INT NOT NULL AUTO_INCREMENT,
  `cars_info` VARCHAR(255) NOT NULL UNIQUE,
  `make` VARCHAR(255) NULL,
  `model` VARCHAR(255) NULL,
  `year` INT NULL,
  `cost` INT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`car_id`));


/*CREATE UNIQUE INDEX `category_id_UNIQUE` ON `cars_sold` (`cars_id` ASC) VISIBLE;*/


-- -----------------------------------------------------
-- Table `mydb`.`payment_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `payment_type` ;

CREATE TABLE IF NOT EXISTS `payment_type` (
  `card_id` INT NOT NULL AUTO_INCREMENT,
  `card_number` VARCHAR(16) NOT NULL,
  `name` VARCHAR(255) NULL,
  `exp_month` VARCHAR(15) NULL,
  `exp_year` INT NULL,
  `cvv` INT NULL,
  `type` VARCHAR(45) NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`card_id`),
  CONSTRAINT UNIQUE (`card_number`, `type`)
  );


-- -----------------------------------------------------
-- Table `mydb`.`transaction`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `transaction` ;

CREATE TABLE IF NOT EXISTS `transaction` (
  `buyers_id` INT NOT NULL,
  `car_id` INT NOT NULL UNIQUE,
  `payment_id` INT NOT NULL,
  `transaction_id` INT NOT NULL AUTO_INCREMENT,
  `sold` INT NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`transaction_id`),
  CONSTRAINT `buyers_id`
    FOREIGN KEY (`buyers_id`)
    REFERENCES `buyers` (`buyers_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `car_id`
    FOREIGN KEY (`car_id`)
    REFERENCES `cars_sold` (`car_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `payment_id`
    FOREIGN KEY (`payment_id`)
    REFERENCES `payment_type` (`card_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

/*CREATE INDEX `cars_id_idx` ON `transaction` (`cars_id` ASC) VISIBLE;

CREATE INDEX `buyers_id_idx` ON `transaction` (`buyers_id` ASC) VISIBLE;

CREATE INDEX `payment_id_idx` ON `transaction` (`payment_id` ASC) VISIBLE;*/


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
