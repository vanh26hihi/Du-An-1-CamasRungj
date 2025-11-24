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
              <h3 class="card-title">Sửa Danh Mục Tour</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="?act=post-sua-danh-muc" method="POST">
                            <div class="card-body">

                                <!-- ID Ẩn -->
                                <input type="hidden" name="id" value="<?= $danhmuc['danh_muc_id'] ?>">

                                <!-- Tên danh mục -->
                                <div class="form-group">
                                    <label>Tên danh mục</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="ten" 
                                        value="<?= $danhmuc['ten'] ?>" 
                                        placeholder="Nhập tên danh mục"
                                        required
                                    >
                                </div>

                                <!-- Mô tả -->
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea 
                                        name="mo_ta" 
                                        class="form-control" 
                                        placeholder="Nhập mô tả"
                                    ><?= $danhmuc['mo_ta'] ?></textarea>
                                </div>

                                <!-- Trạng thái -->
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="trang_thai" class="form-control">
                                        <option value="1" <?= $danhmuc['trang_thai'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
                                        <option value="0" <?= $danhmuc['trang_thai'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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