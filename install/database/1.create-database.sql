-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema technicalsharedb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `technicalsharedb` ;
USE `technicalsharedb` ;

-- -----------------------------------------------------
-- Table `technicalsharedb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technicalsharedb`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `position` VARCHAR(40) NOT NULL,
  `level` VARCHAR(40) NOT NULL,
  `isMentor` TINYINT NOT NULL DEFAULT 0,
  `techs` VARCHAR(255) NOT NULL,
  `linkedin` VARCHAR(100) NULL,
  `teams` VARCHAR(100) NULL,
  `whatsapp` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;

-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;