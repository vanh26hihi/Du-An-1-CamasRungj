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
                    <h1> Quản lý Tài Khoản Khách Hàng</h1>
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
                            <h3 class="card-title">Sửa Thông Khoản Khách Hàng: <?= $khachHang['ho_ten'] ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN . "?act=sua-khach-hang" ?>" method="POST">
                            <div class="card-body">

                                <input type="hidden" name="khach_hang_id" value="<?= $khachHang['id'] ?>">

                                <div class="form-group">
                                    <label>Họ tên</label>
                                    <input type="text" class="form-control" name="ho_ten" placeholder="Nhập Tên Tài Khoản" value="<?= $khachHang['ho_ten'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['ho_ten'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['ho_ten'] ?></p>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Nhập Email" value="<?= $khachHang['email'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['email'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['email'] ?></p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Số Điện Thoại</label>
                                    <input type="text" class="form-control" name="so_dien_thoai" placeholder="Nhập số Điện Thoại" value="<?= $khachHang['so_dien_thoai'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['so_dien_thoai'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['so_dien_thoai'] ?></p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Ngày Sinh</label>
                                    <input type="date" class="form-control" name="ngay_sinh" placeholder="Nhập số Điện Thoại" value="<?= $khachHang['ngay_sinh'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['ngay_sinh'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['ngay_sinh'] ?></p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Giới Tính</label>
                                    <select name="gioi_tinh" id="inputName" class="form-control">
                                        <?php foreach ($gioiTinh as $key => $listGioiTinh): ?>
                                            <option
                                                <?= $listGioiTinh['id'] == $khachHang['gioi_tinh'] ? 'selected' : '' ?>
                                                value="<?= $listGioiTinh['id'] ?>">
                                                <?= $listGioiTinh['ten_gioi_tinh'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Địa Chỉ</label>
                                    <input type="text" class="form-control" name="dia_chi" placeholder="Nhập Địa Chỉ" value="<?= $khachHang['dia_chi'] ?>">
                                </div>

                                <div class="form-group">
                                    <label>Trạng Thái</label>
                                    <select name="trang_thai" id="inputName" class="form-control">
                                        <?php foreach ($trangThai as $key => $listTrangThai): ?>
                                            <option
                                                <?= $listTrangThai['id'] == $khachHang['trang_thai'] ? 'selected' : '' ?>
                                                value="<?= $listTrangThai['id'] ?>">
                                                <?= $listTrangThai['ten_trang_thai'] ?>
                                            </option>
                                        <?php endforeach ?>

                                    </select>
                                </div>
                                <!-- /.card-body -->

                            </div>

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