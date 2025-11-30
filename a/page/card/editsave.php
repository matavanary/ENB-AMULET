<?php
	include("../../../config/dbConnection.php");
	
	$his_type 			= $_POST["his_type"];
	$his_nameproduct 	= $_POST["his_nameproduct"];
	$his_province 		= $_POST["his_province"];
	$his_owner 			= $_POST["his_owner"];
	$his_price 			= $_POST["his_price"];
	$his_datecard 		= $_POST["his_datecard"];
	$his_detailproduct 	= $_POST["his_detailproduct"];
	$his_numcard 		= $_POST["his_numcard"];
	$his_tel 			= $_POST["his_tel"];
	$his_code 			= $_POST["his_code"];

	$stmt = $conn->prepare("UPDATE tb_history SET 
		his_type=:his_type, 
		his_nameproduct=:his_nameproduct, 
		his_province=:his_province, 
		his_owner=:his_owner, 
		his_price=:his_price, 
		his_datecard=:his_datecard, 
		his_detailproduct=:his_detailproduct, 
		his_numcard=:his_numcard, 
		his_tel=:his_tel 
	WHERE his_code=:his_code");
	$stmt->bindParam(':his_type', $his_type , PDO::PARAM_STR);
	$stmt->bindParam(':his_nameproduct', $his_nameproduct , PDO::PARAM_STR);
	$stmt->bindParam(':his_province', $his_province , PDO::PARAM_STR);
	$stmt->bindParam(':his_owner', $his_owner , PDO::PARAM_STR);
	$stmt->bindParam(':his_price', $his_price , PDO::PARAM_STR);
	$stmt->bindParam(':his_datecard', $his_datecard , PDO::PARAM_STR);
	$stmt->bindParam(':his_detailproduct', $his_detailproduct , PDO::PARAM_STR);
	$stmt->bindParam(':his_numcard', $his_numcard , PDO::PARAM_STR);
	$stmt->bindParam(':his_tel', $his_tel , PDO::PARAM_STR);
	$stmt->bindParam(':his_code', $his_code , PDO::PARAM_STR);
	$stmt->execute();
	if($stmt->rowCount() >= 0){
		echo "<script type='text/javascript'>";
		// echo "alert('แก้ไขข้อมูลเรียบร้อย');";
		echo "window.location = '../add_card_image/index.php?his_code=$his_code'; ";
		echo "</script>";
    }else{
		echo "<script type='text/javascript'>";
		echo "alert('ไม่สามารถแก้ไขข้อมูลได้');";
		echo "window.history.back()";
		echo "</script>";
    }
	$conn = null; //close connect db

