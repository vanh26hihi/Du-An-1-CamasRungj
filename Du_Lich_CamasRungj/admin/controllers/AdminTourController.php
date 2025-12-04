<?php
require_once 'models/AdminTour.php';
class AdminTourController
{
    public $model;
    public function __construct()
    {
        $this->model = new AdminTour();
    }

    // Hiển thị danh sách tour với info cần thiết
    public function listTour()
    {
        $listTour = $this->model->getAllToursList();
        require 'views/tour/listTour.php';
    }

    // Form thêm lịch khởi hành cho tour
    public function formAddTour()
    {
        $allTours = $this->model->getAllToursForSelect();
        $allHDV = $this->model->getAllHDV();
        $dsTrangThai = $this->model->getAllTrangThaiLichKhoiHanh();
        $transportServices = $this->model->getDichVuByType('transport');
        $hotelServices = $this->model->getDichVuByType('hotel');
        $cateringServices = $this->model->getDichVuByType('catering');

        $error = $_SESSION['error'] ?? [];
        // Prefill data when coming from copyTour
        $copyPrefill = $_SESSION['copy_prefill'] ?? null;
        if (isset($_SESSION['copy_prefill'])) {
            unset($_SESSION['copy_prefill']); // one-time use
        }
        require 'views/tour/addTour.php';
        deleteSessionError();
    }

    // Chuẩn bị tạo lịch mới cho tour đã có: chỉ lấy thông tin, HDV & dịch vụ mẫu (không tạo tour mới)
    public function copyTour()
    {
        $tour_id = $_GET['tour_id'] ?? null;
        if (!$tour_id) {
            $_SESSION['error'] = 'Thiếu tour_id để sao chép';
            header('Location: ' . BASE_URL_ADMIN . '?act=quan-ly-tour');
            exit();
        }
        // Lấy lịch khởi hành mới nhất của tour để làm template HDV & dịch vụ
        $latestLich = $this->model->getLatestLichByTour($tour_id);
        if ($latestLich) {
            $templateHDV = $this->model->getPhanCongHDVByLich($latestLich['lich_id']);
            $templateServices = $this->model->getDichVuByLich($latestLich['lich_id']);

            // Chuẩn hóa dữ liệu để view dễ dùng
            $hdv_ids = [];
            $vai_tros = [];
            foreach ($templateHDV as $pc) {
                $hdv_ids[] = $pc['hdv_id'];
                $vai_tros[] = $pc['vai_tro'];
            }

            $_SESSION['copy_prefill'] = [
                'hdv_ids' => $hdv_ids,
                'vai_tros' => $vai_tros,
                'services' => $templateServices
            ];
        }

        $_SESSION['success'] = 'Tạo lịch mới từ tour đã chọn';
        header('Location: ' . BASE_URL_ADMIN . '?act=form-them-tour&tour_id=' . $tour_id . '&copied=1');
        exit();
    }

    // Xử lý thêm lịch khởi hành
    public function postAddTour()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tab 1: Thông tin tour và lịch khởi hành
            $tour_id = $_POST['tour_id'] ?? '';
            $ngay_bat_dau = $_POST['ngay_bat_dau'] ?? '';
            $ngay_ket_thuc = $_POST['ngay_ket_thuc'] ?? '';
            $trang_thai_id = $_POST['trang_thai_id'] ?? '';
            $ghi_chu = $_POST['ghi_chu'] ?? '';

            // Tab 2: HDV (array)
            $hdv_ids = $_POST['hdv_id'] ?? [];
            $vai_tros = $_POST['vai_tro'] ?? [];

            // Tab 3: Dịch vụ
            $transport_id = $_POST['transport_id'] ?? '';
            $transport_ghi_chu = $_POST['transport_ghi_chu'] ?? '';

            $hotel_id = $_POST['hotel_id'] ?? '';
            $hotel_ghi_chu = $_POST['hotel_ghi_chu'] ?? '';

            $catering_id = $_POST['catering_id'] ?? '';
            $catering_ghi_chu = $_POST['catering_ghi_chu'] ?? '';

            // Validate
            $error = [];

            // Validate Tab 1
            if (empty($tour_id)) {
                $error['tour_id'] = "Vui lòng chọn tour";
            }

            // Lấy thông tin tour để check thời lượng
            $tourInfo = null;
            if (!empty($tour_id)) {
                $tourInfo = $this->model->getTourDetailById($tour_id);
            }

