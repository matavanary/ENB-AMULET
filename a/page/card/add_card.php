<?php 
include("../../../config/dbConnection.php");
include("../../session.php");
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="เพิ่มบัตรรับรองพระเครื่องใหม่">
  <title>เพิ่มบัตรใหม่ - สถาบันรับรองพระเครื่องเมืองชลฯ</title>

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

          <!-- Page Header & Breadcrumbs -->
          <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php" class="text-primary">รายการบัตร</a></li>
                  <li class="breadcrumb-item active" aria-current="page">เพิ่มบัตรใหม่</li>
                </ol>
              </nav>
              <h1 class="h3 font-weight-bold text-gray-800 mb-0">
                <i class="fas fa-plus-circle text-primary mr-2"></i>เพิ่มข้อมูลบัตรรับรองพระเครื่อง
              </h1>
            </div>
            <div class="mt-3 mt-md-0">
              <a href="index.php" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> ย้อนกลับไปหน้ารายการ
              </a>
            </div>
          </div>

          <!-- Form Card -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center">
              <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-signature mr-2"></i>กรอกข้อมูลบัตรรับรอง
              </h6>
            </div>
            <div class="card-body p-4">
              <form action="insertsave.php" name="frmAdd" method="post" id="cardForm">
                
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
                        <input type="text" name="his_numcard" class="form-control" placeholder="เช่น CN-00123" required>
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
                        <input type="date" name="his_datecard" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
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
                        <input type="text" name="his_type" class="form-control" placeholder="เช่น พระสมเด็จ, เหรียญคณาจารย์" required>
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
                        <input type="text" name="his_nameproduct" class="form-control" placeholder="เช่น พระสมเด็จวัดระฆัง พิมพ์ใหญ่" required>
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
                        <input type="text" name="his_province" class="form-control" placeholder="เช่น กรุงเทพมหานคร, ชลบุรี">
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
                        <input type="number" step="any" min="0" name="his_price" class="form-control" placeholder="0.00">
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
                        <input type="text" name="his_owner" class="form-control" placeholder="ชื่อ-นามสกุล เจ้าของพระ" required>
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
                        <input type="tel" name="his_tel" class="form-control" placeholder="เช่น 0812345678">
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
                      <textarea rows="5" name="his_detailproduct" class="form-control" placeholder="ระบุรายละเอียดเพิ่มเติมเกี่ยวกับองค์พระ สภาพพิมพ์ ทรง เนื้อหา หรือตำหนิ..."></textarea>
                    </div>
                  </div>
                </div>

                <!-- ปุ่มดำเนินการ -->
                <div class="border-top pt-4 d-flex flex-column flex-sm-row justify-content-end align-items-center">
                  <a href="./index.php" class="btn btn-light btn-submit text-secondary border mr-sm-2 mb-2 mb-sm-0 w-100 w-sm-auto text-center">
                    <i class="fas fa-times mr-2"></i>ยกเลิก
                  </a>
                  <button type="submit" name="insert" value="บันทึก" class="btn btn-primary btn-submit shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-save mr-2"></i>บันทึกและจัดการรูปภาพ
                  </button>
                </div>

              </form>
            </div>
          </div>

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
