<?php
/**
 * ============================================================================
 * HDV LICH LAM VIEC CONTROLLER
 * ============================================================================
 * Xử lý tất cả chức năng liên quan đến lịch làm việc của HDV:
 * - Xem danh sách lịch làm việc
 * - Xem danh sách khách hàng theo lịch
 * - Điểm danh khách hàng
 * - Quản lý nhật ký tour
 * ============================================================================
 */

require_once './models/HDVModel.php';
require_once './models/DiemDanhModel.php';
require_once './models/NhatKyTourModel.php';

class HDVLichLamViecController
{
    // ========================================================================
    // === TRANG CHỦ - DANH SÁCH LỊCH LÀM VIỆC ===
    // ========================================================================
    
    public function danhSachLichLamViec()
    {
        $hdv_id = $_SESSION['user_admin']['nguoi_dung_id'];
        
        // Lấy thông tin HDV
        $hdvInfo = HDVModel::getHDVById($hdv_id);
        
        // Lấy danh sách lịch làm việc
        $lichLamViec = HDVModel::getLichLamViecByHDV($hdv_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/danh-sach-lich.php';
        require_once './views/layout/footer.php';
    }

    // ========================================================================
    // === CHI TIẾT LỊCH - DANH SÁCH KHÁCH HÀNG ===
    // ========================================================================
    
    public function danhSachKhach()
    {
        $lich_id = $_GET['lich_id'] ?? null;
        $hdv_id = $_SESSION['user_admin']['nguoi_dung_id'];
        
        if (!$lich_id) {
            $_SESSION['error'] = 'Không tìm thấy lịch trình';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Lấy thông tin lịch
        $lichInfo = $this->getLichInfo($lich_id);
        
        if (!$lichInfo) {
            $_SESSION['error'] = 'Lịch trình không tồn tại';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Kiểm tra quyền truy cập (HDV có được phân công không)
        if (!$this->kiemTraQuyenTruyCap($hdv_id, $lich_id)) {
            $_SESSION['error'] = 'Bạn không có quyền truy cập lịch này';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Lấy danh sách khách hàng
        $danhSachKhach = HDVModel::getPassengersByLich($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/danh-sach-khach.php';
        require_once './views/layout/footer.php';
    }

    // ========================================================================
    // === ĐIỂM DANH KHÁCH HÀNG ===
    // ========================================================================
    
    public function diemDanh()
    {
        $lich_id = $_GET['lich_id'] ?? null;
        $hdv_id = $_SESSION['user_admin']['nguoi_dung_id'];
        
        if (!$lich_id) {
            $_SESSION['error'] = 'Không tìm thấy lịch trình';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Lấy thông tin lịch
        $lichInfo = $this->getLichInfo($lich_id);
        
        if (!$lichInfo) {
            $_SESSION['error'] = 'Lịch trình không tồn tại';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Kiểm tra quyền truy cập
        if (!$this->kiemTraQuyenTruyCap($hdv_id, $lich_id)) {
            $_SESSION['error'] = 'Bạn không có quyền truy cập lịch này';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Lấy danh sách khách để điểm danh
        $danhSachDiemDanh = DiemDanhModel::getCustomersForAttendance($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/diem-danh.php';
        require_once './views/layout/footer.php';
    }

    // ========================================================================
    // === XỬ LÝ ĐIỂM DANH (TOGGLE) ===
    // ========================================================================
    
    public function xuLyDiemDanh()
    {
        $hanh_khach_id = $_GET['hanh_khach_id'] ?? null;
        $lich_id = $_GET['lich_id'] ?? null;
        $hdv_id = $_SESSION['user_admin']['nguoi_dung_id'];
        
        if (!$hanh_khach_id || !$lich_id) {
            $_SESSION['error'] = 'Thiếu thông tin điểm danh';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Kiểm tra quyền
        if (!$this->kiemTraQuyenTruyCap($hdv_id, $lich_id)) {
            $_SESSION['error'] = 'Bạn không có quyền điểm danh lịch này';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Toggle điểm danh
        DiemDanhModel::toggleAttendance($hanh_khach_id, $lich_id, $hdv_id);
        
        // Redirect về trang điểm danh
        header('Location: ' . BASE_URL_ADMIN . '?act=hdv-diem-danh&lich_id=' . $lich_id);
        exit();
    }

    // ========================================================================
    // === NHẬT KÝ TOUR ===
    // ========================================================================
    
    public function nhatKyTour()
    {
        $lich_id = $_GET['lich_id'] ?? null;
        $hdv_id = $_SESSION['user_admin']['nguoi_dung_id'];
        
        if (!$lich_id) {
            $_SESSION['error'] = 'Không tìm thấy lịch trình';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Lấy thông tin lịch
        $lichInfo = $this->getLichInfo($lich_id);
        
        if (!$lichInfo) {
            $_SESSION['error'] = 'Lịch trình không tồn tại';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Kiểm tra quyền
        if (!$this->kiemTraQuyenTruyCap($hdv_id, $lich_id)) {
            $_SESSION['error'] = 'Bạn không có quyền truy cập lịch này';
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }
        
        // Lấy danh sách nhật ký theo địa điểm
        $nhatKyList = NhatKyTourModel::getByLich($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/nhat-ky-tour.php';
        require_once './views/layout/footer.php';
    }

    // ========================================================================
    // === THÊM NHẬT KÝ TOUR ===
    // ========================================================================
    
    public function themNhatKy()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lich_id = $_POST['lich_id'] ?? null;
            $dia_diem = trim($_POST['dia_diem'] ?? '');
            $mo_ta = trim($_POST['mo_ta'] ?? '');
            $ngay_ghi = $_POST['ngay_ghi'] ?? date('Y-m-d');
            $hdv_id = $_SESSION['user_admin']['nguoi_dung_id'];
            
            $error = [];
            
            // Validation
            if (empty($lich_id)) {
                $error['lich_id'] = 'Không tìm thấy lịch trình';
            }
            
            if (empty($dia_diem)) {
                $error['dia_diem'] = 'Địa điểm không được để trống';
            }
            
            if (empty($mo_ta)) {
                $error['mo_ta'] = 'Mô tả không được để trống';
            }
            
            if (!empty($error)) {
                $_SESSION['error'] = $error;
                $_SESSION['old'] = $_POST;
                $_SESSION['flash'] = true;
                header('Location: ' . BASE_URL_ADMIN . '?act=hdv-nhat-ky-tour&lich_id=' . $lich_id);
                exit();
            }
            
            // Thêm nhật ký
            $result = NhatKyTourModel::insert([
                'lich_id' => $lich_id,
                'dia_diem' => $dia_diem,
                'mo_ta' => $mo_ta,
                'ngay_ghi' => $ngay_ghi,
                'nguoi_tao_id' => $hdv_id
            ]);
            
            if ($result) {
                $_SESSION['success'] = 'Thêm nhật ký thành công!';
            } else {
                $_SESSION['error'] = ['general' => 'Có lỗi xảy ra khi thêm nhật ký'];
            }
            
            header('Location: ' . BASE_URL_ADMIN . '?act=hdv-nhat-ky-tour&lich_id=' . $lich_id);
            exit();
        }
    }

    // ========================================================================
    // === HELPER FUNCTIONS ===
    // ========================================================================
    
    private function getLichInfo($lich_id)
    {
        $sql = "SELECT 
                    lich_khoi_hanh.*,
                    tour.ten as ten_tour,
                    tour.mo_ta as mo_ta_tour
                FROM lich_khoi_hanh
                JOIN tour ON tour.tour_id = lich_khoi_hanh.tour_id
                WHERE lich_khoi_hanh.lich_id = ?";
        return db_query($sql, [$lich_id])->fetch();
    }
    
    private function kiemTraQuyenTruyCap($hdv_id, $lich_id)
    {
        // Kiểm tra HDV có được phân công vào lịch này không
        $sql = "SELECT phan_cong_id FROM phan_cong_hdv 
                WHERE hdv_id = ? AND lich_id = ?";
        $result = db_query($sql, [$hdv_id, $lich_id])->fetch();
        return !empty($result);
    }
}
