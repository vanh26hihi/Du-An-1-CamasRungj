<!-- header  -->
<?php require_once './views/layout/header.php'; ?>

<style>
  /* Căn đều các nút trong tabs */
  .nav-tabs .nav-link {
    min-width: 150px;
    text-align: center;
    margin-right: 5px;
  }

  /* Card HDV và Lịch trình */
  .card {
    border-radius: 5px;
  }

  /* Thông info tour */
  #tourInfo {
    border-radius: 5px;
  }

  #tourInfo p {
    margin-bottom: 8px;
  }

  /* Nút thêm HDV */
  #addHDV {
    padding: 8px 20px;
    border-radius: 5px;
  }

  /* Nút xóa HDV */
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

  /* Footer buttons */
  .card-footer .btn {
    min-width: 100px;
    padding: 8px 16px;
    border-radius: 5px;
    margin-right: 10px;
  }

  /* Form controls */
  .form-control,
  select.form-control {
    border-radius: 5px;
  }

  /* Tab content padding */
  .tab-content {
    padding: 20px;
  }

  /* Service cards trong tab 4 */
  .card-outline {
    border: 2px solid;
    border-radius: 5px;
  }
</style>

<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thêm Tour Mới</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Thêm Tour</h3>
            </div>
            <!-- /.card-header -->

            <!-- Tabs Navigation -->
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="tab1-link" data-toggle="pill" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">
                    <i class="fas fa-info-circle"></i> Thông tin tour
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tab3-link" data-toggle="pill" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">
                    <i class="fas fa-user-tie"></i> Hướng dẫn viên
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tab4-link" data-toggle="pill" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">
                    <i class="fas fa-briefcase"></i> Nhà cung cấp dịch vụ
                  </a>
                </li>
              </ul>
            </div>

            <!-- form start -->
            <form action="<?= BASE_URL_ADMIN . "?act=post-them-tour" ?>" method="POST">
              <div class="card-body">
                <div class="tab-content">

                  <!-- TAB 1: Thông tin Tour & Lịch Khởi Hành -->
                  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-link">
                    <?php $error = $_SESSION['error'] ?? []; ?>

                    <h5 class="mb-3"><i class="fas fa-map-marked-alt"></i> Chọn Tour</h5>
                    <div class="form-group">
                      <label for="tour_id">Tour <span class="text-danger">*</span></label>
                      <select class="form-control" id="tour_id" name="tour_id">
                        <option value="">-- Chọn tour --</option>
                        <?php foreach ($allTours as $tour): ?>
                          <option value="<?= $tour['tour_id'] ?>">
                            <?= $tour['ten'] ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <?php if (isset($error['tour_id'])): ?>
                        <span class="text-danger"><?= $error['tour_id'] ?></span>
                      <?php endif; ?>
                    </div>

                    <!-- Thông tin tour được hiển thị sau khi chọn -->
                    <div id="tourInfo" style="display:none; margin-top:20px; padding:15px; background:#f4f6f9; border-radius:5px;">
                      <h6>Thông tin tour:</h6>
                      <p><strong>Tên:</strong> <span id="tourName"></span></p>
                      <p><strong>Giá:</strong> <span id="tourPrice"></span></p>
                      <p><strong>Điểm khởi hành:</strong> <span id="tourDeparture"></span></p>
                    </div>

                    <hr class="my-4">

                    <!-- Lịch Khởi Hành - Ẩn cho đến khi chọn tour -->
                    <div id="lichKhoiHanhSection" style="display:none;">
                      <h5 class="mb-3"><i class="fas fa-calendar-alt"></i> Lịch Khởi Hành</h5>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="ngay_bat_dau">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?= isset($error['ngay_bat_dau']) ? 'is-invalid' : '' ?>" id="ngay_bat_dau" name="ngay_bat_dau" value="<?= $_SESSION['old']['ngay_bat_dau'] ?? '' ?>" min="<?= date('Y-m-d') ?>">
                            <?php if (isset($error['ngay_bat_dau'])): ?>
                              <div class="invalid-feedback d-block"><?= $error['ngay_bat_dau'] ?></div>
                            <?php endif; ?>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="ngay_ket_thuc">Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?= isset($error['ngay_ket_thuc']) ? 'is-invalid' : '' ?>" id="ngay_ket_thuc" name="ngay_ket_thuc" value="<?= $_SESSION['old']['ngay_ket_thuc'] ?? '' ?>" min="<?= date('Y-m-d') ?>" readonly>
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
                            <select class="form-control" id="trang_thai_id" name="trang_thai_id" style="background-color: #e9ecef;" disabled>
                              <?php foreach ($dsTrangThai as $tt): ?>
                                <option value="<?= $tt['trang_thai_id'] ?>" <?= $tt['ten_trang_thai'] == 'Đang mở' ? 'selected' : '' ?>>
                                  <?= htmlspecialchars($tt['ten_trang_thai']) ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="trang_thai_id" value="1">
                            <small class="text-muted">Trạng thái mặc định là "Đang mở" khi thêm mới</small>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="ghi_chu">Ghi chú</label>
                            <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3" placeholder="Ghi chú thêm"><?= $_SESSION['old']['ghi_chu'] ?? '' ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- TAB 3: Hướng Dẫn Viên -->
                  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-link">
                    <button type="button" class="btn btn-success btn-sm mb-3" id="addHDV">
                      <i class="fas fa-plus"></i> Thêm HDV
                    </button>

                    <div id="hdvList" class="row"></div>
                  </div>

                  <!-- TAB 4: Nhà Cung Cấp Dịch Vụ -->
                  <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-link">
                    <div class="row">
                      <!-- Transport Services -->
                      <div class="col-md-4">
                        <div class="card card-outline card-primary">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-bus"></i> Vận Chuyển</h3>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <label for="transport_id">Chọn nhà cung cấp <span class="text-danger">*</span></label>
                              <select class="form-control service-select" id="transport_id" name="transport_id" data-info="transportInfo">
                                <option value="">-- Chọn --</option>
                                <?php foreach ($transportServices as $service): ?>
                                  <option value="<?= $service['dich_vu_id'] ?>" data-gia="<?= $service['gia_mac_dinh'] ?>">
                                    <?= $service['ten_nha_cung_cap'] ?? 'N/A' ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <?php if (isset($error['transport_id'])): ?>
                                <span class="text-danger"><?= $error['transport_id'] ?></span>
                              <?php endif; ?>
                            </div>
                            <div id="transportInfo" class="mb-2" style="display:none;">
                              <div class="alert alert-info py-2">
                                <i class="fas fa-info-circle"></i> <strong>Giá thỏa thuận:</strong> <span id="transportGiaDisplay" class="text-primary font-weight-bold">0</span> VNĐ
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="transport_ghi_chu">Ghi chú</label>
                              <textarea class="form-control" id="transport_ghi_chu" name="transport_ghi_chu" rows="2" placeholder="Ghi chú về dịch vụ vận chuyển"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Hotel Services -->
                      <div class="col-md-4">
                        <div class="card card-outline card-success">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-hotel"></i> Khách Sạn</h3>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <label for="hotel_id">Chọn nhà cung cấp <span class="text-danger">*</span></label>
                              <select class="form-control service-select" id="hotel_id" name="hotel_id" data-info="hotelInfo">
                                <option value="">-- Chọn --</option>
                                <?php foreach ($hotelServices as $service): ?>
                                  <option value="<?= $service['dich_vu_id'] ?>" data-gia="<?= $service['gia_mac_dinh'] ?>">
                                    <?= $service['ten_nha_cung_cap'] ?? 'N/A' ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <?php if (isset($error['hotel_id'])): ?>
                                <span class="text-danger"><?= $error['hotel_id'] ?></span>
                              <?php endif; ?>
                            </div>
                            <div id="hotelInfo" class="mb-2" style="display:none;">
                              <div class="alert alert-info py-2">
                                <i class="fas fa-info-circle"></i> <strong>Giá thỏa thuận:</strong> <span id="hotelGiaDisplay" class="text-primary font-weight-bold">0</span> VNĐ
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="hotel_ghi_chu">Ghi chú</label>
                              <textarea class="form-control" id="hotel_ghi_chu" name="hotel_ghi_chu" rows="2" placeholder="Ghi chú về dịch vụ khách sạn"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Catering Services -->
                      <div class="col-md-4">
                        <div class="card card-outline card-warning">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-utensils"></i> Ăn Uống</h3>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <label for="catering_id">Chọn nhà cung cấp <span class="text-danger">*</span></label>
                              <select class="form-control service-select" id="catering_id" name="catering_id" data-info="cateringInfo">
                                <option value="">-- Chọn --</option>
                                <?php foreach ($cateringServices as $service): ?>
                                  <option value="<?= $service['dich_vu_id'] ?>" data-gia="<?= $service['gia_mac_dinh'] ?>">
                                    <?= $service['ten_nha_cung_cap'] ?? 'N/A' ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <?php if (isset($error['catering_id'])): ?>
                                <span class="text-danger"><?= $error['catering_id'] ?></span>
                              <?php endif; ?>
                            </div>
                            <div id="cateringInfo" class="mb-2" style="display:none;">
                              <div class="alert alert-info py-2">
                                <i class="fas fa-info-circle"></i> <strong>Giá thỏa thuận:</strong> <span id="cateringGiaDisplay" class="text-primary font-weight-bold">0</span> VNĐ
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="catering_ghi_chu">Ghi chú</label>
                              <textarea class="form-control" id="catering_ghi_chu" name="catering_ghi_chu" rows="2" placeholder="Ghi chú về dịch vụ ăn uống"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- /.card-body -->
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Lưu
                </button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
