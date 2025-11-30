<?php
include("../config/dbConnection.php");
session_start();
session_destroy();
echo "<script type='text/javascript'>";
echo "alert('ออกจากระบบเรียบร้อยค่ะ');";
echo "window.location = '$webhost/vip/index.php'; ";
echo "</script>";
 ?>
