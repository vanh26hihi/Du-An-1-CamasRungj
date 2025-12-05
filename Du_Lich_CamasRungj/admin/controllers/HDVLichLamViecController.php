<?php
require_once '../commons/function.php';
require_once './models/HDVModel.php';
require_once './models/DiemDanhModel.php';
require_once './models/NhatKyTourModel.php';

class HDVLichLamViecController {

    // Helper: Lấy thông tin lịch khởi hành
    private function getLichInfo($lich_id) {
        $sql = "SELECT lkh.*, t.ten as ten_tour, t.mo_ta, t.mo_ta_ngan,
                       t.gia_co_ban, t.thoi_luong_mac_dinh, t.diem_khoi_hanh
                FROM lich_khoi_hanh lkh
                JOIN tour t ON t.tour_id = lkh.tour_id
                WHERE lkh.lich_id = ?";
        return db_query($sql, [$lich_id])->fetch();
    }

    // Trang lịch làm việc của HDV (home page)
    public function danhSachLichLamViec() {
        $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
        
        // Lấy hdv_id từ nguoi_dung_id
        $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
        
        if ($hdvInfo) {
            // Lấy lịch làm việc từ bảng phan_cong_hdv
            $lichLamViec = HDVModel::getLichLamViecByHDV($hdvInfo['hdv_id']);
        } else {
            $lichLamViec = [];
        }
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/lich-lam-viec-home.php';
        require_once './views/layout/footer.php';
    }

