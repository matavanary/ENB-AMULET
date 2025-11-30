<html>
<head>
</head>
<body>
	<?php
	include("../../../config/dbConnection.php");

	$detail1	= $_POST["detail1"];
	$detail2 	= $_POST["detail2"];
	$detail3	= $_POST["detail3"];
	$id			= $_POST["id"];
	$stmt = $conn->prepare("UPDATE tb_image SET 
		detail1=:detail1, 
		detail2=:detail2, 
		detail3=:detail3
	WHERE id=:id");
	$stmt->bindParam(':detail1', $detail1 , PDO::PARAM_STR);
	$stmt->bindParam(':detail2', $detail2 , PDO::PARAM_STR);
	$stmt->bindParam(':detail3', $detail3 , PDO::PARAM_STR);
	$stmt->bindParam(':id', $id , PDO::PARAM_STR);
	$stmt->execute();

	if($stmt->rowCount() >= 0){
		
		$sql1 = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
		$sql1->execute([$_POST["id"]]);
		$result1 = $sql1->fetch(PDO::FETCH_ASSOC);
		$his_code=$result1["his_code"];

		echo "<script type='text/javascript'>";
		echo "alert('แก้ไขข้อมูลเรียบร้อย');";
		echo "window.location = 'index.php?his_code=$his_code'; ";
		echo "</script>";
	}
	else{
		echo "<script type='text/javascript'>";
		echo "alert('ไม่สามารถแก้ไขข้อมูลได้');";
		echo "window.history.back()";
		echo "</script>";
	}
	?>
</body>
</html>
