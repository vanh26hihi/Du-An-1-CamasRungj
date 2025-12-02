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
echo "<p><strong>Hash trong DB:</strong> " . htmlspecialchars($user['mat_khau']) . "</p>";

echo "<h3>Test mật khẩu:</h3>";
$test_password = '123@123ab';
$verify = password_verify($test_password, $user['mat_khau']);
echo "<p>Mật khẩu '$test_password' " . ($verify ? "✅ ĐÚNG" : "❌ SAI") . "</p>";

if (isset($_POST['test_pass'])) {
    $input = $_POST['test_pass'];
    $result = password_verify($input, $user['mat_khau']);
    echo "<p>Mật khẩu '$input' " . ($result ? "✅ ĐÚNG" : "❌ SAI") . "</p>";
}
?>

<form method="POST">
    <input type="text" name="test_pass" placeholder="Nhập mật khẩu để test">
    <button type="submit">Kiểm tra</button>
</form>

<p><a href="<?= BASE_URL_ADMIN ?>">Quay về Admin</a></p>
