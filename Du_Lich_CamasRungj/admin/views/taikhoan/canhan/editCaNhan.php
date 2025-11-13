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
            <hr>

            <div class="row">
                <!-- left column -->

                <div class="col-md-3">
                    <div class="text-center">
                        <img src="<?= $thongTin['anh_dai_dien'] ?? $_SESSION['user_admin_infor']['anh_dai_dien'] ?>" width="100" class="avatar img-circle" alt="avatar">
                        <h6 class="mt-2">Họ Tên: <?= $thongTin['ho_ten'] ?></h6>
                        <h6 class="mt-2">Chức vụ: <?= $thongTin['chuc_vu_id'] == 1 ? 'Quản Trị Viên' : 'Khách Hàng' ?></h6>
                    </div>
                </div>

                <!-- edit form column -->
                <div class="col-md-9 personal-info">
                    <form action="<?= BASE_URL_ADMIN . '?act=post-thong-tin-ca-nhan-quan-tri' ?>" method="post">
                        <hr>
                        <h3>Thông tin cá nhân</h3>

                        <form class="form-horizontal" role="form">
                            <input type="hidden" name="id_ca_nhan" value="<?= $thongTin['id'] ?>">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Họ tên:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="ho_ten" type="text" value="<?= $thongTin['ho_ten'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['ho_ten'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['ho_ten'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="email" type="text" value="<?= $thongTin['email'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['email'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['email'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Ngày sinh:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="ngay_sinh" type="date" value="<?= $thongTin['ngay_sinh'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['ngay_sinh'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['ngay_sinh'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Số điện thoại:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="so_dien_thoai" type="text" value="<?= $thongTin['so_dien_thoai'] ?>">
                                    <?php
                                    if (isset($_SESSION['error']['so_dien_thoai'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['so_dien_thoai'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Địa Chỉ:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="dia_chi" type="text" value="<?= $thongTin['dia_chi'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Giới Tính:</label>
                                <div class="col-lg-8">
                                    <div class="ui-select">
                                        <select id="user_time_zone" name="gioi_tinh" class="form-control">
                                            <?php foreach ($gioiTinh as $key => $listGioiTinh): ?>
                                                <option <?= $listGioiTinh['id'] == $thongTin['gioi_tinh'] ? 'selected' : '' ?> value="<?= $listGioiTinh['id'] ?>"><?= $listGioiTinh['ten_gioi_tinh'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                        <hr>
                        <!-- edit form column -->
                        <div class="col-md-8 personal-info">

                            <h3>Đổi Mật Khẩu</h3>
                            <?php if (isset($_SESSION['success_pass'])) { ?>
                                <div class="alert alert-info alert-dismissable ">
                                    <a class="panel-close close" data-dismiss="alert">×</a>
                                    <i class="fa fa-coffee"></i>
                                    <?= $_SESSION['success_pass'] ?>
                                </div>
                                <?php unset($_SESSION['success_pass']); ?>
                            <?php } else if (isset($_SESSION['error_pass'])) { ?>
                                <div class="alert alert-danger alert-dismissable ">
                                    <a class="panel-close close" data-dismiss="alert">×</a>
                                    <i class="fa fa-coffee"></i>
                                    <?= $_SESSION['error_pass'] ?>
                                </div>
                                <?php unset($_SESSION['error_pass']); ?>
                            <?php } else { ?>
                                <?= '' ?>
                            <?php } ?>
                            <form action="<?= BASE_URL_ADMIN . '?act=sua-mat-khau-ca-nhan-quan-tri' ?>" method="post">
                        </div>
                        <input type="hidden" name="email" value="<?= $thongTin['email'] ?>">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Mật khẩu cũ:</label>
                            <div class="col-md-8">
                                <input class="form-control" name="old_pass" type="text" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Mật khẩu mới:</label>
                            <div class="col-md-8">
                                <input class="form-control" name="new_pass" type="text" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nhập lại mật khẩu mới:</label>
                            <div class="col-md-8">
                                <input class="form-control" name="confirm_pass" type="text" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-8">
                                <input type="submit" class="btn btn-primary" value="Save Changes">
                            </div>
                        </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
        <hr>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
<!-- End Footer  -->
</body>

</html>