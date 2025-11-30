<?php
	session_start();
	if($_SESSION['member_id'] == "")
	{
    echo "<script type='text/javascript'>";
    echo "alert('กรุณาเข้าสู่ระบบด้วยค่ะ');";
    echo "window.location = '$webhost/vip/index.php'; ";
    echo "</script>";
		exit();
	}	

	$stmt = $conn->prepare("SELECT * FROM tb_member WHERE member_id = ?");
	$stmt->execute([$_SESSION['member_id']]);
	$objResult = $stmt->fetch(PDO::FETCH_ASSOC);
?>
