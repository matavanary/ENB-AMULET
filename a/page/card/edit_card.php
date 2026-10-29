<?php 
include("../../../config/dbConnection.php");
include("../../session.php");

$strhis_code = isset($_GET["his_code"]) ? $_GET["his_code"] : '';
$result = null;

if (!empty($strhis_code)) {
    $sql = $conn->prepare("SELECT * FROM tb_history WHERE his_code = ?");
    $sql->execute(array($strhis_code));
    $result = $sql->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="แก้ไขข้อมูลบัตรรับรองพระเครื่อง">
  <title>แก้ไขข้อมูลบัตร - สถาบันรับรองพระเครื่องเมืองชลฯ</title>

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

    .section-title {
      font-size: 0.95rem;
      font-weight: 600;
      color: #2b6cb0;
      padding-bottom: 0.5rem;
      margin-bottom: 1.25rem;
      border-bottom: 2px solid #ebf8ff;
      display: flex;
      align-items: center;
    }

    .section-title i {
      margin-right: 0.5rem;
      color: #4299e1;
    }

    .form-group label {
      font-size: 0.875rem;
      font-weight: 600;
      color: #4a5568;
      margin-bottom: 0.4rem;
    }

    .form-group label .required {
      color: #e53e3e;
      margin-left: 2px;
    }

    .input-group-text {
      background-color: #f7fafc;
      border: 1px solid #cbd5e0;
      border-right: none;
      color: #718096;
      border-top-left-radius: 0.5rem;
      border-bottom-left-radius: 0.5rem;
    }

    .form-control {
      border-radius: 0.5rem;
      border: 1px solid #cbd5e0;
      padding: 0.55rem 0.85rem;
      font-size: 0.9rem;
      transition: all 0.2s ease-in-out;
    }

    .input-group > .form-control {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-control:focus {
      border-color: #4e73df;
      box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }

    .input-group:focus-within .input-group-text {
      border-color: #4e73df;
      color: #4e73df;
    }

    .page-title-box {
      background: white;
      border-radius: 0.75rem;
      padding: 1.25rem 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
      border: 1px solid #edf2f7;
    }

    .btn-submit {
      padding: 0.6rem 2rem;
      border-radius: 0.5rem;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 0.5rem;
      font-size: 0.85rem;
    }

    .badge-card-no {
      font-family: 'Nunito', monospace;
      font-size: 0.95rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      color: #2b6cb0;
      background-color: #ebf8ff;
      border: 1px solid #bee3f8;
      border-radius: 0.375rem;
      padding: 0.3rem 0.75rem;
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
            <!-- Alert If Record Not Found -->
            <div class="card shadow mb-4">
              <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-circle fa-4x text-warning mb-3"></i>
                <h4 class="font-weight-bold text-gray-800">ไม่พบข้อมูลบัตรรับรองที่ระบุ</h4>
                <p class="text-muted mb-4">รหัสบัตรรับรองนี้อาจถูกลบไปแล้วหรือไม่ถูกต้อง</p>
                <a href="index.php" class="btn btn-primary px-4 rounded-pill">
                  <i class="fas fa-arrow-left mr-2"></i>กลับหน้ารายการบัตร
                </a>
              </div>
            </div>
          <?php else: 
            $his_id = isset($result["his_id"]) ? $result["his_id"] : '';
            $his_code = isset($result["his_code"]) ? $result["his_code"] : '';
            $his_numcard = isset($result["his_numcard"]) ? $result["his_numcard"] : '';
            $his_datecard = isset($result["his_datecard"]) ? $result["his_datecard"] : '';
            $his_type = isset($result["his_type"]) ? $result["his_type"] : '';
            $his_nameproduct = isset($result["his_nameproduct"]) ? $result["his_nameproduct"] : '';
            $his_province = isset($result["his_province"]) ? $result["his_province"] : '';
            $his_price = isset($result["his_price"]) ? $result["his_price"] : '';
            $his_owner = isset($result["his_owner"]) ? $result["his_owner"] : '';
            $his_tel = isset($result["his_tel"]) ? $result["his_tel"] : '';
            $his_detailproduct = isset($result["his_detailproduct"]) ? $result["his_detailproduct"] : '';
          ?>

            <!-- Page Header & Actions -->
            <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between">
              <div>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" class="text-primary">รายการบัตร</a></li>
                    <li class="breadcrumb-item active" aria-current="page">แก้ไขข้อมูลบัตร</li>
                  </ol>
                </nav>
                <div class="d-flex align-items-center flex-wrap">
                  <h1 class="h3 font-weight-bold text-gray-800 mb-0 mr-3">
                    <i class="fas fa-edit text-primary mr-2"></i>แก้ไขข้อมูลบัตรรับรอง
                  </h1>
                  <span class="badge-card-no mt-2 mt-sm-0">
                    เลขที่: <?php echo htmlspecialchars($his_numcard); ?>
                  </span>
                </div>
              </div>
              <div class="mt-3 mt-md-0 d-flex flex-wrap">
                <!-- ลิงก์ตรงไปจัดการรูปภาพ -->
                <a href="../add_card_image/index.php?his_code=<?php echo urlencode($his_code); ?>" 
                   class="btn btn-info btn-sm px-3 py-2 rounded-pill shadow-sm mr-2 font-weight-bold">
                  <i class="fas fa-images mr-1"></i> จัดการรูปภาพบัตรนี้
                </a>
                <a href="index.php" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill shadow-sm">
                  <i class="fas fa-arrow-left mr-1"></i> ย้อนกลับ
                </a>
              </div>
            </div>

            <!-- Form Card -->
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-edit mr-2"></i>แก้ไขข้อมูลบัตรพระเครื่อง
                </h6>
                <span class="text-muted small">
                  รหัสอ้างอิง: <code class="text-secondary"><?php echo htmlspecialchars($his_code); ?></code>
                </span>
              </div>
              <div class="card-body p-4">
                <form action="editsave.php" name="frmAdd" method="post">   
                  <input type="hidden" name="his_id" value="<?php echo htmlspecialchars($his_id); ?>">     
                  <input type="hidden" name="his_code" value="<?php echo htmlspecialchars($his_code); ?>">                 
                  
                  <!-- หมวดหมู่ที่ 1: ข้อมูลบัตรและพระเครื่อง -->
                  <div class="section-title">
                    <i class="fas fa-certificate"></i> ข้อมูลบัตรและพระเครื่อง
                  </div>

                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <div class="form-group mb-0">
                        <label>เลขที่บัตร: <span class="required">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                          </div>
                          <input type="text" name="his_numcard" class="form-control" placeholder="เลขที่บัตร" value="<?php echo htmlspecialchars($his_numcard); ?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4 mb-3">
                      <div class="form-group mb-0">
                        <label>วันที่ออกบัตร: <span class="required">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" name="his_datecard" class="form-control" value="<?php echo htmlspecialchars($his_datecard); ?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4 mb-3">
                      <div class="form-group mb-0">
                        <label>ประเภทพระเครื่อง: <span class="required">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                          </div>
                          <input type="text" name="his_type" class="form-control" placeholder="ประเภทพระเครื่อง" value="<?php echo htmlspecialchars($his_type); ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 mb-3">
                      <div class="form-group mb-0">
                        <label>ชื่อพระเครื่อง: <span class="required">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-gem"></i></span>
                          </div>
                          <input type="text" name="his_nameproduct" class="form-control" placeholder="ชื่อพระเครื่อง" value="<?php echo htmlspecialchars($his_nameproduct); ?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4 mb-3">
                      <div class="form-group mb-0">
                        <label>จังหวัด:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                          </div>
                          <input type="text" name="his_province" class="form-control" placeholder="จังหวัด" value="<?php echo htmlspecialchars($his_province); ?>">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3 mb-3">
                      <div class="form-group mb-0">
                        <label>ราคาประเมิน (บาท):</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-coins"></i></span>
                          </div>
                          <input type="number" step="any" min="0" name="his_price" class="form-control" placeholder="0.00" value="<?php echo htmlspecialchars($his_price); ?>">
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- หมวดหมู่ที่ 2: ข้อมูลเจ้าของและการติดต่อ -->
                  <div class="section-title mt-4">
                    <i class="fas fa-user-shield"></i> ข้อมูลเจ้าของพระ / ผู้ส่งตรวจ
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <div class="form-group mb-0">
                        <label>ชื่อเจ้าของพระ: <span class="required">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                          </div>
                          <input type="text" name="his_owner" class="form-control" placeholder="ชื่อเจ้าของพระ" value="<?php echo htmlspecialchars($his_owner); ?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <div class="form-group mb-0">
                        <label>เบอร์โทรศัพท์ติดต่อ:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                          </div>
                          <input type="tel" name="his_tel" class="form-control" placeholder="เบอร์โทรศัพท์" value="<?php echo htmlspecialchars($his_tel); ?>">
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- หมวดหมู่ที่ 3: รายละเอียดเพิ่มเติม -->
                  <div class="section-title mt-4">
                    <i class="fas fa-info-circle"></i> รายละเอียดพระเครื่องเพิ่มเติม
                  </div>

                  <div class="row">
                    <div class="col-12 mb-4">
                      <div class="form-group mb-0">
                        <label>รายละเอียด / สภาพพระ / ประวัติ:</label>
                        <textarea rows="5" name="his_detailproduct" class="form-control" placeholder="รายละเอียดเพิ่มเติม"><?php echo htmlspecialchars($his_detailproduct); ?></textarea>
                      </div>
                    </div>
                  </div>

                  <!-- ปุ่มดำเนินการ -->
                  <div class="border-top pt-4 d-flex flex-column flex-sm-row justify-content-end align-items-center">
                    <a href="./index.php" class="btn btn-light btn-submit text-secondary border mr-sm-2 mb-2 mb-sm-0 w-100 w-sm-auto text-center">
                      <i class="fas fa-times mr-2"></i>ยกเลิก
                    </a>
                    <button type="submit" name="insert" value="บันทึก" class="btn btn-primary btn-submit shadow-sm w-100 w-sm-auto">
                      <i class="fas fa-save mr-2"></i>บันทึกการแก้ไข
                    </button>
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
