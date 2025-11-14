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
          <h1> Quản lý Booking Sản Phẩm</h1>
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
              <div class="col-12 col-sm-12">
                <div class="card card-primary card-tabs">
                  <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Tùy Chỉnh Booking</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Profile</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Messages</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                      <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <a href="<?= BASE_URL_ADMIN . "?act=form-them-booking" ?>">
                          <button class="btn btn-success">Thêm Booking</button>
                        </a>
                        <table id="example1" class="table table-bordered table-striped table-hover">
                          <thead class="thead-light text-center">
                            <tr>
                              <th>STT</th>
                              <th>Mã Booking</th>
                              <th>Tên Khách Hàng</th>
                              <th>Tên tour</th>
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
                                <td class="text-center"><?= $key + 1 ?></td>
                                <td class="text-center"><?= $Booking['dat_tour_id'] ?></td>
                                <td><?= htmlspecialchars($Booking['ten_khach_hang']) ?></td>
                                <td><?= htmlspecialchars($Booking['ten_tour']) ?></td>
                                <td class="text-center"><?= tinhNgayDem($Booking['ngay_bat_dau'], $Booking['ngay_ket_thuc']) ?></td>
                                <td class="text-center">
                                  <?= $Booking['loai'] == "group" ? "Cá Nhân" : "Theo Nhóm" ?>
                                </td>
                                <td class="text-center"><?= $Booking['so_nguoi'] ?></td>
                                <td><?= formatPrice($Booking['tong_tien']) ?></td>
                                <td><?= htmlspecialchars($Booking['ten_trang_thai']) ?></td>
                                <td class="text-center">
                                  <a href="<?= BASE_URL_ADMIN . '?act=form-sua-booking&id_booking=' . $Booking['dat_tour_id'] ?>">
                                    <button class="btn btn-primary btn-sm">Sửa</button>
                                  </a>
                                  <a href="<?= BASE_URL_ADMIN . '?act=xoa-booking&id_booking=' . $Booking['dat_tour_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa Booking này không?');">
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                  </a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>

                      </div>
                      <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                        Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
              </div>

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