    // Danh sách khách hàng trong tour
    public function danhSachKhach() {
        $lich_id = $_GET['lich_id'] ?? null;
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        $lichInfo = $this->getLichInfo($lich_id);
        $danhSachKhach = HDVModel::getPassengersByLich($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/danh-sach-khach.php';
        require_once './views/layout/footer.php';
    }

    // Trang điểm danh
    public function diemDanh() {
        $lich_id = $_GET['lich_id'] ?? null;
        $selected_lich_trinh_id = $_GET['lich_trinh_id'] ?? null; // Cho phép chọn lịch trình cụ thể
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        $lichInfo = $this->getLichInfo($lich_id);
        
        // Lấy tất cả lịch trình của tour
        $allSchedules = DiemDanhModel::getTourSchedules($lich_id);
        
        // Lấy lịch trình hiện tại theo timeline
        $currentSchedule = DiemDanhModel::getCurrentSchedule($lich_id);
        
        // Nếu người dùng chọn lịch trình cụ thể, sử dụng lịch trình đó
        if ($selected_lich_trinh_id) {
            foreach ($allSchedules as $schedule) {
                if ($schedule['lich_trinh_id'] == $selected_lich_trinh_id) {
                    $currentSchedule = $schedule;
                    // Đảm bảo có đầy đủ thông tin
                    $currentSchedule['status'] = 'selected';
                    break;
                }
            }
        }
        
        // Lấy danh sách khách hàng theo lịch trình hiện tại
        if ($currentSchedule && isset($currentSchedule['lich_trinh_id'])) {
            $danhSachDiemDanh = DiemDanhModel::getCustomersForSchedule($lich_id, $currentSchedule['lich_trinh_id']);
        } else {
            $danhSachDiemDanh = [];
        }
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/diem-danh.php';
        require_once './views/layout/footer.php';
    }

    // Xử lý điểm danh
    public function xuLyDiemDanh() {
        // Xử lý POST - Lưu nhiều điểm danh cùng lúc
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Clear output buffer và set header JSON
            ob_clean();
            header('Content-Type: application/json; charset=utf-8');
            
            $hanh_khach_ids = $_POST['hanh_khach_ids'] ?? [];
            $lich_id = $_POST['lich_id'] ?? null;
            $lich_trinh_id = $_POST['lich_trinh_id'] ?? null;
            $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
            
            if (!$lich_id || !$lich_trinh_id || !$nguoi_dung_id) {
                echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ!'], JSON_UNESCAPED_UNICODE);
                exit();
            }
            
            // Lấy hdv_id từ nguoi_dung_id
            $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
            if (!$hdvInfo) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy thông tin hướng dẫn viên!'], JSON_UNESCAPED_UNICODE);
                exit();
            }
            
            try {
                // Lấy danh sách khách hàng hiện tại của lịch trình này
                $danhSachHienTai = DiemDanhModel::getCustomersForSchedule($lich_id, $lich_trinh_id);
                
                // Tạo mapping để so sánh
                $currentIds = array_column($danhSachHienTai, 'hanh_khach_id');
                $submittedIds = array_map('intval', $hanh_khach_ids);
                
                // Xác định: ai cần điểm danh (checked), ai cần hủy (unchecked)
                foreach ($danhSachHienTai as $khach) {
                    $hanhKhachId = $khach['hanh_khach_id'];
                    $daCoMat = $khach['da_den'] == 1;
                    $shouldBeChecked = in_array($hanhKhachId, $submittedIds);
                    
                    // Nếu trạng thái khác nhau → toggle
                    if ($daCoMat != $shouldBeChecked) {
                        DiemDanhModel::toggleAttendanceForSchedule($hanhKhachId, $lich_trinh_id, $hdvInfo['hdv_id']);
                    }
                }
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Đã lưu điểm danh thành công!',
                    'total' => count($currentIds),
                    'checked' => count($submittedIds)
                ], JSON_UNESCAPED_UNICODE);
                exit();
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
                exit();
            }
        }
        
        // Xử lý GET - Toggle đơn lẻ (legacy support)
        $hanh_khach_id = $_GET['hanh_khach_id'] ?? null;
        $lich_id = $_GET['lich_id'] ?? null;
        $lich_trinh_id = $_GET['lich_trinh_id'] ?? null;
        $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
        
        if ($hanh_khach_id && $lich_id && $lich_trinh_id && $nguoi_dung_id) {
            $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
            if ($hdvInfo) {
                $result = DiemDanhModel::toggleAttendanceForSchedule($hanh_khach_id, $lich_trinh_id, $hdvInfo['hdv_id']);
                if ($result) {
                    $_SESSION['success'] = "Cập nhật điểm danh thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi khi cập nhật điểm danh!";
                }
            } else {
                $_SESSION['error'] = "Không tìm thấy thông tin hướng dẫn viên!";
            }
        } else {
            $_SESSION['error'] = "Thông tin không hợp lệ!";
        }
        
        $redirectUrl = '?act=hdv-diem-danh&lich_id=' . $lich_id;
        if ($lich_trinh_id) {
            $redirectUrl .= '&lich_trinh_id=' . $lich_trinh_id;
        }
        header('Location: ' . $redirectUrl);
        exit();
    }

    // Trang nhật ký tour
    public function nhatKyTour() {
        $lich_id = $_GET['lich_id'] ?? null;
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        $lichInfo = $this->getLichInfo($lich_id);
        $nhatKyList = NhatKyTourModel::getByLich($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/nhat-ky-tour.php';
        require_once './views/layout/footer.php';
    }

    // Thêm nhật ký tour
    public function themNhatKyTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lich_id = $_POST['lich_id'] ?? null;
            $noi_dung = $_POST['noi_dung'] ?? '';
            $ngay_ghi = $_POST['ngay_ghi'] ?? date('Y-m-d');
            $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
            
            // Lấy hdv_id từ nguoi_dung_id
            $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
            
            if ($hdvInfo && $lich_id && $noi_dung) {
                $data = [
                    ':lich_id' => $lich_id,
                    ':hdv_id' => $hdvInfo['hdv_id'],
                    ':noi_dung' => $noi_dung,
                    ':ngay_ghi' => $ngay_ghi
                ];
                NhatKyTourModel::insert($data);
                
                $_SESSION['success'] = "Thêm nhật ký tour thành công!";
            } else {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            }
            
            header('Location: ?act=hdv-nhat-ky-tour&lich_id=' . $lich_id);
            exit();
        }
    }
}
