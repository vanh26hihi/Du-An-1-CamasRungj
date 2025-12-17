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

    // Trang nhật ký tour (cho HDV xem) - DEPRECATED, dùng chiTietLich() thay thế
    public function nhatKyTour() {
        $lich_id = $_GET['lich_id'] ?? null;
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        // Redirect sang tab nhật ký trong chi tiết lịch
        header('Location: ?act=hdv-chi-tiet-lich-lam-viec&lich_id=' . $lich_id . '&tab=nhat-ky');
        exit();
    }
    
    // Chi tiết lịch làm việc (3 tab: Khách hàng, Điểm danh, Nhật ký) - cho HDV
    public function chiTietLich() {
        $lich_id = $_GET['lich_id'] ?? null;
        $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        // Lấy hdv_id từ nguoi_dung_id
        $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
        if (!$hdvInfo) {
            $_SESSION['error'] = "Không tìm thấy thông tin HDV!";
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        $hdv_id = $hdvInfo['hdv_id'];
        
        $tab = $_GET['tab'] ?? 'khach-hang';
        
        // Lấy thông tin lịch
        $lichInfo = $this->getLichInfo($lich_id);
        if (!$lichInfo) {
            $_SESSION['error'] = "Không tìm thấy lịch tour!";
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        // Lấy danh sách khách hàng
        $danhSachKhach = HDVModel::getPassengersByLich($lich_id);
        
        // Lấy nhật ký
        $nhatKy = NhatKyTourModel::getByLich($lich_id);
        
        // Lấy địa điểm của tour (để chọn trong form nhật ký)
        $sql = "SELECT dd.dia_diem_id, dd.ten as ten_dia_diem 
                FROM dia_diem dd
                INNER JOIN dia_diem_tour ddt ON dd.dia_diem_id = ddt.dia_diem_id
                WHERE ddt.tour_id = ?
                ORDER BY dd.ten";
        $diaDiemTour = db_query($sql, [$lichInfo['tour_id']])->fetchAll();
        
        // Lấy tất cả lịch trình của tour
        $allSchedules = DiemDanhModel::getTourSchedules($lich_id);
        
        // Xác định lịch trình hiện tại (nếu tab điểm danh)
        $currentSchedule = null;
        $lich_trinh_id = $_GET['lich_trinh_id'] ?? null;
        
        if ($tab == 'diem-danh') {
            if ($lich_trinh_id) {
                // Nếu có chọn lịch trình cụ thể, lấy thông tin lịch trình đó
                foreach ($allSchedules as $schedule) {
                    if ($schedule['lich_trinh_id'] == $lich_trinh_id) {
                        $currentSchedule = $schedule;
                        break;
                    }
                }
            } else {
                // Nếu không có, lấy lịch trình hiện tại theo thời gian
                $currentSchedule = DiemDanhModel::getCurrentSchedule($lich_id);
            }
        }
        
        // Lấy danh sách điểm danh theo lịch trình
        if ($tab == 'diem-danh' && $currentSchedule) {
            $diemDanh = DiemDanhModel::getCustomersForSchedule($lich_id, $currentSchedule['lich_trinh_id']);
        } else {
            $diemDanh = DiemDanhModel::getCustomersForAttendance($lich_id);
        }
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/chi-tiet-lich.php';
        require_once './views/layout/footer.php';
    }

    // Thêm nhật ký tour
    public function themNhatKyTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lich_id = $_POST['lich_id'] ?? null;
            $tour_id = $_POST['tour_id'] ?? null;
            $dia_diem_id = $_POST['dia_diem_id'] ?? null;
            $ngay_thuc_hien = $_POST['ngay_thuc_hien'] ?? date('Y-m-d H:i:s');
            $noi_dung = $_POST['noi_dung'] ?? '';
            
            // Lấy hdv_id từ session
            $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
            $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
            
            if (!$hdvInfo) {
                $_SESSION['error'] = "Không tìm thấy thông tin HDV!";
                header('Location: ?act=hdv-lich-lam-viec');
                exit();
            }
            $hdv_id = $hdvInfo['hdv_id'];
            
            // Xử lý upload ảnh
            $anh_tour = '';
            if (isset($_FILES['anh_tour']) && $_FILES['anh_tour']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = PATH_ROOT . 'uploads/nhatky/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_ext = strtolower(pathinfo($_FILES['anh_tour']['name'], PATHINFO_EXTENSION));
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($file_ext, $allowed_exts)) {
                    $new_filename = 'tour' . $tour_id . '_' . time() . '.' . $file_ext;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['anh_tour']['tmp_name'], $upload_path)) {
                        $anh_tour = 'uploads/nhatky/' . $new_filename;
                    }
                }
            }
            
            // Validation
            $error = [];
            if (empty($dia_diem_id)) {
                $error['dia_diem_id'] = 'Vui lòng chọn địa điểm!';
            }
            if (empty($noi_dung)) {
                $error['noi_dung'] = 'Vui lòng nhập nội dung!';
            }
            
            if (empty($error)) {
                // Chuyển đổi datetime-local sang format MySQL
                $ngay_thuc_hien_formatted = date('Y-m-d H:i:s', strtotime($ngay_thuc_hien));
                
                $data = [
                    'tour_id' => $tour_id,
                    'hdv_id' => $hdv_id,
                    'lich_id' => $lich_id,
                    'dia_diem_id' => $dia_diem_id,
                    'anh_tour' => $anh_tour,
                    'ngay_thuc_hien' => $ngay_thuc_hien_formatted,
                    'noi_dung' => $noi_dung
                ];
                
                NhatKyTourModel::add($data);
                $_SESSION['success'] = "Thêm nhật ký tour thành công!";
            } else {
                $_SESSION['error'] = $error;
                $_SESSION['old'] = $_POST;
            }
            
            header('Location: ?act=hdv-chi-tiet-lich-lam-viec&lich_id=' . $lich_id . '&tab=nhat-ky');
            exit();
        }
    }
    
    // Xóa nhật ký tour
    public function xoaNhatKyTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nhat_ky_id = $_POST['nhat_ky_id'] ?? null;
            $lich_id = $_POST['lich_id'] ?? null;
            
            if ($nhat_ky_id) {
                $result = NhatKyTourModel::delete($nhat_ky_id);
                
                if ($result) {
                    $_SESSION['success'] = "Xóa nhật ký thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi xóa nhật ký!";
                }
            }
            
            header('Location: ?act=hdv-chi-tiet-lich-lam-viec&lich_id=' . $lich_id . '&tab=nhat-ky');
            exit();
        }
    }
}
