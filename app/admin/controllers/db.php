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
*/
$conexion = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
?>