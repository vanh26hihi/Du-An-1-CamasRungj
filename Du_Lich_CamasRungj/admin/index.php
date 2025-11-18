<?php
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ
// Require toàn bộ file Controllers
require_once './controllers/AdminBookingController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/HDVController.php';
// // require_once './controllers/AdminTaiKhoanController.php';
// Require toàn bộ file Models
require_once './models/AdminBooking.php';
// require_once './models/AdminTaiKhoan.php';

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match


$publicRoutes = ['login-admin', 'check-login-admin', 'logout-admin'];

// if (!in_array($act, $publicRoutes)) {
//     checkAdmin();
// }

match ($act) {
    // router Admin Home
    '/' => (new AdminBaoCaoThongKeController())->home(),

    // router danh mục
    'booking' => (new AdminBookingController())->danhSachBooking(),
    'form-them-booking' => (new AdminBookingController())->formAddBooking(),
    'them-booking' => (new AdminBookingController())->postAddBooking(),
    // 'form-sua-booking' => (new AdminBookingController())->formEditBooking(),
    // 'sua-booking' => (new AdminBookingController())->postEditBooking(),
    // 'xoa-booking' => (new AdminBookingController())->deleteBooking(),

    //router quản lý HDV
    'hdv-quan-ly' => HDVController::quanLyHDV($_GET['hdv_id'] ?? 'all'),
    'hdv-lich-lam-viec' => HDVController::lichLamViec($_GET['hdv_id'] ?? null),
    'hdv-danh-sach-khach' => HDVController::danhSachKhach($_GET['lich_id'] ?? null),
    'hdv-nhat-ky' => HDVController::nhatKy($_GET['hdv_id'] ?? null),
    'hdv-form-them-nhat-ky' => HDVController::formThemNhatKy($_GET['hdv_id'] ?? null),
    'hdv-get-tours' => HDVController::getToursByHDVAjax($_GET['hdv_id'] ?? null),
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

    //router quản lý tài khoản
    //quản lý tài khoản quản trị
    'list-tai-khoan-quan-tri' => (new AdminTaiKhoanController())->danhSachQuanTri(),
    'form-them-quan-tri' => (new AdminTaiKhoanController())->formAddQuanTri(),
    'them-quan-tri' => (new AdminTaiKhoanController())->postAddQuanTri(),
    'form-sua-quan-tri' => (new AdminTaiKhoanController())->formEditQuanTri(),
    'sua-quan-tri' => (new AdminTaiKhoanController())->postEditQuanTri(),
    //reset password
    'reset-password' => (new AdminTaiKhoanController())->resetPassword(),

    //quản lý tài khoản khách hàng
    'list-tai-khoan-khach-hang' => (new AdminTaiKhoanController())->danhSachKhachHang(),
    'form-sua-khach-hang' => (new AdminTaiKhoanController())->formEditKhachHang(),
    'sua-khach-hang' => (new AdminTaiKhoanController())->postEditKhachHang(),
    'chi-tiet-khach-hang' => (new AdminTaiKhoanController())->detailKhachHang(),


    'form-sua-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->formEditCaNhanQuanTri(),
    'post-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->postEditCaNhanQuanTri(),

    'sua-mat-khau-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->postEditMatKhauCaNhanQuanTri(),

    //router auth'
    'login-admin' => (new AdminTaiKhoanController())->formLogin(),
    'logout-admin' => (new AdminTaiKhoanController())->logout(),
    'check-login-admin' => (new AdminTaiKhoanController())->login(),
};
