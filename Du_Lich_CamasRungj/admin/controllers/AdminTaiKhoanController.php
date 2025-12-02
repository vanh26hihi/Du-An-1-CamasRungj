<?php
/**
 * ============================================================================
 * ADMIN TAI KHOAN CONTROLLER (Login/Logout only)
 * ============================================================================
 * Xử lý authentication cho admin panel
 * - Login
 * - Logout
 * 
 * Note: CRUD cho tài khoản đã tách sang:
 * - AdminTaiKhoanQuanTriController (Quản trị viên)
 * - AdminTaiKhoanHDVController (Hướng dẫn viên)
 * - AdminTaiKhoanCaNhanController (Tài khoản cá nhân)
 * ============================================================================
 */

class AdminTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }

    // ========================================================================
    // === FORM LOGIN ===
    // ========================================================================
    
    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    // ========================================================================
    // === CHECK LOGIN ===
    // ========================================================================
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validation
            if (empty($email)) {
                $_SESSION['error'] = 'Vui lòng nhập email';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            if (empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập mật khẩu';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Get user by email
            $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($email);

            // Check if user exists
            if (!$user) {
                $_SESSION['error'] = 'Email không tồn tại trong hệ thống';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Check password
            if (!password_verify($password, $user['mat_khau'])) {
                $_SESSION['error'] = 'Mật khẩu không chính xác';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Check account status
            if ($user['trang_thai'] !== 'active') {
                $_SESSION['error'] = 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Check role (only Admin and HDV can login)
            if (!in_array($user['vai_tro_id'], [1, 2])) {
                $_SESSION['error'] = 'Bạn không có quyền truy cập vào trang quản trị';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Login success - set session
            $_SESSION['user_admin'] = [
                'nguoi_dung_id' => $user['nguoi_dung_id'],
                'ho_ten' => $user['ho_ten'],
                'email' => $user['email'],
                'so_dien_thoai' => $user['so_dien_thoai'],
                'vai_tro_id' => $user['vai_tro_id'],
                'anh_dai_dien' => $user['anh_dai_dien'] ?? './assets/dist/img/user2-160x160.jpg'
            ];

            unset($_SESSION['error'], $_SESSION['old_email']);
            
            header("Location: " . BASE_URL_ADMIN);
            exit();
        }
    }

    // ========================================================================
    // === LOGOUT ===
    // ========================================================================
    
    public function logout()
    {
        if (isset($_SESSION['user_admin'])) {
            unset($_SESSION['user_admin']);
        }
        
        header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
        exit();
    }
}
