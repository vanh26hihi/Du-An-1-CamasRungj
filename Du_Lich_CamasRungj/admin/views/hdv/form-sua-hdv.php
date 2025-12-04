<?php
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

$old_ho_ten = $hdvInfo['ho_ten'] ?? '';
$old_so_dien_thoai = $hdvInfo['so_dien_thoai'] ?? '';
$old_email = $hdvInfo['email'] ?? '';
$old_kinh_nghiem = $hdvInfo['kinh_nghiem'] ?? '';
$old_ngon_ngu = $hdvInfo['ngon_ngu'] ?? '';

if (isset($_SESSION['old'])) {
    $old_ho_ten = $_SESSION['old']['ho_ten'] ?? $old_ho_ten;
    $old_so_dien_thoai = $_SESSION['old']['so_dien_thoai'] ?? $old_so_dien_thoai;
    $old_email = $_SESSION['old']['email'] ?? $old_email;
    $old_kinh_nghiem = $_SESSION['old']['kinh_nghiem'] ?? $old_kinh_nghiem;
    $old_ngon_ngu = $_SESSION['old']['ngon_ngu'] ?? $old_ngon_ngu;
    unset($_SESSION['old']);
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sửa Hướng Dẫn Viên</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=all" ?>">Quản Lý HDV</a></li>
                        <li class="breadcrumb-item active">Sửa HDV</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông Tin Hướng Dẫn Viên</h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=hdv-sua&hdv_id=' . $hdvInfo['hdv_id'] ?>" method="POST">
                            <div class="card-body">
                                <?php if ($error): ?>
                                    <div class="alert alert-danger">
                                        <?= htmlspecialchars($error) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label>Họ Tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ho_ten" 
                                           value="<?= htmlspecialchars($old_ho_ten) ?>" 
                                           placeholder="Nhập họ tên" required>
                                </div>

                                <div class="form-group">
                                    <label>Số Điện Thoại</label>
                                    <input type="text" class="form-control" name="so_dien_thoai" 
                                           value="<?= htmlspecialchars($old_so_dien_thoai) ?>" 
                                           placeholder="Nhập số điện thoại">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="<?= htmlspecialchars($old_email) ?>" 
                                           placeholder="Nhập email">
                                </div>

                                <div class="form-group">
                                    <label>Kinh Nghiệm</label>
                                    <textarea class="form-control" name="kinh_nghiem" rows="3" 
                                              placeholder="Nhập kinh nghiệm"><?= htmlspecialchars($old_kinh_nghiem) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Ngôn Ngữ</label>
                                    <input type="text" class="form-control" name="ngon_ngu" 
                                           value="<?= htmlspecialchars($old_ngon_ngu) ?>" 
                                           placeholder="Ví dụ: Việt, Anh, Thái">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdvInfo['hdv_id'] ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>