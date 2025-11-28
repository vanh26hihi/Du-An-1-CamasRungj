<?php
require_once '../commons/env.php';
require_once '../commons/function.php';

$conn = connectDB();

require_once './controllers/AdminBookingController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/HDVController.php';
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminTourController.php';
require_once './controllers/AdminTaiKhoanController.php';

require_once './models/AdminBooking.php';
require_once './models/AdminTour.php';

$act = $_GET['act'] ?? '/';

$publicRoutes = ['login-admin', 'check-login-admin', 'logout-admin'];

match ($act) {
    '/' => (new AdminBaoCaoThongKeController())->home(),

    'booking' => (new AdminBookingController())->danhSachBooking(),
    'form-them-booking' => (new AdminBookingController())->formAddBooking(),
    'them-booking' => (new AdminBookingController())->postAddBooking(),
    'form-sua-booking' => (new AdminBookingController())->formEditBooking(),
    'sua-booking' => (new AdminBookingController())->postEditBooking(),
    'xoa-booking' => (new AdminBookingController())->deleteBooking(),

    'hdv-quan-ly' => HDVController::quanLyHDV($_GET['hdv_id'] ?? 'all'),
    'hdv-form-them' => HDVController::formAddHDV(),
    'hdv-them' => HDVController::postAddHDV(),
    'hdv-get-tours' => HDVController::getToursByHDVAjax($_GET['hdv_id'] ?? null),
    'hdv-danh-sach-khach' => HDVController::danhSachKhach($_GET['lich_id'] ?? null),
    'hdv-diem-danh' => HDVController::diemDanh($_GET['lich_id'] ?? null, $_GET['hdv_id'] ?? null),
    'hdv-diem-danh-action' => HDVController::diemDanhAction($_GET['hanh_khach_id'] ?? null, $_GET['lich_id'] ?? null, $_GET['hdv_id'] ?? null),

    'list-tai-khoan-quan-tri' => (new AdminTaiKhoanController())->danhSachQuanTri(),
    'form-them-quan-tri' => (new AdminTaiKhoanController())->formAddQuanTri(),
    'them-quan-tri' => (new AdminTaiKhoanController())->postAddQuanTri(),
    'form-sua-quan-tri' => (new AdminTaiKhoanController())->formEditQuanTri(),
    'sua-quan-tri' => (new AdminTaiKhoanController())->postEditQuanTri(),
    'reset-password' => (new AdminTaiKhoanController())->resetPassword(),

    'list-tai-khoan-khach-hang' => (new AdminTaiKhoanController())->danhSachKhachHang(),
    'form-sua-khach-hang' => (new AdminTaiKhoanController())->formEditKhachHang(),
    'sua-khach-hang' => (new AdminTaiKhoanController())->postEditKhachHang(),
    'chi-tiet-khach-hang' => (new AdminTaiKhoanController())->detailKhachHang(),

    'form-sua-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->formEditCaNhanQuanTri(),
    'post-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->postEditCaNhanQuanTri(),

    'sua-mat-khau-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->postEditMatKhauCaNhanQuanTri(),

    'login-admin' => (new AdminTaiKhoanController())->formLogin(),
    'logout-admin' => (new AdminTaiKhoanController())->logout(),
    'check-login-admin' => (new AdminTaiKhoanController())->login(),


    //router quản lí danh mục tour
    'danh-muc-tour' => (new AdminDanhMucController())->listDanhMuc(),
    'form-them-danh-muc' => (new AdminDanhMucController())->formAddDanhMuc(),
    'post-them-danh-muc' => (new AdminDanhMucController())->postAddDanhMuc(),
    'form-sua-danh-muc' => (new AdminDanhMucController())->formEditDanhMuc(),
    'post-sua-danh-muc' => (new AdminDanhMucController())->postEditDanhMuc(),
    'xoa-danh-muc' => (new AdminDanhMucController())->deleteDanhMuc(),
    // QL Tour
    'quan-ly-tour' => (new AdminTourController())->listTour(),
    'form-them-tour' => (new AdminTourController())->formAddTour(),
    'post-them-tour' => (new AdminTourController())->postAddTour(),
    'get-tour-info' => (new AdminTourController())->getTourInfo(), // AJAX endpoint
    'form-sua-tour' => (new AdminTourController())->formEditTour(),
    'post-sua-tour' => (new AdminTourController())->postEditTour(),
    'xoa-tour' => (new AdminTourController())->deleteTour(),
};
