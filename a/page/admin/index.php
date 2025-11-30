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
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
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
                <h6 class="m-0 font-weight-bold text-primary">ตารางแสดงข้อมูลผู้ใช้ในระบบ</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <?php
                  $sql = $conn->prepare("SELECT * FROM tb_member");
                  $sql->execute();
                  $query = $sql->fetchAll();
                ?>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th><center>ลำดับ</center></th>
                        <th><center>ชื่อผู้ใช้</center></th>
                        <th><center>รหัสผ่าน</center></th>
                        <th><center>ชื่อ-นามสกุล</center></th>
                        <th><center>เบอร์โทร</center></th>
                        <th><center>สถานะ</center></th>
                        <th></th>
                      </tr>
                    </thead>
                    <?php foreach($query as $result) { ?>
                    <tr>
                      <td><center><?php echo $result['member_id']; ?></center></td>
                      <td><?php echo $result['member_user']; ?></td>
                      <td><?php echo $result['member_pass']; ?></td>
                      <td><?php echo $result['member_name']; ?></td>
                      <td><?php echo $result['member_tel']; ?></td>
                      <td><?php if($result['status']=='1'){echo "ADMIN";}else{echo "MEMBER";} ?></td>
                      <td>
                        <center>
                          <a href="edit.php?member_id=<?php echo $result["member_id"]; ?>">
                            <font color="blue"> <i class="fa fa-edit"> แก้ไข</i></font>
                          </a>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          
                          <a href="delete.php?member_id=<?php echo $result['member_id']; ?>" onclick="return confirm('คุณต้องการลบข้อมูลที่เลือกหรือไม่')">
                            <font color="red"> <i class="fa fa-trash"> ลบ</i> </font></a>
                        </center>
                      </td>
                    </tr>
                    <?php } ?>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-4 right">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#defaultModal" >
                <i class="fa fa-user-plus"> เพิ่มสมาชิก</i></button>
            </div>
            <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">เพิ่มสมาชิก</h4>
                    <hr>
                  </div>
                  <form action="insertsave.php" method="POST">
                    <div class="modal-body">
                      <div class="form-group">
                        <div class="form-line">
                          <input type="text" name="member_user" placeholder="Username" class="form-control" required="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="form-line">
                          <input type="text" name="member_pass" placeholder="Password" class="form-control" required="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="form-line">
                          <input type="text" name="member_name" placeholder="ชื่อ" class="form-control" required="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="form-line">
                          <input type="text" name="member_tel" placeholder="เบอร์โทร" class="form-control" required="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="form-line">
                          <select name="status" id="status" class="form-control">
                            <option value="1">ADMIN</option>
                            <option value="2">MEMBER</option>
                          </select>
                        </div>
                      </div><br>
                      <div class="col-md-20">
                        <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#defaultModal">
                          <i class="fa fa-plus"> เพิ่ม</i></button>
                      </div>
                    </div>
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