<?php
	include("../../../config/dbConnection.php");

  $sql = $conn->prepare("INSERT INTO tb_member (member_user, member_pass, member_name, member_tel, status)
  VALUES (
    '".$_POST["member_user"]."',
    '".$_POST["member_pass"]."',
    '".$_POST["member_name"]."',
    '".$_POST["member_tel"]."',
    '".$_POST["status"]."')");
  $query = $sql->execute();
  if($query) {
    echo "<script type='text/javascript'>";
    echo "alert('เพิ่มผู้ดูแลระบบเรียบร้อย');";
    echo "window.location = './'; ";
    echo "</script>";
  }
  else{
    echo "<script type='text/javascript'>";
    echo "alert('ไม่สามารถเพิ่มข้อมูลได้');";
    echo "window.history.back()";
    echo "</script>";
  }