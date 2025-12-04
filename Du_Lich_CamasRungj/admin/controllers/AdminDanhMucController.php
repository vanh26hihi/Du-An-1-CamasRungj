<?php
/**
 * ============================================================================
 * ADMIN DANH MUC CONTROLLER
 * ============================================================================
 * Quản lý Tour (CRUD)
 * - List: Hiển thị danh sách tour
 * - Add: Thêm tour mới (3 tabs: Info, Địa điểm, Lịch trình)
 * - Edit: Sửa tour (3 tabs: Info, Địa điểm, Lịch trình)
 * - Delete: Xóa danh mục tour (không xóa tour - dùng AdminTourController)
 * ============================================================================
 */

require_once 'models/AdminDanhMuc.php';

class AdminDanhMucController
{
    public $model;

    public function __construct()
    {
        $this->model = new AdminDanhMuc();
    }

    // ========================================================================
    // LIST - DANH SÁCH TOUR
    // ========================================================================

    public function listDanhMuc()
    {
        $listDanhMuc = $this->model->getToursWithCategory();
        require 'views/danhmuc/listDanhMuc.php';
    }

    // ========================================================================
    // ADD - THÊM TOUR MỚI
    // ========================================================================

    public function formAddDanhMuc()
    {
        $danhmuc = $this->model->getDanhMuc();
        $diaDiemTour = $this->model->getDiaDiemTour();
        $error = $_SESSION['error'] ?? [];
        $old = $_SESSION['old'] ?? [];
        
        require 'views/danhmuc/addDanhMuc.php';
        deleteSessionError();
    }

    public function postAddDanhMuc()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        // Thu thập dữ liệu
        $ten = $_POST['ten'] ?? '';
        $danh_muc_id = $_POST['danh_muc_id'] ?? '';
        $gia_co_ban = $_POST['gia_co_ban'] ?? '';
        $thoi_luong_mac_dinh = $_POST['thoi_luong_mac_dinh'] ?? '';
        $chinh_sach = $_POST['chinh_sach'] ?? '';
        $diem_khoi_hanh = $_POST['diem_khoi_hanh'] ?? '';
        $mo_ta_ngan = $_POST['mo_ta_ngan'] ?? '';
        $mo_ta = $_POST['mo_ta'] ?? '';
        $dia_diem_id = $_POST['dia_diem_id'] ?? [];
        $thu_tu = $_POST['thu_tu'] ?? [];
        $ghi_chu = $_POST['ghi_chu'] ?? [];
        $ngay = $_POST['ngay'] ?? [];

        // Validation
        $error = $this->validateTourData($ten, $danh_muc_id, $gia_co_ban, $thoi_luong_mac_dinh, 
                                          $chinh_sach, $diem_khoi_hanh, $mo_ta_ngan, $mo_ta, 
                                          $dia_diem_id, $ngay, $thoi_luong_mac_dinh);

        if (!empty($error)) {
            $_SESSION['flash'] = true;
            $_SESSION['error'] = $error;
            $_SESSION['old'] = compact('ten', 'danh_muc_id', 'gia_co_ban', 'thoi_luong_mac_dinh', 
                                       'chinh_sach', 'diem_khoi_hanh', 'mo_ta_ngan', 'mo_ta');
            $_SESSION['old']['dia_diem'] = array_map(function ($id, $tt, $gc) {
                return ['dia_diem_id' => $id, 'thu_tu' => $tt, 'ghi_chu' => $gc];
            }, $dia_diem_id, $thu_tu, $ghi_chu);
            $_SESSION['old']['ngay'] = $ngay;
            
            header("Location: " . BASE_URL_ADMIN . "?act=form-them-danh-muc");
            exit();
        }

        // Insert tour
        $tourId = $this->model->insertTour([
            'ten' => $ten,
            'danh_muc_id' => $danh_muc_id,
            'mo_ta_ngan' => $mo_ta_ngan,
            'mo_ta' => $mo_ta,
            'gia_co_ban' => $gia_co_ban,
            'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
            'chinh_sach' => $chinh_sach,
            'diem_khoi_hanh' => $diem_khoi_hanh
        ]);

