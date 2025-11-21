<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById("lich_id");
    const tourInfoBox = document.getElementById("tourInfo");
    const ten_tour = document.getElementById("ten_tour");
    const mo_ta = document.getElementById("mo_ta");
    const gia_co_ban = document.getElementById("gia_co_ban");
    const chinh_sach = document.getElementById("chinh_sach");
    const diem_khoi_hanh = document.getElementById("diem_khoi_hanh");

    // tour info
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

    // elements for customers
    const soNguoiInput = document.getElementById("so_nguoi");
    const container = document.getElementById("customerList");

    function generateCustomers(count) {
      // đảm bảo count ít nhất = 1 (theo min và value của bạn)
      count = parseInt(count) || 1;

      // Nếu container rỗng hoặc số lượng khác, (tạo lại)
      const existing = container.querySelectorAll('.khach-item').length;
      if (existing === count) return; // không cần rebuild nếu cùng số lượng

      container.innerHTML = "";
      for (let i = 1; i <= count; i++) {
        const html = `
      <div class="col-md-6">
    <div class="border p-3 mb-3 rounded bg-light khach-item">
      <h5>Khách hàng ${i}</h5>

      <div class="form-group">
        <label>Họ Tên</label>
        <input type="text" name="ds_khach[${i}][ho_ten]" class="form-control">
      </div>

      <div class="form-group">
        <label>Giới Tính</label>
        <select name="ds_khach[${i}][gioi_tinh]" class="form-control select2">
          <option value="" disabled selected>--Chọn Giới Tính--</option>
          <option value="Nam">Nam</option>
          <option value="Nữ">Nữ</option>
        </select>
      </div>

      <div class="form-group">
        <label>Số Điện Thoại</label>
        <input type="text" name="ds_khach[${i}][so_dien_thoai]" class="form-control">
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="text" name="ds_khach[${i}][email]" class="form-control">
      </div>

      <div class="form-group">
        <label>CCCD</label>
        <input type="text" name="ds_khach[${i}][cccd]" class="form-control">
      </div>

      <div class="form-group">
        <label>Ngày Sinh</label>
        <input type="date" name="ds_khach[${i}][ngay_sinh]" class="form-control">
      </div>

      <div class="form-group">
        <label>Ghi Chú</label>
        <textarea name="ds_khach[${i}][ghi_chu]" class="form-control"></textarea>
      </div>

    </div>
  </div>
      `;
        container.insertAdjacentHTML("beforeend", html);
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
    select.addEventListener("change", function() {
      tinhTongTien();
    });

    // Khi thay đổi số người → tạo danh sách khách + tính tổng
    soNguoiInput.addEventListener("input", function() {
      const val = parseInt(this.value) || 1;
      generateCustomers(val);
      tinhTongTien();
    });

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
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 ">
          <div class="card ">
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= BASE_URL_ADMIN . "?act=them-booking" ?>" method="POST">
              <div class="col-12 col-sm-12">
                <div class="card card-primary card-tabs">
                  <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Thông Tin Tour</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Thông Tin Người Đặt</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-list-tab" data-toggle="pill" href="#custom-tabs-one-list" role="tab" aria-controls="custom-tabs-one-list" aria-selected="false">Thông Tin Danh Sách Khách Hàng</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">

                      <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <h4>Chọn Tour Du Lịch</h4>
                        <div class="form-group">
                          <select id="lich_id" name="lich_id" class="form-control select2" style="width: 100%;">
                            <option value="" disabled selected>--Chọn Tour--</option>
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
                          <?php
                          if (isset($error['lich_id'])) { ?>
                            <p class="text-danger"><?= $error['lich_id'] ?></p>
                          <?php } ?>
                        </div>

                        <div id="tourInfo" class="p-3 bg-light border rounded mt-3" style="display:none;">
                          <h5>Thông tin Tour</h5>

                          <div class="row">
                            <!-- Cột trái -->
                            <div class="col-md-6">

                              <div class="form-group">
                                <label>Tên Tour</label>
                                <input type="text" name="ten_tour" id="ten_tour" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Giá Cơ Bản</label>
                                <input type="number" name="gia_co_ban" id="gia_co_ban" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Chính Sách</label>
                                <input type="text" name="chinh_sach" id="chinh_sach" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Điểm Khởi Hành</label>
                                <input type="text" name="diem_khoi_hanh" id="diem_khoi_hanh" class="form-control" readonly>
                              </div>

                              <div class="form-group">
                                <label>Mô Tả</label>
                                <textarea name="mo_ta" id="mo_ta" class="form-control" readonly></textarea>
                              </div>

                            </div>

                            <!-- Cột phải -->
                            <div class="col-md-6">

                              <div class="form-group">
                                <label>Loại Tour</label>
                                <select id="loai" name="loai" class="form-control select2">
                                  <option value="" disabled selected>--Chọn Loại Tour--</option>
                                  <option value="group">Theo Nhóm</option>
                                  <option value="individual">Cá Nhân</option>
                                </select>
                                <?php if (isset($error['loai'])) { ?>
                                  <p class="text-danger"><?= $error['loai'] ?></p>
                                <?php } ?>
                              </div>

                              <div class="form-group">
                                <label>Số Lượng Người</label>
                                <input type="number" name="so_nguoi" id="so_nguoi" class="form-control" min="1" value="1">
                                <?php if (isset($error['so_nguoi'])) { ?>
                                  <p class="text-danger"><?= $error['so_nguoi'] ?></p>
                                <?php } ?>
                              </div>

                              <input type="hidden" name="trang_thai_id" value="1">

                              <div class="form-group">
                                <label>Ghi Chú</label>
                                <textarea name="ghi_chu" id="ghi_chu" name="ghi_chu" class="form-control" placeholder="Nhập Ghi Chú"></textarea>
                              </div>

                              <div class="form-group">
                                <label>Tổng Tiền</label>
                                <input type="number" name="tong_tien" id="tong_tien" class="form-control" readonly>
                              </div>

                            </div>
                          </div>
                        </div>

                      </div>



                      <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        <h4>Thông Tin Người Đặt Tour</h4>
                        <div class="form-group">
                          <label>Tên Khách Hàng</label>
                          <input type="text" ten="ho_ten" name="ho_ten" id="ho_ten" class="form-control" placeholder="Nhập Tên Khách Hàng"></input>
                          <?php
                          if (isset($error['ho_ten'])) { ?>
                            <p class="text-danger"><?= $error['ho_ten'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Số Điện Thoại</label>
                          <input type="text" ten="so_dien_thoai" name="so_dien_thoai" id="so_dien_thoai" class="form-control" placeholder="Nhập Số Điện Thoại"></input>
                          <?php
                          if (isset($error['so_dien_thoai'])) { ?>
                            <p class="text-danger"><?= $error['so_dien_thoai'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" ten="email" name="email" id="email" class="form-control" placeholder="Nhập Số Email"></input>
                          <?php
                          if (isset($error['email'])) { ?>
                            <p class="text-danger"><?= $error['email'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>CCCD</label>
                          <input type="text" ten="cccd" name="cccd" id="cccd" class="form-control" placeholder="Nhập Số CCCD"></input>
                          <?php
                          if (isset($error['cccd'])) { ?>
                            <p class="text-danger"><?= $error['cccd'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Địa Chỉ</label>
                          <input type="text" ten="dia_chi" name="dia_chi" id="dia_chi" class="form-control" placeholder="Nhập Số Địa Chỉ"></input>
                          <?php
                          if (isset($error['dia_chi'])) { ?>
                            <p class="text-danger"><?= $error['dia_chi'] ?></p>
                          <?php } ?>
                        </div>
                      </div>

                      <div class="tab-pane fade" id="custom-tabs-one-list" role="tabpanel" aria-labelledby="custom-tabs-one-list-tab">
                        <h4>Thông Tin Danh Sách Khách Hàng</h4>
                        <div id="customerList" class="row">
                          <div id="warningSoNguoi" class="alert alert-danger" style="display:none;">
                            Vui lòng nhập Số Lượng Người Tham Gia Tour
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- /.card -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
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

<!-- End Footer  -->
</body>

<?php require_once './views/layout/footer.php'; ?>

</html>