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
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-6">

            <div class="col-12">
              <img style="width: 300px; height: 300px;" src="  <?= BASE_URL . $SanPham['hinh_anh'] ?>" class="product-image" alt="Product Image">
            </div>
            <div class="col-12 product-image-thumbs">
              <?php foreach ($listAnhSanPham as $key => $anhSP): ?>
                <div class="product-image-thumb active"><img src="<?= BASE_URL . $anhSP['link_hinh_anh'] ?>" alt="Product Image"></div>
              <?php endforeach ?>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <h3 class="my-3">Tên Sản Phẩm: <?= $SanPham['ten_san_pham'] ?></h3>
            <hr>
            <h4 class="my-3">Giá Sản Phẩm: <small><?= number_format($SanPham['gia_san_pham']) ?></small></h4>
            <h4 class="my-3">Giá Khuyến Mãi: <small><?php if ($SanPham['gia_khuyen_mai'] !== null) {
                                                      echo number_format($SanPham['gia_khuyen_mai']);
                                                    } else {
                                                      echo '';
                                                    }
                                                    ?></small></h4>
            <h4 class="my-3">Số Lượng: <small><?= ($SanPham['so_luong']) ?></small></h4>
            <h4 class="my-3">Ngày Nhập: <small><?= ($SanPham['ngay_nhap']) ?></small></h4>
            <h4 class="my-3">Loại Hàng: <small><?= ($SanPham['ten_danh_muc']) ?></small></h4>
            <h4 class="my-3">Trạng Thái: <small><?= ($SanPham['ten_trang_thai']) ?></small></h4>
          </div>
        </div>
        <div class="row mt-4">
          <nav class="w-100">
            <div class="nav nav-tabs" id="product-tab" role="tablist">
              <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#binh_luan" role="tab" aria-controls="product-desc" aria-selected="true">Bình Luận Sản Phẩm</a>
            </div>
            <div class="col-12">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Sản Phẩm</th>
                    <th>Nội Dung</th>
                    <th>Ngày Bình Luậnh/th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($listBinhLuan as $key => $binhluan): ?>
                    <tr>
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td><a target="_blank" href="<?= BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $binhluan['tai_khoan_id'] ?>"><?= $binhluan['ho_ten'] ?></a></td>
                      <td><?= $binhluan['noi_dung'] ?></td>
                      <td><?= formatDate($binhluan['ngay_dang']) ?></td>
                      <td><?= $binhluan['trang_thai'] == 1 ? 'Hiển thị' : 'Bị Ẩn' ?></td>
                      <td class="text-center">
                        <form action="<?= BASE_URL_ADMIN . "?act=update-trang-thai-binh-luan" ?>" method="post">
                          <input type="hidden" name="id_binh_luan" value="<?= $binhluan['id'] ?>">
                          <input type="hidden" name="name_view" value="detail_SP">
                          <button type="submit" onclick="return confirm('Bạn Có Muốn Đồng Ý Ẩn Bình Luận Này Hay Không')" class="btn btn-danger">
                            <?= $binhluan['trang_thai'] == 1 ? '<i class="far fa-eye-slash"></i>' : '<i class="far fa-eye"></i>' ?>

                          </button>
                        </form>

                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </nav>

        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->

  <!-- Main content -->

</div>
<!-- /.content-wrapper -->
<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
<!-- End Footer  -->
</body>
<script>
  $(document).ready(function() {
    $('.product-image-thumb').on('click', function() {
      var $image_element = $(this).find('img')
      $('.product-image').prop('src', $image_element.attr('src'))
      $('.product-image-thumb.active').removeClass('active')
      $(this).addClass('active')
    })
  })
</script>
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