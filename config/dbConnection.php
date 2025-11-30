<?php

ini_set('display_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);

$serverName     = "localhost";
$userName       = "root";
$userPassword   = "";
$dbName         = "amulet";
$webhost        = "http://localhost/enomban/Matavanary/AMULET";

try {
    // $conn = new PDO("sqlsrv:server=$serverName ; Database = $dbName", $userName, $userPassword);
    // $conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";

    $conn = new PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        // echo "Connected successfully";
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
  
    date_default_timezone_set("Asia/Bangkok");
