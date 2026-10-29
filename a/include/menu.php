<?php
// กำหนดข้อมูลผู้ใช้งานอย่างปลอดภัย
$memberName = !empty($_SESSION["member_name"]) ? $_SESSION["member_name"] : (!empty($objResult["member_name"]) ? $objResult["member_name"] : 'ผู้ดูแลระบบ');
$nameParts  = explode(" ", trim($memberName));
$firstName  = htmlspecialchars($nameParts[0], ENT_QUOTES, 'UTF-8');
$userStatus = isset($_SESSION["status"]) ? strval($_SESSION["status"]) : (isset($objResult["status"]) ? strval($objResult["status"]) : '2');
$roleLabel  = ($userStatus === '1') ? 'ผู้ดูแลระบบ' : 'เจ้าหน้าที่';
$roleBadgeClass = ($userStatus === '1') ? 'badge-warning text-dark' : 'badge-light text-primary';

// ตรวจสอบหน้าปัจจุบันเพื่อตั้งค่าสถานะ Active ในเมนู
$currentScript = basename($_SERVER['PHP_SELF']);
$currentDir    = basename(dirname($_SERVER['PHP_SELF']));

$isCardActive    = ($currentDir === 'card' && $currentScript !== 'add_card.php') || ($currentDir === 'add_card_image');
$isAddCardActive = ($currentDir === 'card' && $currentScript === 'add_card.php');
$isAdminActive   = ($currentDir === 'admin');
?>

<style>
/* Modern SB Admin 2 Sidebar Styling */
#accordionSidebar.sidebar-modern {
  background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%) !important;
  box-shadow: 2px 0 12px rgba(0, 0, 0, 0.08);
  border-right: 1px solid rgba(255, 255, 255, 0.05);
  transition: all 0.25s ease-in-out;
}

#accordionSidebar .sidebar-brand {
  height: 5rem;
  padding: 1rem 1.25rem;
  letter-spacing: 0.03rem;
  text-decoration: none;
  background: rgba(255, 255, 255, 0.02);
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

#accordionSidebar .brand-icon-box {
  width: 42px;
  height: 42px;
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: #ffffff;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  box-shadow: 0 4px 10px rgba(245, 158, 11, 0.35);
  flex-shrink: 0;
  transition: transform 0.2s ease;
}

#accordionSidebar .sidebar-brand:hover .brand-icon-box {
  transform: rotate(5deg) scale(1.05);
}

#accordionSidebar .brand-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #ffffff;
  letter-spacing: 0.05rem;
  line-height: 1.2;
}

#accordionSidebar .brand-subtitle {
  font-size: 0.7rem;
  color: #94a3b8;
  font-weight: 400;
  display: block;
  letter-spacing: 0.02rem;
}

/* User mini profile in sidebar */
.sidebar-user-card {
  padding: 0.85rem 1rem;
  margin: 0.85rem 0.85rem 0.25rem 0.85rem;
  background: rgba(255, 255, 255, 0.04);
  border-radius: 0.75rem;
  border: 1px solid rgba(255, 255, 255, 0.06);
  display: flex;
  align-items: center;
}

.sidebar-user-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 0.95rem;
  margin-right: 0.75rem;
  flex-shrink: 0;
  box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
}

.sidebar-user-info {
  line-height: 1.25;
  overflow: hidden;
}

.sidebar-user-name {
  font-size: 0.825rem;
  font-weight: 600;
  color: #f1f5f9;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Nav Item Modern Styling */
#accordionSidebar .nav-item {
  margin: 0.2rem 0.6rem;
}

#accordionSidebar .nav-item .nav-link {
  padding: 0.65rem 0.9rem;
  border-radius: 0.5rem;
  color: #cbd5e1;
  font-size: 0.875rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  transition: all 0.2s ease-in-out;
}

#accordionSidebar .nav-item .nav-link i {
  font-size: 1rem;
  width: 1.75rem;
  text-align: center;
  margin-right: 0.5rem;
  color: #94a3b8;
  transition: all 0.2s ease;
}

#accordionSidebar .nav-item:hover .nav-link {
  background: rgba(255, 255, 255, 0.08);
  color: #ffffff;
}

#accordionSidebar .nav-item:hover .nav-link i {
  color: #38bdf8;
  transform: translateX(2px);
}

/* Active Nav Link */
#accordionSidebar .nav-item.active .nav-link {
  background: linear-gradient(90deg, rgba(56, 189, 248, 0.2) 0%, rgba(56, 189, 248, 0.05) 100%);
  color: #ffffff !important;
  font-weight: 600;
  border-left: 3px solid #38bdf8;
}

#accordionSidebar .nav-item.active .nav-link i {
  color: #38bdf8 !important;
}

/* Section Headings */
#accordionSidebar .sidebar-heading {
  font-size: 0.675rem;
  font-weight: 700;
  letter-spacing: 0.08rem;
  text-transform: uppercase;
  color: #64748b;
  padding: 0.85rem 1.25rem 0.35rem 1.25rem;
}

#accordionSidebar hr.sidebar-divider {
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  margin: 0.65rem 0.85rem;
}

/* Modern Logout Modal */
#logoutModal .modal-content {
  border-radius: 1rem;
  border: none;
  overflow: hidden;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

#logoutModal .modal-header {
  border-bottom: 1px solid #f1f5f9;
  background-color: #f8fafc;
  padding: 1.25rem 1.5rem;
}

