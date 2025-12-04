<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-chart-line"></i> Báo Cáo Thống Kê</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Thẻ thống kê tổng quan -->
            <div class="row">
                <!-- Tổng Doanh Thu -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($tongDoanhThu, 0, ',', '.') ?></h3>
                            <p>Tổng Doanh Thu (VNĐ)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                </div>

                <!-- Doanh Thu Tháng Này -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= number_format($doanhThuThangHienTai, 0, ',', '.') ?></h3>
                            <p>Doanh Thu Tháng Này (VNĐ)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Tổng Số Booking -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= number_format($tongSoBooking, 0, ',', '.') ?></h3>
                            <p>Tổng Số Booking</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                </div>

                <!-- Booking Mới Tháng Này -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= number_format($bookingMoiThang, 0, ',', '.') ?></h3>
                            <p>Booking Mới Tháng Này</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng Top Tour Bán Chạy -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fas fa-trophy"></i> Top 5 Tour Bán Chạy Nhất</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="80" class="text-center">Hạng</th>
                                        <th>Tên Tour</th>
                                        <th width="150" class="text-center">Số Booking</th>
                                        <th width="200" class="text-right">Tổng Doanh Thu (VNĐ)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($topTourBanChay)): ?>
                                        <?php 
                                        $hang = 1;
                                        foreach ($topTourBanChay as $tour): 
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php if ($hang == 1): ?>
                                                        <span class="badge badge-warning" style="font-size: 16px;">
                                                            <i class="fas fa-trophy"></i> #<?= $hang ?>
                                                        </span>
                                                    <?php elseif ($hang == 2): ?>
                                                        <span class="badge badge-secondary" style="font-size: 16px;">
                                                            <i class="fas fa-medal"></i> #<?= $hang ?>
                                                        </span>
                                                    <?php elseif ($hang == 3): ?>
                                                        <span class="badge badge-info" style="font-size: 16px;">
                                                            <i class="fas fa-award"></i> #<?= $hang ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-light" style="font-size: 16px;">
                                                            #<?= $hang ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><strong><?= htmlspecialchars($tour['ten_tour']) ?></strong></td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary"><?= $tour['so_booking'] ?></span>
                                                </td>
                                                <td class="text-right">
                                                    <strong class="text-success">
                                                        <?= number_format($tour['tong_doanh_thu'], 0, ',', '.') ?>
                                                    </strong>
                                                </td>
                                            </tr>
                                        <?php 
                                        $hang++;
                                        endforeach; 
                                        ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> Chưa có dữ liệu thống kê
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
