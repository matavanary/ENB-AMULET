<?php
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Test PHP</title>";
echo "</head>";
echo "<body>";
echo "<h1>PHP ทำงานได้แล้ว!</h1>";
echo "<p>เวลาปัจจุบัน: " . date('Y-m-d H:i:s') . "</p>";

// ทดสอบการเชื่อมต่อฐานข้อมูล
try {
    include("./config/dbConnection.php");
    echo "<p style='color: green;'>✓ เชื่อมต่อฐานข้อมูลสำเร็จ</p>";
    
    // ทดสอบดึงข้อมูล
    $sql = $conn->prepare("SELECT COUNT(*) as total FROM tb_history");
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    echo "<p>จำนวนบัตรในระบบ: " . $result['total'] . " บัตร</p>";
    
} catch(Exception $e) {
    echo "<p style='color: red;'>✗ เชื่อมต่อฐานข้อมูลไม่ได้: " . $e->getMessage() . "</p>";
}

echo "</body>";
echo "</html>";
?>