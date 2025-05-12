<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$pass = "root";
$dbname = "compte_personnes";
$port= 8889;

// Crée une instance de connexion MySQLi
$conn = new mysqli($host, $user, $pass, $dbname, $port);

?>
