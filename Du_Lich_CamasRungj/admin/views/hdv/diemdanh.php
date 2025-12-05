<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh Sách Hành Khách & Điểm Danh</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . ($_GET['hdv_id'] ?? '') ?>">Quản Lý HDV</a></li>
                        <li class="breadcrumb-item active">Điểm Danh</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users"></i> Danh Sách Hành Khách & Điểm Danh
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Hướng dẫn điểm danh -->
                            <div class="alert alert-info mb-4" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-left: 4px solid #0284c7;">
                                <h5 class="mb-3">
                                    <i class="fas fa-info-circle"></i> 
                                    <strong>Hướng Dẫn Điểm Danh</strong>
                                </h5>
                                <ul class="mb-0" style="list-style: none; padding-left: 0;">
                                    <li class="mb-2">
                                        <i class="fas fa-clock text-primary"></i> 
                                        <strong>8h30</strong> - Điểm danh tại sân bay
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-clock text-primary"></i> 
                                        <strong>12h</strong> - Điểm danh tại khách sạn
                                    </li>
                                    <li class="mb-0">
                                        <i class="fas fa-clock text-primary"></i> 
                                        <strong>20h40</strong> - Điểm danh xuống máy bay
                                    </li>
                                </ul>
                            </div>
                            
                            <?php if (!empty($data)): ?>
                            <!-- Form điểm danh -->
                            <form id="formDiemDanh" method="POST" action="<?= BASE_URL_ADMIN ?>?act=hdv-diem-danh-action">
                                <input type="hidden" name="lich_id" value="<?= $_GET['lich_id'] ?? '' ?>">
                                <input type="hidden" name="hdv_id" value="<?= $_GET['hdv_id'] ?? '' ?>">
                                
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">STT</th>
                                                <th style="width: 18%;">Tên Hành Khách</th>
                                                <th style="width: 12%;">CCCD</th>
                                                <th style="width: 12%;">Số Điện Thoại</th>
                                                <th style="width: 18%;">Yêu Cầu Đặc Biệt</th>
                                                <th style="width: 10%;">Trạng Thái</th>
                                                <th style="width: 15%;">Thời Gian</th>
                                                <th style="width: 10%;">Điểm Danh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($data as $item): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                            <td><strong><?php echo htmlspecialchars($item['ho_ten']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($item['cccd'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($item['so_dien_thoai'] ?? ''); ?></td>
                                            <td>
                                                <?php if (!empty($item['ghi_chu'])): ?>
                                                    <span class="text-warning">
                                                        <i class="fas fa-star"></i> <?php echo htmlspecialchars($item['ghi_chu']); ?>
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
                                                $totalKhach = count($data);
                                                $daCoMat = 0;
                                                foreach ($data as $item) {
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
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i> Chưa có khách hàng nào trong tour này
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Cải thiện giao diện bảng */
.table {
    border-collapse: collapse;
    border-spacing: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
    width: 100%;
    table-layout: fixed;
}

.table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.table thead th {
    border: none;
    border-right: 1px solid rgba(255,255,255,0.2);
    padding: 16px 12px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.table thead th:last-child {
    border-right: none;
}

.table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e9ecef;
}

.table tbody td {
    border-right: 1px solid #e9ecef;
}

.table tbody td:last-child {
    border-right: none;
}

.table tbody tr:hover {
    background-color: #f8f9ff;
    transform: scale(1.01);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.table tbody td {
    padding: 14px 12px;
    vertical-align: middle;
    border-top: none;
    white-space: nowrap;
}

.table tbody td:nth-child(5) {
    white-space: normal;
    max-width: 200px;
    word-wrap: break-word;
}

.table tbody td:nth-child(5) .text-warning {
    color: #f39c12 !important;
    font-weight: 500;
}

.table tbody td:nth-child(5) .text-warning i {
    margin-right: 5px;
    color: #f39c12;
}

/* Badge trạng thái */
.badge {
    padding: 6px 12px;
    font-size: 0.85rem;
    font-weight: 500;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.badge-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(86, 171, 47, 0.3);
}

.badge-danger {
    background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(235, 51, 73, 0.3);
}

/* Nút điểm danh */
.btn-diem-danh {
    border-radius: 6px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-diem-danh:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-success.btn-diem-danh {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
    color: white;
}

.btn-success.btn-diem-danh:hover {
    background: linear-gradient(135deg, #4a9625 0%, #96d055 100%);
}

.btn-warning.btn-diem-danh {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.btn-warning.btn-diem-danh:hover {
    background: linear-gradient(135deg, #e081e9 0%, #e3455a 100%);
}

/* Card header */
.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
    padding: 20px;
    border-radius: 8px 8px 0 0;
}

.card-header .card-title {
    color: white;
    font-weight: 600;
    font-size: 1.25rem;
    margin: 0;
}

.card-header .card-title i {
    margin-right: 10px;
    font-size: 1.3rem;
}

/* Card body */
.card-body {
    padding: 25px;
    background-color: #ffffff;
}

/* Alert */
.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    padding: 16px 20px;
}

.alert-info {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #0369a1;
}

/* Responsive */
@media (max-width: 768px) {
    .table {
        font-size: 0.875rem;
    }
    
    .table thead th {
        padding: 12px 8px;
        font-size: 0.75rem;
    }
    
    .table tbody td {
        padding: 10px 8px;
    }
    
    .btn-diem-danh {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
}
</style>

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
        
        document.getElementById('tongKhach').textContent = total;
        document.getElementById('daCoMat').textContent = checked;
        document.getElementById('vangMat').textContent = absent;
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