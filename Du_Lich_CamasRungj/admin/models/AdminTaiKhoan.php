<?php

class AdminTaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Kiểm tra đăng nhập
    public function checkLogin($email, $password)
    {
        try {
            $sql = "SELECT * FROM nguoi_dung WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                // Kiểm tra mật khẩu (giả sử mật khẩu đã hash, nếu chưa thì so sánh trực tiếp)
                // Nếu password trong DB chưa hash, dùng: if ($password === $user['mat_khau'])
                if (password_verify($password, $user['mat_khau']) || $password === $user['mat_khau']) {
                    // Kiểm tra trạng thái tài khoản
                    if ($user['trang_thai'] == 'active') {
                        // Cho phép cả Admin (vai_tro_id = 1) và HDV (vai_tro_id = 2) đăng nhập
                        if ($user['vai_tro_id'] == 1 || $user['vai_tro_id'] == 2) {
                            return [
                                'trang_thai' => true,
                                'user' => [
                                    'id' => $user['nguoi_dung_id'],
                                    'nguoi_dung_id' => $user['nguoi_dung_id'],
                                    'ho_ten' => $user['ho_ten'],
                                    'email' => $user['email'],
                                    'so_dien_thoai' => $user['so_dien_thoai'] ?? '',
                                    'anh_dai_dien' => $user['anh_dai_dien'] ?? 'https://www.transparentpng.com/thumb/user/gray-user-profile-icon-png-fP8Q1P.png',
                                    'vai_tro_id' => $user['vai_tro_id'],
                                    'trang_thai' => $user['trang_thai'],
                                    'ngay_tao' => $user['ngay_tao'] ?? ''
                                ]
                            ];
                        } else {
                            return [
                                'trang_thai' => false,
                                'message' => 'Bạn không có quyền truy cập vào trang quản trị'
                            ];
                        }
                    } else {
                        return [
                            'trang_thai' => false,
                            'message' => 'Tài khoản đã bị khóa'
                        ];
                    }
                } else {
                    return [
                        'trang_thai' => false,
                        'message' => 'Mật khẩu không chính xác'
                    ];
                }
            } else {
                return [
                    'trang_thai' => false,
                    'message' => 'Email không tồn tại trong hệ thống'
                ];
            }
        } catch (Exception $e) {
            return [
                'trang_thai' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ];
        }
    }

    // Lấy tất cả tài khoản theo vai trò
    public function getAllTaiKhoan($vai_tro_id)
    {
        try {
            $sql = "SELECT * FROM nguoi_dung WHERE vai_tro_id = :vai_tro_id ORDER BY nguoi_dung_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':vai_tro_id' => $vai_tro_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Lấy tất cả tài khoản theo vai trò (alias mới)
    public function getAllTaiKhoanByVaiTro($vai_tro_id)
    {
        try {
            $sql = "SELECT * FROM nguoi_dung WHERE vai_tro_id = :vai_tro_id ORDER BY nguoi_dung_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':vai_tro_id' => $vai_tro_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // Lấy chi tiết tài khoản
    public function getDetailTaiKhoan($id)
    {
        try {
            $sql = "SELECT * FROM nguoi_dung WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Lấy tài khoản từ email
    public function getTaiKhoanFormEmail($email)
    {
        try {
            $sql = "SELECT * FROM nguoi_dung WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Kiểm tra email đã tồn tại chưa
    public function checkEmailExists($email)
    {
        try {
            $sql = "SELECT COUNT(*) FROM nguoi_dung WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Kiểm tra email đã tồn tại chưa (trừ ID hiện tại)
    public function checkEmailExistsExcept($email, $id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM nguoi_dung WHERE email = :email AND nguoi_dung_id != :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email, ':id' => $id]);
            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Thêm tài khoản mới (cũ - tương thích ngược)
    public function insertTaiKhoan($ho_ten, $email, $password, $vai_tro_id)
    {
        try {
            $sql = "INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro_id, trang_thai, ngay_tao) 
                    VALUES (:ho_ten, :email, :mat_khau, :vai_tro_id, 'active', NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':mat_khau' => password_hash($password, PASSWORD_BCRYPT),
                ':vai_tro_id' => $vai_tro_id
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Thêm tài khoản mới (với mảng dữ liệu)
    public function insertTaiKhoanArray($data)
    {
        try {
            $sql = "INSERT INTO nguoi_dung (ho_ten, email, mat_khau, so_dien_thoai, vai_tro_id, trang_thai, ngay_tao) 
                    VALUES (:ho_ten, :email, :mat_khau, :so_dien_thoai, :vai_tro_id, :trang_thai, NOW())";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                ':ho_ten' => $data['ho_ten'],
                ':email' => $data['email'],
                ':mat_khau' => $data['mat_khau'], // Already hashed in controller
                ':so_dien_thoai' => $data['so_dien_thoai'] ?? '',
                ':vai_tro_id' => $data['vai_tro_id'],
                ':trang_thai' => $data['trang_thai'] ?? 'active'
            ]);
            return $result;
        } catch (Exception $e) {
            error_log("Lỗi insertTaiKhoanArray: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật tài khoản (cũ - tương thích ngược)
    public function updateTaiKhoan($id, $ho_ten, $email, $so_dien_thoai, $trang_thai)
    {
        try {
            $sql = "UPDATE nguoi_dung 
                    SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai, trang_thai = :trang_thai 
                    WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai,
                ':trang_thai' => $trang_thai
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật tài khoản (với mảng dữ liệu)
    public function updateTaiKhoanArray($id, $data)
    {
        try {
            $sql = "UPDATE nguoi_dung 
                    SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai, trang_thai = :trang_thai 
                    WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':ho_ten' => $data['ho_ten'],
                ':email' => $data['email'],
                ':so_dien_thoai' => $data['so_dien_thoai'],
                ':trang_thai' => $data['trang_thai']
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật thông tin khách hàng
    public function updateKhachHang($id, $ho_ten, $email, $so_dien_thoai, $gioi_tinh, $dia_chi, $ngay_sinh, $trang_thai)
    {
        try {
            $sql = "UPDATE nguoi_dung 
                    SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai, trang_thai = :trang_thai
                    WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai,
                ':trang_thai' => $trang_thai
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật thông tin cá nhân quản trị
    public function updateCaNhanQuanTri($id, $ho_ten, $email, $so_dien_thoai, $gioi_tinh, $dia_chi, $ngay_sinh)
    {
        try {
            $sql = "UPDATE nguoi_dung 
                    SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai
                    WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Reset mật khẩu
    public function resetPassword($id, $password)
    {
        try {
            $sql = "UPDATE nguoi_dung SET mat_khau = :mat_khau WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':mat_khau' => password_hash($password, PASSWORD_BCRYPT)
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật mật khẩu (alias của resetPassword)
    public function updateMatKhau($id, $hashed_password)
    {
        try {
            $sql = "UPDATE nguoi_dung SET mat_khau = :mat_khau WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':mat_khau' => $hashed_password
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Lấy tất cả trạng thái
    public function getAllTrangThai()
    {
        return [
            ['id' => 'active', 'ten_trang_thai' => 'Hoạt động'],
            ['id' => 'inactive', 'ten_trang_thai' => 'Khóa']
        ];
    }

    // Lấy tất cả giới tính
    public function getAllGioiTinh()
    {
        return [
            ['id' => 1, 'ten_gioi_tinh' => 'Nam'],
            ['id' => 2, 'ten_gioi_tinh' => 'Nữ'],
            ['id' => 3, 'ten_gioi_tinh' => 'Khác']
        ];
    }

    // Xóa tài khoản
    public function deleteTaiKhoan($id)
    {
        try {
            $sql = "DELETE FROM nguoi_dung WHERE nguoi_dung_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
}