            if (empty($ngay_bat_dau)) {
                $error['ngay_bat_dau'] = "Ngày bắt đầu không được để trống";
            } else {
                // Kiểm tra ngày bắt đầu không được nhỏ hơn ngày hiện tại
                $today = date('Y-m-d');
                if (strtotime($ngay_bat_dau) < strtotime($today)) {
                    $error['ngay_bat_dau'] = "Ngày bắt đầu không được nhỏ hơn ngày hiện tại";
                }
            }

            if (empty($ngay_ket_thuc)) {
                $error['ngay_ket_thuc'] = "Ngày kết thúc không được để trống";
            } else if (!empty($ngay_bat_dau)) {
                // Kiểm tra ngày kết thúc không được nhỏ hơn ngày bắt đầu
                if (strtotime($ngay_ket_thuc) < strtotime($ngay_bat_dau)) {
                    $error['ngay_ket_thuc'] = "Ngày kết thúc phải sau hoặc bằng ngày bắt đầu";
                }

                // Kiểm tra tổng số ngày phải khớp với thời lượng mặc định của tour
                if ($tourInfo && isset($tourInfo['thoi_luong_mac_dinh'])) {
                    $date1 = new DateTime($ngay_bat_dau);
                    $date2 = new DateTime($ngay_ket_thuc);
                    $interval = $date1->diff($date2);
                    $soNgay = $interval->days + 1; // +1 vì tính cả ngày đầu

                    $thoiLuongMacDinh = (int)$tourInfo['thoi_luong_mac_dinh'];

                    if ($soNgay != $thoiLuongMacDinh) {
                        $error['ngay_ket_thuc'] = "Tổng số ngày không được vượt quá {$thoiLuongMacDinh} ngày ";
                    }
                }
            }

            // Trạng thái mặc định là id=1 (Đang mở) cho form thêm mới
            if (empty($trang_thai_id)) {
                $trang_thai_id = 1; // ID của trạng thái "Đang mở"
            }

            // Validate Tab 2: HDV
            if (empty($hdv_ids) || count($hdv_ids) == 0) {
                $error['hdv_id'] = "Vui lòng chọn ít nhất 1 hướng dẫn viên";
            } else {
                foreach ($hdv_ids as $index => $hdv_id) {
                    if (empty($hdv_id)) {
                        $error['hdv_' . $index] = "Vui lòng chọn hướng dẫn viên";
                    }
                }
            }

            // Validate Tab 3: Dịch vụ
            if (empty($transport_id)) {
                $error['transport_id'] = "Vui lòng chọn dịch vụ vận chuyển";
            }
            if (empty($hotel_id)) {
                $error['hotel_id'] = "Vui lòng chọn dịch vụ khách sạn";
            }
            if (empty($catering_id)) {
                $error['catering_id'] = "Vui lòng chọn dịch vụ ăn uống";
            }

            // Nếu có lỗi, lưu session và quay lại
            if (!empty($error)) {
                $_SESSION['flash'] = true;
                $_SESSION['error'] = $error;
                $_SESSION['old'] = $_POST;
                header('Location: ' . BASE_URL_ADMIN . '?act=form-them-tour');
                exit;
            }

            // Insert lịch khởi hành
            $lichId = $this->model->insertLichKhoiHanh([
                'tour_id' => $tour_id,
                'ngay_bat_dau' => $ngay_bat_dau,
                'ngay_ket_thuc' => $ngay_ket_thuc,
                'trang_thai_id' => $trang_thai_id,
                'ghi_chu' => $ghi_chu
            ]);

