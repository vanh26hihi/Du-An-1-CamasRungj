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
    const select = document.getElementById("lich_id");
    const tourInfoBox = document.getElementById("tourInfo");
    const ten_tour = document.getElementById("ten_tour");
    const mo_ta = document.getElementById("mo_ta");
    const gia_co_ban = document.getElementById("gia_co_ban");
    const chinh_sach = document.getElementById("chinh_sach");
    const diem_khoi_hanh = document.getElementById("diem_khoi_hanh");
    const soNguoiInput = document.getElementById("so_nguoi");
    const container = document.getElementById("customerList");

    // lỗi từ PHP
    const serverErrors = <?= json_encode($error ?? []) ?>;

    // dữ liệu cũ từ session khi submit bị lỗi
    const oldData = <?= json_encode($old) ?>;

    // dữ liệu khách đã có từ DB khi EDIT (nếu không có lỗi)
    const oldCustomers = <?= json_encode($listHanhKhach ?? []) ?>;

    // Hàm restore thông tin tour từ session hoặc DB
    function restoreTourInfo() {
      if (oldData.lich_id) {
        select.value = oldData.lich_id;
        const option = select.options[select.selectedIndex] || {};
        ten_tour.value = option.getAttribute("data-ten-tour") || "";
        mo_ta.value = option.getAttribute("data-mo-ta") || "";
        gia_co_ban.value = option.getAttribute("data-gia-co-ban") || "";
        chinh_sach.value = option.getAttribute("data-chinh-sach") || "";
        diem_khoi_hanh.value = option.getAttribute("data-diem-khoi-hanh") || "";
        tourInfoBox.style.display = "block";
      }
    }

    // tour info change event
    if (select) {
      select.addEventListener("change", function() {
        const option = select.options[select.selectedIndex] || {};
        ten_tour.value = option.getAttribute("data-ten-tour") || "";
        mo_ta.value = option.getAttribute("data-mo-ta") || "";
        gia_co_ban.value = option.getAttribute("data-gia-co-ban") || "";
        chinh_sach.value = option.getAttribute("data-chinh-sach") || "";
        diem_khoi_hanh.value = option.getAttribute("data-diem-khoi-hanh") || "";
        tourInfoBox.style.display = "block";
      });
    }

    function createCustomer(index, data = {}, showError = true) {
      const errName = serverErrors[`ds_khach_${index}_ho_ten`] ?? "";
      const errGender = serverErrors[`ds_khach_${index}_gioi_tinh`] ?? "";
      const errPhone = serverErrors[`ds_khach_${index}_so_dien_thoai`] ?? "";
      const errEmail = serverErrors[`ds_khach_${index}_email`] ?? "";
      const errCccd = serverErrors[`ds_khach_${index}_cccd`] ?? "";
      const errNgay = serverErrors[`ds_khach_${index}_ngay_sinh`] ?? "";

      return `
        <div class="col-md-6 khach-item" data-index="${index}">
            <div class="border p-3 mb-3 rounded bg-light">
                <h5>Khách hàng ${index + 1}</h5>

                ${data.hanh_khach_id ? `
                    <input type="hidden" name="ds_khach[${index}][hanh_khach_id]" value="${data.hanh_khach_id}">
                ` : ""}

                <div class="form-group">
                    <label>Họ Tên</label>
                    <input type="text" name="ds_khach[${index}][ho_ten]" 
                           value="${data.ho_ten ?? ""}" class="form-control">
                    ${showError && errName ? `<div class="invalid-feedback d-block">${errName}</div>` : ""}
                </div>

                <div class="form-group">
                    <label>Giới Tính</label>
                    <select name="ds_khach[${index}][gioi_tinh]" class="form-control">
                        <option value="" disabled>--Chọn Giới Tính--</option>
                        <option value="Nam" ${data.gioi_tinh=="Nam" ? "selected":""}>Nam</option>
                        <option value="Nữ" ${data.gioi_tinh=="Nữ" ? "selected":""}>Nữ</option>
                    </select>
                    ${showError && errGender ? `<div class="invalid-feedback d-block">${errGender}</div>` : ""}
                </div>

                <div class="form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" name="ds_khach[${index}][so_dien_thoai]" 
                           value="${data.so_dien_thoai ?? ""}" class="form-control">
                    ${showError && errPhone ? `<div class="invalid-feedback d-block">${errPhone}</div>` : ""}
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="ds_khach[${index}][email]" 
                           value="${data.email ?? ""}" class="form-control">
                    ${showError && errEmail ? `<div class="invalid-feedback d-block">${errEmail}</div>` : ""}
                </div>

                <div class="form-group">
                    <label>CCCD</label>
                    <input type="text" name="ds_khach[${index}][cccd]" 
                           value="${data.cccd ?? ""}" class="form-control">
                    ${showError && errCccd ? `<div class="invalid-feedback d-block">${errCccd}</div>` : ""}
                </div>

                <div class="form-group">
                    <label>Ngày Sinh</label>
                    <input type="date" name="ds_khach[${index}][ngay_sinh]" 
                           value="${data.ngay_sinh ?? ""}" class="form-control">
                    ${showError && errNgay ? `<div class="invalid-feedback d-block">${errNgay}</div>` : ""}
                </div>

                <div class="form-group">
                    <label>Ghi Chú</label>
                    <textarea name="ds_khach[${index}][ghi_chu]" class="form-control">${data.ghi_chu ?? ""}</textarea>
                </div>
            </div>
        </div>`;
    }

    function rebuildCustomers(required) {
      required = parseInt(required) || 1;

      container.innerHTML = "";

      for (let i = 0; i < required; i++) {
        // Ưu tiên dữ liệu từ $old (session) khi có lỗi validate, nếu không thì lấy từ DB
        let data = {};
        if (oldData && oldData.ds_khach && oldData.ds_khach[i]) {
          data = oldData.ds_khach[i];
        } else if (oldCustomers && oldCustomers[i]) {
          data = oldCustomers[i];
        }

        container.insertAdjacentHTML("beforeend", createCustomer(i, data));
      }
    }

    // Khi user thay đổi số lượng khách
    soNguoiInput.addEventListener("input", function() {
      rebuildCustomers(this.value);
    });

    // Tính tổng tiền
    function tinhTongTien() {
      const gia = parseFloat(gia_co_ban.value) || 0;
      const soNguoi = parseInt(soNguoiInput.value) || 1;
      const tong = gia * soNguoi;
      document.getElementById("tong_tien").value = tong;
    }

    // Khi chọn tour → cập nhật thông tin + tính tổng
    select.addEventListener("change", function() {
      tinhTongTien();
    });

    // Khi thay đổi số người → tạo danh sách khách + tính tổng
    soNguoiInput.addEventListener("input", function() {
      rebuildCustomers(this.value);
      tinhTongTien();
    });

    // Load ban đầu
    (function initOnLoad() {
      // Restore tour info nếu có dữ liệu cũ
      restoreTourInfo();

      // Restore loại tour
      if (oldData.loai) {
        document.getElementById("loai").value = oldData.loai;
      }

      // Restore số người
      if (oldData.so_nguoi) {
        soNguoiInput.value = oldData.so_nguoi;
      }

      // Restore ghi chú
      if (oldData.ghi_chu !== undefined) {
        document.getElementById("ghi_chu").value = oldData.ghi_chu;
      }

      // Restore tổng tiền
      if (oldData.tong_tien !== undefined) {
        document.getElementById("tong_tien").value = oldData.tong_tien;
      }

      rebuildCustomers(soNguoiInput.value);
      tinhTongTien();
    })();

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
          <h1> Sửa Booking</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 ">
          <div class="card ">
            <form action="<?= BASE_URL_ADMIN . "?act=sua-booking" ?>" method="POST">

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

                      <!-- TAB 1 -->
                      <div class="tab-pane fade show active" id="tab-tour" role="tabpanel">
                        <h4>Chọn Tour Du Lịch</h4>

                        <div class="form-group">
                          <select id="lich_id" name="lich_id" class="form-control select2" style="width: 100%;">

                            <option value="<?= $listBookingID['lich_id'] ?>"
                              data-ten-tour="<?= $listBookingID['ten_tour'] ?>"
                              data-mo-ta="<?= $listBookingID['mo_ta'] ?>"
                              data-gia-co-ban="<?= $listBookingID['gia_co_ban'] ?>"
                              data-chinh-sach="<?= $listBookingID['chinh_sach'] ?>"
                              data-diem-khoi-hanh="<?= $listBookingID['diem_khoi_hanh'] ?>"
                              selected>
                              <?= $listBookingID['ten_tour'] . " | " . formatDate($listBookingID["ngay_bat_dau"]) ?>
                            </option>

                            <?php foreach ($listLichAndTour as $item): ?>
                              <option value="<?= $item['lich_id'] ?>"
                                data-ten-tour="<?= $item['ten_tour'] ?>"
                                data-mo-ta="<?= $item['mo_ta'] ?>"
                                data-gia-co-ban="<?= $item['gia_co_ban'] ?>"
                                data-chinh-sach="<?= $item['chinh_sach'] ?>"
                                data-diem-khoi-hanh="<?= $item['diem_khoi_hanh'] ?>">
                                <?= $item['ten_tour'] . " | " . formatDate($item["ngay_bat_dau"]) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>

                          <?php if (isset($error['lich_id'])): ?>
                            <p class="text-danger"><?= $error['lich_id'] ?></p>
                          <?php endif; ?>
                        </div>

                        <div id="tourInfo" class="p-3 bg-light border rounded mt-3" style="display:block;">
                          <h5>Thông tin Tour</h5>

                          <div class="row">
                            <div class="col-md-6">

                              <div class="form-group">
                                <label>Tên Tour</label>
                                <input type="text" id="ten_tour" name="ten_tour" class="form-control"
                                  value="<?= $listBookingID['ten_tour'] ?>" readonly>
                              </div>

                              <div class="form-group">
                                <label>Giá Cơ Bản</label>
                                <input type="number" id="gia_co_ban" name="gia_co_ban" class="form-control"
                                  value="<?= $listBookingID['gia_co_ban'] ?>" readonly>
                              </div>

                              <div class="form-group">
                                <label>Chính Sách</label>
                                <input type="text" id="chinh_sach" name="chinh_sach" class="form-control"
                                  value="<?= $listBookingID['chinh_sach'] ?>" readonly>
                              </div>

                              <div class="form-group">
                                <label>Điểm Khởi Hành</label>
                                <input type="text" id="diem_khoi_hanh" name="diem_khoi_hanh" class="form-control"
                                  value="<?= $listBookingID['diem_khoi_hanh'] ?>" readonly>
                              </div>

                              <div class="form-group">
                                <label>Mô Tả</label>
                                <textarea id="mo_ta" name="mo_ta" class="form-control" readonly><?= $listBookingID['mo_ta'] ?></textarea>
                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">
                                <label>Loại Tour</label>
                                <select id="loai" name="loai" class="form-control select2">
                                  <option value="<?= $listBookingID['loai'] ?>" selected>
                                    <?= ($listBookingID['loai'] == "group") ? "Theo Nhóm" : "Cá Nhân" ?>
                                  </option>
                                  <option value="group">Theo Nhóm</option>
                                  <option value="individual">Cá Nhân</option>
                                </select>

                                <?php if (isset($error['loai'])): ?>
                                  <p class="text-danger"><?= $error['loai'] ?></p>
                                <?php endif; ?>
                              </div>

                              <div class="form-group">
                                <label>Số Lượng Người</label>
                                <input type="number" id="so_nguoi" name="so_nguoi" class="form-control"
                                  min="1" value="<?= $listBookingID['so_nguoi'] ?>">
                                <?php if (isset($error['so_nguoi'])): ?>
                                  <p class="text-danger"><?= $error['so_nguoi'] ?></p>
                                <?php endif; ?>
                              </div>

                              <input type="hidden" name="trang_thai_id" value="1">

                              <div class="form-group">
                                <label>Ghi Chú</label>
                                <textarea id="ghi_chu" name="ghi_chu" class="form-control"><?= $listBookingID['ghi_chu'] ?></textarea>
                              </div>

                              <div class="form-group">
                                <label>Tổng Tiền</label>
                                <input type="number" id="tong_tien" name="tong_tien" class="form-control"
                                  value="<?= $listBookingID['tong_tien'] ?>" readonly>
                              </div>

                            </div>

                          </div>
                        </div>

                      </div>

                      <!-- TAB 2 -->
                      <div class="tab-pane fade" id="tab-customer" role="tabpanel">
                        <h4>Thông Tin Người Đặt Tour</h4>

                        <input type="hidden" name="dat_tour_id" value="<?= $listBookingID['dat_tour_id'] ?>">
                        <input type="hidden" name="khach_hang_id" value="<?= $listBookingID['khach_hang_id'] ?>">

                        <div class="form-group">
                          <label>Tên Khách Hàng</label>
                          <input type="text" id="ho_ten" name="ho_ten" class="form-control"
                            value="<?= $listBookingID['ho_ten'] ?>">
                          <?php if (isset($error['ho_ten'])): ?>
                            <p class="text-danger"><?= $error['ho_ten'] ?></p>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>Số Điện Thoại</label>
                          <input type="text" id="so_dien_thoai" name="so_dien_thoai" class="form-control"
                            value="<?= $listBookingID['so_dien_thoai'] ?>">
                          <?php if (isset($error['so_dien_thoai'])): ?>
                            <p class="text-danger"><?= $error['so_dien_thoai'] ?></p>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" id="email" name="email" class="form-control"
                            value="<?= $listBookingID['email'] ?>">
                          <?php if (isset($error['email'])): ?>
                            <p class="text-danger"><?= $error['email'] ?></p>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>CCCD</label>
                          <input type="text" id="cccd" name="cccd" class="form-control"
                            value="<?= $listBookingID['cccd'] ?>">
                          <?php if (isset($error['cccd'])): ?>
                            <p class="text-danger"><?= $error['cccd'] ?></p>
                          <?php endif; ?>
                        </div>

                        <div class="form-group">
                          <label>Địa Chỉ</label>
                          <input type="text" id="dia_chi" name="dia_chi" class="form-control"
                            value="<?= $listBookingID['dia_chi'] ?>">
                          <?php if (isset($error['dia_chi'])): ?>
                            <p class="text-danger"><?= $error['dia_chi'] ?></p>
                          <?php endif; ?>
                        </div>
                      </div>

                      <!-- TAB 3 -->
                      <div class="tab-pane fade" id="tab-list" role="tabpanel">
                        <h4>Thông Tin Danh Sách Khách Hàng</h4>

                        <div id="customerList" class="row">

                          <?php $index = 1;
                          foreach ($listHanhKhach as $kh): ?>
                            <div class="col-md-6 khach-item" data-index="<?= $index ?>">
                              <div class="border p-3 mb-3 rounded bg-light">
                                <h5>Khách hàng <?= $index ?></h5>

                                <div class="form-group">
                                  <label>Họ Tên</label>
                                  <input type="hidden" name="ds_khach[<?= $index ?>][hanh_khach_id]"
                                    value="<?= $kh['hanh_khach_id'] ?>">
                                  <input type="text" name="ds_khach[<?= $index ?>][ho_ten]"
                                    value="<?= $kh['ho_ten'] ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Giới Tính</label>
                                  <select name="ds_khach[<?= $index ?>][gioi_tinh]" class="form-control">
                                    <option <?= ($kh['gioi_tinh'] == "Nam" ? "selected" : "") ?>>Nam</option>
                                    <option <?= ($kh['gioi_tinh'] == "Nữ" ? "selected" : "") ?>>Nữ</option>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label>Số Điện Thoại</label>
                                  <input type="text" name="ds_khach[<?= $index ?>][so_dien_thoai]"
                                    value="<?= $kh['so_dien_thoai'] ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" name="ds_khach[<?= $index ?>][email]"
                                    value="<?= $kh['email'] ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>CCCD</label>
                                  <input type="text" name="ds_khach[<?= $index ?>][cccd]"
                                    value="<?= $kh['cccd'] ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Ngày Sinh</label>
                                  <input type="date" name="ds_khach[<?= $index ?>][ngay_sinh]"
                                    value="<?= $kh['ngay_sinh'] ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Ghi Chú</label>
                                  <textarea name="ds_khach[<?= $index ?>][ghi_chu]"
                                    class="form-control"><?= $kh['ghi_chu'] ?></textarea>
                                </div>

                              </div>
                            </div>
                          <?php $index++;
                          endforeach; ?>

                        </div>

                      </div>

                    </div>
                  </div>

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập Nhật Booking</button>
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