
<!-- header  -->
<?php require_once './views/layout/header.php'; ?>

<style>
    .nav-tabs .nav-link {
        min-width: 150px;
        text-align: center;
        margin-right: 5px;
        color: inherit;
    }

    #tourInfo {
        border-radius: 5px;
    }

    #tourInfo p {
        margin-bottom: 8px;
    }

    #addHDV {
        padding: 8px 20px;
        border-radius: 5px;
    }

    .card-header .btn-danger {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }

    .card-header {
        position: relative;
        font-weight: 600;
    }

    .card-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .card-footer .btn {
        min-width: 100px;
        padding: 8px 16px;
        border-radius: 5px;
    }

    .form-control,
    select.form-control {
        border-radius: 5px;
    }

    .tab-content {
        padding: 20px;
    }



    .hdv-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .hdv-item {
        margin-bottom: 0;
    }

    @media (max-width: 992px) {
        .hdv-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .hdv-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>

<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sửa Lịch Khởi Hành</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="<?= BASE_URL_ADMIN ?>?act=post-sua-tour" method="POST">
                        <input type="hidden" name="lich_id" value="<?= $lichKhoiHanh['lich_id'] ?>">

                        <div class="card card-outline card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="editTourTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab1-link" data-toggle="pill" href="#tab1" role="tab">
                                            <i class="fas fa-info-circle"></i> Thông tin
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab2-link" data-toggle="pill" href="#tab2" role="tab">
                                            <i class="fas fa-users"></i> Hướng Dẫn Viên
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab3-link" data-toggle="pill" href="#tab3" role="tab">
                                            <i class="fas fa-building"></i> Nhà Cung Cấp
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="editTourTabContent">
                                    <!-- TAB 1: Thông tin tour & Lịch khởi hành -->
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <h5 class="mb-3"><i class="fas fa-info-circle"></i> Chọn Tour</h5>
                                        <div class="form-group">
                                            <label for="tour_id">Tour <span class="text-danger">*</span></label>
                                            <select class="form-control <?= isset($error['tour_id']) ? 'is-invalid' : '' ?>" id="tour_id" name="tour_id" required>
                                                <option value="" disabled selected>-- Chọn tour --</option>
                                                <?php foreach ($allTours as $t): ?>
                                                    <option value="<?= $t['tour_id'] ?>" <?= $lichKhoiHanh['tour_id'] == $t['tour_id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($t['ten']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (isset($error['tour_id'])): ?>
                                                <div class="invalid-feedback d-block"><?= $error['tour_id'] ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div id="tourInfo" class="alert alert-info" style="display:block;">
                                            <h6><strong>Thông tin tour:</strong></h6>
                                            <p><strong>Tên tour:</strong> <span id="info_ten_tour"><?= htmlspecialchars($tour['ten']) ?></span></p>
                                            <p><strong>Giá cơ bản:</strong> <span id="info_gia"><?= number_format($tour['gia_co_ban'], 0, ',', '.') ?> VND</span></p>
                                            <p><strong>Điểm khởi hành:</strong> <span id="info_diem_kh"><?= htmlspecialchars($tour['diem_khoi_hanh']) ?></span></p>
                                            <p><strong>Thời lượng:</strong> <span id="info_thoi_luong"><?= $tour['thoi_luong_mac_dinh'] ?></span> ngày</p>
                                        </div>

                                        <hr class="my-4">

                                        <div id="lichKhoiHanhSection">
                                            <h5 class="mb-3"><i class="fas fa-calendar-alt"></i> Lịch Khởi Hành</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="ngay_bat_dau">Ngày bắt đầu <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control <?= isset($error['ngay_bat_dau']) ? 'is-invalid' : '' ?>"
                                                            id="ngay_bat_dau" name="ngay_bat_dau"
                                                            value="<?= $lichKhoiHanh['ngay_bat_dau'] ?>"
                                                            min="<?= date('Y-m-d') ?>">
                                                        <?php if (isset($error['ngay_bat_dau'])): ?>
                                                            <div class="invalid-feedback d-block"><?= $error['ngay_bat_dau'] ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="ngay_ket_thuc">Ngày kết thúc <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control <?= isset($error['ngay_ket_thuc']) ? 'is-invalid' : '' ?>"
                                                            id="ngay_ket_thuc" name="ngay_ket_thuc"
                                                            value="<?= $lichKhoiHanh['ngay_ket_thuc'] ?>"
                                                            min="<?= date('Y-m-d') ?>" readonly>
                                                        <?php if (isset($error['ngay_ket_thuc'])): ?>
                                                            <div class="invalid-feedback d-block"><?= $error['ngay_ket_thuc'] ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="trang_thai_id">Trạng thái <span class="text-danger">*</span></label>
                                                        <select class="form-control <?= isset($error['trang_thai_id']) ? 'is-invalid' : '' ?>" id="trang_thai_id" name="trang_thai_id">
                                                            <option value="" disabled selected>-- Chọn trạng thái --</option>
                                                            <?php
                                                            $currentTrangThaiId = $_SESSION['old']['trang_thai_id'] ?? $lichKhoiHanh['trang_thai_id'];
                                                            foreach ($dsTrangThai as $tt): ?>
                                                                <option value="<?= $tt['trang_thai_id'] ?>" <?= $currentTrangThaiId == $tt['trang_thai_id'] ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($tt['ten_trang_thai']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php if (isset($error['trang_thai_id'])): ?>
                                                            <div class="invalid-feedback d-block"><?= $error['trang_thai_id'] ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="ghi_chu">Ghi chú</label>
                                                        <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3"><?= $_SESSION['old']['ghi_chu'] ?? $lichKhoiHanh['ghi_chu'] ?? '' ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 2: Hướng Dẫn Viên -->
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <button type="button" class="btn btn-success btn-sm mb-3" id="addHDV">
                                            <i class="fas fa-plus"></i> Thêm HDV
                                        </button>

                                        <div id="hdvList" class="hdv-grid">
                                            <?php if (!empty($hdvList)): ?>
                                                <?php foreach ($hdvList as $index => $hdvItem): ?>
                                                    <div class="card card-info hdv-item">
                                                        <div class="card-header">
                                                            <span class="hdv-number">HDV <?= $index + 1 ?></span>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeHDVCard(this)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Chọn HDV <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="hdv_id[]" required>
                                                                    <option value="" disabled selected>-- Chọn --</option>
                                                                    <?php foreach ($allHDV as $hdv): ?>
                                                                        <option value="<?= $hdv['hdv_id'] ?>" <?= $hdvItem['hdv_id'] == $hdv['hdv_id'] ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($hdv['ho_ten']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Vai trò <span class="text-danger">*</span></label>
                                                                <?php
                                                                $roleVal = strtolower(trim($hdvItem['vai_tro'] ?? ''));
                                                                if (in_array($roleVal, ['trưởng đoàn', 'truong doan'])) {
                                                                    $roleVal = 'main';
                                                                }
                                                                if (in_array($roleVal, ['hỗ trợ', 'ho tro'])) {
                                                                    $roleVal = 'support';
                                                                }
                                                                ?>
                                                                <select class="form-control" name="vai_tro[]" required>
                                                                    <option value="" disabled selected>-- Chọn vai trò --</option>
                                                                    <option value="main" <?= $roleVal == 'main' ? 'selected' : '' ?>>Chính</option>
                                                                    <option value="support" <?= $roleVal == 'support' ? 'selected' : '' ?>>Hỗ trợ</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- TAB 3: Nhà Cung Cấp Dịch Vụ -->
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card card-outline card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><i class="fas fa-bus"></i> Vận Chuyển</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="transport_id">Chọn nhà cung cấp <span class="text-danger">*</span></label>
                                                            <?php $currentTransportId = $_SESSION['old']['transport_id'] ?? $lichKhoiHanh['transport_id'] ?? ''; ?>
                                                            <select class="form-control service-select" id="transport_id" name="transport_id" data-info="transportInfo" required>
                                                                <option value="" disabled selected>-- Chọn Nhà Cung Cấp--</option>
                                                                <?php foreach ($transportServices as $service): ?>
                                                                    <option value="<?= $service['dich_vu_id'] ?>" data-gia="<?= $service['gia_mac_dinh'] ?>" <?= $currentTransportId == $service['dich_vu_id'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($service['ten_nha_cung_cap']) ?> - <?= htmlspecialchars($service['ten_dich_vu']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div id="transportInfo" class="mb-2" style="<?= !empty($currentTransportId) ? 'display:block;' : 'display:none;' ?>">
                                                            <div class="alert alert-info py-2">
                                                                <i class="fas fa-info-circle"></i> <strong>Giá thỏa thuận:</strong> <span id="transportGiaDisplay" class="text-primary font-weight-bold">0</span> VNĐ
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="transport_ghi_chu">Ghi chú</label>
                                                            <?php $currentTransportGhiChu = $_SESSION['old']['transport_ghi_chu'] ?? $lichKhoiHanh['transport_ghi_chu'] ?? ''; ?>
                                                            <textarea class="form-control" id="transport_ghi_chu" name="transport_ghi_chu" rows="2" placeholder="Ghi chú về dịch vụ vận chuyển"><?= htmlspecialchars($currentTransportGhiChu) ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="card card-outline card-success">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><i class="fas fa-hotel"></i> Khách Sạn</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="hotel_id">Chọn nhà cung cấp <span class="text-danger">*</span></label>
                                                            <?php $currentHotelId = $_SESSION['old']['hotel_id'] ?? $lichKhoiHanh['hotel_id'] ?? ''; ?>
                                                            <select class="form-control service-select" id="hotel_id" name="hotel_id" data-info="hotelInfo" required>
                                                                <option value="" disabled <?= empty($currentHotelId) ? 'selected' : ''; ?>>-- Chọn --</option>
                                                                <?php foreach ($hotelServices as $service): ?>
                                                                    <option value="<?= $service['dich_vu_id'] ?>" data-gia="<?= $service['gia_mac_dinh'] ?>" <?= $currentHotelId == $service['dich_vu_id'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($service['ten_nha_cung_cap']) ?> - <?= htmlspecialchars($service['ten_dich_vu']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div id="hotelInfo" class="mb-2" style="<?= !empty($currentHotelId) ? 'display:block;' : 'display:none;' ?>">
                                                            <div class="alert alert-info py-2">
                                                                <i class="fas fa-info-circle"></i> <strong>Giá thỏa thuận:</strong> <span id="hotelGiaDisplay" class="text-primary font-weight-bold">0</span> VNĐ
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="hotel_ghi_chu">Ghi chú</label>
                                                            <?php $currentHotelGhiChu = $_SESSION['old']['hotel_ghi_chu'] ?? $lichKhoiHanh['hotel_ghi_chu'] ?? ''; ?>
                                                            <textarea class="form-control" id="hotel_ghi_chu" name="hotel_ghi_chu" rows="2" placeholder="Ghi chú về dịch vụ khách sạn"><?= htmlspecialchars($currentHotelGhiChu) ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="card card-outline card-warning">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><i class="fas fa-utensils"></i> Ăn Uống</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="catering_id">Chọn nhà cung cấp <span class="text-danger">*</span></label>
                                                            <?php $currentCateringId = $_SESSION['old']['catering_id'] ?? $lichKhoiHanh['catering_id'] ?? ''; ?>
                                                            <select class="form-control service-select" id="catering_id" name="catering_id" data-info="cateringInfo" required>
                                                                <option value="" disabled <?= empty($currentCateringId) ? 'selected' : ''; ?>>-- Chọn --</option>
                                                                <?php foreach ($cateringServices as $service): ?>
                                                                    <option value="<?= $service['dich_vu_id'] ?>" data-gia="<?= $service['gia_mac_dinh'] ?>" <?= $currentCateringId == $service['dich_vu_id'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($service['ten_nha_cung_cap']) ?> - <?= htmlspecialchars($service['ten_dich_vu']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div id="cateringInfo" class="mb-2" style="<?= !empty($currentCateringId) ? 'display:block;' : 'display:none;' ?>">
                                                            <div class="alert alert-info py-2">
                                                                <i class="fas fa-info-circle"></i> <strong>Giá thỏa thuận:</strong> <span id="cateringGiaDisplay" class="text-primary font-weight-bold">0</span> VNĐ
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="catering_ghi_chu">Ghi chú</label>
                                                            <?php $currentCateringGhiChu = $_SESSION['old']['catering_ghi_chu'] ?? $lichKhoiHanh['catering_ghi_chu'] ?? ''; ?>
                                                            <textarea class="form-control" id="catering_ghi_chu" name="catering_ghi_chu" rows="2" placeholder="Ghi chú về dịch vụ ăn uống"><?= htmlspecialchars($currentCateringGhiChu) ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Lưu thay đổi
                                </button>
                                <a href="<?= BASE_URL_ADMIN ?>?act=quan-ly-tour" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>

<script>
    let currentTourData = <?= json_encode($tour) ?>;

    function addHDVCard() {
        const hdvList = document.getElementById('hdvList');
        const hdvCount = hdvList.querySelectorAll('.hdv-item').length + 1;

        const cardHTML = `
      <div class="card card-info hdv-item">
        <div class="card-header">
          <span class="hdv-number">HDV ${hdvCount}</span>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeHDVCard(this)">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Chọn HDV <span class="text-danger">*</span></label>
            <select class="form-control" name="hdv_id[]" required>
              <option value="">-- Chọn --</option>
              <?php foreach ($allHDV as $hdv): ?>
                <option value="<?= $hdv['hdv_id'] ?>"><?= htmlspecialchars($hdv['ho_ten']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Vai trò <span class="text-danger">*</span></label>
            <select class="form-control" name="vai_tro[]" required>
              <option value="" disabled selected>-- Chọn vai trò --</option>
              <option value="main">Chính</option>
              <option value="support">Hỗ trợ</option>
            </select>
          </div>
        </div>
      </div>
    `;

        hdvList.insertAdjacentHTML('beforeend', cardHTML);
    }

    function removeHDVCard(btn) {
        const hdvList = document.getElementById('hdvList');
        const hdvItems = hdvList.querySelectorAll('.hdv-item');

        if (hdvItems.length <= 1) {
            alert('Phải có ít nhất 1 hướng dẫn viên!');
            return;
        }

        btn.closest('.hdv-item').remove();
        updateHDVNumbers();
    }

    function updateHDVNumbers() {
        const hdvItems = document.querySelectorAll('.hdv-item');
        hdvItems.forEach((item, index) => {
            const numberSpan = item.querySelector('.hdv-number');
            if (numberSpan) {
                numberSpan.textContent = 'HDV ' + (index + 1);
            }
        });
    }

    function loadTourInfo(tourId) {
        if (!tourId) {
            document.getElementById('tourInfo').style.display = 'none';
            return;
        }

        fetch('<?= BASE_URL_ADMIN ?>?act=get-tour-info&tour_id=' + tourId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentTourData = data.data;

                    document.getElementById('info_ten_tour').textContent = data.data.ten;
                    document.getElementById('info_gia').textContent = new Intl.NumberFormat('vi-VN').format(data.data.gia_co_ban) + ' VND';
                    document.getElementById('info_diem_kh').textContent = data.data.diem_khoi_hanh;
                    document.getElementById('info_thoi_luong').textContent = data.data.thoi_luong_mac_dinh;

                    document.getElementById('tourInfo').style.display = 'block';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Lỗi khi tải thông tin tour');
            });
    }

    function validateDates() {
        const ngayBatDau = document.getElementById('ngay_bat_dau').value;
        const ngayKetThuc = document.getElementById('ngay_ket_thuc').value;

        clearDateError();

        if (!ngayBatDau || !ngayKetThuc) return true;

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const startDate = new Date(ngayBatDau);
        const endDate = new Date(ngayKetThuc);

        if (startDate < today) {
            showDateError('ngay_bat_dau', 'Ngày bắt đầu không được nhỏ hơn ngày hiện tại');
            return false;
        }

        if (endDate < startDate) {
            showDateError('ngay_ket_thuc', 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu');
            return false;
        }

        if (currentTourData && currentTourData.thoi_luong_mac_dinh) {
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            if (diffDays != currentTourData.thoi_luong_mac_dinh) {
                showDateError('ngay_ket_thuc', `Tổng số ngày phải bằng ${currentTourData.thoi_luong_mac_dinh} ngày`);
                return false;
            }
        }

        return true;
    }

    function showDateError(fieldId, message) {
        const field = document.getElementById(fieldId);
        field.classList.add('is-invalid');

        let errorDiv = field.parentElement.querySelector('.date-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback d-block date-error';
            field.parentElement.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }

    function clearDateError() {
        document.querySelectorAll('.date-error').forEach(el => el.remove());
        document.querySelectorAll('#ngay_bat_dau, #ngay_ket_thuc').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    function autoCalculateEndDate() {
        const ngayBatDau = document.getElementById('ngay_bat_dau').value;

        if (!ngayBatDau || !currentTourData || !currentTourData.thoi_luong_mac_dinh) {
            return;
        }

        const startDate = new Date(ngayBatDau);
        const duration = parseInt(currentTourData.thoi_luong_mac_dinh);

        // Tính ngày kết thúc = ngày bắt đầu + (thời lượng - 1) ngày
        const endDate = new Date(startDate);
        endDate.setDate(startDate.getDate() + (duration - 1));

        // Format thành YYYY-MM-DD
        const year = endDate.getFullYear();
        const month = String(endDate.getMonth() + 1).padStart(2, '0');
        const day = String(endDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        document.getElementById('ngay_ket_thuc').value = formattedDate;
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addHDV').addEventListener('click', addHDVCard);

        document.getElementById('tour_id').addEventListener('change', function() {
            const tourId = this.value;
            if (tourId) {
                loadTourInfo(tourId);
            } else {
                document.getElementById('tourInfo').style.display = 'none';
            }
        });

        document.getElementById('ngay_bat_dau').addEventListener('change', function() {
            autoCalculateEndDate();
            validateDates();
        });

        document.getElementById('ngay_ket_thuc').addEventListener('change', validateDates);

        // Xử lý hiển thị giá mặc định khi chọn dịch vụ
        document.querySelectorAll('.service-select').forEach(select => {
            // Hiển thị giá ban đầu nếu đã có dịch vụ được chọn
            if (select.value) {
                const selectedOption = select.options[select.selectedIndex];
                const giaMacDinh = selectedOption.getAttribute('data-gia') || 0;
                const infoId = select.getAttribute('data-info');
                const infoDiv = document.getElementById(infoId);

                if (infoDiv) {
                    infoDiv.style.display = 'block';
                    let displaySpanId = '';
                    if (infoId === 'transportInfo') displaySpanId = 'transportGiaDisplay';
                    else if (infoId === 'hotelInfo') displaySpanId = 'hotelGiaDisplay';
                    else if (infoId === 'cateringInfo') displaySpanId = 'cateringGiaDisplay';

                    const displaySpan = document.getElementById(displaySpanId);
                    if (displaySpan) {
                        displaySpan.textContent = new Intl.NumberFormat('vi-VN').format(giaMacDinh);
                    }
                }
            }

            // Xử lý khi thay đổi select
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const giaMacDinh = selectedOption.getAttribute('data-gia') || 0;
                const infoId = this.getAttribute('data-info');

                const infoDiv = document.getElementById(infoId);
                if (this.value) {
                    infoDiv.style.display = 'block';

                    let displaySpanId = '';
                    if (infoId === 'transportInfo') displaySpanId = 'transportGiaDisplay';
                    else if (infoId === 'hotelInfo') displaySpanId = 'hotelGiaDisplay';
                    else if (infoId === 'cateringInfo') displaySpanId = 'cateringGiaDisplay';

                    const displaySpan = document.getElementById(displaySpanId);
                    if (displaySpan) {
                        displaySpan.textContent = new Intl.NumberFormat('vi-VN').format(giaMacDinh);
                    }
                } else {
                    infoDiv.style.display = 'none';
                }
            });
        });
    });
</script>

</body>

</html>
