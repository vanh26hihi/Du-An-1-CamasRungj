
<!-- header  -->
 <?php require_once './views/layout/header.php';?>
  <!-- Navbar -->
 <?php require_once './views/layout/navbar.php';?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 <?php require_once './views/layout/sidebar.php';?>
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Thêm Danh Mục Tour</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="<?=BASE_URL_ADMIN."?act=post-them-danh-muc"?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label >Thêm Danh Mục</label>
                    <input type="text" class="form-control" name="ten" placeholder="Nhập Tên Danh Mục">
                    <?php
                    if(isset($error)): ?>
                        <p class="text-danger"><?=$error?></p>
                    <?php endif ; ?>
                  </div>

                  <div class="form-group">
                    <label >Trạng thái</label>
                    <select name="trang_thai" id="" class="form-control">
                      <option value="Hiển thị">Hiển thị</option>
                      <option value="Ẩn">Ẩn</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Mô tả</label>
                    <textarea name="mo_ta" id="" class="form-control" placeholder="Nhập mô tả đi bố"></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thêm</button>
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
 <?php require_once './views/layout/footer.php';?>
  <!-- End Footer  -->
</body>
</html>