<?php
/**
 * ============================================================================
 * ADMIN TAI KHOAN QUAN TRI CONTROLLER
 * ============================================================================
 * Quản lý tài khoản Admin (vai_tro_id = 1)
 * - CRUD: List, Add, Edit, Delete, Reset Password
 * - Validation đầy đủ
 * ============================================================================
 */

class AdminTaiKhoanQuanTriController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }

    // ========================================================================
    // === LIST - DANH SÁCH QUẢN TRỊ VIÊN ===
    // ========================================================================
    
    public function danhSachQuanTri()
    {
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoanByVaiTro(1); // vai_tro_id = 1 (Admin)
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }

    // ========================================================================
    // === ADD - THÊM QUẢN TRỊ VIÊN ===
    // ========================================================================
    
    public function formAddQuanTri()
    {
        require_once './views/taikhoan/quantri/addQuanTri.php';
    }

    public function postAddQuanTri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $mat_khau = $_POST['mat_khau'] ?? '';
            $xac_nhan_mat_khau = $_POST['xac_nhan_mat_khau'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? 'active';

            $error = [];

            // Validation Họ tên
            if (empty($ho_ten)) {
                $error['ho_ten'] = 'Họ tên không được để trống';
            } elseif (strlen($ho_ten) < 3) {
                $error['ho_ten'] = 'Họ tên phải có ít nhất 3 ký tự';
            }

            // Validation Email
            if (empty($email)) {
                $error['email'] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'Email không đúng định dạng';
            } elseif ($this->modelTaiKhoan->checkEmailExists($email)) {
                $error['email'] = 'Email đã tồn tại trong hệ thống';
            }

            // Validation Số điện thoại
            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số điện thoại không được để trống';
            } elseif (!preg_match('/^[0-9]{9,11}$/', $so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số điện thoại phải từ 9-11 số';
            }

            // Validation Mật khẩu
            if (empty($mat_khau)) {
                $error['mat_khau'] = 'Mật khẩu không được để trống';
            } elseif (strlen($mat_khau) < 6) {
                $error['mat_khau'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }

            // Validation Xác nhận mật khẩu
            if (empty($xac_nhan_mat_khau)) {
                $error['xac_nhan_mat_khau'] = 'Vui lòng xác nhận mật khẩu';
            } elseif ($mat_khau !== $xac_nhan_mat_khau) {
                $error['xac_nhan_mat_khau'] = 'Xác nhận mật khẩu không khớp';
            }

            // Set session errors
            if (!empty($error)) {
                $_SESSION['error'] = $error;
                $_SESSION['old'] = $_POST;
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                exit();
            }

            // If no errors, proceed to insert
            $password_hash = password_hash($mat_khau, PASSWORD_BCRYPT);
            $vai_tro_id = 1; // Admin
            
            $result = $this->modelTaiKhoan->insertTaiKhoanArray([
                'email' => $email,
                'mat_khau' => $password_hash,
                'ho_ten' => $ho_ten,
                'so_dien_thoai' => $so_dien_thoai,
                'vai_tro_id' => $vai_tro_id,
                'trang_thai' => $trang_thai
            ]);

            if ($result) {
                $_SESSION['success'] = 'Thêm quản trị viên thành công!';
                unset($_SESSION['error'], $_SESSION['old']);
                header("Location: " . BASE_URL_ADMIN . '?act=danh-sach-quan-tri');
                exit();
            } else {
                $_SESSION['error'] = ['general' => 'Có lỗi xảy ra khi thêm tài khoản'];
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                exit();
            }
        }
    }

    // ========================================================================
    // === EDIT - SỬA QUẢN TRỊ VIÊN ===
    // ========================================================================
    
    public function formEditQuanTri()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'Không tìm thấy tài khoản';
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }

        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        
        if (!$quanTri || $quanTri['vai_tro_id'] != 1) {
            $_SESSION['error'] = 'Tài khoản không tồn tại hoặc không phải quản trị viên';
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }

        require_once './views/taikhoan/quantri/editQuanTri.php';
    }

    public function postEditQuanTri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['nguoi_dung_id'] ?? null;
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $trang_thai = $_POST['trang_thai'] ?? 'active';

            $error = [];

            // Validation
            if (empty($ho_ten)) {
                $error['ho_ten'] = 'Họ tên không được để trống';
            } elseif (strlen($ho_ten) < 3) {
                $error['ho_ten'] = 'Họ tên phải có ít nhất 3 ký tự';
            }

            if (empty($email)) {
                $error['email'] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'Email không đúng định dạng';
            } else {
                // Check email duplicate (exclude current user)
                if ($this->modelTaiKhoan->checkEmailExistsExcept($email, $id)) {
                    $error['email'] = 'Email đã tồn tại trong hệ thống';
                }
            }

            if (empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số điện thoại không được để trống';
            } elseif (!preg_match('/^[0-9]{9,11}$/', $so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Số điện thoại phải từ 9-11 số';
            }

            $_SESSION['error'] = $error;
            $_SESSION['old'] = $_POST;

            if (empty($error)) {
                $result = $this->modelTaiKhoan->updateTaiKhoanArray($id, [
                    'email' => $email,
                    'ho_ten' => $ho_ten,
                    'so_dien_thoai' => $so_dien_thoai,
                    'trang_thai' => $trang_thai
                ]);

                if ($result) {
                    $_SESSION['success'] = 'Cập nhật quản trị viên thành công!';
                    unset($_SESSION['error'], $_SESSION['old']);
                    header("Location: " . BASE_URL_ADMIN . '?act=danh-sach-quan-tri');
                    exit();
                } else {
                    $_SESSION['error']['general'] = 'Có lỗi xảy ra khi cập nhật tài khoản';
                }
            }

            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id=' . $id);
            exit();
        }
    }

    // ========================================================================
    // === RESET PASSWORD ===
    // ========================================================================
    
    public function resetPassword()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'Không tìm thấy tài khoản';
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }

        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        
        if (!$quanTri || $quanTri['vai_tro_id'] != 1) {
            $_SESSION['error'] = 'Tài khoản không tồn tại hoặc không phải quản trị viên';
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }

        // Reset password to default
        $default_password = '123@123ab';
        $password_hash = password_hash($default_password, PASSWORD_BCRYPT);
        
        $result = $this->modelTaiKhoan->resetPassword($id, $password_hash);

        if ($result) {
            $_SESSION['success'] = "Đã reset mật khẩu thành công! Mật khẩu mới: $default_password";
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi reset mật khẩu';
        }

        header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
        exit();
    }

    // ========================================================================
    // === DELETE ===
    // ========================================================================
    
    public function deleteQuanTri()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'Không tìm thấy tài khoản';
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }

        // Prevent deleting yourself
        if ($id == $_SESSION['user_admin']['nguoi_dung_id']) {
            $_SESSION['error'] = 'Không thể xóa tài khoản của chính bạn!';
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }

        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        
        if (!$quanTri || $quanTri['vai_tro_id'] != 1) {
            $_SESSION['error'] = 'Tài khoản không tồn tại hoặc không phải quản trị viên';
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }

        $result = $this->modelTaiKhoan->deleteTaiKhoan($id);

        if ($result) {
            $_SESSION['success'] = 'Xóa quản trị viên thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa tài khoản';
        }

        header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
        exit();
    }
}
