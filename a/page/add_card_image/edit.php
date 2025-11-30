<?php
	include("../../../config/dbConnection.php");
	if (isset($_POST['editId'])) {
		$editId = $_POST['editId'];
	}
	if (!empty($editId)) {
		$sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
		$sql->execute([$editId]);
		$query = $sql->fetchAll();
		if($sql->rowCount() >= 0){
			foreach($query as $row) {
			$image = 'upimg-port/'.$row['images'];
			echo "<form id='editForm'>
					<div class='modal-body' style='width: 100%;height: 300px;'>
						<input type='hidden' name='image_id' id='image_id' value='".$row['id']."'/>
						<div class='form-group'>
							<div class='custom-file mb-3'>
								<input type='file' class='custom-file-input' name='file_name' id='file_name'>
								<label class='custom-file-label'>เลือกรูปภาพ</label><br><br>
								<img src='".$image."' class='img-thumbnail' width='200px' height='200px'/>
							</div>
						</div>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-danger' data-dismiss='modal'>ยกเลิก</button>
						<button type='submit' class='btn btn-success'>ยืนยัน</button>
					</div>
				</form>";
			}
		}
	}

?>
