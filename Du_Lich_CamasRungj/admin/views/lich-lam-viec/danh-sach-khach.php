<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-users"></i> Danh Sách Khách Hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Danh Sách Khách</li>
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
                        <div class="card card-info card-outline">
                            <div class="card-body">
                                <h4 class="mb-3">
                                    <i class="fas fa-map-marked-alt text-info"></i> 
                                    <strong><?= htmlspecialchars($lichInfo['ten_tour']) ?></strong>
                                </h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1">
                                            <i class="fas fa-calendar-check text-success"></i> 
                                            <strong>Khởi hành:</strong> <?= date('d/m/Y', strtotime($lichInfo['ngay_bat_dau'])) ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1">
                                            <i class="fas fa-calendar-times text-danger"></i> 
                                            <strong>Kết thúc:</strong> <?= date('d/m/Y', strtotime($lichInfo['ngay_ket_thuc'])) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Danh sách khách hàng -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i> Danh Sách Khách Hàng
                            </h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN ?>" class="btn btn-sm btn-light">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($danhSachKhach)): ?>
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <p class="mb-0">Chưa có khách hàng nào trong tour này.</p>
                                </div>
                            <?php else: ?>
                                <table id="tableKhach" class="table table-bordered table-hover table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="50" class="text-center">STT</th>
                                            <th>Họ Tên</th>
                                            <th width="100" class="text-center">Giới Tính</th>
                                            <th width="150">CCCD</th>
                                            <th width="130">Số Điện Thoại</th>
                                            <th width="200">Email</th>
                                            <th width="120" class="text-center">Ngày Sinh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($danhSachKhach as $khach): 
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
                                                <td><?= htmlspecialchars($khach['cccd'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($khach['so_dien_thoai'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($khach['email'] ?? 'N/A') ?></td>
                                                <td class="text-center">
                                                    <?= $khach['ngay_sinh'] ? date('d/m/Y', strtotime($khach['ngay_sinh'])) : 'N/A' ?>
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
    $("#tableKhach").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "language": {
            "search": "Tìm kiếm:",
            "info": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ khách",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(lọc từ _MAX_ khách)",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Sau",
                "previous": "Trước"
            },
            "zeroRecords": "Không tìm thấy khách hàng"
        }
    });
});
</script>
