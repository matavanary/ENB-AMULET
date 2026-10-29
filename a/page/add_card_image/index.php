<?php 
include("../../../config/dbConnection.php");
include("../../session.php");

$his_code = isset($_GET["his_code"]) ? $_GET["his_code"] : '';
$card = null;
$his_numcard = '';

if (!empty($his_code)) {
    $sql_chknumcard = $conn->prepare("SELECT * FROM tb_history WHERE his_code = ?");
    $sql_chknumcard->execute(array($his_code));
    $card = $sql_chknumcard->fetch(PDO::FETCH_ASSOC);
    if ($card && isset($card["his_numcard"])) {
        $his_numcard = $card["his_numcard"];
    }
}

// สร้างโฟลเดอร์สำหรับเก็บ QR Code ชั่วคราว
$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = 'temp/';
include "./phpqrcode/qrlib.php";

if (!file_exists($PNG_TEMP_DIR)) {
    @mkdir($PNG_TEMP_DIR, 0777, true);
}

$filename = $PNG_TEMP_DIR . $his_numcard . ".png";
$errorCorrectionLevel = 'M'; 
$matrixPointSize = 8;

// URL ตรวจสอบพระ
$targetHost = isset($webhost) ? rtrim($webhost, '/') : '';
$verifyUrl = !empty($targetHost) ? "$targetHost/index.php?his_numcard=$his_numcard" : "index.php?his_numcard=$his_numcard";

