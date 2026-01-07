<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appperruna"; 
// Create connection
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultame"; 


$servername = "localhost";
$username = "u685818680_gabrieladmin02";
$password = "7|Pvfsp~WjP";
$dbname = "u685818680_consultamev2";*/
$conexion = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
?>