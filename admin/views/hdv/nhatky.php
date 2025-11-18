<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nhật Ký Tour</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Nhật Ký Tour</li>
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
                                <i class="fas fa-book"></i> Nhật Ký Tour
                            </h3>
                            <a href="<?= BASE_URL_ADMIN . "?act=hdv-form-them-nhat-ky&hdv_id=" . $_GET['hdv_id'] ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Thêm Nhật Ký
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($data)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">STT</th>
                                            <th style="width: 12%;">Ngày</th>
                                            <th style="width: 20%;">Tour</th>
                                            <th style="width: 15%;">Địa Điểm</th>
                                            <th style="width: 28%;">Nội Dung</th>
                                            <th style="width: 12%;">Ảnh</th>
                                            <th style="width: 8%;">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($data as $row): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['ngay_thuc_hien'])); ?></td>
                                            <td><strong><?php echo htmlspecialchars($row['tour']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($row['dia_diem']); ?></td>
                                            <td>
                                                <span title="<?php echo htmlspecialchars($row['noi_dung']); ?>">
                                                    <?php echo substr(htmlspecialchars($row['noi_dung']), 0, 50) . (strlen($row['noi_dung']) > 50 ? '...' : ''); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($row['anh_tour'])): ?>
                                                    <img src="<?php echo $row['anh_tour']; ?>" width="60" height="60" alt="Tour" class="img-thumbnail">
                                                <?php else: ?>
                                                    <span class="text-muted"><i class="fas fa-image"></i> Không có</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center" style="width:80px;">
                                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-form-sua-nhat-ky&nhat_ky_id=" . $row['nhat_ky_tour_id'] ?>" class="btn btn-sm btn-primary" title="Sửa"><i class="fas fa-edit"></i></a>
                                                &nbsp;
                                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-xoa-nhat-ky&nhat_ky_id=" . $row['nhat_ky_tour_id'] . "&hdv_id=" . ($_GET['hdv_id'] ?? '') ?>" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa nhật ký này?')"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i> Chưa có nhật ký tour nào
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
