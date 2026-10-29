<?php
include("../../../config/dbConnection.php");

$action = isset($_POST['action']) ? $_POST['action'] : '';
$image_id = isset($_POST['image_id']) ? $_POST['image_id'] : '';
$his_code = isset($_POST['his_code']) ? $_POST['his_code'] : '';
$detail1 = isset($_POST['detail1']) ? $_POST['detail1'] : '';
$detail2 = isset($_POST['detail2']) ? $_POST['detail2'] : '';
$detail3 = isset($_POST['detail3']) ? $_POST['detail3'] : '';

if (!empty($_FILES['file_name']['name'])) {
    $fileTmp = $_FILES['file_name']['tmp_name'];
    $sourceProperties = @getimagesize($fileTmp);
    if ($sourceProperties === false) {
        http_response_code(400);
        echo "ไฟล์ที่อัปโหลดไม่ใช่รูปภาพที่ถูกต้อง";
        exit;
    }

    $folderPath = 'upimg-port/';
    if (!file_exists($folderPath)) {
        @mkdir($folderPath, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION));
    $fileNewName = rand(10000000, 99999999) . "." . $ext;
    $imageType = $sourceProperties[2];

    // กรณีเพิ่มรูปภาพใหม่ (Add New Image Row)
    if ($action === 'add' || empty($image_id)) {
        if (empty($his_code)) {
            http_response_code(400);
            echo "ไม่พบรหัสบัตร";
            exit;
        }

        // ตรวจสอบจำนวนภาพปัจจุบัน
        $chkStmt = $conn->prepare("SELECT COUNT(*) FROM tb_image WHERE his_code = ? AND images IS NOT NULL AND images != ''");
        $chkStmt->execute(array($his_code));
        $currentCount = intval($chkStmt->fetchColumn());

        if ($currentCount >= 9) {
            http_response_code(400);
            echo "ไม่สามารถเพิ่มรูปได้ เนื่องจากครบจำนวนสูงสุด 9 รูปแล้ว";
            exit;
        }

        $nextSort = $currentCount + 1;

        // บันทึกและย่อขนาดรูปภาพ
        saveResizedImage($fileTmp, $folderPath . $fileNewName, $imageType, $sourceProperties[0], $sourceProperties[1]);

        $insStmt = $conn->prepare("INSERT INTO tb_image (his_code, image_sort, images, detail1, detail2, detail3) VALUES (?, ?, ?, ?, ?, ?)");
        $insStmt->execute(array($his_code, $nextSort, $fileNewName, $detail1, $detail2, $detail3));
        echo "success";
        exit;
    }

    // กรณีเปลี่ยนรูปภาพในแถวเดิม (Update Existing Row)
    if (!empty($image_id)) {
        $sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
        $sql->execute(array($image_id));
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            http_response_code(404);
            echo "ไม่พบรายการรูปภาพ";
            exit;
        }

        $oldFilePath = $folderPath . $row['images'];
        if (!empty($row['images']) && file_exists($oldFilePath)) {
            @unlink($oldFilePath);
        }

        saveResizedImage($fileTmp, $folderPath . $fileNewName, $imageType, $sourceProperties[0], $sourceProperties[1]);

        $stmt = $conn->prepare("UPDATE tb_image SET images = :images WHERE id = :id");
        $stmt->bindParam(':images', $fileNewName, PDO::PARAM_STR);
        $stmt->bindParam(':id', $image_id, PDO::PARAM_STR);
        $stmt->execute();
        echo "success";
        exit;
    }
} else {
    http_response_code(400);
    echo "กรุณาเลือกไฟล์รูปภาพ";
    exit;
}

function saveResizedImage($fileTmp, $destination, $imageType, $width, $height) {
    $targetWidth = $width < 1280 ? $width : 1280;
    $targetHeight = intval(($height / $width) * $targetWidth);
    $targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);

    switch ($imageType) {
        case IMAGETYPE_PNG:
            $imageResourceId = @imagecreatefrompng($fileTmp);
            if ($imageResourceId) {
                imagealphablending($targetLayer, false);
                imagesavealpha($targetLayer, true);
                imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
                imagepng($targetLayer, $destination);
                imagedestroy($imageResourceId);
            } else {
                move_uploaded_file($fileTmp, $destination);
            }
            break;
        case IMAGETYPE_GIF:
            $imageResourceId = @imagecreatefromgif($fileTmp);
            if ($imageResourceId) {
                imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
                imagegif($targetLayer, $destination);
                imagedestroy($imageResourceId);
            } else {
                move_uploaded_file($fileTmp, $destination);
            }
            break;
        case IMAGETYPE_JPEG:
        default:
            $imageResourceId = @imagecreatefromjpeg($fileTmp);
            if ($imageResourceId) {
                imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
                imagejpeg($targetLayer, $destination, 90);
                imagedestroy($imageResourceId);
            } else {
                move_uploaded_file($fileTmp, $destination);
            }
            break;
    }
    imagedestroy($targetLayer);
}
?>
