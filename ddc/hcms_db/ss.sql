SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `secure_sessions` DEFAULT CHARACTER SET latin1 ;
USE `secure_sessions` ;

-- -----------------------------------------------------
-- Table `secure_sessions`.`sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `secure_sessions`.`sessions` (
  `id` CHAR(128) NOT NULL ,
  `set_time` CHAR(10) NOT NULL ,
  `data` TEXT NOT NULL ,
  `session_key` CHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf-8;

USE `secure_sessions` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
