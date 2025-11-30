<?php include("../../../config/dbConnection.php") ?>
<?php include("../../session.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }
    .topnav {
      overflow: hidden;
      background-color: #333;
    }
    .topnav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 30px;
    }
    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }
    .topnav a.active {
      background-color: #FF0000;
      color: white;
    }
    .topnav-right {
      float: right;
    }
    </style>
</head>
<body id="page-top">
  <div id="wrapper">
  <?php include("../../include/menu.php")?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include("../../include/nav.php")?>
        <!-- <div class="topnav">
          <a class="active" href="">หน้าหลัก</a>
          <a href="th-ex">แกลเลอรี่</a>
        </div> -->
        <div class="container-fluid">
          <!-- <br> -->
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">หน้าหลัก</h1>
          </div> -->
          <div class="col-md-2 right" >
          <a href="add_card.php" class="btn btn-primary" >
                        <font color="white"> <i class="fa fa-plus"> เพิ่มบัตรใหม่</i></font></a>
          </div>
          <br>
          <div class="content">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ข้อมูล</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <?php
                  $sql = $conn->prepare("SELECT * FROM tb_history a LEFT JOIN tb_member b ON b.member_id = a.his_create_by");
                  $sql->execute();
                  $query = $sql->fetchAll();
                  $i=1;
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%"><center>ลำดับ</center></th>
                      <th width="10%"><center>เลขที่บัตร</center></th>
                      <th width="10%"><center>ประเภท</center></th>
                      <th width="25%"><center>ชื่อพระ</center></th>
                      <th width="10%"><center>วันที่ออกบัตร</center></th>
                      <th width="15%"><center>เจ้าของพระ</center></th>
                      <th width="15%"><center>ผู้สร้างบัตร</center></th>
                      <th width="10%"><center>จัดการ</center></th>
                    </tr>
                  </thead>
                  <?php foreach($query as $result) { ?>
                  <tr>
                    <td><center><?php echo $i; ?></center></td>
                    <td><center><?php echo $result['his_numcard']; ?></center></td>
                    <td><?php echo $result['his_type']; ?></td>
                    <td><?php echo $result['his_nameproduct']; ?></td>
                    <td><center><?php echo $result['his_datecard']; ?></center></td>
                    <td><?php echo $result['his_owner']; ?></td>
                    <td><?php echo $result['member_name']; ?></td>
                    <td><center>
                      <a href="edit_card.php?his_code=<?php echo $result["his_code"]; ?>">
                        <font color="blue"> <i class="fa fa-edit"> แก้ไข</i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="delete.php?his_code=<?php echo $result["his_code"]; ?>" onclick="return confirm('คุณต้องการลบข้อมูลที่เลือกหรือไม่')">
                        <font color="red"> <i class="fa fa-trash"> ลบ</i></font></a>
                      </center>
                    </td>
                  </tr>
              <?php
                ++$i;  }
              ?>
              </table>
                </div>
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
  <script src="../../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../../js/demo/chart-area-demo.js"></script>
  <script src="../../js/demo/chart-pie-demo.js"></script>

  <!-- Page level plugins -->
  <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../../js/demo/datatables-demo.js"></script>

</body>

</html>
