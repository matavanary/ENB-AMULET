<html>
<head>
</head>
<body>
<?php
	include("../../../config/dbConnection.php");
	$strmember_id = $_GET["member_id"];
	$sql = $conn->prepare('DELETE FROM tb_member WHERE member_id = :member_id');
	$sql->bindParam(':member_id', $strmember_id , PDO::PARAM_INT);
	$sql->execute();
	
	if($sql->rowCount() ==1){
		echo "<script type='text/javascript'>";
		echo "alert('ลบข้อมูลเรียบร้อย');";
			echo "window.location = './'; ";
		echo "</script>";
	}else{
		echo "<script type='text/javascript'>";
		echo "alert('ไม่สามารถแก้ไขข้อมูลได้');";
		echo "window.history.back()";
		echo "</script>";
	}
?>
</body>
</html>
