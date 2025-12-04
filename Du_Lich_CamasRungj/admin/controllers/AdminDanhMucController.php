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
    // HELPER METHODS - PRIVATE
    // ========================================================================

    /**
     * Validate dữ liệu tour
     */
    private function validateTourData($ten, $danh_muc_id, $gia_co_ban, $thoi_luong_mac_dinh, 
                                      $chinh_sach, $diem_khoi_hanh, $mo_ta_ngan, $mo_ta, 
                                      $dia_diem_id, $ngay, $thoi_luong, $requireFullSchedule = true)
    {
        $error = [];

        // Tab 1: Thông tin cơ bản
        if (empty($ten)) $error['ten'] = "Tên tour không được để trống";
        if (empty($danh_muc_id)) $error['danh_muc_id'] = "Vui lòng chọn loại tour";
        if (empty($gia_co_ban)) $error['gia_co_ban'] = "Giá cơ bản không được để trống";
        if (empty($thoi_luong_mac_dinh)) $error['thoi_luong_mac_dinh'] = "Số ngày du lịch không được để trống";
        if (empty($chinh_sach)) $error['chinh_sach'] = "Chính sách không được để trống";
        if (empty($diem_khoi_hanh)) $error['diem_khoi_hanh'] = "Điểm khởi hành không được để trống";
        if (empty($mo_ta_ngan)) $error['mo_ta_ngan'] = "Mô tả ngắn không được để trống";
        if (empty($mo_ta)) $error['mo_ta'] = "Mô tả không được để trống";

        // Tab 2: Địa điểm
        if (empty($dia_diem_id) || count(array_filter($dia_diem_id)) === 0) {
            $error['dia_diem'] = "Vui lòng chọn ít nhất 1 địa điểm";
        } else {
            foreach ($dia_diem_id as $idx => $dd_id) {
                if (empty($dd_id)) {
                    $error['dia_diem_' . $idx] = "Địa điểm " . ($idx + 1) . " chưa được chọn";
                }
            }
        }

        // Tab 3: Lịch trình
        if (empty($ngay) || count($ngay) === 0) {
            $error['lich_trinh'] = "Vui lòng tạo lịch trình cho tour";
        } else {
            $soNgay = count($ngay);
            
            // Kiểm tra không vượt quá
            if ($soNgay > $thoi_luong) {
                $error['lich_trinh'] = "Số ngày trong lịch trình ($soNgay) không được vượt quá số ngày du lịch ($thoi_luong ngày)";
            }
            
            // Kiểm tra phải đủ số ngày (chỉ áp dụng khi thêm mới)
            if ($requireFullSchedule && $soNgay < $thoi_luong) {
                $error['lich_trinh'] = "Lịch trình chỉ có $soNgay ngày, cần đủ $thoi_luong ngày";
            }
            
            // Validate từng ngày
            foreach ($ngay as $ngayIndex => $ngayData) {
                $ngayThu = $ngayData['ngay_thu'] ?? '';
                $diaDiemTourId = $ngayData['dia_diem_tour_id'] ?? '';
                $lichTrinhList = $ngayData['lich_trinh'] ?? [];
                
                if (empty($ngayThu)) {
                    $error["ngay_{$ngayIndex}_ngay_thu"] = "Ngày thứ không được để trống";
                }
                
                if (!isset($diaDiemTourId) || $diaDiemTourId === '') {
                    $error["ngay_{$ngayIndex}_dia_diem"] = "Vui lòng chọn địa điểm cho Ngày $ngayThu";
                }
                
                if (empty($lichTrinhList)) {
                    $error["ngay_{$ngayIndex}_hoat_dong"] = "Ngày $ngayThu phải có ít nhất 1 hoạt động";
                } else {
                    foreach ($lichTrinhList as $ltIndex => $lt) {
                        $gioBatDau = $lt['gio_bat_dau'] ?? '';
                        $gioKetThuc = $lt['gio_ket_thuc'] ?? '';
                        $noiDung = $lt['noi_dung'] ?? '';
                        
                        if (empty($gioBatDau)) {
                            $error["ngay_{$ngayIndex}_lt_{$ltIndex}_gio_bat_dau"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ bắt đầu không được để trống";
                        }
                        
                        if (empty($gioKetThuc)) {
                            $error["ngay_{$ngayIndex}_lt_{$ltIndex}_gio_ket_thuc"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ kết thúc không được để trống";
                        }
                        
                        if (empty($noiDung)) {
                            $error["ngay_{$ngayIndex}_lt_{$ltIndex}_noi_dung"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Nội dung không được để trống";
                        } elseif (strlen($noiDung) < 10) {
                            $error["ngay_{$ngayIndex}_lt_{$ltIndex}_noi_dung"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Nội dung quá ngắn (tối thiểu 10 ký tự)";
                        }
                        
                        if (!empty($gioBatDau) && !empty($gioKetThuc) && $gioKetThuc <= $gioBatDau) {
                            $error["ngay_{$ngayIndex}_lt_{$ltIndex}_thoi_gian"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ kết thúc phải sau giờ bắt đầu";
                        }
                    }
                }
            }
        }

        return $error;
    }

    /**
     * Insert địa điểm tour với mapping
     */
    private function insertDiaDiemTour($tourId, $dia_diem_id, $thu_tu, $ghi_chu)
    {
        $diaDiemTourIdMap = [];
        
        foreach ($dia_diem_id as $idx => $dd_id) {
            if (!empty($dd_id)) {
                $insertedId = $this->model->insertDiaDiemTour([
                    'tour_id' => $tourId,
                    'dia_diem_id' => $dd_id,
                    'thu_tu' => $thu_tu[$idx] ?? ($idx + 1),
                    'ghi_chu' => $ghi_chu[$idx] ?? ''
                ]);
                
                $diaDiemTourIdMap[$idx] = $insertedId;
            }
        }
        
        return $diaDiemTourIdMap;
    }

    /**
     * Insert lịch trình với mapping dia_diem_tour_id
     */
    private function insertLichTrinhWithMapping($tourId, $ngay, $diaDiemTourIdMap)
    {
        foreach ($ngay as $ngayIndex => $ngayData) {
            if (isset($ngayData['ngay_thu']) && $ngayData['ngay_thu'] != '' 
                && isset($ngayData['dia_diem_tour_id']) && $ngayData['dia_diem_tour_id'] !== ''
                && !empty($ngayData['lich_trinh'])) {
                
                $diaDiemIndex = $ngayData['dia_diem_tour_id'];
                $diaDiemTourId = $diaDiemTourIdMap[$diaDiemIndex] ?? null;
                
                if (!$diaDiemTourId) {
                    continue;
                }
                
                foreach ($ngayData['lich_trinh'] as $lt) {
                    if (!empty($lt['gio_bat_dau']) && !empty($lt['gio_ket_thuc']) && !empty($lt['noi_dung'])) {
                        $this->model->insertLichTrinh([
                            'tour_id' => $tourId,
                            'ngay_thu' => $ngayData['ngay_thu'],
                            'gio_bat_dau' => $lt['gio_bat_dau'],
                            'gio_ket_thuc' => $lt['gio_ket_thuc'],
                            'dia_diem_tour_id' => $diaDiemTourId,
                            'noi_dung' => $lt['noi_dung']
                        ]);
                    }
                }
            }
        }
    }
}