
<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>

<style>
  .hdv-item {
    display: inline-block;
    background-color: #17a2b8;
    color: white;
    padding: 5px 10px;
    margin: 3px;
    border-radius: 5px;
    font-size: 13px;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> Quản lý tour</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <!-- Kiểm Tra Kết quả Của Delete -->
              <?php if (isset($_GET['msg'])): ?>
                <script>
                  <?php if ($_GET['msg'] == 'success'): ?>
                    alert("✅ Đã xóa sản phẩm thành công!");
                  <?php else: ?>
                    alert("❌ Xóa sản phẩm thất bại!");
                  <?php endif; ?>
                  if (window.history.replaceState) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('msg');
                    window.history.replaceState(null, '', url.toString());
                  }
                </script>
                </script>
              <?php endif; ?>
              <div class="content-header">
                <a href="<?= BASE_URL_ADMIN . "?act=form-them-tour" ?>">
                  <button class="btn btn-success"><i class="fas fa-plus"></i> Thêm tour</button>
                </a>
              </div>
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead class="thead-light text-center">
                  <tr>
                    <th>STT</th>
                    <th>Tên tour</th>
                    <th>Giá cơ bản</th>
                    <th>Điểm khởi hành</th>
                    <th>Ngày bắt đầu</th>
                    <th>Hướng dẫn viên</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listTour as $key => $tour): ?>
                    <tr>
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td><?= htmlspecialchars($tour['ten_tour']) ?></td>
                      <td><?= isset($tour['gia_co_ban']) ? number_format((float)$tour['gia_co_ban'], 0, ',', '.') . ' VND' : '' ?></td>
                      <td><?= htmlspecialchars($tour['diem_khoi_hanh'] ?? '') ?></td>
                      <td><?= $tour['ngay_bat_dau'] ? date('d/m/Y', strtotime($tour['ngay_bat_dau'])) : 'N/A' ?></td>
                      <td>
                        <?php if (!empty($tour['danh_sach_hdv'])): ?>
                          <?php
                          $danhSachHDV = explode(', ', $tour['danh_sach_hdv']);
                          foreach ($danhSachHDV as $hdv):
                          ?>
                            <span class="hdv-item"><?= htmlspecialchars($hdv) ?></span>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <span class="text-muted">Chưa có HDV</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <a href="<?= BASE_URL_ADMIN . '?act=tour-detail&id=' . $tour['tour_id'] ?>" class="mb-1" target="_blank">
                          <button class="btn btn-primary btn-sm" title="Xem chi tiết tour"><i class="fas fa-eye"></i> Xem chi tiết</button>
                        </a>
                        <a href="<?= BASE_URL_ADMIN . '?act=copy-tour&tour_id=' . $tour['tour_id'] ?>" class="mb-1">
                          <button class="btn btn-info btn-sm" title="Tạo lịch mới cho tour"><i class="fas fa-calendar-plus"></i> Lịch mới</button>
                        </a>
                        <?php if (!empty($tour['lich_id'])): ?>
                          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-tour&lich_id=' . $tour['lich_id'] ?>" class="mb-1">
                            <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                          </a>
                          <a href="<?= BASE_URL_ADMIN . '?act=xoa-tour&lich_id=' . $tour['lich_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch khởi hành này không?');" class="mb-1">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                          </a>
                        <?php else: ?>
                          <span class="text-muted">Chưa có lịch</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
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
