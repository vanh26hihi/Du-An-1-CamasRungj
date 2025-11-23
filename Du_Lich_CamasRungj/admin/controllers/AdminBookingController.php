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
        $listLichAndTour = $this->modelBooking->getAllLichAndTour();
        // var_dump($listLichAndTour);
        // die();
        // hàm này dùng để nhập form sản phẩm
        require_once './views/Booking/addBooking.php';
    }

    public function postAddBooking()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu

            $lich_id = $_POST['lich_id'];
            $loai = $_POST['loai'];
            $so_nguoi = $_POST['so_nguoi'];
            $ghi_chu = $_POST['ghi_chu'];
            $tong_tien = $_POST['tong_tien'];
            $nguoi_tao_id = $_POST['nguoi_tao_id'] ?? null;

            //Thông tin người đặt tour
            $ho_ten = $_POST['ho_ten'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $email = $_POST['email'];
            $cccd = $_POST['cccd'];
            $dia_chi = $_POST['dia_chi'];

            //Danh Sách Khách Hàng
            $ds_khach = $_POST['ds_khach'];  // Nhận toàn bộ danh sách khách


            $error = [];
            // if (empty($ten_danh_muc)) {
            //     $error['ten_danh_muc'] = 'Tên Danh Mục Không Được Để Trống';
            // }

            $_SESSION['error'] = $error;
            //Nếu Không có lỗi thì tiến hành thêm danh mục
            if (empty($error)) {
                $khach_hang_id = $this->modelBooking->insertKhachHang($ho_ten, $so_dien_thoai, $email, $cccd, $dia_chi);
                $dat_tour_id = $this->modelBooking->insertBooking($lich_id, $loai, $so_nguoi, $ghi_chu, $khach_hang_id, $nguoi_tao_id, $tong_tien);
                foreach ($ds_khach as $kh) {
                    $ho_ten_list = $kh['ho_ten'] ?? '';
                    $so_dien_thoai_list = $kh['so_dien_thoai'] ?? '';
                    $email_list = $kh['email'] ?? '';
                    $gioi_tinh_list = $kh['gioi_tinh'] ?? '';
                    $cccd_list = $kh['cccd'] ?? '';
                    $ngay_sinh_list = $kh['ngay_sinh'] ?? '';
                    $ghi_chu_list = $kh['ghi_chu'] ?? '';
                    $so_ghe_list = $kh['so_ghe'] ?? null;

                    // Thực hiện lưu DB
                    $this->modelBooking->insertListKhachHang($dat_tour_id, $ho_ten_list, $so_dien_thoai_list, $email_list, $gioi_tinh_list, $cccd_list, $ngay_sinh_list, $ghi_chu_list, $so_ghe_list);
                }

                header("Location:" . BASE_URL_ADMIN . '?act=booking');
                exit();
            } else {
                $_SESSION['flash'] = true;
                // Trả về form vá lỗi
                header("Location:" . BASE_URL_ADMIN . '?act=form-them-booking');
                exit();
            }
        }
    }
    public function formEditBooking()
    {
        // hàm này dùng để nhập form sản phẩm
        $id = $_GET['id_booking'];
        $listBookingID = $this->modelBooking->getAllBookingID($id);
        $listHanhKhach = $this->modelBooking->getAllHanhKhachID($id);
        $listLichAndTour = $this->modelBooking->getAllLichAndTour();
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
                        $dat_tour_id,
                        $kh['ho_ten'],
                        $kh['so_dien_thoai'],
                        $kh['email'],
                        $kh['gioi_tinh'],
                        $kh['cccd'],
                        $kh['ngay_sinh'],
                        $kh['ghi_chu'],
                        $kh['so_ghe']
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
                        $kh['ghi_chu'],
                        $kh['so_ghe']
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
                $dat_tour_id,
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

    // public function deleteBooking()
    // {
    //     // hàm này dùng để xóa danh mục
    //     $id = $_GET['id_danh_muc'];
    //     $Booking = $this->modelBooking->getDetailBooking($id);
    //     $msg = 'fail';
    //     if ($Booking) {
    //         $this->modelBooking->destroyBooking($id);
    //         $msg = 'success';
    //     }
    //     header("Location:" . BASE_URL_ADMIN . '?act=booking&msg=' . $msg);
    //     exit();
    // }
}
