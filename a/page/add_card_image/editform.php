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
  <style>
    body {
      margin: 0;
    }

    .topnav1 {
      overflow: hidden;
      background-color: #f1f1f1;
    }

    .topnav1 a {
      float: left;
      display: block;
      color: black;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
      border-bottom: 3px solid transparent;
    }

    .topnav1 a:hover {
      border-bottom: 3px solid red;
    }

    .topnav1 a.active {
      border-bottom: 3px solid red;
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
          <a href="../theme.php">หน้าหลัก</a>
          <a class="active" href="../th-ex.php">แกลเลอรี่</a>
        </div>
        <div class="topnav1">
          <a href="../th-ex.php"><h4><b>หัวข้อ</b></h4></a>
          <a class="active" href="../portfolio"><h4><b>รูป</b></h4></a>
        </div> -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- หัวข้อ -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">รายละเอียดรูปภาพ</h1>
          </div>

          <!-- Content Row -->
          <div class="content">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลรายละเอียด</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <?php
                     $strmember_id = null;
                     if(isset($_GET["id"]))
                     {
                       $strmember_id = $_GET["id"];
                     }
                     $sql = $conn->prepare("SELECT * FROM tb_image WHERE id = ?");
                     $sql->execute([$strmember_id]);
                     $result = $sql->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <form action="editsave.php" name="frmAdd" method="post">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th><center>หัวข้อ</center></th>
                          <th><center>สถานะ</center></th>
                          <th><center>รายละเอียด</center></th>
                          <th><center>รูปภาพ</center></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tr>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $result["id"];?>">
                        <td><input type="text" class="form-control" name="detail1" value="<?php echo $result["detail1"];?>"></td>
                        <td><input type="text" class="form-control" name="detail2" value="<?php echo $result["detail2"];?>"></td>
                        <td><input type="text" class="form-control" name="detail3" value="<?php echo $result["detail3"];?>"></td>
                        <td>
                          <?php    
                            $stmt = $conn->prepare("SELECT * FROM tb_image where id = ?");
                            $stmt->execute([$strmember_id]);
                            $query = $stmt->fetchAll();
                            if($stmt->rowCount() >= 0){
                              foreach($query as $row) {
                                $images = 'upimg-port/'. $row['images'];
                                echo "<center><img src='".$images."' class='img-thumbnail' width='200px' height='200px' /></center>";
                              }
                            }else{
                              echo "<h3 style='text-align:center'>No Image found</h3>";
                            }
                          ?>
                        </td>
                        <td>
                          <center>
                            <button type="submit" class="btn btn-success" name="button"><i class="fa fa-check">
                                บันทึก</i></button>
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

<script type="text/javascript">
  $(document).ready(function () {
    $("#submitForm").on("submit", function (e) {
      e.preventDefault();
      $.ajax({
        url: "upload.php",
        type: "POST",
        cache: false,
        contentType: false, // you can also use multipart/form-data replace of false
        processData: false,
        data: new FormData(this),
        success: function (response) {
          $("#success").show();
          $("#multipleFile").val("");
          fetchData();
        }
      });
    });

    // Fetch Data from Database
    function fetchData() {
      $.ajax({
        url: "fetch_data_edit.php",
        type: "POST",
        cache: false,
        success: function (data) {
          $("#gallery").html(data);
        }
      });
    }
    fetchData();

    // Edit Data from Database
    $(document).on("click", ".btn-success", function () {
      var editId = $(this).data('id');
      $.ajax({
        url: "edit.php",
        type: "POST",
        cache: false,
        data: {
          editId: editId
        },
        success: function (data) {
          $("#editForm").html(data);
        }
      });
    });

    // Delete Data from database

    $(document).on('click', '.delete-btn', function () {
      var deleteId = $(this).data('id');
      if (confirm("Are you sure want to delete this image")) {
        $.ajax({
          url: "delete.php",
          type: "POST",
          cache: false,
          data: {
            deleteId: deleteId
          },
          success: function (data) {
            fetchData();
            alert("Image is deleted successfully");
          }
        });
      }
    });

    // Update Data from database
    $(document).on("submit", "#editForm", function (e) {
      e.preventDefault();
      var formData = new FormData(this);
      $.ajax({
        url: "update.php",
        type: "POST",
        cache: false,
        contentType: false, // you can also use multipart/form-data replace of false
        processData: false,
        data: formData,
        success: function (response) {
          $("#exampleModal").modal('hide');
          alert("Image updated successfully");
          fetchData();
        }
      });
    });
  });
</script>