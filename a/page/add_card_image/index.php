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
  <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
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
    .specific {
      width: 500px;
      height: 550px;
      margin: auto;
      /* margin: 0px 0px 0px 100px; */
    }	
    .boxqrcode {
      width: 550px;
      height: 520px;
      margin: auto;
      margin: 50px 0px 0px -25px;
    }	
    .textcard {    
      position: absolute;
      align-items: center;
      justify-content: center;
      left: 0px;
      height: 50px;
      width: 100%;
      font-size: 70px;
      line-height: 70px;
      text-align: center;
      vertical-align: middle;
      margin: auto;
      /* position: absolute;
      font-size: 70px;
      margin: auto; */
      /* margin: -20px 0px 0px 80px; */
    }		
  </style> 
</head>
<body id="page-top">
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
            <h1 class="h3 mb-0 text-gray-800">เพิ่มรูปภาพ</h1>
          </div>

          <!-- Content Row -->
          <div class="content">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">เพิ่มรูปภาพ</h6>
              </div>
              <div class="card-body">
                <?php
                  $his_code = null;
                  if (isset($_GET["his_code"])) {
                    $his_code = $_GET["his_code"];
                  }           
                  $sql_chknumcard = $conn->prepare("SELECT his_numcard FROM tb_history WHERE his_code = ?");
                  $sql_chknumcard->execute([$his_code]);
                  $result_chknumcard = $sql_chknumcard->fetch(PDO::FETCH_ASSOC);
                  $his_numcard = $result_chknumcard["his_numcard"];   
                ?>     
                <!-- QRCODE -->
                <?php        
                  $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
                  $PNG_WEB_DIR = 'temp/';
                  include "./phpqrcode/qrlib.php";
                  if (!file_exists($PNG_TEMP_DIR))
                  mkdir($PNG_TEMP_DIR);
                  $filename = $PNG_TEMP_DIR."$his_numcard.png";
                  $errorCorrectionLevel = 'M'; 
                  $matrixPointSize = 5;               
                  // QRcode::png("http://203.150.225.30:84/?his_numcard=$his_numcard", $filename, $errorCorrectionLevel, $matrixPointSize, 2);     
                  QRcode::png("$webhost/index.php?his_numcard=$his_numcard", $filename, $errorCorrectionLevel, $matrixPointSize, 2);     
                ?>       
                <input type="hidden" class="custom-file-input" id="his_code" value="<?=$his_code?>" >
                <div class="row">
                  <div class="col-md-6">
                  <center><div id="gallery"></div></center>  
                  </div>
                  <div class="col-md-6">
                    <center>
                      <div class="card-body">
                        <div class="row">                    
                          <div class="specific" id="html2canvas">
                            <font class="textcard"><b><?=$his_numcard?></b></font>
                            <img src="<?php echo $PNG_WEB_DIR.basename($filename)?>" class="boxqrcode">    
                          </div>
                        </div>
                        <!-- <br> -->
                        <button onclick="downloadByHtml2Canvas()" class="btn btn-success">Download QR Code</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="../card" class="btn btn-danger"> ข้าม / ย้อนกลับ</a>
                      </div>                      
                    </center>  
                  </div>
                </div>
              </div>
            </div>

          </div>


            <!--Edit Multiple image form -->
            <div class='modal' id='exampleModal'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h4 class='modal-title'>เปลี่ยนรูปภาพ</h4>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div id="editForm">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- End of Content Wrapper -->

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

  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <script>
    function downloadByHtml2Canvas() {
      html2canvas(document.querySelector('#html2canvas')).then((canvas) => {
        const name = 'QR';
        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth() + 1;
        let yyyy = today.getFullYear();
        if (dd < 10) {
          dd = '0' + dd;
        }
        if (mm < 10) {
          mm = '0' + mm;
        }
        today = yyyy + '-' + mm + '-' + dd;
        let img = canvas.toDataURL('image/png');
        downloadImage(img, `${name}_${today}`);
      });
    }
    function downloadImage(blob, fileName) {
      const fakeLink = window.document.createElement('a');
      fakeLink.style = 'display:none;';
      fakeLink.download = fileName;
      fakeLink.href = blob;
      document.body.appendChild(fakeLink);
      fakeLink.click();
      document.body.removeChild(fakeLink);
      fakeLink.remove();
    }      

  </script>

<script type="text/javascript">
$(document).ready(function(){
  $("#submitForm").on("submit", function(e){
    e.preventDefault();
    $.ajax({
      url  :"upload.php",
      type :"POST",
      cache:false,
      contentType : false, // you can also use multipart/form-data replace of false
      processData : false,
      data: new FormData(this),
      success:function(response){
        $("#success").show();
        $("#multipleFile").val("");
        fetchData();
      }
    });
  });

  // Fetch Data from Database
  function fetchData(){
    var his_code = document.getElementById('his_code').value;
    $.ajax({
      url  : "fetch_data.php",
      type : "POST",      
      data: {
        his_code: his_code
      },
      cache: false,
      success:function(data){
        $("#gallery").html(data);
      }
    });
  }
  fetchData();

  // Edit Data from Database
  $(document).on("click",".btn-success", function(){
    var editId = $(this).data('id');
    $.ajax({
      url : "edit.php",
      type : "POST",
      cache: false,
      data : {editId:editId},
      success:function(data){
        $("#editForm").html(data);
      }
    });
  });

  // Delete Data from database

  $(document).on('click','.delete-btn', function(){
    var deleteId = $(this).data('id');
    if (confirm("Are you sure want to delete this image")) {
      $.ajax({
        url  : "delete.php",
        type : "POST",
        cache:false,
        data:{deleteId:deleteId},
        success:function(data){
          alert("Image is deleted successfully");
          fetchData();
        }
      });
    }
  });

  // Update Data from database
  $(document).on("submit", "#editForm", function(e){
  e.preventDefault();
  var formData = new FormData(this);
  $.ajax({
      url  : "update.php",
      type : "POST",
      cache: false,
      contentType : false, // you can also use multipart/form-data replace of false
      processData : false,
      data: formData,
      success:function(response){
        $("#exampleModal").modal('hide');
        alert("Image updated successfully");
        fetchData();
      }
    });
  });
});

</script>

</body>

</html>