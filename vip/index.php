<?php
session_start();
if (isset($_SESSION['member_id']) && !empty($_SESSION['member_id'])) {
    header("Location: ../a/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="ระบบจัดการและตรวจสอบพระเครื่อง VIP AMULET">
  <meta name="author" content="AMULET">

  <title>เข้าสู่ระบบสมาชิก VIP | AMULET</title>
  <link rel="shortcut icon" type="image/x-icon" href="../assets/Logo.png">

  <!-- Google Fonts: Prompt -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="../a/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- SB Admin 2 / Bootstrap Core Styles -->
  <link href="../a/css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      --accent-gold: #d4af37;
      --accent-gold-hover: #b89628;
    }

    * {
      font-family: 'Prompt', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
      min-height: 100vh;
      /* background: radial-gradient(circle at 10% 20%, rgba(30, 60, 114, 0.95) 0%, rgba(15, 23, 42, 0.98) 90%),
                  url('../assets/Logo.png') no-repeat center center fixed; */
      /* background-size: cover; */
      background-color: #0f172a; /* Dark background color */
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 1.5rem 0.75rem;
      position: relative;
    }

    /* Ambient background overlay pattern */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.12), transparent 40%),
                  radial-gradient(circle at 20% 80%, rgba(42, 82, 152, 0.25), transparent 45%);
      pointer-events: none;
    }

    .login-container {
      width: 100%;
      max-width: 460px;
      position: relative;
      z-index: 1;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 1.25rem;
      border: 1px solid rgba(255, 255, 255, 0.6);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35),
                  0 0 0 1px rgba(255, 255, 255, 0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card-header {
      padding: 2.25rem 2rem 1.25rem;
      text-align: center;
      position: relative;
    }

    .logo-wrapper {
      width: 90px;
      height: 90px;
      margin: 0 auto 1.25rem;
      padding: 8px;
      background: #ffffff;
      border-radius: 50%;
      box-shadow: 0 10px 25px rgba(30, 60, 114, 0.2), 0 0 0 3px rgba(212, 175, 55, 0.35);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .logo-wrapper:hover {
      transform: scale(1.06);
    }

    .logo-wrapper img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .badge-vip {
      background: linear-gradient(135deg, #d4af37, #f3e08a);
      color: #3d2d00;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      padding: 0.35rem 0.9rem;
      border-radius: 50rem;
      display: inline-block;
      margin-bottom: 0.5rem;
      box-shadow: 0 4px 10px rgba(212, 175, 55, 0.25);
    }

    .login-title {
      font-size: 1.45rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 0.35rem;
    }

    .login-subtitle {
      font-size: 0.875rem;
      color: #64748b;
      font-weight: 400;
      margin-bottom: 0;
    }

    .login-card-body {
      padding: 1.25rem 2rem 2.25rem;
    }

    .form-group {
      margin-bottom: 1.35rem;
    }

    .form-label {
      font-size: 0.875rem;
      font-weight: 600;
      color: #334155;
      margin-bottom: 0.45rem;
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 1rem;
      color: #94a3b8;
      font-size: 1rem;
      transition: color 0.2s ease;
      pointer-events: none;
      z-index: 2;
    }

    .form-control-modern {
      height: 3rem;
      padding-left: 2.75rem !important;
      padding-right: 2.75rem !important;
      font-size: 0.95rem;
      border-radius: 0.75rem;
      border: 1.5px solid #e2e8f0;
      background-color: #f8fafc;
      color: #1e293b;
      font-weight: 500;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      width: 100%;
    }

    .form-control-modern:focus {
      background-color: #ffffff;
      border-color: #2a5298;
      box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.15);
      outline: none;
    }

    .form-control-modern:focus + .input-icon,
    .input-wrapper:focus-within .input-icon {
      color: #2a5298;
    }

    .form-control-modern::placeholder {
      color: #94a3b8;
      font-weight: 300;
      font-size: 0.9rem;
    }

    .password-toggle-btn {
      position: absolute;
      right: 0.75rem;
      background: transparent;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      padding: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.95rem;
      transition: color 0.2s ease;
      z-index: 3;
    }

    .password-toggle-btn:hover {
      color: #334155;
    }

    .btn-login {
      height: 3.1rem;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      border: none;
      border-radius: 0.75rem;
      color: #ffffff;
      font-size: 1rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      box-shadow: 0 8px 20px rgba(30, 60, 114, 0.35);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 0.75rem;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #162d56 0%, #22427a 100%);
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(30, 60, 114, 0.45);
    }

    .btn-login:active {
      transform: translateY(0);
      box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
    }

    .btn-login:disabled {
      opacity: 0.75;
      cursor: not-allowed;
      transform: none;
    }

    .divider {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 1.5rem 0 1.25rem;
      color: #cbd5e1;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #e2e8f0;
    }

    .back-home-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      color: #64748b;
      font-size: 0.875rem;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.2s ease;
      padding: 0.4rem 0.8rem;
      border-radius: 0.5rem;
    }

    .back-home-link:hover {
      color: #1e3c72;
      background-color: #f1f5f9;
      text-decoration: none;
    }

    .login-footer-text {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.8rem;
      color: rgba(255, 255, 255, 0.7);
    }

    /* SweetAlert2 Prompt Font Customization */
    .swal2-popup {
      font-family: 'Prompt', sans-serif !important;
      border-radius: 1.25rem !important;
      padding: 1.75rem !important;
    }

    .swal2-title {
      font-size: 1.35rem !important;
      font-weight: 700 !important;
      color: #1e293b !important;
    }

    .swal2-html-container {
      font-size: 0.95rem !important;
      color: #64748b !important;
    }

    .swal2-confirm {
      font-family: 'Prompt', sans-serif !important;
      font-weight: 500 !important;
      border-radius: 0.6rem !important;
      padding: 0.6rem 1.6rem !important;
    }

    @media (max-width: 576px) {
      .login-card-header {
        padding: 1.75rem 1.5rem 1rem;
      }
      .login-card-body {
        padding: 1rem 1.5rem 1.75rem;
      }
      .logo-wrapper {
        width: 75px;
        height: 75px;
      }
      .login-title {
        font-size: 1.25rem;
      }
    }
  </style>
</head>

<body>

  <div class="login-container">
    <div class="card login-card">
      <div class="login-card-header">
        <div class="logo-wrapper">
          <img src="../assets/Logo.png" alt="AMULET Logo">
        </div>
        <div>
          <span class="badge-vip">
            <i class="fas fa-crown mr-1"></i> VIP PORTAL
          </span>
        </div>
        <h1 class="login-title">เข้าสู่ระบบ</h1>
        <p class="login-subtitle">ระบบจัดการข้อมูลและออกบัตรรับรองพระแท้</p>
      </div>

      <div class="login-card-body">
        <form id="loginForm" method="POST" autocomplete="on">
          <!-- Username Field -->
          <div class="form-group">
            <label for="member_user" class="form-label">
              <i class="fas fa-user-circle text-primary"></i> ชื่อผู้ใช้งาน (Username)
            </label>
            <div class="input-wrapper">
              <i class="fas fa-user input-icon"></i>
              <input type="text" 
                     name="member_user" 
                     id="member_user" 
                     class="form-control form-control-modern" 
                     placeholder="กรอกชื่อผู้ใช้ของคุณ" 
                     required 
                     autofocus
                     autocomplete="username">
            </div>
          </div>

          <!-- Password Field -->
          <div class="form-group">
            <label for="member_pass" class="form-label">
              <i class="fas fa-shield-alt text-primary"></i> รหัสผ่าน (Password)
            </label>
            <div class="input-wrapper">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" 
                     name="member_pass" 
                     id="member_pass" 
                     class="form-control form-control-modern" 
                     placeholder="กรอกรหัสผ่าน" 
                     required
                     autocomplete="current-password">
              <button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="แสดง/ซ่อนรหัสผ่าน" aria-label="Toggle password visibility">
                <i class="fas fa-eye" id="toggleIcon"></i>
              </button>
            </div>
          </div>

          <!-- Submit Button -->
          <button type="submit" id="btnSubmit" class="btn btn-login btn-block">
            <i class="fas fa-sign-in-alt"></i>
            <span id="btnSubmitText">เข้าสู่ระบบ</span>
          </button>
        </form>

        <div class="divider"></div>

        <div class="text-center">
          <a href="../index.php" class="back-home-link">
            <i class="fas fa-arrow-left"></i>
            <span>กลับสู่หน้าหลักเว็บไซต์</span>
          </a>
        </div>
      </div>
    </div>

    <div class="login-footer-text">
      &copy; <?= date("Y"); ?> AMULET System. สงวนลิขสิทธิ์ทั้งหมด
    </div>
  </div>

  <!-- Scripts -->
  <script src="../a/vendor/jquery/jquery.min.js"></script>
  <script src="../a/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 for modern alert dialogs -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function () {
      // Toggle Password Visibility
      $('#togglePasswordBtn').on('click', function () {
        const passwordInput = $('#member_pass');
        const toggleIcon = $('#toggleIcon');
        const isPassword = passwordInput.attr('type') === 'password';

        passwordInput.attr('type', isPassword ? 'text' : 'password');
        toggleIcon.toggleClass('fa-eye', !isPassword);
        toggleIcon.toggleClass('fa-eye-slash', isPassword);
      });

      // Handle Login Form via AJAX
      $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        const member_user = $.trim($('#member_user').val());
        const member_pass = $.trim($('#member_pass').val());
        const btnSubmit = $('#btnSubmit');
        const originalBtnHtml = '<i class="fas fa-sign-in-alt"></i> <span>เข้าสู่ระบบ</span>';

        if (!member_user || !member_pass) {
          Swal.fire({
            icon: 'warning',
            title: 'แจ้งเตือน',
            text: 'กรุณากรอกชื่อผู้ใช้และรหัสผ่านให้ครบถ้วน',
            confirmButtonColor: '#1e3c72',
            confirmButtonText: 'ตกลง'
          });
          return;
        }

        // Disable button & show spinner
        btnSubmit.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> <span>กำลังตรวจสอบข้อมูล...</span>');

        $.ajax({
          url: 'logincheck.php',
          type: 'POST',
          dataType: 'json',
          data: {
            member_user: member_user,
            member_pass: member_pass,
            ajax: 1
          },
          success: function (response) {
            if (response && response.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'เข้าสู่ระบบสำเร็จ',
                text: response.message || 'กำลังเข้าสู่ระบบ...',
                timer: 1300,
                showConfirmButton: false,
                timerProgressBar: true
              }).then(function () {
                window.location.href = response.redirect || '../a/index.php';
              });
            } else {
              // Restore button
              btnSubmit.prop('disabled', false).html(originalBtnHtml);

              Swal.fire({
                icon: 'error',
                title: 'เข้าสู่ระบบไม่สำเร็จ',
                text: response.message || 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
                confirmButtonColor: '#1e3c72',
                confirmButtonText: 'ลองใหม่อีกครั้ง'
              }).then(function () {
                $('#member_pass').val('').focus();
              });
            }
          },
          error: function (xhr, status, error) {
            // Restore button
            btnSubmit.prop('disabled', false).html(originalBtnHtml);

            console.error('AJAX Login Error:', status, error, xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
              text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
              confirmButtonColor: '#1e3c72',
              confirmButtonText: 'ตกลง'
            });
          }
        });
      });
    });
  </script>
</body>

</html>
