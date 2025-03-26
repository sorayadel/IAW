CREATE DATABASE IF NOT EXISTS sallepresencia COLLATE 'utf8mb4_general_ci' ;

USE sallepresencia;

CREATE TABLE IF NOT EXISTS `usuarios`(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `nombre` varchar(20) NULL,
    `apellido` varchar (20) NULL,
    `email` varchar(30) NOT NULL,
    `contraseña` varchar(10) NOT NULL,
    `Tipo usuario` varchar (10) NULL,

)

CREATE TABLE IF NOT EXISTS `Historial de fichajes`(
    `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
    `nombre` varchar (20) NULL,
    `apellido` varchar (20) NULL,
    `data` date NULL,
    `acción` varchar (20) NULL,
    
);