<?php
include("../../../config/dbConnection.php");
include("../../session.php");

// ตรวจสอบสิทธิ์เฉพาะผู้ดูแลระบบ (status = 1) เท่านั้น
if (!isset($_SESSION["status"]) || strval($_SESSION["status"]) !== '1') {
    echo "<script type='text/javascript'>";
    echo "alert('คุณไม่มีสิทธิ์ในการจัดการส่วนนี้');";
    echo "window.location = '../card/';";
    echo "</script>";
    exit();
}

$strmember_id = isset($_GET["member_id"]) ? intval($_GET["member_id"]) : 0;

// ป้องกันการลบบัญชีของตนเองที่กำลังล็อกอินอยู่
if ($strmember_id > 0 && $strmember_id == intval($_SESSION["member_id"])) {
    echo "<script type='text/javascript'>";
    echo "alert('ไม่สามารถลบบัญชีผู้ใช้งานที่คุณกำลังเข้าสู่ระบบอยู่ได้');";
    echo "window.location = './';";
    echo "</script>";
    exit();
}

if ($strmember_id > 0) {
    try {
        $sql = $conn->prepare('DELETE FROM tb_member WHERE member_id = :member_id');
        $sql->bindParam(':member_id', $strmember_id, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() >= 1) {
            echo "<script type='text/javascript'>";
            echo "alert('ลบข้อมูลผู้ใช้งานเรียบร้อยแล้ว');";
            echo "window.location = './';";
            echo "</script>";
            exit();
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('ไม่พบข้อมูลผู้ใช้งานที่ต้องการลบ');";
            echo "window.location = './';";
            echo "</script>";
            exit();
        }
    } catch (PDOException $e) {
        error_log("Delete member error: " . $e->getMessage());
        echo "<script type='text/javascript'>";
        echo "alert('เกิดข้อผิดพลาด ไม่สามารถลบข้อมูลได้ อาจเนื่องจากมีข้อมูลอ้างอิงอยู่ในระบบ');";
        echo "window.location = './';";
        echo "</script>";
        exit();
    }
} else {
    echo "<script type='text/javascript'>";
    echo "alert('รหัสผู้ใช้งานไม่ถูกต้อง');";
    echo "window.location = './';";
    echo "</script>";
    exit();
}

$conn = null;
?>