        if ($tourId) {
            // Insert địa điểm tour và lấy mapping
            $diaDiemTourIdMap = $this->insertDiaDiemTour($tourId, $dia_diem_id, $thu_tu, $ghi_chu);
            
            // Insert lịch trình với mapping
            $this->insertLichTrinhWithMapping($tourId, $ngay, $diaDiemTourIdMap);

            $_SESSION['success'] = "Thêm tour thành công";
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        $_SESSION['error']['general'] = "Có lỗi khi thêm tour";
        header("Location: " . BASE_URL_ADMIN . "?act=form-them-danh-muc");
        exit();
    }

    // ========================================================================
    // EDIT - SỬA TOUR
    // ========================================================================

    public function formEditDanhMuc()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        $tour = $this->model->getTourById($id);
        
        if (!$tour) {
            $_SESSION['error'] = "Không tìm thấy tour";
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        $danhmuc = $this->model->getDanhMuc();
        $diaDiemTour = $this->model->getDiaDiemTour();
        $tourDiaDiem = $this->model->getDiaDiemTourByTour($id);
        $lichTrinhList = $this->model->getLichTrinhByTour($id);
        $error = $_SESSION['error'] ?? [];
        $old = $_SESSION['old'] ?? [];

        require 'views/danhmuc/editDanhMuc.php';
        deleteSessionError();
    }

    public function postEditDanhMuc()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "Thiếu ID tour";
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        $tour = $this->model->getTourById($id);
        if (!$tour) {
            $_SESSION['error'] = "Không tìm thấy tour";
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        // Thu thập dữ liệu
        $ten = $_POST['ten'] ?? '';
        $danh_muc_id = $_POST['danh_muc_id'] ?? '';
        $gia_co_ban = $_POST['gia_co_ban'] ?? '';
        $thoi_luong_mac_dinh = $_POST['thoi_luong_mac_dinh'] ?? '';
        $chinh_sach = $_POST['chinh_sach'] ?? '';
        $diem_khoi_hanh = $_POST['diem_khoi_hanh'] ?? '';
        $mo_ta_ngan = $_POST['mo_ta_ngan'] ?? '';
        $mo_ta = $_POST['mo_ta'] ?? '';
        $dia_diem_id = $_POST['dia_diem_id'] ?? [];
        $thu_tu = $_POST['thu_tu'] ?? [];
        $ghi_chu = $_POST['ghi_chu'] ?? [];
        $ngay = $_POST['ngay'] ?? [];

        // Validation
        $error = $this->validateTourData($ten, $danh_muc_id, $gia_co_ban, $thoi_luong_mac_dinh, 
                                          $chinh_sach, $diem_khoi_hanh, $mo_ta_ngan, $mo_ta, 
                                          $dia_diem_id, $ngay, $thoi_luong_mac_dinh, false);

        if (!empty($error)) {
            $_SESSION['flash'] = true;
            $_SESSION['error'] = $error;
            $_SESSION['old'] = compact('ten', 'danh_muc_id', 'gia_co_ban', 'thoi_luong_mac_dinh', 
                                       'chinh_sach', 'diem_khoi_hanh', 'mo_ta_ngan', 'mo_ta');
            $_SESSION['old']['dia_diem'] = array_map(function ($id, $tt, $gc) {
                return ['dia_diem_id' => $id, 'thu_tu' => $tt, 'ghi_chu' => $gc];
            }, $dia_diem_id, $thu_tu, $ghi_chu);
            $_SESSION['old']['ngay'] = $ngay;
            
            header("Location: " . BASE_URL_ADMIN . "?act=form-sua-danh-muc&id=$id");
            exit();
        }

        // Update tour
        $this->model->updateTour($id, [
            'ten' => $ten,
            'danh_muc_id' => $danh_muc_id,
            'mo_ta_ngan' => $mo_ta_ngan,
            'mo_ta' => $mo_ta,
            'gia_co_ban' => $gia_co_ban,
            'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
            'chinh_sach' => $chinh_sach,
            'diem_khoi_hanh' => $diem_khoi_hanh
        ]);

        // Delete & re-insert địa điểm tour
        $this->model->deleteDiaDiemTourByTour($id);
        $diaDiemTourIdMap = $this->insertDiaDiemTour($id, $dia_diem_id, $thu_tu, $ghi_chu);

        // Delete & re-insert lịch trình
        $this->model->deleteLichTrinhByTour($id);
        $this->insertLichTrinhWithMapping($id, $ngay, $diaDiemTourIdMap);

        $_SESSION['success'] = "Cập nhật tour thành công";
        header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
        exit();
    }

