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
  <meta name="description" content="ระบบจัดการบัตรรับรองพระเครื่อง">
  <title>จัดการบัตรรับรองพระเครื่อง - สถาบันรับรองพระเครื่องเมืองชลฯ</title>

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

    .badge-card-no {
      font-family: 'Nunito', monospace;
      font-size: 0.85rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      color: #2b6cb0;
      background-color: #ebf8ff;
      border: 1px solid #bee3f8;
      border-radius: 0.375rem;
      padding: 0.25rem 0.6rem;
    }

    .badge-category {
      font-size: 0.8rem;
      font-weight: 500;
      background-color: #e2e8f0;
      color: #4a5568;
      border-radius: 20px;
      padding: 0.3rem 0.75rem;
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

    .btn-action i {
      font-size: 0.8rem;
    }

    .btn-action:hover {
      transform: translateY(-1px);
    }

    .page-title-box {
      background: white;
      border-radius: 0.75rem;
      padding: 1.25rem 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
      border: 1px solid #edf2f7;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      border-radius: 0.375rem !important;
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
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include("../../include/menu.php") ?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include("../../include/nav.php") ?>

        <div class="container-fluid py-2">
          <?php
            // Query ข้อมูลประวัติการออกบัตรทั้งหมด
            $sql = $conn->prepare("SELECT a.*, b.member_name 
                                  FROM tb_history a 
                                  LEFT JOIN tb_member b ON b.member_id = a.his_create_by 
                                  ORDER BY a.his_id DESC");
            $sql->execute();
            $query = $sql->fetchAll(PDO::FETCH_ASSOC);
            $totalCards = count($query);

            // ดึงจำนวนประเภททั้งหมดเพื่อแสดงสถิติ
            $typesArray = array();
            foreach ($query as $row) {
                if (!empty($row['his_type'])) {
                    $typesArray[$row['his_type']] = true;
                }
            }
            $totalTypes = count($typesArray);
          ?>

          <!-- Header & Actions -->
          <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div>
              <h1 class="h3 font-weight-bold text-gray-800 mb-1">
                <i class="fas fa-certificate text-primary mr-2"></i>จัดการบัตรรับรองพระเครื่อง
              </h1>
              <p class="text-muted small mb-0">ระบบค้นหา ตรวจสอบ แก้ไข และออกบัตรรับรองพระเครื่อง</p>
            </div>
            <div class="mt-3 mt-md-0">
              <a href="add_card.php" class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill font-weight-bold">
                <i class="fas fa-plus mr-2"></i>เพิ่มบัตรใหม่
              </a>
            </div>
          </div>

          <!-- Overview Stats -->
          <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-3">
              <div class="card stat-card border-left-primary h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">บัตรรับรองทั้งหมด</div>
                      <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalCards); ?> <small class="text-muted text-sm font-weight-normal">ใบ</small></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-id-card fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-3">
              <div class="card stat-card border-left-success h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">หมวดหมู่ / ประเภทพระ</div>
                      <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalTypes); ?> <small class="text-muted text-sm font-weight-normal">ประเภท</small></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-12 mb-3">
              <div class="card stat-card border-left-info h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">สถานะระบบ</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800 text-truncate">
                        <i class="fas fa-check-circle text-success mr-1"></i> ฐานข้อมูลพร้อมใช้งาน
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Table Card -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i>รายการข้อมูลบัตรทั้งหมด
              </h6>
              <span class="badge badge-light border text-muted px-3 py-2">
                ทั้งหมด <?php echo number_format($totalCards); ?> รายการ
              </span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%" class="text-center">#</th>
                      <th width="12%" class="text-center">เลขที่บัตร</th>
                      <th width="12%">ประเภท</th>
                      <th width="23%">ชื่อพระ</th>
                      <th width="11%" class="text-center">วันที่ออกบัตร</th>
                      <th width="13%">เจ้าของพระ</th>
                      <th width="11%">ผู้สร้างบัตร</th>
                      <th width="13%" class="text-center">จัดการ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $i = 1;
                      foreach ($query as $result) { 
                        $his_numcard = isset($result['his_numcard']) ? $result['his_numcard'] : '-';
                        $his_type = isset($result['his_type']) ? $result['his_type'] : '-';
                        $his_nameproduct = isset($result['his_nameproduct']) ? $result['his_nameproduct'] : '-';
                        $his_province = isset($result['his_province']) ? $result['his_province'] : '';
                        $his_datecard = isset($result['his_datecard']) ? $result['his_datecard'] : '-';
                        $his_owner = isset($result['his_owner']) ? $result['his_owner'] : '-';
                        $his_tel = isset($result['his_tel']) ? $result['his_tel'] : '';
                        $member_name = isset($result['member_name']) ? $result['member_name'] : '-';
                        $his_code = isset($result['his_code']) ? $result['his_code'] : '';
                    ?>
                    <tr>
                      <td class="text-center text-muted font-weight-bold"><?php echo $i; ?></td>
                      <td class="text-center">
                        <span class="badge-card-no">
                          <?php echo htmlspecialchars($his_numcard); ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge-category">
                          <?php echo htmlspecialchars($his_type); ?>
                        </span>
                      </td>
                      <td class="font-weight-bold text-dark">
                        <?php echo htmlspecialchars($his_nameproduct); ?>
                        <?php if (!empty($his_province)): ?>
                          <div class="text-muted small mt-1">
                            <i class="fas fa-map-marker-alt text-danger mr-1"></i><?php echo htmlspecialchars($his_province); ?>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <span class="text-muted small">
                          <i class="far fa-calendar-alt mr-1"></i><?php echo htmlspecialchars($his_datecard); ?>
                        </span>
                      </td>
                      <td>
                        <div><?php echo htmlspecialchars($his_owner); ?></div>
                        <?php if (!empty($his_tel)): ?>
                          <div class="text-muted small">
                            <i class="fas fa-phone-alt mr-1"></i><?php echo htmlspecialchars($his_tel); ?>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="text-muted small">
                          <i class="fas fa-user-edit mr-1"></i><?php echo htmlspecialchars($member_name); ?>
                        </span>
                      </td>
                      <td class="text-center text-nowrap">
                        <!-- รูปภาพ -->
                        <a href="../add_card_image/index.php?his_code=<?php echo urlencode($his_code); ?>" 
                           class="btn btn-action btn-outline-info" 
                           title="จัดการรูปภาพ">
                          <i class="fas fa-images mr-1"></i>รูป
                        </a>
                        <!-- แก้ไข -->
                        <a href="edit_card.php?his_code=<?php echo urlencode($his_code); ?>" 
                           class="btn btn-action btn-outline-primary" 
                           title="แก้ไขข้อมูล">
                          <i class="fas fa-edit mr-1"></i>แก้ไข
                        </a>
                        <!-- ลบ -->
                        <a href="delete.php?his_code=<?php echo urlencode($his_code); ?>" 
                           onclick="return confirm('คุณต้องการลบข้อมูลบัตรเลขที่ <?php echo htmlspecialchars($his_numcard); ?> หรือไม่?');" 
                           class="btn btn-action btn-outline-danger" 
                           title="ลบข้อมูล">
                          <i class="fas fa-trash-alt"></i>
                        </a>
                      </td>
                    </tr>
                    <?php 
                      ++$i; 
                      } 
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
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
      $('#dataTable').DataTable({
        "order": [], // ให้เรียงตาม SQL DESC ล่าสุดขึ้นก่อน
        "language": {
          "search": "<i class='fas fa-search text-gray-400 mr-2'></i>ค้นหา:",
          "searchPlaceholder": "พิมพ์คำค้นหา...",
          "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
          "zeroRecords": "ไม่พบข้อมูลที่ตรงกับการค้นหา",
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
  </script>

</body>

</html>
