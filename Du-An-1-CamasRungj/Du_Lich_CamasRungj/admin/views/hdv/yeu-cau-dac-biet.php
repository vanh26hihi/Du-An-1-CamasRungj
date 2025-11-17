<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Yêu Cầu Đặc Biệt Của Khách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Yêu Cầu Đặc Biệt</li>
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
                                <i class="fas fa-star"></i> Yêu Cầu Đặc Biệt Của Khách Hàng
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($data)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">STT</th>
                                            <th style="width: 25%;">Tên Khách</th>
                                            <th style="width: 50%;">Yêu Cầu Đặc Biệt</th>
                                            <th style="width: 20%;">Hành Động</th>
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
                                            <td><?php echo htmlspecialchars($row['yeu_cau_dac_biet']); ?></td>
                                            <td class="text-center">
                                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-form-sua-yeu-cau&khach_hang_id=" . $row['hanh_khach_id'] ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Cập Nhật
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i> Không có yêu cầu đặc biệt nào
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
