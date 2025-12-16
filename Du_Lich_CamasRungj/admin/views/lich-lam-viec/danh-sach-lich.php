<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-alt"></i> Lịch Làm Việc Của Tôi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Lịch Làm Việc</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <?php if ($hdvInfo): ?>
                <!-- Thông tin HDV -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="mb-0">
                                            <i class="fas fa-user-tie text-primary"></i> 
                                            Xin chào, <strong><?= htmlspecialchars($hdvInfo['ho_ten'] ?? $_SESSION['user_admin']['ho_ten']) ?></strong>
                                        </h4>
                                        <p class="text-muted mb-0 mt-2">
                                            <i class="fas fa-envelope"></i> <?= htmlspecialchars($hdvInfo['email'] ?? $_SESSION['user_admin']['email']) ?>
                                            <?php if (!empty($hdvInfo['so_dien_thoai'])): ?>
                                                | <i class="fas fa-phone"></i> <?= htmlspecialchars($hdvInfo['so_dien_thoai']) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <span class="badge badge-info" style="font-size: 14px; padding: 8px 15px;">
                                            <i class="fas fa-calendar-check"></i> 
                                            <?= count($lichLamViec) ?> tour được phân công
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Danh sách lịch làm việc -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i> Danh Sách Lịch Được Phân Công
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (empty($lichLamViec)): ?>
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                                    <p class="mb-0">Hiện tại bạn chưa được phân công tour nào.</p>
                                </div>
                            <?php else: ?>
                                <table id="example1" class="table table-bordered table-hover table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="50" class="text-center">STT</th>
                                            <th>Tên Tour</th>
                                            <th width="150" class="text-center">Ngày Khởi Hành</th>
                                            <th width="150" class="text-center">Ngày Kết Thúc</th>
                                            <th width="120" class="text-center">Vai Trò</th>
                                            <th width="100" class="text-center">Trạng Thái</th>
                                            <th width="200" class="text-center">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($lichLamViec as $lich): 
                                            // Xác định trạng thái tour
                                            $now = time();
                                            $ngayBatDau = strtotime($lich['ngay_bat_dau']);
                                            $ngayKetThuc = strtotime($lich['ngay_ket_thuc']);
                                            
                                            if ($now < $ngayBatDau) {
                                                $trangThai = '<span class="badge badge-warning">Sắp diễn ra</span>';
                                            } elseif ($now >= $ngayBatDau && $now <= $ngayKetThuc) {
                                                $trangThai = '<span class="badge badge-success">Đang diễn ra</span>';
                                            } else {
                                                $trangThai = '<span class="badge badge-secondary">Đã kết thúc</span>';
                                            }
                                            
                                            // Vai trò badge
                                            $vaiTroBadge = $lich['vai_tro'] == 'truong_doan' 
                                                ? '<span class="badge badge-primary"><i class="fas fa-star"></i> Trưởng đoàn</span>' 
                                                : '<span class="badge badge-info"><i class="fas fa-user"></i> HDV phụ</span>';
                                        ?>
                                            <tr>
                                                <td class="text-center"><strong><?= $stt++ ?></strong></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($lich['ten_tour']) ?></strong>
                                                    <?php if (!empty($lich['so_booking'])): ?>
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="fas fa-users"></i> <?= $lich['so_booking'] ?> booking
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <i class="far fa-calendar"></i>
                                                    <?= date('d/m/Y', strtotime($lich['ngay_bat_dau'])) ?>
                                                </td>
                                                <td class="text-center">
                                                    <i class="far fa-calendar"></i>
                                                    <?= date('d/m/Y', strtotime($lich['ngay_ket_thuc'])) ?>
                                                </td>
                                                <td class="text-center"><?= $vaiTroBadge ?></td>
                                                <td class="text-center"><?= $trangThai ?></td>
                                                <td class="text-center">
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=hdv-chi-tiet-lich-lam-viec&lich_id=<?= $lich['lich_id'] ?>&tab=khach-hang" 
                                                       class="btn btn-sm btn-info"
                                                       title="Danh sách khách">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=hdv-chi-tiet-lich-lam-viec&lich_id=<?= $lich['lich_id'] ?>&tab=diem-danh" 
                                                       class="btn btn-sm btn-success"
                                                       title="Điểm danh">
                                                        <i class="fas fa-check-square"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=hdv-chi-tiet-lich-lam-viec&lich_id=<?= $lich['lich_id'] ?>&tab=nhat-ky" 
                                                       class="btn btn-sm btn-primary"
                                                       title="Nhật ký tour">
                                                        <i class="fas fa-book"></i>
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

<!-- DataTables Script -->
<script>
$(function () {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "language": {
            "search": "Tìm kiếm:",
            "lengthMenu": "Hiển thị _MENU_ dòng",
            "info": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ dòng",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(lọc từ _MAX_ dòng)",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Sau",
                "previous": "Trước"
            },
            "zeroRecords": "Không tìm thấy dữ liệu"
        },
        "order": [[2, "asc"]] // Sắp xếp theo ngày khởi hành
    });
});
</script>
