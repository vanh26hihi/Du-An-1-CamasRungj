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
                                            <th style="width: 10%;">Hành Động</th>
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
                                            <td><?php echo !empty($item['thoi_gian']) ? date('d/m/Y H:i', strtotime($item['thoi_gian'])) : 'Chưa điểm danh'; ?></td>
                                            <td class="text-center">
                                                <?php if (isset($item['da_den']) && $item['da_den']): ?>
                                                    <button class="btn btn-sm btn-warning btn-diem-danh" 
                                                            data-hanh-khach-id="<?= $item['hanh_khach_id'] ?>"
                                                            data-lich-id="<?= $_GET['lich_id'] ?>"
                                                            data-hdv-id="<?= $_GET['hdv_id'] ?>"
                                                            title="Chuyển sang Vắng">
                                                        <i class="fas fa-times"></i> Vắng
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-success btn-diem-danh" 
                                                            data-hanh-khach-id="<?= $item['hanh_khach_id'] ?>"
                                                            data-lich-id="<?= $_GET['lich_id'] ?>"
                                                            data-hdv-id="<?= $_GET['hdv_id'] ?>"
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
    const buttons = document.querySelectorAll('.btn-diem-danh');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const hanhKhachId = this.getAttribute('data-hanh-khach-id');
            const lichId = this.getAttribute('data-lich-id');
            const hdvId = this.getAttribute('data-hdv-id');
            
            const currentStatus = this.closest('tr').querySelector('.badge-success') ? 'Có mặt' : 'Vắng';
            const newStatus = currentStatus === 'Có mặt' ? 'Vắng' : 'Có mặt';
            
            if (confirm('Xác nhận chuyển trạng thái từ "' + currentStatus + '" sang "' + newStatus + '" cho khách hàng này?')) {
                // Redirect to attendance action
                window.location.href = '<?= BASE_URL_ADMIN ?>?act=hdv-diem-danh-action&hanh_khach_id=' + hanhKhachId + '&lich_id=' + lichId + '&hdv_id=' + hdvId;
            }
        });
    });
});
</script>