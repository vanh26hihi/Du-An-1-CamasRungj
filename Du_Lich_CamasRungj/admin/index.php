<?php
require_once '../commons/env.php';
require_once '../commons/function.php';

$conn = connectDB();

require_once './controllers/AdminBookingController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/HDVController.php';
require_once './controllers/QuanLyTourController.php';
require_once './controllers/AdminDanhMucController.php';

require_once './models/AdminBooking.php';

$act = $_GET['act'] ?? '/';

$publicRoutes = ['login-admin', 'check-login-admin', 'logout-admin'];

match ($act) {
    '/' => (new AdminBaoCaoThongKeController())->home(),

    'booking' => (new AdminBookingController())->danhSachBooking(),
    'form-them-booking' => (new AdminBookingController())->formAddBooking(),
    'them-booking' => (new AdminBookingController())->postAddBooking(),

    'hdv-quan-ly' => HDVController::quanLyHDV($_GET['hdv_id'] ?? 'all'),
    'hdv-get-tours' => HDVController::getToursByHDVAjax($_GET['hdv_id'] ?? null),
    'hdv-lich-lam-viec' => HDVController::lichLamViec($_GET['hdv_id'] ?? null),
    'hdv-danh-sach-khach' => HDVController::danhSachKhach($_GET['lich_id'] ?? null),
    'hdv-nhat-ky' => HDVController::nhatKy($_GET['hdv_id'] ?? null),
    'hdv-form-them-nhat-ky' => HDVController::formThemNhatKy($_GET['hdv_id'] ?? null),
    'hdv-them-nhat-ky' => HDVController::themNhatKy($_POST),
    'hdv-form-sua-nhat-ky' => HDVController::formSuaNhatKy($_GET['nhat_ky_id'] ?? null),
    'hdv-sua-nhat-ky' => HDVController::suaNhatKy($_POST),
    'hdv-xoa-nhat-ky' => HDVController::xoaNhatKy($_GET['nhat_ky_id'] ?? null, $_GET['hdv_id'] ?? null),
    'hdv-diem-danh' => HDVController::diemDanh($_GET['lich_id'] ?? null, $_GET['hdv_id'] ?? null),
    'hdv-diem-danh-action' => HDVController::diemDanhAction($_GET['hanh_khach_id'] ?? null, $_GET['lich_id'] ?? null, $_GET['hdv_id'] ?? null),
    'hdv-yeu-cau-dac-biet' => HDVController::yeuCauDacBiet($_GET['lich_id'] ?? null),
    'hdv-form-sua-yeu-cau' => HDVController::formSuaYeuCau($_GET['khach_hang_id'] ?? null),
    'hdv-sua-yeu-cau' => HDVController::suaYeuCau($_POST),
    'hdv-form-danh-gia-tour' => HDVController::danhGiaTour($_GET['hdv_id'] ?? null),
    'hdv-gui-danh-gia' => HDVController::guiDanhGia($_POST),

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
    'quan-ly-tour' => (new QuanLyTourController())->listTour(),
    'form-them-tour' => (new QuanLyTourController())->formAddtour(),
    'post-them-tour' => (new QuanLyTourController())->AddTour(),
    'form-sua-tour' => (new QuanLyTourController())->EditTour(),
    'post-sua-tour' => (new QuanLyTourController())->postEdittour(),
    

    'xoa-tour' => (new QuanLyTourController())->deleteTour(),


};
