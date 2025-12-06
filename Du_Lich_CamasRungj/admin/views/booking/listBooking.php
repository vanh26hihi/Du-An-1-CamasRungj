<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="page-header-custom">
        <h1><i class="fas fa-calendar-check"></i> Quản Lý Booking</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý Booking</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Alert Messages -->
      <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-custom alert-<?= $_GET['msg'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show">
          <i class="fas fa-<?= $_GET['msg'] == 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
          <?= $_GET['msg'] == 'success' ? 'Thao tác thành công!' : 'Thao tác thất bại!' ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <script>
          if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('msg');
            window.history.replaceState(null, '', url.toString());
          }
        </script>
      <?php endif; ?>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <a href="<?= BASE_URL_ADMIN . "?act=form-them-booking" ?>" class="btn btn-add-new">
          <i class="fas fa-plus"></i> Thêm Booking Mới
        </a>
      </div>

      <!-- Data Table Card -->
      <div class="card card-custom">
        <div class="card-header">
          <h3><i class="fas fa-list"></i> Danh Sách Booking</h3>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-custom table-hover">
            <thead>
              <tr>
                <th>STT</th>
                <th>Tên Khách Hàng</th>
                <th>Tên Tour</th>
                <th>Số Ngày</th>
                <th>Loại</th>
                <th>Số Người</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Thao Tác</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($listBooking as $key => $Booking): ?>
                <tr>
                  <td class="text-center"><strong><?= $key + 1 ?></strong></td>
                  <td><?= htmlspecialchars($Booking['ten_khach_hang']) ?></td>
                  <td><?= htmlspecialchars($Booking['ten_tour']) ?></td>
                  <td class="text-center"><?= tinhNgayDem($Booking['ngay_bat_dau'], $Booking['ngay_ket_thuc']) ?></td>
                  <td class="text-center">
                    <span class="badge badge-tour-type <?= $Booking['loai'] == "group" ? 'badge-group' : 'badge-individual' ?>">
                      <?= $Booking['loai'] == "group" ? "Theo Nhóm" : "Cá Nhân" ?>
                    </span>
                  </td>
                  <td class="text-center"><strong><?= $Booking['so_nguoi'] ?></strong></td>
                  <td class="price-text"><?= formatPrice($Booking['tong_tien']) ?></td>
                  <td>
                    <span class="badge badge-status badge-info"><?= htmlspecialchars($Booking['ten_trang_thai']) ?></span>
                  </td>
                  <td class="text-center">
                    <a href="<?= BASE_URL_ADMIN . '?act=booking-detail&id_booking=' . $Booking['dat_tour_id'] ?>" 
                       class="btn btn-info btn-action btn-sm" title="Xem chi tiết">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-booking&id_booking=' . $Booking['dat_tour_id'] ?>" 
                       class="btn btn-warning btn-action btn-sm" title="Sửa">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= BASE_URL_ADMIN . '?act=xoa-booking&id_booking=' . $Booking['dat_tour_id'] ?>" 
                       class="btn btn-danger btn-action btn-sm" 
                       onclick="return sweetConfirmDelete(event, 'Bạn có chắc chắn muốn xóa Booking này không?');"
                       title="Xóa">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>
<!-- /.content-wrapper -->
<!-- Footer -->
<!-- Code injected by live-server -->
</body>
<?php require_once './views/layout/footer.php'; ?>
<!-- End Footer  -->
<!-- Page specific script -->

<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</html>