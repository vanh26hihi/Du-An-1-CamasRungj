<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
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
          <h1> Quản lý Danh Mục Tour</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <?php if (!isset($tour)): ?>
            <!-- Fallback: chỉnh sửa record danh_muc cũ -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Sửa Danh Mục Tour</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="?act=post-sua-danh-muc" method="POST">
                <div class="card-body">

                  <!-- ID Ẩn -->
                  <input type="hidden" name="id" value="<?= $danhmuc['danh_muc_id'] ?>">

                  <!-- Tên danh mục -->
                  <div class="form-group">
                    <label>Tên danh mục</label>
                    <input type="text" class="form-control" name="ten" value="<?= $danhmuc['ten'] ?>" placeholder="Nhập tên danh mục" required>
                  </div>

                  <!-- Mô tả -->
                  <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="mo_ta" class="form-control" placeholder="Nhập mô tả"><?= $danhmuc['mo_ta'] ?></textarea>
                  </div>

                  <!-- Trạng thái -->
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
            <!-- /.card -->

          <?php else: ?>

            <!-- Nếu là tour: hiển thị form chỉnh sửa giống Add nhưng đổ dữ liệu sẵn -->
            <div>
              <form action="<?= BASE_URL_ADMIN . "?act=post-sua-danh-muc" ?>" method="POST">
                <input type="hidden" name="id" value="<?= $tour['tour_id'] ?>">
                <div class="col-12 col-sm-12">
                  <div class="card card-primary card-tabs">

                    <div class="card-header p-0 pt-1">
                      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="pill" href="#tab-tour" role="tab">Thông Tin Danh Mục Tour</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="pill" href="#tab-customer" role="tab">Chọn Địa Điểm Tour</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="pill" href="#tab-lich-trinh" role="tab"><i class="fas fa-route"></i> Lịch Trình</a>
                        </li>
                      </ul>
                    </div>

                    <div class="card-body">
                      <div class="tab-content">

                        <!-- TAB 1: THÔNG TIN TOUR -->
                        <div class="tab-pane fade show active" id="tab-tour" role="tabpanel">
                          <h4>Sửa Thông Tin Danh Mục Tour </h4>

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
                                  <input type="number" class="form-control" name="thoi_luong_mac_dinh" min="1" placeholder="Nhập Số Ngày Du Lịch" value="<?= htmlspecialchars($old['thoi_luong_mac_dinh'] ?? $tour['thoi_luong_mac_dinh']) ?>">
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
                          <!-- /.card-body -->

                        </div>

                        <!-- TAB 2: THÔNG TIN ĐỊA ĐIỂM -->
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

                        <!-- TAB 3: LỊCH TRÌNH -->
                        <div class="tab-pane fade" id="tab-lich-trinh" role="tabpanel">
                          <h4><i class="fas fa-route"></i> Lịch Trình Tour</h4>
                          <p class="text-info">Chỉnh sửa lịch trình theo địa điểm đã chọn.</p>

                          <div class="card-body">
                            <div id="lich_trinh_container">
                              <!-- Lịch trình sẽ được load từ database hoặc tạo tự động -->
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>

                  </div>
                </div>
              </form>
            </div>

          <?php endif; ?>

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
</body>

</html>

