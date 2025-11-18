<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm Nhật Ký Tour</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . ($_GET['hdv_id'] ?? 'all') . "&tab=nhat-ky" ?>">Nhật Ký Tour</a></li>
                        <li class="breadcrumb-item active">Thêm Nhật Ký</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-plus"></i> Thêm Nhật Ký Tour Mới
                            </h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=hdv-them-nhat-ky' ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="hdv_id">Hướng Dẫn Viên <span class="text-danger">*</span></label>
                                    <select class="form-control" id="hdv_id" name="hdv_id" required>
                                        <option value="">-- Chọn Hướng Dẫn Viên --</option>
                                        <?php if (!empty($allHDV)): ?>
                                            <?php 
                                            $selectedHDVId = $_GET['hdv_id'] ?? ($allHDV[0]['hdv_id'] ?? '');
                                            foreach ($allHDV as $hdv): 
                                            ?>
                                                <option value="<?= $hdv['hdv_id'] ?>" <?= $selectedHDVId == $hdv['hdv_id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($hdv['ho_ten']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tour_id">Tour <span class="text-danger">*</span></label>
                                    <select class="form-control" id="tour_id" name="tour_id" required>
                                        <option value="">-- Chọn Tour --</option>
                                        <?php if (!empty($toursData)): ?>
                                            <?php 
                                            $uniqueTours = [];
                                            foreach ($toursData as $tour): 
                                                if (!isset($uniqueTours[$tour['tour_id']])):
                                                    $uniqueTours[$tour['tour_id']] = $tour['ten_tour'];
                                            ?>
                                                <option value="<?= $tour['tour_id'] ?>">
                                                    <?= htmlspecialchars($tour['ten_tour']) ?>
                                                </option>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="lich_id">Lịch Khởi Hành <span class="text-danger">*</span></label>
                                    <select class="form-control" id="lich_id" name="lich_id" required>
                                        <option value="">-- Chọn Lịch --</option>
                                        <?php if (!empty($toursData)): ?>
                                            <?php foreach ($toursData as $tour): ?>
                                                <option value="<?= $tour['lich_id'] ?>" data-tour-id="<?= $tour['tour_id'] ?>">
                                                    <?= htmlspecialchars($tour['ten_tour']) ?> - <?= date('d/m/Y', strtotime($tour['ngay_bat_dau'])) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dia_diem_id">Địa Điểm <span class="text-danger">*</span></label>
                                    <select class="form-control" id="dia_diem_id" name="dia_diem_id" required>
                                        <option value="">-- Chọn Địa Điểm --</option>
                                        <?php if (!empty($diaDiemData)): ?>
                                            <?php foreach ($diaDiemData as $diaDiem): ?>
                                                <option value="<?= $diaDiem['dia_diem_id'] ?>">
                                                    <?= htmlspecialchars($diaDiem['ten']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="noi_dung">Nội Dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="noi_dung" name="noi_dung" rows="5" placeholder="Nhập nội dung nhật ký tour..." required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="anh_tour">Ảnh Tour</label>
                                    <input type="file" class="form-control-file" id="anh_tour" name="anh_tour" accept="image/*">
                                    <small class="form-text text-muted">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 5MB</small>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Lưu Nhật Ký
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . ($_GET['hdv_id'] ?? 'all') . "&tab=nhat-ky" ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Hướng Dẫn
                            </h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Lưu ý khi thêm nhật ký:</strong></p>
                            <ul>
                                <li>Chọn tour và lịch khởi hành tương ứng</li>
                                <li>Chọn địa điểm trên tour</li>
                                <li>Mô tả chi tiết nội dung và sự kiện trong ngày</li>
                                <li>Tải ảnh minh họa (tùy chọn)</li>
                                <li>Nhấn "Lưu Nhật Ký" để hoàn thành</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-danger {
        color: #dc3545;
    }

    .card-footer {
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .card-footer .btn {
        margin-right: 5px;
    }
</style>

<script>
// Load tours and schedules when HDV changes
document.addEventListener('DOMContentLoaded', function() {
    const hdvSelect = document.getElementById('hdv_id');
    const tourSelect = document.getElementById('tour_id');
    const lichSelect = document.getElementById('lich_id');
    
    // Auto-sync tour_id when lich_id changes
    if (lichSelect && tourSelect) {
        lichSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const tourId = selectedOption.getAttribute('data-tour-id');
            if (tourId) {
                tourSelect.value = tourId;
            }
        });
    }
    
    // Load tours and schedules when HDV is selected
    if (hdvSelect) {
        hdvSelect.addEventListener('change', function() {
            const hdvId = this.value;
            if (!hdvId) {
                // Clear tours and schedules if no HDV selected
                tourSelect.innerHTML = '<option value="">-- Chọn Tour --</option>';
                lichSelect.innerHTML = '<option value="">-- Chọn Lịch --</option>';
                return;
            }
            
            // Load tours and schedules via AJAX
            fetch('<?= BASE_URL_ADMIN ?>?act=hdv-get-tours&hdv_id=' + hdvId)
                .then(response => response.json())
                .then(data => {
                    // Update tour dropdown
                    tourSelect.innerHTML = '<option value="">-- Chọn Tour --</option>';
                    if (data.tours && data.tours.length > 0) {
                        const uniqueTours = {};
                        data.tours.forEach(tour => {
                            if (!uniqueTours[tour.tour_id]) {
                                uniqueTours[tour.tour_id] = tour.ten_tour;
                                const option = document.createElement('option');
                                option.value = tour.tour_id;
                                option.textContent = tour.ten_tour;
                                tourSelect.appendChild(option);
                            }
                        });
                    }
                    
                    // Update schedule dropdown
                    lichSelect.innerHTML = '<option value="">-- Chọn Lịch --</option>';
                    if (data.tours && data.tours.length > 0) {
                        data.tours.forEach(tour => {
                            const option = document.createElement('option');
                            option.value = tour.lich_id;
                            option.setAttribute('data-tour-id', tour.tour_id);
                            const dateStr = new Date(tour.ngay_bat_dau).toLocaleDateString('vi-VN');
                            option.textContent = tour.ten_tour + ' - ' + dateStr;
                            lichSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading tours:', error);
                });
        });
    }
});
</script>
