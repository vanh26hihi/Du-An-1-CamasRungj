<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<?php
// Lấy lỗi và dữ liệu cũ từ session
$error = $_SESSION['error'] ?? [];
$old   = $_SESSION['old']   ?? [];

// Xóa sau khi lấy, tránh lỗi hiển thị lại
unset($_SESSION['error'], $_SESSION['old'], $_SESSION['flash']);
?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tourSelect = document.getElementById("tour_id");
    const lichSelect = document.getElementById("lich_id");
    const tourInfoBox = document.getElementById("tourInfo");
    const ten_tour = document.getElementById("ten_tour");
    const mo_ta = document.getElementById("mo_ta");
    const gia_co_ban = document.getElementById("gia_co_ban");
    const chinh_sach = document.getElementById("chinh_sach");
    const diem_khoi_hanh = document.getElementById("diem_khoi_hanh");
    const oldData = <?= json_encode($old) ?>;
    const listLichAll = <?= json_encode($listLichAll ?? []) ?>;
    const listTours = <?= json_encode($listTours ?? []) ?>;

    // Hàm restore thông tin tour
    function restoreTourInfo() {
      if (oldData.lich_id) {
        lichSelect.value = oldData.lich_id;
        const option = lichSelect.options[lichSelect.selectedIndex] || {};
        ten_tour.value = option.getAttribute("data-ten-tour") || "";
        mo_ta.value = option.getAttribute("data-mo-ta") || "";
        gia_co_ban.value = option.getAttribute("data-gia-co-ban") || "";
        chinh_sach.value = option.getAttribute("data-chinh-sach") || "";
        diem_khoi_hanh.value = option.getAttribute("data-diem-khoi-hanh") || "";
        tourInfoBox.style.display = "block";
      }
    }

    // tour info change event
    if (lichSelect) {
      lichSelect.addEventListener("change", function() {
        const option = lichSelect.options[lichSelect.selectedIndex] || {};
        ten_tour.value = option.getAttribute("data-ten-tour") || "";
        mo_ta.value = option.getAttribute("data-mo-ta") || "";
        gia_co_ban.value = option.getAttribute("data-gia-co-ban") || "";
        chinh_sach.value = option.getAttribute("data-chinh-sach") || "";
        diem_khoi_hanh.value = option.getAttribute("data-diem-khoi-hanh") || "";
        tourInfoBox.style.display = "block";
      });
    }

    // elements for customers (table version without add/remove buttons)
    const soNguoiInput = document.getElementById("so_nguoi");
    const container = document.querySelector('#tableDsKhach tbody');
    const serverErrors = <?= json_encode($error ?? []) ?>;

    function buildRow(i, khachOld) {
      const errName = serverErrors[`ds_khach_${i}_ho_ten`] ?? "";
      const errGender = serverErrors[`ds_khach_${i}_gioi_tinh`] ?? "";
      const errPhone = serverErrors[`ds_khach_${i}_so_dien_thoai`] ?? "";
      const errEmail = serverErrors[`ds_khach_${i}_email`] ?? "";
      const errCCCD = serverErrors[`ds_khach_${i}_cccd`] ?? "";
      const errBirthday = serverErrors[`ds_khach_${i}_ngay_sinh`] ?? "";
      const errNote = serverErrors[`ds_khach_${i}_ghi_chu`] ?? "";
      const oldHoTen = khachOld.ho_ten ?? "";
      const oldGioiTinh = khachOld.gioi_tinh ?? "";
      const oldSoDienThoai = khachOld.so_dien_thoai ?? "";
      const oldEmail = khachOld.email ?? "";
      const oldCCCD = khachOld.cccd ?? "";
      const oldNgaySinh = khachOld.ngay_sinh ?? "";
      const oldGhiChu = khachOld.ghi_chu ?? "";
      return `<tr data-index="${i}">
        <td class="align-middle">${i + 1}</td>
        <td><input type="text" name="ds_khach[${i}][ho_ten]" class="form-control form-control-sm" value="${oldHoTen}">${errName ? `<small class='text-danger'>${errName}</small>` : ''}</td>
        <td><select name="ds_khach[${i}][gioi_tinh]" class="form-control form-control-sm"><option value="" ${!oldGioiTinh ? 'selected' : ''}>--</option><option value="Nam" ${oldGioiTinh === 'Nam' ? 'selected' : ''}>Nam</option><option value="Nữ" ${oldGioiTinh === 'Nữ' ? 'selected' : ''}>Nữ</option></select>${errGender ? `<small class='text-danger'>${errGender}</small>` : ''}</td>
        <td><input type="text" name="ds_khach[${i}][so_dien_thoai]" class="form-control form-control-sm" value="${oldSoDienThoai}">${errPhone ? `<small class='text-danger'>${errPhone}</small>` : ''}</td>
        <td><input type="text" name="ds_khach[${i}][email]" class="form-control form-control-sm" value="${oldEmail}">${errEmail ? `<small class='text-danger'>${errEmail}</small>` : ''}</td>
        <td><input type="text" name="ds_khach[${i}][cccd]" class="form-control form-control-sm" value="${oldCCCD}">${errCCCD ? `<small class='text-danger'>${errCCCD}</small>` : ''}</td>
        <td><input type="date" name="ds_khach[${i}][ngay_sinh]" class="form-control form-control-sm" value="${oldNgaySinh}">${errBirthday ? `<small class='text-danger'>${errBirthday}</small>` : ''}</td>
        <td><input type="text" name="ds_khach[${i}][ghi_chu]" class="form-control form-control-sm" value="${oldGhiChu}">${errNote ? `<small class='text-danger'>${errNote}</small>` : ''}</td>
      </tr>`;
    }

    function generateCustomers(count) {
      count = parseInt(count) || 1;
      const dsKhachOld = oldData.ds_khach ?? [];
      container.innerHTML = '';
      for (let i = 0; i < count; i++) {
        const khachOld = dsKhachOld[i] ?? {};
        container.insertAdjacentHTML('beforeend', buildRow(i, khachOld));
      }
    }

    // khi thay đổi số lượng
    if (soNguoiInput) {
      soNguoiInput.addEventListener("input", function() {
        // Không ép mặc định rỗng thành 1 ở đây nếu bạn muốn khác,
        // nhưng theo yêu cầu bạn đã set value=1 nên mặc định là 1.
        const val = parseInt(this.value) || 1;
        generateCustomers(val);
      });
    }

    // Khi trang load: tạo danh sách theo value hiện tại (nếu container rỗng thì tạo)
    // Điều này đảm bảo khi tải lại trang bạn sẽ thấy 1 form (value=1)
    (function initOnLoad() {
      // Restore tour info nếu có dữ liệu cũ
      if (oldData.tour_id) {
        tourSelect.value = oldData.tour_id;
        rebuildLichOptionsByTour(oldData.tour_id);
        if (oldData.lich_id) {
          lichSelect.value = oldData.lich_id;
          const option = lichSelect.options[lichSelect.selectedIndex] || {};
          ten_tour.value = option.getAttribute("data-ten-tour") || "";
          mo_ta.value = option.getAttribute("data-mo-ta") || "";
          gia_co_ban.value = option.getAttribute("data-gia-co-ban") || "";
          chinh_sach.value = option.getAttribute("data-chinh-sach") || "";
          diem_khoi_hanh.value = option.getAttribute("data-diem-khoi-hanh") || "";
          tourInfoBox.style.display = "block";
        }
      }

      const val = soNguoiInput ? (parseInt(soNguoiInput.value) || 1) : 1;
      generateCustomers(val);
    })();

    // Khi user chuyển sang tab "Danh Sách Khách Hàng" (Bootstrap)
    // Tab link id trong code của bạn là: custom-tabs-one-list-tab
    const tabLink = document.getElementById("custom-tabs-one-list-tab");

    function onShowListTab() {
      // đảm bảo danh sách có mặt (nếu rỗng thì tạo)
      const val = soNguoiInput ? (parseInt(soNguoiInput.value) || 1) : 1;
      generateCustomers(val);
    }

    if (tabLink) {
      // Try addEventListener for Bootstrap custom event
      tabLink.addEventListener("shown.bs.tab", onShowListTab);

      // jQuery fallback (nhiều project AdminLTE dùng jQuery)
      if (typeof $ !== "undefined" && $.fn && $.fn.tab) {
        // remove duplicate handlers then attach
        $(tabLink).off("shown.bs.tab.custom").on("shown.bs.tab.custom", onShowListTab);
      }
    }

    function tinhTongTien() {
      const gia = parseFloat(gia_co_ban.value) || 0;
      const soNguoi = parseInt(so_nguoi.value) || 1;
      const tong = gia * soNguoi;
      document.getElementById("tong_tien").value = tong;
    }

    // Khi chọn tour → cập nhật thông tin + tính tổng
    lichSelect.addEventListener("change", function() {
      tinhTongTien();
    });

    function rebuildLichOptionsByTour(tourId) {
      // clear
      lichSelect.innerHTML = '<option value="" disabled selected>--Chọn Lịch Khởi Hành--</option>';
      const lichForTour = listLichAll.filter(l => String(l.tour_id) === String(tourId));
      // find tour info
      const tour = listTours.find(t => String(t.tour_id) === String(tourId));
      lichForTour.forEach(l => {
        const opt = document.createElement('option');
        opt.value = l.lich_id;
        opt.textContent = `${tour?.ten_tour || ''} | ${formatDateJS(l.ngay_bat_dau)}`;
        opt.setAttribute('data-ten-tour', tour?.ten_tour || '');
        opt.setAttribute('data-mo-ta', tour?.mo_ta || '');
        opt.setAttribute('data-gia-co-ban', tour?.gia_co_ban || '');
        opt.setAttribute('data-chinh-sach', tour?.chinh_sach || '');
        opt.setAttribute('data-diem-khoi-hanh', tour?.diem_khoi_hanh || '');
        lichSelect.appendChild(opt);
      });
    }

    function formatDateJS(dateStr) {
      const d = new Date(dateStr);
      const dd = String(d.getDate()).padStart(2, '0');
      const mm = String(d.getMonth() + 1).padStart(2, '0');
      const yyyy = d.getFullYear();
      return `${dd}-${mm}-${yyyy}`;
    }

    if (tourSelect) {
      tourSelect.addEventListener('change', function() {
        const tourId = this.value;
        tourInfoBox.style.display = 'none';
        ten_tour.value = '';
        mo_ta.value = '';
        gia_co_ban.value = '';
        chinh_sach.value = '';
        diem_khoi_hanh.value = '';
        rebuildLichOptionsByTour(tourId);
      });
    }

    // Khi thay đổi số người → tạo danh sách khách + tính tổng
    soNguoiInput.addEventListener("input", function() {
      const val = parseInt(this.value) || 1;
      generateCustomers(val);
      tinhTongTien();
    });

    // Add row button
    const btnAddRow = document.getElementById('btnAddKhach');
    if (btnAddRow) {
      btnAddRow.addEventListener('click', function() {
        addRow();
        tinhTongTien();
      });
    }

    // Tính tổng ngay lúc load trang
    tinhTongTien();

  });
