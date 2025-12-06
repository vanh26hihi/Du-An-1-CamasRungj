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

        // DEBUG: Xem dữ liệu POST
        error_log("=== POST DATA ===");
        error_log(print_r($_POST, true));

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

        // DEBUG: Xem dữ liệu ngày
        error_log("=== NGAY DATA ===");
        error_log(print_r($ngay, true));

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

        // Chuẩn bị dữ liệu địa điểm để load vào form
        $initialDiaDiem = [];
        if (!empty($old['dia_diem'])) {
            // Nếu có lỗi validation, load từ session old
            $initialDiaDiem = $old['dia_diem'];
        } elseif (!empty($tourDiaDiem)) {
            // Load dữ liệu từ database - PHẢI CÓ dia_diem_tour_id
            foreach ($tourDiaDiem as $dd) {
                $initialDiaDiem[] = [
                    'dia_diem_tour_id' => $dd['dia_diem_tour_id'],
                    'dia_diem_id' => $dd['dia_diem_id'],
                    'thu_tu' => $dd['thu_tu'],
                    'ghi_chu' => $dd['ghi_chu']
                ];
            }
        }

        // Chuẩn bị dữ liệu lịch trình để load vào form
        if (!empty($old['ngay'])) {
            // Nếu có lỗi validation, load từ session old
            $lichTrinhList = [];
            foreach ($old['ngay'] as $ngayIdx => $ngayData) {
                foreach ($ngayData['schedules'] as $schedule) {
                    $lichTrinhList[] = [
                        'ngay_thu' => $ngayIdx + 1,
                        'gio_bat_dau' => $schedule['gio_bat_dau'] ?? '',
                        'gio_ket_thuc' => $schedule['gio_ket_thuc'] ?? '',
                        'noi_dung' => $schedule['noi_dung'] ?? '',
                        'dia_diem_tour_id' => $ngayData['dia_diem_tour_id'] ?? null
                    ];
                }
            }
        }
        // else: $lichTrinhList đã được load từ DB ở trên

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
        $dia_diem = $_POST['dia_diem'] ?? [];
        $ngay = $_POST['ngay'] ?? [];

        // Extract arrays for validation (backward compatible)
        $dia_diem_id = array_column($dia_diem, 'dia_diem_id');
        $thu_tu = array_column($dia_diem, 'thu_tu');
        $ghi_chu = array_column($dia_diem, 'ghi_chu');

        // Validation
        $error = $this->validateTourData($ten, $danh_muc_id, $gia_co_ban, $thoi_luong_mac_dinh, 
                                          $chinh_sach, $diem_khoi_hanh, $mo_ta_ngan, $mo_ta, 
                                          $dia_diem_id, $ngay, $thoi_luong_mac_dinh, false);

        if (!empty($error)) {
            $_SESSION['flash'] = true;
            $_SESSION['error'] = $error;
            $_SESSION['old'] = compact('ten', 'danh_muc_id', 'gia_co_ban', 'thoi_luong_mac_dinh', 
                                       'chinh_sach', 'diem_khoi_hanh', 'mo_ta_ngan', 'mo_ta');
            $_SESSION['old']['dia_diem'] = $dia_diem;
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

        // === SMART UPDATE/DELETE/INSERT ĐỊA ĐIỂM ===
        $existingDiaDiem = $this->model->getDiaDiemTourByTour($id);
        $existingIds = array_column($existingDiaDiem, 'dia_diem_tour_id');
        $submittedIds = array_filter(array_column($dia_diem, 'dia_diem_tour_id'));
        
        // DELETE: Xóa địa điểm không còn trong form
        $idsToDelete = array_diff($existingIds, $submittedIds);
        foreach ($idsToDelete as $deleteId) {
            $this->model->deleteDiaDiemTourById($deleteId);
        }

        // UPDATE/INSERT địa điểm
        $diaDiemTourIdMap = [];
        foreach ($dia_diem as $index => $dd) {
            if (!empty($dd['dia_diem_tour_id'])) {
                // UPDATE existing
                $this->model->updateDiaDiemTour($dd['dia_diem_tour_id'], [
                    'dia_diem_id' => $dd['dia_diem_id'],
                    'thu_tu' => $dd['thu_tu'],
                    'ghi_chu' => $dd['ghi_chu']
                ]);
                $diaDiemTourIdMap[$index] = $dd['dia_diem_tour_id'];
            } else {
                // INSERT new
                $newId = $this->model->insertDiaDiemTour([
                    'tour_id' => $id,
                    'dia_diem_id' => $dd['dia_diem_id'],
                    'thu_tu' => $dd['thu_tu'],
                    'ghi_chu' => $dd['ghi_chu']
                ]);
                $diaDiemTourIdMap[$index] = $newId;
            }
        }

        // === SMART UPDATE/DELETE/INSERT LỊCH TRÌNH ===
        $existingLichTrinh = $this->model->getLichTrinhByTour($id);
        $existingLichTrinhIds = array_column($existingLichTrinh, 'lich_trinh_id');
        
        // Thu thập tất cả lich_trinh_id được submit
        $submittedLichTrinhIds = [];
        foreach ($ngay as $ngayData) {
            if (isset($ngayData['lich_trinh']) && is_array($ngayData['lich_trinh'])) {
                foreach ($ngayData['lich_trinh'] as $lt) {
                    if (!empty($lt['lich_trinh_id'])) {
                        $submittedLichTrinhIds[] = $lt['lich_trinh_id'];
                    }
                }
            }
        }
        
        // DELETE: Xóa lịch trình không còn trong form
        $lichTrinhIdsToDelete = array_diff($existingLichTrinhIds, $submittedLichTrinhIds);
        foreach ($lichTrinhIdsToDelete as $deleteId) {
            $this->model->deleteLichTrinhById($deleteId);
        }

        // UPDATE/INSERT lịch trình
        foreach ($ngay as $ngayIndex => $ngayData) {
            $diaDiemTourId = $diaDiemTourIdMap[$ngayData['dia_diem_tour_id']] ?? null;
            
            if (isset($ngayData['lich_trinh']) && is_array($ngayData['lich_trinh'])) {
                foreach ($ngayData['lich_trinh'] as $ltItem) {
                    if (!empty($ltItem['lich_trinh_id'])) {
                        // UPDATE existing
                        $this->model->updateLichTrinh($ltItem['lich_trinh_id'], [
                            'ngay_thu' => $ngayIndex + 1,
                            'gio_bat_dau' => $ltItem['gio_bat_dau'],
                            'gio_ket_thuc' => $ltItem['gio_ket_thuc'],
                            'dia_diem_tour_id' => $diaDiemTourId,
                            'noi_dung' => $ltItem['noi_dung']
                        ]);
                    } else {
                        // INSERT new
                        $this->model->insertLichTrinh([
                            'tour_id' => $id,
                            'ngay_thu' => $ngayIndex + 1,
                            'gio_bat_dau' => $ltItem['gio_bat_dau'],
                            'gio_ket_thuc' => $ltItem['gio_ket_thuc'],
                            'dia_diem_tour_id' => $diaDiemTourId,
                            'noi_dung' => $ltItem['noi_dung']
                        ]);
                    }
                }
            }
        }

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
        error_log("=== INSERT LICH TRINH ===");
        error_log("Tour ID: " . $tour_id);
        error_log("Ngays data: " . print_r($ngays, true));
        error_log("Map: " . print_r($dia_diem_tour_id_map, true));

        if (empty($ngays) || !is_array($ngays)) {
            error_log("ERROR: Ngays empty or not array");
            return;
        }

        foreach ($ngays as $ngay_thu => $ngay_data) {
            error_log("Processing ngay_thu: $ngay_thu");
            error_log("Ngay data: " . print_r($ngay_data, true));

            if (!is_array($ngay_data)) {
                error_log("ERROR: Ngay data not array");
                continue;
            }

            // Lấy dia_diem_tour_id từ form (có thể là index hoặc ID trực tiếp)
            $dia_diem_tour_id = null;
            
            if (isset($ngay_data['dia_diem_tour_id'])) {
                // Nếu form gửi dia_diem_tour_id trực tiếp
                $dia_diem_tour_id = $ngay_data['dia_diem_tour_id'];
                error_log("Found dia_diem_tour_id: $dia_diem_tour_id");
            } elseif (isset($ngay_data['dia_diem_tour_index'])) {
                // Nếu form gửi index, map từ array
                $dia_diem_tour_index = $ngay_data['dia_diem_tour_index'];
                $dia_diem_tour_id = $dia_diem_tour_id_map[$dia_diem_tour_index] ?? null;
                error_log("Found index: $dia_diem_tour_index, mapped to ID: $dia_diem_tour_id");
            } else {
                error_log("ERROR: No dia_diem_tour_id or index found");
            }

            // Xử lý lịch trình chi tiết
            if (isset($ngay_data['lich_trinh']) && is_array($ngay_data['lich_trinh'])) {
                error_log("Found lich_trinh array with " . count($ngay_data['lich_trinh']) . " items");
                
                foreach ($ngay_data['lich_trinh'] as $lt_index => $lich_trinh) {
                    error_log("Processing lich_trinh $lt_index: " . print_r($lich_trinh, true));
                    
                    if (!is_array($lich_trinh)) {
                        error_log("ERROR: Lich trinh not array");
                        continue;
                    }

                    $insertData = [
                        'tour_id' => $tour_id,
                        'ngay_thu' => $ngay_data['ngay_thu'] ?? $ngay_thu,
                        'gio_bat_dau' => $lich_trinh['gio_bat_dau'] ?? null,
                        'gio_ket_thuc' => $lich_trinh['gio_ket_thuc'] ?? null,
                        'dia_diem_tour_id' => $dia_diem_tour_id,
                        'noi_dung' => $lich_trinh['noi_dung'] ?? ''
                    ];
                    
                    error_log("Inserting: " . print_r($insertData, true));
                    $result = $this->model->insertLichTrinh($insertData);
                    error_log("Insert result: " . ($result ? "SUCCESS (ID: $result)" : "FAILED"));
                }
            } else {
                error_log("ERROR: No lich_trinh found in ngay_data");
            }
        }
    }

    // ========================================================================
    // DETAIL - XEM CHI TIẾT TOUR
    // ========================================================================

    public function chiTietDanhMuc()
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

        $tourDiaDiem = $this->model->getDiaDiemTourByTour($id);
        $lichTrinhList = $this->model->getLichTrinhByTour($id);

        require 'views/danhmuc/chiTietDanhMuc.php';
    }
}
?>