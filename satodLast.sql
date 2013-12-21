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
  `nombre` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NOT NULL,
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
  `nombre` VARCHAR(45) NOT NULL,
  `valor` VARCHAR(45) NOT NULL,
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
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(255) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `satod`.`indicadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`indicadores` ;

CREATE TABLE IF NOT EXISTS `satod`.`indicadores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `etiqueta` VARCHAR(45) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `calculo` VARCHAR(45) NULL,
  `grafica` VARCHAR(45) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `satod`.`indicadores_valores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`indicadores_valores` ;

CREATE TABLE IF NOT EXISTS `satod`.`indicadores_valores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
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
    ON DELETE CASCADE
    ON UPDATE CASCADE)
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
  `comision` FLOAT NULL,
  `clientes_id` INT UNSIGNED NOT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_carteras_clientes1_idx` (`clientes_id` ASC),
  CONSTRAINT `fk_carteras_clientes1`
    FOREIGN KEY (`clientes_id`)
    REFERENCES `satod`.`clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


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
-- Table `satod`.`planificaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`planificaciones` ;

CREATE TABLE IF NOT EXISTS `satod`.`planificaciones` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  `carteras_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_planificaciones_carteras1_idx` (`carteras_id` ASC),
  CONSTRAINT `fk_planificaciones_carteras1`
    FOREIGN KEY (`carteras_id`)
    REFERENCES `satod`.`carteras` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `satod`.`detalles_planificaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`detalles_planificaciones` ;

CREATE TABLE IF NOT EXISTS `satod`.`detalles_planificaciones` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `estrategias_id` INT UNSIGNED NOT NULL,
  `carteras_indicadores_id` INT UNSIGNED NOT NULL,
  `planificaciones_id` INT UNSIGNED NOT NULL,
  `created` VARCHAR(45) NULL,
  `modified` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_detalles_planificaciones_estrategias1_idx` (`estrategias_id` ASC),
  INDEX `fk_detalles_planificaciones_planificaciones1_idx` (`planificaciones_id` ASC),
  CONSTRAINT `fk_detalles_planificaciones_estrategias1`
    FOREIGN KEY (`estrategias_id`)
    REFERENCES `satod`.`estrategias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalles_planificaciones_planificaciones1`
    FOREIGN KEY (`planificaciones_id`)
    REFERENCES `satod`.`planificaciones` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `satod`.`pagos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`pagos` ;

CREATE TABLE IF NOT EXISTS `satod`.`pagos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL,
  `monto` FLOAT NULL,
  `comision` FLOAT NULL,
  `idImportacion` VARCHAR(45) NULL,
  `carteras_id` INT UNSIGNED NOT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pagos_carteras1_idx` (`carteras_id` ASC),
  CONSTRAINT `fk_pagos_carteras1`
    FOREIGN KEY (`carteras_id`)
    REFERENCES `satod`.`carteras` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `satod`.`tmp_cartera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`tmp_cartera` ;

CREATE TABLE IF NOT EXISTS `satod`.`tmp_cartera` (
  `col0` TEXT NULL DEFAULT NULL,
  `col1` TEXT NULL DEFAULT NULL,
  `col2` TEXT NULL DEFAULT NULL,
  `col3` TEXT NULL DEFAULT NULL,
  `col4` TEXT NULL DEFAULT NULL,
  `col5` TEXT NULL DEFAULT NULL,
  `col6` TEXT NULL DEFAULT NULL,
  `col7` TEXT NULL DEFAULT NULL,
  `col8` TEXT NULL DEFAULT NULL,
  `col9` TEXT NULL DEFAULT NULL,
  `col10` TEXT NULL DEFAULT NULL,
  `col11` TEXT NULL DEFAULT NULL,
  `col12` TEXT NULL DEFAULT NULL,
  `col13` TEXT NULL DEFAULT NULL,
  `col14` TEXT NULL DEFAULT NULL,
  `col15` TEXT NULL DEFAULT NULL,
  `col16` TEXT NULL DEFAULT NULL,
  `col17` TEXT NULL DEFAULT NULL,
  `col18` TEXT NULL DEFAULT NULL,
  `col19` TEXT NULL DEFAULT NULL,
  `col20` TEXT NULL DEFAULT NULL,
  `col21` TEXT NULL DEFAULT NULL,
  `col22` TEXT NULL DEFAULT NULL,
  `col23` TEXT NULL DEFAULT NULL,
  `col24` TEXT NULL DEFAULT NULL,
  `col25` TEXT NULL DEFAULT NULL,
  `col26` TEXT NULL DEFAULT NULL,
  `col27` TEXT NULL DEFAULT NULL,
  `col28` TEXT NULL DEFAULT NULL,
  `col29` TEXT NULL DEFAULT NULL,
  `col30` TEXT NULL DEFAULT NULL,
  `col31` TEXT NULL DEFAULT NULL,
  `col32` TEXT NULL DEFAULT NULL,
  `col33` TEXT NULL DEFAULT NULL,
  `col34` TEXT NULL DEFAULT NULL,
  `col35` TEXT NULL DEFAULT NULL,
  `col36` TEXT NULL DEFAULT NULL,
  `col37` TEXT NULL DEFAULT NULL,
  `col38` TEXT NULL DEFAULT NULL,
  `col39` TEXT NULL DEFAULT NULL,
  `col40` TEXT NULL DEFAULT NULL,
  `col41` TEXT NULL DEFAULT NULL,
  `col42` TEXT NULL DEFAULT NULL,
  `col43` TEXT NULL DEFAULT NULL,
  `col44` TEXT NULL DEFAULT NULL,
  `col45` TEXT NULL DEFAULT NULL,
  `col46` TEXT NULL DEFAULT NULL,
  `col47` TEXT NULL DEFAULT NULL,
  `col48` TEXT NULL DEFAULT NULL,
  `col49` TEXT NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `satod`.`tmp_pagos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`tmp_pagos` ;

