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
                            <!-- Thông tin tour và progress -->
                            <div class="row mb-3">
                                <div class="col-md-<?= isset($currentSchedule) && $currentSchedule ? '6' : '12' ?>">
                                    <div class="card card-success card-outline h-100">
                                        <div class="card-body">
                                            <h5 class="mb-3">
                                                <i class="fas fa-map-marked-alt text-success"></i> 
                                                <?= htmlspecialchars($lichInfo['ten_tour']) ?>
                                            </h5>
                                            <div class="row">
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted d-block">Khởi hành</small>
                                                    <strong><i class="fas fa-calendar-check text-success"></i> <?= date('d/m/Y', strtotime($lichInfo['ngay_bat_dau'])) ?></strong>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted d-block">Kết thúc</small>
                                                    <strong><i class="fas fa-calendar-times text-danger"></i> <?= date('d/m/Y', strtotime($lichInfo['ngay_ket_thuc'])) ?></strong>
                                                </div>
                                                <div class="col-12">
                                                    <?php 
                                                    $tongKhach = count($diemDanh);
                                                    $daCoMat = 0;
                                                    foreach ($diemDanh as $khach) {
                                                        if (isset($khach['da_den']) && $khach['da_den'] == 1) {
                                                            $daCoMat++;
                                                        }
                                                    }
                                                    $phanTram = $tongKhach > 0 ? round(($daCoMat / $tongKhach) * 100) : 0;
                                                    ?>
                                                    <small class="text-muted d-block">Tình trạng điểm danh</small>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 mr-2">
                                                            <div class="progress" style="height: 25px;">
                                                                <div class="progress-bar bg-success" role="progressbar" 
                                                                     style="width: <?= $phanTram ?>%;" 
                                                                     aria-valuenow="<?= $phanTram ?>" aria-valuemin="0" aria-valuemax="100">
                                                                    <?= $phanTram ?>%
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <strong><?= $daCoMat ?>/<?= $tongKhach ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lịch trình hiện tại -->
                                <?php if (isset($currentSchedule) && $currentSchedule): ?>
                                    <div class="col-md-6">
                                        <div class="card border-success h-100" style="border-width: 2px;">
                                            <div class="card-header bg-success">
                                                <h5 class="card-title mb-0">
                                                    <i class="fas fa-bullseye"></i> Lịch Trình Hiện Tại
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center mb-3">
                                                    <h2 class="mb-0 text-success">
                                                        <i class="fas fa-clock"></i> 
                                                        <?= substr($currentSchedule['gio_bat_dau'], 0, 5) ?> - <?= substr($currentSchedule['gio_ket_thuc'], 0, 5) ?>
                                                    </h2>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 text-center border-right">
                                                        <small class="text-muted d-block">Ngày</small>
                                                        <strong class="h4 text-primary">Ngày <?= $currentSchedule['ngay_thu'] ?></strong>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <small class="text-muted d-block">Hoạt động</small>
                                                        <strong><?= htmlspecialchars($currentSchedule['noi_dung']) ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Timeline lịch trình -->
                            <?php if (!empty($allSchedules)): ?>
                                <div class="card card-outline card-info mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-route"></i> Lịch Trình Chi Tiết
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        <?php 
                                        // Nhóm lịch trình theo ngày
                                        $schedulesByDay = [];
                                        foreach ($allSchedules as $schedule) {
                                            $schedulesByDay[$schedule['ngay_thu']][] = $schedule;
                                        }
                                        
                                        foreach ($schedulesByDay as $ngayThu => $schedules): 
                                        ?>
                                            <div class="mb-4 pb-4 <?= $ngayThu < count($schedulesByDay) ? 'border-bottom' : '' ?>">
                                                <h6 class="text-primary mb-3">
                                                    <i class="fas fa-calendar-day"></i> <strong>Ngày <?= $ngayThu ?></strong>
                                                </h6>
                                                <div class="row">
                                                    <?php foreach ($schedules as $schedule): 
                                                        $isCurrent = (isset($currentSchedule['lich_trinh_id']) && $schedule['lich_trinh_id'] == $currentSchedule['lich_trinh_id']);
                                                    ?>
                                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                                            <div class="small-box <?= $isCurrent ? 'bg-success' : 'bg-light' ?>" 
                                                                 style="cursor: pointer; min-height: 130px;"
                                                                 onclick="window.location='?act=hdv-chi-tiet-lich&lich_id=<?= $lich_id ?>&hdv_id=<?= $hdv_id ?>&tab=diem-danh&lich_trinh_id=<?= $schedule['lich_trinh_id'] ?>'">
                                                                <div class="inner p-3">
                                                                    <h6 class="mb-2 <?= $isCurrent ? 'text-white' : '' ?>">
                                                                        <i class="fas fa-clock"></i> 
                                                                        <?= substr($schedule['gio_bat_dau'], 0, 5) ?> - 
                                                                        <?= substr($schedule['gio_ket_thuc'], 0, 5) ?>
                                                                    </h6>
                                                                    <p class="mb-0 <?= $isCurrent ? 'text-white' : 'text-muted' ?>" style="font-size: 0.875rem; line-height: 1.4;">
                                                                        <?= htmlspecialchars($schedule['noi_dung']) ?>
                                                                    </p>
                                                                </div>
                                                                <?php if ($isCurrent): ?>
                                                                    <div class="icon">
                                                                        <i class="fas fa-bullseye"></i>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="small-box-footer py-2" style="background: rgba(0,0,0,0.1);">
                                                                        <small>Click để chọn</small>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="card">
                                <div class="card-body">
                                    
                                    <?php if (!empty($diemDanh)): ?>
                                        <!-- Form điểm danh -->
                                        <form id="formDiemDanh" method="POST" action="<?= BASE_URL_ADMIN ?>?act=hdv-diem-danh-action">
                                            <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                                            <input type="hidden" name="hdv_id" value="<?= $hdv_id ?>">
                                            
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
                                                            <th>Điểm Danh</th>
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
                                                                <span class="badge <?= isset($item['da_den']) && $item['da_den'] ? 'badge-success' : 'badge-danger' ?> status-badge-<?= $item['hanh_khach_id'] ?>">
                                                                    <i class="fas <?= isset($item['da_den']) && $item['da_den'] ? 'fa-check' : 'fa-times' ?>"></i> 
                                                                    <?= isset($item['da_den']) && $item['da_den'] ? 'Có mặt' : 'Vắng' ?>
                                                                </span>
                                                            </td>
                                                            <td class="thoi-gian-cell-<?= $item['hanh_khach_id'] ?>">
                                                                <?= !empty($item['thoi_gian']) ? '<span class="thoi-gian-' . $item['hanh_khach_id'] . '">' . date('d/m/Y H:i', strtotime($item['thoi_gian'])) . '</span>' : '<span class="text-muted">Chưa điểm danh</span>' ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" 
                                                                           id="check_<?= $item['hanh_khach_id'] ?>" 
                                                                           name="hanh_khach_ids[]" 
                                                                           value="<?= $item['hanh_khach_id'] ?>"
                                                                           class="checkbox-diem-danh"
                                                                           data-hanh-khach-id="<?= $item['hanh_khach_id'] ?>"
                                                                           <?= (isset($item['da_den']) && $item['da_den']) ? 'checked' : '' ?>>
                                                                    <label for="check_<?= $item['hanh_khach_id'] ?>"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot class="bg-light">
                                                    <tr>
                                                        <td colspan="7" class="text-right align-middle">
                                                            <?php 
                                                            $totalKhach = count($diemDanh);
                                                            $daCoMat = 0;
                                                            foreach ($diemDanh as $item) {
                                                                if (isset($item['da_den']) && $item['da_den']) {
                                                                    $daCoMat++;
                                                                }
                                                            }
                                                            ?>
                                                            <strong>Tổng cộng: <span id="tongKhach"><?= $totalKhach ?></span> khách | 
                                                            <span class="text-success">Có mặt: <span id="daCoMat"><?= $daCoMat ?></span></span> | 
                                                            <span class="text-danger">Vắng: <span id="vangMat"><?= $totalKhach - $daCoMat ?></span></span></strong>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <button type="submit" class="btn btn-success btn-lg" id="btnLuuDiemDanh">
                                                                <i class="fas fa-save"></i> Lưu điểm danh
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        </form>
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
                                                            $anh = $nk['anh_tour'];
                                                            if (strpos($anh, '../') === 0) {
                                                                $anh = str_replace('../', '', $anh);
                                                            }
                                                            if (strpos($anh, 'assets/') !== 0) {
                                                                $anh = 'assets/img/nhatky/' . basename($anh);
                                                            }
                                                            ?>
                                                            <img src="<?= BASE_URL . htmlspecialchars($anh) ?>" class="card-img-top" alt="Ảnh tour" style="max-height: 200px; object-fit: cover;">
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
    const checkboxes = document.querySelectorAll('.checkbox-diem-danh');
    const form = document.getElementById('formDiemDanh');
    const btnLuu = document.getElementById('btnLuuDiemDanh');
    
    if (!checkboxes.length || !form) return;
    
    // Cập nhật UI khi click checkbox (không submit)
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const hanhKhachId = this.dataset.hanhKhachId;
            const isChecked = this.checked;
            const row = this.closest('tr');
            const statusBadge = document.querySelector('.status-badge-' + hanhKhachId);
            
            // Cập nhật giao diện
            if (isChecked) {
                statusBadge.className = 'badge badge-success status-badge-' + hanhKhachId;
                statusBadge.innerHTML = '<i class="fas fa-check"></i> Có mặt';
            } else {
                statusBadge.className = 'badge badge-danger status-badge-' + hanhKhachId;
                statusBadge.innerHTML = '<i class="fas fa-times"></i> Vắng';
                
                // Xóa thời gian nếu có
                const thoiGianCell = document.querySelector('.thoi-gian-cell-' + hanhKhachId);
                if (thoiGianCell) {
                    thoiGianCell.innerHTML = '<span class="text-muted">Chưa điểm danh</span>';
                }
            }
            
            // Cập nhật số liệu
            updateStats();
        });
    });
    
    // Cập nhật thống kê
    function updateStats() {
        const total = checkboxes.length;
        const checked = document.querySelectorAll('.checkbox-diem-danh:checked').length;
        const absent = total - checked;
        
        const tongKhachEl = document.getElementById('tongKhach');
        const daCoMatEl = document.getElementById('daCoMat');
        const vangMatEl = document.getElementById('vangMat');
        
        if (tongKhachEl) tongKhachEl.textContent = total;
        if (daCoMatEl) daCoMatEl.textContent = checked;
        if (vangMatEl) vangMatEl.textContent = absent;
    }
    
    // Submit form qua AJAX
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            console.log('Form submit started');
            console.log('Action URL:', form.action);
            
            if (btnLuu) {
                btnLuu.disabled = true;
                btnLuu.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
            }
            
            const formData = new FormData(form);
            
            // Log form data
            console.log('Form data:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers.get('Content-Type'));
                
                // Kiểm tra content-type
                const contentType = response.headers.get('Content-Type');
                if (!contentType || !contentType.includes('application/json')) {
                    return response.text().then(text => {
                        console.error('Response is not JSON:', text);
                        throw new Error('Server trả về dữ liệu không hợp lệ (HTML thay vì JSON)');
                    });
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (data.success) {
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: data.message || 'Đã lưu điểm danh',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Cập nhật thời gian điểm danh
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            const hanhKhachId = checkbox.dataset.hanhKhachId;
                            const thoiGianCell = document.querySelector('.thoi-gian-cell-' + hanhKhachId);
                            
                            if (thoiGianCell && !thoiGianCell.querySelector('.thoi-gian-' + hanhKhachId)) {
                                const now = new Date();
                                const dateStr = now.getDate().toString().padStart(2, '0') + '/' + 
                                              (now.getMonth() + 1).toString().padStart(2, '0') + '/' + 
                                              now.getFullYear();
                                const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                                              now.getMinutes().toString().padStart(2, '0');
                                thoiGianCell.innerHTML = '<span class="thoi-gian-' + hanhKhachId + '">' + 
                                                        dateStr + ' ' + timeStr + '</span>';
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: data.message || 'Có lỗi xảy ra'
                    });
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi kết nối!',
                    text: error.message || 'Không thể kết nối đến server. Vui lòng kiểm tra kết nối mạng.',
                    footer: 'Chi tiết lỗi: ' + error.toString()
                });
            })
            .finally(() => {
                if (btnLuu) {
                    btnLuu.disabled = false;
                    btnLuu.innerHTML = '<i class="fas fa-save"></i> Lưu điểm danh';
                }
            });
        });
    }
});
</script>

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
            
            sweetConfirmPromise('Xác nhận chuyển trạng thái từ "' + currentStatus + '" sang "' + newStatus + '" cho khách hàng này?').then(function(confirmed) {
                if (confirmed) {
                    window.location.href = '<?= BASE_URL_ADMIN ?>?act=hdv-diem-danh-action&hanh_khach_id=' + hanhKhachId + '&lich_id=' + lichId + '&hdv_id=' + hdvId + '&redirect=chi-tiet-lich&tab=diem-danh';
                }
            });
        });
    });
});
</script>

