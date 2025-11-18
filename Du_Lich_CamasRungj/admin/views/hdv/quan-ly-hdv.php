<?php
$tab = $_GET['tab'] ?? 'lich-lam-viec';
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
            <!-- Nav tabs -->
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'lich-lam-viec' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=lich-lam-viec" ?>" 
                               role="tab">
                                <i class="fas fa-calendar-alt"></i> Lịch Làm Việc
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'nhat-ky' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=nhat-ky" ?>" 
                               role="tab">
                                <i class="fas fa-book"></i> Nhật Ký Tour
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'yeu-cau-dac-biet' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=yeu-cau-dac-biet" ?>" 
                               role="tab">
                                <i class="fas fa-star"></i> Yêu Cầu Đặc Biệt
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'danh-gia' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=danh-gia" ?>" 
                               role="tab">
                                <i class="fas fa-comment"></i> Đánh Giá Tour
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <!-- Tab Lịch Làm Việc -->
                        <div class="tab-pane fade <?= $tab == 'lich-lam-viec' ? 'show active' : '' ?>" 
                             id="custom-tabs-three-lich-lam-viec" role="tabpanel">
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
                                            <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=lich-lam-viec&tour_id=" . $currentTourId ?>" 
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
                                                        <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $hdv_id . "&tab=lich-lam-viec" ?>" 
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
                                                                            <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=" . $firstHDVId . "&tab=yeu-cau-dac-biet&lich_id=" . $row['lich_id'] ?>" 
                                                                               class="btn btn-sm btn-warning" title="Yêu cầu đặc biệt">
                                                                                <i class="fas fa-star"></i> Yêu Cầu
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

                        <!-- Tab Nhật Ký Tour -->
                        <div class="tab-pane fade <?= $tab == 'nhat-ky' ? 'show active' : '' ?>" 
                             id="custom-tabs-three-nhat-ky" role="tabpanel">
                            <div class="card-header d-flex justify-content-between align-items-center mb-3">
                                <h3 class="card-title">
                                    <i class="fas fa-book"></i> Nhật Ký Tour
                                </h3>
                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-form-them-nhat-ky&hdv_id=" . $hdv_id ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Thêm Nhật Ký
                                </a>
                            </div>
                            <?php if (!empty($nhatKyData)): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">STT</th>
                                                <th style="width: 12%;">Ngày</th>
                                                <?php if ($hdv_id === 'all'): ?>
                                                <th style="width: 15%;">Hướng Dẫn Viên</th>
                                                <?php endif; ?>
                                                <th style="width: 18%;">Tour</th>
                                                <th style="width: 12%;">Địa Điểm</th>
                                                <th style="width: 25%;">Nội Dung</th>
                                                <th style="width: 10%;">Ảnh</th>
                                                <th style="width: 8%;">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $stt = 1;
                                            foreach ($nhatKyData as $row): 
                                            ?>
                                            <tr>
                                                <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                                <td><?php echo date('d/m/Y', strtotime($row['ngay_thuc_hien'])); ?></td>
                                                <?php if ($hdv_id === 'all'): ?>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <?= htmlspecialchars($row['hdv_ten'] ?? 'HDV #' . ($row['hdv_id'] ?? 'N/A')) ?>
                                                    </span>
                                                </td>
                                                <?php endif; ?>
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
                                                    <a href="<?= BASE_URL_ADMIN . "?act=hdv-xoa-nhat-ky&nhat_ky_id=" . $row['nhat_ky_tour_id'] . "&hdv_id=" . ($row['hdv_id'] ?? $hdv_id) ?>" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa nhật ký này?')"><i class="fas fa-trash"></i></a>
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

                        <!-- Tab Yêu Cầu Đặc Biệt -->
                        <div class="tab-pane fade <?= $tab == 'yeu-cau-dac-biet' ? 'show active' : '' ?>" 
                             id="custom-tabs-three-yeu-cau-dac-biet" role="tabpanel">
                            <?php if (!empty($yeuCauData)): ?>
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
                                            foreach ($yeuCauData as $row): 
                                            ?>
                                            <tr>
                                                <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                                <td><strong><?php echo htmlspecialchars($row['ho_ten']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($row['yeu_cau_dac_biet']); ?></td>
                                                <td class="text-center">
                                                    <a href="<?= BASE_URL_ADMIN . "?act=hdv-form-sua-yeu-cau&khach_hang_id=" . $row['hanh_khach_id'] . "&lich_id=" . ($lich_id ?? '') . "&hdv_id=" . $hdv_id ?>" class="btn btn-sm btn-warning">
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

                        <!-- Tab Đánh Giá Tour -->
                        <div class="tab-pane fade <?= $tab == 'danh-gia' ? 'show active' : '' ?>" 
                             id="custom-tabs-three-danh-gia" role="tabpanel">
                            <!-- Danh sách đánh giá đã gửi -->
                            <?php if (!empty($danhGiaData)): ?>
                                <div class="card card-info mb-4">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-list"></i> Danh Sách Đánh Giá Đã Gửi
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">STT</th>
                                                        <th style="width: 20%;">Tour</th>
                                                        <th style="width: 15%;">Ngày Khởi Hành</th>
                                                        <th style="width: 12%;">Điểm Đánh Giá</th>
                                                        <th style="width: 35%;">Phản Hồi</th>
                                                        <th style="width: 13%;">Ngày Gửi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $stt = 1;
                                                    foreach ($danhGiaData as $row): 
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><strong><?php echo $stt++; ?></strong></td>
                                                        <td><strong><?php echo htmlspecialchars($row['ten_tour'] ?? 'N/A'); ?></strong></td>
                                                        <td>
                                                            <?php if (!empty($row['ngay_bat_dau'])): ?>
                                                                <?php echo date('d/m/Y', strtotime($row['ngay_bat_dau'])); ?>
                                                            <?php else: ?>
                                                                N/A
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php 
                                                            $diem = $row['diem_danh_gia'] ?? 0;
                                                            $sao = str_repeat('⭐', $diem);
                                                            ?>
                                                            <span class="badge badge-warning" style="font-size: 1rem;">
                                                                <?php echo $sao; ?> <?php echo $diem; ?>/5
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span title="<?php echo htmlspecialchars($row['phan_hoi'] ?? ''); ?>">
                                                                <?php echo substr(htmlspecialchars($row['phan_hoi'] ?? ''), 0, 80) . (strlen($row['phan_hoi'] ?? '') > 80 ? '...' : ''); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo !empty($row['ngay_tao']) ? date('d/m/Y H:i', strtotime($row['ngay_tao'])) : 'N/A'; ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Form gửi đánh giá mới -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-star"></i> Gửi Đánh Giá Về Tour
                                            </h3>
                                        </div>
                                        <form action="<?= BASE_URL_ADMIN . '?act=hdv-gui-danh-gia' ?>" method="POST">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="danh_gia_hdv_id">Chọn Hướng Dẫn Viên <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="danh_gia_hdv_id" name="hdv_id" required>
                                                        <option value="">-- Chọn Hướng Dẫn Viên --</option>
                                                        <?php if (!empty($allHDV)): ?>
                                                            <?php foreach ($allHDV as $hdv): ?>
                                                                <option value="<?= $hdv['hdv_id'] ?>" <?= ($hdv_id !== 'all' && $hdv_id == $hdv['hdv_id']) ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($hdv['ho_ten']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="danh_gia_lich_id">Chọn Lịch Khởi Hành <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="danh_gia_lich_id" name="lich_id" required>
                                                        <option value="">-- Chọn Hướng Dẫn Viên trước --</option>
                                                    </select>
                                                    <small class="form-text text-muted">Vui lòng chọn Hướng Dẫn Viên để xem danh sách lịch</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="danh_gia_tour_id">Tour <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="danh_gia_tour_id" name="tour_id" required>
                                                        <option value="">-- Chọn Hướng Dẫn Viên trước --</option>
                                                    </select>
                                                    <small class="form-text text-muted">Tour sẽ tự động được chọn khi bạn chọn lịch</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="diem_danh_gia">Đánh Giá Chung (1-5 sao) <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="diem_danh_gia" name="diem_danh_gia" required>
                                                        <option value="">-- Chọn Điểm --</option>
                                                        <option value="5">⭐⭐⭐⭐⭐ 5 Sao - Xuất Sắc</option>
                                                        <option value="4">⭐⭐⭐⭐ 4 Sao - Tốt</option>
                                                        <option value="3">⭐⭐⭐ 3 Sao - Bình Thường</option>
                                                        <option value="2">⭐⭐ 2 Sao - Cần Cải Thiện</option>
                                                        <option value="1">⭐ 1 Sao - Kém</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="phan_hoi">Phản Hồi Chi Tiết <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="phan_hoi" name="phan_hoi" rows="6" placeholder="Ghi lại ý kiến về:&#10;- Chất lượng dịch vụ&#10;- Khách sạn, nhà hàng&#10;- Xe vận chuyển&#10;- Hướng dẫn&#10;- Các vấn đề phát sinh..." required></textarea>
                                                </div>

                                            </div>

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-paper-plane"></i> Gửi Đánh Giá
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-comment"></i> Hướng Dẫn Đánh Giá
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Vui lòng đánh giá về:</strong></p>
                                            <ul>
                                                <li><strong>Dịch vụ:</strong> Chất lượng hướng dẫn, phục vụ</li>
                                                <li><strong>Khách sạn:</strong> Sạch sẽ, tiện nghi, phục vụ</li>
                                                <li><strong>Ăn uống:</strong> Chất lượng, vệ sinh, phong cách</li>
                                                <li><strong>Xe:</strong> Điều kiện, hành xử tài xế</li>
                                                <li><strong>Sự cố:</strong> Ghi rõ vấn đề để cải thiện</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-sync tour_id when lich_id changes
document.addEventListener('DOMContentLoaded', function() {
    const tourSelect = document.getElementById('tour_id');
    const lichSelect = document.getElementById('lich_id');
    
    if (lichSelect && tourSelect) {
        lichSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const tourId = selectedOption.getAttribute('data-tour-id');
            if (tourId) {
                tourSelect.value = tourId;
            }
        });
    }
});
</script>

