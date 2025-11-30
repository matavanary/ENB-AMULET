<?php
	include("../config/dbConnection.php");

	$numcard=$_POST["numcard"];

    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
	
	$sql_chknumcard = $conn->prepare("SELECT DISTINCT his_numcard FROM tb_history WHERE his_numcard = ?");
	$sql_chknumcard->execute([$numcard]);
	$row = $sql_chknumcard->fetch(PDO::FETCH_ASSOC);
	
	if($sql_chknumcard->rowCount() < 1){
		echo json_encode(array("statusCode"=>201));
	}else{
		echo json_encode(array("statusCode"=>200));
	}

?>