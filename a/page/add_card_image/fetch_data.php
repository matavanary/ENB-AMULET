<?php
// Database connection
include("../../../config/dbConnection.php");

$his_code = isset($_POST["his_code"]) ? $_POST["his_code"] : '';

if (empty($his_code)) {
    echo "<div class='text-center py-4 text-muted'>ไม่พบรหัสบัตร</div>";
    exit();
}

// 1. ลบแถวที่ไม่มีรูปภาพ (แถวว่างเปล่า) ออกจากฐานข้อมูล เพื่อให้แสดงตามจริง
$delEmpty = $conn->prepare("DELETE FROM tb_image WHERE his_code = ? AND (images IS NULL OR images = '' OR images = 'NULL')");
$delEmpty->execute(array($his_code));

// 2. ดึงรายการรูปภาพที่มีอยู่จริงของ his_code นี้
$stmt = $conn->prepare("SELECT * FROM tb_image WHERE his_code = ? AND images IS NOT NULL AND images != '' ORDER BY image_sort ASC, id ASC");
$stmt->execute(array($his_code));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. จัดเรียงลำดับ image_sort ใหม่ให้ต่อเนื่องกัน (1, 2, 3...)
$reIndex = 1;
foreach ($rows as $k => $r) {
    if (intval($r['image_sort']) !== $reIndex) {
        $up = $conn->prepare("UPDATE tb_image SET image_sort = ? WHERE id = ?");
        $up->execute(array($reIndex, $r['id']));
        $rows[$k]['image_sort'] = $reIndex;
    }
    $reIndex++;
}

$currentCount = count($rows);
$maxImages = 9;
?>

<!-- แถบเครื่องมือจัดการจำนวนรูปภาพ -->
<div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between flex-wrap">
  <div>
    <span class="font-weight-bold text-gray-800">
      <i class="fas fa-images text-primary mr-1"></i>รายการรูปภาพทั้งหมด
    </span>
    <span class="badge <?php echo ($currentCount >= $maxImages) ? 'badge-success' : 'badge-primary'; ?> ml-2 px-2 py-1">
      <?php echo $currentCount; ?> / <?php echo $maxImages; ?> รูป
    </span>
  </div>
  <div class="mt-2 mt-sm-0">
    <?php if ($currentCount < $maxImages): ?>
      <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill font-weight-bold btn-add-new-img">
        <i class="fas fa-plus mr-1"></i>เพิ่มรูปภาพใหม่ (<?php echo ($currentCount + 1); ?>/9)
      </button>
    <?php else: ?>
      <span class="badge badge-success px-3 py-2">
        <i class="fas fa-check-circle mr-1"></i>ครบจำนวนสูงสุด 9 รูปแล้ว
      </span>
    <?php endif; ?>
  </div>
</div>

<?php if ($currentCount > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle mb-0" id="imageTable" width="100%" cellspacing="0">
      <thead class="bg-light text-dark">
        <tr>
          <th width="8%" class="text-center">ลำดับ</th>
          <th width="24%" class="text-center">รูปภาพ</th>
          <th width="22%">หัวข้อมุมมอง</th>
          <th width="16%" class="text-center">สถานะ</th>
          <th width="18%">รายละเอียด</th>
          <th width="12%" class="text-center">จัดการ</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row) { 
          $rowId = $row['id'];
          $sort = $row['image_sort'];
          $imagePath = 'upimg-port/' . htmlspecialchars($row['images']);
          $detail1 = !empty($row['detail1']) ? htmlspecialchars($row['detail1']) : '';
          $detail2 = !empty($row['detail2']) ? htmlspecialchars($row['detail2']) : '';
          $detail3 = !empty($row['detail3']) ? htmlspecialchars($row['detail3']) : '';
        ?>
          <tr>
            <td class="text-center font-weight-bold text-muted">
              <span class="badge badge-pill badge-secondary px-2 py-1 font-weight-bold">
                <?php echo $sort; ?>
              </span>
            </td>
            <td class="text-center py-2">
              <div class="mb-2">
                <a href="<?php echo $imagePath; ?>" target="_blank" title="คลิกเพื่อดูภาพขยาย">
                  <img src="<?php echo $imagePath; ?>" 
                       class="img-thumbnail shadow-sm rounded" 
                       style="width: 85px; height: 85px; object-fit: cover; cursor: pointer;" 
                       alt="ภาพที่ <?php echo $sort; ?>" />
                </a>
              </div>
              <div class="btn-group btn-group-sm" role="group">
                <button type="button" 
                        class="btn btn-outline-primary btn-sm btn-change-img" 
                        data-toggle="modal" 
                        data-target="#exampleModal" 
                        data-id="<?php echo $rowId; ?>"
                        title="เปลี่ยนภาพนี้">
                  <i class="fas fa-sync-alt mr-1"></i>เปลี่ยน
                </button>
                <button type="button" 
                        class="btn btn-outline-danger btn-sm delete-btn" 
                        data-id="<?php echo $rowId; ?>"
                        title="ลบแถวภาพนี้">
                  <i class="fas fa-trash-alt mr-1"></i>ลบ
                </button>
              </div>
            </td>
            <td>
              <?php if (!empty($detail1)) { ?>
                <span class="font-weight-bold text-dark"><?php echo $detail1; ?></span>
              <?php } else { ?>
                <span class="text-muted small font-italic">- ไม่ได้ระบุ -</span>
              <?php } ?>
            </td>
            <td class="text-center">
              <?php if (!empty($detail2)) { ?>
                <span class="badge badge-info px-2 py-1"><?php echo $detail2; ?></span>
              <?php } else { ?>
                <span class="text-muted small">-</span>
              <?php } ?>
            </td>
            <td>
              <?php if (!empty($detail3)) { ?>
                <span class="small text-dark"><?php echo $detail3; ?></span>
              <?php } else { ?>
                <span class="text-muted small">-</span>
              <?php } ?>
            </td>
            <td class="text-center">
              <a href="editform.php?id=<?php echo $rowId; ?>" 
                 class="btn btn-outline-secondary btn-sm shadow-sm"
                 title="แก้ไขคำบรรยาย / หัวข้อ">
                <i class="fas fa-edit mr-1"></i>แก้ไข
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <!-- กรอบแสดงเมื่อยังไม่มีรูปภาพใดๆ -->
  <div class="text-center py-5 px-3">
    <div class="mb-3">
      <i class="far fa-images fa-4x text-gray-300"></i>
    </div>
    <h5 class="font-weight-bold text-gray-800">ยังไม่มีรูปภาพสำหรับบัตรรับรองนี้</h5>
    <p class="text-muted small mb-4">คุณสามารถเพิ่มรูปภาพพระเครื่องมุมมองต่างๆ ได้สูงสุด 9 รูป (เช่น ด้านหน้า, ด้านหลัง, ขอบข้าง, โค้ด)</p>
    <button type="button" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm font-weight-bold btn-add-new-img">
      <i class="fas fa-plus mr-2"></i>เพิ่มรูปภาพแรก (1/9)
    </button>
  </div>
<?php endif; ?>
