<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thống Kê Doanh Thu</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thẻ thống kê -->
            <div class="row">
                <!-- Tổng doanh thu -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4>Tổng Doanh Thu</h4>
                            <p><?= number_format($tongDoanhThu, 0, ',', '.') ?> VND</p>
                        </div>
                    </div>
                </div>

                <!-- Doanh thu tháng này -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4>Doanh Thu Tháng Này</h4>
                            <p><?= number_format($doanhThuThangHienTai, 0, ',', '.') ?> VND</p>
                        </div>
                    </div>
                </div>

                <!-- Tổng số booking -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4>Tổng Số Booking</h4>
                            <p><?= number_format($tongSoBooking, 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Booking mới tháng này -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4>Booking Mới Tháng Này</h4>
                            <p><?= number_format($bookingMoiThang, 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng top tour -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top 5 Tour Bán Chạy Nhất</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Tour</th>
                                        <th>Số Booking</th>
                                        <th>Tổng Doanh Thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($topTourBanChay)): ?>
                                        <?php $stt = 1; foreach ($topTourBanChay as $tour): ?>
                                            <tr>
                                                <td class="text-center"><?= $stt++ ?></td>
                                                <td><?= htmlspecialchars($tour['ten_tour']) ?></td>
                                                <td class="text-center"><?= number_format($tour['so_booking'], 0, ',', '.') ?></td>
                                                <td class="text-right"><?= number_format($tour['tong_doanh_thu'], 0, ',', '.') ?> VND</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Chưa có dữ liệu</td>
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
<!-- /.content-wrapper -->

<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
