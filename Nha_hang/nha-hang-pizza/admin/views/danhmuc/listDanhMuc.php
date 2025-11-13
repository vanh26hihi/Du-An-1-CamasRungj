
<!-- header  -->
 <?php require_once './views/layout/header.php';?>
  <!-- Navbar -->
 <?php require_once './views/layout/navbar.php';?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 <?php require_once './views/layout/sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Quản lý Danh Mục Sản Phẩm</h1>
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
                <a href="<?= BASE_URL_ADMIN."?act=form-them-danh-muc" ?>">
                  <button class="btn btn-success">Thêm Danh Mục</button>
                </a>
              </div>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên Danh Mục</th>
                    <th>Mô Tả</th>
                    <th>Thao Tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($listDanhMuc as $key=>$danhmuc):?>
                  <tr>
                    <td class="text-center"><?=$key + 1?></td>
                    <td><?=$danhmuc['ten_danh_muc']?></td>
                    <td class="text-truncate" style="max-width: 400px;"><?=$danhmuc['mo_ta']?></td>
                    <td class="text-center">
                      <a href="<?= BASE_URL_ADMIN."?act=form-sua-danh-muc&id_danh_muc=".$danhmuc['id']; ?>">
                        <button class="btn btn-warning">Sửa</button>
                      </a>
                      <a href="<?= BASE_URL_ADMIN."?act=xoa-danh-muc&id_danh_muc=".$danhmuc['id']; ?>"
                       onclick="return confirm('Bạn Có Muốn Đong Ý Xóa Hay Không')">
                        <button class="btn btn-danger" >Xóa</button>
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>STT</th>
                    <th>Tên Danh Mục</th>
                    <th>Mô Tả</th>
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
 <?php require_once './views/layout/footer.php';?>
  <!-- End Footer  -->
<!-- Page specific script -->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
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
