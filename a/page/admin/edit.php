<?php 
include("../../../config/dbConnection.php");
include("../../session.php");

// ตรวจสอบสิทธิ์เฉพาะผู้ดูแลระบบ (status = 1)
if (!isset($_SESSION["status"]) || strval($_SESSION["status"]) !== '1') {
    echo "<script type='text/javascript'>";
    echo "alert('คุณไม่มีสิทธิ์ในการเข้าถึงส่วนนี้ เฉพาะผู้ดูแลระบบเท่านั้น');";
    echo "window.location = '../card/';";
    echo "</script>";
    exit();
}

$strmember_id = isset($_GET["member_id"]) ? intval($_GET["member_id"]) : 0;
$result = null;

if ($strmember_id > 0) {
    $sql = $conn->prepare("SELECT * FROM tb_member WHERE member_id = ?");
    $sql->execute([$strmember_id]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="แก้ไขข้อมูลผู้ใช้งานระบบ">
  <title>แก้ไขข้อมูลผู้ใช้ - สถาบันรับรองพระเครื่องเมืองชลฯ</title>

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

    .form-group label {
      font-weight: 500;
      font-size: 0.875rem;
      color: #4a5568;
      margin-bottom: 0.4rem;
    }

    .input-group-text {
      background-color: #f8fafc;
      border-color: #d1d5db;
      color: #6b7280;
    }

    .form-control:focus {
      border-color: #4e73df;
      box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .profile-badge-box {
      background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
      border-radius: 0.75rem;
      padding: 1.5rem;
      color: #ffffff;
      box-shadow: 0 4px 15px rgba(78, 115, 223, 0.25);
    }

    .profile-avatar-large {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      border: 2px solid rgba(255, 255, 255, 0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.75rem;
      font-weight: 700;
      color: #ffffff;
      margin-right: 1.25rem;
      flex-shrink: 0;
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
          
          <!-- Page Header Banner -->
          <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div class="mb-3 mb-md-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1" style="font-size: 0.85rem;">
                  <li class="breadcrumb-item"><a href="../card/"><i class="fas fa-home mr-1"></i>หน้าหลัก</a></li>
                  <li class="breadcrumb-item"><a href="./">สิทธิ์การเข้าถึง</a></li>
                  <li class="breadcrumb-item active" aria-current="page">แก้ไขข้อมูลผู้ใช้</li>
                </ol>
              </nav>
              <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                <i class="fas fa-user-edit text-primary mr-2"></i>แก้ไขข้อมูลผู้ใช้งาน
              </h1>
              <small class="text-muted">ปรับปรุงข้อมูลบัญชีผู้ใช้งานและกำหนดระดับสิทธิ์</small>
            </div>
            <div>
              <a href="./" class="btn btn-outline-secondary shadow-sm px-3 py-2">
                <i class="fas fa-arrow-left mr-1"></i> ย้อนกลับไปหน้ารายการ
              </a>
            </div>
          </div>

          <?php if (!$result) { ?>
            <!-- Alert กรณีไม่พบข้อมูล -->
            <div class="card shadow mb-4 border-left-danger">
              <div class="card-body p-5 text-center">
                <div class="mb-3">
                  <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                </div>
                <h4 class="font-weight-bold text-gray-800">ไม่พบข้อมูลผู้ใช้งานที่ระบุ</h4>
                <p class="text-muted mb-4">รหัสผู้ใช้งานนี้อาจถูกลบไปแล้วหรือไม่ถูกต้อง กรุณากลับไปตรวจสอบหน้ารายการสมาชิก</p>
                <a href="./" class="btn btn-primary px-4 shadow-sm">
                  <i class="fas fa-arrow-left mr-1"></i> กลับไปหน้ารายการผู้ใช้งาน
                </a>
              </div>
            </div>
          <?php } else { 
            $firstChar = mb_substr($result['member_name'] ?: $result['member_user'], 0, 1, 'UTF-8');
            $isAdmin = (strval($result['status']) === '1');
            $isSelf = ($result['member_id'] == $_SESSION['member_id']);
          ?>

            <!-- User Quick Info Header -->
            <div class="profile-badge-box mb-4">
              <div class="d-flex flex-column flex-sm-row align-items-center">
                <div class="profile-avatar-large mb-3 mb-sm-0">
                  <?php echo htmlspecialchars($firstChar, ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div class="text-center text-sm-left flex-grow-1">
                  <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start">
                    <h4 class="mb-1 font-weight-bold text-white mr-2">
                      <?php echo htmlspecialchars($result['member_name'] ?: $result['member_user'], ENT_QUOTES, 'UTF-8'); ?>
                    </h4>
                    <?php if ($isAdmin) { ?>
                      <span class="badge badge-warning text-dark font-weight-bold px-2 py-1 mb-1">
                        <i class="fas fa-user-shield mr-1"></i> ผู้ดูแลระบบ (ADMIN)
                      </span>
                    <?php } else { ?>
                      <span class="badge badge-light text-primary font-weight-bold px-2 py-1 mb-1">
                        <i class="fas fa-user mr-1"></i> เจ้าหน้าที่ทั่วไป (MEMBER)
                      </span>
                    <?php } ?>
                    <?php if ($isSelf) { ?>
                      <span class="badge badge-info ml-1 mb-1">(บัญชีของคุณ)</span>
                    <?php } ?>
                  </div>
                  <div class="text-white-50" style="font-size: 0.9rem;">
                    <span><i class="fas fa-id-badge mr-1"></i>รหัสสมาชิก: #<?php echo $result['member_id']; ?></span>
                    <span class="mx-2">•</span>
                    <span><i class="fas fa-user mr-1"></i>ชื่อผู้ใช้: <strong><?php echo htmlspecialchars($result['member_user'], ENT_QUOTES, 'UTF-8'); ?></strong></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Card -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-sliders-h mr-1"></i> กรอกข้อมูลที่ต้องการปรับปรุง
                </h6>
              </div>
              <div class="card-body p-4">
                <form action="editsave.php" method="POST" autocomplete="off">
                  <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($result["member_id"], ENT_QUOTES, 'UTF-8'); ?>">

                  <div class="row">
                    <!-- Username -->
                    <div class="col-md-6 form-group">
                      <label for="member_user"><i class="fas fa-user text-primary mr-1"></i> ชื่อผู้ใช้งาน (Username) <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="text" 
                               name="member_user" 
                               id="member_user" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($result["member_user"], ENT_QUOTES, 'UTF-8'); ?>" 
                               required>
                      </div>
                      <small class="form-text text-muted">ใช้สำหรับเข้าสู่ระบบ</small>
                    </div>

                    <!-- Role Status -->
                    <div class="col-md-6 form-group">
                      <label for="status"><i class="fas fa-user-shield text-primary mr-1"></i> ระดับสิทธิ์การเข้าถึง <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        </div>
                        <select name="status" id="status" class="form-control" required <?php if ($isSelf) { echo 'title="คุณไม่สามารถลดสิทธิ์บัญชีตนเองได้"'; } ?>>
                          <option value="1" <?php if (strval($result["status"]) === '1') echo "selected"; ?>>
                            ผู้ดูแลระบบ (ADMIN) - เข้าถึงได้ทุกฟังก์ชัน
                          </option>
                          <option value="2" <?php if (strval($result["status"]) === '2') echo "selected"; ?>>
                            เจ้าหน้าที่ทั่วไป (MEMBER) - ออกบัตรและแก้ไขบัตร
                          </option>
                        </select>
                      </div>
                      <small class="form-text text-muted">กำหนดสิทธิ์การจัดการระบบให้กับผู้ใช้นี้</small>
                    </div>

                    <!-- Full Name -->
                    <div class="col-md-6 form-group">
                      <label for="member_name"><i class="fas fa-id-card text-primary mr-1"></i> ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" 
                               name="member_name" 
                               id="member_name" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($result["member_name"], ENT_QUOTES, 'UTF-8'); ?>" 
                               required>
                      </div>
                      <small class="form-text text-muted">ชื่อแสดงในระบบและประวัติการออกบัตร</small>
                    </div>

                    <!-- Telephone -->
                    <div class="col-md-6 form-group">
                      <label for="member_tel"><i class="fas fa-phone text-primary mr-1"></i> เบอร์โทรศัพท์</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        <input type="text" 
                               name="member_tel" 
                               id="member_tel" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($result["member_tel"], ENT_QUOTES, 'UTF-8'); ?>">
                      </div>
                      <small class="form-text text-muted">เบอร์โทรศัพท์สำหรับติดต่อ</small>
                    </div>

                    <!-- New Password -->
                    <div class="col-md-12 form-group">
                      <label for="member_pass">
                        <i class="fas fa-lock text-primary mr-1"></i> รหัสผ่านใหม่ 
                        <span class="badge badge-light border text-muted ml-1">เว้นว่างไว้หากไม่ต้องการเปลี่ยน</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" 
                               name="member_pass" 
                               id="member_pass" 
                               class="form-control" 
                               placeholder="กรอกรหัสผ่านใหม่ที่นี่ (เว้นว่างไว้เพื่อคงรหัสผ่านเดิม)">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" onclick="togglePassVisibility('member_pass', this)">
                            <i class="fas fa-eye"></i>
                          </button>
                        </div>
                      </div>
                      <small class="form-text text-muted">หากกรอกรหัสผ่านใหม่ ระบบจะทำการเข้ารหัสความปลอดภัยด้วย bcrypt ให้โดยอัตโนมัติ</small>
                    </div>
                  </div>

                  <hr class="my-4">

                  <!-- Form Action Buttons -->
                  <div class="d-flex align-items-center justify-content-end">
                    <a href="./" class="btn btn-light border text-secondary shadow-sm mr-2 px-4 py-2">
                      <i class="fas fa-times mr-1"></i> ยกเลิก
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm px-4 py-2 font-weight-bold">
                      <i class="fas fa-save mr-1"></i> บันทึกการเปลี่ยนแปลง
                    </button>
                  </div>

                </form>
              </div>
            </div>

          <?php } ?>

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

  <script>
    function togglePassVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
