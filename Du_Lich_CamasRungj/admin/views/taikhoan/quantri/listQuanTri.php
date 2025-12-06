<?php require_once './views/layout/header.php'; ?>
<?php require_once './views/layout/navbar.php'; ?>
<?php require_once './views/layout/sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Quản Lý Tài Khoản Quản Trị</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?act=/">Trang chủ</a></li>
            <li class="breadcrumb-item active">Quản lý tài khoản quản trị</li>
          </ol>
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
            <div class="card-header">
              <a href="<?= BASE_URL_ADMIN . "?act=form-them-quan-tri" ?>">
                <button class="btn btn-success">
                  <i class="fas fa-plus"></i> Thêm Tài Khoản Quản Trị
                </button>
              </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <!-- Success Message -->
              <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= $_SESSION['success'] ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php unset($_SESSION['success']); ?>
              <?php endif; ?>

              <!-- Error Message -->
              <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php 
                  if (is_array($_SESSION['error'])) {
                    echo implode('<br>', $_SESSION['error']);
                  } else {
                    echo $_SESSION['error'];
                  }
                  ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php unset($_SESSION['error']); ?>
              <?php endif; ?>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listQuanTri as $key => $quantri): ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td><?= htmlspecialchars($quantri['ho_ten']) ?></td>
                      <td><?= htmlspecialchars($quantri['email']) ?></td>
                      <td><?= htmlspecialchars($quantri['so_dien_thoai'] ?? 'Chưa cập nhật') ?></td>
                      <td>
                        <?php if ($quantri['trang_thai'] === 'active'): ?>
                          <span class="badge badge-success">Hoạt động</span>
                        <?php else: ?>
                          <span class="badge badge-danger">Khóa</span>
                        <?php endif; ?>
                      </td>
                      <td><?= date('d/m/Y H:i', strtotime($quantri['ngay_tao'])) ?></td>
                      <td>
                        <div class="btn-group">
                          <a href="<?= BASE_URL_ADMIN . "?act=form-sua-quan-tri&id=" . $quantri['nguoi_dung_id'] ?>" 
                             class="btn btn-warning btn-sm" 
                             title="Sửa">
                            <i class="fas fa-edit"></i>
                          </a>
                          
                            <a href="<?= BASE_URL_ADMIN . "?act=reset-password-quan-tri&id=" . $quantri['nguoi_dung_id'] ?>" 
                              class="btn btn-info btn-sm" 
                              title="Reset Mật Khẩu"
                              onclick="return sweetConfirmDelete(event, 'Bạn có chắc muốn reset mật khẩu về mặc định (123@123ab)?')">
                            <i class="fas fa-key"></i>
                          </a>
                          
                          <?php if ($quantri['nguoi_dung_id'] != $_SESSION['user_admin']['nguoi_dung_id']): ?>
                             <a href="<?= BASE_URL_ADMIN . "?act=xoa-quan-tri&id=" . $quantri['nguoi_dung_id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               title="Xóa"
                               onclick="return sweetConfirmDelete(event, 'Bạn có chắc muốn xóa tài khoản này?')">
                              <i class="fas fa-trash"></i>
                            </a>
                          <?php else: ?>
                            <button class="btn btn-secondary btn-sm" 
                                    title="Không thể xóa chính mình" 
                                    disabled>
                              <i class="fas fa-trash"></i>
                            </button>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>STT</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Thao Tác</th>
                  </tr>
                </tfoot>
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
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "language": {
        "search": "Tìm kiếm:",
        "lengthMenu": "Hiển thị _MENU_ bản ghi",
        "info": "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
        "infoEmpty": "Hiển thị 0 đến 0 của 0 bản ghi",
        "infoFiltered": "(lọc từ _MAX_ bản ghi)",
        "zeroRecords": "Không tìm thấy bản ghi nào",
        "emptyTable": "Không có dữ liệu",
        "paginate": {
          "first": "Đầu",
          "last": "Cuối",
          "next": "Sau",
          "previous": "Trước"
        }
      }
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
<!-- Code injected by live-server -->
</body>

</html>
