<?php
require_once 'models/AdminDanhMuc.php';
class AdminDanhMucController
{
    public $model;
    public function __construct()
    {
        $this->model = new AdminDanhMuc(); //gọi model
    }

    //hiển thị danh mục
    public function listDanhMuc()
    {
        // Lấy danh sách tour kèm thông tin danh mục để hiển thị
        $listDanhMuc = $this->model->getToursWithCategory();
        require 'views/danhmuc/listDanhMuc.php';
    }
    // thêm danh mục 
    public function formAddDanhMuc()
    {
        $danhmuc = $this->model->getDanhMuc();
        $diaDiemTour = $this->model->getDiaDiemTour();
        $error = $_SESSION['error'] ?? [];
        $old = $_SESSION['old'] ?? [];
        require 'views/danhmuc/addDanhMuc.php';
        deleteSessionError();
    }
    // xử lí thêm danh mục

    public function postAddDanhMuc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            $lich_trinh = $_POST['lich_trinh'] ?? [];
            $ngay = $_POST['ngay'] ?? []; // Dữ liệu mới: mảng ngày

            // Validate Tab 1
            $error = [];
            if (empty($ten)) {
                $error['ten'] = "Tên danh mục không được để trống";
            }
            if (empty($danh_muc_id)) {
                $error['danh_muc_id'] = "Vui lòng chọn loại tour";
            }
            if (empty($gia_co_ban)) {
                $error['gia_co_ban'] = "Giá cơ bản không được để trống";
            }
            if (empty($thoi_luong_mac_dinh)) {
                $error['thoi_luong_mac_dinh'] = "Số ngày du lịch không được để trống";
            }
            if (empty($chinh_sach)) {
                $error['chinh_sach'] = "Chính sách không được để trống";
            }
            if (empty($diem_khoi_hanh)) {
                $error['diem_khoi_hanh'] = "Điểm khởi hành không được để trống";
            }
            if (empty($mo_ta_ngan)) {
                $error['mo_ta_ngan'] = "Mô tả ngắn không được để trống";
            }
            if (empty($mo_ta)) {
                $error['mo_ta'] = "Mô tả không được để trống";
            }

            // Validate Tab 2
            if (empty($dia_diem_id) || count(array_filter($dia_diem_id)) === 0) {
                $error['dia_diem'] = "Vui lòng chọn ít nhất 1 địa điểm";
            } else {
                foreach ($dia_diem_id as $idx => $dd_id) {
                    if (empty($dd_id)) {
                        $error['dia_diem_' . $idx] = "Địa điểm " . ($idx + 1) . " chưa được chọn";
                    }
                }
            }

