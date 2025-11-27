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
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> Quản lý danh mục tour</h1>
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
                <a href="<?= BASE_URL_ADMIN . "?act=form-them-danh-muc" ?>">
                  <button class="btn btn-success">Thêm danh mục tour</button>
                </a>
              </div>
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead class="thead-light text-center">
                  <tr>
                    <th>STT</th>
                    <th>Tên tour</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Giá cơ bản</th>
                    <th>Chính sách</th>
                    <th>Điểm khởi hành</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listDanhMuc as $key => $row): ?>
                    <tr>
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td><?= $row['ten_tour'] ?? '' ?></td>
                      <td><?= $row['ten_danh_muc'] ?? '' ?></td>
                      <td><?= $row['mo_ta'] ?? '' ?></td>
                      <td><?= formatPrice($row['gia_co_ban']) ?></td>
                      <td><?= $row['chinh_sach'] ?? '' ?></td>
                      <td><?= $row['diem_khoi_hanh'] ?? '' ?></td>

                      <td class="text-center">
                        <a href="<?= BASE_URL_ADMIN . '?act=form-sua-danh-muc&id=' . $row['tour_id'] ?>" class="btn btn-sm btn-outline-primary" title="Sửa">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL_ADMIN . '?act=xoa-tour&tour_id=' . $row['tour_id'] ?>" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?');">
                          <i class="fas fa-trash-alt"></i>
                        </a>

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