    // ========================================================================
    // DELETE - XÓA DANH MỤC TOUR (KHÔNG XÓA TOUR)
    // ========================================================================

    public function deleteDanhMuc()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "Thiếu ID danh mục";
            header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit();
        }

        $result = $this->model->destroyDanhMuc($id);
        
        if ($result) {
            $_SESSION['success'] = "Xóa danh mục thành công";
        } else {
            $_SESSION['error'] = "Có lỗi khi xóa danh mục";
        }
        
        header("Location: " . BASE_URL_ADMIN . '?act=danh-muc-tour');
        exit();
    }

    // ========================================================================
    // HELPER METHODS
    // ========================================================================

    private function validateTourData($ten, $danh_muc_id, $gia_co_ban, $thoi_luong_mac_dinh, 
                                      $chinh_sach, $diem_khoi_hanh, $mo_ta_ngan, $mo_ta, 
                                      $dia_diem_id, $ngay, $expected_days, $is_create = true)
    {
        $error = [];

        if (empty($ten)) {
            $error['ten'] = "Tên tour không được để trống";
        }

        if (empty($danh_muc_id)) {
            $error['danh_muc_id'] = "Vui lòng chọn danh mục";
        }

        if (empty($gia_co_ban) || !is_numeric($gia_co_ban) || $gia_co_ban <= 0) {
            $error['gia_co_ban'] = "Giá cơ bản phải là số dương";
        }

        if (empty($thoi_luong_mac_dinh) || !is_numeric($thoi_luong_mac_dinh) || $thoi_luong_mac_dinh <= 0) {
            $error['thoi_luong_mac_dinh'] = "Thời lượng phải là số dương";
        }

        if (empty($diem_khoi_hanh)) {
            $error['diem_khoi_hanh'] = "Điểm khởi hành không được để trống";
        }

        if (empty($dia_diem_id) || !is_array($dia_diem_id)) {
            $error['dia_diem'] = "Vui lòng chọn ít nhất một địa điểm";
        }

        if (empty($ngay) || !is_array($ngay)) {
            $error['ngay'] = "Vui lòng thêm ít nhất một lịch trình";
        } elseif (count($ngay) != $expected_days) {
            $error['ngay'] = "Số ngày lịch trình phải bằng thời lượng tour ($expected_days ngày)";
        }

        return $error;
    }

    private function insertDiaDiemTour($tour_id, $dia_diem_ids, $thu_tus, $ghi_chus)
    {
        $mapping = [];
        foreach ($dia_diem_ids as $index => $dia_diem_id) {
            $thu_tu = $thu_tus[$index] ?? $index + 1;
            $ghi_chu = $ghi_chus[$index] ?? '';
            
            $dia_diem_tour_id = $this->model->insertDiaDiemTour([
                'tour_id' => $tour_id,
                'dia_diem_id' => $dia_diem_id,
                'thu_tu' => $thu_tu,
                'ghi_chu' => $ghi_chu
            ]);
            
            $mapping[$index] = $dia_diem_tour_id;
        }
        return $mapping;
    }

    private function insertLichTrinhWithMapping($tour_id, $ngays, $dia_diem_tour_id_map)
    {
        foreach ($ngays as $ngay_thu => $ngay_data) {
            $dia_diem_tour_index = $ngay_data['dia_diem_tour_index'] ?? 0;
            $dia_diem_tour_id = $dia_diem_tour_id_map[$dia_diem_tour_index] ?? null;
            
            if ($dia_diem_tour_id) {
                $this->model->insertLichTrinh([
                    'tour_id' => $tour_id,
                    'ngay_thu' => $ngay_thu,
                    'tieu_de' => $ngay_data['tieu_de'] ?? '',
                    'mo_ta' => $ngay_data['mo_ta'] ?? '',
                    'dia_diem_tour_id' => $dia_diem_tour_id
                ]);
            }
        }
    }
}
?>