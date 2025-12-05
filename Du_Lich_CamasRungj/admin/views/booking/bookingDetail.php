<?php require_once './views/layout/header.php'; ?>
<?php require_once './views/layout/navbar.php'; ?>
<?php require_once './views/layout/sidebar.php'; ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Chi tiết Booking</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>?act=booking">Quản lý Booking</a></li>
            <li class="breadcrumb-item active">Chi tiết Booking</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Thông Tin Chi Tiết Booking
              </h3>
              <div class="card-tools">
                <a href="<?= BASE_URL_ADMIN ?>?act=form-sua-booking&id_booking=<?= $bookingInfo['dat_tour_id'] ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Sửa
                </a>
                <a href="<?= BASE_URL_ADMIN ?>?act=booking" class="btn btn-sm btn-secondary">
                  <i class="fas fa-arrow-left"></i> Quay lại
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- Left: Booking & Customer Info -->
                <div class="col-md-6">
                  <h5 class="mb-3">
                    <i class="fas fa-user-circle"></i> Thông Tin Khách Hàng
                  </h5>
                  <table class="table table-borderless table-sm">
                    <tr>
                      <td style="width: 40%; font-weight: bold;">Họ tên:</td>
                      <td><?= htmlspecialchars($bookingInfo['ho_ten'] ?? '') ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Email:</td>
                      <td><?= htmlspecialchars($bookingInfo['email'] ?? '') ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Số điện thoại:</td>
                      <td><?= htmlspecialchars($bookingInfo['so_dien_thoai'] ?? '') ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">CCCD:</td>
                      <td><?= htmlspecialchars($bookingInfo['cccd'] ?? '') ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Địa chỉ:</td>
                      <td><?= htmlspecialchars($bookingInfo['dia_chi'] ?? '') ?></td>
                    </tr>
                  </table>

                  <hr class="my-3">

                  <h5 class="mb-3">
                    <i class="fas fa-calendar-alt"></i> Thông Tin Booking
                  </h5>
                  <table class="table table-borderless table-sm">
                    <tr>
                      <td style="width: 40%; font-weight: bold;">Loại booking:</td>
                      <td>
                        <span class="badge <?= $bookingInfo['loai'] === 'group' ? 'badge-info' : 'badge-success' ?>">
                          <?= $bookingInfo['loai'] === 'group' ? 'Theo Nhóm' : 'Cá Nhân' ?>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Số người:</td>
                      <td><?= (int)$bookingInfo['so_nguoi'] ?> người</td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Ghi chú:</td>
                      <td><?= htmlspecialchars($bookingInfo['ghi_chu'] ?? 'Không có') ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Tổng tiền:</td>
                      <td class="text-danger" style="font-weight: bold; font-size: 1.1rem;">
                        <?= number_format((float)$bookingInfo['tong_tien'], 0, ',', '.') ?> VND
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Ngày tạo:</td>
                      <td><?= $bookingInfo['ngay_tao'] ? date('d/m/Y H:i', strtotime($bookingInfo['ngay_tao'])) : 'N/A' ?></td>
                    </tr>
                  </table>
                </div>

                <!-- Right: Tour Info -->
                <div class="col-md-6">
                  <h5 class="mb-3">
                    <i class="fas fa-map-marker-alt"></i> Thông Tin Tour
                  </h5>
                  <table class="table table-borderless table-sm">
                    <tr>
                      <td style="width: 40%; font-weight: bold;">Tên tour:</td>
                      <td><?= htmlspecialchars($bookingInfo['ten_tour'] ?? '') ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Điểm khởi hành:</td>
                      <td><?= htmlspecialchars($bookingInfo['diem_khoi_hanh'] ?? '') ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Ngày bắt đầu:</td>
                      <td><?= $bookingInfo['ngay_bat_dau'] ? date('d/m/Y', strtotime($bookingInfo['ngay_bat_dau'])) : 'N/A' ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Ngày kết thúc:</td>
                      <td><?= $bookingInfo['ngay_ket_thuc'] ? date('d/m/Y', strtotime($bookingInfo['ngay_ket_thuc'])) : 'N/A' ?></td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Giá cơ bản:</td>
                      <td><?= number_format((float)$bookingInfo['gia_co_ban'], 0, ',', '.') ?> VND</td>
                    </tr>
                  </table>

                  <hr class="my-3">

                  <h5 class="mb-3">
                    <i class="fas fa-file-alt"></i> Mô Tả Tour
                  </h5>
                  <div style="padding: 10px; background-color: #f8f9fa; border-radius: 5px; max-height: 300px; overflow-y: auto;">
                    <?= nl2br(htmlspecialchars($bookingInfo['mo_ta'] ?? 'Không có mô tả')) ?>
                  </div>

                  <hr class="my-3">

                  <h5 class="mb-3">
                    <i class="fas fa-file-contract"></i> Chính Sách
                  </h5>
                  <div style="padding: 10px; background-color: #f8f9fa; border-radius: 5px; max-height: 200px; overflow-y: auto;">
                    <?= nl2br(htmlspecialchars($bookingInfo['chinh_sach'] ?? 'Không có chính sách')) ?>
                  </div>
                </div>
              </div>

              <!-- Hành khách list -->
              <?php if (!empty($hanhKhachList)): ?>
                <hr class="my-4">
                <h5 class="mb-3">
                  <i class="fas fa-users"></i> Danh Sách Hành Khách (<?= count($hanhKhachList) ?> người)
                </h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover table-sm">
                    <thead class="thead-light">
                      <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Giới tính</th>
                        <th>CCCD</th>
                        <th>Ngày sinh</th>
                        <th>Số ghế</th>
                        <th>Ghi chú</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($hanhKhachList as $key => $hanhKhach): ?>
                        <tr>
                          <td><?= $key + 1 ?></td>
                          <td><?= htmlspecialchars($hanhKhach['ho_ten'] ?? '') ?></td>
                          <td><?= htmlspecialchars($hanhKhach['email'] ?? '') ?></td>
                          <td><?= htmlspecialchars($hanhKhach['so_dien_thoai'] ?? '') ?></td>
                          <td>
                            <?php 
                              $gioiTinh = $hanhKhach['gioi_tinh'] ?? '';
                              if ($gioiTinh === 'male') echo '👨 Nam';
                              elseif ($gioiTinh === 'female') echo '👩 Nữ';
                              else echo 'Khác';
                            ?>
                          </td>
                          <td><?= htmlspecialchars($hanhKhach['cccd'] ?? '') ?></td>
                          <td><?= $hanhKhach['ngay_sinh'] ? date('d/m/Y', strtotime($hanhKhach['ngay_sinh'])) : '' ?></td>
                          <td class="text-center"><?= $hanhKhach['so_ghe'] ?? 'N/A' ?></td>
                          <td><?= htmlspecialchars($hanhKhach['ghi_chu'] ?? '') ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>

<style>
  .card-primary.card-outline {
    border-top: 3px solid #007bff;
  }
  
  .table-borderless td {
    padding: 8px 0;
    border: none !important;
  }
  
  h5 {
    color: #2c3e50;
    font-weight: 600;
    border-bottom: 2px solid #007bff;
    padding-bottom: 8px;
  }
</style>

</body>
</html>
