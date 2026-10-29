<?php
include("../../../config/dbConnection.php");

$deleteId = isset($_POST['deleteId']) ? $_POST['deleteId'] : '';

if (!empty($deleteId)) {
    $sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
    $sql->execute(array($deleteId));
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $his_code = $row['his_code'];
        if (!empty($row['images'])) {
            $filePath = 'upimg-port/' . $row['images'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        // ลบแถวนี้ออกจากฐานข้อมูล
        $del = $conn->prepare("DELETE FROM tb_image WHERE id = ?");
        $del->execute(array($deleteId));

        // จัดเรียงลำดับ image_sort ที่เหลือใหม่ให้เรียง 1, 2, 3...
        $reStmt = $conn->prepare("SELECT id FROM tb_image WHERE his_code = ? ORDER BY image_sort ASC, id ASC");
        $reStmt->execute(array($his_code));
        $remaining = $reStmt->fetchAll(PDO::FETCH_ASSOC);
        $idx = 1;
        foreach ($remaining as $rem) {
            $up = $conn->prepare("UPDATE tb_image SET image_sort = ? WHERE id = ?");
            $up->execute(array($idx, $rem['id']));
            $idx++;
        }
        echo "success";
        exit;
    }
}
echo "not found";
?>
