<!-- header -->
<?php require_once './views/layout/header.php'; ?>
<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="page-header-custom">
        <h1><i class="fas fa-folder-open"></i> Quản Lý Danh Mục Tour</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý Danh Mục</li>
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
        <a href="<?= BASE_URL_ADMIN . "?act=form-them-danh-muc" ?>" class="btn btn-add-new">
          <i class="fas fa-plus"></i> Thêm Danh Mục Mới
        </a>
      </div>

      <!-- Data Table Card -->
      <div class="card card-custom">
        <div class="card-header">
          <h3><i class="fas fa-list"></i> Danh Sách Danh Mục & Tour</h3>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-custom table-hover">
            <thead>
              <tr>
                <th>STT</th>
                <th>Tên Tour</th>
                <th>Danh Mục</th>
                <th>Mô Tả</th>
                <th>Giá Cơ Bản</th>
                <th>Chính Sách</th>
                <th>Điểm Khởi Hành</th>
                <th>Thao Tác</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($listDanhMuc as $key => $row): ?>
                <tr>
                  <td class="text-center"><strong><?= $key + 1 ?></strong></td>
                  <td><strong><?= htmlspecialchars($row['ten_tour'] ?? '') ?></strong></td>
                  <td>
                    <span class="badge badge-status badge-info"><?= htmlspecialchars($row['ten_danh_muc'] ?? '') ?></span>
                  </td>
                  <td><?= htmlspecialchars($row['mo_ta'] ?? '') ?></td>
                  <td class="price-text"><?= formatPrice($row['gia_co_ban']) ?></td>
                  <td><?= htmlspecialchars($row['chinh_sach'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['diem_khoi_hanh'] ?? '') ?></td>
                  <td class="text-center">
                    <button class="btn btn-info btn-action btn-sm btn-preview" data-id="<?= $row['tour_id'] ?>" title="Xem chi tiết">
                      <i class="fas fa-eye"></i>
                    </button>
                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-danh-muc&id=' . $row['tour_id'] ?>" 
                       class="btn btn-warning btn-action btn-sm" title="Sửa">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= BASE_URL_ADMIN . '?act=xoa-tour&tour_id=' . $row['tour_id'] ?>" 
                       class="btn btn-danger btn-action btn-sm" title="Xóa" 
                       onclick="return sweetConfirmDelete(event, 'Bạn có chắc chắn muốn xóa mục này không?');">
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

<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
  $(document).on('click', '.btn-preview', function() {
    var tourId = $(this).data('id');
    $('#tourPreviewContent').html('<p class="text-muted">Đang tải...</p>');
    $('#tourPreviewOpenPage').attr('href', '#');
    $('#tourPreviewModal').modal('show');

    var adminPublic = '<?= BASE_URL_ADMIN ?>?act=public-tour&id=' + tourId;
    window.location.href = adminPublic;
  });
</script>
</body>
</html>
