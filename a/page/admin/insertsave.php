<?php
include("../../../config/dbConnection.php");
include("../../session.php");

// เฉพาะผู้ดูแลระบบ (status = 1) เท่านั้น
if ($_SESSION["status"] != '1') {
    echo "<script type='text/javascript'>";
    echo "alert('คุณไม่มีสิทธิ์ในการจัดการส่วนนี้');";
    echo "window.location = '../card/';";
    echo "</script>";
    exit();
}

$member_user = isset($_POST["member_user"]) ? trim($_POST["member_user"]) : '';
$member_pass = isset($_POST["member_pass"]) ? trim($_POST["member_pass"]) : '';
$member_name = isset($_POST["member_name"]) ? trim($_POST["member_name"]) : '';
$member_tel  = isset($_POST["member_tel"]) ? trim($_POST["member_tel"]) : '';
$status      = isset($_POST["status"]) ? trim($_POST["status"]) : '2';

if (empty($member_user) || empty($member_pass)) {
    echo "<script type='text/javascript'>";
    echo "alert('กรุณากรอกชื่อผู้ใช้และรหัสผ่าน');";
    echo "window.history.back();";
    echo "</script>";
    exit();
}

// เข้ารหัสรหัสผ่านด้วย password_hash()
$hashed_pass = password_hash($member_pass, PASSWORD_DEFAULT);

try {
    $stmt = $conn->prepare("INSERT INTO tb_member (member_user, member_pass, member_name, member_tel, status) 
                            VALUES (:member_user, :member_pass, :member_name, :member_tel, :status)");
    $stmt->bindParam(':member_user', $member_user, PDO::PARAM_STR);
    $stmt->bindParam(':member_pass', $hashed_pass, PDO::PARAM_STR);
    $stmt->bindParam(':member_name', $member_name, PDO::PARAM_STR);
    $stmt->bindParam(':member_tel', $member_tel, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $result = $stmt->execute();

    if ($result) {
        echo "<script type='text/javascript'>";
        echo "alert('เพิ่มผู้ดูแลระบบ/สมาชิกเรียบร้อย');";
        echo "window.location = './';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('ไม่สามารถเพิ่มข้อมูลได้');";
        echo "window.history.back();";
        echo "</script>";
    }
} catch (PDOException $e) {
    error_log("Insert member error: " . $e->getMessage());
    echo "<script type='text/javascript'>";
    echo "alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');";
    echo "window.history.back();";
    echo "</script>";
}

$conn = null;
?>