            if ($lichId) {
                // Insert phân công HDV
                foreach ($hdv_ids as $index => $hdv_id) {
                    if (!empty($hdv_id)) {
                        $this->model->insertPhanCongHDV([
                            'lich_id' => $lichId,
                            'hdv_id' => $hdv_id,
                            'vai_tro' => $vai_tros[$index] ?? 'support'
                        ]);
                    }
                }

                // Insert dịch vụ vào tour_ncc
                $dichVuData = [];
                if (!empty($transport_id)) {
                    $dichVuData[] = [
                        'dich_vu_id' => $transport_id,
                        'gia_thoa_thuan' => $this->model->getGiaMacDinhByDichVuId($transport_id),
                        'ghi_chu' => $transport_ghi_chu
                    ];
                }
                if (!empty($hotel_id)) {
                    $dichVuData[] = [
                        'dich_vu_id' => $hotel_id,
                        'gia_thoa_thuan' => $this->model->getGiaMacDinhByDichVuId($hotel_id),
                        'ghi_chu' => $hotel_ghi_chu
                    ];
                }
                if (!empty($catering_id)) {
                    $dichVuData[] = [
                        'dich_vu_id' => $catering_id,
                        'gia_thoa_thuan' => $this->model->getGiaMacDinhByDichVuId($catering_id),
                        'ghi_chu' => $catering_ghi_chu
                    ];
                }
                $this->model->insertDichVuTour($lichId, $dichVuData);

                // Xóa session
                unset($_SESSION['error']);
                unset($_SESSION['old']);
                unset($_SESSION['flash']);

                header('Location: ' . BASE_URL_ADMIN . '?act=quan-ly-tour');
                exit;
            } else {
                $_SESSION['error']['general'] = "Có lỗi xảy ra khi thêm lịch khởi hành";
                $_SESSION['old'] = $_POST;
                header('Location: ' . BASE_URL_ADMIN . '?act=form-them-tour');
                exit;
            }
        }
    }

    // Form sửa tour
    public function formEditTour()
    {
        $lich_id = $_GET['lich_id'] ?? null;
        if (!$lich_id) {
            $_SESSION['error'] = "Thiếu lich_id";
            header('Location: ' . BASE_URL_ADMIN . '?act=quan-ly-tour');
            exit;
        }

        // Lấy thông tin lịch khởi hành
        $lichKhoiHanh = $this->model->getLichKhoiHanhById($lich_id);
        if (!$lichKhoiHanh) {
            $_SESSION['error'] = "Không tìm thấy lịch khởi hành";
            header('Location: ' . BASE_URL_ADMIN . '?act=quan-ly-tour');
            exit;
        }

        // Lấy id dịch vụ và ghi chú đã chọn cho lịch khởi hành (nếu có)
        $lichDichVu = $this->model->getDichVuByLich($lich_id);
        if ($lichDichVu) {
            $lichKhoiHanh['transport_id'] = $lichDichVu['transport_id'] ?? '';
            $lichKhoiHanh['transport_ghi_chu'] = $lichDichVu['transport_ghi_chu'] ?? '';
            $lichKhoiHanh['hotel_id'] = $lichDichVu['hotel_id'] ?? '';
            $lichKhoiHanh['hotel_ghi_chu'] = $lichDichVu['hotel_ghi_chu'] ?? '';
            $lichKhoiHanh['catering_id'] = $lichDichVu['catering_id'] ?? '';
            $lichKhoiHanh['catering_ghi_chu'] = $lichDichVu['catering_ghi_chu'] ?? '';
        } else {
            $lichKhoiHanh['transport_id'] = '';
            $lichKhoiHanh['transport_ghi_chu'] = '';
            $lichKhoiHanh['hotel_id'] = '';
            $lichKhoiHanh['hotel_ghi_chu'] = '';
            $lichKhoiHanh['catering_id'] = '';
            $lichKhoiHanh['catering_ghi_chu'] = '';
        }

        // Lấy thông tin tour
        $tour = $this->model->getTourDetailById($lichKhoiHanh['tour_id']);

        // Lấy danh sách để chọn
        $allTours = $this->model->getAllToursForSelect();
        $allHDV = $this->model->getAllHDV();
        $dsTrangThai = $this->model->getAllTrangThaiLichKhoiHanh();

        // Lấy dịch vụ theo từng loại
        $transportServices = $this->model->getDichVuByType('transport');
        $hotelServices = $this->model->getDichVuByType('hotel');
        $cateringServices = $this->model->getDichVuByType('catering');

        // Lấy HDV đã phân công
        $hdvList = $this->model->getPhanCongHDVByLich($lich_id);

        $error = $_SESSION['error'] ?? [];

        require 'views/tour/editTour.php';
        deleteSessionError();
    }

    // Xử lý sửa tour
    public function postEditTour()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lich_id = $_POST['lich_id'] ?? null;
            $tour_id = $_POST['tour_id'] ?? '';
            $ngay_bat_dau = $_POST['ngay_bat_dau'] ?? '';
            $ngay_ket_thuc = $_POST['ngay_ket_thuc'] ?? '';
            $trang_thai_id = $_POST['trang_thai_id'] ?? '';
            $ghi_chu = $_POST['ghi_chu'] ?? '';

            $hdv_ids = $_POST['hdv_id'] ?? [];
            $vai_tros = $_POST['vai_tro'] ?? [];

            $transport_id = $_POST['transport_id'] ?? '';
            $transport_ghi_chu = $_POST['transport_ghi_chu'] ?? '';
            $hotel_id = $_POST['hotel_id'] ?? '';
            $hotel_ghi_chu = $_POST['hotel_ghi_chu'] ?? '';
            $catering_id = $_POST['catering_id'] ?? '';
            $catering_ghi_chu = $_POST['catering_ghi_chu'] ?? '';

            $error = [];

            if (empty($lich_id)) {
                $_SESSION['error'] = ['lich_id' => 'Thiếu lich_id'];
                header('Location: ' . BASE_URL_ADMIN . '?act=quan-ly-tour');
                exit;
            }

            // Validate
            if (empty($tour_id)) {
                $error['tour_id'] = "Vui lòng chọn tour";
            }

            $tourInfo = null;
            if (!empty($tour_id)) {
                $tourInfo = $this->model->getTourDetailById($tour_id);
            }

            if (empty($ngay_bat_dau)) {
                $error['ngay_bat_dau'] = "Ngày bắt đầu không được để trống";
            } else {
                $today = date('Y-m-d');
                if (strtotime($ngay_bat_dau) < strtotime($today)) {
                    $error['ngay_bat_dau'] = "Ngày bắt đầu không được nhỏ hơn ngày hiện tại";
                }
            }

            if (empty($ngay_ket_thuc)) {
                $error['ngay_ket_thuc'] = "Ngày kết thúc không được để trống";
            } else if (!empty($ngay_bat_dau)) {
                if (strtotime($ngay_ket_thuc) < strtotime($ngay_bat_dau)) {
                    $error['ngay_ket_thuc'] = "Ngày kết thúc phải sau hoặc bằng ngày bắt đầu";
                }

                if ($tourInfo && isset($tourInfo['thoi_luong_mac_dinh'])) {
                    $date1 = new DateTime($ngay_bat_dau);
                    $date2 = new DateTime($ngay_ket_thuc);
                    $interval = $date1->diff($date2);
                    $soNgay = $interval->days + 1;
                    $thoiLuongMacDinh = (int)$tourInfo['thoi_luong_mac_dinh'];

                    if ($soNgay != $thoiLuongMacDinh) {
                        $error['ngay_ket_thuc'] = "Tổng số ngày không được vượt quá {$thoiLuongMacDinh} ngày";
                    }
                }
            }

            if (empty($trang_thai_id)) {
                $error['trang_thai_id'] = "Trạng thái không được để trống";
            }

            // Validate HDV
            if (empty($hdv_ids) || count($hdv_ids) == 0) {
                $error['hdv'] = "Vui lòng chọn ít nhất 1 hướng dẫn viên";
            } else {
                foreach ($hdv_ids as $index => $hdv_id) {
                    if (empty($hdv_id)) {
                        $error['hdv_' . $index] = "Vui lòng chọn hướng dẫn viên";
                    }
                    if (empty($vai_tros[$index])) {
                        $error['vai_tro_' . $index] = "Vai trò không được để trống";
                    }
                }
            }

            // Validate Tab 4: Dịch vụ
            if (empty($transport_id)) {
                $error['transport_id'] = "Vui lòng chọn dịch vụ vận chuyển";
            }
            if (empty($hotel_id)) {
                $error['hotel_id'] = "Vui lòng chọn dịch vụ khách sạn";
            }
            if (empty($catering_id)) {
                $error['catering_id'] = "Vui lòng chọn dịch vụ ăn uống";
            }

            if (!empty($error)) {
                $_SESSION['flash'] = true;
                $_SESSION['error'] = $error;
                $_SESSION['old'] = $_POST;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-tour&lich_id=' . $lich_id);
                exit;
            }

            // Update lịch khởi hành
            $updateLich = $this->model->updateLichKhoiHanh($lich_id, [
                'tour_id' => $tour_id,
                'ngay_bat_dau' => $ngay_bat_dau,
                'ngay_ket_thuc' => $ngay_ket_thuc,
                'trang_thai_id' => $trang_thai_id,
                'ghi_chu' => $ghi_chu
            ]);

            if ($updateLich) {
                // Xóa HDV cũ và thêm mới
                $this->model->deletePhanCongHDVByLich($lich_id);
                foreach ($hdv_ids as $index => $hdv_id) {
                    if (!empty($hdv_id)) {
                        $this->model->insertPhanCongHDV([
                            'lich_id' => $lich_id,
                            'hdv_id' => $hdv_id,
                            'vai_tro' => $vai_tros[$index]
                        ]);
                    }
                }

                // Cập nhật dịch vụ vào tour_ncc
                $dichVuData = [];
                if (!empty($transport_id)) {
                    $dichVuData[] = [
                        'dich_vu_id' => $transport_id,
                        'gia_thoa_thuan' => $this->model->getGiaMacDinhByDichVuId($transport_id),
                        'ghi_chu' => $transport_ghi_chu
                    ];
                }
                if (!empty($hotel_id)) {
                    $dichVuData[] = [
                        'dich_vu_id' => $hotel_id,
                        'gia_thoa_thuan' => $this->model->getGiaMacDinhByDichVuId($hotel_id),
                        'ghi_chu' => $hotel_ghi_chu
                    ];
                }
                if (!empty($catering_id)) {
                    $dichVuData[] = [
                        'dich_vu_id' => $catering_id,
                        'gia_thoa_thuan' => $this->model->getGiaMacDinhByDichVuId($catering_id),
                        'ghi_chu' => $catering_ghi_chu
                    ];
                }
                $this->model->insertDichVuTour($lich_id, $dichVuData);

                $_SESSION['success'] = "Cập nhật lịch khởi hành thành công!";
                header("Location: " . BASE_URL_ADMIN . '?act=quan-ly-tour');
                exit;
            } else {
                $_SESSION['error'] = ['general' => "Lỗi khi cập nhật lịch khởi hành"];
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-tour&lich_id=' . $lich_id);
                exit;
            }
        }
    }

    // API: Lấy thông tin tour qua AJAX
    public function getTourInfo()
    {
        // Xóa output buffer và set header
        ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        $tourId = $_GET['id'] ?? null;

        if (!$tourId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu ID tour'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $tourDetail = $this->model->getTourDetailById($tourId);
        $diaDiemList = $this->model->getDiaDiemTourByTour($tourId);

        if ($tourDetail) {
            echo json_encode([
                'success' => true,
                'data' => array_merge($tourDetail, ['dia_diem' => $diaDiemList])
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy tour'], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    // Xóa lịch khởi hành (cascade: lich_trinh, phan_cong_hdv)
    public function deleteTour()
    {
        // Xóa lịch khởi hành
        $lich_id = $_GET['lich_id'] ?? null;
        if ($lich_id) {
            $result = $this->model->deleteLichKhoiHanh($lich_id);
            if ($result) {
                $_SESSION['success'] = "Xóa lịch khởi hành thành công";
            } else {
                $_SESSION['error'] = "Có lỗi khi xóa lịch khởi hành";
            }
            header('Location: ' . BASE_URL_ADMIN . '?act=quan-ly-tour');
            exit;
        }
        
        // Xóa tour (cascade delete tất cả dữ liệu liên quan)
        $tour_id = $_GET['tour_id'] ?? null;
        if ($tour_id) {
            // Xóa theo thứ tự: lịch trình → dia_diem_tour → lich_khoi_hanh → tour
            require_once 'models/AdminDanhMuc.php';
            $danhMucModel = new AdminDanhMuc();
            
            try {
                // 1. Xóa lịch trình
                $danhMucModel->deleteLichTrinhByTour($tour_id);
                
                // 2. Xóa dia_diem_tour
                $danhMucModel->deleteDiaDiemTourByTour($tour_id);
                
                // 3. Xóa tất cả lịch khởi hành của tour
                $this->model->deleteLichKhoiHanhByTour($tour_id);
                
                // 4. Xóa tour
                $result = $this->model->deleteTourById($tour_id);
                
                if ($result) {
                    $_SESSION['success'] = "Xóa tour thành công";
                } else {
                    $_SESSION['error'] = "Có lỗi khi xóa tour";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            }
            
            header('Location: ' . BASE_URL_ADMIN . '?act=danh-muc-tour');
            exit;
        }
        
        // Không có tham số
        $_SESSION['error'] = "Thiếu tham số để xóa";
        header('Location: ' . BASE_URL_ADMIN . '?act=quan-ly-tour');
        exit;
    }
}
