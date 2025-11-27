<?php
require_once './models/HDVModel.php';
require_once './models/DiemDanhModel.php';

class HDVController {

    public static function lichLamViec($hdv_id) {
        $data = HDVModel::getToursByHDV($hdv_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/lichlamviec.php';
        include './views/layout/footer.php';
    }

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
        $tab = $_GET['tab'] ?? 'lich-lam-viec';
        $lich_id = $_GET['lich_id'] ?? null;
        $search_hdv = $_GET['search_hdv'] ?? null;
        
        // Xử lý hdv_id: nếu là "all" hoặc rỗng, lấy tất cả
        if ($hdv_id === 'all' || $hdv_id === '' || $hdv_id === null) {
            $hdv_id = 'all';
            $hdvInfo = null;
        } else {
            // Lấy thông tin HDV
            $hdvInfo = HDVModel::getHDVById($hdv_id);
        }
        
        // Lấy danh sách tất cả HDV để chọn
        $allHDV = HDVModel::getAllHDV();
        
        // Lấy dữ liệu cho tab lịch làm việc (nhóm theo tên tour)
        $lichLamViecData = HDVModel::getToursByHDVGrouped($hdv_id, $search_hdv);
        
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/quan-ly-hdv.php';
        include './views/layout/footer.php';
    }

}
