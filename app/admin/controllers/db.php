<?php
$servername = "localhost";
$username = "u685818680_appperruna";
$password = "TX093e>GI~s5";
$dbname = "u685818680_appperruna";  


// Create connection
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appperruna"; 

$servername = "localhost";
$username = "u685818680_appperruna";
$password = "TX093e>GI~s5";
$dbname = "u685818680_appperruna";


CREATE TABLE appperruna.registro_usuarios (
	id INT auto_increment NOT NULL,
	contrasenia varchar(150) NULL,
	desparacitacion varchar(100) NULL,
	direccion varchar(100) NULL,
	esterilizado varchar(100) NULL,
	fecha_nacimiento DATE NULL,
	nombremascota varchar(100) NULL,
	parent_dni varchar(100) NOT NULL,
	parent_email varchar(100) NOT NULL,
	parent_emergencia varchar(100) NULL,
	parent_nombre varchar(100) NULL,
	parent_tel varchar(100) NULL,
	peso DOUBLE NULL,
	raza varchar(100) NULL,
	sexo varchar(100) NULL,
	tipomascota varchar(100) NULL,
	vacuna_dia varchar(100) NULL,
	vacuna_kc varchar(100) NULL,
	veterinaria varchar(100) NULL,
	CONSTRAINT registro_usuarios_pk PRIMARY KEY (id),
	CONSTRAINT registro_usuarios_unique UNIQUE KEY (parent_dni),
	CONSTRAINT registro_usuarios_unique_1 UNIQUE KEY (parent_email)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;



*/
$conexion = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
?>