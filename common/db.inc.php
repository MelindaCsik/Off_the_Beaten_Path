<?php

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING);

session_start();

$servername = "localhost";
$username = "c31otbp";
$password = "MAvi!Mr53";
$dbname = "c31offthebeatenpath";

define('DB_PREFIX', "c8m6k");

try{
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    throw new Exception("Adatbázis hiba");
  }
}catch(Exception $e){
  echo "Hiba történt: az adatbázis nem elérhető";
  exit;
}

?>