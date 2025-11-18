<?php
require_once './models/HDVModel.php';
require_once './models/NhatKyTourModel.php';
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

    public static function nhatKy($hdv_id) {
        $data = NhatKyTourModel::getByHDV($hdv_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/nhatky.php';
        include './views/layout/footer.php';
    }

    public static function formThemNhatKy($hdv_id) {
        // Lấy danh sách tất cả HDV
        $allHDV = HDVModel::getAllHDV();
        
        // Lấy danh sách tour và lịch của HDV (hoặc HDV đầu tiên nếu không có)
        $selectedHDVId = $hdv_id ?? ($allHDV[0]['hdv_id'] ?? 1);
        $toursData = HDVModel::getToursByHDV($selectedHDVId);
        $lichLamViecData = HDVModel::getToursByHDVGrouped($selectedHDVId);
        
        // Lấy danh sách địa điểm
        $diaDiemData = HDVModel::getAllDiaDiem();
        
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-them-nhat-ky.php';
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

    public static function themNhatKy($formData) {
        // Xử lý upload ảnh nếu có
        if (!empty($_FILES['anh_tour']) && $_FILES['anh_tour']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PATH_ROOT . 'img/nhatky/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $ext = pathinfo($_FILES['anh_tour']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('nk_') . '.' . $ext;
            $target = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['anh_tour']['tmp_name'], $target)) {
                // Lưu đường dẫn tương đối để hiển thị từ trang admin (../img/...)
                $formData['anh_tour'] = '../img/nhatky/' . $filename;
            }
        } else {
            $formData['anh_tour'] = null;
        }

        NhatKyTourModel::add($formData);
        header('Location: ?act=hdv-quan-ly&hdv_id=' . $formData['hdv_id'] . '&tab=nhat-ky');
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
        
        // Lấy dữ liệu cho tab nhật ký
        if ($hdv_id !== 'all') {
            $nhatKyData = NhatKyTourModel::getByHDV($hdv_id);
        } else {
            // Lấy tất cả nhật ký của tất cả HDV
            $nhatKyData = NhatKyTourModel::getAll();
        }
        
        // Lấy dữ liệu cho tab yêu cầu đặc biệt
        $yeuCauData = [];
        if ($lich_id) {
            $yeuCauData = HDVModel::getSpecialRequests($lich_id);
        } else {
            // Lấy tất cả yêu cầu từ các tour của HDV
            if ($hdv_id !== 'all') {
                $allTours = HDVModel::getToursByHDV($hdv_id);
                foreach ($allTours as $tour) {
                    $requests = HDVModel::getSpecialRequests($tour['lich_id']);
                    $yeuCauData = array_merge($yeuCauData, $requests);
                }
            }
        }
        
        // Lấy dữ liệu cho tab đánh giá tour
        if ($hdv_id !== 'all') {
            $danhGiaData = NhatKyTourModel::getFeedbackByHDV($hdv_id);
        } else {
            $danhGiaData = [];
        }
        
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/quan-ly-hdv.php';
        include './views/layout/footer.php';
    }

    public static function formSuaNhatKy($nhat_ky_id) {
        $data = NhatKyTourModel::getById($nhat_ky_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-sua-nhat-ky.php';
        include './views/layout/footer.php';
    }

    public static function suaNhatKy($formData) {
        // Lấy bản ghi hiện tại để giữ ảnh cũ khi không upload ảnh mới
        $current = NhatKyTourModel::getById($formData['nhat_ky_id']);

        if (!empty($_FILES['anh_tour']) && $_FILES['anh_tour']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = PATH_ROOT . 'img/nhatky/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $ext = pathinfo($_FILES['anh_tour']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('nk_') . '.' . $ext;
            $target = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['anh_tour']['tmp_name'], $target)) {
                $formData['anh_tour'] = '../img/nhatky/' . $filename;
            } else {
                // nếu không upload được thì giữ ảnh cũ
                $formData['anh_tour'] = $current['anh_tour'] ?? null;
            }
        } else {
            // không có file mới => giữ ảnh cũ
            $formData['anh_tour'] = $current['anh_tour'] ?? null;
        }

        NhatKyTourModel::update($formData);
        header('Location: ?act=hdv-quan-ly&hdv_id=' . $formData['hdv_id'] . '&tab=nhat-ky');
    }

    public static function xoaNhatKy($nhat_ky_id, $hdv_id = null) {
        if (empty($nhat_ky_id)) {
            header('Location: ?act=hdv-quan-ly&hdv_id=' . ($hdv_id ?? '') . '&tab=nhat-ky');
            return;
        }

        // Gọi model để xóa bản ghi và file ảnh (nếu có)
        NhatKyTourModel::delete($nhat_ky_id);

        header('Location: ?act=hdv-quan-ly&hdv_id=' . ($hdv_id ?? '') . '&tab=nhat-ky');
    }

    public static function yeuCauDacBiet($lich_id) {
        $data = HDVModel::getSpecialRequests($lich_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/yeu-cau-dac-biet.php';
        include './views/layout/footer.php';
    }

    public static function formSuaYeuCau($khach_hang_id) {
        $data = HDVModel::getCustomerDetails($khach_hang_id);
        // Lấy lich_id từ GET parameter
        $data['lich_id'] = $_GET['lich_id'] ?? '';
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-sua-yeu-cau.php';
        include './views/layout/footer.php';
    }

    public static function suaYeuCau($formData) {
        HDVModel::updateSpecialRequest($formData);
        $hdv_id = $formData['hdv_id'] ?? $_GET['hdv_id'] ?? '';
        $lich_id = $formData['lich_id'] ?? '';
        header('Location: ?act=hdv-quan-ly&hdv_id=' . $hdv_id . '&tab=yeu-cau-dac-biet&lich_id=' . $lich_id);
    }

    public static function danhGiaTour($hdv_id) {
        // Lấy danh sách tour và lịch của HDV
        $toursData = HDVModel::getToursByHDV($hdv_id);
        $lichLamViecData = HDVModel::getToursByHDVGrouped($hdv_id);
        
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-danh-gia-tour.php';
        include './views/layout/footer.php';
    }

    public static function guiDanhGia($formData) {
        NhatKyTourModel::addFeedback($formData);
        header('Location: ?act=hdv-quan-ly&hdv_id=' . $formData['hdv_id'] . '&tab=danh-gia');
    }
}
