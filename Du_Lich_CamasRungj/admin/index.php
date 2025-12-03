<?php
session_start();
require_once '../commons/env.php';
require_once '../commons/function.php';

$conn = connectDB();

require_once './controllers/AdminBookingController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/HDVController.php';
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminTourController.php';
require_once './controllers/AdminTaiKhoanController.php';
require_once './controllers/AdminTaiKhoanQuanTriController.php';
require_once './controllers/AdminTaiKhoanHDVController.php';
require_once './controllers/AdminTaiKhoanCaNhanController.php';
require_once './controllers/hdv/HDVLichLamViecController.php';

require_once './models/AdminBooking.php';
require_once './models/AdminTour.php';
require_once './models/AdminTaiKhoan.php';

$act = $_GET['act'] ?? '/';

// Danh sách route công khai (không cần đăng nhập)
$publicRoutes = ['login-admin', 'check-login-admin'];

// Kiểm tra đăng nhập cho tất cả route trừ public routes
if (!in_array($act, $publicRoutes)) {
    // Nếu chưa đăng nhập, chuyển đến trang login
    if (empty($_SESSION['user_admin'])) {
        header('Location: ' . BASE_URL_ADMIN . '?act=login-admin');
        exit();
    }
}

match ($act) {
    '/' => $_SESSION['user_admin']['vai_tro_id'] == 2 
        ? (new HDVLichLamViecController())->danhSachLichLamViec()
        : (new AdminBaoCaoThongKeController())->home(),

    'booking' => (new AdminBookingController())->danhSachBooking(),
    'form-them-booking' => (new AdminBookingController())->formAddBooking(),
    'them-booking' => (new AdminBookingController())->postAddBooking(),
    'form-sua-booking' => (new AdminBookingController())->formEditBooking(),
    'sua-booking' => (new AdminBookingController())->postEditBooking(),
    'xoa-booking' => (new AdminBookingController())->deleteBooking(),

    'hdv-quan-ly' => HDVController::quanLyHDV($_GET['hdv_id'] ?? 'all'),
    'hdv-form-them' => HDVController::formAddHDV(),
    'hdv-them' => HDVController::postAddHDV(),
    'hdv-form-sua' => HDVController::formEditHDV($_GET['hdv_id'] ?? null),
    'hdv-sua' => HDVController::postEditHDV($_GET['hdv_id'] ?? null),
    'hdv-xoa' => HDVController::deleteHDV($_GET['hdv_id'] ?? null),
    'hdv-chi-tiet-lich' => HDVController::chiTietLich($_GET['lich_id'] ?? null, $_GET['hdv_id'] ?? null),
    'hdv-get-tours' => HDVController::getToursByHDVAjax($_GET['hdv_id'] ?? null),
    'hdv-diem-danh-action' => HDVController::diemDanhAction($_GET['hanh_khach_id'] ?? null, $_GET['lich_id'] ?? null, $_GET['hdv_id'] ?? null),

    // Quản lý tài khoản quản trị (AdminTaiKhoanQuanTriController)
    'list-tai-khoan-quan-tri' => (new AdminTaiKhoanQuanTriController())->danhSachQuanTri(),
    'danh-sach-quan-tri' => (new AdminTaiKhoanQuanTriController())->danhSachQuanTri(),
    'form-them-quan-tri' => (new AdminTaiKhoanQuanTriController())->formAddQuanTri(),
    'them-quan-tri' => (new AdminTaiKhoanQuanTriController())->postAddQuanTri(),
    'form-sua-quan-tri' => (new AdminTaiKhoanQuanTriController())->formEditQuanTri(),
    'sua-quan-tri' => (new AdminTaiKhoanQuanTriController())->postEditQuanTri(),
    'reset-password' => (new AdminTaiKhoanQuanTriController())->resetPassword(),
    'reset-password-quan-tri' => (new AdminTaiKhoanQuanTriController())->resetPassword(),
    'xoa-quan-tri' => (new AdminTaiKhoanQuanTriController())->deleteQuanTri(),

    // Quản lý tài khoản HDV (AdminTaiKhoanHDVController)
    'danh-sach-hdv' => (new AdminTaiKhoanHDVController())->danhSachHDV(),
    'form-them-hdv' => (new AdminTaiKhoanHDVController())->formAddHDV(),
    'them-hdv' => (new AdminTaiKhoanHDVController())->postAddHDV(),
    'form-sua-hdv' => (new AdminTaiKhoanHDVController())->formEditHDV(),
    'sua-hdv' => (new AdminTaiKhoanHDVController())->postEditHDV(),
    'reset-password-hdv' => (new AdminTaiKhoanHDVController())->resetPassword(),
    'xoa-hdv' => (new AdminTaiKhoanHDVController())->deleteHDV(),

    // Quản lý tài khoản cá nhân (AdminTaiKhoanCaNhanController)
    'form-sua-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanCaNhanController())->formEditCaNhan(),
    'post-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanCaNhanController())->postEditCaNhan(),
    'sua-mat-khau-ca-nhan-quan-tri' => (new AdminTaiKhoanCaNhanController())->postEditMatKhau(),

    'login-admin' => (new AdminTaiKhoanController())->formLogin(),
    'logout-admin' => (new AdminTaiKhoanController())->logout(),
    'check-login-admin' => (new AdminTaiKhoanController())->login(),

    // Routes cho HDV - Lịch Làm Việc
    'hdv-danh-sach-khach' => (new HDVLichLamViecController())->danhSachKhach(),
    'hdv-diem-danh' => (new HDVLichLamViecController())->diemDanh(),
    'hdv-xu-ly-diem-danh' => (new HDVLichLamViecController())->xuLyDiemDanh(),
    'hdv-nhat-ky-tour' => (new HDVLichLamViecController())->nhatKyTour(),
    'hdv-them-nhat-ky' => (new HDVLichLamViecController())->themNhatKy(),


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
    'copy-tour' => (new AdminTourController())->copyTour(),
};
