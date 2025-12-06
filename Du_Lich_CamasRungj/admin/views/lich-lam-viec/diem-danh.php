<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-check-square"></i> Điểm Danh Khách Hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Điểm Danh</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?= $_SESSION['success'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= $_SESSION['error'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Thông tin tour và lịch trình hiện tại -->
            <div class="row mb-3">
                <!-- Thông tin tour -->
                <?php if ($lichInfo): ?>
                    <div class="col-md-<?= $currentSchedule ? '6' : '12' ?>">
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
                                        $tongKhach = count($danhSachDiemDanh);
                                        $daCoMat = 0;
                                        foreach ($danhSachDiemDanh as $khach) {
                                            if ($khach['da_den'] == 1) {
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
                <?php endif; ?>

                <!-- Lịch trình hiện tại -->
                <?php if ($currentSchedule): ?>
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
                                        <small class="text-muted d-block">Địa điểm</small>
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
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card card-outline card-info">
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
                                                $isCurrent = ($currentSchedule && isset($currentSchedule['lich_trinh_id']) && $schedule['lich_trinh_id'] == $currentSchedule['lich_trinh_id']);
                                            ?>
                                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                                    <div class="small-box <?= $isCurrent ? 'bg-success' : 'bg-light' ?>" style="cursor: pointer; min-height: 130px;" 
                                                         onclick="window.location='?act=hdv-diem-danh&lich_id=<?= $lichInfo['lich_id'] ?>&lich_trinh_id=<?= $schedule['lich_trinh_id'] ?>'">
                                                        <div class="inner p-3">
                                                            <h6 class="mb-2 <?= $isCurrent ? 'text-white' : '' ?>">
                                                                <i class="fas fa-clock"></i> 
                                                                <?= isset($schedule['gio_bat_dau']) ? substr($schedule['gio_bat_dau'], 0, 5) : 'N/A' ?> - 
                                                                <?= isset($schedule['gio_ket_thuc']) ? substr($schedule['gio_ket_thuc'], 0, 5) : 'N/A' ?>
                                                            </h6>
                                                            <p class="mb-0 <?= $isCurrent ? 'text-white' : 'text-muted' ?>" style="font-size: 0.875rem; line-height: 1.4;">
                                                                <?= isset($schedule['noi_dung']) ? htmlspecialchars($schedule['noi_dung']) : 'Chưa có mô tả' ?>
                                                            </p>
                                                        </div>
                                                        <?php if ($isCurrent): ?>
                                                            <div class="icon">
                                                                <i class="fas fa-bullseye"></i>
                                                            </div>
                                                        <?php else: ?>
                                                            <a href="?act=hdv-diem-danh&lich_id=<?= $lichInfo['lich_id'] ?>&lich_trinh_id=<?= $schedule['lich_trinh_id'] ?>" 
                                                               class="small-box-footer py-2">
                                                                Chọn <i class="fas fa-arrow-circle-right"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Danh sách điểm danh -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-success card-outline">
                        <div class="card-header" style="padding: 10px 15px;">
                            <h3 class="card-title" style="font-size: 16px; font-weight: 600; margin: 0; line-height: 32px;">
                                <i class="fas fa-users-check"></i> Danh Sách Điểm Danh
                            </h3>
                            <div class="card-tools">
                                <?php if (!empty($danhSachDiemDanh)): ?>
                                    <span class="badge badge-success mr-2" style="padding: 6px 12px; font-size: 13px;">
                                        <i class="fas fa-check"></i> <?= $daCoMat ?>
                                    </span>
                                    <span class="badge badge-secondary mr-2" style="padding: 6px 12px; font-size: 13px;">
                                        <i class="fas fa-users"></i> <?= $tongKhach ?>
                                    </span>
                                <?php endif; ?>
                                <a href="<?= BASE_URL_ADMIN ?>?act=hdv-lich-lam-viec" class="btn btn-sm btn-default" style="padding: 6px 12px; font-size: 13px;">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($danhSachDiemDanh)): ?>
                                <div class="alert alert-warning text-center m-3">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <p class="mb-0">Chưa có khách hàng nào để điểm danh.</p>
                                </div>
                            <?php else: ?>
                                <!-- Form điểm danh -->
                                <form id="formDiemDanh" method="POST" action="<?= BASE_URL_ADMIN ?>?act=hdv-xu-ly-diem-danh">
                                    <input type="hidden" name="lich_id" value="<?= $lichInfo['lich_id'] ?>">
                                    <?php if ($currentSchedule): ?>
                                        <input type="hidden" name="lich_trinh_id" value="<?= $currentSchedule['lich_trinh_id'] ?>">
                                    <?php endif; ?>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0">
                                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <tr>
                                                    <th width="50" class="text-center align-middle" style="padding: 12px 8px; font-size: 14px; font-weight: 600;">STT</th>
                                                    <th class="align-middle" style="padding: 12px 8px; font-size: 14px; font-weight: 600;">
                                                        <i class="fas fa-user"></i> Họ Tên
                                                    </th>
                                                    <th width="110" class="text-center align-middle" style="padding: 12px 8px; font-size: 14px; font-weight: 600;">
                                                        <i class="fas fa-venus-mars"></i> Giới Tính
                                                    </th>
                                                    <th width="140" class="align-middle" style="padding: 12px 8px; font-size: 14px; font-weight: 600;">
                                                        <i class="fas fa-phone"></i> Số Điện Thoại
                                                    </th>
                                                    <th width="130" class="text-center align-middle" style="padding: 12px 8px; font-size: 14px; font-weight: 600;">
                                                        <i class="fas fa-user-check"></i> Trạng Thái
                                                    </th>
                                                    <th width="160" class="text-center align-middle" style="padding: 12px 8px; font-size: 14px; font-weight: 600;">
                                                        <i class="fas fa-clock"></i> Thời Gian
                                                    </th>
                                                    <th width="100" class="text-center align-middle" style="padding: 12px 8px; font-size: 14px; font-weight: 600;">
                                                        <i class="fas fa-check-square"></i> Điểm Danh
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $stt = 1;
                                            foreach ($danhSachDiemDanh as $khach): 
                                                $coMat = $khach['da_den'] == 1;
                                            ?>
                                                <tr style="border-bottom: 1px solid #e9ecef;">
                                                    <td class="text-center align-middle" style="padding: 10px 8px; font-size: 14px;"><?= $stt++ ?></td>
                                                    <td class="align-middle" style="padding: 10px 8px; font-size: 14px;">
                                                        <strong><?= htmlspecialchars($khach['ho_ten']) ?></strong>
                                                    </td>
                                                    <td class="text-center align-middle" style="padding: 10px 8px; font-size: 13px;">
                                                        <?php if (!empty($khach['gioi_tinh']) && $khach['gioi_tinh'] == 'Nam'): ?>
                                                            <span class="badge badge-info" style="padding: 5px 10px; font-size: 12px;">
                                                                <i class="fas fa-male"></i> Nam
                                                            </span>
                                                        <?php elseif (!empty($khach['gioi_tinh']) && $khach['gioi_tinh'] == 'Nữ'): ?>
                                                            <span class="badge badge-danger" style="padding: 5px 10px; font-size: 12px;">
                                                                <i class="fas fa-female"></i> Nữ
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted" style="font-size: 13px;">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="align-middle" style="padding: 10px 8px; font-size: 14px;">
                                                        <i class="fas fa-phone-alt text-primary" style="font-size: 12px;"></i> 
                                                        <?= htmlspecialchars($khach['so_dien_thoai'] ?? 'N/A') ?>
                                                    </td>
                                                    <td class="text-center align-middle" style="padding: 10px 8px; font-size: 13px;">
                                                        <span class="badge <?= $coMat ? 'badge-success' : 'badge-secondary' ?> status-badge-<?= $khach['hanh_khach_id'] ?>" style="padding: 6px 12px; font-size: 12px;">
                                                            <i class="fas <?= $coMat ? 'fa-check' : 'fa-times' ?>"></i> <?= $coMat ? 'Có mặt' : 'Chưa có mặt' ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center align-middle" style="padding: 10px 8px; font-size: 13px;">
                                                        <span class="thoi-gian-wrapper-<?= $khach['hanh_khach_id'] ?>">
                                                            <?php if ($coMat && !empty($khach['thoi_gian'])): ?>
                                                                <span class="thoi-gian-<?= $khach['hanh_khach_id'] ?>">
                                                                    <?= date('d/m/Y H:i', strtotime($khach['thoi_gian'])) ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center align-middle" style="padding: 10px 8px;">
                                                        <?php if ($currentSchedule): ?>
                                                            <input type="checkbox" 
                                                                   id="check_<?= $khach['hanh_khach_id'] ?>" 
                                                                   name="hanh_khach_ids[]" 
                                                                   value="<?= $khach['hanh_khach_id'] ?>"
                                                                   class="checkbox-diem-danh"
                                                                   data-hanh-khach-id="<?= $khach['hanh_khach_id'] ?>"
                                                                   style="width: 18px; height: 18px; cursor: pointer;"
                                                                   <?= $coMat ? 'checked' : '' ?>>
                                                        <?php else: ?>
                                                            <span class="text-muted" style="font-size: 13px;">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot style="background: #f4f6f9; border-top: 2px solid #dee2e6;">
                                            <tr>
                                                <td colspan="6" class="text-right align-middle" style="padding: 12px 8px; font-size: 14px;">
                                                    <strong>Tổng cộng: <span id="tongKhach"><?= $tongKhach ?></span> khách | 
                                                    <span class="text-success">Có mặt: <span id="daCoMat"><?= $daCoMat ?></span></span> | 
                                                    <span class="text-danger">Vắng: <span id="vangMat"><?= $tongKhach - $daCoMat ?></span></span></strong>
                                                </td>
                                                <td class="text-center align-middle" style="padding: 12px 8px;">
                                                    <?php if ($currentSchedule): ?>
                                                        <button type="submit" class="btn btn-success" id="btnLuuDiemDanh" style="padding: 6px 16px; font-size: 13px; font-weight: 500; white-space: nowrap;">
                                                            <i class="fas fa-save"></i> Lưu điểm danh
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.checkbox-diem-danh');
    const form = document.getElementById('formDiemDanh');
    const btnLuu = document.getElementById('btnLuuDiemDanh');
    
    // Cập nhật UI khi click checkbox (không submit)
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const hanhKhachId = this.dataset.hanhKhachId;
            const isChecked = this.checked;
            const statusBadge = document.querySelector('.status-badge-' + hanhKhachId);
            const thoiGianWrapper = document.querySelector('.thoi-gian-wrapper-' + hanhKhachId);
            
            // Cập nhật trạng thái
            if (isChecked) {
                statusBadge.className = 'badge badge-success status-badge-' + hanhKhachId;
                statusBadge.innerHTML = '<i class="fas fa-check"></i> Có mặt';
            } else {
                statusBadge.className = 'badge badge-secondary status-badge-' + hanhKhachId;
                statusBadge.innerHTML = '<i class="fas fa-times"></i> Chưa có mặt';
                
                // Xóa thời gian
                if (thoiGianWrapper) {
                    thoiGianWrapper.innerHTML = '';
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
        
        document.getElementById('tongKhach').textContent = total;
        document.getElementById('daCoMat').textContent = checked;
        document.getElementById('vangMat').textContent = absent;
        
        // Cập nhật progress bar
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            const percent = total > 0 ? Math.round((checked / total) * 100) : 0;
            progressBar.style.width = percent + '%';
            progressBar.setAttribute('aria-valuenow', percent);
            progressBar.textContent = percent + '%';
        }
    }
    
    // Submit form qua AJAX
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (btnLuu) {
                btnLuu.disabled = true;
                btnLuu.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
            }
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                const contentType = response.headers.get('Content-Type');
                if (!contentType || !contentType.includes('application/json')) {
                    return response.text().then(text => {
                        throw new Error('Server trả về dữ liệu không hợp lệ');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
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
                            const thoiGianWrapper = document.querySelector('.thoi-gian-wrapper-' + hanhKhachId);
                            
                            if (thoiGianWrapper && !thoiGianWrapper.querySelector('.thoi-gian-' + hanhKhachId)) {
                                const now = new Date();
                                const dateStr = now.getDate().toString().padStart(2, '0') + '/' +
                                              (now.getMonth() + 1).toString().padStart(2, '0') + '/' +
                                              now.getFullYear();
                                const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                                              now.getMinutes().toString().padStart(2, '0');
                                const fullDateTime = dateStr + ' ' + timeStr;
                                
                                thoiGianWrapper.innerHTML = '<span class="thoi-gian-' + hanhKhachId + '">' + fullDateTime + '</span>';
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
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi kết nối!',
                    text: error.message || 'Không thể kết nối đến server.'
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

<!-- Auto-refresh script -->
<script>
// Tự động refresh trang mỗi 60 giây để cập nhật lịch trình hiện tại
setTimeout(function() {
    location.reload();
}, 60000);
</script>