<style>
.card-tabs .nav-tabs {
    border-bottom: 2px solid #dee2e6;
    background-color: #ffffff;
    padding: 0;
}

.card-tabs .nav-tabs .nav-link {
    border: none;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    color: #6c757d;
    font-weight: 500;
    padding: 0.875rem 1.5rem;
    margin-right: 0.25rem;
    transition: all 0.2s ease;
    background-color: transparent;
    border-bottom: 3px solid transparent;
}

.card-tabs .nav-tabs .nav-link:hover {
    color: #495057;
    background-color: #f8f9fa;
    border-bottom-color: #adb5bd;
}

.card-tabs .nav-tabs .nav-link.active {
    color: #007bff;
    background-color: #ffffff;
    border-bottom: 3px solid #007bff;
    font-weight: 600;
    position: relative;
}

.card-tabs .nav-tabs .nav-link.active::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
}

.card-tabs .nav-tabs .nav-link i {
    margin-right: 8px;
    font-size: 1.05rem;
    opacity: 0.8;
}

.card-tabs .nav-tabs .nav-link.active i {
    opacity: 1;
    color: #007bff;
}

.text-danger {
    color: #dc3545;
}

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

/* Sửa nút không bị xuống dòng */
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

<script>
// Load lịch khi chọn HDV trong form đánh giá
document.addEventListener('DOMContentLoaded', function() {
    const danhGiaHDVSelect = document.getElementById('danh_gia_hdv_id');
    const danhGiaLichSelect = document.getElementById('danh_gia_lich_id');
    const danhGiaTourSelect = document.getElementById('danh_gia_tour_id');
    
    console.log('Danh gia elements:', {
        hdv: danhGiaHDVSelect,
        lich: danhGiaLichSelect,
        tour: danhGiaTourSelect
    });
    
    if (danhGiaHDVSelect && danhGiaLichSelect && danhGiaTourSelect) {
        danhGiaHDVSelect.addEventListener('change', function() {
            const hdvId = this.value;
            console.log('HDV selected:', hdvId);
            
            // Clear lịch và tour khi chọn HDV mới
            danhGiaLichSelect.innerHTML = '<option value="">-- Chọn Lịch --</option>';
            danhGiaTourSelect.innerHTML = '<option value="">-- Chọn Tour --</option>';
            
            if (!hdvId) {
                return;
            }
            
            // Show loading
            const loadingOption = document.createElement('option');
            loadingOption.value = '';
            loadingOption.textContent = 'Đang tải...';
            loadingOption.disabled = true;
            danhGiaLichSelect.appendChild(loadingOption);
            
            // Load lịch của HDV qua AJAX
            const url = '<?= BASE_URL_ADMIN ?>?act=hdv-get-tours&hdv_id=' + hdvId;
            console.log('Fetching URL:', url);
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    // Clear loading
                    danhGiaLichSelect.innerHTML = '<option value="">-- Chọn Lịch --</option>';
                    danhGiaTourSelect.innerHTML = '<option value="">-- Chọn Tour --</option>';
                    
                    // Update lịch dropdown
                    if (data && data.tours && Array.isArray(data.tours) && data.tours.length > 0) {
                        console.log('Found', data.tours.length, 'tours');
                        const uniqueTours = {};
                        
                        data.tours.forEach(tour => {
                            console.log('Processing tour:', tour);
                            // Thêm vào dropdown lịch
                            const lichOption = document.createElement('option');
                            lichOption.value = tour.lich_id;
                            lichOption.setAttribute('data-tour-id', tour.tour_id);
                            
                            // Format date
                            let dateStr = '';
                            if (tour.ngay_bat_dau) {
                                try {
                                    const date = new Date(tour.ngay_bat_dau);
                                    dateStr = date.toLocaleDateString('vi-VN');
                                } catch(e) {
                                    dateStr = tour.ngay_bat_dau;
                                }
                            }
                            
                            lichOption.textContent = (tour.ten_tour || 'Tour') + (dateStr ? ' - ' + dateStr : '');
                            danhGiaLichSelect.appendChild(lichOption);
                            
                            // Thêm vào dropdown tour (unique)
                            if (tour.tour_id && !uniqueTours[tour.tour_id]) {
                                uniqueTours[tour.tour_id] = tour.ten_tour || 'Tour';
                                const tourOption = document.createElement('option');
                                tourOption.value = tour.tour_id;
                                tourOption.textContent = tour.ten_tour || 'Tour';
                                danhGiaTourSelect.appendChild(tourOption);
                            }
                        });
                    } else {
                        console.log('No tours found or empty data');
                        // Hiển thị thông báo nếu không có lịch
                        const noDataOption = document.createElement('option');
                        noDataOption.value = '';
                        noDataOption.textContent = '-- Không có lịch nào --';
                        noDataOption.disabled = true;
                        danhGiaLichSelect.appendChild(noDataOption);
                    }
                })
                .catch(error => {
                    console.error('Error loading tours:', error);
                    alert('Có lỗi xảy ra khi tải danh sách lịch. Vui lòng thử lại.');
                });
        });
    }
    
    // Auto-sync tour_id when lich_id changes
    if (danhGiaLichSelect && danhGiaTourSelect) {
        danhGiaLichSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const tourId = selectedOption.getAttribute('data-tour-id');
            if (tourId) {
                danhGiaTourSelect.value = tourId;
            }
        });
    }
});
</script>

