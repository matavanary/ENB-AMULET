
		<!-- เปิดโค้ดเมนู -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
<?php
$str = $_SESSION["member_name"];
$name= explode(" ",$str);
$rsname0 = $name[0];
// $rsname1 = $name[1]; 
?>
<!-- โลโก้ -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="" value="Refresh" ><h1><?php echo $rsname0;?></h1></a>



<!-- เส้น-หน้าหลัก -->
<hr class="sidebar-divider my-0">
<li class="nav-item">
  <a class="nav-link" href="../card">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>หน้าหลัก</span>
  </a>
</li>
<?php $status=$_SESSION["status"]; ?>
<?php if($status=='1'){ ?>
<!-- เส้น-ส่วนตัว -->
<hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link" href="../admin">
      <i class="fas fa-fw fa-unlock-alt"></i>
      <span>สิทธิ์การเข้าถึง</span>
    </a>
  </li>
<?php } ?>

<!-- เส้น-ส่วนตัว -->
<hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-sign-out-alt"></i>
      <span>ออกจากระบบ</span>
    </a>
  </li>


<!-- เส้น-ปิด -->
<hr class="sidebar-divider d-none d-md-block">

<!-- ลูกศรย่อแถบเมนู -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">พร้อมที่จะออกหรือยัง?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">เลือก "ออกจากระบบ" ด้านล่างหากคุณพร้อมที่จะสิ้นสุดการทำงานปัจจุบันของคุณ</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
          <a class="btn btn-danger" href="../../logout.php">ออกจากระบบ</a>
        </div>
      </div>
    </div>
  </div>

</ul>
<!-- จบโค้ดเมนู -->