#logoutModal .logout-icon-circle {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  background-color: #fee2e2;
  color: #ef4444;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  margin: 0 auto 1rem auto;
}

/* Adjustments for toggled sidebar */
#accordionSidebar.toggled .sidebar-user-card,
#accordionSidebar.toggled .brand-subtitle,
#accordionSidebar.toggled .brand-title {
  display: none !important;
}

#accordionSidebar.toggled .brand-icon-box {
  margin: 0 auto;
}
</style>

<!-- เปิดโค้ดเมนู Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion sidebar-modern" id="accordionSidebar">

  <!-- โลโก้แบรนด์ -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../card/index.php" title="ระบบจัดการบัตรรับรองพระเครื่อง">
    <div class="brand-icon-box mr-2">
      <i class="fas fa-award"></i>
    </div>
    <div class="sidebar-brand-text text-left">
      <div class="brand-title">ENB AMULET</div>
      <span class="brand-subtitle">ระบบจัดการพระเครื่อง</span>
    </div>
  </a>

  <!-- แสดงผู้ใช้งานใน Sidebar -->
  <div class="sidebar-user-card d-none d-md-flex">
    <div class="sidebar-user-avatar">
      <?php echo mb_substr($firstName, 0, 1, 'UTF-8'); ?>
    </div>
    <div class="sidebar-user-info">
      <div class="sidebar-user-name" title="<?php echo htmlspecialchars($memberName, ENT_QUOTES, 'UTF-8'); ?>">
        <?php echo $firstName; ?>
      </div>
      <span class="badge <?php echo $roleBadgeClass; ?> px-2 py-0" style="font-size: 0.68rem; font-weight: 500;">
        <i class="fas fa-circle text-success mr-1" style="font-size: 6px;"></i><?php echo $roleLabel; ?>
      </span>
    </div>
  </div>

  <hr class="sidebar-divider">

  <!-- หมวดหมู่: จัดการข้อมูลบัตร -->
  <div class="sidebar-heading">จัดการข้อมูลบัตร</div>

  <!-- เมนู: หน้ารายการบัตร -->
  <li class="nav-item <?php echo $isCardActive ? 'active' : ''; ?>">
    <a class="nav-link" href="../card/index.php">
      <i class="fas fa-id-card"></i>
      <span>รายการบัตรรับรอง</span>
    </a>
  </li>

  <!-- เมนู: ออกบัตรใหม่ -->
  <li class="nav-item <?php echo $isAddCardActive ? 'active' : ''; ?>">
    <a class="nav-link" href="../card/add_card.php">
      <i class="fas fa-plus-circle"></i>
      <span>ออกบัตรรับรองใหม่</span>
    </a>
  </li>

  <?php if ($userStatus === '1'): ?>
  <hr class="sidebar-divider">
  <!-- หมวดหมู่: ผู้ดูแลระบบ -->
  <div class="sidebar-heading">ผู้ดูแลระบบ</div>

  <!-- เมนู: จัดการสิทธิ์การเข้าถึง -->
  <li class="nav-item <?php echo $isAdminActive ? 'active' : ''; ?>">
    <a class="nav-link" href="../admin/index.php">
      <i class="fas fa-user-shield"></i>
      <span>จัดการผู้ใช้และสิทธิ์</span>
    </a>
  </li>
  <?php endif; ?>

  <hr class="sidebar-divider">

  <!-- หมวดหมู่: เว็บไซต์ & ระบบ -->
  <div class="sidebar-heading">ทางลัด & ระบบ</div>

  <!-- เมนู: ไปหน้าค้นหาพระเครื่อง (หน้าเว็บไซต์) -->
  <li class="nav-item">
    <a class="nav-link" href="../../../index.php" target="_blank" rel="noopener noreferrer">
      <i class="fas fa-external-link-alt"></i>
      <span>ดูหน้าเว็บไซต์หลัก</span>
    </a>
  </li>

  <!-- เมนู: ออกจากระบบ -->
  <li class="nav-item">
    <a class="nav-link text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-sign-out-alt text-danger"></i>
      <span class="font-weight-bold">ออกจากระบบ</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  <!-- ปุ่มย่อ/ขยายเมนู Sidebar -->
  <div class="text-center d-none d-md-inline mb-3">
    <button class="rounded-circle border-0" id="sidebarToggle" title="ย่อ/ขยายแถบเมนู"></button>
  </div>

</ul>
<!-- จบโค้ดเมนู Sidebar -->

<!-- Logout Modal โมดอลยืนยันการออกจากระบบ -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold text-gray-800" id="logoutModalLabel">
          <i class="fas fa-question-circle text-primary mr-1"></i> ยืนยันการออกจากระบบ
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center py-4">
        <div class="logout-icon-circle">
          <i class="fas fa-sign-out-alt"></i>
        </div>
        <h5 class="font-weight-bold text-gray-800 mb-2">คุณต้องการออกจากระบบหรือไม่?</h5>
        <p class="text-muted small mb-0">หากออกจากระบบ เซสชันการทำงานปัจจุบันจะถูกยกเลิกทันที</p>
      </div>
      <div class="modal-footer bg-light justify-content-center">
        <button class="btn btn-secondary px-4 rounded-pill" type="button" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i> ยกเลิก
        </button>
        <a class="btn btn-danger px-4 rounded-pill" href="../../logout.php">
          <i class="fas fa-sign-out-alt mr-1"></i> ออกจากระบบ
        </a>
      </div>
    </div>
  </div>
</div>
