DROP DATABASE IF EXISTS `duty`;

CREATE DATABASE IF NOT EXISTS `duty` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `duty`;

DROP TABLE IF EXISTS `rank` ;
CREATE TABLE IF NOT EXISTS `rank` (
  `id` INT UNSIGNED AUTO_INCREMENT,
  `name` varchar (50),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `updated_at`  TIMESTAMP NULL ON UPDATE now(),
  PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `service` ;
CREATE TABLE IF NOT EXISTS `service` (
  `id` INT UNSIGNED AUTO_INCREMENT,
  `name` varchar (50),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `updated_at`  TIMESTAMP NULL ON UPDATE now(),
  PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `service_ranks` ;
CREATE TABLE IF NOT EXISTS `service_ranks` (
  `id` INT UNSIGNED AUTO_INCREMENT,
  `service_id` INT UNSIGNED,
  `rank_id` INT UNSIGNED,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `updated_at`  TIMESTAMP NULL ON UPDATE now(),
  PRIMARY KEY (id),
  FOREIGN KEY FK_service_ranks_rank (rank_id) REFERENCES rank(id),
  FOREIGN KEY FK_service_ranks_service(service_id) REFERENCES service(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `person` ;
CREATE TABLE IF NOT EXISTS `person` (
  `id` INT UNSIGNED AUTO_INCREMENT,
  `cip_code` VARCHAR (7) UNIQUE NULL,
  `name` VARCHAR (100),
  `rank_id` INT UNSIGNED NOT NULL,
  `birth_date` DATE NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `updated_at`  TIMESTAMP NULL ON UPDATE now(),
  PRIMARY KEY (id),
  FOREIGN KEY FK_person_rank (rank_id) REFERENCES rank(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `unavailability_motive` ;
CREATE TABLE IF NOT EXISTS `unavailability_motive` (
  `id` INT UNSIGNED AUTO_INCREMENT,
  `name` varchar (50),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `updated_at`  TIMESTAMP NULL ON UPDATE now(),
  PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `prevision` ;
CREATE TABLE IF NOT EXISTS `prevision` (
  `id` INT UNSIGNED AUTO_INCREMENT,
  `person_id` INT UNSIGNED default NULL,
  `service_id` INT UNSIGNED default NULL,
  `rank_id` INT UNSIGNED default NULL,
  `start_date` TIMESTAMP NULL,
  `end_date` TIMESTAMP  NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `updated_at`  TIMESTAMP NULL ON UPDATE now(),
  PRIMARY KEY (id) /*  ,
 FOREIGN KEY FK_prevision_person (person_id) REFERENCES person(id),
  FOREIGN KEY FK_prevision_service (service_id) REFERENCES service(id),
  FOREIGN KEY FK_prevision_rank (rank_id) REFERENCES rank(id)*/
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP USER IF EXISTS  'readonlyuser'@'localhost';
CREATE USER 'readonlyuser'@'localhost' IDENTIFIED by '123';
GRANT USAGE ON *.* TO 'readonlyuser'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT SELECT ON `duty`.* TO 'readonlyuser'@'localhost';

DROP USER IF EXISTS 'localuser'@'localhost';
CREATE USER 'localuser'@'localhost' IDENTIFIED by '123';
GRANT USAGE ON *.* TO 'localuser'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT SELECT, INSERT, UPDATE, DELETE ON `duty`.* TO 'localuser'@'localhost';

DROP USER IF EXISTS  'admin'@'localhost';
CREATE USER 'admin'@'localhost' IDENTIFIED by '123';
GRANT USAGE ON *.* TO 'admin'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `duty`.* TO 'admin'@'localhost' WITH GRANT OPTION;

INSERT INTO service (name) VALUES ('Guardia /L-V'), ('Guardia /S,D /F'), ('Limpieza HQ'),('Jefe Limpieza HQ');
INSERT INTO rank (name) VALUES ('Soldado'), ('Soldado 1ª'), ('Cabo'), ('Cabo 1º') ;

INSERT INTO `service_ranks` (service_id, rank_id) VALUES ( 1, 1), ( 1, 2), ( 1, 3), ( 1, 4), ( 2, 1), ( 2, 2), ( 2, 3), ( 2, 4), ( 3, 1), ( 3, 2), ( 3, 3), ( 4, 4);

/*set FOREIGN_key_checks=0;*/

/*
DROP TABLE IF EXISTS `Users` ;
CREATE TABLE IF NOT EXISTS `Users` (
	`id`  int AUTO_INCREMENT,
	`nif` varchar(9) NOT NULL,
	`name` varchar(100) NOT NULL,
	`email` varchar(80) NOT NULL,
	`password` varchar(30) DEFAULT NULL,
	`addressshipping` varchar(60) DEFAULT NULL,
	`addressshippingPO` varchar(60) DEFAULT NULL,
	`addressshippingcity` varchar(60) DEFAULT NULL,
	`addressshippingregion` varchar(60) DEFAULT NULL,
	`addressbilling` varchar(60) DEFAULT NULL,
	`addressbillingPO` varchar(60) DEFAULT NULL,
	`addressbillingcity` varchar(60) DEFAULT NULL,
	`addressbillingregion` varchar(60) DEFAULT NULL,
	`status` tinyint(1) DEFAULT NULL,
	`admin` tinyint(1) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Categories` ;
CREATE TABLE IF NOT EXISTS `Categories` (
	`id` int AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`description` varchar(100) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `SubCategories` ;
CREATE TABLE IF NOT EXISTS `SubCategories` (
	`id` int AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`description` varchar(100) DEFAULT NULL,
	`categoryid` int,	
	PRIMARY KEY (id),
	FOREIGN KEY FK_SubCategories_Categories (categoryid) REFERENCES Categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Provider` ;
CREATE TABLE IF NOT EXISTS `Provider` (
	`id` int AUTO_INCREMENT,
	`nif` varchar (9) DEFAULT NULL,
	`email` varchar(80) NOT NULL,
	`name` varchar(100) NOT NULL,
	`country` varchar(100) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Orders` ;
CREATE TABLE IF NOT EXISTS `Orders` (
	`id` int AUTO_INCREMENT,
	`userid` int,
	`date` date DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY FK_Order_Users (userid) REFERENCES Users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Products` ;
CREATE TABLE IF NOT EXISTS `Products` (
	`id` int AUTO_INCREMENT,
	`object` varchar(100) DEFAULT NULL,
	`name` varchar(100) DEFAULT NULL,
	`brand` varchar(50) DEFAULT NULL,
	`model` varchar(50) DEFAULT NULL,
	`description` text(10000) DEFAULT NULL,
	`specifications` text(10000) DEFAULT NULL,
	`price` int(11) DEFAULT NULL,
	`categoryid` int DEFAULT NULL,
	`subcategoryid` int DEFAULT NULL,
	`providerid` int DEFAULT NULL,
	`imgRoute` varchar(100) DEFAULT NULL,
	`stock` int(11) DEFAULT NULL,
	`taxesid` int,
	PRIMARY KEY (id),
	FOREIGN KEY FK_Product_Category (categoryid) REFERENCES Categories(id),
	FOREIGN KEY FK_Product_subCategory (subcategoryid) REFERENCES SubCategories(id),
	FOREIGN KEY FK_Product_Provider (providerid) REFERENCES Provider(id),
	FOREIGN KEY FK_Products_Taxes (taxesid) REFERENCES Taxes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `OrderLines` ;
CREATE TABLE IF NOT EXISTS `OrderLines` (
	`id` int AUTO_INCREMENT,
	`orderid` int NOT NULL,  /*PENDIENTE DE CAMBIAR EL NOMBRE AL NOMBRE DE LA CLAVE AJENA*/
	`productid` int NOT NULL,
	`price` float(5,2) DEFAULT NULL, /*VALOR CALCULADO, SE COPIA DESDE EL PRECIO ACTUAL*/
	`quantity` int(11) DEFAULT NULL,
	`discount` float(10,2) DEFAULT NULL,
	`taxApplied` float(5,2) DEFAULT NULL, /*VALOR CALCULADO, SE COPIA DESDE EL IVA ACTUAL*/
	PRIMARY KEY (id),
	FOREIGN KEY FK_OrderLines_Order (orderid) REFERENCES Orders(id),
	FOREIGN KEY FK_OrderLines_Product (productid) REFERENCES Products(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ProviderOrders` ;
CREATE TABLE IF NOT EXISTS `ProviderOrders` (
	`id` int AUTO_INCREMENT,
	`providerid` int,
	`date` date DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY FK_ProviderOrders_Providers (providerid) REFERENCES Provider(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ProviderOrderLines` ;
CREATE TABLE IF NOT EXISTS `ProviderOrderLines` (
	`id` int AUTO_INCREMENT,
	`providerorderid` int NOT NULL,  /*PENDIENTE DE CAMBIAR EL NOMBRE AL NOMBRE DE LA CLAVE AJENA*/
	`productid` int NOT NULL,
	`price` float(5,2) DEFAULT NULL,
	`quantity` int(11) DEFAULT NULL,
	`discount` float(10,2) DEFAULT NULL,
	`taxApplied` float(5,2) DEFAULT NULL, /*VALOR CALCULADO, SE COPIA DESDE EL IVA ACTUAL*/
	PRIMARY KEY (id),
	FOREIGN KEY FK_ProviderOrderLines_ProviderOrders (providerorderid) REFERENCES ProviderOrders(id),
	FOREIGN KEY FK_ProviderOrderLines_Product (productid) REFERENCES Products(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `favourites` ;
create table IF NOT EXISTS `favourites`(
	`id` int AUTO_INCREMENT,
	`userid` INT,
	`productid` INT,
	PRIMARY KEY (id),
	FOREIGN KEY FK_idFav_userid (`userid`) REFERENCES Users(`id`) ON DELETE CASCADE,
	FOREIGN KEY FK_idFav_productid (productid) REFERENCES products(id) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP USER IF EXISTS  'readonlyuser'@'%';
CREATE USER 'readonlyuser'@'%' IDENTIFIED by '123';
GRANT USAGE ON *.* TO 'readonlyuser'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT SELECT ON `shop`.* TO 'readonlyuser'@'%';

DROP USER IF EXISTS 'localuser'@'%';
CREATE USER 'localuser'@'%' IDENTIFIED by '123';
GRANT USAGE ON *.* TO 'localuser'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT SELECT, INSERT, UPDATE, DELETE ON `shop`.* TO 'localuser'@'%';

DROP USER IF EXISTS  'admin'@'%';
CREATE USER 'admin'@'%' IDENTIFIED by '123';
GRANT USAGE ON *.* TO 'admin'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `shop`.* TO 'admin'@'%' WITH GRANT OPTION;

DROP USER IF EXISTS  'shop'@'localhost';
CREATE USER 'shop'@'localhost' IDENTIFIED by '123';
GRANT USAGE ON *.* TO 'shop'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `shop`.* TO 'shop'@'localhost' WITH GRANT OPTION;

*/