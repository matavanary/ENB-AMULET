<?php
	session_start();
	include("../../../config/dbConnection.php");

  function random_char($len){
    $chars = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"; 
    $ret_char = "";
    $num = strlen($chars);
    for($i = 0; $i < $len; $i++) {
        $ret_char.= $chars[rand()%$num];
        $ret_char.=""; 
    }
    return $ret_char; 
  }
  $his_code = random_char(30);  
  $date=date("Y-m-d H:i:s");
  $member_id=$_SESSION['member_id'];
  
  // echo"<pre>";
  // print_r($_POST);
  // echo"</pre>";
  // exit();
  
  $his_type           = $_POST["his_type"];
  $his_nameproduct    = $_POST["his_nameproduct"];
  $his_province       = $_POST["his_province"];
  $his_owner          = $_POST["his_owner"];
  $his_price          = $_POST["his_price"];
  $his_datecard       = $_POST["his_datecard"];
  $his_numcard        = $_POST["his_numcard"];
  $his_detailproduct  = $_POST["his_detailproduct"];
  $his_tel            = $_POST["his_tel"];
  // $his_code           = $his_code;
  // $his_create_date    = $date;    
  // $his_create_by      = $member_id;

  $stmt = $conn->prepare("INSERT INTO tb_history (his_type, his_nameproduct, his_province, his_owner, his_price,his_datecard,his_numcard,his_detailproduct,his_tel,his_code,his_create_date,his_create_by)
    VALUES (:his_type, :his_nameproduct, :his_province, :his_owner, :his_price, :his_datecard, :his_numcard, :his_detailproduct, :his_tel, :his_code, :his_create_date, :his_create_by)");
  $stmt->bindParam(':his_type', $his_type, PDO::PARAM_STR);
  $stmt->bindParam(':his_nameproduct', $his_nameproduct, PDO::PARAM_STR);
  $stmt->bindParam(':his_province', $his_province, PDO::PARAM_STR);
  $stmt->bindParam(':his_owner', $his_owner, PDO::PARAM_STR);
  $stmt->bindParam(':his_price', $his_price, PDO::PARAM_STR);
  $stmt->bindParam(':his_datecard', $his_datecard, PDO::PARAM_STR);
  $stmt->bindParam(':his_numcard', $his_numcard, PDO::PARAM_STR);
  $stmt->bindParam(':his_detailproduct', $his_detailproduct, PDO::PARAM_STR);
  $stmt->bindParam(':his_tel', $his_tel, PDO::PARAM_STR);
  $stmt->bindParam(':his_code', $his_code, PDO::PARAM_STR);
  $stmt->bindParam(':his_create_date', $date, PDO::PARAM_STR);    
  $stmt->bindParam(':his_create_by', $member_id, PDO::PARAM_STR);
  $result = $stmt->execute();
  
  if($result){
    $sql1 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','1')");
    $query1 = $sql1->execute();
    $sql2 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','2')");
    $query2 = $sql2->execute();
    $sql3 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','3')");
    $query3 = $sql3->execute();
    $sql4 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','4')");
    $query4 = $sql4->execute();
    $sql5 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','5')");
    $query5 = $sql5->execute();
    $sql6 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','6')");
    $query6 = $sql6->execute();
    $sql7 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','7')");
    $query7 = $sql7->execute();
    $sql8 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','8')");
    $query8 = $sql8->execute();
    $sql9 = $conn->prepare("INSERT INTO tb_image (his_code, image_sort) VALUES ('".$his_code."','9')");
    $query9 = $sql9->execute();
    echo "<script type='text/javascript'>";
    // echo "alert('เพิ่มเรียบร้อย');";
    echo "window.location = '../add_card_image/index.php?his_code=$his_code'; ";
    echo "</script>";
  }else{
      echo "<script type='text/javascript'>";
      echo "alert('ไม่สามารถเพิ่มข้อมูลได้');";
      echo "window.history.back()";
      echo "</script>";
  }
  $conn = null; //close connect db
   