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
  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
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
  <!-- Page Wrapper -->
  <div id="wrapper">

  <?php include("../../include/menu.php")?>


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      <?php include("../../include/nav.php")?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- หัวข้อ -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">สิทธิ์การเข้าถึง</h1>
          </div>

          <!-- Content Row -->
          <div class="content">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">แก้ไขข้อมูลผู้ใช้ในระบบ</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <?php
                     $strmember_id = null;
                     if (isset($_GET["member_id"])) {
                         $strmember_id = $_GET["member_id"];
                     }
                     
                     $sql = $conn->prepare("SELECT * FROM tb_member WHERE member_id = ?");
                     $sql->execute([$strmember_id]);
                     $result = $sql->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <form action="editsave.php" name="frmAdd" method="post">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><center>ชื่อผู้ใช้</center></th>
                      <th><center>รหัสผ่าน</center></th>
                      <th><center>ชื่อ-นามสกุล</center></th>
                      <th><center>เบอร์โทร</center></th>
                      <th><center>สถานะ</center></th>
                      <th></th>
                    </tr>
                  </thead>
              <tr>
                <input type="hidden" class="form-control" name="member_id" value="<?php echo $result["member_id"];?>">
                <td><input type="text" class="form-control" name="member_user" value="<?php echo $result["member_user"];?>"></td>
                <td><input type="text" class="form-control" name="member_pass" value="<?php echo $result["member_pass"];?>"></td>
                <td><input type="text" class="form-control" name="member_name" value="<?php echo $result["member_name"];?>"></td>
                <td><input type="text" class="form-control" name="member_tel" value="<?php echo $result["member_tel"];?>"></td>
                <td>
                  <select name="status" id="status" class="form-control">
                    <option value="1" <?php if($result["status"]=='1'){echo "selected";};?>>ADMIN</option>
                    <option value="2" <?php if($result["status"]=='2'){echo "selected";};?>>MEMBER</option>
                  </select>
                </td>
                <td><center>
                  <button type="submit" class="btn btn-success" name="button"><i class="fa fa-check"> บันทึก</i></button>
                  </center>
                </td>
              </tr>
            </table>
          </form>
          </div>
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
