<?php
session_start();
require_once '../commons/env.php';
require_once '../commons/function.php';

// Chỉ cho phép admin truy cập
if (!isset($_SESSION['user_admin']) || $_SESSION['user_admin']['vai_tro_id'] != 1) {
    die("Bạn không có quyền truy cập trang này!");
}

$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    $default_password = '123@123ab';
    $hashed_password = password_hash($default_password, PASSWORD_BCRYPT);
    
    try {
        $sql = "UPDATE nguoi_dung SET mat_khau = :mat_khau";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':mat_khau' => $hashed_password]);
        
        $count = $stmt->rowCount();
        $success = "✅ Đã reset mật khẩu cho $count tài khoản thành công! Mật khẩu mới: <strong>$default_password</strong>";
    } catch (PDOException $e) {
        $error = "❌ Lỗi: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Mật Khẩu Hệ Thống</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #28a745;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            border: 1px solid #dc3545;
            color: #721c24;
        }
        button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            background: #c82333;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        ul {
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Reset Mật Khẩu Hệ Thống</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
            <a href="<?= BASE_URL_ADMIN ?>"><button class="btn-secondary">Quay về Admin Panel</button></a>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php else: ?>
            <div class="alert alert-warning">
                <strong>⚠️ CẢNH BÁO:</strong> Hành động này sẽ:
                <ul>
                    <li>Reset mật khẩu của <strong>TẤT CẢ</strong> tài khoản trong hệ thống</li>
                    <li>Mật khẩu mới: <strong>123@123ab</strong></li>
                    <li>Áp dụng cho Admin, HDV, và Khách hàng</li>
                </ul>
            </div>
            
            <form method="POST">
                <button type="submit" name="confirm" value="1">
                    🔄 Xác Nhận Reset Mật Khẩu
                </button>
                <a href="<?= BASE_URL_ADMIN ?>"><button type="button" class="btn-secondary">❌ Hủy Bỏ</button></a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
