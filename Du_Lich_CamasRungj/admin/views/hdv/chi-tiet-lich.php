<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chi Tiết Lịch Làm Việc</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id ?>">Quản Lý HDV</a></li>
                        <li class="breadcrumb-item active">Chi Tiết Lịch</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tour: <?= htmlspecialchars($lichInfo['ten_tour']) ?></h3>
                    <p class="mb-0">Từ <?= date('d/m/Y', strtotime($lichInfo['ngay_bat_dau'])) ?> đến <?= date('d/m/Y', strtotime($lichInfo['ngay_ket_thuc'])) ?></p>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="lichTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'khach-hang' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich&lich_id=" . $lich_id . "&hdv_id=" . $hdv_id . "&tab=khach-hang" ?>">
                                <i class="fas fa-users"></i> Thông Tin Khách Hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'diem-danh' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich&lich_id=" . $lich_id . "&hdv_id=" . $hdv_id . "&tab=diem-danh" ?>">
                                <i class="fas fa-check-circle"></i> Điểm Danh
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'nhat-ky' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich&lich_id=" . $lich_id . "&hdv_id=" . $hdv_id . "&tab=nhat-ky" ?>">
                                <i class="fas fa-book"></i> Nhật Ký Tour
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Tab 1: Thông Tin Khách Hàng -->
                        <?php if ($tab == 'khach-hang'): ?>
                            <div class="card">
                                <div class="card-body">
                                    <?php if (!empty($danhSachKhach)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Họ Tên</th>
                                                        <th>CCCD</th>
                                                        <th>Số Điện Thoại</th>
                                                        <th>Ghi Chú</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $stt = 1; foreach ($danhSachKhach as $khach): ?>
                                                        <tr>
                                                            <td class="text-center"><?= $stt++ ?></td>
                                                            <td><?= htmlspecialchars($khach['ho_ten']) ?></td>
                                                            <td><?= htmlspecialchars($khach['cccd'] ?? '') ?></td>
                                                            <td><?= htmlspecialchars($khach['so_dien_thoai'] ?? '') ?></td>
                                                            <td><?= htmlspecialchars($khach['ghi_chu'] ?? '') ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Chưa có khách hàng nào trong tour này
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tab 2: Điểm Danh -->
                        <?php if ($tab == 'diem-danh'): ?>
                            <div class="card">
                                <div class="card-body">
                                    <?php if (!empty($diemDanh)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Tên Hành Khách</th>
                                                        <th>CCCD</th>
                                                        <th>Số Điện Thoại</th>
                                                        <th>Yêu Cầu Đặc Biệt</th>
                                                        <th>Trạng Thái</th>
                                                        <th>Thời Gian</th>
                                                        <th>Hành Động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $stt = 1;
                                                    foreach ($diemDanh as $item): 
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $stt++ ?></td>
                                                            <td><strong><?= htmlspecialchars($item['ho_ten']) ?></strong></td>
                                                            <td><?= htmlspecialchars($item['cccd'] ?? '') ?></td>
                                                            <td><?= htmlspecialchars($item['so_dien_thoai'] ?? '') ?></td>
                                                            <td>
                                                                <?php if (!empty($item['ghi_chu'])): ?>
                                                                    <span class="text-warning">
                                                                        <i class="fas fa-star"></i> <?= htmlspecialchars($item['ghi_chu']) ?>
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="text-muted">Không có</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if (isset($item['da_den']) && $item['da_den']): ?>
                                                                    <span class="badge badge-success">
                                                                        <i class="fas fa-check"></i> Có mặt
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-danger">
                                                                        <i class="fas fa-times"></i> Vắng
                                                                    </span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= !empty($item['thoi_gian']) ? date('d/m/Y H:i', strtotime($item['thoi_gian'])) : 'Chưa điểm danh' ?></td>
                                                            <td class="text-center">
                                                                <?php if (isset($item['da_den']) && $item['da_den']): ?>
                                                                    <button class="btn btn-sm btn-warning btn-diem-danh" 
                                                                            data-hanh-khach-id="<?= $item['hanh_khach_id'] ?>"
                                                                            data-lich-id="<?= $lich_id ?>"
                                                                            data-hdv-id="<?= $hdv_id ?>"
                                                                            title="Chuyển sang Vắng">
                                                                        <i class="fas fa-times"></i> Vắng
                                                                    </button>
                                                                <?php else: ?>
                                                                    <button class="btn btn-sm btn-success btn-diem-danh" 
                                                                            data-hanh-khach-id="<?= $item['hanh_khach_id'] ?>"
                                                                            data-lich-id="<?= $lich_id ?>"
                                                                            data-hdv-id="<?= $hdv_id ?>"
                                                                            title="Đánh dấu Có mặt">
                                                                        <i class="fas fa-check"></i> Có mặt
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Chưa có khách hàng nào trong tour này
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tab 3: Nhật Ký Tour -->
                        <?php if ($tab == 'nhat-ky'): ?>
                            <div class="card">
                                <div class="card-body">
                                    <?php if (!empty($nhatKy)): ?>
                                        <div class="row">
                                            <?php foreach ($nhatKy as $nk): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="card">
                                                        <?php if (!empty($nk['anh_tour'])): ?>
                                                            <?php 
                                                            $anh_path = $nk['anh_tour'];
                                                            // Bỏ ../ nếu có
                                                            if (strpos($anh_path, '../') === 0) {
                                                                $anh_path = str_replace('../', '', $anh_path);
                                                            }
                                                            // Nếu không có assets/ thì thêm vào
                                                            if (strpos($anh_path, 'assets/') !== 0) {
                                                                if (strpos($anh_path, 'img/nhatky/') === 0) {
                                                                    $anh_path = 'assets/' . $anh_path;
                                                                } else {
                                                                    $anh_path = 'assets/img/nhatky/' . basename($anh_path);
                                                                }
                                                            }
                                                            ?>
                                                            <img src="<?= BASE_URL . htmlspecialchars($anh_path) ?>" class="card-img-top" alt="Ảnh tour" style="max-height: 200px; object-fit: cover;">
                                                        <?php endif; ?>
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= htmlspecialchars($nk['dia_diem']) ?></h5>
                                                            <p class="card-text"><?= htmlspecialchars($nk['noi_dung']) ?></p>
                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar"></i> <?= date('d/m/Y H:i', strtotime($nk['ngay_thuc_hien'])) ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Chưa có nhật ký tour nào
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-diem-danh');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const hanhKhachId = this.getAttribute('data-hanh-khach-id');
            const lichId = this.getAttribute('data-lich-id');
            const hdvId = this.getAttribute('data-hdv-id');
            
            const currentStatus = this.closest('tr').querySelector('.badge-success') ? 'Có mặt' : 'Vắng';
            const newStatus = currentStatus === 'Có mặt' ? 'Vắng' : 'Có mặt';
            
            if (confirm('Xác nhận chuyển trạng thái từ "' + currentStatus + '" sang "' + newStatus + '" cho khách hàng này?')) {
                window.location.href = '<?= BASE_URL_ADMIN ?>?act=hdv-diem-danh-action&hanh_khach_id=' + hanhKhachId + '&lich_id=' + lichId + '&hdv_id=' + hdvId + '&redirect=chi-tiet-lich&tab=diem-danh';
            }
        });
    });
});
</script>

