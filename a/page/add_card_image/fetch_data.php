
<?php
	// Database connection
	include("../../../config/dbConnection.php");

	$his_code = $_POST["his_code"];
	
	$stmt = $conn->prepare("select * from tb_image where his_code = ? and image_sort between 1 and 9");
	$stmt->execute([$his_code]);
	$query = $stmt->fetchAll();

	if($stmt->rowCount() >= 0){
		echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
				<thead>
			        <tr>
			          <th><center>ลำดับ</center></th>
			          <th><center>รูปภาพ</center></th>
			          <th><center>หัวข้อ</center></th>
			          <th><center>สถานะ</center></th>
			          <th><center>รายละเอียด</center></th>
			          <th><center>จัดการ</center></th>
			        </tr>
			      </thead>";
		foreach($query as $row) {
			if(isset($row['images'])){
				$image_value = $row['images'];
				$images = "<img src='upimg-port/".$image_value."' class='img-thumbnail' width='100px' height='100px' />";
			}else{
				$image_value = '';
				$images = '';
			}
			echo  "<tr>
			          	<td><center>".$row["image_sort"]."</center></td>
			          	<td><center>".$images."</center>
					  		<center><button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#exampleModal' data-id='".$row["id"]."'><b><h5>เปลี่ยนภาพ</b></h5></button></center>";
							if(isset($row['images'])){
								echo  "<center><button type='button' class='btn btn-danger btn-sm delete-btn' data-id='".$row["id"]."'><b><h5>ลบภาพ</b></h5></button></center>";
							}
				echo  "	</td>
						<td><center>".$row["detail1"]."</center></td>
						<td><center>".$row["detail2"]."</center></td>
						<td><center>".$row["detail3"]."</center></td>
						<td><center>
							<a href='editform.php?id=".$row["id"]."'>
								<button type='button' class='btn btn-primary btn-sm' data-id='".$row["id"]."'>
							<b><h5>แก้ไขข้อมูล</b></h5></button></a></center>
						</td>
					</tr>";
		}
		echo "</table>";
	}else {
		echo "<h3 style='text-align:center'>No Image found</h3>";
	}
?>