</script>



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
          <h1> Tạo Booking</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <!-- Updated form with standardized validation blocks -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <form action="<?= BASE_URL_ADMIN . '?act=them-booking' ?>" method="POST">

              <div class="col-12 col-sm-12">
                <div class="card card-primary card-tabs">

                  <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#tab-tour" role="tab">Thông Tin Tour</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#tab-customer" role="tab">Thông Tin Người Đặt</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#tab-list" role="tab">Danh Sách Khách Hàng</a>
                      </li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <div class="tab-content">

                      <!-- TAB 1: THÔNG TIN TOUR -->
                      <div class="tab-pane fade show active" id="tab-tour" role="tabpanel">
                        <h4>Chọn Tour Du Lịch</h4>

                        <div class="form-group">
                          <label>Tour</label>
                          <select id="tour_id" name="tour_id" class="form-control select2">
                            <option value="" <?= empty($old['tour_id']) ? 'selected' : '' ?> disabled>--Chọn Tour--</option>
                            <?php foreach ($listTours as $tour): ?>
                              <option value="<?= $tour['tour_id'] ?>" <?= ($old['tour_id'] ?? '') == $tour['tour_id'] ? 'selected' : '' ?>>
                                <?= $tour['ten_tour'] ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <?php if (isset($error['tour_id'])): ?>
                            <div class="invalid-feedback d-block"> <?= $error['tour_id'] ?> </div>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>Lịch Khởi Hành</label>
                          <select id="lich_id" name="lich_id" class="form-control select2">
                            <option value="" <?= empty($old['lich_id']) ? 'selected' : '' ?> disabled>--Chọn Lịch Khởi Hành--</option>
                          </select>
                          <?php if (isset($error['lich_id'])): ?>
                            <div class="invalid-feedback d-block"> <?= $error['lich_id'] ?> </div>
                          <?php endif; ?>
                        </div>

                        <div id="tourInfo" class="p-3 bg-light border rounded mt-3" style="<?= isset($old['lich_id']) ? '' : 'display:none;' ?>">
                          <h5>Thông tin Tour</h5>
                          <div class="row">

                            <!-- LEFT -->
                            <div class="col-md-6">

                              <div class="form-group">
                                <label>Tên Tour</label>
                                <input type="text" id="ten_tour" name="ten_tour" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Giá Cơ Bản</label>
                                <input type="number" id="gia_co_ban" name="gia_co_ban" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Chính Sách</label>
                                <input type="text" id="chinh_sach" name="chinh_sach" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Điểm Khởi Hành</label>
                                <input type="text" id="diem_khoi_hanh" name="diem_khoi_hanh" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Mô Tả</label>
                                <textarea id="mo_ta" name="mo_ta" class="form-control" readonly></textarea>
                              </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-6">

                              <div class="form-group">
                                <label>Loại Tour</label>
                                <select id="loai" name="loai" class="form-control select2">
                                  <option value="" disabled <?= empty($old['loai']) ? 'selected' : '' ?>>--Chọn Loại Tour--</option>
                                  <option value="group" <?= ($old['loai'] ?? '') === 'group' ? 'selected' : '' ?>>Theo Nhóm</option>
                                  <option value="individual" <?= ($old['loai'] ?? '') === 'individual' ? 'selected' : '' ?>>Cá Nhân</option>
                                </select>
                                <?php if (isset($error['loai'])): ?>
                                  <div class="invalid-feedback d-block"> <?= $error['loai'] ?> </div>
                                <?php endif; ?>
                              </div>

                              <div class="form-group">
                                <label>Số Lượng Người</label>
                                <input type="number" id="so_nguoi" name="so_nguoi" class="form-control" min="1" value="<?= $old['so_nguoi'] ?? '1' ?>">
                                <?php if (isset($error['so_nguoi'])): ?>
                                  <div class="invalid-feedback d-block"> <?= $error['so_nguoi'] ?> </div>
                                <?php endif; ?>
                              </div>

                              <input type="hidden" name="trang_thai_id" value="1">

                              <div class="form-group">
                                <label>Ghi Chú</label>
                                <textarea id="ghi_chu" name="ghi_chu" class="form-control"><?= $old['ghi_chu'] ?? '' ?></textarea>
                              </div>

                              <div class="form-group">
                                <label>Tổng Tiền</label>
                                <input type="number" id="tong_tien" name="tong_tien" class="form-control" readonly value="<?= $old['tong_tien'] ?? '' ?>">
                              </div>

                            </div>

                          </div>
                        </div>

                      </div>

                      <!-- TAB 2: THÔNG TIN NGƯỜI ĐẶT -->
                      <div class="tab-pane fade" id="tab-customer" role="tabpanel">
                        <h4>Thông Tin Người Đặt Tour</h4>

                        <div class="form-group">
                          <label>Tên Khách Hàng</label>
                          <input type="text" value="<?= $old['ho_ten'] ?? '' ?>" id="ho_ten" name="ho_ten" class="form-control" placeholder="Nhập tên khách hàng">
                          <?php if (isset($error['ho_ten'])): ?>
                            <div class="invalid-feedback d-block"> <?= $error['ho_ten'] ?> </div>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>Số Điện Thoại</label>
                          <input type="text" id="so_dien_thoai" name="so_dien_thoai" class="form-control" placeholder="Nhập số điện thoại" value="<?= $old['so_dien_thoai'] ?? '' ?>">
                          <?php if (isset($error['so_dien_thoai'])): ?>
                            <div class="invalid-feedback d-block"> <?= $error['so_dien_thoai'] ?> </div>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" id="email" name="email" class="form-control" placeholder="Nhập email" value="<?= $old['email'] ?? '' ?>">
                          <?php if (isset($error['email'])): ?>
                            <div class="invalid-feedback d-block"> <?= $error['email'] ?> </div>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>CCCD</label>
                          <input type="text" id="cccd" name="cccd" class="form-control" placeholder="Nhập CCCD" value="<?= $old['cccd'] ?? '' ?>">
                          <?php if (isset($error['cccd'])): ?>
                            <div class="invalid-feedback d-block"> <?= $error['cccd'] ?> </div>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>Địa Chỉ</label>
                          <input type="text" id="dia_chi" name="dia_chi" class="form-control" placeholder="Nhập địa chỉ" value="<?= $old['dia_chi'] ?? '' ?>">
                          <?php if (isset($error['dia_chi'])): ?>
                            <div class="invalid-feedback d-block"> <?= $error['dia_chi'] ?> </div>
                          <?php endif; ?>
                        </div>

                      </div>

                      <!-- TAB 3: DANH SÁCH KHÁCH HÀNG -->
                      <div class="tab-pane fade" id="tab-list" role="tabpanel">
                        <h4>Thông Tin Danh Sách Khách Hàng</h4>

                        <div class="table-responsive" style="max-height:400px; overflow:auto;">
                          <table class="table table-bordered table-sm" id="tableDsKhach">
                            <thead class="thead-light">
                              <tr>
                                <th style="width:40px">#</th>
                                <th>Họ Tên</th>
                                <th>Giới Tính</th>
                                <th>SĐT</th>
                                <th>Email</th>
                                <th>CCCD</th>
                                <th>Ngày Sinh</th>
                                <th>Ghi Chú</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>

                        <div id="warningSoNguoi" class="alert alert-danger" style="display:none;">
                          Vui lòng nhập số lượng người tham gia tour.
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>

                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Footer -->

<!-- End Footer  -->
</body>

<?php require_once './views/layout/footer.php'; ?>

</html>