SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema technicalsharedb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `technicalsharedb` ;
USE `technicalsharedb` ;

-- -----------------------------------------------------
-- Table `technicalsharedb`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technicalsharedb`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `habilidade` VARCHAR(45) NULL,
  `linkedin` VARCHAR(100) NULL,
  `teams` VARCHAR(100) NULL,
  `whatsapp` VARCHAR(100) NULL,
  `is_mentor` TINYINT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE USER 'technicalsharesys'@'localhost' IDENTIFIED BY '$uC0D3l@R4nJa';
GRANT ALL ON `technicalsharedb`.* TO 'technicalsharesys'@'localhost';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;