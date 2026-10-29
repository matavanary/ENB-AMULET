<?php 
include("../config/dbConnection.php");
session_start();

// ตรวจสอบการส่งคำขอแบบ AJAX
$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)
    || (isset($_POST['ajax']) && $_POST['ajax'] == '1');

/**
 * ฟังก์ชันตอบกลับผลลัพธ์ (รองรับทั้ง JSON สำหรัล AJAX และ Script alert สำหรับแบบเดิม)
 */
function send_login_response($is_ajax, $status, $message, $redirect = './index.php') {
    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'redirect' => $redirect
        ], JSON_UNESCAPED_UNICODE);
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('" . addslashes($message) . "');";
        echo "window.location = '" . addslashes($redirect) . "';";
        echo "</script>";
        exit();
    }
}

$member_user = isset($_POST["member_user"]) ? trim($_POST["member_user"]) : '';
$member_pass = isset($_POST["member_pass"]) ? trim($_POST["member_pass"]) : '';

if (empty($member_user) || empty($member_pass)) {
    send_login_response($is_ajax, 'error', 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน', './index.php');
}

try {
    $chk_member = $conn->prepare("SELECT * FROM tb_member WHERE member_user = :member_user");
    $chk_member->bindParam(':member_user', $member_user, PDO::PARAM_STR);
    $chk_member->execute();
    $objResult = $chk_member->fetch(PDO::FETCH_ASSOC);

    $is_authenticated = false;

    if ($objResult) {
        // 1. ตรวจสอบด้วย password_verify (กรณีรหัสผ่านเป็น Hash แล้ว)
        if (password_verify($member_pass, $objResult["member_pass"])) {
            $is_authenticated = true;

            // หากจำเป็นต้อง rehash เมื่อ algorithm หรือ cost มีการอัปเกรด
            if (password_needs_rehash($objResult["member_pass"], PASSWORD_DEFAULT)) {
                $newHash = password_hash($member_pass, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE tb_member SET member_pass = :pass WHERE member_id = :id");
                $updateStmt->execute([':pass' => $newHash, ':id' => $objResult['member_id']]);
            }
        } 
        // 2. รองรับข้อมูลเก่าที่เป็น Plaintext (Auto-migrate ทันทีที่ล็อกอิน)
        else if ($objResult["member_pass"] === $member_pass) {
            $is_authenticated = true;
            $newHash = password_hash($member_pass, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE tb_member SET member_pass = :pass WHERE member_id = :id");
            $updateStmt->execute([':pass' => $newHash, ':id' => $objResult['member_id']]);
        }
    }

    if ($is_authenticated) {
        $_SESSION["member_id"] = $objResult["member_id"];
        $_SESSION["member_name"] = $objResult["member_name"];
        $_SESSION["status"] = $objResult["status"];

        session_write_close();

        if ($objResult["status"] == "1") {
            send_login_response($is_ajax, 'success', 'ยินดีต้อนรับผู้ดูแลระบบค่ะ', '../a/index.php');
        } else if ($objResult["status"] == "2") {
            send_login_response($is_ajax, 'success', 'ยินดีต้อนรับสมาชิกค่ะ', '../a/index.php');
        } else {
            send_login_response($is_ajax, 'error', 'สถานะผู้ใช้งานไม่ถูกต้อง', './index.php');
        }
    } else {
        send_login_response($is_ajax, 'error', 'กรอกชื่อผู้ใช้ หรือรหัสผ่านผิด', './index.php');
    }
} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    send_login_response($is_ajax, 'error', 'เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง', './index.php');
}
       
$conn = null; 
?>
