<?php

ini_set('display_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);

// โหลดการตั้งค่าจาก env.php หากมี มิฉะนั้นใช้ค่าเริ่มต้น
$envFile = __DIR__ . '/env.php';
if (file_exists($envFile)) {
    $envConfig = include($envFile);
} else {
    $envConfig = [
        'RUNNING_IN' => 'LOCAL',
        'TECHNOLOGY' => 'sqlsrv',
        'ENVIRONMENTS' => [
            'LOCAL' => [
                'HOST'     => 'localhost',
                'USERNAME' => 'sa',
                'PASSWORD' => '212224236',
                'DATABASE' => 'EMS',
                'WEBURL'   => 'http://localhost/enomban/REPO.GITHUB/ENB-AMULET'
            ]
        ]
    ];
}

$RUNNING_IN = isset($envConfig['RUNNING_IN']) ? $envConfig['RUNNING_IN'] : 'LOCAL';
$TECHNOLOGY = isset($envConfig['TECHNOLOGY']) ? $envConfig['TECHNOLOGY'] : 'sqlsrv';

$currentEnv = isset($envConfig['ENVIRONMENTS'][$RUNNING_IN]) ? $envConfig['ENVIRONMENTS'][$RUNNING_IN] : [];

$HOST          = isset($currentEnv['HOST']) ? $currentEnv['HOST'] : 'localhost';
$USERNAME      = isset($currentEnv['USERNAME']) ? $currentEnv['USERNAME'] : 'sa';
$PASSWORD      = isset($currentEnv['PASSWORD']) ? $currentEnv['PASSWORD'] : '';
$DATABASE      = isset($currentEnv['DATABASE']) ? $currentEnv['DATABASE'] : 'EMS';
$WEBURL        = isset($currentEnv['WEBURL']) ? $currentEnv['WEBURL'] : 'http://localhost/enomban/REPO.GITHUB/ENB-AMULET';

$serverName     = $HOST;
$userName       = $USERNAME;
$userPassword   = $PASSWORD;
$dbName         = $DATABASE;
$webhost        = $WEBURL;

try {
    if ($TECHNOLOGY == "sqlsrv") {
        $conn = new PDO("sqlsrv:server=$serverName ; Database = $dbName", $userName, $userPassword);
        $conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    } else if ($TECHNOLOGY == "mysql") {
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8", $userName, $userPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        // echo "Connected successfully";
    }
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
  
    date_default_timezone_set("Asia/Bangkok");
