<?php
header('Content-Type: text/html; charset=utf-8');
include(__DIR__ . "/dbConnection.php");

echo "<h2>ตรวจสอบฐานข้อมูล SQL Server</h2>";

if (!$conn) {
    echo "<p style='color:red;'>ไม่สามารถเชื่อมต่อฐานข้อมูลได้</p>";
    exit();
}

echo "<p><b>Database ที่เชื่อมต่ออยู่ปัจจุบัน:</b> " . htmlspecialchars($dbName) . "</p>";
echo "<p><b>Host:</b> " . htmlspecialchars($serverName) . "</p>";
echo "<p><b>Technology:</b> " . htmlspecialchars($TECHNOLOGY) . "</p>";

try {
    // 1. ดึงรายชื่อ Database ทั้งหมดใน SQL Server
    echo "<h3>1. รายชื่อ Databases ทั้งหมดบนเครื่อง:</h3><ul>";
    $dbQuery = $conn->query("SELECT name FROM sys.databases ORDER BY name");
    $foundAmuletDb = false;
    while ($dbRow = $dbQuery->fetch(PDO::FETCH_ASSOC)) {
        $dName = $dbRow['name'];
        echo "<li><b>" . htmlspecialchars($dName) . "</b>";
        if (strcasecmp($dName, 'AMULET') === 0) {
            echo " <span style='color:green;'>&larr; (ฐานข้อมูล AMULET อยู่ที่นี่)</span>";
            $foundAmuletDb = true;
        }
        echo "</li>";
    }
    echo "</ul>";

    // 2. ดึงรายชื่อ Tables ใน Database ปัจจุบัน ($dbName)
    echo "<h3>2. ตารางใน Database [" . htmlspecialchars($dbName) . "]:</h3>";
    $tableQuery = $conn->query("SELECT TABLE_SCHEMA, TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' ORDER BY TABLE_NAME");
    $tables = $tableQuery->fetchAll(PDO::FETCH_ASSOC);

    if (empty($tables)) {
        echo "<p style='color:orange;'>ไม่พบตารางในฐานข้อมูลนี้</p>";
    } else {
        echo "<ul>";
        $hasMember = false;
        foreach ($tables as $t) {
            $tableName = $t['TABLE_NAME'];
            echo "<li>" . htmlspecialchars($t['TABLE_SCHEMA']) . "." . htmlspecialchars($tableName);
            if (strcasecmp($tableName, 'tb_member') === 0) {
                echo " <span style='color:green; font-weight:bold;'>&check; พบ tb_member</span>";
                $hasMember = true;
            } else if (strcasecmp($tableName, 'tb_history') === 0) {
                echo " <span style='color:green; font-weight:bold;'>&check; พบ tb_history</span>";
            } else if (strcasecmp($tableName, 'tb_image') === 0) {
                echo " <span style='color:green; font-weight:bold;'>&check; พบ tb_image</span>";
            }
            echo "</li>";
        }
        echo "</ul>";
        
        if (!$hasMember) {
            echo "<p style='color:red;'><b>ข้อสังเกต:</b> ใน Database [" . htmlspecialchars($dbName) . "] ไม่มีตาราง tb_member</p>";
        }
    }

    // 3. ถ้าพบฐานข้อมูล AMULET แต่ปัจจุบันต่อ EMS อยู่ ให้ลองเช็คว่า AMULET มีตารางอะไรบ้าง
    if ($foundAmuletDb && strcasecmp($dbName, 'AMULET') !== 0) {
        echo "<h3>3. ตรวจสอบตารางใน Database [AMULET]:</h3>";
        try {
            $amuletTables = $conn->query("SELECT TABLE_SCHEMA, TABLE_NAME FROM AMULET.INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");
            echo "<ul>";
            while ($at = $amuletTables->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>" . htmlspecialchars($at['TABLE_SCHEMA']) . "." . htmlspecialchars($at['TABLE_NAME']) . "</li>";
            }
            echo "</ul>";
            echo "<p style='color:blue;'><b>คำแนะนำ:</b> สามารถเปลี่ยน 'DATABASE' ใน <code>config/env.php</code> จาก 'EMS' เป็น 'AMULET' ได้</p>";
        } catch (Exception $ex) {
            echo "<p>ไม่สามารถดึงข้าม Database ได้: " . htmlspecialchars($ex->getMessage()) . "</p>";
        }
    }

} catch (Exception $e) {
    echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
