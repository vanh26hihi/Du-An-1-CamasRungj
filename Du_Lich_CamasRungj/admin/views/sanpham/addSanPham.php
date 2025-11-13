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
          <h1> Quản lý Sản Phẩm</h1>
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
              <h3 class="card-title">Thêm Sản Phẩm</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= BASE_URL_ADMIN . "?act=them-san-pham" ?>" method="POST" enctype="multipart/form-data">
              <div class="card-body row">

                <!-- Tên Sản Phẩm -->
                <div class="form-group col-6">
                  <label>Tên Sản Phẩm</label>
                  <input type="text" class="form-control" name="ten_san_pham" value="<?= isset($_POST['ten_san_pham']) ? $_POST['ten_san_pham'] : '' ?>" placeholder="Nhập Tên Sản Phẩm">
                  <?php
                  if (isset($_SESSION['error']['ten_san_pham'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['ten_san_pham'] ?></p>
                  <?php } ?>
                </div>

                <!-- Giá Tiền -->
                <div class="form-group col-6">
                  <label>Giá Tiền</label>
                  <input type="number" class="form-control" name="gia_san_pham" min="0" placeholder="Nhập Giá Sản Phẩm">
                  <?php
                  if (isset($_SESSION['error']['gia_san_pham'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['gia_san_pham'] ?></p>
                  <?php } ?>
                </div>

                <!-- Giá Khuyến Mãi -->
                <div class="form-group col-6">
                  <label>Giá Khuyến Mãi</label>
                  <input type="number" class="form-control" name="gia_khuyen_mai" placeholder="Nhập Giá Khuyến Mãi">
                </div>

                <!-- Số Lượng -->
                <div class="form-group col-6">
                  <label>Số Lượng</label>
                  <input type="number" class="form-control" name="so_luong" placeholder="Nhập Số Lượng Sản Phẩm">
                  <?php
                  if (isset($_SESSION['error']['so_luong'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['so_luong'] ?></p>
                  <?php } ?>
                </div>

                <!-- Ảnh Sản Phẩm -->
                <div class="form-group col-6">
                  <label>Ảnh Sản Phẩm</label>
                  <input type="file" class="form-control" name="hinh_anh">
                  <?php
                  if (isset($_SESSION['error']['hinh_anh'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['hinh_anh'] ?></p>
                  <?php } ?>
                </div>

                <!-- Album Ảnh Sản Phẩm -->
                <div class="form-group col-6">
                  <label>Album Ảnh Sản Phẩm</label>
                  <input type="file" class="form-control" name="img_array[]" multiple>
                </div>

                <!-- Lượt Xem -->
                <div class="form-group col-6">
                  <label>Lượt Xem</label>
                  <input type="number" class="form-control" name="luot_xem" placeholder="Nhập Lượt Xem Sản Phẩm">
                  <?php
                  if (isset($_SESSION['error']['luot_xem'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['luot_xem'] ?></p>
                  <?php } ?>
                </div>

                <!-- Ngày Nhập -->
                <div class="form-group col-6">
                  <label>Ngay Nhập</label>
                  <input type="date" class="form-control" name="ngay_nhap" placeholder="Nhập Ngày Nhập Sản Phẩm">
                  <?php
                  if (isset($_SESSION['error']['ngay_nhap'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['ngay_nhap'] ?></p>
                  <?php } ?>
                </div>

                <!-- Danh Mục -->
                <div class="form-group col-6">
                  <label>Danh Mục</label>
                  <select name="danh_muc_id" class="form-control" id="">
                    <option selected disabled value="">Chọn Danh Mục</option>

                    <?php foreach ($listDanhMuc as $danhMuc): ?>
                      <option value="<?= $danhMuc['id'] ?>"><?= $danhMuc['ten_danh_muc'] ?></option>
                    <?php endforeach ?>

                  </select>
                  <?php
                  if (isset($_SESSION['error']['danh_muc_id'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['danh_muc_id'] ?></p>
                  <?php } ?>
                </div>

                <!-- Trạng Thái -->
                <div class="form-group col-6">
                  <label>Trạng Thái</label>
                  <select name="trang_thai" class="form-control" id="">
                    <option selected disabled value="">Chọn Trạng Thái</option>

                    <?php foreach ($listTrangThai as $trangthai): ?>
                      <option value="<?= $trangthai['id'] ?>"><?= $trangthai['ten_trang_thai'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <?php
                  if (isset($_SESSION['error']['danh_muc_id'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['danh_muc_id'] ?></p>
                  <?php } ?>
                </div>

                <!-- Mô Tả -->
                <div class="form-group col-12">
                  <label>Mô Tả</label>
                  <textarea name="mo_ta" class="form-control" id="" placeholder="Nhập Mô Tả Sản Phẩm"></textarea>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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
</body>

</html>