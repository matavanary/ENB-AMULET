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
        <!-- <div class="topnav">
          <a class="active" href="">หน้าหลัก</a>
          <a href="th-ex">แกลเลอรี่</a>
        </div> -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- <br> -->
          <!-- หัวข้อ -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">แก้ไขการ์ด</h1>
          </div>

          <!-- Content Row -->
          <div class="content">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">แก้ไขการ์ด</h6>
              </div>
              <?php
                  $strhis_code = null;
                  if(isset($_GET["his_code"]))
                  {
                    $strhis_code = $_GET["his_code"];
                  }                  
                  $sql = $conn->prepare("SELECT * FROM tb_history WHERE his_code = ?");
                  $sql->execute([$strhis_code]);
                  $result = $sql->fetch(PDO::FETCH_ASSOC);
              ?>
              <div class="card-body">
                <div class="table-responsive">
                  <form action="editsave.php" name="frmAdd" method="post">   
                    <input type="hidden" class="form-control" name="his_id" value="<?php echo $result["his_id"];?>">     
                    <input type="hidden" class="form-control" name="his_code" value="<?php echo $result["his_code"];?>">                 
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>ประเภท:</label>
                            <input type="text" name="his_type" class="form-control" placeholder="ประเภท:" value="<?php echo $result["his_type"];?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>ชื่อพระ:</label>
                            <input type="text" name="his_nameproduct" class="form-control" placeholder="ชื่อพระ:" value="<?php echo $result["his_nameproduct"];?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>จังหวัด:</label>
                            <input type="text" name="his_province" class="form-control" placeholder="จังหวัด:" value="<?php echo $result["his_province"];?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>เจ้าของพระ:</label>
                            <input type="text" name="his_owner" class="form-control" placeholder="เจ้าของพระ:" value="<?php echo $result["his_owner"];?>">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>ราคาประเมิน:</label>
                            <input type="number" name="his_price" class="form-control" placeholder="ราคาประเมิน:" value="<?php echo $result["his_price"];?>">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>วันที่ออกบัตร:</label>
                            <input type="date" name="his_datecard" class="form-control" placeholder="วันที่ออกบัตร:" value="<?php echo $result["his_datecard"];?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>เบอร์โทรศัพท์:</label>
                            <input type="number" name="his_tel" class="form-control" placeholder="เบอร์โทรศัพท์:" value="<?php echo $result["his_tel"];?>">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>เลขทีบัตร:</label>                   
                            <input type="text" name="his_numcard" class="form-control" placeholder="เลขทีบัตร:" value="<?php echo $result["his_numcard"];?>">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>รายละเอียด:</label>
                            <textarea rows="6" cols="50" name="his_detailproduct" class="form-control" placeholder="รายละเอียด"><?php echo $result["his_detailproduct"];?></textarea>
                            <!-- <input type="text" name="detailproduct1" class="form-control" placeholder="รายละเอียด แถวที่ 1:" value="หลวงปู่โต๊ะ รุ่น 129 ปี วัดถ้ำสิงโตทอง (ซึ่งวัดนี้คืออีกสถานที่ปฏิบัติธรรมที่หลวงปู่โต๊ะท่าบุกเบิกสร้างขึ้น) "> -->
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-2">
                          <input type="submit" name="insert" value="บันทึก" class="form-control btn btn-success"> 
                        </div>
                        <div class="col-md-2">
                          <a href="./index.php" class="form-control btn btn-danger"> ยกเลิก</a>
                        </div>
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