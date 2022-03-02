CREATE TABLE `nw202201`.`pagos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL,
  `cliente` VARCHAR(45) NOT NULL ,
  `monto` FLOAT NOT NULL ,
  `fechaVencimiento` VARCHAR(45) NOT NULL ,
  `estado` VARCHAR(45) NOT NULL DEFAULT 'ACT' ,
  PRIMARY KEY (`id`));