<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-book"></i> Nhật Ký Tour</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Nhật Ký Tour</li>
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
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <h4 class="mb-3">
                                    <i class="fas fa-map-marked-alt text-primary"></i> 
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

            <!-- Form thêm nhật ký -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-plus"></i> Thêm Nhật Ký Mới
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $error = $_SESSION['error'] ?? [];
                            $old = $_SESSION['old'] ?? [];
                            unset($_SESSION['error'], $_SESSION['old'], $_SESSION['flash']);
                            ?>
                            
                            <form action="<?= BASE_URL_ADMIN ?>?act=hdv-them-nhat-ky-tour" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="lich_id" value="<?= $lichInfo['lich_id'] ?>">
                                <input type="hidden" name="tour_id" value="<?= $lichInfo['tour_id'] ?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Địa Điểm <span class="text-danger">*</span></label>
                                            <select name="dia_diem_id" 
                                                    class="form-control <?= isset($error['dia_diem_id']) ? 'is-invalid' : '' ?>" 
                                                    required>
                                                <option value="">-- Chọn địa điểm --</option>
                                                <?php
                                                // Lấy danh sách địa điểm của tour
                                                $sqlDiaDiem = "SELECT dd.dia_diem_id, dd.ten_dia_diem 
                                                              FROM dia_diem dd
                                                              JOIN lich_trinh lt ON dd.dia_diem_id = lt.dia_diem_id
                                                              WHERE lt.tour_id = ?
                                                              GROUP BY dd.dia_diem_id
                                                              ORDER BY dd.ten_dia_diem";
                                                $diaDiemList = db_query($sqlDiaDiem, [$lichInfo['tour_id']])->fetchAll();
                                                foreach ($diaDiemList as $dd):
                                                ?>
                                                    <option value="<?= $dd['dia_diem_id'] ?>" 
                                                            <?= (isset($old['dia_diem_id']) && $old['dia_diem_id'] == $dd['dia_diem_id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($dd['ten_dia_diem']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (isset($error['dia_diem_id'])): ?>
                                                <small class="text-danger"><?= $error['dia_diem_id'] ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ngày Ghi</label>
                                            <input type="date" 
                                                   name="ngay_thuc_hien" 
                                                   class="form-control" 
                                                   value="<?= $old['ngay_thuc_hien'] ?? date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Mô Tả <span class="text-danger">*</span></label>
                                    <textarea name="noi_dung" 
                                              rows="4" 
                                              class="form-control <?= isset($error['noi_dung']) ? 'is-invalid' : '' ?>" 
                                              placeholder="Ghi chú về hoạt động, tình hình khách hàng, vấn đề phát sinh..."
                                              required><?= $old['noi_dung'] ?? '' ?></textarea>
                                    <?php if (isset($error['noi_dung'])): ?>
                                        <small class="text-danger"><?= $error['noi_dung'] ?></small>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Lưu Nhật Ký
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách nhật ký -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i> Danh Sách Nhật Ký
                            </h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN ?>" class="btn btn-sm btn-light">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($nhatKyList)): ?>
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                                    <p class="mb-0">Chưa có nhật ký nào. Hãy thêm nhật ký đầu tiên!</p>
                                </div>
                            <?php else: ?>
                                <div class="timeline">
                                    <?php foreach ($nhatKyList as $nhatKy): ?>
                                        <div>
                                            <i class="fas fa-map-marker-alt bg-primary"></i>
                                            <div class="timeline-item">
                                                <span class="time">
                                                    <i class="fas fa-clock"></i> 
                                                    <?= date('d/m/Y H:i', strtotime($nhatKy['ngay_thuc_hien'])) ?>
                                                </span>
                                                <h3 class="timeline-header">
                                                    <strong><?= htmlspecialchars($nhatKy['ten_dia_diem']) ?></strong>
                                                </h3>
                                                <div class="timeline-body">
                                                    <?= nl2br(htmlspecialchars($nhatKy['noi_dung'])) ?>
                                                </div>
                                                <div class="timeline-footer">
                                                    <small class="text-muted">
                                                        <i class="fas fa-user"></i> 
                                                        Ghi bởi: <?= htmlspecialchars($nhatKy['nguoi_tao_ten'] ?? 'HDV') ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div>
                                        <i class="fas fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<style>
.timeline {
    position: relative;
    margin: 0 0 30px 0;
    padding: 0;
    list-style: none;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #ddd;
    left: 31px;
    margin: 0;
    border-radius: 2px;
}

.timeline > div {
    position: relative;
    margin-right: 10px;
    margin-bottom: 15px;
}

.timeline > div > .timeline-item {
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    border-radius: 3px;
    margin-top: 0;
    background: #fff;
    color: #444;
    margin-left: 60px;
    margin-right: 15px;
    padding: 0;
    position: relative;
}

.timeline > div > .fa,
.timeline > div > .fas,
.timeline > div > .far,
.timeline > div > .fab,
.timeline > div > .fal,
.timeline > div > .fad,
.timeline > div > .svg-inline--fa,
.timeline > div > .ion {
    width: 30px;
    height: 30px;
    font-size: 15px;
    line-height: 30px;
    position: absolute;
    color: #fff;
    background: #999;
    border-radius: 50%;
    text-align: center;
    left: 18px;
    top: 0;
}

.timeline > div > .timeline-item > .time {
    color: #999;
    float: right;
    padding: 10px;
    font-size: 12px;
}

.timeline > div > .timeline-item > .timeline-header {
    margin: 0;
    color: #555;
    border-bottom: 1px solid #f4f4f4;
    padding: 10px;
    font-size: 16px;
    line-height: 1.1;
}

.timeline > div > .timeline-item > .timeline-body,
.timeline > div > .timeline-item > .timeline-footer {
    padding: 10px;
}
</style>
