<?php
session_start();
require_once '../commons/env.php';
require_once '../commons/function.php';

if (!isset($_SESSION['user_admin'])) {
    die("Vui lòng đăng nhập!");
}

$conn = connectDB();
$email = $_SESSION['user_admin']['email'];

$sql = "SELECT nguoi_dung_id, email, mat_khau, ho_ten FROM nguoi_dung WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

echo "<h2>Thông tin tài khoản của bạn:</h2>";
echo "<p><strong>ID:</strong> " . $user['nguoi_dung_id'] . "</p>";
echo "<p><strong>Email:</strong> " . $user['email'] . "</p>";
echo "<p><strong>Họ tên:</strong> " . $user['ho_ten'] . "</p>";
echo "<p><strong>Mật khẩu trong DB:</strong> <code>" . htmlspecialchars($user['mat_khau']) . "</code></p>";
echo "<p><strong>Độ dài:</strong> " . strlen($user['mat_khau']) . " ký tự</p>";

// Kiểm tra xem mật khẩu có phải là bcrypt hash không
$is_bcrypt = (strlen($user['mat_khau']) == 60 && substr($user['mat_khau'], 0, 4) === '$2y$');
echo "<p><strong>Định dạng:</strong> " . ($is_bcrypt ? "✅ Bcrypt Hash (Đã mã hóa)" : "⚠️ Plain Text (Chưa mã hóa)") . "</p>";

echo "<hr>";
echo "<h3>Test các mật khẩu phổ biến:</h3>";

$test_passwords = ['123@123ab', 'admin', '123456', 'password', '12345678'];

foreach ($test_passwords as $test_pass) {
    $verify = password_verify($test_pass, $user['mat_khau']);
    $plain_match = ($test_pass === $user['mat_khau']);
    
    if ($verify) {
        echo "<p>✅ Mật khẩu '<strong>$test_pass</strong>' - ĐÚNG (Bcrypt)</p>";
    } elseif ($plain_match) {
        echo "<p>✅ Mật khẩu '<strong>$test_pass</strong>' - ĐÚNG (Plain Text)</p>";
    } else {
        echo "<p>❌ Mật khẩu '<strong>$test_pass</strong>' - SAI</p>";
    }
}

echo "<hr>";
echo "<h3>Test mật khẩu tùy chỉnh:</h3>";

if (isset($_POST['test_pass'])) {
    $input = $_POST['test_pass'];
    $verify = password_verify($input, $user['mat_khau']);
    $plain_match = ($input === $user['mat_khau']);
    
    if ($verify) {
        echo "<p style='color: green; font-size: 18px;'>✅ Mật khẩu '<strong>$input</strong>' - ĐÚNG (Bcrypt)</p>";
    } elseif ($plain_match) {
        echo "<p style='color: green; font-size: 18px;'>✅ Mật khẩu '<strong>$input</strong>' - ĐÚNG (Plain Text)</p>";
    } else {
        echo "<p style='color: red; font-size: 18px;'>❌ Mật khẩu '<strong>$input</strong>' - SAI</p>";
    }
}
?>

<form method="POST">
    <input type="text" name="test_pass" placeholder="Nhập mật khẩu để test">
    <button type="submit">Kiểm tra</button>
</form>

<p><a href="<?= BASE_URL_ADMIN ?>">Quay về Admin</a></p>
