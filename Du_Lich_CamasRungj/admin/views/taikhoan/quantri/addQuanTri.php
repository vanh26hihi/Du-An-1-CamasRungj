<?php 
require_once './views/layout/header.php'; 
$error = $_SESSION['error'] ?? [];
$old = $_SESSION['old'] ?? [];
?>
<?php require_once './views/layout/navbar.php'; ?>
<?php require_once './views/layout/sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm Tài Khoản Quản Trị</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?act=/">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="?act=danh-sach-quan-tri">Quản lý tài khoản quản trị</a></li>
                        <li class="breadcrumb-item active">Thêm tài khoản quản trị</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thông Tin Tài Khoản Quản Trị</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN . "?act=them-quan-tri" ?>" method="POST" autocomplete="off">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="ho_ten">Họ và Tên <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($error['ho_ten']) ? 'is-invalid' : '' ?>" 
                                           id="ho_ten" 
                                           name="ho_ten" 
                                           placeholder="Nhập họ và tên"
                                           autocomplete="off"
                                           value="<?= htmlspecialchars($old['ho_ten'] ?? '') ?>">
                                    <?php if (isset($error['ho_ten'])): ?>
                                        <span class="error invalid-feedback"><?= $error['ho_ten'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control <?= isset($error['email']) ? 'is-invalid' : '' ?>" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Nhập email"
                                           autocomplete="off"
                                           value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                                    <?php if (isset($error['email'])): ?>
                                        <span class="error invalid-feedback"><?= $error['email'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="so_dien_thoai">Số Điện Thoại <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($error['so_dien_thoai']) ? 'is-invalid' : '' ?>" 
                                           id="so_dien_thoai" 
                                           name="so_dien_thoai" 
                                           placeholder="Nhập số điện thoại (9-11 số)"
                                           autocomplete="off"
                                           value="<?= htmlspecialchars($old['so_dien_thoai'] ?? '') ?>">
                                    <?php if (isset($error['so_dien_thoai'])): ?>
                                        <span class="error invalid-feedback"><?= $error['so_dien_thoai'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="mat_khau">Mật Khẩu <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           class="form-control <?= isset($error['mat_khau']) ? 'is-invalid' : '' ?>" 
                                           id="mat_khau" 
                                           name="mat_khau" 
                                           placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)"
                                           autocomplete="new-password">
                                    <?php if (isset($error['mat_khau'])): ?>
                                        <span class="error invalid-feedback"><?= $error['mat_khau'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="xac_nhan_mat_khau">Xác Nhận Mật Khẩu <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           class="form-control <?= isset($error['xac_nhan_mat_khau']) ? 'is-invalid' : '' ?>" 
                                           id="xac_nhan_mat_khau" 
                                           name="xac_nhan_mat_khau" 
                                           placeholder="Nhập lại mật khẩu"
                                           autocomplete="new-password">
                                    <?php if (isset($error['xac_nhan_mat_khau'])): ?>
                                        <span class="error invalid-feedback"><?= $error['xac_nhan_mat_khau'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Hidden field: Trạng thái mặc định là active -->
                                <input type="hidden" name="trang_thai" value="active">
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Thêm Tài Khoản
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=danh-sach-quan-tri" ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay Lại
                                </a>
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
<?php 
// Clear session errors AFTER displaying (this runs after HTML is sent to browser)
if (isset($_SESSION['flash'])) {
    unset($_SESSION['error'], $_SESSION['old'], $_SESSION['flash']);
}
?>
