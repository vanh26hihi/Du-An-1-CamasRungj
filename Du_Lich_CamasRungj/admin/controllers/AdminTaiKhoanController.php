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
            // Sanitize inputs
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Basic validation
            $errors = [];

            if (empty($email)) {
                $errors[] = 'Vui lòng nhập địa chỉ email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Địa chỉ email không hợp lệ';
            } elseif (strlen($email) > 255) {
                $errors[] = 'Email quá dài (tối đa 255 ký tự)';
            }

            if (empty($password)) {
                $errors[] = 'Vui lòng nhập mật khẩu';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
            } elseif (strlen($password) > 255) {
                $errors[] = 'Mật khẩu quá dài';
            }

            // If validation fails
            if (!empty($errors)) {
                $_SESSION['error'] = implode('<br>', $errors);
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Rate limiting check (prevent brute force)
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = [];
            }
            
            // Clean old attempts (older than 15 minutes)
            $_SESSION['login_attempts'] = array_filter($_SESSION['login_attempts'], function($time) {
                return $time > time() - 900;
            });
            
            // Check if too many attempts
            if (count($_SESSION['login_attempts']) >= 5) {
                $_SESSION['error'] = 'Quá nhiều lần đăng nhập thất bại. Vui lòng thử lại sau 15 phút';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Get user by email
            $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($email);

            // Check if user exists
            if (!$user) {
                $_SESSION['login_attempts'][] = time();
                $_SESSION['error'] = 'Email hoặc mật khẩu không chính xác';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Check password (support both hashed and plain text for backward compatibility)
            $verify_result = password_verify($password, $user['mat_khau']) || $password === $user['mat_khau'];
            if (!$verify_result) {
                $_SESSION['login_attempts'][] = time();
                $_SESSION['error'] = 'Email hoặc mật khẩu không chính xác';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Check account status
            if ($user['trang_thai'] !== 'active') {
                $_SESSION['error'] = 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên để được hỗ trợ';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Check role (only Admin and HDV can login)
            if (!in_array($user['vai_tro_id'], [1, 2])) {
                $_SESSION['error'] = 'Bạn không có quyền truy cập vào hệ thống quản trị';
                $_SESSION['old_email'] = $email;
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }

            // Login success - clear failed attempts and set session
            unset($_SESSION['login_attempts']);
            
            $_SESSION['user_admin'] = [
                'nguoi_dung_id' => $user['nguoi_dung_id'],
                'ho_ten' => $user['ho_ten'],
                'email' => $user['email'],
                'so_dien_thoai' => $user['so_dien_thoai'],
                'vai_tro_id' => $user['vai_tro_id'],
                'anh_dai_dien' => $user['anh_dai_dien'] ?? './assets/dist/img/user2-160x160.jpg'
            ];

            unset($_SESSION['error'], $_SESSION['old_email']);
            
            // Redirect to dashboard
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