$qrBase64 = '';
if (!empty($his_numcard)) {
    QRcode::png($verifyUrl, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    if (file_exists($filename)) {
        $qrRawData = file_get_contents($filename);
        if ($qrRawData !== false) {
            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrRawData);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="จัดการรูปภาพและ QR Code บัตรรับรองพระเครื่อง">
  <title>จัดการรูปภาพและ QR Code - สถาบันรับรองพระเครื่องเมืองชลฯ</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

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

    .page-title-box {
      background: white;
      border-radius: 0.75rem;
      padding: 1.25rem 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
      border: 1px solid #edf2f7;
    }

    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 0.5rem;
      font-size: 0.85rem;
    }

    .badge-card-no {
      font-family: 'Nunito', monospace;
      font-size: 0.95rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      color: #2b6cb0;
      background-color: #ebf8ff;
      border: 1px solid #bee3f8;
      border-radius: 0.375rem;
      padding: 0.25rem 0.65rem;
    }

    /* กล่องบัตร QR Code สำหรับ Export ภาพ */
    .qr-export-box {
      width: 100%;
      max-width: 440px;
      background: #ffffff;
      border: 4px double #2b6cb0;
      border-radius: 16px;
      padding: 24px 20px;
      margin: 0 auto;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
      text-align: center;
      box-sizing: border-box;
    }

    .qr-org-title {
      font-size: 19px;
      font-weight: 600;
      color: #2d3748;
      margin-bottom: 4px;
    }

    .qr-card-number {
      font-family: 'Nunito', monospace;
      font-size: 36px;
      font-weight: 800;
      color: #2b6cb0;
      letter-spacing: 1.5px;
      line-height: 1.2;
      margin-bottom: 12px;
    }

    .qr-image-wrapper {
      background: #ffffff;
      padding: 8px;
      display: inline-block;
      border: 1px solid #edf2f7;
      border-radius: 12px;
    }

    .qr-code-img {
      width: 290px;
      height: 290px;
      display: block;
      margin: 0 auto;
    }

    .qr-scan-hint {
      font-size: 15px;
      color: #718096;
      margin-top: 10px;
      font-weight: 500;
    }

    /* Modal Form Enhancements */
    .modal-content {
      border-radius: 0.75rem;
      border: none;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
      background-color: #4e73df;
      color: white;
      border-top-left-radius: 0.75rem;
      border-top-right-radius: 0.75rem;
    }

    .modal-header .close {
      color: white;
      text-shadow: none;
      opacity: 0.8;
    }

    .modal-header .close:hover {
      opacity: 1;
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

          <?php if (!$card): ?>
            <!-- Alert If Record Not Found -->
            <div class="card shadow mb-4">
              <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-circle fa-4x text-warning mb-3"></i>
                <h4 class="font-weight-bold text-gray-800">ไม่พบข้อมูลบัตรรับรองที่ระบุ</h4>
                <p class="text-muted mb-4">รหัสบัตรรับรองนี้อาจไม่ถูกต้อง</p>
                <a href="../card/index.php" class="btn btn-primary px-4 rounded-pill">
                  <i class="fas fa-arrow-left mr-2"></i>กลับหน้ารายการบัตร
                </a>
              </div>
            </div>
          <?php else: 
            $amuletName = isset($card['his_nameproduct']) ? $card['his_nameproduct'] : '';
            $amuletType = isset($card['his_type']) ? $card['his_type'] : '';
            $amuletOwner = isset($card['his_owner']) ? $card['his_owner'] : '';
          ?>

            <!-- Page Header -->
            <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between">
              <div>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../card/index.php" class="text-primary">รายการบัตร</a></li>
                    <li class="breadcrumb-item active" aria-current="page">จัดการรูปภาพและ QR Code</li>
                  </ol>
                </nav>
                <div class="d-flex align-items-center flex-wrap">
                  <h1 class="h3 font-weight-bold text-gray-800 mb-0 mr-3">
                    <i class="fas fa-images text-primary mr-2"></i>จัดการรูปภาพและ QR Code
                  </h1>
                  <span class="badge-card-no mt-2 mt-sm-0">
                    เลขที่: <?php echo htmlspecialchars($his_numcard); ?>
                  </span>
                </div>
                <?php if (!empty($amuletName)): ?>
                  <p class="text-muted small mb-0 mt-1">
                    <i class="fas fa-gem text-warning mr-1"></i><?php echo htmlspecialchars($amuletName); ?>
                    <?php if (!empty($amuletType)): ?>
                      <span class="mx-2">•</span><i class="fas fa-layer-group text-info mr-1"></i><?php echo htmlspecialchars($amuletType); ?>
                    <?php endif; ?>
                    <?php if (!empty($amuletOwner)): ?>
                      <span class="mx-2">•</span><i class="fas fa-user text-secondary mr-1"></i>เจ้าของ: <?php echo htmlspecialchars($amuletOwner); ?>
                    <?php endif; ?>
                  </p>
                <?php endif; ?>
              </div>
              <div class="mt-3 mt-md-0 d-flex flex-wrap">
                <a href="../card/edit_card.php?his_code=<?php echo urlencode($his_code); ?>" class="btn btn-outline-primary btn-sm px-3 py-2 rounded-pill shadow-sm mr-2 font-weight-bold">
                  <i class="fas fa-edit mr-1"></i> แก้ไขข้อมูลบัตรนี้
                </a>
                <a href="../card/index.php" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill shadow-sm">
                  <i class="fas fa-arrow-left mr-1"></i> หน้ารายการบัตร
                </a>
              </div>
            </div>

            <!-- Content Row -->
            <input type="hidden" id="his_code" value="<?php echo htmlspecialchars($his_code); ?>">

            <div class="row">
              <!-- คอลัมน์ซ้าย: จัดการรูปภาพ 9 ช่อง -->
              <div class="col-xl-7 col-lg-6 mb-4">
                <div class="card shadow h-100">
                  <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                      <i class="fas fa-photo-video mr-2"></i>ภาพพระเครื่องประจำบัตร (สูงสุด 9 ภาพ)
                    </h6>
                    <span class="badge badge-light border text-muted px-2 py-1">
                      <i class="fas fa-info-circle mr-1"></i>คลิกเปลี่ยนหรือลบได้ในตาราง
                    </span>
                  </div>
                  <div class="card-body p-0">
                    <div id="gallery">
                      <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                          <span class="sr-only">กำลังโหลด...</span>
                        </div>
                        <p class="text-muted mt-2 small">กำลังโหลดรายการรูปภาพ...</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- คอลัมน์ขวา: QR Code สำหรับรับรอง -->
              <div class="col-xl-5 col-lg-6 mb-4">
                <div class="card shadow h-100">
                  <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                      <i class="fas fa-qrcode mr-2"></i>QR Code ตรวจสอบความแท้
                    </h6>
                    <span class="badge badge-success px-2 py-1">
                      <i class="fas fa-check mr-1"></i>พร้อมใช้งาน
                    </span>
                  </div>
                  <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    
                    <!-- กรอบบัตรสำหรับดาวน์โหลดเป็นภาพ -->
                    <div id="html2canvas" class="qr-export-box mb-4">
                      <div class="qr-org-title">สถาบันรับรองพระเครื่องเมืองชลฯ</div>
                      <div class="qr-card-number"><?php echo htmlspecialchars($his_numcard); ?></div>
                      <div class="qr-image-wrapper">
                        <?php 
                          $imgSrc = !empty($qrBase64) ? $qrBase64 : ($PNG_WEB_DIR . basename($filename));
                        ?>
                        <img id="qrCodeImage" src="<?php echo $imgSrc; ?>" class="qr-code-img" alt="QR Code <?php echo htmlspecialchars($his_numcard); ?>">
                      </div>
                      <div class="qr-scan-hint">สแกนเพื่อตรวจสอบความแท้</div>
                    </div>

                    <!-- ปุ่มการดำเนินการเกี่ยวกับ QR Code -->
                    <div class="w-100" style="max-width: 440px;">
                      <button onclick="downloadQRCard()" class="btn btn-success btn-block py-2 mb-2 shadow-sm font-weight-bold">
                        <i class="fas fa-download mr-2"></i>ดาวน์โหลดภาพบัตร QR Code
                      </button>
                      <a href="<?php echo htmlspecialchars($PNG_WEB_DIR . basename($filename)); ?>" download="QR_<?php echo htmlspecialchars($his_numcard); ?>.png" class="btn btn-outline-secondary btn-block py-2 mb-2 shadow-sm font-weight-bold text-dark">
                        <i class="fas fa-file-image mr-2"></i>ดาวน์โหลดเฉพาะไฟล์รูป QR Code
                      </a>
                      <a href="<?php echo htmlspecialchars($verifyUrl); ?>" target="_blank" class="btn btn-outline-info btn-block py-2 shadow-sm">
                        <i class="fas fa-external-link-alt mr-2"></i>ทดสอบเปิดหน้าแสดงผลพระเครื่อง
                      </a>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal สำหรับเปลี่ยนรูปภาพเดิม -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold" id="modalLabel">
            <i class="fas fa-upload mr-2"></i>เลือกรูปภาพ
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="editFormContainer">
          <!-- edit.php จะถูกโหลดเข้ามาที่นี่ -->
          <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="text-muted mt-2 small">กำลังโหลดฟอร์ม...</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal สำหรับเพิ่มรูปภาพใหม่ -->
  <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content shadow-lg border-0" style="border-radius: 0.75rem;">
        <div class="modal-header bg-primary text-white" style="border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">
          <h5 class="modal-title font-weight-bold" id="addImageModalLabel">
            <i class="fas fa-plus-circle mr-2"></i>เพิ่มรูปภาพพระเครื่องใหม่
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addNewImageForm" enctype="multipart/form-data">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="his_code" value="<?php echo htmlspecialchars($his_code); ?>">
          <div class="modal-body p-4">
            <div class="form-group mb-3">
              <label class="font-weight-bold text-dark small">เลือกไฟล์รูปภาพ (JPG, PNG, JPEG): <span class="text-danger">*</span></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="file_name" id="new_file_name" accept="image/*" required>
                <label class="custom-file-label" for="new_file_name">เลือกไฟล์รูปภาพ...</label>
              </div>
            </div>

            <div class="form-group mb-3">
              <label class="font-weight-bold text-dark small">หัวข้อมุมมองภาพ (เช่น ด้านหน้า, ด้านหลัง, โค้ดใต้ฐาน):</label>
              <input type="text" class="form-control" name="detail1" placeholder="เช่น ด้านหน้าองค์พระ">
            </div>

            <div class="form-group mb-3">
              <label class="font-weight-bold text-dark small">สถานะภาพ (เช่น ภาพหลัก, ภาพขยาย, สภาพสมบูรณ์):</label>
              <input type="text" class="form-control" name="detail2" placeholder="เช่น ภาพมุมมองหลัก">
            </div>

            <div class="form-group mb-0">
              <label class="font-weight-bold text-dark small">รายละเอียดเพิ่มเติมเกี่ยวกับภาพนี้:</label>
              <textarea class="form-control" name="detail3" rows="3" placeholder="ระบุรายละเอียดเพิ่มเติม หรือจุดสังเกต..."></textarea>
            </div>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">ยกเลิก</button>
            <button type="submit" class="btn btn-primary btn-sm px-4 font-weight-bold">
              <i class="fas fa-save mr-1"></i>บันทึกและเพิ่มรูปภาพ
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

  <script>
    // ฟังก์ชันดาวน์โหลดบัตร QR Code เป็นรูปภาพ PNG โดยใช้ Native HTML5 Canvas 100% (ไม่พึ่งพา html2canvas จึงไม่เกิดภาพว่าง)
    function downloadQRCard() {
      var qrImgEl = document.getElementById('qrCodeImage');
      if (!qrImgEl) return;

      var downloadBtn = (typeof event !== 'undefined' && event && event.target) ? (event.target.closest ? event.target.closest('button') : event.target) : null;
      var originalBtnHtml = downloadBtn ? downloadBtn.innerHTML : '';
      if (downloadBtn) {
        downloadBtn.disabled = true;
        downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>กำลังสร้างภาพ...';
      }

      function generateAndDownload(img) {
        try {
          var canvas = document.createElement('canvas');
          canvas.width = 880;
          canvas.height = 1040;
          var ctx = canvas.getContext('2d');

          function drawRoundRect(x, y, w, h, r) {
            ctx.beginPath();
            ctx.moveTo(x + r, y);
            ctx.arcTo(x + w, y, x + w, y + h, r);
            ctx.arcTo(x + w, y + h, x, y + h, r);
            ctx.arcTo(x, y + h, x, y, r);
            ctx.arcTo(x, y, x + w, y, r);
            ctx.closePath();
          }

          // 1. พื้นหลังการ์ดสีขาว
          ctx.fillStyle = '#ffffff';
          drawRoundRect(0, 0, canvas.width, canvas.height, 36);
          ctx.fill();

          // 2. กรอบนอกคู่สีน้ำเงิน
          ctx.strokeStyle = '#2b6cb0';
          ctx.lineWidth = 6;
          drawRoundRect(14, 14, canvas.width - 28, canvas.height - 28, 28);
          ctx.stroke();

          // 3. กรอบในเส้นเล็ก
          ctx.strokeStyle = '#2b6cb0';
          ctx.lineWidth = 2;
          drawRoundRect(22, 22, canvas.width - 44, canvas.height - 44, 22);
          ctx.stroke();

          // 4. หัวข้อสถาบัน
          ctx.fillStyle = '#2d3748';
          ctx.font = 'bold 36px "Prompt", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif';
          ctx.textAlign = 'center';
          ctx.fillText('สถาบันรับรองพระเครื่องเมืองชลฯ', 440, 92);

          // 5. เลขที่บัตร
          var cardNo = '<?php echo !empty($his_numcard) ? addslashes($his_numcard) : "QR"; ?>';
          ctx.fillStyle = '#2b6cb0';
          ctx.font = '800 68px "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif';
          ctx.textAlign = 'center';
          ctx.fillText(cardNo, 440, 175);

          // 6. กล่องกรอบสำหรับรูป QR Code
          ctx.fillStyle = '#ffffff';
          ctx.strokeStyle = '#edf2f7';
          ctx.lineWidth = 3;
          drawRoundRect(130, 215, 620, 620, 24);
          ctx.fill();
          ctx.stroke();

          // 7. วาดรูป QR Code จากตัวภาพโดยตรง (รับประกันภาพติด 100%)
          ctx.drawImage(img, 145, 230, 590, 590);

          // 8. ข้อความแนะนำใต้ QR Code
          ctx.fillStyle = '#718096';
          ctx.font = '500 30px "Prompt", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif';
          ctx.textAlign = 'center';
          ctx.fillText('สแกนเพื่อตรวจสอบความแท้', 440, 940);

          // 9. บันทึกและดาวน์โหลดภาพ PNG
          var cleanName = cardNo.replace(/[^a-zA-Z0-9_-]/g, '_');
          var fileName = 'QR_' + cleanName + '.png';
          var imgUrl = canvas.toDataURL('image/png');
          
          var fakeLink = document.createElement('a');
          fakeLink.style.display = 'none';
          fakeLink.download = fileName;
          fakeLink.href = imgUrl;
          document.body.appendChild(fakeLink);
          fakeLink.click();
          document.body.removeChild(fakeLink);
        } catch (e) {
          console.error("Canvas draw error:", e);
          alert("เกิดข้อผิดพลาดในการสร้างภาพ กรุณาลองใหม่อีกครั้ง: " + e.message);
        } finally {
          if (downloadBtn) {
            downloadBtn.disabled = false;
            downloadBtn.innerHTML = originalBtnHtml;
          }
        }
      }

      // ตรวจสอบว่ารูปพร้อมวาดหรือไม่
      if (qrImgEl.complete && qrImgEl.naturalWidth > 0) {
        generateAndDownload(qrImgEl);
      } else {
        var tempImg = new Image();
        tempImg.crossOrigin = "anonymous";
        tempImg.onload = function() {
          generateAndDownload(tempImg);
        };
        tempImg.onerror = function() {
          alert("ไม่สามารถโหลดรูป QR Code ได้ กรุณาลองใหม่อีกครั้ง");
          if (downloadBtn) {
            downloadBtn.disabled = false;
            downloadBtn.innerHTML = originalBtnHtml;
          }
        };
        tempImg.src = qrImgEl.src;
      }
    }

    // Alias ให้เรียกฟังก์ชันเดิมได้
    var downloadByHtml2Canvas = downloadQRCard;

    $(document).ready(function() {
      // ดึงรายการรูปภาพทั้งหมดของบัตรนี้ผ่าน AJAX
      function fetchData() {
        var hisCodeEl = document.getElementById('his_code');
        if (!hisCodeEl) return;
        var his_code = hisCodeEl.value;

        $.ajax({
          url: "fetch_data.php",
          type: "POST",
          data: { his_code: his_code },
          cache: false,
          success: function(data) {
            $("#gallery").html(data);
          },
          error: function() {
            $("#gallery").html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-triangle mr-2"></i>ไม่สามารถโหลดข้อมูลรูปภาพได้</div>');
          }
        });
      }

      fetchData();

      // เมื่อคลิกปุ่ม "+ เพิ่มรูปภาพใหม่"
      $(document).on("click", ".btn-add-new-img", function() {
        $("#addNewImageForm")[0].reset();
        $("#addNewImageForm .custom-file-label").removeClass("selected").html("เลือกไฟล์รูปภาพ...");
        $("#addImageModal").modal("show");
      });

      // Submit ฟอร์มเพิ่มรูปภาพใหม่
      $(document).on("submit", "#addNewImageForm", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var submitBtn = $(this).find("button[type='submit']");
        var originalText = submitBtn.html();
        submitBtn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin mr-1"></i>กำลังบันทึก...');

        $.ajax({
          url: "update.php",
          type: "POST",
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          success: function(response) {
            $("#addImageModal").modal('hide');
            fetchData();
          },
          error: function(xhr) {
            var msg = xhr.responseText ? xhr.responseText : "ไม่สามารถเพิ่มรูปภาพได้ กรุณาตรวจสอบไฟล์";
            alert(msg);
          },
          complete: function() {
            submitBtn.prop("disabled", false).html(originalText);
          }
        });
      });

      // เมื่อคลิกปุ่มเปลี่ยนภาพ ให้เปิด Modal และดึงฟอร์มจาก edit.php
      $(document).on("click", ".btn-change-img", function() {
        var editId = $(this).data('id');
        $("#editFormContainer").html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="text-muted mt-2 small">กำลังโหลดฟอร์ม...</p></div>');
        
        $.ajax({
          url: "edit.php",
          type: "POST",
          cache: false,
          data: { editId: editId },
          success: function(data) {
            $("#editFormContainer").html(data);
          },
          error: function() {
            $("#editFormContainer").html('<div class="p-4 text-center text-danger">เกิดข้อผิดพลาดในการโหลดแบบฟอร์ม</div>');
          }
        });
      });

      // ลบรูปภาพผ่าน AJAX
      $(document).on('click', '.delete-btn', function() {
        var deleteId = $(this).data('id');
        if (confirm("คุณแน่ใจหรือไม่ว่าต้องการลบรูปภาพนี้?")) {
          $.ajax({
            url: "delete.php",
            type: "POST",
            cache: false,
            data: { deleteId: deleteId },
            success: function(data) {
              fetchData();
            },
            error: function() {
              alert("ไม่สามารถลบรูปภาพได้ กรุณาลองใหม่อีกครั้ง");
            }
          });
        }
      });

      // บันทึกการอัปเดตรูปภาพจากฟอร์มใน Modal
      $(document).on("submit", "#editForm", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var submitBtn = $(this).find("button[type='submit']");
        var originalText = submitBtn.html();
        submitBtn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin mr-1"></i>กำลังบันทึก...');

        $.ajax({
          url: "update.php",
          type: "POST",
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          success: function(response) {
            $("#exampleModal").modal('hide');
            fetchData();
          },
          error: function() {
            alert("ไม่สามารถอัปเดตรูปภาพได้ กรุณาตรวจสอบไฟล์รูปภาพ");
          },
          complete: function() {
            submitBtn.prop("disabled", false).html(originalText);
          }
        });
      });

      // อัปเดตชื่อไฟล์ที่เลือกใน custom-file input
      $(document).on('change', '.custom-file-input', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
    });
  </script>

</body>

</html>
