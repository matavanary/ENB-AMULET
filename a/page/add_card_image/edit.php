<?php
	include("../../../config/dbConnection.php");
	$editId = isset($_POST['editId']) ? $_POST['editId'] : '';

	if (!empty($editId)) {
		$sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
		$sql->execute(array($editId));
		$query = $sql->fetchAll(PDO::FETCH_ASSOC);
		if ($sql->rowCount() > 0) {
			foreach ($query as $row) {
				$hasImg = (!empty($row['images']) && file_exists('upimg-port/' . $row['images']));
				$image = $hasImg ? 'upimg-port/' . htmlspecialchars($row['images']) : '';
				echo "<form id='editForm'>
						<div class='modal-body p-4'>
							<input type='hidden' name='image_id' id='image_id' value='" . htmlspecialchars($row['id']) . "'/>
							<div class='form-group mb-3'>
								<label class='font-weight-bold text-dark small'>เลือกไฟล์รูปภาพ (JPG, PNG, JPEG):</label>
								<div class='custom-file'>
									<input type='file' class='custom-file-input' name='file_name' id='file_name' accept='image/*' required>
									<label class='custom-file-label' for='file_name'>เลือกไฟล์ภาพ...</label>
								</div>
							</div>";
				if ($hasImg) {
					echo "<div class='text-center my-3'>
							<div class='small text-muted mb-2'>รูปภาพปัจจุบัน (ช่องที่ " . $row['image_sort'] . "):</div>
							<img src='" . $image . "' class='img-thumbnail rounded shadow-sm' style='max-width: 180px; max-height: 180px; object-fit: cover;'/>
						  </div>";
				} else {
					echo "<div class='text-center my-3 text-muted small'>
							<i class='far fa-image fa-3x text-gray-300 d-block mb-1'></i>
							ยังไม่มีรูปภาพในช่องที่ " . $row['image_sort'] . "
						  </div>";
				}
				echo "	</div>
						<div class='modal-footer bg-light'>
							<button type='button' class='btn btn-secondary btn-sm px-3' data-dismiss='modal'>ยกเลิก</button>
							<button type='submit' class='btn btn-primary btn-sm px-4 font-weight-bold'><i class='fas fa-upload mr-1'></i>อัปโหลด</button>
						</div>
					</form>";
			}
		}
	}
?>