CREATE TABLE IF NOT EXISTS `satod`.`tmp_pagos` (
  `col0` TEXT NULL DEFAULT NULL,
  `col1` TEXT NULL DEFAULT NULL,
  `col2` TEXT NULL DEFAULT NULL,
  `col3` TEXT NULL DEFAULT NULL,
  `col4` TEXT NULL DEFAULT NULL,
  `col5` TEXT NULL DEFAULT NULL,
  `col6` TEXT NULL DEFAULT NULL,
  `col7` TEXT NULL DEFAULT NULL,
  `col8` TEXT NULL DEFAULT NULL,
  `col9` TEXT NULL DEFAULT NULL,
  `col10` TEXT NULL DEFAULT NULL,
  `col11` TEXT NULL DEFAULT NULL,
  `col12` TEXT NULL DEFAULT NULL,
  `col13` TEXT NULL DEFAULT NULL,
  `col14` TEXT NULL DEFAULT NULL,
  `col15` TEXT NULL DEFAULT NULL,
  `col16` TEXT NULL DEFAULT NULL,
  `col17` TEXT NULL DEFAULT NULL,
  `col18` TEXT NULL DEFAULT NULL,
  `col19` TEXT NULL DEFAULT NULL,
  `col20` TEXT NULL DEFAULT NULL,
  `col21` TEXT NULL DEFAULT NULL,
  `col22` TEXT NULL DEFAULT NULL,
  `col23` TEXT NULL DEFAULT NULL,
  `col24` TEXT NULL DEFAULT NULL,
  `col25` TEXT NULL DEFAULT NULL,
  `col26` TEXT NULL DEFAULT NULL,
  `col27` TEXT NULL DEFAULT NULL,
  `col28` TEXT NULL DEFAULT NULL,
  `col29` TEXT NULL DEFAULT NULL,
  `col30` TEXT NULL DEFAULT NULL,
  `col31` TEXT NULL DEFAULT NULL,
  `col32` TEXT NULL DEFAULT NULL,
  `col33` TEXT NULL DEFAULT NULL,
  `col34` TEXT NULL DEFAULT NULL,
  `col35` TEXT NULL DEFAULT NULL,
  `col36` TEXT NULL DEFAULT NULL,
  `col37` TEXT NULL DEFAULT NULL,
  `col38` TEXT NULL DEFAULT NULL,
  `col39` TEXT NULL DEFAULT NULL,
  `col40` TEXT NULL DEFAULT NULL,
  `col41` TEXT NULL DEFAULT NULL,
  `col42` TEXT NULL DEFAULT NULL,
  `col43` TEXT NULL DEFAULT NULL,
  `col44` TEXT NULL DEFAULT NULL,
  `col45` TEXT NULL DEFAULT NULL,
  `col46` TEXT NULL DEFAULT NULL,
  `col47` TEXT NULL DEFAULT NULL,
  `col48` TEXT NULL DEFAULT NULL,
  `col49` TEXT NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `satod`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`groups` ;

CREATE TABLE IF NOT EXISTS `satod`.`groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `satod`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`users` ;

CREATE TABLE IF NOT EXISTS `satod`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` CHAR(40) NOT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  `groups_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username` (`username` ASC),
  INDEX `fk_users_groups1_idx` (`groups_id` ASC),
  CONSTRAINT `fk_users_groups1`
    FOREIGN KEY (`groups_id`)
    REFERENCES `satod`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `satod`.`acos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`acos` ;

CREATE TABLE IF NOT EXISTS `satod`.`acos` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `parent_id` INT(10) NULL DEFAULT NULL,
  `model` VARCHAR(255) NULL DEFAULT NULL,
  `foreign_key` INT(10) NULL DEFAULT NULL,
  `alias` VARCHAR(255) NULL DEFAULT NULL,
  `lft` INT(10) NULL DEFAULT NULL,
  `rght` INT(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 178
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `satod`.`aros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`aros` ;

CREATE TABLE IF NOT EXISTS `satod`.`aros` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `parent_id` INT(10) NULL DEFAULT NULL,
  `model` VARCHAR(255) NULL DEFAULT NULL,
  `foreign_key` INT(10) NULL DEFAULT NULL,
  `alias` VARCHAR(255) NULL DEFAULT NULL,
  `lft` INT(10) NULL DEFAULT NULL,
  `rght` INT(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `satod`.`aros_acos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `satod`.`aros_acos` ;

CREATE TABLE IF NOT EXISTS `satod`.`aros_acos` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `_create` VARCHAR(2) NOT NULL DEFAULT '0',
  `_read` VARCHAR(2) NOT NULL DEFAULT '0',
  `_update` VARCHAR(2) NOT NULL DEFAULT '0',
  `_delete` VARCHAR(2) NOT NULL DEFAULT '0',
  `acos_id` INT(10) NOT NULL,
  `aros_id` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_aros_acos_acos1_idx` (`acos_id` ASC),
  INDEX `fk_aros_acos_aros1_idx` (`aros_id` ASC),
  CONSTRAINT `fk_aros_acos_acos1`
    FOREIGN KEY (`acos_id`)
    REFERENCES `satod`.`acos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aros_acos_aros1`
    FOREIGN KEY (`aros_id`)
    REFERENCES `satod`.`aros` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 60
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
