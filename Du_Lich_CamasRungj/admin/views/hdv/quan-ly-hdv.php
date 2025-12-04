<?php
$hdv_id = $_GET['hdv_id'] ?? 'all';
$tab = $_GET['tab'] ?? 'thong-tin';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản Lý Hướng Dẫn Viên</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Quản Lý HDV</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- Danh sách HDV -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="card-title">Danh Sách Hướng Dẫn Viên</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($allHDV)): ?>
                                <div class="row">
                                    <?php foreach ($allHDV as $hdv): ?>
                                        <?php $isActive = $hdv_id == $hdv['hdv_id']; ?>
                                        <div class="col-md-3 mb-3">
                                            <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv['hdv_id'] . "&tab=thong-tin" ?>" 
                                               class="card <?= $isActive ? 'border-primary' : '' ?>" 
                                               style="text-decoration: none; cursor: pointer;">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="fas fa-user-tie"></i> <?= htmlspecialchars($hdv['ho_ten']) ?>
                                                    </h5>
                                                    <p class="card-text mb-1">
                                                        <small class="text-muted">
                                                            <i class="fas fa-phone"></i> <?= htmlspecialchars($hdv['so_dien_thoai']) ?>
                                                        </small>
                                                    </p>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <i class="fas fa-envelope"></i> <?= htmlspecialchars($hdv['email']) ?>
                                                        </small>
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Chưa có hướng dẫn viên nào
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin HDV được chọn -->
            <?php if ($hdv_id !== 'all' && $hdvInfo): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link <?= $tab == 'thong-tin' ? 'active' : '' ?>" 
                                           href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=thong-tin" ?>">
                                            <i class="fas fa-user"></i> Thông Tin Cá Nhân
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $tab == 'lich-lam-viec' ? 'active' : '' ?>" 
                                           href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=lich-lam-viec" ?>">
                                            <i class="fas fa-calendar-alt"></i> Lịch Làm Việc
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <!-- Tab Thông Tin Cá Nhân -->
                                <?php if ($tab == 'thong-tin'): ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Thông Tin Cá Nhân</h3>
                                            <div class="card-tools">
                                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-form-sua&hdv_id=" . $hdv_id ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-xoa&hdv_id=" . $hdv_id ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa hướng dẫn viên <?= htmlspecialchars($hdvInfo['ho_ten']) ?>?');">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Họ Tên</th>
                                                    <td><?= htmlspecialchars($hdvInfo['ho_ten']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Số Điện Thoại</th>
                                                    <td><?= htmlspecialchars($hdvInfo['so_dien_thoai']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td><?= htmlspecialchars($hdvInfo['email']) ?></td>
                                                </tr>
                                                <?php if (!empty($hdvInfo['kinh_nghiem'])): ?>
                                                <tr>
                                                    <th>Kinh Nghiệm</th>
                                                    <td><?= htmlspecialchars($hdvInfo['kinh_nghiem']) ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php if (!empty($hdvInfo['ngon_ngu'])): ?>
                                                <tr>
                                                    <th>Ngôn Ngữ</th>
                                                    <td><?= htmlspecialchars($hdvInfo['ngon_ngu']) ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Tab Lịch Làm Việc -->
                                <?php if ($tab == 'lich-lam-viec'): ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Lịch Làm Việc</h3>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($lichLamViec)): ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Tên Tour</th>
                                                                <th>Ngày Bắt Đầu</th>
                                                                <th>Ngày Kết Thúc</th>
                                                                <th>Vai Trò</th>
                                                                <th>Hành Động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $stt = 1; foreach ($lichLamViec as $lich): ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $stt++ ?></td>
                                                                    <td><?= htmlspecialchars($lich['ten_tour']) ?></td>
                                                                    <td><?= date('d/m/Y', strtotime($lich['ngay_bat_dau'])) ?></td>
                                                                    <td><?= date('d/m/Y', strtotime($lich['ngay_ket_thuc'])) ?></td>
                                                                    <td class="text-center">
                                                                        <span class="badge <?= $lich['vai_tro'] == 'main' ? 'badge-success' : 'badge-info' ?>">
                                                                            <?= $lich['vai_tro'] == 'main' ? 'Chính' : 'Hỗ Trợ' ?>
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich&lich_id=" . $lich['lich_id'] . "&hdv_id=" . $hdv_id . "&tab=khach-hang" ?>" 
                                                                           class="btn btn-sm btn-info mb-1" title="Thông Tin Khách Hàng">
                                                                            <i class="fas fa-users"></i> Khách Hàng
                                                                        </a>
                                                                        <br>
                                                                        <a href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich&lich_id=" . $lich['lich_id'] . "&hdv_id=" . $hdv_id . "&tab=diem-danh" ?>" 
                                                                           class="btn btn-sm btn-success mb-1" title="Điểm Danh">
                                                                            <i class="fas fa-check-circle"></i> Điểm Danh
                                                                        </a>
                                                                        <br>
                                                                        <a href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich&lich_id=" . $lich['lich_id'] . "&hdv_id=" . $hdv_id . "&tab=nhat-ky" ?>" 
                                                                           class="btn btn-sm btn-warning" title="Nhật Ký Tour">
                                                                            <i class="fas fa-book"></i> Nhật Ký
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php else: ?>
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> HDV này chưa có lịch làm việc nào
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($hdv_id !== 'all'): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Không tìm thấy thông tin hướng dẫn viên
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* CSS cho tab - đơn giản, dễ nhìn */
.nav-tabs {
    border-bottom: 2px solid #dee2e6;
    background-color: #f8f9fa;
}

.nav-tabs .nav-link {
    color: #495057;
    background-color: #e9ecef;
    border: 1px solid #dee2e6;
    border-bottom: none;
    padding: 10px 20px;
    margin-right: 5px;
}

.nav-tabs .nav-link:hover {
    background-color: #ffffff;
    color: #007bff;
}

.nav-tabs .nav-link.active {
    background-color: #ffffff;
    color: #007bff;
    border-bottom: 2px solid #ffffff;
    font-weight: bold;
}

/* Card HDV */
.card:hover {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.border-primary {
    border: 2px solid #007bff !important;
}
</style>

