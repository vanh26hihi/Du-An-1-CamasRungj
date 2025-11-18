<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh Sách Hành Khách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Danh Sách Hành Khách</li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i> Danh Sách Hành Khách
                            </h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN . '?act=form-them-booking' ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-user-plus"></i> Thêm hành khách
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($data)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">STT</th>
                                            <th style="width: 25%;">Họ Tên</th>
                                            <th style="width: 20%;">CCCD</th>
                                            <th style="width: 20%;">Số Điện Thoại</th>
                                            <th style="width: 30%;">Ghi Chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($data as $row): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                            <td><strong><?php echo htmlspecialchars($row['ho_ten']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($row['cccd']); ?></td>
                                            <td><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>
                                            <td><?php echo htmlspecialchars($row['ghi_chu'] ?? ''); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i> Chưa có hành khách nào
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
