<?php 
include("../../../config/dbConnection.php");
include("../../session.php");

$strmember_id = isset($_GET["id"]) ? $_GET["id"] : '';
$result = null;
$card = null;

if (!empty($strmember_id)) {
    $sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
    $sql->execute(array($strmember_id));
    $result = $sql->fetch(PDO::FETCH_ASSOC);

    if ($result && !empty($result['his_code'])) {
        $sql_card = $conn->prepare("SELECT * FROM tb_history WHERE his_code = ?");
        $sql_card->execute(array($result['his_code']));
        $card = $sql_card->fetch(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="แก้ไขรายละเอียดรูปภาพพระเครื่อง">
  <title>แก้ไขรายละเอียดรูปภาพ - สถาบันรับรองพระเครื่องเมืองชลฯ</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Prompt', 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      color: #4a5568;
      background-color: #f8f9fc;
    }

    .card {
      border-radius: 0.75rem;
      border: 1px solid rgba(0, 0, 0, 0.05);
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.08) !important;
    }

    .card-header {
      border-top-left-radius: 0.75rem !important;
      border-top-right-radius: 0.75rem !important;
      background-color: #ffffff;
      border-bottom: 1px solid #edf2f7;
    }

    .page-title-box {
      background: white;
      border-radius: 0.75rem;
      padding: 1.25rem 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
      border: 1px solid #edf2f7;
    }

    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 0.5rem;
      font-size: 0.85rem;
    }

    .form-group label {
      font-size: 0.875rem;
      font-weight: 600;
      color: #4a5568;
      margin-bottom: 0.4rem;
    }

    .form-control {
      border-radius: 0.5rem;
      border: 1px solid #cbd5e0;
      padding: 0.55rem 0.85rem;
      font-size: 0.9rem;
      transition: all 0.2s ease-in-out;
    }

    .form-control:focus {
      border-color: #4e73df;
      box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }

    .img-preview-box {
      background: #f8fafc;
      border: 2px dashed #cbd5e0;
      border-radius: 0.75rem;
      padding: 1.5rem;
      text-align: center;
    }

    .img-preview-box img {
      max-width: 100%;
      max-height: 320px;
      object-fit: contain;
      border-radius: 0.5rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .btn-submit {
      padding: 0.6rem 2rem;
      border-radius: 0.5rem;
      font-weight: 600;
      letter-spacing: 0.3px;
    }
  </style>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include("../../include/menu.php") ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <?php include("../../include/nav.php") ?>

        <!-- Begin Page Content -->
        <div class="container-fluid py-2">

          <?php if (!$result): ?>
            <div class="card shadow mb-4">
              <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-circle fa-4x text-warning mb-3"></i>
                <h4 class="font-weight-bold text-gray-800">ไม่พบข้อมูลรูปภาพที่ระบุ</h4>
                <p class="text-muted mb-4">รูปภาพนี้อาจถูกลบไปแล้วหรือรหัสไม่ถูกต้อง</p>
                <a href="../card/index.php" class="btn btn-primary px-4 rounded-pill">
                  <i class="fas fa-arrow-left mr-2"></i>กลับหน้ารายการบัตร
                </a>
              </div>
            </div>
          <?php else: 
            $his_code = isset($result["his_code"]) ? $result["his_code"] : '';
            $image_sort = isset($result["image_sort"]) ? $result["image_sort"] : '';
            $detail1 = isset($result["detail1"]) ? $result["detail1"] : '';
            $detail2 = isset($result["detail2"]) ? $result["detail2"] : '';
            $detail3 = isset($result["detail3"]) ? $result["detail3"] : '';
            $hasImage = (!empty($result['images']) && file_exists('upimg-port/' . $result['images']));
            $imagePath = $hasImage ? 'upimg-port/' . htmlspecialchars($result['images']) : '';
            $his_numcard = isset($card['his_numcard']) ? $card['his_numcard'] : '-';
            $amuletName = isset($card['his_nameproduct']) ? $card['his_nameproduct'] : '';
          ?>

            <!-- Page Header -->
            <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between">
              <div>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../card/index.php" class="text-primary">รายการบัตร</a></li>
                    <li class="breadcrumb-item"><a href="index.php?his_code=<?php echo urlencode($his_code); ?>" class="text-primary">จัดการรูปภาพ (เลขที่: <?php echo htmlspecialchars($his_numcard); ?>)</a></li>
                    <li class="breadcrumb-item active" aria-current="page">แก้ไขรายละเอียดรูปภาพ</li>
                  </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-gray-800 mb-0">
                  <i class="fas fa-edit text-primary mr-2"></i>แก้ไขรายละเอียดรูปภาพ (ลำดับที่ <?php echo $image_sort; ?>)
                </h1>
                <?php if (!empty($amuletName)): ?>
                  <p class="text-muted small mb-0 mt-1">
                    <i class="fas fa-gem text-warning mr-1"></i><?php echo htmlspecialchars($amuletName); ?>
                  </p>
                <?php endif; ?>
              </div>
              <div class="mt-3 mt-md-0">
                <a href="index.php?his_code=<?php echo urlencode($his_code); ?>" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill shadow-sm">
                  <i class="fas fa-arrow-left mr-1"></i> ย้อนกลับไปหน้าจัดการรูปภาพ
                </a>
              </div>
            </div>

            <!-- Content Row -->
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-info-circle mr-2"></i>ข้อมูลรายละเอียดรูปภาพ ลำดับที่ <?php echo $image_sort; ?>
                </h6>
                <span class="badge badge-primary px-3 py-2">ภาพช่องที่ <?php echo $image_sort; ?> / 9</span>
              </div>
              <div class="card-body p-4">
                <form action="editsave.php" name="frmAdd" method="post">
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($result["id"]); ?>">

                  <div class="row align-items-center">
                    <!-- แสดงภาพพรีวิว -->
                    <div class="col-lg-4 mb-4 mb-lg-0">
                      <div class="img-preview-box">
                        <?php if ($hasImage): ?>
                          <img src="<?php echo $imagePath; ?>" alt="รูปภาพลำดับที่ <?php echo $image_sort; ?>" class="img-fluid mb-2">
                          <div class="small text-muted font-weight-bold">
                            <i class="fas fa-image mr-1"></i>ภาพปัจจุบัน (ช่องที่ <?php echo $image_sort; ?>)
                          </div>
                        <?php else: ?>
                          <div class="py-5">
                            <i class="far fa-image fa-4x text-gray-400 mb-3"></i>
                            <p class="text-muted small mb-0">ยังไม่มีการอัปโหลดรูปภาพสำหรับช่องนี้</p>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <!-- ฟอร์มกรอกรายละเอียด -->
                    <div class="col-lg-8">
                      <div class="form-group mb-3">
                        <label>หัวข้อมุมมองภาพ (เช่น ด้านหน้า, ด้านหลัง, โค้ดใต้ฐาน):</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-heading"></i></span>
                          </div>
                          <input type="text" class="form-control" name="detail1" placeholder="เช่น ด้านหน้าองค์พระ" value="<?php echo htmlspecialchars($detail1); ?>">
                        </div>
                      </div>

                      <div class="form-group mb-3">
                        <label>สถานะภาพ (เช่น ภาพหลัก, ภาพขยาย, สภาพสมบูรณ์):</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                          </div>
                          <input type="text" class="form-control" name="detail2" placeholder="เช่น ภาพมุมมองหลัก" value="<?php echo htmlspecialchars($detail2); ?>">
                        </div>
                      </div>

                      <div class="form-group mb-4">
                        <label>รายละเอียดเพิ่มเติมเกี่ยวกับภาพนี้:</label>
                        <textarea class="form-control" name="detail3" rows="4" placeholder="ระบุรายละเอียดเพิ่มเติมเกี่ยวกับจุดสังเกต ตำหนิ รอยจาร หรือคำอธิบายภาพนี้..."><?php echo htmlspecialchars($detail3); ?></textarea>
                      </div>

                      <div class="border-top pt-3 d-flex flex-column flex-sm-row justify-content-end align-items-center">
                        <a href="index.php?his_code=<?php echo urlencode($his_code); ?>" class="btn btn-light btn-submit text-secondary border mr-sm-2 mb-2 mb-sm-0 w-100 w-sm-auto text-center">
                          <i class="fas fa-times mr-2"></i>ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-success btn-submit shadow-sm w-100 w-sm-auto" name="button">
                          <i class="fas fa-check mr-2"></i>บันทึกข้อมูล
                        </button>
                      </div>

                    </div>
                  </div>

                </form>
              </div>
            </div>

          <?php endif; ?>

        </div>
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../../js/sb-admin-2.min.js"></script>

</body>

</html>
