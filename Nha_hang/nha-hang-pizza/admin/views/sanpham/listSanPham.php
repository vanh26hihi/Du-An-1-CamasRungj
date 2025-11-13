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
          <h1> Quản lý Sản Phẩm</h1>
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
              <a href="<?= BASE_URL_ADMIN . "?act=form-them-san-pham" ?>">
                <button class="btn btn-success">Thêm Sản Phẩm</button>
              </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Giá Tiền</th>
                    <th>Số Lượng</th>
                    <th>Danh Mục </th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($listSanPham as $key => $sanpham): ?>
                    <tr>
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td><?= $sanpham['ten_san_pham'] ?></td>
                      <td><img src="<?= BASE_URL . $sanpham['hinh_anh'] ?>" class="img-thumbnail" width="100" alt=""
                          onerror="this.onerror = null , this.src='http://localhost/Du-an-mau/img/images.png'"></td>
                      <td><?= number_format($sanpham['gia_san_pham'], 0, '.', ',') . ' vnđ' ?></td>
                      <td><?= $sanpham['so_luong'] ?></td>
                      <td><?= $sanpham['ten_danh_muc'] ?></td>
                      <td><?= $sanpham['ten_trang_thai'] ?></td>
                      <td class="text-center">
                        <div class="btn-group">
                          <a href="<?= BASE_URL_ADMIN . "?act=chi-tiet-san-pham&id=" . $sanpham['id_san_pham']; ?>">
                            <button class="btn btn-primary"><i class="far fa-eye"></i></button>
                          </a>
                          <a href="<?= BASE_URL_ADMIN . "?act=form-sua-san-pham&id=" . $sanpham['id_san_pham']; ?>">
                            <button class="btn btn-warning"><i class="fas fa-cogs"></i></button>
                          </a>
                          <a href="<?= BASE_URL_ADMIN . "?act=xoa-san-pham&id=" . $sanpham['id_san_pham']; ?>"
                            onclick="return confirm('Bạn Có Muốn Đong Ý Xóa Hay Không')">
                            <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                          </a>
                        </div>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>STT</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Giá Tiền</th>
                    <th>Số Lượng</th>
                    <th>Danh Mục </th>
                    <th>Trạng Thái</th>
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