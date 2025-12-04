<?php
require_once './models/AdminBaoCaoThongKe.php';

class AdminBaoCaoThongKeController
{
    public $model;

    public function __construct()
    {
        $this->model = new AdminBaoCaoThongKe();
    }

    public function home()
    {
        // Lấy dữ liệu thống kê cơ bản
        $tongDoanhThu = $this->model->getTongDoanhThu();
        $doanhThuThangHienTai = $this->model->getDoanhThuThangHienTai();
        $tongSoBooking = $this->model->getTongSoBooking();
        $bookingMoiThang = $this->model->getBookingMoiThangHienTai();
        $topTourBanChay = $this->model->getTopTourBanChay(5);
        
        require_once './views/home.php';
    }
}

