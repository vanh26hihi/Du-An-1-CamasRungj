<?php
require_once './models/HDVModel.php';

class HDVController {
    
    // API endpoint để lấy tours của HDV (cho AJAX)
    public static function getToursByHDVAjax($hdv_id) {
        // Xóa tất cả output buffer
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set headers
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-cache, must-revalidate');
        
        if (empty($hdv_id)) {
            $result = json_encode(['tours' => []], JSON_UNESCAPED_UNICODE);
            echo $result;
            exit;
        }
        
        try {
            $toursData = HDVModel::getToursByHDV($hdv_id);
            $result = json_encode(['tours' => $toursData ? $toursData : []], JSON_UNESCAPED_UNICODE);
            echo $result;
        } catch (Exception $e) {
            $result = json_encode(['error' => $e->getMessage(), 'tours' => []], JSON_UNESCAPED_UNICODE);
            echo $result;
        }
        exit;
    }

    public static function quanLyHDV($hdv_id) {
        $tab = $_GET['tab'] ?? 'thong-tin';
        
        // Lấy danh sách tất cả HDV
        $allHDV = HDVModel::getAllHDV();
        
        // Xử lý hdv_id: nếu là "all" hoặc rỗng, lấy tất cả
        if ($hdv_id === 'all' || $hdv_id === '' || $hdv_id === null) {
            $hdv_id = 'all';
            $hdvInfo = null;
            $lichLamViec = [];
        } else {
            // Lấy thông tin HDV từ bảng huong_dan_vien
            $hdvInfo = HDVModel::getHDVById($hdv_id);
            
            // Lấy lịch làm việc từ bảng phan_cong_hdv
            $lichLamViec = HDVModel::getLichLamViecByHDV($hdv_id);
        }
        
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/quan-ly-hdv.php';
        include './views/layout/footer.php';
    }

    // Hiển thị form thêm HDV
    public static function formAddHDV() {
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-them-hdv.php';
        include './views/layout/footer.php';
    }

    // Xử lý thêm HDV
    public static function postAddHDV() {
        $ho_ten = $_POST['ho_ten'] ?? '';
        $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
        $email = $_POST['email'] ?? '';
        $kinh_nghiem = $_POST['kinh_nghiem'] ?? '';
        $ngon_ngu = $_POST['ngon_ngu'] ?? '';
        
        // Kiểm tra họ tên
        if ($ho_ten == '') {
            $_SESSION['error'] = "Họ tên không được để trống";
            header("Location: ?act=hdv-form-them");
            exit;
        }
        
        // Thêm HDV
        HDVModel::insertHDV($ho_ten, $so_dien_thoai, $email, $kinh_nghiem, $ngon_ngu);
        
        $_SESSION['success'] = "Thêm hướng dẫn viên thành công";
        header("Location: ?act=hdv-quan-ly&hdv_id=all");
        exit;
    }

    // Hiển thị form sửa HDV
    public static function formEditHDV($hdv_id) {
        $hdvInfo = HDVModel::getHDVById($hdv_id);
        if (!$hdvInfo) {
            header("Location: ?act=hdv-quan-ly&hdv_id=all");
            exit;
        }
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-sua-hdv.php';
        include './views/layout/footer.php';
    }

    // Xử lý sửa HDV
    public static function postEditHDV($hdv_id) {
        $ho_ten = $_POST['ho_ten'] ?? '';
        $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
        $email = $_POST['email'] ?? '';
        $kinh_nghiem = $_POST['kinh_nghiem'] ?? '';
        $ngon_ngu = $_POST['ngon_ngu'] ?? '';
        
        // Kiểm tra họ tên
        if ($ho_ten == '') {
            $_SESSION['error'] = "Họ tên không được để trống";
            $_SESSION['old'] = $_POST;
            header("Location: ?act=hdv-form-sua&hdv_id=" . $hdv_id);
            exit;
        }
        
        // Sửa HDV
        HDVModel::updateHDV($hdv_id, $ho_ten, $so_dien_thoai, $email, $kinh_nghiem, $ngon_ngu);
        
        $_SESSION['success'] = "Sửa hướng dẫn viên thành công";
        header("Location: ?act=hdv-quan-ly&hdv_id=" . $hdv_id);
        exit;
    }

    // Xóa hướng dẫn viên
    public static function deleteHDV($hdv_id) {
        $hdvInfo = HDVModel::getHDVById($hdv_id);
        if (!$hdvInfo) {
            $_SESSION['error'] = "Không tìm thấy hướng dẫn viên";
            header("Location: ?act=hdv-quan-ly&hdv_id=all");
            exit;
        }
        
        HDVModel::deleteHDV($hdv_id);
        $_SESSION['success'] = "Xóa hướng dẫn viên thành công";
        header("Location: ?act=hdv-quan-ly&hdv_id=all");
        exit;
    }

    // Chi tiết lịch làm việc (3 tab: Khách hàng, Điểm danh, Nhật ký)
    public static function chiTietLich($lich_id, $hdv_id) {
        require_once './models/DiemDanhModel.php';
        require_once './models/NhatKyTourModel.php';
        require_once '../commons/function.php';
        
        $tab = $_GET['tab'] ?? 'khach-hang';
        
        $sql = "SELECT lich_khoi_hanh.lich_id, lich_khoi_hanh.ngay_bat_dau, lich_khoi_hanh.ngay_ket_thuc, tour.tour_id, tour.ten ten_tour
                FROM lich_khoi_hanh
                JOIN tour ON lich_khoi_hanh.tour_id = tour.tour_id
                WHERE lich_khoi_hanh.lich_id = ?";
        $lichInfo = db_query($sql, [$lich_id])->fetch();
        
        if (!$lichInfo) {
            header("Location: ?act=hdv-quan-ly&hdv_id=" . $hdv_id);
            exit;
        }
        
        $danhSachKhach = HDVModel::getPassengersByLich($lich_id);
        $nhatKy = NhatKyTourModel::getByLich($lich_id);
        
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
        
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/chi-tiet-lich.php';
        include './views/layout/footer.php';
    }

