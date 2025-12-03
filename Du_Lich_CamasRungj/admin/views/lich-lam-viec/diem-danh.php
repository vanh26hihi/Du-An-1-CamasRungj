<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-check-square"></i> Điểm Danh Khách Hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Điểm Danh</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Thông tin tour -->
            <?php if ($lichInfo): ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card card-success card-outline">
                            <div class="card-body">
                                <h4 class="mb-3">
                                    <i class="fas fa-map-marked-alt text-success"></i> 
                                    <strong><?= htmlspecialchars($lichInfo['ten_tour']) ?></strong>
                                </h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="mb-1">
                                            <i class="fas fa-calendar-check"></i> 
                                            <strong>Khởi hành:</strong> <?= date('d/m/Y', strtotime($lichInfo['ngay_bat_dau'])) ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">
                                            <i class="fas fa-calendar-times"></i> 
                                            <strong>Kết thúc:</strong> <?= date('d/m/Y', strtotime($lichInfo['ngay_ket_thuc'])) ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <?php 
                                        $tongKhach = count($danhSachDiemDanh);
                                        $daCoMat = 0;
                                        foreach ($danhSachDiemDanh as $khach) {
                                            if ($khach['trang_thai_diem_danh'] == 'co_mat') {
                                                $daCoMat++;
                                            }
                                        }
                                        ?>
                                        <p class="mb-1">
                                            <i class="fas fa-users"></i> 
                                            <strong>Điểm danh:</strong> 
                                            <span class="badge badge-success"><?= $daCoMat ?></span> / 
                                            <span class="badge badge-secondary"><?= $tongKhach ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Danh sách điểm danh -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h3 class="card-title">
                                <i class="fas fa-list-check"></i> Danh Sách Điểm Danh
                            </h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN ?>" class="btn btn-sm btn-light">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($danhSachDiemDanh)): ?>
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <p class="mb-0">Chưa có khách hàng nào để điểm danh.</p>
                                </div>
                            <?php else: ?>
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="50" class="text-center">STT</th>
                                            <th>Họ Tên</th>
                                            <th width="100" class="text-center">Giới Tính</th>
                                            <th width="130">Số Điện Thoại</th>
                                            <th width="150" class="text-center">Trạng Thái</th>
                                            <th width="120" class="text-center">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($danhSachDiemDanh as $khach): 
                                            $coMat = $khach['trang_thai_diem_danh'] == 'co_mat';
                                            $badgeClass = $coMat ? 'badge-success' : 'badge-secondary';
                                            $badgeText = $coMat ? 'Có mặt' : 'Chưa điểm danh';
                                            $badgeIcon = $coMat ? 'fa-check-circle' : 'fa-times-circle';
                                        ?>
                                            <tr>
                                                <td class="text-center"><strong><?= $stt++ ?></strong></td>
                                                <td><strong><?= htmlspecialchars($khach['ho_ten']) ?></strong></td>
                                                <td class="text-center">
                                                    <?php if ($khach['gioi_tinh'] == 'Nam'): ?>
                                                        <i class="fas fa-male text-primary"></i> Nam
                                                    <?php else: ?>
                                                        <i class="fas fa-female text-danger"></i> Nữ
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($khach['so_dien_thoai'] ?? 'N/A') ?></td>
                                                <td class="text-center">
                                                    <span class="badge <?= $badgeClass ?>">
                                                        <i class="fas <?= $badgeIcon ?>"></i> <?= $badgeText ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=hdv-xu-ly-diem-danh&hanh_khach_id=<?= $khach['hanh_khach_id'] ?>&lich_id=<?= $lichInfo['lich_id'] ?>" 
                                                       class="btn btn-sm <?= $coMat ? 'btn-warning' : 'btn-success' ?>"
                                                       title="<?= $coMat ? 'Hủy điểm danh' : 'Điểm danh' ?>">
                                                        <i class="fas <?= $coMat ? 'fa-undo' : 'fa-check' ?>"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
