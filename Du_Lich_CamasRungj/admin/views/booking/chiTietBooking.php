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
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-file-invoice"></i> Chi Tiết Booking</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=booking' ?>">Booking</a></li>
            <li class="breadcrumb-item active">Chi tiết</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Thông tin booking -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-ticket-alt"></i> Thông Tin Booking</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <dl class="row">
                <dt class="col-sm-5">Mã Booking:</dt>
                <dd class="col-sm-7"><strong>#<?= $booking['dat_tour_id'] ?></strong></dd>
                
                <dt class="col-sm-5">Tên Tour:</dt>
                <dd class="col-sm-7"><strong><?= htmlspecialchars($booking['ten_tour']) ?></strong></dd>
                
                <dt class="col-sm-5">Ngày Bắt Đầu:</dt>
                <dd class="col-sm-7"><?= date('d/m/Y', strtotime($booking['ngay_bat_dau'])) ?></dd>
                
                <dt class="col-sm-5">Ngày Kết Thúc:</dt>
                <dd class="col-sm-7"><?= date('d/m/Y', strtotime($booking['ngay_ket_thuc'])) ?></dd>
                
                <dt class="col-sm-5">Số Ngày:</dt>
                <dd class="col-sm-7"><?= tinhNgayDem($booking['ngay_bat_dau'], $booking['ngay_ket_thuc']) ?> ngày</dd>
              </dl>
            </div>
            <div class="col-md-6">
              <dl class="row">
                <dt class="col-sm-5">Loại:</dt>
                <dd class="col-sm-7">
                  <?php if ($booking['loai'] == 'group'): ?>
                    <span class="badge badge-info">Cá Nhân</span>
                  <?php else: ?>
                    <span class="badge badge-primary">Theo Nhóm</span>
                  <?php endif; ?>
                </dd>
                
                <dt class="col-sm-5">Số Người:</dt>
                <dd class="col-sm-7"><strong><?= $booking['so_nguoi'] ?></strong> người</dd>
                
                <dt class="col-sm-5">Tổng Tiền:</dt>
                <dd class="col-sm-7 text-danger"><strong><?= formatPrice($booking['tong_tien']) ?></strong></dd>
                
                <dt class="col-sm-5">Trạng Thái:</dt>
                <dd class="col-sm-7">
                  <?php
                  $statusClass = '';
                  switch ($booking['trang_thai_id']) {
                    case 1: $statusClass = 'badge-warning'; break;
                    case 2: $statusClass = 'badge-info'; break;
                    case 3: $statusClass = 'badge-success'; break;
                    case 4: $statusClass = 'badge-danger'; break;
                    default: $statusClass = 'badge-secondary';
                  }
                  ?>
                  <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($booking['ten_trang_thai']) ?></span>
                </dd>
                
                <dt class="col-sm-5">Ngày Đặt:</dt>
                <dd class="col-sm-7"><?= date('d/m/Y H:i', strtotime($booking['ngay_dat'])) ?></dd>
              </dl>
            </div>
          </div>
          
          <?php if (!empty($booking['ghi_chu'])): ?>
            <div class="row">
              <div class="col-12">
                <dl class="row">
                  <dt class="col-sm-2">Ghi Chú:</dt>
                  <dd class="col-sm-10"><?= nl2br(htmlspecialchars($booking['ghi_chu'])) ?></dd>
                </dl>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Thông tin người đặt -->
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-user"></i> Thông Tin Người Đặt Tour</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <dl class="row">
                <dt class="col-sm-5">Họ Tên:</dt>
                <dd class="col-sm-7"><strong><?= htmlspecialchars($booking['ten_khach_hang']) ?></strong></dd>
                
                <dt class="col-sm-5">Số Điện Thoại:</dt>
                <dd class="col-sm-7"><i class="fas fa-phone"></i> <?= htmlspecialchars($booking['so_dien_thoai'] ?? 'N/A') ?></dd>
                
                <dt class="col-sm-5">Email:</dt>
                <dd class="col-sm-7"><i class="fas fa-envelope"></i> <?= htmlspecialchars($booking['email'] ?? 'N/A') ?></dd>
              </dl>
            </div>
            <div class="col-md-6">
              <dl class="row">
                <dt class="col-sm-5">CCCD:</dt>
                <dd class="col-sm-7"><?= htmlspecialchars($booking['cccd'] ?? 'N/A') ?></dd>
                
                <dt class="col-sm-5">Địa Chỉ:</dt>
                <dd class="col-sm-7"><?= htmlspecialchars($booking['dia_chi'] ?? 'N/A') ?></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Danh sách hành khách -->
      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-users"></i> Danh Sách Hành Khách (<?= count($hanhKhachList) ?> người)</h3>
        </div>
        <div class="card-body">
          <?php if (empty($hanhKhachList)): ?>
            <p class="text-muted">Chưa có hành khách nào.</p>
          <?php else: ?>
            <table class="table table-bordered table-striped table-hover">
              <thead class="thead-light">
                <tr class="text-center">
                  <th>STT</th>
                  <th>Họ Tên</th>
                  <th>Giới Tính</th>
                  <th>CCCD</th>
                  <th>Số Điện Thoại</th>
                  <th>Email</th>
                  <th>Ngày Sinh</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($hanhKhachList as $index => $khach): ?>
                  <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($khach['ho_ten'] ?? 'N/A') ?></td>
                    <td class="text-center">
                      <?php if (isset($khach['gioi_tinh'])): ?>
                        <?php if ($khach['gioi_tinh'] == 'Nam'): ?>
                          <i class="fas fa-male text-primary"></i> Nam
                        <?php else: ?>
                          <i class="fas fa-female text-danger"></i> Nữ
                        <?php endif; ?>
                      <?php else: ?>
                        N/A
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($khach['cccd'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($khach['so_dien_thoai'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($khach['email'] ?? 'N/A') ?></td>
                    <td class="text-center">
                      <?= isset($khach['ngay_sinh']) ? date('d/m/Y', strtotime($khach['ngay_sinh'])) : 'N/A' ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="row">
        <div class="col-12">
          <a href="<?= BASE_URL_ADMIN . '?act=booking' ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
          </a>
          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-booking&id_booking=' . $booking['dat_tour_id'] ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Sửa Booking
          </a>
          <a href="<?= BASE_URL_ADMIN . '?act=xoa-booking&id_booking=' . $booking['dat_tour_id'] ?>" 
             class="btn btn-danger" 
             onclick="return confirm('Bạn có chắc chắn muốn xóa booking này không?');">
            <i class="fas fa-trash"></i> Xóa Booking
          </a>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
</body>
</html>
