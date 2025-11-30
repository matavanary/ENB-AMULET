<?php
	include("../../../config/dbConnection.php");
	$strhis_code = $_GET["his_code"];
	
	$sql3 = $conn->prepare("SELECT his_numcard FROM tb_history WHERE his_code = ?");
	$sql3->execute([$strhis_code]);
	$result3 = $sql3->fetch(PDO::FETCH_ASSOC);
	$his_numcard=$result3['his_numcard'];
	$filePathQR = '../add_card_image/temp/'.$his_numcard.'.png';
	if (is_file($filePathQR)) {
		unlink($filePathQR);    
	}

	$sql1 = $conn->prepare("SELECT * FROM tb_image WHERE his_code = ?");
	$sql1->execute([$strhis_code]);
	$query = $sql1->fetchAll();
	foreach($query as $row) {
		$id=$row['id'];
		$filePath = '../add_card_image/upimg-port/'.$row['images'];
		if (is_file($filePath)) {
			unlink($filePath);    
		}
		$sql2 = $conn->prepare('DELETE FROM tb_image WHERE id = :id');
		$sql2->bindParam(':id', $id , PDO::PARAM_INT);
		$sql2->execute();		
	}

	$sql = $conn->prepare("DELETE FROM tb_history WHERE his_code = '$strhis_code'");
	$sql->execute();
	if($sql->rowCount() ==1){
		echo "<script type='text/javascript'>";
		echo "alert('ลบข้อมูลเรียบร้อย');";
		echo "window.location = './'; ";
		echo "</script>";
	}else{
		echo "<script type='text/javascript'>";
		echo "alert('ไม่สามารถลบข้อมูลได้');";
		echo "window.history.back()";
		echo "</script>";		
	}
