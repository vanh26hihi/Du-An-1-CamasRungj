<?php
/**
 * Script để hash lại mật khẩu trong database
 * Chạy một lần để chuyển từ plain text sang bcrypt hash
 */

require_once '../commons/env.php';
require_once '../commons/function.php';

$conn = connectDB();

// Mật khẩu mặc định là '123@123ab'
$default_password = '123@123ab';
$hashed_password = password_hash($default_password, PASSWORD_BCRYPT);

echo "Đang cập nhật mật khẩu...\n";
echo "Mật khẩu mới cho tất cả tài khoản: $default_password\n\n";

try {
    // Cập nhật tất cả tài khoản với mật khẩu đã hash
    $sql = "UPDATE nguoi_dung SET mat_khau = :mat_khau";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':mat_khau' => $hashed_password]);
    
    $count = $stmt->rowCount();
    
    echo "✅ Đã cập nhật $count tài khoản thành công!\n";
    echo "Hash mới: $hashed_password\n\n";
    echo "Bạn có thể đăng nhập với:\n";
    echo "- Email: admin@travel.com\n";
    echo "- Password: $default_password\n";
    
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
}