            // Validate Tab 3: Lịch trình
            if (empty($ngay) || count($ngay) === 0) {
                $error['lich_trinh'] = "Vui lòng tạo lịch trình cho tour (nhập 'Số Ngày Du Lịch' ở 'Thông Tin Danh Mục Tour')";
            } else {
                $soNgay = count($ngay);
                
                // Kiểm tra số ngày không vượt quá thời lượng
                if ($soNgay > $thoi_luong_mac_dinh) {
                    $error['lich_trinh'] = "Số ngày trong lịch trình ($soNgay) không được vượt quá số ngày du lịch ($thoi_luong_mac_dinh ngày)";
                }
                
                // Kiểm tra số ngày phải đủ
                if ($soNgay < $thoi_luong_mac_dinh) {
                    $error['lich_trinh'] = "Lịch trình chỉ có $soNgay ngày, cần đủ $thoi_luong_mac_dinh ngày";
                }
                
                // Validate từng ngày
                foreach ($ngay as $ngayIndex => $ngayData) {
                    $ngayThu = $ngayData['ngay_thu'] ?? '';
                    $diaDiemTourId = $ngayData['dia_diem_tour_id'] ?? '';
                    $lichTrinhList = $ngayData['lich_trinh'] ?? [];
                    
                    // Kiểm tra ngày thứ
                    if (empty($ngayThu)) {
                        $error["ngay_{$ngayIndex}_ngay_thu"] = "Ngày thứ không được để trống";
                    }
                    
                    // Kiểm tra địa điểm
                    if (!isset($diaDiemTourId) || $diaDiemTourId === '') {
                        $error["ngay_{$ngayIndex}_dia_diem"] = "Vui lòng chọn địa điểm cho Ngày $ngayThu";
                    }
                    
                    // Kiểm tra có ít nhất 1 hoạt động
                    if (empty($lichTrinhList) || count($lichTrinhList) === 0) {
                        $error["ngay_{$ngayIndex}_hoat_dong"] = "Ngày $ngayThu phải có ít nhất 1 hoạt động";
                    } else {
                        // Validate từng hoạt động trong ngày
                        foreach ($lichTrinhList as $ltIndex => $lt) {
                            $gioBatDau = $lt['gio_bat_dau'] ?? '';
                            $gioKetThuc = $lt['gio_ket_thuc'] ?? '';
                            $noiDung = $lt['noi_dung'] ?? '';
                            
                            // Kiểm tra giờ bắt đầu
                            if (empty($gioBatDau)) {
                                $error["ngay_{$ngayIndex}_lt_{$ltIndex}_gio_bat_dau"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ bắt đầu không được để trống";
                            }
                            
                            // Kiểm tra giờ kết thúc
                            if (empty($gioKetThuc)) {
                                $error["ngay_{$ngayIndex}_lt_{$ltIndex}_gio_ket_thuc"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ kết thúc không được để trống";
                            }
                            
                            // Kiểm tra nội dung
                            if (empty($noiDung)) {
                                $error["ngay_{$ngayIndex}_lt_{$ltIndex}_noi_dung"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Nội dung không được để trống";
                            } elseif (strlen($noiDung) < 10) {
                                $error["ngay_{$ngayIndex}_lt_{$ltIndex}_noi_dung"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Nội dung quá ngắn (tối thiểu 10 ký tự)";
                            }
                            
                            // Kiểm tra logic thời gian: giờ kết thúc phải sau giờ bắt đầu
                            if (!empty($gioBatDau) && !empty($gioKetThuc)) {
                                if ($gioKetThuc <= $gioBatDau) {
                                    $error["ngay_{$ngayIndex}_lt_{$ltIndex}_thoi_gian"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ kết thúc phải sau giờ bắt đầu";
                                }
                            }
                        }
                    }
                }
            }

            // Nếu có lỗi, lưu session và redirect
            if (!empty($error)) {
                $_SESSION['flash'] = true;
                $_SESSION['error'] = $error;
                $_SESSION['old'] = [
                    'ten' => $ten,
                    'danh_muc_id' => $danh_muc_id,
                    'gia_co_ban' => $gia_co_ban,
                    'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
                    'chinh_sach' => $chinh_sach,
                    'diem_khoi_hanh' => $diem_khoi_hanh,
                    'mo_ta_ngan' => $mo_ta_ngan,
                    'mo_ta' => $mo_ta,
                    'dia_diem' => array_map(function ($id, $tt, $gc) {
                        return ['dia_diem_id' => $id, 'thu_tu' => $tt, 'ghi_chu' => $gc];
                    }, $dia_diem_id, $thu_tu, $ghi_chu)
                ];
                header('Location: ' . BASE_URL_ADMIN . '?act=form-them-danh-muc');
                exit;
            }

            // Insert tour vào bảng tour
            $tourData = [
                'ten' => $ten,
                'danh_muc_id' => $danh_muc_id,
                'mo_ta_ngan' => $mo_ta_ngan,
                'mo_ta' => $mo_ta,
                'gia_co_ban' => $gia_co_ban,
                'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
                'chinh_sach' => $chinh_sach,
                'diem_khoi_hanh' => $diem_khoi_hanh
            ];
            $tourId = $this->model->insertTour($tourData);

            // Insert địa điểm cho tour
            if ($tourId) {
                foreach ($dia_diem_id as $idx => $dd_id) {
                    if (!empty($dd_id)) {
                        $this->model->insertDiaDiemTour([
                            'tour_id' => $tourId,
                            'dia_diem_id' => $dd_id,
                            'thu_tu' => $thu_tu[$idx] ?? ($idx + 1),
                            'ghi_chu' => $ghi_chu[$idx] ?? ''
                        ]);
                    }
                }

                // Insert lịch trình theo cấu trúc mới
                // Cấu trúc: ngay[index] = { ngay_thu, dia_diem_tour_id, lich_trinh[ltIndex] = { gio_bat_dau, gio_ket_thuc, noi_dung } }
                foreach ($ngay as $ngayIndex => $ngayData) {
                    // Fix: isset() thay vì !empty() để xử lý giá trị 0 (index đầu tiên)
                    if (isset($ngayData['ngay_thu']) && $ngayData['ngay_thu'] != '' 
                        && isset($ngayData['dia_diem_tour_id']) && $ngayData['dia_diem_tour_id'] !== ''
                        && !empty($ngayData['lich_trinh'])) {
                        
                        // Lấy dia_diem_tour_id thực tế từ index
                        $diaDiemTourId = $this->model->getDiaDiemTourIdByIndex($tourId, $ngayData['dia_diem_tour_id']);
                        
                        // Insert từng lịch trình trong ngày
                        foreach ($ngayData['lich_trinh'] as $ltIndex => $lt) {
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

                unset($_SESSION['error']);
                unset($_SESSION['old']);
                unset($_SESSION['flash']);

                header('Location: ?act=danh-muc-tour');
                exit;
            }
        }
    }
    // sửa danh mục
    public function formEditDanhMuc()
    {
        $id = $_GET['id'] ?? null;
        $error = $_SESSION['error'] ?? [];
        $old = $_SESSION['old'] ?? [];

        // Nếu tồn tại tour với id này, hiển thị form chỉnh sửa tour (giống add nhưng đổ sẵn dữ liệu)
        $tour = $this->model->getTourById($id);
        if ($tour) {
            $danhmuc = $this->model->getDanhMuc(); // danh sách loại tour để select
            $diaDiemTour = $this->model->getDiaDiemTour(); // danh sách dia_diem để chọn
            $tourDiaDiem = $this->model->getDiaDiemTourByTour($id); // các địa điểm đã gắn với tour
            $lichTrinhList = $this->model->getLichTrinhByTour($id); // lịch trình của tour
            require 'views/danhmuc/editDanhMuc.php';
            deleteSessionError();
            return;
        }

        // Nếu không phải là tour (giữ hành vi cũ: chỉnh sửa bản ghi danh_muc)
        $danhmuc = $this->model->getDanhMucID($id);
        require 'views/danhmuc/editDanhMuc.php';
    }
    //xử lí sửa danh mục

    public function postEditDanhMuc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // DEBUG: Ghi log ngay khi vào POST
            file_put_contents(__DIR__ . '/../../debug_edit.txt', 
                date('Y-m-d H:i:s') . " - POST REQUEST RECEIVED\n",
                FILE_APPEND
            );

            $id = $_POST['id'] ?? null;

            // Kiểm tra xem có phải tour hay category
            $tour = $this->model->getTourById($id);

            // Nếu là tour, xử lý như form add (với Tab 1 + Tab 2 + Tab 3)
            if ($tour) {
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
                $ngay = $_POST['ngay'] ?? []; // NEW: Cấu trúc ngày giống addDanhMuc

                // Validate Tab 1
                $error = [];
                if (empty($ten)) {
                    $error['ten'] = "Tên danh mục không được để trống";
                }
                if (empty($danh_muc_id)) {
                    $error['danh_muc_id'] = "Vui lòng chọn loại tour";
                }
                if (empty($gia_co_ban)) {
                    $error['gia_co_ban'] = "Giá cơ bản không được để trống";
                }
                if (empty($thoi_luong_mac_dinh)) {
                    $error['thoi_luong_mac_dinh'] = "Số ngày du lịch không được để trống";
                }
                if (empty($chinh_sach)) {
                    $error['chinh_sach'] = "Chính sách không được để trống";
                }
                if (empty($diem_khoi_hanh)) {
                    $error['diem_khoi_hanh'] = "Điểm khởi hành không được để trống";
                }
                if (empty($mo_ta_ngan)) {
                    $error['mo_ta_ngan'] = "Mô tả ngắn không được để trống";
                }
                if (empty($mo_ta)) {
                    $error['mo_ta'] = "Mô tả không được để trống";
                }

                // Validate Tab 2
                if (empty($dia_diem_id) || count(array_filter($dia_diem_id)) === 0) {
                    $error['dia_diem'] = "Vui lòng chọn ít nhất 1 địa điểm";
                } else {
                    foreach ($dia_diem_id as $idx => $dd_id) {
                        if (empty($dd_id)) {
                            $error['dia_diem_' . $idx] = "Địa điểm " . ($idx + 1) . " chưa được chọn";
                        }
                    }
                }

                // Validate Tab 3: Lịch trình (giống postAddDanhMuc)
                
                // DEBUG: Log validation data
                file_put_contents(__DIR__ . '/../../debug_edit.txt',
                    "VALIDATION LICH TRINH:\n" .
                    "  thoi_luong_mac_dinh: $thoi_luong_mac_dinh\n" .
                    "  ngay count: " . count($ngay) . "\n" .
                    "  ngay data: " . print_r($ngay, true) . "\n",
                    FILE_APPEND
                );
                
                if (!empty($ngay)) {
                    $soNgay = count($ngay);
                    
                    // Kiểm tra số ngày không vượt quá thời lượng
                    if ($soNgay > $thoi_luong_mac_dinh) {
                        $error['lich_trinh'] = "Số ngày trong lịch trình ($soNgay) không được vượt quá số ngày du lịch ($thoi_luong_mac_dinh ngày)";
                    }
                    
                    // REMOVED: Không cần kiểm tra phải đủ số ngày - cho phép lịch trình một phần
                    // if ($soNgay < $thoi_luong_mac_dinh) {
                    //     $error['lich_trinh'] = "Lịch trình chỉ có $soNgay ngày, cần đủ $thoi_luong_mac_dinh ngày";
                    // }
                    
                    // Validate từng ngày
                    foreach ($ngay as $ngayIndex => $ngayData) {
                        $ngayThu = $ngayData['ngay_thu'] ?? '';
                        $diaDiemTourId = $ngayData['dia_diem_tour_id'] ?? '';
                        $lichTrinhList = $ngayData['lich_trinh'] ?? [];
                        
                        // Kiểm tra ngày thứ
                        if (empty($ngayThu)) {
                            $error["ngay_{$ngayIndex}_ngay_thu"] = "Ngày thứ không được để trống";
                        }
                        
                        // Kiểm tra địa điểm
                        if (!isset($diaDiemTourId) || $diaDiemTourId === '') {
                            $error["ngay_{$ngayIndex}_dia_diem"] = "Vui lòng chọn địa điểm cho Ngày $ngayThu";
                        }
                        
                        // Kiểm tra có ít nhất 1 hoạt động
                        if (empty($lichTrinhList) || count($lichTrinhList) === 0) {
                            $error["ngay_{$ngayIndex}_hoat_dong"] = "Ngày $ngayThu phải có ít nhất 1 hoạt động";
                        } else {
                            // Validate từng hoạt động trong ngày
                            foreach ($lichTrinhList as $ltIndex => $lt) {
                                $gioBatDau = $lt['gio_bat_dau'] ?? '';
                                $gioKetThuc = $lt['gio_ket_thuc'] ?? '';
                                $noiDung = $lt['noi_dung'] ?? '';
                                
                                // Kiểm tra giờ bắt đầu
                                if (empty($gioBatDau)) {
                                    $error["ngay_{$ngayIndex}_lt_{$ltIndex}_gio_bat_dau"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ bắt đầu không được để trống";
                                }
                                
                                // Kiểm tra giờ kết thúc
                                if (empty($gioKetThuc)) {
                                    $error["ngay_{$ngayIndex}_lt_{$ltIndex}_gio_ket_thuc"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ kết thúc không được để trống";
                                }
                                
                                // Kiểm tra nội dung
                                if (empty($noiDung)) {
                                    $error["ngay_{$ngayIndex}_lt_{$ltIndex}_noi_dung"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Nội dung không được để trống";
                                } elseif (strlen($noiDung) < 10) {
                                    $error["ngay_{$ngayIndex}_lt_{$ltIndex}_noi_dung"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Nội dung quá ngắn (tối thiểu 10 ký tự)";
                                }
                                
                                // Kiểm tra logic thời gian: giờ kết thúc phải sau giờ bắt đầu
                                if (!empty($gioBatDau) && !empty($gioKetThuc)) {
                                    if ($gioKetThuc <= $gioBatDau) {
                                        $error["ngay_{$ngayIndex}_lt_{$ltIndex}_thoi_gian"] = "Ngày $ngayThu - Hoạt động " . ($ltIndex + 1) . ": Giờ kết thúc phải sau giờ bắt đầu";
                                    }
                                }
                            }
                        }
                    }
                }

                // Nếu có lỗi, lưu session và redirect
                if (!empty($error)) {
                    // DEBUG: Log errors
                    file_put_contents(__DIR__ . '/../../debug_edit.txt',
                        "VALIDATION ERRORS:\n" . print_r($error, true) . "\n",
                        FILE_APPEND
                    );
                    
                    $_SESSION['flash'] = true;
                    $_SESSION['error'] = $error;
                    $_SESSION['old'] = [
                        'ten' => $ten,
                        'danh_muc_id' => $danh_muc_id,
                        'gia_co_ban' => $gia_co_ban,
                        'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
                        'chinh_sach' => $chinh_sach,
                        'diem_khoi_hanh' => $diem_khoi_hanh,
                        'mo_ta_ngan' => $mo_ta_ngan,
                        'mo_ta' => $mo_ta,
                        'dia_diem' => array_map(function ($id, $tt, $gc) {
                            return ['dia_diem_id' => $id, 'thu_tu' => $tt, 'ghi_chu' => $gc];
                        }, $dia_diem_id, $thu_tu, $ghi_chu)
                    ];
                    header('Location: ' . BASE_URL_ADMIN . '?act=form-sua-danh-muc&id=' . $id);
                    exit;
                }

                // Update tour
                $tourData = [
                    'ten' => $ten,
                    'danh_muc_id' => $danh_muc_id,
                    'mo_ta_ngan' => $mo_ta_ngan,
                    'mo_ta' => $mo_ta,
                    'gia_co_ban' => $gia_co_ban,
                    'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
                    'chinh_sach' => $chinh_sach,
                    'diem_khoi_hanh' => $diem_khoi_hanh
                ];
                $this->model->updateTour($id, $tourData);

                // Xóa dia_diem_tour cũ và insert lại
                $this->model->deleteDiaDiemTourByTour($id);
                
                // DEBUG: Xem dữ liệu POST
                file_put_contents(__DIR__ . '/../../debug_edit.txt', 
                    "=== EDIT TOUR ID: $id ===\n" .
                    "DIA_DIEM_ID: " . print_r($dia_diem_id, true) . "\n" .
                    "NGAY DATA: " . print_r($ngay, true) . "\n",
                    FILE_APPEND
                );
                
                // Lưu mapping index -> dia_diem_tour_id
                $diaDiemTourIdMap = [];
                
                foreach ($dia_diem_id as $idx => $dd_id) {
                    if (!empty($dd_id)) {
                        $insertedId = $this->model->insertDiaDiemTour([
                            'tour_id' => $id,
                            'dia_diem_id' => $dd_id,
                            'thu_tu' => $thu_tu[$idx] ?? ($idx + 1),
                            'ghi_chu' => $ghi_chu[$idx] ?? ''
                        ]);
                        
                        // Lưu mapping: index -> dia_diem_tour_id
                        $diaDiemTourIdMap[$idx] = $insertedId;
                        
                        // DEBUG
                        file_put_contents(__DIR__ . '/../../debug_edit.txt',
                            "Inserted dia_diem_tour: idx=$idx, dd_id=$dd_id, inserted_id=$insertedId\n",
                            FILE_APPEND
                        );
                    }
                }
                
                // DEBUG: Mapping
                file_put_contents(__DIR__ . '/../../debug_edit.txt',
                    "DIA_DIEM_TOUR_ID_MAP: " . print_r($diaDiemTourIdMap, true) . "\n",
                    FILE_APPEND
                );

                // Xóa lịch trình cũ và insert lại theo cấu trúc mới
                $this->model->deleteLichTrinhByTour($id);
                
                // Insert lịch trình theo cấu trúc mới
                foreach ($ngay as $ngayIndex => $ngayData) {
                    if (isset($ngayData['ngay_thu']) && $ngayData['ngay_thu'] != '' 
                        && isset($ngayData['dia_diem_tour_id']) && $ngayData['dia_diem_tour_id'] !== ''
                        && !empty($ngayData['lich_trinh'])) {
                        
                        // Lấy dia_diem_tour_id từ mapping đã lưu
                        $diaDiemIndex = $ngayData['dia_diem_tour_id'];
                        $diaDiemTourId = $diaDiemTourIdMap[$diaDiemIndex] ?? null;
                        
                        // DEBUG
                        file_put_contents(__DIR__ . '/../../debug_edit.txt',
                            "Ngay $ngayIndex: ngay_thu={$ngayData['ngay_thu']}, dd_index=$diaDiemIndex, dd_tour_id=$diaDiemTourId\n",
                            FILE_APPEND
                        );
                        
                        if (!$diaDiemTourId) {
                            continue; // Bỏ qua nếu không tìm thấy
                        }
                        
                        // Insert từng lịch trình trong ngày
                        foreach ($ngayData['lich_trinh'] as $ltIndex => $lt) {
                            if (!empty($lt['gio_bat_dau']) && !empty($lt['gio_ket_thuc']) && !empty($lt['noi_dung'])) {
                                $insertResult = $this->model->insertLichTrinh([
                                    'tour_id' => $id,
                                    'ngay_thu' => $ngayData['ngay_thu'],
                                    'gio_bat_dau' => $lt['gio_bat_dau'],
                                    'gio_ket_thuc' => $lt['gio_ket_thuc'],
                                    'dia_diem_tour_id' => $diaDiemTourId,
                                    'noi_dung' => $lt['noi_dung']
                                ]);
                                
                                // DEBUG
                                file_put_contents(__DIR__ . '/../../debug_edit.txt',
                                    "  Insert lich_trinh $ltIndex: " . ($insertResult ? 'OK' : 'FAIL') . 
                                    " (gio={$lt['gio_bat_dau']}-{$lt['gio_ket_thuc']}, noi_dung=" . substr($lt['noi_dung'], 0, 30) . "...)\n",
                                    FILE_APPEND
                                );
                            }
                        }
                    }
                }
                
                // DEBUG: Kết thúc
                file_put_contents(__DIR__ . '/../../debug_edit.txt', "=== END EDIT ===\n\n", FILE_APPEND);

                unset($_SESSION['error']);
                unset($_SESSION['old']);
                unset($_SESSION['flash']);

                header('Location: ?act=danh-muc-tour');
                exit;
            } else {
                // Cập nhật category cũ (hành vi cũ)
                $ten = $_POST['ten'];
                $mo_ta = $_POST['mo_ta'];
                $trang_thai = $_POST['trang_thai'];
                $ngay_tao = date('Y-m-d H:i:s');
                // kiểm tra
                if ($ten == "") {
                    $_SESSION['error'] = "Tên danh mục không được để trống";
                    header("Location: ?act=form-sua-danh-muc&id=" . $id);
                    exit;
                }

                // gọi model cập nhật
                $this->model->updateDanhMuc($id, $ten, $mo_ta, $trang_thai, $ngay_tao);
                $_SESSION['success'] = "Cập nhật thành công";
                header("Location: ?act=danh-muc-tour");
                exit;
            }
        }
    }

    public function deleteDanhMuc()
    {
        // hàm này dùng để xóa danh mục
        $id = $_GET['id'];
        $this->model->destroyDanhMuc($id);
        header("Location:" . BASE_URL_ADMIN . '?act=danh-muc-tour');
        exit();
    }
}
