<?php
class AdminBookingController
{
    public $modelBooking;
    public function __construct()
    {
        $this->modelBooking = new AdminBooking();
    }
    public function AdminHome()
    {
        header("Location:" . BASE_URL_ADMIN . '?act=booking');
    }

    public function danhSachBooking()
    {
        $listBooking = $this->modelBooking->getAllBooking();
        require_once './views/Booking/listBooking.php';
    }

    public function formAddBooking()
    {
        // Cung cấp dữ liệu tách biệt: tour và toàn bộ lịch
        $listTours   = $this->modelBooking->getAllTours();
        $listLichAll = $this->modelBooking->getAllLich();
        require_once './views/booking/addBooking.php';
    }

    public function postAddBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // DEBUG: In ra dữ liệu được gửi
            error_log("=== DEBUG postAddBooking ===");
            error_log("POST data: " . json_encode($_POST));

            // Gom dữ liệu
            $tour_id        = $_POST['tour_id'] ?? null;
            $lich_id        = $_POST['lich_id'] ?? null;
            $loai           = $_POST['loai'] ?? null;
            $so_nguoi       = $_POST['so_nguoi'] ?? null;
            $ghi_chu        = $_POST['ghi_chu'] ?? null;
            $tong_tien      = $_POST['tong_tien'] ?? null;
            $nguoi_tao_id   = $_POST['nguoi_tao_id'] ?? null;

            // Thông tin người đặt tour
            $ho_ten        = $_POST['ho_ten'] ?? null;
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? null;
            $email         = $_POST['email'] ?? null;
            $cccd          = $_POST['cccd'] ?? null;
            $dia_chi       = $_POST['dia_chi'] ?? null;

            // Danh sách khách hàng
            $ds_khach = $_POST['ds_khach'] ?? [];

            error_log("tour_id: $tour_id, lich_id: $lich_id, loai: $loai, ho_ten: $ho_ten, email: $email");

            // Mảng lỗi
            $error = [];

            // Validate cơ bản
            if (empty($tour_id)) {
                $error['tour_id'] = "Vui lòng chọn tour.";
            }
            if (empty($lich_id)) {
                $error['lich_id'] = "Vui lòng chọn lịch tour.";
            }

            if (empty($loai)) {
                $error['loai'] = "Vui lòng chọn loại tour.";
            }

            if (empty($so_nguoi)) {
                $error['so_nguoi'] = "Vui lòng nhập số lượng người.";
            } elseif ($so_nguoi <= 0) {
                $error['so_nguoi'] = "Số lượng người phải lớn hơn 0.";
            }

