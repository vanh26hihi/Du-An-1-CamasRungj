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
          <h1> Sửa thông tin sản phẩm <?= $SanPham['ten_san_pham'] ?></h1>
        </div>
        <div class="col-sm-1 ">
          <a href="#" class="btn btn-secondary"> Quay Lại </a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title ">Thông tin sản phẩm</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <form action="<?= BASE_URL_ADMIN . "?act=sua-san-pham" ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $SanPham['id_san_pham'] ?>">
            <!-- Tên sản phẩm -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" id="inputName" class="form-control" value="<?= $SanPham['ten_san_pham'] ?>">
                <?php
                if (isset($_SESSION['error']['ten_san_pham'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['ten_san_pham'] ?></p>
                <?php } ?>
              </div>
            </div>
            <!-- Giá sản phẩm -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Giá sản phẩm</label>
                <input type="text" name="gia_san_pham" id="inputName" class="form-control" value="<?= number_format($SanPham['gia_san_pham']) ?>">
                <?php
                if (isset($_SESSION['error']['gia_san_pham'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['gia_san_pham'] ?></p>
                <?php } ?>
              </div>
            </div>
            <!-- Giá Khuyến Mãi -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Giá Khuyến Mãi</label>
                <input type="text" name="gia_khuyen_mai" id="inputName" class="form-control" value="<?php if ($SanPham['gia_khuyen_mai'] !== null) {
                                                                                                      echo number_format($SanPham['gia_khuyen_mai']);
                                                                                                    } else {
                                                                                                      echo '';
                                                                                                    }
                                                                                                    ?>">
                <?php
                if (isset($_SESSION['error']['gia_khuyen_mai'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['gia_khuyen_mai'] ?></p>
                <?php } ?>
              </div>
            </div>
            <!-- Số Lượng -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Số Lượng</label>
                <input type="text" name="so_luong" id="inputName" class="form-control" value="<?= $SanPham['so_luong'] ?>">
                <?php
                if (isset($_SESSION['error']['so_luong'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['so_luong'] ?></p>
                <?php } ?>
              </div>
            </div>
            <!-- Ảnh Sản phẩm -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Ảnh sản phẩm</label>
                <input type="hidden" value="<?= $SanPham['hinh_anh'] ?>" name="">
                <input type="file" id="inputName" name="hinh_anh" class="form-control">
              </div>
            </div>
            <!-- Lượt xem -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Lượt xem</label>
                <input type="text" name="luot_xem" id="inputName" class="form-control" value="<?= $SanPham['luot_xem'] ?>">
                <?php
                if (isset($_SESSION['error']['luot_xem'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['luot_xem'] ?></p>
                <?php } ?>
              </div>
            </div>
            <!-- Ngày Nhập -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Ngày Nhập</label>
                <input type="date" name="ngay_nhap" id="inputName" class="form-control" value="<?= $SanPham['ngay_nhap'] ?>">
                <?php
                if (isset($_SESSION['error']['ngay_nhap'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['ngay_nhap'] ?></p>
                <?php } ?>
              </div>
            </div>
            <!-- Danh Muc -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Danh mục</label>
                <select name="danh_muc_id" id="inputName" class="form-control">
                  <option value="<?= $SanPham['danh_muc_id'] ?>"><?= $SanPham['ten_danh_muc'] ?></option>

                  <?php foreach ($DanhMuc as $key => $listDanhMuc): ?>
                    <option <?php $listDanhMuc['id'] == $SanPham['danh_muc_id'] ? 'selected' : '' ?> value="<?= $listDanhMuc['id'] ?>"> <?= $listDanhMuc['ten_danh_muc'] ?></option>
                  <?php endforeach ?>

                </select>
              </div>
            </div>

            <!-- Trạng Thái -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Trạng Thái</label>
                <select name="trang_thai" id="inputName" class="form-control">
                  <option value="<?= $SanPham['id'] ?>"><?= $SanPham['ten_trang_thai'] ?></option>

                  <?php foreach ($TrangThai as $key => $listTrangThai): ?>
                    <option <?php $listTrangThai['id'] == $SanPham['trang_thai'] ? 'selected' : '' ?> value="<?= $listTrangThai['id'] ?>"> <?= $listTrangThai['ten_trang_thai'] ?></option>
                  <?php endforeach ?>

                </select>
              </div>
            </div>
            <!-- Mô tả -->
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Mô Tả</label>
                <textarea name="mo_ta" id="inputDescription" class="form-control" rows="4"><?= $SanPham['mo_ta'] ?></textarea>
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
      <div class="col-md-4">
        <!-- /.card -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Album ảnh sản phẩm</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body p-0">
            <form action="<?= BASE_URL_ADMIN . "?act=sua-album-anh-san-pham" ?>" method="post" enctype="multipart/form-data">
              <div class="table-responsive">
                <table id="faqs" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Ảnh</th>
                      <th>File</th>
                      <th>
                        <div class="text-center"><button onclick="addfaqs();" type="button" class="badge badge-success"><i class="fa fa-plus"></i>Thêm</button></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <input type="hidden" name="san_pham_id" value="<?= $SanPham['id_san_pham'] ?>">
                    <input type="hidden" id="img_delete" name="img_delete" value="<?= $SanPham['id'] ?>">
                    <?php
                    foreach ($listAnhSanPham as $key => $value): ?>
                      <tr id="faqs-row-<?= $key ?>">
                        <input type="hidden" name="current_img_ids[]" value="<?= $value['id'] ?>">
                        <td><img src="<?= BASE_URL . $value['link_hinh_anh'] ?>" style="width: 50px; height: 50px;"></td>
                        <td><input type="file" name="img_array[]" placeholder="Product name" class="form-control"></td>
                        <td class="mt-10"><button class="badge badge-danger" type="button" onclick="removeRow(<?= $key ?> , <?= $value['id'] ?>)"><i class="fa fa-trash"></i> Delete</button></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>

          </div>
          <!-- /.card-body -->
          <div class="card-footer text-center">
            <button class="btn btn-primary" type="submit">Lưu Album ảnh</button>
          </div>
          </form>
        </div>
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
  var faqs_row = <?= count($listAnhSanPham); ?>;

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