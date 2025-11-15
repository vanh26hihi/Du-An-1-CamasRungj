<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>

<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Lấy tham chiếu đến nút và ô input
    const button = document.getElementById("tour_id");
    const input = document.getElementById("get_tour_id");

    // Thêm sự kiện click cho nút
    button.addEventListener("click", function() {
      // Lấy giá trị đã chọn từ select
      const select = document.querySelector("select[name='tour_id']");
      const selectedValue = select.value;

      // Gán giá trị vào ô input ẩn
      input.value = selectedValue;

      // Hiển thị giá trị trong console (hoặc thực hiện các hành động khác)

    });
  }); -->
</script>
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
            <form action="<?= BASE_URL_ADMIN . "?act=them-booking" ?>" method="POST">
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
                  <div class="card-body ">
                    <div class="tab-content " id="custom-tabs-one-tabContent">
                      <div class="tab-pane fade show active" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                        <div class="form-group">
                          <<<<<<< HEAD
                            <label for="tour_id">Chọn Tour</label>
                            <select id="lich_id" name="tour_id" class="form-control select2" style="width: 100%;">
                              <?php foreach ($listLichAndTour as $item): ?>
                                <option value="<?= $listLichAndTour['lich_id'] ?>"><?= $listLichAndTour['ten_tour'] - $listLichAndTour["ngay_bat_dau"] ?></option>
                              <?php endforeach; ?>
                            </select>
                            <?php
                            if (isset($error['ten_danh_muc'])) { ?>
                              <p class="text-danger"><?= $error['ten_danh_muc'] ?></p>
                            <?php } ?>
                        </div>
                        <<<<<<< HEAD
                          </div>

                          <!-- /.card-body -->
                          >>>>>>> cbe84838b9a4ed2b30a045c240a80113f97f7c10
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