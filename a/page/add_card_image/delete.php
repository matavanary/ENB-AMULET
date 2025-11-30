<?php
	include("../../../config/dbConnection.php");
	$deleteId = $_POST['deleteId'];

	$sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
	$sql->execute([$deleteId]);
	$query = $sql->fetchAll();

	foreach($query as $row) {
		$filePath = 'upimg-port/'.$row['images'];
		unlink($filePath);
		$id = $row['id'];
		$stmt = $conn->prepare("UPDATE tb_image SET images=NULL WHERE id = '$id'");
		$stmt->execute();
	}
