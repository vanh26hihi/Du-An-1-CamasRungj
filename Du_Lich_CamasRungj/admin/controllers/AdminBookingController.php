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
            $nguoi_tao_id = $_POST['nguoi_tao_id'] ?? null;

            //Thông tin người đặt tour
            $ho_ten = $_POST['ho_ten'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $email = $_POST['email'];
            $cccd = $_POST['cccd'];
            $dia_chi = $_POST['dia_chi'];

            //Danh Sách Khách Hàng
            $ds_khach = $_POST['ds_khach'];  // Nhận toàn bộ danh sách khách

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
            }


            $error = [];
            if (empty($ten_danh_muc)) {
                $error['ten_danh_muc'] = 'Tên Danh Mục Không Được Để Trống';
            }

            $_SESSION['error'] = $error;
            //Nếu Không có lỗi thì tiến hành thêm danh mục
            if (empty($error)) {
                $khach_hang_id = $this->modelBooking->insertKhachHang($ho_ten, $so_dien_thoai, $email, $cccd, $dia_chi);
                $dat_tour_id = $this->modelBooking->insertBooking($lich_id, $loai, $so_nguoi, $ghi_chu, $khach_hang_id, $nguoi_tao_id);
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
    // public function formEditBooking()
    // {
    //     // hàm này dùng để nhập form sản phẩm
    //     $id = $_GET['id_danh_muc'];
    //     $Booking = $this->modelBooking->getDetailBooking($id);
    //     if ($Booking) {
    //         require_once './views/Booking/editBooking.php';
    //         deleteSessionError();
    //     } else {
    //         header("Location:" . BASE_URL_ADMIN . '?act=booking');
    //         exit();
    //     }
    // }

    // public function postEditBooking()
    // {
    //     // hàm này dùng để thêm dữ liệu từ form
    //     // Kiểm tra xem dữ liệu có phải submit lên không
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         //lấy dữ liệu
    //         $ten_danh_muc = $_POST['ten_danh_muc'];
    //         $mo_ta = $_POST['mo_ta'];
    //         $id = $_POST['id'];
    //         $error = [];
    //         if (empty($ten_danh_muc)) {
    //             $error['ten_danh_muc'] = 'Tên Danh Mục Không Được Để Trống';
    //         }
    //         //Nếu Không có lỗi thì tiến hành sửa danh mục
    //         if (empty($error)) {
    //             //Nếu Không có lỗi thì tiến hành sửa danh mục
    //             // var_dump("Oke");

    //             $this->modelBooking->updateBooking($id, $ten_danh_muc, $mo_ta);
    //             header("Location:" . BASE_URL_ADMIN . '?act=booking');
    //             exit();
    //         } else {
    //             // Trả về form vá lỗi
    //             $Booking = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
    //             require_once './views/Booking/editBooking.php';
    //         }
    //     }
    // }
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