            if (empty($ho_ten)) {
                $error['ho_ten'] = "Tên khách hàng không được để trống.";
            }

            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = "Số điện thoại không được để trống.";
            } elseif (!preg_match('/^[0-9]{9,11}$/', $so_dien_thoai)) {
                $error['so_dien_thoai'] = "Số điện thoại không hợp lệ.";
            }

            if (empty($email)) {
                $error['email'] = "Email không được để trống.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Email không hợp lệ.";
            }

            if (empty($cccd)) {
                $error['cccd'] = "CCCD không được để trống.";
            } elseif (!preg_match('/^[0-9]{12}$/', $cccd)) {
                $error['cccd'] = "CCCD phải đúng 12 số.";
            }

            if (empty($dia_chi)) {
                $error['dia_chi'] = "Địa chỉ không được để trống.";
            }


            // Validate từng khách trong danh sách
            if (!empty($ds_khach)) {
                foreach ($ds_khach as $index => $kh) {

                    if (empty($kh['ho_ten'])) {
                        $error["ds_khach_{$index}_ho_ten"] = "Khách hàng số " . ($index + 1) . " chưa nhập họ tên.";
                    }

                    if (empty($kh['gioi_tinh'])) {
                        $error["ds_khach_{$index}_gioi_tinh"] = "Khách hàng số " . ($index + 1) . " chưa chọn giới tính.";
                    }

                    if (empty($kh['so_dien_thoai'])) {
                        $error["ds_khach_{$index}_so_dien_thoai"] = "Khách hàng số " . ($index + 1) . " chưa nhập số điện thoại.";
                    } elseif (!preg_match('/^[0-9]{9,11}$/', $kh['so_dien_thoai'])) {
                        $error["ds_khach_{$index}_so_dien_thoai"] = "Số điện thoại khách hàng số " . ($index + 1) . " không hợp lệ.";
                    }

                    if (empty($kh['email'])) {
                        $error["ds_khach_{$index}_email"] = "Khách hàng số " . ($index + 1) . " chưa nhập email.";
                    } elseif (!filter_var($kh['email'], FILTER_VALIDATE_EMAIL)) {
                        $error["ds_khach_{$index}_email"] = "Email của khách hàng số " . ($index + 1) . " không hợp lệ.";
                    }

                    if (empty($kh['cccd'])) {
                        $error["ds_khach_{$index}_cccd"] = "Khách hàng số " . ($index + 1) . " chưa nhập CCCD.";
                    } elseif (!preg_match('/^[0-9]{9,12}$/', $kh['cccd'])) {
                        $error["ds_khach_{$index}_cccd"] = "CCCD của khách hàng số " . ($index + 1) . " không hợp lệ.";
                    }

                    if (empty($kh['ngay_sinh'])) {
                        $error["ds_khach_{$index}_ngay_sinh"] = "Khách hàng số " . ($index + 1) . " chưa chọn ngày sinh.";
                    }
                }
            }

            // Nếu có lỗi → trả về form
            if (!empty($error)) {

                error_log("=== Validation errors ===");
                error_log(json_encode($error));

                $_SESSION['flash'] = true;      // cờ báo có lỗi
                $_SESSION['error'] = $error;    // lưu lỗi
                $_SESSION['old']   = $_POST;    // lưu dữ liệu cũ

                header("Location:" . BASE_URL_ADMIN . '?act=form-them-booking');
                exit();
            }

            // Không lỗi → tiến hành lưu DB
            // (Optional) Kiểm tra lịch thuộc tour đã chọn
            if (!empty($tour_id) && !empty($lich_id)) {
                $schedule = $this->modelBooking->getScheduleById($lich_id);
                if (!$schedule || (string)$schedule['tour_id'] !== (string)$tour_id) {
                    $_SESSION['flash'] = true;
                    $_SESSION['error'] = ['lich_id' => 'Lịch khởi hành không thuộc tour đã chọn.'];
                    $_SESSION['old']   = $_POST;
                    header("Location:" . BASE_URL_ADMIN . '?act=form-them-booking');
                    exit();
                }
            }
            $khach_hang_id = $this->modelBooking->insertKhachHang($ho_ten, $so_dien_thoai, $email, $cccd, $dia_chi);

            error_log("khach_hang_id inserted: $khach_hang_id");

            $dat_tour_id = $this->modelBooking->insertBooking(
                $lich_id,
                $loai,
                $so_nguoi,
                $ghi_chu,
                $khach_hang_id,
                $nguoi_tao_id,
                $tong_tien
            );

            error_log("dat_tour_id inserted: $dat_tour_id");

            foreach ($ds_khach as $kh) {
                $this->modelBooking->insertListKhachHang(
                    $dat_tour_id,
                    $kh['ho_ten'],
                    $kh['so_dien_thoai'],
                    $kh['email'],
                    $kh['gioi_tinh'],
                    $kh['cccd'],
                    $kh['ngay_sinh'],
                    $kh['ghi_chu'] ?? '',
                    $kh['so_ghe'] ?? null
                );
            }

            error_log("=== Booking saved successfully ===");

            // Xong → chuyển trang
            header("Location:" . BASE_URL_ADMIN . '?act=booking');
            exit();
        }
    }

    public function formEditBooking()
    {
        // hàm này dùng để nhập form sản phẩm
        $id = $_GET['id_booking'];
        $listBookingID = $this->modelBooking->getAllBookingID($id);
        $listHanhKhach = $this->modelBooking->getAllHanhKhachID($id);
        $listLichAndTour = $this->modelBooking->getAllLichAndTour();

        // Lấy lỗi và dữ liệu cũ từ session
        $error = $_SESSION['error'] ?? [];
        $old   = $_SESSION['old']   ?? [];

        // printf('<pre>%s</pre>', print_r($listBookingID, true));
        // die();
        if ($listBookingID) {
            require_once './views/booking/editBooking.php';
            deleteSessionError();
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=booking');
            exit();
        }
    }

    public function postEditBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $dat_tour_id = $_POST['dat_tour_id'];
            $khach_hang_id = $_POST['khach_hang_id'];

            $lich_id = $_POST['lich_id'];
            $loai = $_POST['loai'];
            $so_nguoi = $_POST['so_nguoi'];
            $ghi_chu = $_POST['ghi_chu'];
            $tong_tien = $_POST['tong_tien'];
            $nguoi_tao_id = $_POST['nguoi_tao_id'] ?? null;

            // Thông tin người đặt tour
            $ho_ten = $_POST['ho_ten'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $email = $_POST['email'];
            $cccd = $_POST['cccd'];
            $dia_chi = $_POST['dia_chi'];

            // Danh sách khách hàng từ form
            $ds_khach = $_POST['ds_khach'] ?? [];

            // Mảng lỗi
            $error = [];

            // Validate cơ bản
            if (empty($lich_id)) {
                $error['lich_id'] = "Vui lòng chọn lịch tour.";
            }

            if (empty($loai)) {
                $error['loai'] = "Vui lòng chọn loại tour.";
            }

            if (empty($so_nguoi)) {
                $error['so_nguoi'] = "Vui lòng nhập số lượng người.";
            } elseif ($so_nguoi <= 0) {
                $error['so_nguoi'] = "Số lượng người phải lớn hơn 0.";
            }

            if (empty($ho_ten)) {
                $error['ho_ten'] = "Tên khách hàng không được để trống.";
            }

            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = "Số điện thoại không được để trống.";
            } elseif (!preg_match('/^[0-9]{9,11}$/', $so_dien_thoai)) {
                $error['so_dien_thoai'] = "Số điện thoại không hợp lệ.";
            }

            if (empty($email)) {
                $error['email'] = "Email không được để trống.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Email không hợp lệ.";
            }

            if (empty($cccd)) {
                $error['cccd'] = "CCCD không được để trống.";
            } elseif (!preg_match('/^[0-9]{12}$/', $cccd)) {
                $error['cccd'] = "CCCD phải đúng 12 số.";
            }

            if (empty($dia_chi)) {
                $error['dia_chi'] = "Địa chỉ không được để trống.";
            }

            // Validate từng khách trong danh sách
            if (!empty($ds_khach)) {
                foreach ($ds_khach as $index => $kh) {

                    if (empty($kh['ho_ten'])) {
                        $error["ds_khach_{$index}_ho_ten"] = "Khách hàng số " . ($index + 1) . " chưa nhập họ tên.";
                    }

                    if (empty($kh['gioi_tinh'])) {
                        $error["ds_khach_{$index}_gioi_tinh"] = "Khách hàng số " . ($index + 1) . " chưa chọn giới tính.";
                    }

                    if (empty($kh['so_dien_thoai'])) {
                        $error["ds_khach_{$index}_so_dien_thoai"] = "Khách hàng số " . ($index + 1) . " chưa nhập số điện thoại.";
                    } elseif (!preg_match('/^[0-9]{9,11}$/', $kh['so_dien_thoai'])) {
                        $error["ds_khach_{$index}_so_dien_thoai"] = "Số điện thoại khách hàng số " . ($index + 1) . " không hợp lệ.";
                    }

                    if (empty($kh['email'])) {
                        $error["ds_khach_{$index}_email"] = "Khách hàng số " . ($index + 1) . " chưa nhập email.";
                    } elseif (!filter_var($kh['email'], FILTER_VALIDATE_EMAIL)) {
                        $error["ds_khach_{$index}_email"] = "Email của khách hàng số " . ($index + 1) . " không hợp lệ.";
                    }

                    if (empty($kh['cccd'])) {
                        $error["ds_khach_{$index}_cccd"] = "Khách hàng số " . ($index + 1) . " chưa nhập CCCD.";
                    } elseif (!preg_match('/^[0-9]{9,12}$/', $kh['cccd'])) {
                        $error["ds_khach_{$index}_cccd"] = "CCCD của khách hàng số " . ($index + 1) . " không hợp lệ.";
                    }

                    if (empty($kh['ngay_sinh'])) {
                        $error["ds_khach_{$index}_ngay_sinh"] = "Khách hàng số " . ($index + 1) . " chưa chọn ngày sinh.";
                    }
                }
            }

            // Nếu có lỗi → trả về form
            if (!empty($error)) {
                $_SESSION['flash'] = true;      // cờ báo có lỗi
                $_SESSION['error'] = $error;    // lưu lỗi
                $_SESSION['old']   = $_POST;    // lưu dữ liệu cũ

                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-booking&id_booking=' . $dat_tour_id);
                exit();
            }

            // 1. Lấy danh sách hành khách cũ
            $oldList = $this->modelBooking->getAllHanhKhachID($dat_tour_id);
            $oldIds = array_column($oldList, 'hanh_khach_id');

            // Mảng lưu ID hành khách mới còn tồn tại
            $currentIds = [];

            // 2. XỬ LÝ DANH SÁCH KHÁCH GỬI LÊN
            foreach ($ds_khach as $kh) {

                $hanh_khach_id = $kh['hanh_khach_id'] ?? null;

                // Nếu tồn tại -> UPDATE
                if (!empty($hanh_khach_id)) {

                    $currentIds[] = $hanh_khach_id;

                    $this->modelBooking->updateListKhachHang(
                        $hanh_khach_id,
                        $kh['ho_ten'],
                        $kh['so_dien_thoai'],
                        $kh['email'],
                        $kh['gioi_tinh'],
                        $kh['cccd'],
                        $kh['ngay_sinh'],
                        $kh['ghi_chu'] ?? '',
                        $kh['so_ghe'] ?? null
                    );
                } else {

                    // KHÁCH MỚI -> INSERT
                    $this->modelBooking->insertListKhachHang(
                        $dat_tour_id,
                        $kh['ho_ten'],
                        $kh['so_dien_thoai'],
                        $kh['email'],
                        $kh['gioi_tinh'],
                        $kh['cccd'],
                        $kh['ngay_sinh'],
                        $kh['ghi_chu'] ?? '',
                        $kh['so_ghe'] ?? null
                    );
                }
            }

            // 3. XÓA HÀNH KHÁCH BỊ GIẢM (không còn trong form)
            foreach ($oldIds as $oldId) {
                if (!in_array($oldId, $currentIds)) {
                    $this->modelBooking->deleteListKhachHang($oldId);
                }
            }

            // 4. UPDATE THÔNG TIN NGƯỜI ĐẶT
            $this->modelBooking->updateKhachHang(
                $khach_hang_id,
                $ho_ten,
                $so_dien_thoai,
                $email,
                $cccd,
                $dia_chi
            );

            // 5. UPDATE THÔNG TIN BOOKING
            $this->modelBooking->updateBooking(
                $dat_tour_id,
                $lich_id,
                $loai,
                $so_nguoi,
                $ghi_chu,
                $khach_hang_id,
                $nguoi_tao_id,
                $tong_tien
            );

            header("Location:" . BASE_URL_ADMIN . '?act=booking');
            exit();
        }
    }

    public function deleteBooking()
    {
        // hàm này dùng để xóa danh mục
        $id = $_GET['id_booking'];
        $Booking = $this->modelBooking->getDetailBooking($id);
        $HanhKhach = $this->modelBooking->getAllHanhKhachID($id);
        if ($Booking) {
            $this->modelBooking->destroyKhachHang($Booking['khach_hang_id']);
            foreach ($HanhKhach as $khach) {
                $this->modelBooking->destroyListKhachHang($khach['hanh_khach_id']);
            }
            $this->modelBooking->destroyBooking($id);
        }
        header("Location:" . BASE_URL_ADMIN . '?act=booking');
        exit();
    }

    public function bookingDetail()
    {
        $id_booking = $_GET['id_booking'] ?? null;
        if (empty($id_booking)) {
            header("Location:" . BASE_URL_ADMIN . '?act=booking');
            exit();
        }

        $bookingInfo = $this->modelBooking->getAllBookingID($id_booking);
        if (!$bookingInfo) {
            header("Location:" . BASE_URL_ADMIN . '?act=booking');
            exit();
        }

        $hanhKhachList = $this->modelBooking->getAllHanhKhachID($id_booking);

        require_once './views/booking/bookingDetail.php';
    }
}
