<?php
/**
 * สคริปต์ Migration สำหรับแปลงรหัสผ่านเดิมที่เป็น Plain Text ใน tb_member
 * ให้กลายเป็น password_hash() อย่างปลอดภัย
 */

header('Content-Type: text/html; charset=utf-8');
include(__DIR__ . "/dbConnection.php");

$is_cli = (php_sapi_name() === 'cli');
$confirmed = false;

if ($is_cli) {
    if (isset($argv[1]) && strpos($argv[1], 'confirm=yes') !== false) {
        $confirmed = true;
    }
} else {
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        $confirmed = true;
    }
}

function output($text, $is_cli) {
    if ($is_cli) {
        echo $text . "\n";
    } else {
        echo "<p style='font-family: monospace;'>" . htmlspecialchars($text) . "</p>";
    }
}

if (!$confirmed) {
    if ($is_cli) {
        echo "คำเตือน: สคริปต์นี้จะแปลงรหัสผ่าน Plain Text ใน tb_member ทั้งหมดเป็น password_hash()\n";
        echo "หากต้องการดำเนินการ ให้รันคำสั่ง: php config/migrate_passwords.php confirm=yes\n";
    } else {
        echo "<h2>ระบบ Migrate รหัสผ่านเดิม (tb_member) สู่ password_hash()</h2>";
        echo "<p><b>ฐานข้อมูลที่เชื่อมต่อปัจจุบัน:</b> " . htmlspecialchars($dbName) . " (Host: " . htmlspecialchars($serverName) . ")</p>";
        echo "<p style='color: orange;'>คำเตือน: สคริปต์นี้จะแปลงรหัสผ่าน Plain Text ที่ยังไม่ได้เข้ารหัสในตาราง tb_member ให้เป็น password_hash()</p>";
        echo "<p>ระบบล็อกอินได้ถูกอัปเดตให้รองรับทั้งแบบแฮช และแปลงอัตโนมัติเมื่อผู้ใช้เข้าสู่ระบบอยู่แล้ว แต่หากต้องการแปลงทั้งหมดในฐานข้อมูลทันที กดปุ่มด้านล่าง:</p>";
        echo "<a href='?confirm=yes' style='display:inline-block; padding:10px 20px; background:#2563eb; color:#fff; text-decoration:none; border-radius:5px;'>ยืนยันดำเนินการ Migrate ทันที</a>";
    }
    exit();
}

try {
    // ตรวจสอบว่าตาราง tb_member มีอยู่ในฐานข้อมูลที่เชื่อมต่อหรือไม่
    $checkTable = $conn->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'tb_member'");
    $checkTable->execute();
    if ($checkTable->rowCount() === 0 && count($checkTable->fetchAll()) === 0) {
        output("-----------------------------------------------------------------", $is_cli);
        output("ข้อผิดพลาด: ไม่พบตาราง 'tb_member' ในฐานข้อมูล [{$dbName}]", $is_cli);
        output("สาเหตุที่เป็นไปได้:", $is_cli);
        output("1. ใน config/env.php ปัจจุบันตั้งค่า 'DATABASE' => '{$dbName}' (สำหรับโปรเจกต์นี้มักจะเป็น 'AMULET')", $is_cli);
        output("2. หรือยังไม่ได้ Import ตารางเข้าฐานข้อมูลนี้", $is_cli);
        output("-----------------------------------------------------------------", $is_cli);
        if (!$is_cli) {
            echo "<p><a href='check_db.php' style='color:blue; font-weight:bold;'>&raquo; คลิกที่นี่เพื่อเปิดหน้าตรวจสอบรายชื่อ Database และตารางทั้งหมด (check_db.php)</a></p>";
        }
        exit();
    }

    $stmt = $conn->query("SELECT member_id, member_user, member_pass FROM tb_member");
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = count($members);
    $migrated = 0;
    $already_hashed = 0;

    output("=== เริ่มต้นตรวจสอบและ Migrate รหัสผ่าน (ฐานข้อมูล: $dbName, ทั้งหมด $total บัญชี) ===", $is_cli);

    $updateStmt = $conn->prepare("UPDATE tb_member SET member_pass = :pass WHERE member_id = :id");

    foreach ($members as $m) {
        $id = $m['member_id'];
        $user = $m['member_user'];
        $pass = $m['member_pass'];

        $info = password_get_info($pass);
        if ($info['algo'] !== 0) {
            output("[$user] รหัสผ่านได้รับการเข้ารหัสแล้ว ข้ามไป...", $is_cli);
            $already_hashed++;
        } else {
            $newHash = password_hash($pass, PASSWORD_DEFAULT);
            $updateStmt->execute([
                ':pass' => $newHash,
                ':id'   => $id
            ]);
            output("[$user] แปลงรหัสผ่าน Plain Text เป็น Hash สำเร็จ!", $is_cli);
            $migrated++;
        }
    }

    output("==================================================", $is_cli);
    output("สรุปผลการทำงาน:", $is_cli);
    output("- บัญชีทั้งหมด: $total", $is_cli);
    output("- บัญชีที่ได้รับการเข้ารหัสใหม่: $migrated", $is_cli);
    output("- บัญชีที่เคยเข้ารหัสแล้ว: $already_hashed", $is_cli);
    output("เสร็จสิ้นการ Migration อย่างสมบูรณ์!", $is_cli);

    if (!$is_cli) {
        echo "<br><a href='../vip/index.php' style='display:inline-block; padding:8px 16px; background:#10b981; color:#fff; text-decoration:none; border-radius:4px;'>ไปยังหน้า Login</a>";
    }

} catch (PDOException $e) {
    output("เกิดข้อผิดพลาด: " . $e->getMessage(), $is_cli);
    if (strpos($e->getMessage(), "Invalid object name 'tb_member'") !== false) {
        output("คำแนะนำ: ฐานข้อมูล [{$dbName}] ไม่มีตาราง 'tb_member' กรุณาตรวจสอบชื่อฐานข้อมูลใน config/env.php หรือรัน check_db.php เพื่อดูรายชื่อ Database", $is_cli);
    }
}
?>
