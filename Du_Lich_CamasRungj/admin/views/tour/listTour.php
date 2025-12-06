
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
        <h1><i class="fas fa-map-marked-alt"></i> Quản Lý Tour</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý Tour</li>
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
        <a href="<?= BASE_URL_ADMIN . "?act=form-them-tour" ?>" class="btn btn-add-new">
          <i class="fas fa-plus"></i> Thêm Tour Mới
        </a>
      </div>

      <!-- Data Table Card -->
      <div class="card card-custom">
        <div class="card-header">
          <h3><i class="fas fa-list"></i> Danh Sách Tour</h3>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-custom table-hover">
            <thead>
              <tr>
                <th>STT</th>
                <th>Tên Tour</th>
                <th>Giá Cơ Bản</th>
                <th>Điểm Khởi Hành</th>
                <th>Ngày Bắt Đầu</th>
                <th>Hướng Dẫn Viên</th>
                <th>Thao Tác</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($listTour as $key => $tour): ?>
                <tr>
                  <td class="text-center"><strong><?= $key + 1 ?></strong></td>
                  <td><strong><?= htmlspecialchars($tour['ten_tour']) ?></strong></td>
                  <td class="price-text">
                    <?= isset($tour['gia_co_ban']) ? number_format((float)$tour['gia_co_ban'], 0, ',', '.') . ' VND' : 'N/A' ?>
                  </td>
                  <td><?= htmlspecialchars($tour['diem_khoi_hanh'] ?? '') ?></td>
                  <td class="text-center">
                    <?php if ($tour['ngay_bat_dau']): ?>
                      <span class="badge badge-status badge-info">
                        <?= date('d/m/Y', strtotime($tour['ngay_bat_dau'])) ?>
                      </span>
                    <?php else: ?>
                      <span class="badge badge-status badge-secondary">Chưa có</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($tour['danh_sach_hdv'])): ?>
                      <?php
                      $danhSachHDV = explode(', ', $tour['danh_sach_hdv']);
                      foreach ($danhSachHDV as $hdv):
                      ?>
                        <span class="badge-hdv"><?= htmlspecialchars($hdv) ?></span>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted"><i class="fas fa-user-slash"></i> Chưa có HDV</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <a href="<?= BASE_URL_ADMIN . '?act=tour-detail&id=' . $tour['tour_id'] ?>" 
                       class="btn btn-info btn-action btn-sm" title="Xem chi tiết" target="_blank">
                      <i class="fas fa-eye"></i>
                    </a>
                    <?php if (!empty($tour['lich_id'])): ?>
                      <a href="<?= BASE_URL_ADMIN . '?act=form-sua-tour&lich_id=' . $tour['lich_id'] ?>" 
                         class="btn btn-warning btn-action btn-sm" title="Sửa">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= BASE_URL_ADMIN . '?act=xoa-tour&lich_id=' . $tour['lich_id'] ?>" 
                         class="btn btn-danger btn-action btn-sm" 
                         onclick="return sweetConfirmDelete(event, 'Bạn có chắc chắn muốn xóa lịch khởi hành này không?');"
                         title="Xóa">
                        <i class="fas fa-trash"></i>
                      </a>
                    <?php else: ?>
                      <span class="badge badge-status badge-secondary">Chưa có lịch</span>
                    <?php endif; ?>
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
<!-- Code injected by live-server -->
</body>

</html>
