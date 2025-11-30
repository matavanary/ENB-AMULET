<?php
	include("../../../config/dbConnection.php");

	$member_user	= $_POST["member_user"];
	$member_pass 	= $_POST["member_pass"];
	$member_name	= $_POST["member_name"];
	$member_tel		= $_POST["member_tel"];
	$status			= $_POST["status"];
	$member_id		= $_POST["member_id"];
	$stmt = $conn->prepare("UPDATE tb_member SET 
		member_user=:member_user, 
		member_pass=:member_pass, 
		member_name=:member_name,
		member_tel=:member_tel,
		status=:status
	WHERE member_id=:member_id");
	$stmt->bindParam(':member_user', $member_user , PDO::PARAM_STR);
	$stmt->bindParam(':member_pass', $member_pass , PDO::PARAM_STR);
	$stmt->bindParam(':member_name', $member_name , PDO::PARAM_STR);
	$stmt->bindParam(':member_tel', $member_tel , PDO::PARAM_STR);
	$stmt->bindParam(':status', $status , PDO::PARAM_STR);
	$stmt->bindParam(':member_id', $member_id , PDO::PARAM_STR);
	$stmt->execute();
	if($stmt->rowCount() >= 0){
		echo "<script type='text/javascript'>";
		echo "alert('แก้ไขข้อมูลเรียบร้อย');";
		echo "window.location = './'; ";
		echo "</script>";
	}
	else{
		echo "<script type='text/javascript'>";
		echo "alert('ไม่สามารถแก้ไขข้อมูลได้');";
		echo "window.history.back()";
		echo "</script>";
	}
