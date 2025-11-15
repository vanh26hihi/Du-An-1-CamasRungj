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
          <h1> Quản lý Booking</h1>
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
            <form action="<?= BASE_URL_ADMIN . "?act=them-danh-muc" ?>" method="POST">
              <div class="col-12 col-sm-12">
                <div class="card card-primary card-tabs">
                  <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Danh sách tour</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Profile</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                      <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

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
                          <input type="text" ten="email" name="email" id="email" class="form-control" placeholder="Nhập Số Điện Thoại"></input>
                          <?php
                          if (isset($error['email'])) { ?>
                            <p class="text-danger"><?= $error['email'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>CCCD</label>
                          <input type="text" ten="cccd" name="cccd" id="cccd" class="form-control" placeholder="Nhập Số Điện Thoại"></input>
                          <?php
                          if (isset($error['cccd'])) { ?>
                            <p class="text-danger"><?= $error['cccd'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Địa Chỉ</label>
                          <input type="text" ten="dia_chi" name="dia_chi" id="dia_chi" class="form-control" placeholder="Nhập Số Điện Thoại"></input>
                          <?php
                          if (isset($error['dia_chi'])) { ?>
                            <p class="text-danger"><?= $error['dia_chi'] ?></p>
                          <?php } ?>
                        </div>
                        <hr>

                        <h4>Chọn Tour Du Lịch</h4>

                        <div class="form-group">
                          <label for="lich_and_tour">Chọn Tour</label>
                          <select id="lich_and_tour" name="lich_and_tour" class="form-control select2" style="width: 100%;">
                            <?php foreach ($listLichAndTour as $item): ?>
                              <option value="<?= [$item['lich_id'], $item['tour_id']]  ?>"><?= $item['ten_tour'] . " | " . formatDate($item["ngay_bat_dau"]) ?></option>
                            <?php endforeach; ?>
                          </select>
                          <?php
                          if (isset($error['lich_and_tour'])) { ?>
                            <p class="text-danger"><?= $error['lich_and_tour'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Loại Tour</label>
                          <select id="loai" name="loai" class="form-control select2" style="width: 100%;">
                            <option value="">--Chọn Loại Tour--</option>
                            <option value="group">Theo Nhóm</option>
                            <option value="individual">Cá Nhân</option>
                          </select>
                          <?php
                          if (isset($error['loai'])) { ?>
                            <p class="text-danger"><?= $error['loai'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Số Lượng Người</label>
                          <input type="number" ten="dia_chi" name="dia_chi" id="dia_chi" class="form-control" min="1" value="1" placeholder="Nhập Số Điện Thoại"></input>
                          <?php
                          if (isset($error['dia_chi'])) { ?>
                            <p class="text-danger"><?= $error['dia_chi'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label for="lich_and_tour"></label>
                          <select id="lich_and_tour" name="lich_and_tour" class="form-control select2" style="width: 100%;">
                            <?php foreach ($listLichAndTour as $item): ?>
                              <option value="<?= [$item['lich_id'], $item['tour_id']]  ?>"><?= $item['ten_tour'] . " | " . formatDate($item["ngay_bat_dau"]) ?></option>
                            <?php endforeach; ?>
                          </select>
                          <?php
                          if (isset($error['lich_and_tour'])) { ?>
                            <p class="text-danger"><?= $error['lich_and_tour'] ?></p>
                          <?php } ?>
                        </div>

                        <div class="form-group">
                          <label>Mô Tả</label>
                          <textarea ten="mo_ta" id="" class="form-control" placeholder="Nhập Mô Tả"></textarea>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
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
<?php require_once './views/layout/footer.php'; ?>
<!-- End Footer  -->
</body>

</html>