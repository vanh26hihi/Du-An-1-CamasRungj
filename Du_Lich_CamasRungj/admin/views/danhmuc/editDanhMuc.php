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
          <h1>Quản lý Danh Mục Tour</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <?php if (!isset($tour)): ?>
            <!-- ==================== FALLBACK: EDIT CATEGORY (NOT TOUR) ==================== -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Sửa Danh Mục Tour</h3>
              </div>
              <form action="?act=post-sua-danh-muc" method="POST">
                <div class="card-body">
                  <input type="hidden" name="id" value="<?= $danhmuc['danh_muc_id'] ?>">
                  
                  <div class="form-group">
                    <label>Tên danh mục</label>
                    <input type="text" class="form-control" name="ten" value="<?= $danhmuc['ten'] ?>" placeholder="Nhập tên danh mục" required>
                  </div>

                  <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="mo_ta" class="form-control" placeholder="Nhập mô tả"><?= $danhmuc['mo_ta'] ?></textarea>
                  </div>

                  <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="trang_thai" class="form-control">
                      <option value="1" <?= $danhmuc['trang_thai'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
                      <option value="0" <?= $danhmuc['trang_thai'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
              </form>
            </div>

          <?php else: ?>

            <!-- ==================== EDIT TOUR FORM ==================== -->
            <div>
              <form id="formEditTour" action="<?= BASE_URL_ADMIN . "?act=post-sua-danh-muc" ?>" method="POST">
                <input type="hidden" name="id" value="<?= $tour['tour_id'] ?>">
                <div class="col-12 col-sm-12">
                  <div class="card card-primary card-tabs">

                    <!-- ==================== TAB NAVIGATION ==================== -->
                    <div class="card-header p-0 pt-1">
                      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="tab-link-tour" data-toggle="pill" href="#tab-tour" role="tab">
                            Thông Tin Danh Mục Tour
                            <span class="badge badge-danger ml-1" id="error-badge-tab1" style="display: none;">!</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab-link-customer" data-toggle="pill" href="#tab-customer" role="tab">
                            Chọn Địa Điểm Tour
                            <span class="badge badge-danger ml-1" id="error-badge-tab2" style="display: none;">!</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab-link-lich-trinh" data-toggle="pill" href="#tab-lich-trinh" role="tab">
                            <i class="fas fa-route"></i> Lịch Trình
                            <span class="badge badge-danger ml-1" id="error-badge-tab3" style="display: none;">!</span>
                          </a>
                        </li>
                      </ul>
                    </div>

                    <div class="card-body">
                      <div class="tab-content">

                        <!-- ==================== TAB 1: THÔNG TIN TOUR ==================== -->
                        <div class="tab-pane fade show active" id="tab-tour" role="tabpanel">
                          <h4>Sửa Thông Tin Danh Mục Tour</h4>

                          <div class="card-body">
                            <div class="row">
                              <!-- Left Column -->
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Tên Danh Mục Tour</label>
                                  <input type="text" class="form-control" name="ten" placeholder="Nhập Tên Danh Mục Tour" value="<?= htmlspecialchars($old['ten'] ?? $tour['ten']) ?>">
                                  <?php if (!empty($error['ten'])): ?>
                                    <p class="text-danger"><?= $error['ten'] ?></p>
                                  <?php endif; ?>
                                </div>

                                <div class="form-group">
                                  <label>Loại Tour</label>
                                  <select name="danh_muc_id" class="form-control">
                                    <option value="" disabled>--Chọn Loại Tour---</option>
                                    <?php foreach ($danhmuc as $dm): ?>
                                      <?php $selected = (isset($old['danh_muc_id']) ? $old['danh_muc_id'] : $tour['danh_muc_id']) == $dm['danh_muc_id']; ?>
                                      <option value="<?= $dm['danh_muc_id'] ?>" <?= $selected ? 'selected' : '' ?>><?= $dm['ten'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                  <?php if (!empty($error['danh_muc_id'])): ?>
                                    <p class="text-danger"><?= $error['danh_muc_id'] ?></p>
                                  <?php endif; ?>
                                </div>

                                <div class="form-group">
                                  <label>Giá Cơ Bản</label>
                                  <input type="number" class="form-control" name="gia_co_ban" placeholder="Nhập Giá Cơ Bản" value="<?= htmlspecialchars($old['gia_co_ban'] ?? $tour['gia_co_ban']) ?>">
                                  <?php if (!empty($error['gia_co_ban'])): ?>
                                    <p class="text-danger"><?= $error['gia_co_ban'] ?></p>
                                  <?php endif; ?>
                                </div>

                                <div class="form-group">
                                  <label>Chính Sách</label>
                                  <input type="text" class="form-control" name="chinh_sach" placeholder="Nhập Chính Sách" value="<?= htmlspecialchars($old['chinh_sach'] ?? $tour['chinh_sach']) ?>">
                                  <?php if (!empty($error['chinh_sach'])): ?>
                                    <p class="text-danger"><?= $error['chinh_sach'] ?></p>
                                  <?php endif; ?>
                                </div>
                              </div>

                              <!-- Right Column -->
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Số Ngày Du Lịch</label>
                                  <input type="number" class="form-control" id="thoi_luong_mac_dinh" name="thoi_luong_mac_dinh" min="1" placeholder="Nhập Số Ngày Du Lịch" value="<?= htmlspecialchars($old['thoi_luong_mac_dinh'] ?? $tour['thoi_luong_mac_dinh']) ?>">
                                  <?php if (!empty($error['thoi_luong_mac_dinh'])): ?>
                                    <p class="text-danger"><?= $error['thoi_luong_mac_dinh'] ?></p>
                                  <?php endif; ?>
                                </div>

                                <div class="form-group">
                                  <label>Điểm Khởi Hành</label>
                                  <input type="text" class="form-control" name="diem_khoi_hanh" placeholder="Nhập Điểm Khởi Hành" value="<?= htmlspecialchars($old['diem_khoi_hanh'] ?? $tour['diem_khoi_hanh']) ?>">
                                  <?php if (!empty($error['diem_khoi_hanh'])): ?>
                                    <p class="text-danger"><?= $error['diem_khoi_hanh'] ?></p>
                                  <?php endif; ?>
                                </div>

                                <div class="form-group">
                                  <label>Mô tả ngắn</label>
                                  <textarea name="mo_ta_ngan" class="form-control" placeholder="Nhập mô tả ngắn"><?= htmlspecialchars($old['mo_ta_ngan'] ?? $tour['mo_ta_ngan']) ?></textarea>
                                  <?php if (!empty($error['mo_ta_ngan'])): ?>
                                    <p class="text-danger"><?= $error['mo_ta_ngan'] ?></p>
                                  <?php endif; ?>
                                </div>

                                <div class="form-group">
                                  <label>Mô tả</label>
                                  <textarea name="mo_ta" class="form-control" placeholder="Nhập mô tả"><?= htmlspecialchars($old['mo_ta'] ?? $tour['mo_ta']) ?></textarea>
                                  <?php if (!empty($error['mo_ta'])): ?>
                                    <p class="text-danger"><?= $error['mo_ta'] ?></p>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- ==================== TAB 2: ĐỊA ĐIỂM ==================== -->
                        <div class="tab-pane fade" id="tab-customer" role="tabpanel">
                          <h4>Chọn Và Nhập Thông Tin Địa Điểm</h4>

                          <div class="card-body">
                            <div id="dia_diem_container">
                              <!-- Địa điểm sẽ được thêm động từ đây -->
                            </div>

                            <button type="button" class="btn btn-success mt-3" id="btn-add-dia-diem">
                              <i class="fas fa-plus"></i> Thêm Địa Điểm
                            </button>

                            <?php if (!empty($error['dia_diem'])): ?>
                              <p class="text-danger mt-2"><?= $error['dia_diem'] ?></p>
                            <?php endif; ?>
                          </div>
                        </div>

                        <!-- ==================== TAB 3: LỊCH TRÌNH ==================== -->
                        <div class="tab-pane fade" id="tab-lich-trinh" role="tabpanel">
                          <div class="mb-3">
                            <h4 class="mb-1"><i class="fas fa-route"></i> Lịch Trình Tour</h4>
                            <p class="text-muted mb-0">Nhập lịch trình cho từng ngày của tour</p>
                          </div>

                          <?php if (!empty($error['lich_trinh'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <i class="fas fa-exclamation-triangle"></i> 
                              <strong>Lỗi:</strong> <?= $error['lich_trinh'] ?>
                              <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                          <?php endif; ?>

                          <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Hướng dẫn:</strong> 
                            Sau khi nhập "Số Ngày Du Lịch" ở "Thông Tin Danh Mục Tour", hệ thống sẽ tự động tạo các ngày tương ứng.
                            Mỗi ngày chọn 1 địa điểm (từ "Chọn Địa Điểm Tour") và có thể thêm nhiều hoạt động.
                            <button type="button" class="close" data-dismiss="alert">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <div class="card-body p-0">
                            <div id="lich_trinh_container">
                              <!-- Các ngày sẽ được tạo tự động -->
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" id="btnSubmitForm">Cập nhật</button>
                    </div>

                  </div>
                </div>
              </form>
            </div>

          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>
</div>

<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
</body>
</html>

<?php if (!isset($tour)) deleteSessionError(); ?>

<!-- ============================================================================
     JAVASCRIPT - ORGANIZED BY FUNCTIONALITY (EDIT MODE)
     ============================================================================ -->
<?php if (isset($tour)): ?>
<script>
  // ============================================================================
  // === 1. DATA INITIALIZATION ===
  // ============================================================================
  
  // Server data
  const diaDiemData = <?php echo json_encode($diaDiemTour); ?>;
  const serverLichTrinhData = <?php echo !empty($lichTrinhList) ? json_encode($lichTrinhList) : '[]'; ?>;
  const tourDiaDiemData = <?php echo !empty($tourDiaDiem) ? json_encode($tourDiaDiem) : '[]'; ?>;
  
  // Client state management
  let diaDiemList = <?php echo json_encode($initialDiaDiem); ?>;
  let lichTrinhNgayList = [];

  // ============================================================================
  // === 2. DOM READY - INITIAL SETUP ===
  // ============================================================================
  
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize dia diem form from existing data
    if (diaDiemList.length > 0) {
      diaDiemList.forEach((item, index) => {
        renderDiaDiem(item, index);
      });
    } else {
      diaDiemList.push({});
      renderDiaDiem({}, 0);
    }

    // Initialize lich trinh from database
    const inputSoNgay = document.getElementById('thoi_luong_mac_dinh');
    const soNgayDuLich = parseInt(inputSoNgay.value) || 0;
    
    // Load existing lich trinh from server
    loadLichTrinhFromServer();
    
    // If no schedule data, generate from duration
    if (lichTrinhNgayList.length === 0 && soNgayDuLich > 0) {
      generateLichTrinhFromSoNgay(soNgayDuLich);
    } else {
      renderAllLichTrinh();
    }

    // Event listener for duration change
    inputSoNgay.addEventListener('input', function() {
      const soNgay = parseInt(this.value) || 0;
      if (soNgay > 0 && soNgay <= 30) {
        generateLichTrinhFromSoNgay(soNgay);
      } else if (soNgay > 30) {
        alert('Số ngày du lịch không được vượt quá 30 ngày!');
        this.value = 30;
        generateLichTrinhFromSoNgay(30);
      } else {
        lichTrinhNgayList = [];
        renderAllLichTrinh();
      }
    });
  });

  // ============================================================================
  // === 3. DATA LOADING FROM SERVER ===
  // ============================================================================
  
  function loadLichTrinhFromServer() {
    if (!serverLichTrinhData || serverLichTrinhData.length === 0) {
      return;
    }

    // Create mapping: dia_diem_tour_id (DB) -> index in diaDiemList
    const diaDiemTourIdToIndex = {};
    tourDiaDiemData.forEach((ddt, idx) => {
      diaDiemTourIdToIndex[ddt.dia_diem_tour_id] = idx;
    });

    // Group schedule by day
    const groupedByNgay = {};
    serverLichTrinhData.forEach(lt => {
      const ngayThu = lt.ngay_thu;
      if (!groupedByNgay[ngayThu]) {
        const diaDiemIndex = diaDiemTourIdToIndex[lt.dia_diem_tour_id] ?? '';
        
        groupedByNgay[ngayThu] = {
          ngay_thu: ngayThu,
          dia_diem_tour_id: diaDiemIndex,
          lich_trinh: []
        };
      }
      groupedByNgay[ngayThu].lich_trinh.push({
        gio_bat_dau: lt.gio_bat_dau || '',
        gio_ket_thuc: lt.gio_ket_thuc || '',
        noi_dung: lt.noi_dung || ''
      });
    });

    // Convert to array and sort by day
    lichTrinhNgayList = Object.values(groupedByNgay).sort((a, b) => a.ngay_thu - b.ngay_thu);
  }

  // ============================================================================
  // === 4. EVENT HANDLERS - DIA DIEM ===
  // ============================================================================
  
  document.getElementById('btn-add-dia-diem').addEventListener('click', function() {
    diaDiemList.push({});
    const newIndex = diaDiemList.length - 1;
    renderDiaDiem({}, newIndex);
  });

  document.addEventListener('change', function(e) {
    if (e.target.classList.contains('dia-diem-select')) {
      renderAllLichTrinh();
    }
  });

  // ============================================================================
  // === 5. EVENT HANDLERS - LICH TRINH ===
  // ============================================================================
  
  document.addEventListener('change', function(e) {
    if (e.target.classList.contains('gio-bat-dau') || e.target.classList.contains('gio-ket-thuc')) {
      const ngayIdx = e.target.dataset.ngay;
      const ltIdx = e.target.dataset.lt;
      
      const gioBatDauEl = document.querySelector(`input[name="ngay[${ngayIdx}][lich_trinh][${ltIdx}][gio_bat_dau]"]`);
      const gioKetThucEl = document.querySelector(`input[name="ngay[${ngayIdx}][lich_trinh][${ltIdx}][gio_ket_thuc]"]`);
      
      if (gioBatDauEl && gioKetThucEl) {
        const gioBatDau = gioBatDauEl.value;
        const gioKetThuc = gioKetThucEl.value;
        
        const errorKetThucEl = document.querySelector(`.error-gio-ket-thuc-${ngayIdx}-${ltIdx}`);
        
        if (errorKetThucEl) {
          errorKetThucEl.style.display = 'none';
          gioKetThucEl.classList.remove('is-invalid');
        }
        
        if (gioBatDau && gioKetThuc && gioKetThuc <= gioBatDau) {
          if (errorKetThucEl) {
            errorKetThucEl.textContent = 'Giờ kết thúc phải sau giờ bắt đầu';
            errorKetThucEl.style.display = 'block';
            gioKetThucEl.classList.add('is-invalid');
          }
        }
      }
    }
  });

  // ============================================================================
  // === 6. RENDERING FUNCTIONS - DIA DIEM ===
  // ============================================================================
  
  function renderDiaDiem(data, index) {
    const container = document.getElementById('dia_diem_container');
    const diaDiemItem = document.createElement('div');
    diaDiemItem.className = 'card mb-3 border';
    diaDiemItem.id = 'dia_diem_item_' + index;

    diaDiemItem.innerHTML = `
    <div class="card-header bg-light">
      <h5>Địa Điểm Thứ ${index + 1}</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Chọn Địa Điểm</label>
            <select name="dia_diem_id[]" class="form-control dia-diem-select" data-index="${index}">
              <option value="">-- Chọn Địa Điểm --</option>
              ${diaDiemData.map(dd => `
                <option value="${dd.dia_diem_id}" ${data.dia_diem_id == dd.dia_diem_id ? 'selected' : ''}>
                  ${dd.ten}
                </option>
              `).join('')}
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Thứ Tự</label>
            <input type="number" name="thu_tu[]" class="form-control" min="1" value="${data.thu_tu || index + 1}" readonly>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Ghi Chú</label>
            <textarea name="ghi_chu[]" class="form-control" placeholder="Nhập ghi chú (nếu có)">${data.ghi_chu || ''}</textarea>
          </div>
        </div>
      </div>

      <div id="dia_diem_info_${index}" class="mt-3" style="display: none; background-color: #e8f4f8; border-left: 4px solid #0c5460; padding: 15px; border-radius: 4px;">
        <div class="row">
          <div class="col-md-6">
            <h5 id="dia_diem_name_${index}" style="color: #0c5460; font-weight: 600; margin-bottom: 10px;"></h5>
            <p id="dia_diem_mo_ta_${index}" style="color: #495057; margin-bottom: 10px; line-height: 1.5;"></p>
          </div>
          <div class="col-md-6">
            <small id="dia_diem_quoc_gia_${index}" style="color: #0c5460; line-height: 1.8;"></small>
          </div>
        </div>
      </div>

      <div class="form-group mt-3">
        <button type="button" class="btn btn-danger btn-sm" onclick="removeDiaDiem(${index})">
          <i class="fas fa-trash"></i> Xóa
        </button>
      </div>
    </div>
  `;

    container.appendChild(diaDiemItem);

    const selectElement = diaDiemItem.querySelector('.dia-diem-select');
    selectElement.addEventListener('change', function() {
      const selectedDiaDiemId = this.value;
      const selectedDiaDiem = diaDiemData.find(dd => dd.dia_diem_id == selectedDiaDiemId);

      if (selectedDiaDiem) {
        document.getElementById(`dia_diem_name_${index}`).textContent = '📍 ' + selectedDiaDiem.ten;
        document.getElementById(`dia_diem_mo_ta_${index}`).textContent = selectedDiaDiem.mo_ta;
        document.getElementById(`dia_diem_quoc_gia_${index}`).innerHTML = `
          <strong style="color: #0c5460;">🌍 Quốc gia:</strong> ${selectedDiaDiem.ten_quoc_gia}<br><br>
          <strong style="color: #0c5460;">📝 Mô tả:</strong> ${selectedDiaDiem.mo_ta_quoc_gia}
        `;
        document.getElementById(`dia_diem_info_${index}`).style.display = 'block';
        diaDiemList[index].dia_diem_id = selectedDiaDiemId;
      } else {
        document.getElementById(`dia_diem_info_${index}`).style.display = 'none';
        diaDiemList[index].dia_diem_id = null;
      }
    });

    if (data.dia_diem_id) {
      selectElement.dispatchEvent(new Event('change'));
    }
  }

  function removeDiaDiem(index) {
    diaDiemList.splice(index, 1);
    const container = document.getElementById('dia_diem_container');
    container.innerHTML = '';
    diaDiemList.forEach((item, idx) => {
      renderDiaDiem(item, idx);
    });
  }

  // ============================================================================
  // === 7. RENDERING FUNCTIONS - LICH TRINH ===
  // ============================================================================
  
  function generateLichTrinhFromSoNgay(soNgayDuLich) {
    if (soNgayDuLich < 1) {
      lichTrinhNgayList = [];
      renderAllLichTrinh();
      return;
    }

    if (lichTrinhNgayList.length !== soNgayDuLich) {
      const oldData = [...lichTrinhNgayList];
      lichTrinhNgayList = [];
      
      for (let i = 1; i <= soNgayDuLich; i++) {
        const existingDay = oldData.find(d => d.ngay_thu === i);
        if (existingDay) {
          lichTrinhNgayList.push(existingDay);
        } else {
          lichTrinhNgayList.push({
            ngay_thu: i,
            dia_diem_tour_id: '',
            lich_trinh: [
              { gio_bat_dau: '', gio_ket_thuc: '', noi_dung: '' }
            ]
          });
        }
      }
      
      renderAllLichTrinh();
    }
  }

  function renderAllLichTrinh() {
    const container = document.getElementById('lich_trinh_container');
    if (!container) return;
    
    container.innerHTML = '';

    const inputSoNgay = document.getElementById('thoi_luong_mac_dinh');
    const soNgayDuLich = inputSoNgay ? parseInt(inputSoNgay.value) || 0 : 0;
    
    if (lichTrinhNgayList.length === 0) {
      const alertDiv = document.createElement('div');
      alertDiv.className = 'alert alert-warning';
      alertDiv.innerHTML = `
        <i class="fas fa-exclamation-triangle"></i> 
        <strong>Chưa có lịch trình!</strong><br>
        ${soNgayDuLich > 0 
          ? `Đang tải lịch trình cho <strong>${soNgayDuLich} ngày</strong>...`
          : 'Vui lòng nhập <strong>"Số Ngày Du Lịch"</strong> ở "Thông Tin Danh Mục Tour" để tự động tạo lịch trình.'
        }
      `;
      container.appendChild(alertDiv);
      return;
    }

    const infoDiv = document.createElement('div');
    infoDiv.className = 'alert alert-success mb-3';
    infoDiv.innerHTML = `
      <i class="fas fa-check-circle"></i> 
      <strong>Tour ${lichTrinhNgayList.length} ngày</strong> - Vui lòng nhập thông tin lịch trình cho từng ngày
    `;
    container.appendChild(infoDiv);

    lichTrinhNgayList.forEach((ngay, ngayIndex) => {
      renderNgayCard(ngay, ngayIndex, container);
    });
  }

  function renderNgayCard(ngay, ngayIndex, container) {
    const ngayCard = document.createElement('div');
    ngayCard.className = 'card mb-4 border-primary shadow';
    ngayCard.id = `ngay_card_${ngayIndex}`;

    const selectedDiaDiem = diaDiemList.filter(dd => dd.dia_diem_id);
    let diaDiemOptions = '<option value="">-- Chọn Địa Điểm --</option>';
    selectedDiaDiem.forEach((ddItem, idx) => {
      const dd = diaDiemData.find(d => d.dia_diem_id == ddItem.dia_diem_id);
      if (dd) {
        const isSelected = ngay.dia_diem_tour_id == idx ? 'selected' : '';
        diaDiemOptions += `<option value="${idx}" ${isSelected}>${dd.ten} (Thứ tự: ${idx + 1})</option>`;
      }
    });

    let lichTrinhHTML = '';
    ngay.lich_trinh.forEach((lt, ltIndex) => {
      lichTrinhHTML += renderLichTrinhItem(ngay, ngayIndex, lt, ltIndex);
    });

    ngayCard.innerHTML = `
      <div class="card-header bg-gradient-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-calendar-day"></i> NGÀY ${ngay.ngay_thu}
            <small class="ml-2" style="font-size: 0.85rem; opacity: 0.9;">(${ngay.lich_trinh.length} hoạt động)</small>
          </h5>
        </div>
      </div>
      <div class="card-body bg-light">
        <input type="hidden" name="ngay[${ngayIndex}][ngay_thu]" value="${ngay.ngay_thu}">
        
        <div class="form-group">
          <label class="font-weight-bold">
            <i class="fas fa-map-marker-alt text-danger"></i> Địa Điểm Cho Ngày ${ngay.ngay_thu} <span class="text-danger">*</span>
          </label>
          <select name="ngay[${ngayIndex}][dia_diem_tour_id]" class="form-control dia-diem-ngay" data-ngay="${ngayIndex}" required>
            ${diaDiemOptions}
          </select>
          <small class="text-muted">Chọn địa điểm chính cho ngày này (từ "Chọn Địa Điểm Tour")</small>
        </div>

        <hr>
        <h6 class="text-info mb-3"><i class="fas fa-list"></i> Các Hoạt Động Trong Ngày</h6>
        
        <div id="lich_trinh_ngay_${ngayIndex}">
          ${lichTrinhHTML}
        </div>

        <div class="text-center mt-3">
          <button type="button" class="btn btn-sm btn-info" onclick="addLichTrinhItem(${ngayIndex})">
            <i class="fas fa-plus-circle"></i> Thêm Hoạt Động
          </button>
        </div>
      </div>
    `;

    container.appendChild(ngayCard);
  }

  function renderLichTrinhItem(ngay, ngayIndex, lt, ltIndex) {
    return `
      <div class="card mb-2 border-info" id="lt_${ngayIndex}_${ltIndex}">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center py-2">
          <small><i class="fas fa-clock"></i> Lịch Trình #${ltIndex + 1}</small>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeLichTrinhItem(${ngayIndex}, ${ltIndex})" title="Xóa lịch trình này">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label class="mb-1"><i class="fas fa-clock text-success"></i> Giờ Bắt Đầu <span class="text-danger">*</span></label>
                <input type="time" name="ngay[${ngayIndex}][lich_trinh][${ltIndex}][gio_bat_dau]" 
                  class="form-control form-control-sm gio-bat-dau" 
                  data-ngay="${ngayIndex}" 
                  data-lt="${ltIndex}"
                  value="${lt.gio_bat_dau}" required>
                <small class="text-danger error-gio-bat-dau-${ngayIndex}-${ltIndex}" style="display: none;"></small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label class="mb-1"><i class="fas fa-clock text-warning"></i> Giờ Kết Thúc <span class="text-danger">*</span></label>
                <input type="time" name="ngay[${ngayIndex}][lich_trinh][${ltIdx}][gio_ket_thuc]" 
                  class="form-control form-control-sm gio-ket-thuc" 
                  data-ngay="${ngayIndex}" 
                  data-lt="${ltIndex}"
                  value="${lt.gio_ket_thuc}" required>
                <small class="text-danger error-gio-ket-thuc-${ngayIndex}-${ltIndex}" style="display: none;"></small>
              </div>
            </div>
          </div>
          <div class="form-group mb-0">
            <label class="mb-1"><i class="fas fa-align-left text-info"></i> Nội Dung Hoạt Động <span class="text-danger">*</span></label>
            <textarea name="ngay[${ngayIndex}][lich_trinh][${ltIndex}][noi_dung]" 
              class="form-control form-control-sm noi-dung-lt" 
              rows="2" 
              data-ngay="${ngayIndex}" 
              data-lt="${ltIndex}"
              placeholder="VD: Tham quan bảo tàng, ăn trưa tại nhà hàng... (tối thiểu 10 ký tự)" 
              required>${lt.noi_dung}</textarea>
            <small class="text-danger error-noi-dung-${ngayIndex}-${ltIndex}" style="display: none;"></small>
          </div>
        </div>
      </div>
    `;
  }

  function addLichTrinhItem(ngayIndex) {
    lichTrinhNgayList[ngayIndex].lich_trinh.push({
      gio_bat_dau: '',
      gio_ket_thuc: '',
      noi_dung: ''
    });
    renderAllLichTrinh();
  }

  function removeLichTrinhItem(ngayIndex, ltIndex) {
    if (lichTrinhNgayList[ngayIndex].lich_trinh.length === 1) {
      alert('Mỗi ngày phải có ít nhất 1 hoạt động!');
      return;
    }
    lichTrinhNgayList[ngayIndex].lich_trinh.splice(ltIndex, 1);
    renderAllLichTrinh();
  }

  // ============================================================================
  // === 8. FORM VALIDATION ===
  // ============================================================================
  
  function validateLichTrinhForm() {
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('[id^="error-badge-"]').forEach(el => el.style.display = 'none');
    
    let hasError = false;
    let firstErrorTab = null;
    
    const inputTen = document.querySelector('input[name="ten"]');
    const selectDanhMuc = document.querySelector('select[name="danh_muc_id"]');
    const inputGia = document.querySelector('input[name="gia_co_ban"]');
    const inputSoNgay = document.getElementById('thoi_luong_mac_dinh');
    
    if (inputTen && !inputTen.value.trim()) {
      inputTen.classList.add('is-invalid');
      hasError = true;
      firstErrorTab = 'tab-tour';
    }
    if (selectDanhMuc && !selectDanhMuc.value) {
      selectDanhMuc.classList.add('is-invalid');
      hasError = true;
      if (!firstErrorTab) firstErrorTab = 'tab-tour';
    }
    if (inputGia && !inputGia.value) {
      inputGia.classList.add('is-invalid');
      hasError = true;
      if (!firstErrorTab) firstErrorTab = 'tab-tour';
    }
    if (inputSoNgay && !inputSoNgay.value) {
      inputSoNgay.classList.add('is-invalid');
      hasError = true;
      if (!firstErrorTab) firstErrorTab = 'tab-tour';
    }
    
    if (hasError && firstErrorTab === 'tab-tour') {
      document.getElementById('error-badge-tab1').style.display = 'inline-block';
    }
    
    const diaDiemSelects = document.querySelectorAll('.dia-diem-select');
    let hasSelectedDiaDiem = false;
    diaDiemSelects.forEach(select => {
      if (select.value) hasSelectedDiaDiem = true;
    });
    
    if (!hasSelectedDiaDiem) {
      document.getElementById('error-badge-tab2').style.display = 'inline-block';
      hasError = true;
      if (!firstErrorTab) firstErrorTab = 'tab-customer';
    }
    
    if (lichTrinhNgayList.length === 0) {
      document.getElementById('error-badge-tab3').style.display = 'inline-block';
      hasError = true;
      if (!firstErrorTab) firstErrorTab = 'tab-lich-trinh';
    }
    
    if (hasError && firstErrorTab) {
      if (firstErrorTab === 'tab-tour') {
        document.getElementById('tab-link-tour').click();
      } else if (firstErrorTab === 'tab-customer') {
        document.getElementById('tab-link-customer').click();
      } else if (firstErrorTab === 'tab-lich-trinh') {
        document.getElementById('tab-link-lich-trinh').click();
      }
      
      setTimeout(() => {
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
          firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }, 300);
      
      return false;
    }
    
    return true;
  }

  // ============================================================================
  // === 9. FORM SUBMISSION ===
  // ============================================================================
  
  const formElement = document.getElementById('formEditTour');
  const btnSubmit = document.getElementById('btnSubmitForm');
  
  if (btnSubmit && formElement) {
    btnSubmit.addEventListener('click', function(e) {
      e.preventDefault();
      
      if (!validateLichTrinhForm()) {
        return;
      }
      
      formElement.submit();
    });
  }
</script>
<?php endif; ?>
