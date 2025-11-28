<?php
require_once './models/HDVModel.php';
require_once './models/DiemDanhModel.php';

class HDVController {

    public static function danhSachKhach($lich_id) {
        $data = HDVModel::getPassengersByLich($lich_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/danhsachkhach.php';
        include './views/layout/footer.php';
    }

    
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


    public static function diemDanh($lich_id, $hdv_id) {
        $data = DiemDanhModel::getCustomersForAttendance($lich_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/diemdanh.php';
        include './views/layout/footer.php';
    }

    public static function diemDanhAction($hanh_khach_id, $lich_id, $hdv_id) {
        // Toggle trạng thái điểm danh
        DiemDanhModel::toggleAttendance($hanh_khach_id, $lich_id, $hdv_id);
        header('Location: ?act=hdv-diem-danh&lich_id=' . $lich_id . '&hdv_id=' . $hdv_id);
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

}
