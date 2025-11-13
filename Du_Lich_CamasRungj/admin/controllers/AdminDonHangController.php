<?php
class AdminDonHangController
{
    public $modelDonHang;
    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
    }

    // Lấy ra đơn hàng
    public function danhSachDonHang()
    {
        $listDonHang = $this->modelDonHang->getAllDonHang();
        require_once './views/DonHang/listDonHang.php';
    }

    // Chuyển đến form edit đơn hàng
    public function formEditDonHang()
    {
        // hàm này dùng để nhập form đơn hàng
        $id = $_GET['id'];
        $DonHang = $this->modelDonHang->getDetailDonHang($id);
        $TrangThai = $this->modelDonHang->getAllTrangThai();
        $ThanhToan = $this->modelDonHang->getAllThanhToan();
        if ($DonHang) {
            require_once './views/DonHang/editDonHang.php';
            deleteSessionError();
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
        //Xóa session sau khi load lại trang;
    }

    // Bắt đầu validate form và edit đơn hàng
    public function postEditDonHang()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $id_don_hang = $_POST['id'] ?? '';
            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? '';
            $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
            $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
            $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
            $ghi_chu = $_POST['ghi_chu'] ?? '';
            $trang_thai_id = $_POST['trang_thai_id'] ?? $_POST['old_trang_thai'];


            // validate form Edit đơn hàng
            $error = [];

            if (empty($ten_nguoi_nhan)) {
                $error['ten_nguoi_nhan'] = 'Tên Người Nhận Không Được Để Trống';
            }

            if (empty($email_nguoi_nhan)) {
                $error['email_nguoi_nhan'] = 'Email Không Được Để Trống';
            }

            if (empty($sdt_nguoi_nhan)) {
                $error['sdt_nguoi_nhan'] = 'Số Điện Thoại Không Được Để Trống';
            }

            if (empty($dia_chi_nguoi_nhan)) {
                $error['dia_chi_nguoi_nhan'] = 'Địa Chỉ Không Được Để Trống';
            }

            if (empty($error)) {
                //Nếu Không có lỗi thì tiến hành thêm đơn hàng
                // var_dump("Oke");
                // die();
                // $don_hang_id =
                $this->modelDonHang->updateDonHang(
                    $id_don_hang,
                    $ten_nguoi_nhan,
                    $email_nguoi_nhan,
                    $sdt_nguoi_nhan,
                    $dia_chi_nguoi_nhan,
                    $ghi_chu,
                    $trang_thai_id
                );
                header("Location:" . BASE_URL_ADMIN . '?act=don-hang');
                exit();
            } else {
                // Trả về form vá lỗi
                //  đặt chỉ thị xóa session k=sau khi thi triển
                $_SESSION['old_data'] = $_POST;
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-don-hang&id=' . $id_don_hang);
                exit();
            }
        }
    }

    public function detailDonHang()
    {
        // hàm này dùng để nhập form đơn hàng
        $id = $_GET['id'];
        $DonHang = $this->modelDonHang->getDetailDonHang($id);
        $sanPhamDonHang = $this->modelDonHang->getListSPDonHang($id);
        $trangThai = $this->modelDonHang->getAllTrangThai();
        require_once './views/DonHang/detailDonHang.php';
    }
}
