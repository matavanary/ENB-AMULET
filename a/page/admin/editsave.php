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

$member_id   = isset($_POST["member_id"]) ? trim($_POST["member_id"]) : '';
$member_user = isset($_POST["member_user"]) ? trim($_POST["member_user"]) : '';
$member_pass = isset($_POST["member_pass"]) ? trim($_POST["member_pass"]) : '';
$member_name = isset($_POST["member_name"]) ? trim($_POST["member_name"]) : '';
$member_tel  = isset($_POST["member_tel"]) ? trim($_POST["member_tel"]) : '';
$status      = isset($_POST["status"]) ? trim($_POST["status"]) : '2';

if (empty($member_id) || empty($member_user)) {
    echo "<script type='text/javascript'>";
    echo "alert('ข้อมูลไม่ครบถ้วน');";
    echo "window.history.back();";
    echo "</script>";
    exit();
}

try {
    // หากมีการกรอกรหัสผ่านใหม่ ให้แฮชและอัปเดตด้วย
    if (!empty($member_pass)) {
        $hashed_pass = password_hash($member_pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE tb_member SET 
            member_user = :member_user, 
            member_pass = :member_pass, 
            member_name = :member_name,
            member_tel  = :member_tel,
            status      = :status
        WHERE member_id = :member_id");
        $stmt->bindParam(':member_pass', $hashed_pass, PDO::PARAM_STR);
    } else {
        // หากเว้นว่างไว้ ให้อัปเดตข้อมูลอื่นโดยคงรหัสผ่านเดิมไว้
        $stmt = $conn->prepare("UPDATE tb_member SET 
            member_user = :member_user, 
            member_name = :member_name,
            member_tel  = :member_tel,
            status      = :status
        WHERE member_id = :member_id");
    }

    $stmt->bindParam(':member_user', $member_user, PDO::PARAM_STR);
    $stmt->bindParam(':member_name', $member_name, PDO::PARAM_STR);
    $stmt->bindParam(':member_tel',  $member_tel,  PDO::PARAM_STR);
    $stmt->bindParam(':status',      $status,      PDO::PARAM_INT);
    $stmt->bindParam(':member_id',   $member_id,   PDO::PARAM_INT);
    $stmt->execute();

    echo "<script type='text/javascript'>";
    echo "alert('แก้ไขข้อมูลเรียบร้อย');";
    echo "window.location = './';";
    echo "</script>";
} catch (PDOException $e) {
    error_log("Update member error: " . $e->getMessage());
    echo "<script type='text/javascript'>";
    echo "alert('ไม่สามารถแก้ไขข้อมูลได้');";
    echo "window.history.back();";
    echo "</script>";
}

$conn = null;
?>
