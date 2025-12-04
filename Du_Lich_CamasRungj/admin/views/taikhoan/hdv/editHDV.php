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
                    <h1>Sửa Tài Khoản Hướng Dẫn Viên</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?act=/">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="?act=danh-sach-hdv">Quản lý tài khoản HDV</a></li>
                        <li class="breadcrumb-item active">Sửa tài khoản HDV</li>
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
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Cập Nhật Thông Tin Hướng Dẫn Viên</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN . "?act=sua-hdv" ?>" method="POST" autocomplete="off">
                            <input type="hidden" name="nguoi_dung_id" value="<?= $hdv['nguoi_dung_id'] ?>">
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="ho_ten">Họ và Tên <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($error['ho_ten']) ? 'is-invalid' : '' ?>" 
                                           id="ho_ten" 
                                           name="ho_ten" 
                                           placeholder="Nhập họ và tên"
                                           autocomplete="off"
                                           value="<?= htmlspecialchars($old['ho_ten'] ?? $hdv['ho_ten']) ?>">
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
                                           value="<?= htmlspecialchars($old['email'] ?? $hdv['email']) ?>">
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
                                           value="<?= htmlspecialchars($old['so_dien_thoai'] ?? $hdv['so_dien_thoai']) ?>">
                                    <?php if (isset($error['so_dien_thoai'])): ?>
                                        <span class="error invalid-feedback"><?= $error['so_dien_thoai'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="trang_thai">Trạng Thái <span class="text-danger">*</span></label>
                                    <select class="form-control <?= isset($error['trang_thai']) ? 'is-invalid' : '' ?>" 
                                            id="trang_thai" 
                                            name="trang_thai">
                                        <option value="active" <?= ($old['trang_thai'] ?? $hdv['trang_thai']) === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                        <option value="inactive" <?= ($old['trang_thai'] ?? $hdv['trang_thai']) === 'inactive' ? 'selected' : '' ?>>Khóa</option>
                                    </select>
                                    <?php if (isset($error['trang_thai'])): ?>
                                        <span class="error invalid-feedback"><?= $error['trang_thai'] ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="alert alert-info">
                                    <i class="icon fas fa-info-circle"></i>
                                    <strong>Lưu ý:</strong> Để đổi mật khẩu, vui lòng sử dụng chức năng "Reset Mật Khẩu" ở danh sách tài khoản.
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Cập Nhật
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=danh-sach-hdv" ?>" class="btn btn-secondary">
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
