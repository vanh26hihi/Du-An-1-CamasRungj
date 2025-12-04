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
                    <h1>Quản Lý Tài Khoản Cá Nhân</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?act=/">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Tài khoản cá nhân</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Profile Card -->
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="<?= $thongTin['anh_dai_dien'] ?? './assets/dist/img/user2-160x160.jpg' ?>"
                                     alt="User profile picture"
                                     onerror="this.src='./assets/dist/img/user2-160x160.jpg'">
                            </div>

                            <h3 class="profile-username text-center"><?= htmlspecialchars($thongTin['ho_ten']) ?></h3>

                            <p class="text-muted text-center">
                                <i class="fas fa-user-shield"></i>
                                <?= $thongTin['vai_tro_id'] == 1 ? 'Quản Trị Viên' : 'Hướng Dẫn Viên' ?>
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b>
                                    <a class="float-right"><?= htmlspecialchars($thongTin['email']) ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Trạng thái</b>
                                    <span class="float-right badge badge-success">
                                        <?= $thongTin['trang_thai'] === 'active' ? 'Hoạt động' : 'Khóa' ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Edit Forms -->
                <div class="col-md-9">
                    <!-- Thông tin cá nhân -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-edit"></i> Thông Tin Cá Nhân
                            </h3>
                        </div>
                        <!-- Success/Error Messages -->
                        <div class="card-body">
                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <?= $_SESSION['success'] ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                                <?php unset($_SESSION['success']); ?>
                            <?php endif; ?>

                            <form action="<?= BASE_URL_ADMIN . '?act=post-thong-tin-ca-nhan-quan-tri' ?>" method="POST">
                                <input type="hidden" name="nguoi_dung_id" value="<?= $thongTin['nguoi_dung_id'] ?>">
                                
                                <div class="form-group">
                                    <label for="ho_ten">Họ và Tên <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($error['ho_ten']) ? 'is-invalid' : '' ?>" 
                                           id="ho_ten" 
                                           name="ho_ten" 
                                           value="<?= htmlspecialchars($old['ho_ten'] ?? $thongTin['ho_ten']) ?>">
                                    <?php if (isset($error['ho_ten'])): ?>
                                        <span class="error invalid-feedback"><?= $error['ho_ten'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           value="<?= htmlspecialchars($thongTin['email']) ?>"
                                           disabled>
                                    <small class="form-text text-muted">Email không thể thay đổi</small>
                                </div>

                                <div class="form-group">
                                    <label for="so_dien_thoai">Số Điện Thoại <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($error['so_dien_thoai']) ? 'is-invalid' : '' ?>" 
                                           id="so_dien_thoai" 
                                           name="so_dien_thoai" 
                                           placeholder="Nhập số điện thoại (9-11 số)"
                                           value="<?= htmlspecialchars($old['so_dien_thoai'] ?? $thongTin['so_dien_thoai']) ?>">
                                    <?php if (isset($error['so_dien_thoai'])): ?>
                                        <span class="error invalid-feedback"><?= $error['so_dien_thoai'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Lưu Thay Đổi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Đổi mật khẩu -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-key"></i> Đổi Mật Khẩu
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION['success_pass'])): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <?= $_SESSION['success_pass'] ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                                <?php unset($_SESSION['success_pass']); ?>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['error_pass'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $_SESSION['error_pass'] ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                                <?php unset($_SESSION['error_pass']); ?>
                            <?php endif; ?>

                            <form action="<?= BASE_URL_ADMIN . '?act=sua-mat-khau-ca-nhan-quan-tri' ?>" method="POST">
                                <input type="hidden" name="email" value="<?= $thongTin['email'] ?>">
                                
                                <div class="form-group">
                                    <label for="old_pass">Mật Khẩu Cũ <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="old_pass" 
                                           name="old_pass" 
                                           placeholder="Nhập mật khẩu cũ"
                                           autocomplete="current-password">
                                </div>

                                <div class="form-group">
                                    <label for="new_pass">Mật Khẩu Mới <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_pass" 
                                           name="new_pass" 
                                           placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)"
                                           autocomplete="new-password">
                                </div>

                                <div class="form-group">
                                    <label for="confirm_pass">Xác Nhận Mật Khẩu Mới <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirm_pass" 
                                           name="confirm_pass" 
                                           placeholder="Nhập lại mật khẩu mới"
                                           autocomplete="new-password">
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-lock"></i> Đổi Mật Khẩu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
// Clear session errors AFTER displaying
if (isset($_SESSION['flash'])) {
    unset($_SESSION['error'], $_SESSION['old'], $_SESSION['flash']);
}
?>

