<?php
	include("../config/dbConnection.php");

	$numcard = isset($_POST["numcard"]) ? trim($_POST["numcard"]) : "";

	if (empty($numcard)) {
		echo json_encode(array("statusCode" => 201));
		exit();
	}
	
	try {
		$sql_chknumcard = $conn->prepare("SELECT his_numcard FROM tb_history WHERE his_numcard = ?");
		$sql_chknumcard->execute([$numcard]);
		$row = $sql_chknumcard->fetch(PDO::FETCH_ASSOC);
		
		if (!$row) {
			echo json_encode(array("statusCode" => 201));
		} else {
			echo json_encode(array("statusCode" => 200));
		}
	} catch (PDOException $e) {
		echo json_encode(array("statusCode" => 500, "message" => $e->getMessage()));
	}
?>
