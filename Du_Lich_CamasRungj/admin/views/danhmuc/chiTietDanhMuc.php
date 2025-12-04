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
          <h1><i class="fas fa-info-circle"></i> Chi tiết Tour</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=danh-muc-tour' ?>">Danh mục tour</a></li>
            <li class="breadcrumb-item active">Chi tiết</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Thông tin cơ bản -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-info"></i> Thông Tin Cơ Bản</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <dl class="row">
                <dt class="col-sm-4">Tên Tour:</dt>
                <dd class="col-sm-8"><strong><?= htmlspecialchars($tour['ten']) ?></strong></dd>
                
                <dt class="col-sm-4">Danh Mục:</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($tour['ten_danh_muc'] ?? 'N/A') ?></dd>
                
                <dt class="col-sm-4">Giá Cơ Bản:</dt>
                <dd class="col-sm-8 text-danger"><strong><?= formatPrice($tour['gia_co_ban']) ?></strong></dd>
                
                <dt class="col-sm-4">Thời Lượng:</dt>
                <dd class="col-sm-8"><?= $tour['thoi_luong_mac_dinh'] ?> ngày</dd>
              </dl>
            </div>
            <div class="col-md-6">
              <dl class="row">
                <dt class="col-sm-4">Điểm Khởi Hành:</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($tour['diem_khoi_hanh']) ?></dd>
                
                <dt class="col-sm-4">Trạng Thái:</dt>
                <dd class="col-sm-8">
                  <?php if ($tour['hoat_dong'] == 1): ?>
                    <span class="badge badge-success">Đang hoạt động</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Ngừng hoạt động</span>
                  <?php endif; ?>
                </dd>
                
                <dt class="col-sm-4">Người Tạo:</dt>
                <dd class="col-sm-8"><?= $tour['nguoi_tao_id'] ?? 'N/A' ?></dd>
                
                <dt class="col-sm-4">Ngày Tạo:</dt>
                <dd class="col-sm-8"><?= $tour['ngay_tao'] ? date('d/m/Y H:i', strtotime($tour['ngay_tao'])) : 'N/A' ?></dd>
              </dl>
            </div>
          </div>
          
          <div class="row">
            <div class="col-12">
              <dl class="row">
                <dt class="col-sm-2">Mô Tả Ngắn:</dt>
                <dd class="col-sm-10"><?= htmlspecialchars($tour['mo_ta_ngan'] ?? '') ?></dd>
                
                <dt class="col-sm-2">Mô Tả Chi Tiết:</dt>
                <dd class="col-sm-10"><?= nl2br(htmlspecialchars($tour['mo_ta'] ?? '')) ?></dd>
                
                <dt class="col-sm-2">Chính Sách:</dt>
                <dd class="col-sm-10"><?= nl2br(htmlspecialchars($tour['chinh_sach'] ?? '')) ?></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Địa điểm tour -->
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Địa Điểm Tour</h3>
        </div>
        <div class="card-body">
          <?php if (empty($tourDiaDiem)): ?>
            <p class="text-muted">Chưa có địa điểm nào được thêm.</p>
          <?php else: ?>
            <table class="table table-bordered table-striped">
              <thead class="thead-light">
                <tr class="text-center">
                  <th>STT</th>
                  <th>Tên Địa Điểm</th>
                  <th>Thứ Tự</th>
                  <th>Ghi Chú</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($tourDiaDiem as $index => $dd): ?>
                  <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($dd['ten_dia_diem'] ?? 'N/A') ?></td>
                    <td class="text-center"><?= $dd['thu_tu'] ?></td>
                    <td><?= htmlspecialchars($dd['ghi_chu'] ?? '') ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>

      <!-- Lịch trình -->
      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Lịch Trình Tour</h3>
        </div>
        <div class="card-body">
          <?php if (empty($lichTrinhList)): ?>
            <p class="text-muted">Chưa có lịch trình nào được thêm.</p>
          <?php else: ?>
            <?php foreach ($lichTrinhList as $lt): ?>
              <div class="callout callout-info">
                <h5><i class="fas fa-calendar-day"></i> Ngày <?= $lt['ngay_thu'] ?>: <?= htmlspecialchars($lt['tieu_de'] ?? '') ?></h5>
                <p><?= nl2br(htmlspecialchars($lt['mo_ta'] ?? '')) ?></p>
                <?php if (!empty($lt['ten_dia_diem'])): ?>
                  <p class="text-muted"><i class="fas fa-map-pin"></i> <strong>Địa điểm:</strong> <?= htmlspecialchars($lt['ten_dia_diem']) ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="row">
        <div class="col-12">
          <a href="<?= BASE_URL_ADMIN . '?act=danh-muc-tour' ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
          </a>
          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-danh-muc&id=' . $tour['tour_id'] ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Sửa Tour
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
