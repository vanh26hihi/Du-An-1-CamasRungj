<?php
/**
 * ============================================================================
 * ADMIN TAI KHOAN CA NHAN CONTROLLER
 * ============================================================================
 * Quản lý tài khoản cá nhân của user đang đăng nhập
 * - Chỉnh sửa thông tin cá nhân
 * - Đổi mật khẩu
 * ============================================================================
 */

class AdminTaiKhoanCaNhanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }

    // ========================================================================
    // === FORM EDIT THÔNG TIN CÁ NHÂN ===
    // ========================================================================
    
    public function formEditCaNhan()
    {
        $email = $_SESSION['user_admin']['email'];
        $thongTin = $this->modelTaiKhoan->getTaiKhoanFormEmail($email);
        
        if (!$thongTin) {
            $_SESSION['error'] = 'Không tìm thấy thông tin tài khoản';
            header("Location: " . BASE_URL_ADMIN);
            exit();
        }

        require_once './views/taikhoan/canhan/editCaNhan.php';
    }

    // ========================================================================
    // === POST EDIT THÔNG TIN CÁ NHÂN ===
    // ========================================================================
    
    public function postEditCaNhan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nguoi_dung_id = $_POST['nguoi_dung_id'] ?? null;
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');

            $error = [];

            // Validation
            if (empty($ho_ten)) {
                $error['ho_ten'] = 'Họ tên không được để trống';
            } elseif (strlen($ho_ten) < 3) {
                $error['ho_ten'] = 'Họ tên phải có ít nhất 3 ký tự';
            }

            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số điện thoại không được để trống';
            } elseif (!preg_match('/^[0-9]{9,11}$/', $so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số điện thoại phải từ 9-11 số';
            }

            if (!empty($error)) {
                $_SESSION['error'] = $error;
                $_SESSION['old'] = $_POST;
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
                exit();
            }

            // Update thông tin
            $result = $this->modelTaiKhoan->updateTaiKhoanArray($nguoi_dung_id, [
                'ho_ten' => $ho_ten,
                'email' => $_SESSION['user_admin']['email'], // Giữ nguyên email
                'so_dien_thoai' => $so_dien_thoai,
                'trang_thai' => 'active' // Giữ nguyên trạng thái
            ]);

            if ($result) {
                // Update session info
                $_SESSION['user_admin']['ho_ten'] = $ho_ten;
                $_SESSION['user_admin']['so_dien_thoai'] = $so_dien_thoai;
                
                $_SESSION['success'] = 'Cập nhật thông tin cá nhân thành công!';
                unset($_SESSION['error'], $_SESSION['old']);
            } else {
                $_SESSION['error'] = ['general' => 'Có lỗi xảy ra khi cập nhật thông tin'];
                $_SESSION['flash'] = true;
            }

            header("Location: " . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
            exit();
        }
    }

    // ========================================================================
    // === POST ĐỔI MẬT KHẨU ===
    // ========================================================================
    
    public function postEditMatKhau()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $old_pass = $_POST['old_pass'] ?? '';
            $new_pass = $_POST['new_pass'] ?? '';
            $confirm_pass = $_POST['confirm_pass'] ?? '';

            // Lấy thông tin tài khoản từ email
            $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($email);

            if (!$user) {
                $_SESSION['error_pass'] = "Tài khoản không tồn tại";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            // Validation
            if (empty($old_pass)) {
                $_SESSION['error_pass'] = "Vui lòng nhập mật khẩu cũ";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            if (empty($new_pass)) {
                $_SESSION['error_pass'] = "Vui lòng nhập mật khẩu mới";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            if (empty($confirm_pass)) {
                $_SESSION['error_pass'] = "Vui lòng xác nhận mật khẩu mới";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            // Kiểm tra mật khẩu cũ
            $verify_result = password_verify($old_pass, $user['mat_khau']);
            
            if (!$verify_result) {
                $_SESSION['error_pass'] = "Mật khẩu cũ không chính xác";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            // Kiểm tra mật khẩu mới
            if (strlen($new_pass) < 6) {
                $_SESSION['error_pass'] = "Mật khẩu mới phải có ít nhất 6 ký tự";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            // Kiểm tra xác nhận mật khẩu
            if ($new_pass !== $confirm_pass) {
                $_SESSION['error_pass'] = "Mật khẩu mới và xác nhận không trùng khớp";
                header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
                exit();
            }

            // Mã hóa mật khẩu mới
            $hashed_pass = password_hash($new_pass, PASSWORD_BCRYPT);

            // Cập nhật vào DB
            $result = $this->modelTaiKhoan->updateMatKhau($user['nguoi_dung_id'], $hashed_pass);

            if ($result) {
                $_SESSION['success_pass'] = "Đổi mật khẩu thành công!";
            } else {
                $_SESSION['error_pass'] = "Có lỗi xảy ra khi đổi mật khẩu";
            }

            header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
            exit();
        }
    }
}
