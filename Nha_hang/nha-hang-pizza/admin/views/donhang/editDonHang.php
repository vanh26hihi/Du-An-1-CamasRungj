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
        <div class="col-sm-11">
          <h1> Sửa thông tin Đơn Hàng</h1>
        </div>
        <div class="col-sm-1 ">
          <a href="#" class="btn btn-secondary"> Quay Lại </a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row col-md-12">
      <div class=" col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title ">Sửa Thông tin Đơn Hàng: <?= $DonHang['ma_don_hang'] ?> </h3>
          </div>
          <form action="<?= BASE_URL_ADMIN . "?act=sua-don-hang" ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $DonHang['id'] ?>">
            <!-- Tên Đơn Hàng -->

            <!-- Tên Người Nhận -->
            <div class="card-body ">
              <div class="form-group">
                <label for="inputName">Tên Người Nhận</label>
                <input type="text" name="ten_nguoi_nhan" id="inputName" class="form-control" value="<?= $_SESSION['old_data']['ten_nguoi_nhan'] ?? $DonHang['ten_nguoi_nhan'] ?>">
                <?php
                if (isset($_SESSION['error']['ten_nguoi_nhan'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['ten_nguoi_nhan'] ?></p>
                <?php } ?>
              </div>
            </div>

            <!-- Số Điện Thoại -->
            <div class="card-body ">
              <div class="form-group">
                <label for="inputName">Số Điện Thoại</label>
                <input type="text" name="sdt_nguoi_nhan" id="inputName" class="form-control" value="<?= $_SESSION['old_data']['sdt_nguoi_nhan'] ?? $DonHang['sdt_nguoi_nhan'] ?>">
                <?php
                if (isset($_SESSION['error']['sdt_nguoi_nhan'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['sdt_nguoi_nhan'] ?></p>
                <?php } ?>
              </div>
            </div>

            <!-- Địa Chỉ Người Nhận -->
            <div class="card-body ">
              <div class="form-group">
                <label for="inputName">Địa Chỉ Người Nhận</label>
                <input type="text" name="dia_chi_nguoi_nhan" id="inputName" class="form-control" value="<?= $_SESSION['old_data']['dia_chi_nguoi_nhan'] ?? $DonHang['dia_chi_nguoi_nhan'] ?>">
                <?php
                if (isset($_SESSION['error']['dia_chi_nguoi_nhan'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['dia_chi_nguoi_nhan'] ?></p>
                <?php } ?>
              </div>
            </div>

            <!-- Email Người Nhận -->
            <div class="card-body ">
              <div class="form-group">
                <label for="inputName">Email Người Nhận</label>
                <input type="text" name="email_nguoi_nhan" id="inputName" class="form-control" value="<?= $_SESSION['old_data']['email_nguoi_nhan'] ?? $DonHang['email_nguoi_nhan'] ?>">
                <?php
                if (isset($_SESSION['error']['email_nguoi_nhan'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['email_nguoi_nhan'] ?></p>
                <?php } ?>
              </div>
            </div>

            <!-- Trạng Thái -->
            <div class="card-body ">
              <div class="form-group">
                <label for="inputName">Trạng Thái Đơn Hàng</label>
                <input type="hidden" name="old_trang_thai" value="<?= $listTrangThai['id'] ?>">
                <select name="trang_thai_id" id="inputName" class="form-control">
                  <?php foreach ($TrangThai as $key => $listTrangThai): ?>
                    <option
                      <?php
                      if (
                        $DonHang['trang_thai_id'] > $listTrangThai['id']
                        || $DonHang['trang_thai_id'] == 9
                        || $DonHang['trang_thai_id'] == 10
                        || $DonHang['trang_thai_id'] == 11
                      ) {
                        echo 'disabled';
                      }

                      ?>
                      <?= $listTrangThai['id'] == $DonHang['trang_thai_id'] ? 'selected' : '' ?>
                      value="<?= $listTrangThai['id'] ?>">
                      <?= $listTrangThai['ten_trang_thai'] ?>
                    </option>
                  <?php endforeach ?>

                </select>
              </div>
            </div>
            <!-- Ghi Chú -->
            <div class="card-body col-md-12">
              <div class="form-group">
                <label for="inputName">Ghi Chú</label>
                <textarea name="ghi_chu" id="inputDescription" class="form-control" rows="4"><?= $DonHang['ghi_chu'] ?></textarea>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-primary">Sửa thông tin</button>
            </div>
        </div>
        </form>
        <!-- /.card -->
      </div>
      <!-- /.card -->
      </form>
      <!-- /.card -->
    </div>
</div>
</section>

<!-- Main content -->

</div>
<!-- /.content-wrapper -->
<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
<!-- End Footer  -->
</body>
<script>
  var faqs_row = <?= count($listAnhDonHang); ?>;

  function addfaqs() {
    html = '<tr id="faqs-row-' + faqs_row + '">';
    html += '<td><img src="<?= BASE_URL . 'uploads/images.png' ?>" style="width: 50px; height: 50px;"></td>'
    html += '<td><input type="file" name="img_array[]" class="form-control"></td>';
    html += '<td class="mt-10"><button type="button" class="badge badge-danger" onclick="removeRow(' + faqs_row + ', null);"><i class="fa fa-trash"></i> Delete</button></td>';
    html += '</tr>';

    $('#faqs tbody').append(html);

    faqs_row++;
  }

  function removeRow(rowId, imgId) {
    $('#faqs-row-' + rowId).remove();
    if (imgId !== null) {
      var imgDeleteInput = document.getElementById('img_delete');
      var currentValue = imgDeleteInput.value;
      imgDeleteInput.value = currentValue ? currentValue + ',' + imgId : imgId;
    }
  }
</script>

</html>