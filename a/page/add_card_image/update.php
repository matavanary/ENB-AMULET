<?php
	include("../../../config/dbConnection.php");
	if (isset($_POST['image_id'])) {
		$image_id = $_POST['image_id'];
	}
	// if (!empty($_FILES['file_name']['name'])) {
	// 	$fileTmp = $_FILES['file_name']['tmp_name'];
	// 	$allowImg = array('png','jpeg','jpg','gif');
	// 	$fileExnt = explode('.', $_FILES['file_name']['name']);
	// 	$fileActExt   = strtolower(end($fileExnt));
	// 	$newFile = 	rand("10000000","99999999"). '.'. $fileActExt;
	// 	$destination = 'upimg-port/'.$newFile;
	// 	if (in_array($fileActExt, $allowImg)) {
	// 		if ($_FILES['file_name']['size'] > 0 && $_FILES['file_name']['error']==0) {
				
	// 			$sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
	// 			$sql->execute([$image_id]);
	// 			$row = $sql->fetch(PDO::FETCH_ASSOC);

	// 			$filePath = 'upimg-port/'.$row['images'];

	// 			if (move_uploaded_file($fileTmp, $destination)) {
	// 				$stmt = $conn->prepare("UPDATE tb_image SET images=:images	WHERE id=:id");
	// 				$stmt->bindParam(':images', $newFile , PDO::PARAM_STR);
	// 				$stmt->bindParam(':id', $image_id , PDO::PARAM_STR);
	// 				$stmt->execute();
	// 				unlink($filePath);
	// 			}
	// 		}
	// 	}
	// }

	if (!empty($_FILES['file_name']['name'])) {
		$fileTmp = $_FILES['file_name']['tmp_name'];
        $sourceProperties = getimagesize($fileTmp);
		$fileNewName = 	rand("10000000","99999999");
		$folderPath = 'upimg-port/';
        $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
        $imageType = $sourceProperties[2];
		
		
		$sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
		$sql->execute([$image_id]);
		$row = $sql->fetch(PDO::FETCH_ASSOC);

        $newFile = $fileNewName.".".$ext;
		$filePath = 'upimg-port/'.$row['images'];
		$stmt = $conn->prepare("UPDATE tb_image SET images=:images	WHERE id=:id");
		$stmt->bindParam(':images', $newFile , PDO::PARAM_STR);
		$stmt->bindParam(':id', $image_id , PDO::PARAM_STR);
		$stmt->execute();
		unlink($filePath);

        switch ($imageType) {
            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($fileTmp); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagepng($targetLayer,$folderPath.$fileNewName.".".$ext);
                break;
            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($fileTmp); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagegif($targetLayer,$folderPath.$fileNewName.".".$ext);
                break;
            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($fileTmp); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagejpeg($targetLayer,$folderPath.$fileNewName.".".$ext);
                break;
            default:
                echo "Invalid Image type.";
                exit;
                break;
        }        
    } 
	
    function imageResize($imageResourceId,$width,$height) {
        $targetWidth = $width < 1280 ? $width : 1280 ;
        $targetHeight = ($height/$width)* $targetWidth;
        $targetLayer = imagecreatetruecolor($targetWidth,$targetHeight);
        imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        return $targetLayer;
    }

