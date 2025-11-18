<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lịch Làm Việc</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Lịch Làm Việc HDV</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-alt"></i> Lịch Làm Việc Của HDV
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($data)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">STT</th>
                                            <th style="width: 25%;">Tên Tour</th>
                                            <th style="width: 15%;">Ngày Bắt Đầu</th>
                                            <th style="width: 15%;">Ngày Kết Thúc</th>
                                            <th style="width: 15%;">Trạng Thái</th>
                                            <th style="width: 25%;">Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($data as $row): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                            <td><strong><?php echo htmlspecialchars($row['ten_tour']); ?></strong></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['ngay_bat_dau'])); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['ngay_ket_thuc'])); ?></td>
                                            <td class="text-center">
                                                <span class="badge <?php echo ($row['trang_thai'] == 'Đã hoàn thành' || $row['trang_thai'] == 'da_hoan_thanh') ? 'badge-success' : 'badge-warning'; ?>">
                                                    <?php echo $row['trang_thai']; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-danh-sach-khach&lich_id=" . $row['lich_id'] ?>" class="btn btn-sm btn-info" title="Danh sách hành khách">
                                                    <i class="fas fa-users"></i> Hành Khách
                                                </a>
                                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-diem-danh&lich_trinh_id=" . $row['lich_id'] . "&hdv_id=" . $_GET['hdv_id'] ?>" class="btn btn-sm btn-primary" title="Điểm danh">
                                                    <i class="fas fa-check-circle"></i> Điểm Danh
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i> Chưa có lịch làm việc nào
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