<!-- End Footer  -->

<script>
  let hdvCount = 0;
  let hdvData = <?= json_encode($allHDV ?? []) ?>;
  let oldData = <?= json_encode($_SESSION['old'] ?? []) ?>;
  let currentTourData = null; // Lưu thông tin tour hiện tại

  console.log('Script loaded successfully');

  function loadTourInfo(tourId) {
    // Gọi AJAX lấy thông tin tour
    fetch('<?= BASE_URL_ADMIN ?>?act=get-tour-info&id=' + tourId)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Lưu thông tin tour
          currentTourData = data.data;

          // Hiển thị thông tin tour
          document.getElementById('tourName').textContent = data.data.ten;

          // Format giá với dấu phẩy
          let price = new Intl.NumberFormat('vi-VN').format(data.data.gia_co_ban);
          document.getElementById('tourPrice').textContent = price + ' VND';

          document.getElementById('tourDeparture').textContent = data.data.diem_khoi_hanh;
          document.getElementById('tourInfo').style.display = 'block';

          // Hiển thị phần Lịch Khởi Hành
          document.getElementById('lichKhoiHanhSection').style.display = 'block';

          // Tạo form lịch trình
          let html = '';
          if (data.data.dia_diem && data.data.dia_diem.length > 0) {
            data.data.dia_diem.forEach((dd, index) => {
              let ngay = index + 1;
              html += `
                <div class="card mb-2">
                  <div class="card-header">Ngày ${ngay}: ${dd.ten_dia_diem}</div>
                  <div class="card-body">
                    <input type="hidden" name="lich_trinh[${index}][ngay_thu]" value="${ngay}">
                    <input type="hidden" name="lich_trinh[${index}][dia_diem_id]" value="${dd.dia_diem_id}">
                    <div class="form-group">
                      <label>Tên địa điểm cụ thể</label>
                      <input type="text" class="form-control" name="lich_trinh[${index}][mo_ta]" placeholder="Ví dụ: Vịnh Hạ Long, Bãi Cháy..." />
                    </div>
                    <div class="form-group">
                      <label>Nội dung lịch trình <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="lich_trinh[${index}][noi_dung]" rows="3" placeholder="Nhập nội dung ngày ${ngay}" required></textarea>
                    </div>
                  </div>
                </div>
              `;
            });
          }
          document.getElementById('lichTrinhContainer').innerHTML = html;
        }
      });
  }

  // Validate ngày bắt đầu và ngày kết thúc
  function validateDates() {
    let ngayBatDau = document.getElementById('ngay_bat_dau').value;
    let ngayKetThuc = document.getElementById('ngay_ket_thuc').value;
    let today = new Date().toISOString().split('T')[0];

    // Clear previous errors
    document.getElementById('ngay_bat_dau').classList.remove('is-invalid');
    document.getElementById('ngay_ket_thuc').classList.remove('is-invalid');
    clearDateError('ngay_bat_dau');
    clearDateError('ngay_ket_thuc');

    // Nếu chưa nhập gì thì không validate
    if (!ngayBatDau && !ngayKetThuc) {
      return true;
    }

    if (ngayBatDau && ngayBatDau < today) {
      document.getElementById('ngay_bat_dau').classList.add('is-invalid');
      showDateError('ngay_bat_dau', 'Ngày bắt đầu không được nhỏ hơn ngày hiện tại');
      return false;
    }

    if (ngayBatDau && ngayKetThuc) {
      if (ngayKetThuc < ngayBatDau) {
        document.getElementById('ngay_ket_thuc').classList.add('is-invalid');
        showDateError('ngay_ket_thuc', 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu');
        return false;
      }

      // Kiểm tra thời lượng tour
      if (currentTourData && currentTourData.thoi_luong_mac_dinh) {
        let date1 = new Date(ngayBatDau);
        let date2 = new Date(ngayKetThuc);
        let diffTime = Math.abs(date2 - date1);
        let soNgay = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        let thoiLuong = parseInt(currentTourData.thoi_luong_mac_dinh);

        if (soNgay !== thoiLuong) {
          document.getElementById('ngay_ket_thuc').classList.add('is-invalid');
          showDateError('ngay_ket_thuc', `Tổng số ngày phải là ${thoiLuong} ngày (theo thời lượng tour)`);
          return false;
        }
      }
    }

    return true;
  }

  function showDateError(fieldId, message) {
    clearDateError(fieldId); // Xóa lỗi cũ trước
    let field = document.getElementById(fieldId);
    let feedback = document.createElement('div');
    feedback.classList.add('invalid-feedback', 'd-block', 'date-error');
    feedback.textContent = message;
    field.parentNode.appendChild(feedback);
  }

  function clearDateError(fieldId) {
    let field = document.getElementById(fieldId);
    let parent = field.parentNode;
    let errors = parent.querySelectorAll('.date-error');
    errors.forEach(err => err.remove());
  }

  // Tự động tính ngày kết thúc khi chọn ngày bắt đầu
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

  // Hàm thêm card HDV
  function addHDVCard() {
    let currentCount = document.querySelectorAll('.hdv-item').length + 1;

    let html = `
      <div class="col-md-4 mb-3 hdv-item">
        <div class="card">
          <div class="card-header">
            <span class="hdv-number">HDV #${currentCount}</span>
            <button type="button" class="btn btn-sm btn-danger btn-remove-hdv">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Chọn HDV <span class="text-danger">*</span></label>
              <select class="form-control hdv-select" name="hdv_id[]">
                <option value="">-- Chọn --</option>
                ${hdvData.map(hdv => `<option value="${hdv.hdv_id}">${hdv.ho_ten}</option>`).join('')}
              </select>
            </div>
            <div class="form-group">
              <label>Vai trò</label>
              <select class="form-control" name="vai_tro[]">
                <option value="main">Chính</option>
                <option value="support">Hỗ trợ</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    `;
    document.getElementById('hdvList').insertAdjacentHTML('beforeend', html);
    attachHDVEvents();
    updateHDVNumbers();
  }

  // Gắn sự kiện cho các nút xóa HDV
  function attachHDVEvents() {
    document.querySelectorAll('.btn-remove-hdv').forEach(btn => {
      btn.onclick = function() {
        removeHDVCard(this);
      };
    });

    // Kiểm tra trùng HDV khi chọn
    document.querySelectorAll('.hdv-select').forEach(select => {
      select.onchange = function() {
        checkDuplicateHDV();
      };
    });
  }

  // Xóa HDV
  function removeHDVCard(btn) {
    let totalHDV = document.querySelectorAll('.hdv-item').length;

    if (totalHDV <= 1) {
      alert('Phải có ít nhất 1 hướng dẫn viên!');
      return;
    }

    btn.closest('.hdv-item').remove();
    updateHDVNumbers();
  }

  // Cập nhật lại số thứ tự HDV
  function updateHDVNumbers() {
    document.querySelectorAll('.hdv-item').forEach((item, index) => {
      item.querySelector('.hdv-number').textContent = 'HDV #' + (index + 1);
    });
  }

  // Kiểm tra HDV trùng
  function checkDuplicateHDV() {
    let selectedHDVs = [];
    let hasDuplicate = false;

    document.querySelectorAll('.hdv-select').forEach(select => {
      let val = select.value;
      if (val && selectedHDVs.includes(val)) {
        hasDuplicate = true;
        select.style.borderColor = 'orange';
      } else {
        select.style.borderColor = '';
        if (val) selectedHDVs.push(val);
      }
    });

    if (hasDuplicate) {
      console.warn('Cảnh báo: Có HDV bị chọn trùng!');
    }
  }

  // Restore dữ liệu cũ khi có lỗi
  window.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');

    // Gắn sự kiện validate cho input date
    document.getElementById('ngay_bat_dau').addEventListener('change', function() {
      autoCalculateEndDate();
      validateDates();
    });

    document.getElementById('ngay_ket_thuc').addEventListener('change', validateDates);

    // Gắn sự kiện thêm HDV
    document.getElementById('addHDV').addEventListener('click', function() {
      addHDVCard();
    });

    // Gắn sự kiện chọn tour
    document.getElementById('tour_id').addEventListener('change', function() {
      let tourId = this.value;
      console.log('Tour selected:', tourId);
      if (tourId) {
        loadTourInfo(tourId);
      } else {
        document.getElementById('tourInfo').style.display = 'none';
        document.getElementById('lichKhoiHanhSection').style.display = 'none';
        document.getElementById('lichTrinhContainer').innerHTML = '<p class="text-muted">Vui lòng chọn tour ở Tab 1.</p>';
        currentTourData = null;
      }
    });

    // Restore tour đã chọn
    if (oldData.tour_id) {
      document.getElementById('tour_id').value = oldData.tour_id;
      loadTourInfo(oldData.tour_id);
      // Hiển thị lịch khởi hành khi có oldData
      document.getElementById('lichKhoiHanhSection').style.display = 'block';
    }

    // Restore HDV
    if (oldData.hdv_id && Array.isArray(oldData.hdv_id)) {
      // Xóa HDV mặc định
      document.querySelectorAll('.hdv-item').forEach(item => item.remove());

      // Thêm lại HDV từ old data
      oldData.hdv_id.forEach((hdvId, index) => {
        addHDVCard();
        let hdvItems = document.querySelectorAll('.hdv-item');
        let lastItem = hdvItems[hdvItems.length - 1];
        let select = lastItem.querySelector('.hdv-select');
        let vaiTroSelect = lastItem.querySelector('select[name="vai_tro[]"]');

        if (select) select.value = hdvId;
        if (vaiTroSelect && oldData.vai_tro && oldData.vai_tro[index]) {
          vaiTroSelect.value = oldData.vai_tro[index];
        }
      });
    } else {
      // Tự động thêm 1 HDV khi load trang (lần đầu)
      addHDVCard();
    }

    // Restore lịch trình nếu có
    if (oldData.lich_trinh && Array.isArray(oldData.lich_trinh)) {
      setTimeout(() => {
        oldData.lich_trinh.forEach((lt, index) => {
          let textarea = document.querySelector(`textarea[name="lich_trinh[${index}][noi_dung]"]`);
          if (textarea && lt.noi_dung) {
            textarea.value = lt.noi_dung;
          }

          // Restore mo_ta nếu có
          let inputMoTa = document.querySelector(`input[name="lich_trinh[${index}][mo_ta]"]`);
          if (inputMoTa && lt.mo_ta) {
            inputMoTa.value = lt.mo_ta;
          }
        });
      }, 500);
    }

    // Restore dịch vụ (Tab 4)
    if (oldData.transport_id) {
      document.getElementById('transport_id').value = oldData.transport_id;
    }
    if (oldData.hotel_id) {
      document.getElementById('hotel_id').value = oldData.hotel_id;
    }
    if (oldData.catering_id) {
      document.getElementById('catering_id').value = oldData.catering_id;
    }

    // Xử lý hiển thị giá mặc định khi chọn dịch vụ
    document.querySelectorAll('.service-select').forEach(select => {
      select.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const giaMacDinh = selectedOption.getAttribute('data-gia') || 0;
        const infoId = this.getAttribute('data-info');

        // Hiển thị thông tin giá mặc định
        const infoDiv = document.getElementById(infoId);
        if (this.value) {
          infoDiv.style.display = 'block';

          // Tìm display element tương ứng
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