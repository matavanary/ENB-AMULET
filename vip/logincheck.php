<?php include("../config/dbConnection.php") ?>
<?php
	session_start();

	$member_user=$_POST["member_user"];
	$member_pass=$_POST["member_pass"];

	$chk_member = $conn->prepare("SELECT * FROM tb_member WHERE member_user = :member_user AND member_pass = :member_pass");
	$chk_member->bindParam(':member_user', $member_user , PDO::PARAM_STR);
	$chk_member->bindParam(':member_pass', $member_pass , PDO::PARAM_STR);
	$chk_member->execute();
	
    // echo"<pre>";
    // print_r($chk_member->execute());
    // echo"</pre>";
    // exit();

	if($chk_member->execute() == 1){
	// if(!$objResult) {
        $objResult = $chk_member->fetch(PDO::FETCH_ASSOC);

		$_SESSION["member_id"] = $objResult["member_id"];
		$_SESSION["member_name"] = $objResult["member_name"];
		$_SESSION["status"] = $objResult["status"];

		session_write_close();

		if($objResult["status"] == "1"){
			echo "<script type='text/javascript'>";
			echo "alert('ยินดีต้อนรับผู้ดูแลระบบค่ะ');";
			echo "window.location = '../a/index.php'; ";
			echo "</script>";
		}else if($objResult["status"] == "2"){
			echo "<script type='text/javascript'>";
			echo "alert('ยินดีต้อนสมาชิกค่ะ');";
			echo "window.location = '../a/index.php'; ";
			echo "</script>";
		}
		else
		{
			header("location:./index.php");
		}
}else{
	
	echo "<script type='text/javascript'>";
	echo "alert('กรอกชื่อผู้ใช้ หรือรหัสผ่านผิด');";
	echo "window.location = './index.php'; ";
	echo "</script>"; 
}
       
    $conn = null; 
?>
