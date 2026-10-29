<?php
// กำหนดข้อมูลผู้ใช้งานอย่างปลอดภัยหากยังไม่ได้กำหนดจากเมนู
if (!isset($memberName)) {
    $memberName = !empty($_SESSION["member_name"]) ? $_SESSION["member_name"] : (!empty($objResult["member_name"]) ? $objResult["member_name"] : 'ผู้ดูแลระบบ');
    $nameParts  = explode(" ", trim($memberName));
    $firstName  = htmlspecialchars($nameParts[0], ENT_QUOTES, 'UTF-8');
    $userStatus = isset($_SESSION["status"]) ? strval($_SESSION["status"]) : (isset($objResult["status"]) ? strval($objResult["status"]) : '2');
}
?>

<style>
/* Modern Topbar Styling */
.modern-topbar {
  background: #ffffff !important;
  border-bottom: 1px solid #e2e8f0;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px 0 rgba(0, 0, 0, 0.02) !important;
  min-height: 4.375rem;
  padding: 0.5rem 1.25rem;
}

.topbar-institute-box {
  display: flex;
  align-items: center;
}

.topbar-institute-icon {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
  border: 1px solid #bfdbfe;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #2563eb;
  font-size: 1.15rem;
  margin-right: 0.75rem;
  flex-shrink: 0;
}

.topbar-institute-title {
  font-size: 1.05rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
  line-height: 1.25;
  letter-spacing: -0.01em;
}

.topbar-institute-desc {
  font-size: 0.75rem;
  color: #64748b;
  margin: 0;
  line-height: 1;
}

/* User Avatar & Status */
.topbar-avatar-container {
  position: relative;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 1rem;
  box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.topbar-avatar-container:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(79, 70, 229, 0.35);
}

.topbar-avatar-status {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 10px;
  height: 10px;
  background-color: #10b981;
  border: 2px solid #ffffff;
  border-radius: 50%;
}

/* Dropdown Menu Polish */
.topbar .dropdown-menu {
  border-radius: 0.75rem;
  border: 1px solid #e2e8f0;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
  min-width: 15rem;
  padding: 0.5rem 0;
}

.topbar .dropdown-item {
  padding: 0.6rem 1.25rem;
  font-size: 0.85rem;
  font-weight: 500;
  color: #475569;
  transition: all 0.15s ease;
  display: flex;
  align-items: center;
}

.topbar .dropdown-item:hover {
  background-color: #f8fafc;
  color: #1e293b;
}

.topbar .dropdown-item.text-danger:hover {
  background-color: #fee2e2;
  color: #ef4444;
}

.topbar .dropdown-item i {
  width: 1.5rem;
  text-align: center;
}

@media (max-width: 576px) {
  .topbar-institute-desc {
    display: none;
  }
  .topbar-institute-title {
    font-size: 0.95rem;
  }
}
</style>

<!-- เปิดโค้ดแถบบาร์ด้านบน Modern Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top modern-topbar">

  <!-- ปุ่มย่อ/ขยาย Sidebar สำหรับมือถือ -->
  <button id="sidebarToggleTop" class="btn btn-light btn-circle mr-3 d-md-none text-primary" title="เปิด/ปิดเมนู">
    <i class="fa fa-bars"></i>
  </button>

  <!-- ชื่อสถาบัน & สัญลักษณ์ -->
  <div class="topbar-institute-box">
    <div class="topbar-institute-icon d-none d-sm-flex">
      <i class="fas fa-certificate"></i>
    </div>
    <div>
      <h1 class="topbar-institute-title">สถาบันรับรองพระเครื่องเมืองชลฯ</h1>
      <p class="topbar-institute-desc">ระบบออกบัตรรับรองพระแท้และจัดการข้อมูลพระเครื่อง</p>
    </div>
  </div>

  <!-- แถบเมนูด้านขวา -->
  <ul class="navbar-nav ml-auto align-items-center">

    <!-- ปุ่มเปิดหน้าค้นหาพระเครื่อง (หน้าบ้าน) -->
    <li class="nav-item d-none d-md-block mr-2">
      <a class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 font-weight-medium" 
         href="../../../index.php" 
         target="_blank" 
         rel="noopener noreferrer" 
         title="เปิดดูหน้าแรกของเว็บไซต์สาธารณะ">
        <i class="fas fa-globe mr-1"></i> ดูหน้าเว็บไซต์
      </a>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- เมนูข้อมูลผู้ใช้งาน (User Dropdown) -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle py-0" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="d-none d-lg-flex flex-column text-right mr-3">
          <span class="text-gray-800 font-weight-bold small line-height-1 mb-1">
            <?php echo htmlspecialchars($memberName, ENT_QUOTES, 'UTF-8'); ?>
          </span>
          <div>
            <span class="badge <?php echo ($userStatus === '1') ? 'badge-primary' : 'badge-secondary'; ?> px-2 py-0" style="font-size: 0.68rem; font-weight: 500;">
              <?php echo ($userStatus === '1') ? 'ผู้ดูแลระบบ' : 'เจ้าหน้าที่'; ?>
            </span>
          </div>
        </div>
        <div class="topbar-avatar-container">
          <span><?php echo mb_substr($firstName, 0, 1, 'UTF-8'); ?></span>
          <span class="topbar-avatar-status"></span>
        </div>
      </a>

      <!-- รายการดรอปดาวน์ -->
      <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="userDropdown">
        <div class="px-3 py-2 border-bottom bg-light">
          <div class="font-weight-bold text-gray-800"><?php echo htmlspecialchars($memberName, ENT_QUOTES, 'UTF-8'); ?></div>
          <div class="small text-muted">
            สถานะ: <?php echo ($userStatus === '1') ? 'ผู้ดูแลระบบ (Admin)' : 'เจ้าหน้าที่ (Staff)'; ?>
          </div>
        </div>

        <a class="dropdown-item mt-1" href="../card/index.php">
          <i class="fas fa-id-card text-primary"></i> รายการบัตรรับรอง
        </a>
        <a class="dropdown-item" href="../card/add_card.php">
          <i class="fas fa-plus-circle text-success"></i> ออกบัตรรับรองใหม่
        </a>

        <?php if ($userStatus === '1'): ?>
        <a class="dropdown-item" href="../admin/index.php">
          <i class="fas fa-users-cog text-info"></i> จัดการผู้ใช้และสิทธิ์
        </a>
        <?php endif; ?>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="../../../index.php" target="_blank" rel="noopener noreferrer">
          <i class="fas fa-external-link-alt text-secondary"></i> เปิดดูหน้าเว็บไซต์หลัก
        </a>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt text-danger"></i> ออกจากระบบ
        </a>
      </div>
    </li>

  </ul>

</nav>
<!-- ปิดโค้ดแถบบาร์ด้านบน -->
