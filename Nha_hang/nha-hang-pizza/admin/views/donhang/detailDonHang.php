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
        <div class="col-sm-10">
          <h1> Quản lý Danh Sách Đơn Hàng - Đơn Hàng: <?= $DonHang['ma_don_hang'] ?></h1>
        </div>
        <div class="col-sm-2">
          <form action="" method="post">
            <select name="" class="form-group form-control" id="">
              <?php foreach ($trangThai as $key => $trangThai): ?>
                <option
                  <?= $trangThai['id'] == $DonHang['trang_thai_id'] ? 'selected' : '' ?>
                  <?= $trangThai['id'] < $DonHang['trang_thai_id'] ? 'disabled' : '' ?>
                  value="<?= $trangThai['id'] ?>">
                  <?= $trangThai['ten_trang_thai'] ?>
                </option>
              <?php endforeach ?>
            </select>
          </form>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php
          if ($DonHang['trang_thai_id'] == 1) {
            $colorAlerts = 'primary';
          } else if ($DonHang['trang_thai_id'] >= 2 && $DonHang['trang_thai_id'] <= 9) {
            $colorAlerts = 'warning';
          } else if ($DonHang['trang_thai_id'] == 10) {
            $colorAlerts = 'success';
          } else {
            $colorAlerts = 'danger';
          }
          ?>
          <div class="alert alert-<?= $colorAlerts ?>" role="alert">
            Đơn Hàng: <?= $DonHang['ten_trang_thai'] ?>
          </div>


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-pizza-slice"></i> Nhà Hàng Pizza Home-Namld
                  <small class="float-right">Ngày Đặt: <?= formatDate($DonHang['ngay_dat']) ?> </small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                Thông tin người đặt
                <address>
                  <strong><?= $DonHang['ho_ten'] ?></strong><br>
                  Email:<?= $DonHang['email'] ?><br>
                  Số Điện Thoại<?= $DonHang['so_dien_thoai'] ?><br>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                Người Nhận
                <address>
                  <strong><?= $DonHang['ten_nguoi_nhan'] ?></strong><br>
                  Email:<?= $DonHang['email_nguoi_nhan'] ?><br>
                  Số Điện Thoại: <?= $DonHang['sdt_nguoi_nhan'] ?><br>
                  Địa Chỉ: <?= $DonHang['dia_chi_nguoi_nhan'] ?><br>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                Thông Tin
                <address>
                  <strong>Mã Đơn Hàng:<?= $DonHang['ma_don_hang'] ?></strong><br>
                  Tổng Tiền:<?= number_format($DonHang['tong_tien']) ?><br>
                  Ghi Chú: <?= $DonHang['ghi_chu'] ?><br>
                  Phương Thức Thanh Toán: <?= $DonHang['ten_phuong_thuc'] ?><br>
                </address>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tên sản phẩm</th>
                      <th>Đơn giá</th>
                      <th>Số lượng</th>
                      <th>Thành Tiền</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $tong_tien = 0;
                    foreach ($sanPhamDonHang as $key => $sanPham):  ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $sanPham['ten_san_pham'] ?></td>
                        <td><?= $sanPham['don_gia'] ?></td>
                        <td><?= $sanPham['so_luong'] ?></td>
                        <td><?= $sanPham['thanh_tien'] ?></td>
                        <?php $tong_tien += $sanPham['thanh_tien'] ?>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- /.col -->
              <div class="col-6">
                <p class="lead">Ngày đặt hàng: <?= formatDate($DonHang['ngay_dat']) ?></p>

                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Thành tiền:</th>
                      <td><?= number_format($tong_tien) ?></td>
                    </tr>
                    <tr>
                      <th>Phí vận chuyển:</th>
                      <td>200.000</td>
                    </tr>
                    <tr>
                      <th>Tổng Tiền</th>
                      <td><?= number_format($tong_tien + 50000) ?></td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
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