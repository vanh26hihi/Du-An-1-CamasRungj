<?php
$hdv_id = $_GET['hdv_id'] ?? 'all';
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
            <div class="card card-primary">
                <div class="card-body">
                            <?php 
                            $selectedTourId = $_GET['tour_id'] ?? null;
                            ?>
                            <?php if (!empty($lichLamViecData)): ?>
                                <!-- Danh sách Tour -->
                                <div class="row mb-3">
                                    <?php foreach ($lichLamViecData as $tourKey => $tourData): ?>
                                        <?php 
                                        $currentTourId = $tourData['tour_id'] ?? $tourKey;
                                        $ten_tour = $tourData['ten_tour'] ?? 'Tour';
                                        $schedules = $tourData['schedules'] ?? [];
                                        $isActive = $selectedTourId == $currentTourId;
                                        ?>
                                        <div class="col-md-4 mb-3">
                                            <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tour_id=" . $currentTourId ?>" 
                                               class="card card-info card-hover <?= $isActive ? 'border-primary' : '' ?>" 
                                               style="text-decoration: none; cursor: pointer;">
                                                <div class="card-header">
                                                    <h3 class="card-title mb-0">
                                                        <i class="fas fa-map-marked-alt"></i> <?= htmlspecialchars($ten_tour) ?>
                                                        <span class="badge badge-light ml-2"><?= count($schedules) ?> lịch</span>
                                                    </h3>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Danh sách Lịch của Tour được chọn -->
                                <?php if ($selectedTourId): ?>
                                    <?php 
                                    $selectedTours = null;
                                    $selectedTourName = '';
                                    foreach ($lichLamViecData as $tourKey => $tourData) {
                                        $currentTourId = $tourData['tour_id'] ?? $tourKey;
                                        if ($currentTourId == $selectedTourId) {
                                            $selectedTours = $tourData['schedules'] ?? [];
                                            $selectedTourName = $tourData['ten_tour'] ?? 'Tour';
                                            break;
                                        }
                                    }
                                    ?>
                                    <?php if ($selectedTours !== null): ?>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <h3 class="card-title mb-0">
                                                            <i class="fas fa-list"></i> Danh Sách Lịch: <?= htmlspecialchars($selectedTourName) ?>
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id ?>" 
                                                           class="btn btn-sm btn-secondary">
                                                            <i class="fas fa-arrow-left"></i> Quay lại
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <?php if (!empty($selectedTours)): ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-hover table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 5%;">STT</th>
                                                                    <th style="width: 15%;">Ngày Bắt Đầu</th>
                                                                    <th style="width: 15%;">Ngày Kết Thúc</th>
                                                                    <th style="width: 15%;">Hướng Dẫn Viên</th>
                                                                    <th style="width: 10%;">Trạng Thái</th>
                                                                    <th style="width: 40%;">Hành Động</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $stt = 1;
                                                                foreach ($selectedTours as $row): 
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($row['ngay_bat_dau'])); ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($row['ngay_ket_thuc'])); ?></td>
                                                                    <td>
                                                                        <?php 
                                                                        // Lấy danh sách HDV được phân công cho lịch này
                                                                        $hdvList = HDVModel::getHDVByLich($row['lich_id']);
                                                                        if (!empty($hdvList)): 
                                                                            foreach ($hdvList as $index => $hdvItem): 
                                                                                if ($index > 0) echo ', ';
                                                                        ?>
                                                                            <span class="badge badge-info">
                                                                                <?= htmlspecialchars($hdvItem['ho_ten']) ?>
                                                                            </span>
                                                                        <?php 
                                                                            endforeach;
                                                                        else: 
                                                                        ?>
                                                                            <span class="text-muted">Chưa phân công</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="badge <?php echo ($row['trang_thai'] == 'Đã hoàn thành' || $row['trang_thai'] == 'da_hoan_thanh') ? 'badge-success' : 'badge-warning'; ?>">
                                                                            <?php echo $row['trang_thai']; ?>
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php 
                                                                        $firstHDVId = !empty($hdvList) ? $hdvList[0]['hdv_id'] : ($hdv_id !== 'all' ? $hdv_id : null);
                                                                        if ($firstHDVId): 
                                                                        ?>
                                                                            <a href="<?= BASE_URL_ADMIN . "?act=hdv-diem-danh&lich_id=" . $row['lich_id'] . "&hdv_id=" . $firstHDVId ?>" 
                                                                               class="btn btn-sm btn-primary" title="Danh sách hành khách & Điểm danh">
                                                                                <i class="fas fa-users"></i> Hành Khách & Điểm Danh
                                                                            </a>
                                                                        <?php else: ?>
                                                                            <span class="text-muted">Chưa có HDV</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="alert alert-info" role="alert">
                                                        <i class="fas fa-info-circle"></i> Tour này chưa có lịch khởi hành.
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-info" role="alert">
                                        <i class="fas fa-info-circle"></i> Vui lòng chọn một tour để xem danh sách lịch làm việc.
                                    </div>
                                <?php endif; ?>
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

<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.card-hover.border-primary {
    border-width: 2px !important;
}

.table td .btn {
    white-space: nowrap !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
    line-height: 1.5;
    min-width: fit-content;
    width: auto;
}

.table td {
    white-space: nowrap;
    overflow: visible;
}

.table td:last-child {
    white-space: nowrap !important;
    text-align: center;
}

.table {
    table-layout: auto;
    width: 100%;
}
</style>
