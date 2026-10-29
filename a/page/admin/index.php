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

// ดึงข้อมูลสมาชิกทั้งหมด
$sql = $conn->prepare("SELECT * FROM tb_member ORDER BY member_id ASC");
$sql->execute();
$members = $sql->fetchAll(PDO::FETCH_ASSOC);

// สถิติผู้ใช้งาน
$totalUsers = count($members);
$totalAdmins = 0;
$totalStaff = 0;
foreach ($members as $m) {
    if (strval($m['status']) === '1') {
        $totalAdmins++;
    } else {
        $totalStaff++;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="ระบบจัดการผู้ใช้งานและสิทธิ์การเข้าถึง">
  <title>จัดการสิทธิ์การเข้าถึง - สถาบันรับรองพระเครื่องเมืองชลฯ</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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

    .stat-card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      border-left: 4px solid;
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.12) !important;
    }

    .table thead th {
      background-color: #f8fafc;
      color: #4a5568;
      font-weight: 600;
      border-top: none;
      border-bottom: 2px solid #e2e8f0;
      vertical-align: middle;
      font-size: 0.9rem;
      white-space: nowrap;
    }

    .table tbody td {
      vertical-align: middle;
      color: #4a5568;
      font-size: 0.9rem;
      border-top: 1px solid #edf2f7;
    }

    .table-hover tbody tr:hover {
      background-color: #f8fbff;
    }

    .page-title-box {
      background: white;
      border-radius: 0.75rem;
      padding: 1.25rem 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
      border: 1px solid #edf2f7;
    }

    .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.9rem;
      color: #ffffff;
      flex-shrink: 0;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.35rem 0.65rem;
      font-size: 0.8rem;
      font-weight: 500;
      border-radius: 0.5rem;
      transition: all 0.15s ease-in-out;
      margin: 2px;
    }

    .btn-action:hover {
      transform: translateY(-1px);
    }

    .dataTables_wrapper .dataTables_filter input {
      border-radius: 0.5rem;
      border: 1px solid #cbd5e0;
      padding: 0.375rem 0.75rem;
      outline: none;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
      border-color: #4e73df;
      box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .modal-content {
      border-radius: 1rem;
      border: none;
      box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
    }

    .modal-header {
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      border-bottom: 1px solid #edf2f7;
    }

    .form-group label {
      font-weight: 500;
      font-size: 0.875rem;
      color: #4a5568;
      margin-bottom: 0.35rem;
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
                  <li class="breadcrumb-item active" aria-current="page">สิทธิ์การเข้าถึง</li>
                </ol>
              </nav>
              <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                <i class="fas fa-users-cog text-primary mr-2"></i>จัดการผู้ใช้งานและสิทธิ์การเข้าถึง
              </h1>
              <small class="text-muted">กำหนดสิทธิ์และดูแลบัญชีผู้ใช้งานระบบทั้งหมด</small>
            </div>
            <div>
              <button type="button" class="btn btn-primary shadow-sm px-3 py-2" data-toggle="modal" data-target="#modalAddMember">
                <i class="fas fa-user-plus mr-1"></i> เพิ่มผู้ใช้งานใหม่
              </button>
            </div>
          </div>

          <!-- Summary Stats Row -->
          <div class="row mb-4">
            <!-- Total Users -->
            <div class="col-xl-4 col-md-6 mb-3">
              <div class="card stat-card shadow h-100 py-2" style="border-left-color: #4e73df;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        ผู้ใช้งานทั้งหมดในระบบ
                      </div>
                      <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalUsers); ?> บัญชี</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Admin Users -->
            <div class="col-xl-4 col-md-6 mb-3">
              <div class="card stat-card shadow h-100 py-2" style="border-left-color: #f6c23e;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        ผู้ดูแลระบบ (ADMIN)
                      </div>
                      <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalAdmins); ?> บัญชี</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Regular Staff -->
            <div class="col-xl-4 col-md-6 mb-3">
              <div class="card stat-card shadow h-100 py-2" style="border-left-color: #1cc88a;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        เจ้าหน้าที่ทั่วไป (MEMBER)
                      </div>
                      <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalStaff); ?> บัญชี</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Members Table Card -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-1"></i> รายชื่อผู้ใช้งานในระบบ
              </h6>
              <span class="badge badge-light border text-muted px-2 py-1">
                ทั้งหมด <?php echo $totalUsers; ?> รายการ
              </span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="text-center" width="70">ลำดับ</th>
                      <th>ชื่อผู้ใช้งาน</th>
                      <th>ชื่อ-นามสกุล</th>
                      <th>เบอร์โทรศัพท์</th>
                      <th class="text-center">ความปลอดภัย</th>
                      <th class="text-center">สิทธิ์การใช้งาน</th>
                      <th class="text-center" width="150">จัดการ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $order = 1;
                    $avatarColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1'];
                    
                    foreach ($members as $result) { 
                      $isSelf = ($result['member_id'] == $_SESSION['member_id']);
                      $colorIndex = $result['member_id'] % count($avatarColors);
                      $avatarBg = $avatarColors[$colorIndex];
                      
                      // First letter for avatar
                      $firstChar = mb_substr($result['member_name'] ?: $result['member_user'], 0, 1, 'UTF-8');
                      $pwd_info = password_get_info($result['member_pass']);
                      $isHashed = ($pwd_info['algo'] !== 0);
                    ?>
                    <tr>
                      <td class="text-center font-weight-bold text-muted"><?php echo $order++; ?></td>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="user-avatar mr-2" style="background-color: <?php echo $avatarBg; ?>;">
                            <?php echo htmlspecialchars($firstChar, ENT_QUOTES, 'UTF-8'); ?>
                          </div>
                          <div>
                            <span class="font-weight-bold text-dark"><?php echo htmlspecialchars($result['member_user'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php if ($isSelf) { ?>
                              <span class="badge badge-primary ml-1" style="font-size: 0.7rem;">(คุณ)</span>
                            <?php } ?>
                          </div>
                        </div>
                      </td>
                      <td class="font-weight-500"><?php echo htmlspecialchars($result['member_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td>
                        <?php if (!empty($result['member_tel'])) { ?>
                          <a href="tel:<?php echo htmlspecialchars($result['member_tel'], ENT_QUOTES, 'UTF-8'); ?>" class="text-secondary">
                            <i class="fas fa-phone-alt text-muted mr-1" style="font-size: 0.75rem;"></i><?php echo htmlspecialchars($result['member_tel'], ENT_QUOTES, 'UTF-8'); ?>
                          </a>
                        <?php } else { ?>
                          <span class="text-muted">-</span>
                        <?php } ?>
                      </td>
                      <td class="text-center">
                        <?php if ($isHashed) { ?>
                          <span class="badge badge-success px-2 py-1" data-toggle="tooltip" title="รหัสผ่านเข้ารหัสด้วยมาตรฐานความปลอดภัยสูง (bcrypt)">
                            <i class="fas fa-lock mr-1"></i> เข้ารหัสแล้ว
                          </span>
                        <?php } else { ?>
                          <span class="badge badge-warning px-2 py-1 text-dark" data-toggle="tooltip" title="จะเข้ารหัสอัตโนมัติเมื่อเข้าสู่ระบบครั้งถัดไป">
                            <i class="fas fa-unlock mr-1"></i> ข้อความเดิม
                          </span>
                        <?php } ?>
                      </td>
                      <td class="text-center">
                        <?php if (strval($result['status']) === '1') { ?>
                          <span class="badge badge-pill badge-primary px-2 py-1 shadow-sm font-weight-500">
                            <i class="fas fa-user-shield mr-1"></i> ADMIN
                          </span>
                        <?php } else { ?>
                          <span class="badge badge-pill badge-light border text-secondary px-2 py-1 font-weight-500">
                            <i class="fas fa-user mr-1"></i> MEMBER
                          </span>
                        <?php } ?>
                      </td>
                      <td class="text-center">
                        <div class="d-inline-flex">
                          <a href="edit.php?member_id=<?php echo $result["member_id"]; ?>" 
                             class="btn btn-action btn-outline-primary shadow-sm" 
                             data-toggle="tooltip" 
                             title="แก้ไขข้อมูลผู้ใช้">
                            <i class="fas fa-edit mr-1"></i> แก้ไข
                          </a>

                          <?php if (!$isSelf) { ?>
                            <a href="delete.php?member_id=<?php echo $result['member_id']; ?>" 
                               class="btn btn-action btn-outline-danger shadow-sm" 
                               data-toggle="tooltip" 
                               title="ลบผู้ใช้งาน" 
                               onclick="return confirm('ยืนยันการลบผู้ใช้ [ <?php echo htmlspecialchars($result['member_user'], ENT_QUOTES, 'UTF-8'); ?> ] หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้');">
                              <i class="fas fa-trash-alt mr-1"></i> ลบ
                            </a>
                          <?php } else { ?>
                            <button type="button" 
                                    class="btn btn-action btn-light text-muted border shadow-sm" 
                                    data-toggle="tooltip" 
                                    title="ไม่สามารถลบบัญชีที่กำลังใช้งานอยู่ได้" 
                                    disabled>
                              <i class="fas fa-trash-alt mr-1"></i> ลบ
                            </button>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Modal เพิ่มสมาชิก -->
  <div class="modal fade" id="modalAddMember" tabindex="-1" role="dialog" aria-labelledby="modalAddMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title font-weight-bold" id="modalAddMemberLabel">
            <i class="fas fa-user-plus mr-2"></i>เพิ่มผู้ใช้งานใหม่
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="insertsave.php" method="POST" autocomplete="off">
          <div class="modal-body p-4">
            
            <div class="form-group">
              <label for="add_member_user"><i class="fas fa-user text-primary mr-1"></i> ชื่อผู้ใช้ (Username) <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-at"></i></span>
                </div>
                <input type="text" name="member_user" id="add_member_user" placeholder="เช่น somchai, admin2" class="form-control" required>
              </div>
            </div>

            <div class="form-group">
              <label for="add_member_pass"><i class="fas fa-lock text-primary mr-1"></i> รหัสผ่าน (Password) <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="member_pass" id="add_member_pass" placeholder="กำหนดรหัสผ่านความปลอดภัย" class="form-control" required>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePassVisibility('add_member_pass', this)">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="add_member_name"><i class="fas fa-id-card text-primary mr-1"></i> ชื่อ-นามสกุล <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                </div>
                <input type="text" name="member_name" id="add_member_name" placeholder="เช่น นายสมชาย ใจดี" class="form-control" required>
              </div>
            </div>

            <div class="form-group">
              <label for="add_member_tel"><i class="fas fa-phone text-primary mr-1"></i> เบอร์โทรศัพท์</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                </div>
                <input type="text" name="member_tel" id="add_member_tel" placeholder="เช่น 081-234-5678" class="form-control">
              </div>
            </div>

            <div class="form-group mb-0">
              <label for="add_status"><i class="fas fa-user-shield text-primary mr-1"></i> สิทธิ์การใช้งานระบบ <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                </div>
                <select name="status" id="add_status" class="form-control" required>
                  <option value="2" selected>เจ้าหน้าที่ทั่วไป (MEMBER)</option>
                  <option value="1">ผู้ดูแลระบบ (ADMIN)</option>
                </select>
              </div>
            </div>

          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">
              <i class="fas fa-times mr-1"></i> ยกเลิก
            </button>
            <button type="submit" class="btn btn-primary shadow-sm px-4">
              <i class="fas fa-check mr-1"></i> บันทึกข้อมูล
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

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

  <!-- Page level plugins -->
  <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
      // Tooltip initialization
      $('[data-toggle="tooltip"]').tooltip();

      // DataTable localization
      $('#dataTable').DataTable({
        "order": [[0, 'asc']],
        "language": {
          "search": "<i class='fas fa-search text-gray-400 mr-2'></i>ค้นหา:",
          "searchPlaceholder": "ค้นหาชื่อ, ผู้ใช้, เบอร์โทร...",
          "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
          "zeroRecords": "ไม่พบข้อมูลผู้ใช้งานที่ตรงกับการค้นหา",
          "info": "แสดงรายการที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
          "infoEmpty": "ไม่มีรายการข้อมูล",
          "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
          "paginate": {
            "first": "หน้าแรก",
            "last": "หน้าสุดท้าย",
            "next": "ถัดไป",
            "previous": "ก่อนหน้า"
          }
        }
      });
    });

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
