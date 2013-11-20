SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `satod` ;
CREATE SCHEMA IF NOT EXISTS `satod` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `satod` ;

-- -----------------------------------------------------
-- Table `satod`.`clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`clientes` ;

CREATE TABLE IF NOT EXISTS `satod`.`clientes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  `idLogisis` INT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `satod`.`costos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`costos` ;

CREATE TABLE IF NOT EXISTS `satod`.`costos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `valor` VARCHAR(45) NULL,
  `tipo` VARCHAR(45) NULL,
  `parent_id` INT UNSIGNED NULL DEFAULT NULL,
  `lft` INT NULL DEFAULT NULL,
  `rght` INT NULL DEFAULT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_costos_costos1_idx` (`parent_id` ASC),
  CONSTRAINT `fk_costos_costos1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `satod`.`costos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`estrategias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`estrategias` ;

CREATE TABLE IF NOT EXISTS `satod`.`estrategias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`indicadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`indicadores` ;

CREATE TABLE IF NOT EXISTS `satod`.`indicadores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `etiqueta` VARCHAR(45) NOT NULL,
  `tipo` VARCHAR(45) NULL,
  `calculo` VARCHAR(45) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`indicadores_valores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`indicadores_valores` ;

CREATE TABLE IF NOT EXISTS `satod`.`indicadores_valores` (
  `id` INT UNSIGNED NULL AUTO_INCREMENT,
  `valor` VARCHAR(45) NULL,
  `valor_ponderado` VARCHAR(45) NULL,
  `valor_calculo` VARCHAR(45) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  `indicadores_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_indicadores_valores_indicadores1_idx` (`indicadores_id` ASC),
  CONSTRAINT `fk_indicadores_valores_indicadores1`
    FOREIGN KEY (`indicadores_id`)
    REFERENCES `satod`.`indicadores` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`carteras`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`carteras` ;

CREATE TABLE IF NOT EXISTS `satod`.`carteras` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `idAsignacionLogisis` INT NULL,
  `clientes_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_carteras_clientes1_idx` (`clientes_id` ASC),
  CONSTRAINT `fk_carteras_clientes1`
    FOREIGN KEY (`clientes_id`)
    REFERENCES `satod`.`clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`columnasCartera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`columnasCartera` ;

CREATE TABLE IF NOT EXISTS `satod`.`columnasCartera` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `etiqueta` VARCHAR(45) NULL,
  `calculo` VARCHAR(45) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`carteras_indicadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`carteras_indicadores` ;

CREATE TABLE IF NOT EXISTS `satod`.`carteras_indicadores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `indicadores_id` INT UNSIGNED NOT NULL,
  `carteras_id` INT UNSIGNED NOT NULL,
  `indicadores_valores_id` INT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_indicadores_has_carteras_carteras1_idx` (`carteras_id` ASC),
  INDEX `fk_indicadores_has_carteras_indicadores1_idx` (`indicadores_id` ASC),
  CONSTRAINT `fk_indicadores_has_carteras_indicadores1`
    FOREIGN KEY (`indicadores_id`)
    REFERENCES `satod`.`indicadores` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_indicadores_has_carteras_carteras1`
    FOREIGN KEY (`carteras_id`)
    REFERENCES `satod`.`carteras` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`costos_estrategias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`costos_estrategias` ;

CREATE TABLE IF NOT EXISTS `satod`.`costos_estrategias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `costos_id` INT UNSIGNED NOT NULL,
  `estrategias_id` INT UNSIGNED NOT NULL,
  `multiplicador` INT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_costos_has_estrategias_estrategias1_idx` (`estrategias_id` ASC),
  INDEX `fk_costos_has_estrategias_costos1_idx` (`costos_id` ASC),
  CONSTRAINT `fk_costos_has_estrategias_costos1`
    FOREIGN KEY (`costos_id`)
    REFERENCES `satod`.`costos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_costos_has_estrategias_estrategias1`
    FOREIGN KEY (`estrategias_id`)
    REFERENCES `satod`.`estrategias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`filasCartera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`filasCartera` ;

CREATE TABLE IF NOT EXISTS `satod`.`filasCartera` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = big5
COLLATE = big5_chinese_ci;


-- -----------------------------------------------------
-- Table `satod`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`users` ;

CREATE TABLE IF NOT EXISTS `satod`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NULL,
  `password` VARCHAR(50) NULL,
  `role` VARCHAR(20) NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