    // Trang chủ cho HDV - Hiển thị lịch làm việc
    public static function lichLamViecHDV($hdv_id) {
        // Lấy thông tin HDV
        $hdvInfo = HDVModel::getHDVById($hdv_id);
        
        // Lấy lịch làm việc của HDV
        $lichLamViec = HDVModel::getLichLamViecByHDV($hdv_id);
        
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/lich-lam-viec-home.php';
        include './views/layout/footer.php';
    }

    // Xử lý điểm danh (cho admin)
    public static function diemDanhAction() {
        require_once './models/DiemDanhModel.php';
        
        // Xử lý POST - Lưu nhiều điểm danh cùng lúc (AJAX)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ob_clean();
            header('Content-Type: application/json; charset=utf-8');
            
            $hanh_khach_ids = $_POST['hanh_khach_ids'] ?? [];
            $lich_id = $_POST['lich_id'] ?? null;
            $hdv_id = $_POST['hdv_id'] ?? null;
            
            if (!$lich_id || !$hdv_id) {
                echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ!'], JSON_UNESCAPED_UNICODE);
                exit();
            }
            
            try {
                // Lấy danh sách khách hàng hiện tại
                $danhSachHienTai = DiemDanhModel::getCustomersForAttendance($lich_id);
                
                // Tạo mapping để so sánh
                $currentIds = array_column($danhSachHienTai, 'hanh_khach_id');
                $submittedIds = array_map('intval', $hanh_khach_ids);
                
                // Xác định: ai cần điểm danh (checked), ai cần hủy (unchecked)
                foreach ($danhSachHienTai as $khach) {
                    $hanhKhachId = $khach['hanh_khach_id'];
                    $daCoMat = isset($khach['da_den']) && $khach['da_den'] == 1;
                    $shouldBeChecked = in_array($hanhKhachId, $submittedIds);
                    
                    // Nếu trạng thái khác nhau → toggle
                    if ($daCoMat != $shouldBeChecked) {
                        DiemDanhModel::toggleAttendance($hanhKhachId, $lich_id, $hdv_id);
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
        $hdv_id = $_GET['hdv_id'] ?? null;
        $redirect = $_GET['redirect'] ?? 'chi-tiet-lich';
        $tab = $_GET['tab'] ?? 'diem-danh';
        
        if (!$hanh_khach_id || !$lich_id || !$hdv_id) {
            $_SESSION['error'] = "Thiếu thông tin điểm danh";
            header("Location: ?act=hdv-chi-tiet-lich&lich_id=" . $lich_id . "&hdv_id=" . $hdv_id . "&tab=" . $tab);
            exit;
        }
        
        // Toggle điểm danh
        $result = DiemDanhModel::toggleAttendance($hanh_khach_id, $lich_id, $hdv_id);
        
        if ($result) {
            $_SESSION['success'] = "Cập nhật điểm danh thành công";
        } else {
            $_SESSION['error'] = "Có lỗi khi cập nhật điểm danh";
        }
        
        if ($redirect === 'chi-tiet-lich') {
            header("Location: ?act=hdv-chi-tiet-lich&lich_id=" . $lich_id . "&hdv_id=" . $hdv_id . "&tab=" . $tab);
        } else {
            header("Location: ?act=hdv-quan-ly&hdv_id=" . $hdv_id);
        }
        exit;
    }

    // Thêm nhật ký tour (Admin thêm cho HDV)
    public static function themNhatKy() {
        require_once './models/NhatKyTourModel.php';
        require_once '../commons/function.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lich_id = $_POST['lich_id'] ?? null;
            $hdv_id = $_POST['hdv_id'] ?? null;
            $tour_id = $_POST['tour_id'] ?? null;
            $dia_diem_id = $_POST['dia_diem_id'] ?? null;
            $ngay_thuc_hien = $_POST['ngay_thuc_hien'] ?? date('Y-m-d H:i:s');
            $noi_dung = $_POST['noi_dung'] ?? '';
            
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
            
            header('Location: ?act=hdv-chi-tiet-lich&lich_id=' . $lich_id . '&hdv_id=' . $hdv_id . '&tab=nhat-ky');
            exit();
        }
    }
    
    // Xóa nhật ký tour
    public static function xoaNhatKy() {
        require_once './models/NhatKyTourModel.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nhat_ky_id = $_POST['nhat_ky_id'] ?? null;
            $lich_id = $_POST['lich_id'] ?? null;
            $hdv_id = $_POST['hdv_id'] ?? null;
            
            if ($nhat_ky_id) {
                $result = NhatKyTourModel::delete($nhat_ky_id);
                
                if ($result) {
                    $_SESSION['success'] = "Xóa nhật ký thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi xóa nhật ký!";
                }
            }
            
            header('Location: ?act=hdv-chi-tiet-lich&lich_id=' . $lich_id . '&hdv_id=' . $hdv_id . '&tab=nhat-ky');
            exit();
        }
    }

}