<?php if (isset($tour)): ?>
  <?php
  // Chuẩn bị dữ liệu dia_diem để JS sử dụng: ưu tiên dữ liệu cũ trong session nếu có
  $initialDiaDiem = [];
  if (!empty($old['dia_diem'])) {
    $initialDiaDiem = $old['dia_diem'];
  } else {
    // $tourDiaDiem được nạp bởi controller, map về format giống add
    $initialDiaDiem = [];
    if (!empty($tourDiaDiem)) {
      foreach ($tourDiaDiem as $ddt) {
        $initialDiaDiem[] = [
          'dia_diem_id' => $ddt['dia_diem_id'],
          'thu_tu' => $ddt['thu_tu'],
          'ghi_chu' => $ddt['ghi_chu'] ?? ''
        ];
      }
    }
  }
  ?>

  <script>
    // Dữ liệu địa điểm từ server
    const diaDiemData = <?php echo json_encode($diaDiemTour); ?>;

    // Lưu trữ dữ liệu địa điểm đã thêm (từ session old hoặc dữ liệu tour)
    let diaDiemList = <?php echo json_encode($initialDiaDiem); ?>;

    // Khởi tạo form địa điểm khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
      if (diaDiemList.length > 0) {
        diaDiemList.forEach((item, index) => {
          renderDiaDiem(item, index);
        });
      } else {
        // Ensure the data array reflects the single initial empty block
        diaDiemList.push({});
        renderDiaDiem({}, 0);
      }

      // Event listener cho nút thêm địa điểm
      document.getElementById('btn-add-dia-diem').addEventListener('click', function() {
        diaDiemList.push({});
        const newIndex = diaDiemList.length - 1;
        renderDiaDiem({}, newIndex);
      });
    });

    // Render form địa điểm
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
            ${data.error_dia_diem_id ? `<p class="text-danger">${data.error_dia_diem_id}</p>` : ''}
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

      // Event listener cho select địa điểm
      const selectElement = diaDiemItem.querySelector('.dia-diem-select');
      selectElement.addEventListener('change', function() {
        const selectedDiaDiemId = this.value;
        const selectedDiaDiem = diaDiemData.find(dd => dd.dia_diem_id == selectedDiaDiemId);

        if (selectedDiaDiem) {
          // Cập nhật thông tin hiển thị
          document.getElementById(`dia_diem_name_${index}`).textContent = '📍 ' + selectedDiaDiem.ten;
          document.getElementById(`dia_diem_mo_ta_${index}`).textContent = selectedDiaDiem.mo_ta;
          document.getElementById(`dia_diem_quoc_gia_${index}`).innerHTML = `
          <strong style="color: #0c5460;">🌍 Quốc gia:</strong> ${selectedDiaDiem.ten_quoc_gia}<br><br>
          <strong style="color: #0c5460;">📝 Mô tả:</strong> ${selectedDiaDiem.mo_ta_quoc_gia}
        `;
          document.getElementById(`dia_diem_info_${index}`).style.display = 'block';

          // Cập nhật dữ liệu
          diaDiemList[index].dia_diem_id = selectedDiaDiemId;
        } else {
          document.getElementById(`dia_diem_info_${index}`).style.display = 'none';
          diaDiemList[index].dia_diem_id = null;
        }
      });

      // Trigger change event nếu đã có giá trị
      if (data.dia_diem_id) {
        selectElement.dispatchEvent(new Event('change'));
      }
    }

    // Hàm xóa địa điểm — sau khi xóa sẽ re-render toàn bộ block từ diaDiemList
    function removeDiaDiem(index) {
      // Remove from data
      diaDiemList.splice(index, 1);

      // Re-render container to keep indexes and element IDs consistent
      const container = document.getElementById('dia_diem_container');
      container.innerHTML = '';
      diaDiemList.forEach((item, idx) => {
        renderDiaDiem(item, idx);
      });

      // Cập nhật lại lịch trình
      updateLichTrinh();
    }

    // Hàm tạo/cập nhật lịch trình
    function updateLichTrinh() {
      const lichTrinhContainer = document.getElementById('lich_trinh_container');

      // Lọc các địa điểm đã chọn
      const selectedDiaDiem = diaDiemList.filter(item => item.dia_diem_id);

      if (selectedDiaDiem.length === 0) {
        lichTrinhContainer.innerHTML = '<p class="text-muted"><i class="fas fa-info-circle"></i> Hãy chọn địa điểm ở Tab 2 để tạo lịch trình</p>';
        return;
      }

      let html = '';
      selectedDiaDiem.forEach((item, index) => {
        const diaDiem = diaDiemData.find(dd => dd.dia_diem_id == item.dia_diem_id);
        const ngayThu = index + 1;

        // Tìm lịch trình đã có (nếu edit)
        const existingLichTrinh = lichTrinhData.find(lt => lt.dia_diem_id == item.dia_diem_id && lt.ngay_thu == ngayThu);

        html += `
          <div class="card mb-3 border-primary">
            <div class="card-header bg-primary text-white">
              <h5><i class="fas fa-calendar-day"></i> Ngày ${ngayThu}: ${diaDiem ? diaDiem.ten : 'Chưa rõ'}</h5>
            </div>
            <div class="card-body">
              ${existingLichTrinh ? `<input type="hidden" name="lich_trinh[${index}][lich_trinh_id]" value="${existingLichTrinh.lich_trinh_id}">` : ''}
              <input type="hidden" name="lich_trinh[${index}][ngay_thu]" value="${ngayThu}">
              <input type="hidden" name="lich_trinh[${index}][dia_diem_id]" value="${item.dia_diem_id}">
              
              <div class="form-group">
                <label>Tên địa điểm cụ thể</label>
                <input type="text" class="form-control" name="lich_trinh[${index}][mo_ta]" 
                  value="${existingLichTrinh ? (existingLichTrinh.mo_ta || '') : ''}"
                  placeholder="Ví dụ: Vịnh Hạ Long, Bãi Cháy..." />
              </div>
              
              <div class="form-group">
                <label>Nội dung lịch trình <span class="text-danger">*</span></label>
                <textarea class="form-control" name="lich_trinh[${index}][noi_dung]" rows="4" 
                  placeholder="Mô tả hoạt động trong ngày ${ngayThu}..." required>${existingLichTrinh ? (existingLichTrinh.noi_dung || '') : ''}</textarea>
              </div>
            </div>
          </div>
        `;
      });

      lichTrinhContainer.innerHTML = html;
    }

    // Load lịch trình khi vào trang edit
    const lichTrinhData = <?php echo !empty($lichTrinhList) ? json_encode($lichTrinhList) : '[]'; ?>;

    // Cập nhật lịch trình khi load trang
    setTimeout(() => {
      updateLichTrinh();
    }, 500);

    // Cập nhật lịch trình khi thay đổi địa điểm
    document.addEventListener('change', function(e) {
      if (e.target.classList.contains('dia-diem-select')) {
        updateLichTrinh();
      }
    });
  </script>
<?php endif; ?>

<?php if (!isset($tour)) deleteSessionError(); ?>