<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Điểm Danh Hành Khách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Điểm Danh</li>
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
                                <i class="fas fa-check-circle"></i> Điểm Danh Hành Khách
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($data)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">STT</th>
                                            <th style="width: 25%;">Tên Hành Khách</th>
                                            <th style="width: 15%;">Địa Điểm</th>
                                            <th style="width: 12%;">Đã Đến</th>
                                            <th style="width: 18%;">Thời Gian</th>
                                            <th style="width: 25%;">Ghi Chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stt = 1;
                                        foreach ($data as $item): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                            <td><strong><?php echo htmlspecialchars($item['ho_ten']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($item['dia_diem_id'] ?? 'N/A'); ?></td>
                                            <td class="text-center">
                                                <span class="badge <?php echo $item['da_den'] ? 'badge-success' : 'badge-danger'; ?>">
                                                    <?php echo $item['da_den'] ? '<i class="fas fa-check"></i> Có mặt' : '<i class="fas fa-times"></i> Vắng'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo !empty($item['thoi_gian']) ? date('d/m/Y H:i', strtotime($item['thoi_gian'])) : 'Chưa có'; ?></td>
                                            <td><?php echo htmlspecialchars($item['ghi_chu'] ?? ''); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i> Chưa có dữ liệu điểm danh
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
