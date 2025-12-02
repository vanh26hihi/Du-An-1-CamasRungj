<?php
class AdminTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }


    public function danhSachQuanTri()
    {
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }
    public function formAddQuanTri()
    {
        require_once './views/taikhoan/quantri/addQuanTri.php';
        deleteSessionError();
    }
    public function postAddQuanTri()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $error = [];
            if (empty($ho_ten)) {
                $error['ho_ten'] = 'Họ Tên Không Được Để Trống';
            }
            if (empty($email)) {
                $error['email'] = 'Email Không Được Để Trống';
            }
            $_SESSION['error'] = $error;
            $chuc_vu_id = 1;

            //Nếu Không có lỗi thì tiến hành thêm danh mục
            if (empty($error)) {
                $password = password_hash('123@123ab', PASSWORD_BCRYPT);
                $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                $_SESSION['flash'] = true;
                // Trả về form vá lỗi
                require_once './views/taikhoan/quantri/addQuanTri.php';
                exit();
            }
        }
    }

    public function formEditQuanTri()
    {
        $id_quan_tri = $_GET['id_quan_tri'];
        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id_quan_tri);
        $trangThai = $this->modelTaiKhoan->getAllTrangThai();
        require_once './views/taikhoan/quantri/editQuanTri.php';
        deleteSessionError();
    }

    public function formEditKhachHang()
    {
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        $trangThai = $this->modelTaiKhoan->getAllTrangThai();
        $gioiTinh = $this->modelTaiKhoan->getAllGioiTinh();
        require_once './views/taikhoan/khachhang/editKhachHang.php';
        deleteSessionError();
    }

    public function postEditQuanTri()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $id_khach_hang = $_POST['khach_hang_id'];
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $trang_thai = $_POST['trang_thai'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $error = [];
            if (empty($ho_ten)) {
                $error['ho_ten'] = 'Tên Người Dùng Không Được Để Trống';
            }
            if (empty($email)) {
                $error['email'] = 'Email Không Được Để Trống';
            }
            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số Điện Thoại Không Được Để Trống';
            }

            $_SESSION['error'] = $error;

            //Nếu Không có lỗi thì tiến hành thêm danh mục
            if (empty($error)) {
                $this->modelTaiKhoan->updateTaiKhoan($id_khach_hang, $ho_ten, $email, $so_dien_thoai, $trang_thai);
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                $_SESSION['flash'] = true;
                // Trả về form vá lỗi
                require_once './views/taikhoan/quantri/editQuanTri.php?act=' . $id_khach_hang;
                exit();
            }
        }
    }

    public function postEditKhachHang()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $khach_hang_id = $_POST['khach_hang_id'];
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $trang_thai = $_POST['trang_thai'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $ngay_sinh = $_POST['ngay_sinh'];
            $dia_chi = $_POST['dia_chi'];
            $gioi_tinh = $_POST['gioi_tinh'];
            $error = [];
            if (empty($ho_ten)) {
                $error['ho_ten'] = 'Tên Người Dùng Không Được Để Trống';
            }
            if (empty($email)) {
                $error['email'] = 'Email Không Được Để Trống';
            }
            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số Điện Thoại Không Được Để Trống';
            }
            if (empty($ngay_sinh)) {
                $error['so_dien_thoai'] = 'Số Điện Thoại Không Được Để Trống';
            }

            $_SESSION['error'] = $error;

            //Nếu Không có lỗi thì tiến hành thêm danh mục
            if (empty($error)) {
                $this->modelTaiKhoan->updateKhachHang($khach_hang_id, $ho_ten, $email, $so_dien_thoai, $gioi_tinh, $dia_chi, $ngay_sinh, $trang_thai);
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
                exit();
            } else {
                $_SESSION['flash'] = true;
                // Trả về form vá lỗi
                require_once './views/taikhoan/khachhang/editKhachHang.php?act=' . $khach_hang_id;
                exit();
            }
        }
    }

    public function resetPassword()
    {
        $tai_khoan_id = $_GET['id_khach_hang'];
        $tai_khoan = $this->modelTaiKhoan->getDetailTaiKhoan($tai_khoan_id);
        $password = password_hash('123@123ab', PASSWORD_BCRYPT);
        $atatus = $this->modelTaiKhoan->resetPassword($tai_khoan_id, $password);
        if ($atatus && $tai_khoan['chuc_vu_id'] == 1) {
            header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
        } else if ($atatus && $tai_khoan['chuc_vu_id'] == 2) {
            header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
        } else {
            var_dump("Lỗi Khi reset tài khoản");
            die;
        }
    }

    public function danhSachKhachHang()
    {
        $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);
        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }

    public function detailKhachHang()
    {
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang  = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        $trangThai  = $this->modelTaiKhoan->getAllTrangThai();

        // TODO: Cần tạo model cho đơn hàng và bình luận
        $listDonHang = [];
        $listBinhLuan = [];

        require_once './views/taikhoan/khachhang/detailKhachHang.php';
    }

    public function formLogin()
    {
        // Nếu đã đăng nhập, chuyển về trang chủ admin
        if (isset($_SESSION['user_admin'])) {
            header('Location: ' . BASE_URL_ADMIN);
            exit();
        }

        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validate input
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ email và mật khẩu';
                $_SESSION['old_email'] = $email;
                header('Location: ' . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Kiểm tra đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            if ($user['trang_thai'] === true) {
                // Đăng nhập thành công - Lưu toàn bộ thông tin user vào session
                $_SESSION['user_admin'] = $user['user'];

                // Xóa session lỗi và email cũ
                unset($_SESSION['error']);
                unset($_SESSION['old_email']);

                header('Location: ' . BASE_URL_ADMIN);
                exit();
            } else {
                // Đăng nhập thất bại
                $_SESSION['error'] = $user['message'];
                $_SESSION['old_email'] = $email;
                header('Location: ' . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }
        }
    }
    public function logout()
    {
        if (isset($_SESSION['user_admin'])) {
            unset($_SESSION['user_admin']);
            unset($_SESSION['old_email']);
            unset($_SESSION['error']);
        }
        header('Location: ' . BASE_URL_ADMIN . '?act=login-admin');
    }

    public function formEditCaNhanQuanTri()
    {
        $email = $_SESSION['user_admin']['email'];
        $thongTin = $this->modelTaiKhoan->getTaiKhoanFormEmail($email);
        $gioiTinh = $this->modelTaiKhoan->getAllGioiTinh();
        require_once './views/taikhoan/canhan/editCaNhan.php';
        deleteSessionError();
    }

    public function postEditCaNhanQuanTri()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $id_ca_nhan = $_POST['id_ca_nhan'];
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $ngay_sinh = $_POST['ngay_sinh'];
            $dia_chi = $_POST['dia_chi'];
            $gioi_tinh = $_POST['gioi_tinh'];
            $error = [];
            if (empty($ho_ten)) {
                $error['ho_ten'] = 'Tên Người Dùng Không Được Để Trống';
            }
            if (empty($email)) {
                $error['email'] = 'Email Không Được Để Trống';
            }
            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số Điện Thoại Không Được Để Trống';
            }
            if (empty($ngay_sinh)) {
                $error['so_dien_thoai'] = 'Số Điện Thoại Không Được Để Trống';
            }
            if (empty($ho_ten)) {
                $error['so_dien_thoai'] = 'Số Điện Thoại Không Được Để Trống';
            }

            $_SESSION['error'] = $error;

            //Nếu Không có lỗi thì tiến hành thêm danh mục
            if (empty($error)) {
                $this->modelTaiKhoan->updateCaNhanQuanTri($id_ca_nhan, $ho_ten, $email, $so_dien_thoai, $gioi_tinh, $dia_chi, $ngay_sinh);
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
                exit();
            } else {
                $_SESSION['flash'] = true;
                // Trả về form vá lỗi
                require_once './views/taikhoan/canhang/editCaNhan.php';
                exit();
            }
        }
    }

    public function postEditMatKhauCaNhanQuanTri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $old_pass = $_POST['old_pass'] ?? '';
            $new_pass = $_POST['new_pass'] ?? '';
            $confirm_pass = $_POST['confirm_pass'] ?? '';

            // Lấy thông tin tài khoản từ email
            $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($email);

            // Nếu không tìm thấy user
            if (!$user) {
                $_SESSION['error_pass'] = "Tài khoản không tồn tại.";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }
            //kiểm tra xem đã nhập toàn bộ form mật khẩu chưa
            if ($old_pass == '' && $new_pass == '' && $confirm_pass == '') {
                $_SESSION['error_pass'] = "Vui Lòng Nhập Mật Khẩu Cũ Và Mới Để Đổi";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri&id");
                exit();
            }

            // Kiểm tra mật khẩu cũ
            if (!password_verify($old_pass, $user['mat_khau'])) {
                $_SESSION['error_pass'] = "Mật khẩu cũ không chính xác.";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            // Kiểm tra mật khẩu mới và xác nhận
            if ($new_pass !== $confirm_pass) {
                $_SESSION['error_pass'] = "Mật khẩu mới và xác nhận không trùng khớp.";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            // Có thể thêm điều kiện kiểm tra độ mạnh của mật khẩu ở đây
            // Ví dụ: độ dài tối thiểu 6 ký tự
            if (strlen($new_pass) < 6) {
                $_SESSION['error_pass'] = "Mật khẩu mới phải có ít nhất 6 ký tự.";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri&id");
                exit();
            }


            // Mã hóa mật khẩu mới
            $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);

            // Cập nhật vào DB
            $this->modelTaiKhoan->updateMatKhau($user['id'], $hashed_pass);

            // Thông báo thành công
            $_SESSION['success_pass'] = "Đổi mật khẩu thành công!";
            header("Location: " . BASE_URL_ADMIN . "?act=form-doi-mat-khau");
            exit();
        }
    }
}
