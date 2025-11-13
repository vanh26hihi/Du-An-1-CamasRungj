<?php
class AdminTaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn  = connectDB();
    }

    //Lấy Tất cả trong bảng sản phẩm
    public function getAllTaiKhoan($chuc_vu_id)
    {
        try {
            $sql = 'SELECT tai_khoans.* , trang_thai_tai_khoans.ten_trang_thai
             FROM tai_khoans
             INNER JOIN trang_thai_tai_khoans ON tai_khoans.trang_thai = trang_thai_tai_khoans.id
            WHERE tai_khoans.chuc_vu_id = :chuc_vu_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":chuc_vu_id" => $chuc_vu_id,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id)
    {
        try {
            $sql = 'INSERT INTO tai_khoans(ho_ten,email,mat_khau,chuc_vu_id)
                VALUES(:ho_ten,:email,:mat_khau,:chuc_vu_id)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':mat_khau' => $password,
                ':chuc_vu_id' => $chuc_vu_id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDetailTaiKhoan($id)
    {
        try {
            $sql = 'SELECT * FROM tai_khoans
             WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getAllGioiTinh()
    {
        try {
            $sql = 'SELECT * FROM gioi_tinhs';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function getAllTrangThai()
    {
        try {
            $sql = 'SELECT * FROM trang_thai_tai_khoans ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function updateTaiKhoan($id, $ho_ten, $email, $so_dien_thoai, $trang_thai)
    {
        try {
            $sql = 'UPDATE tai_khoans SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai, trang_thai = :trang_thai WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':id' => $id,
                ':so_dien_thoai' => $so_dien_thoai,
                ':trang_thai' => $trang_thai,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function updateKhachHang($id, $ho_ten, $email, $so_dien_thoai, $gioi_tinh, $dia_chi, $ngay_sinh, $trang_thai)
    {
        try {
            $sql = 'UPDATE tai_khoans SET ho_ten = :ho_ten, email = :email,gioi_tinh = :gioi_tinh,dia_chi = :dia_chi,ngay_sinh = :ngay_sinh, so_dien_thoai = :so_dien_thoai, trang_thai = :trang_thai WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':id' => $id,
                ':gioi_tinh' => $gioi_tinh,
                ':dia_chi' => $dia_chi,
                ':ngay_sinh' => $ngay_sinh,
                ':so_dien_thoai' => $so_dien_thoai,
                ':trang_thai' => $trang_thai,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function updateCaNhanQuanTri($id, $ho_ten, $email, $so_dien_thoai, $gioi_tinh, $dia_chi, $ngay_sinh)
    {
        try {
            $sql = 'UPDATE tai_khoans SET ho_ten = :ho_ten, email = :email,gioi_tinh = :gioi_tinh,dia_chi = :dia_chi,ngay_sinh = :ngay_sinh, so_dien_thoai = :so_dien_thoai WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':id' => $id,
                ':gioi_tinh' => $gioi_tinh,
                ':dia_chi' => $dia_chi,
                ':ngay_sinh' => $ngay_sinh,
                ':so_dien_thoai' => $so_dien_thoai,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function updateMatKhau($id, $mat_khau)
    {
        try {
            $sql = 'UPDATE tai_khoans SET mat_khau = :mat_khau WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':mat_khau' => $mat_khau,
                ':id' => $id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function resetPassword($id, $mat_khau)
    {
        try {
            $sql = 'UPDATE tai_khoans SET mat_khau = :mat_khau WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':mat_khau' => $mat_khau,
                ':id' => $id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function checkLogin($email, $mat_khau)
    {
        $result = [
            'status' => false, // Mặc định là thất bại
            'message' => '',
            'email' => $email, // Lưu email để trả lại form
            'user' => null
        ];

        try {
            // 1. Tìm user theo email
            $sql = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();




            // Nếu email không tồn tại
            if (!$user) {
                $result['message'] = 'Email không tồn tại';
                return $result;
            }

            // Nếu mật khẩu sai
            if (!password_verify($mat_khau, $user['mat_khau'])) {
                $result['message'] = 'Mật khẩu không chính xác';
                return $result;
            }

            // Nếu không phải admin
            if ($user['chuc_vu_id'] != 1) {
                $result['message'] = 'Tài khoản không có quyền truy cập';
                return $result;
            }

            // Nếu tài khoản bị khóa
            if ($user['trang_thai'] != 1) {
                if ($user['trang_thai'] == 2) {
                    $result['message'] = 'Tài khoản chưa được kích hoạt';
                    return $result;
                }
                if ($user['trang_thai'] == 3) {
                    $result['message'] = 'Tài khoản bị khóa tạm thời';
                    return $result;
                }
                if ($user['trang_thai'] == 4) {
                    $result['message'] = 'Tài khoản bị vô hiệu hóa';
                    return $result;
                }
                if ($user['trang_thai'] == 5) {
                    $result['message'] = 'Tài khoản đang chờ duyệt';
                    return $result;
                }
            }

            // Thành công
            $result['status'] = true;
            $result['message'] = 'Đăng nhập thành công';
            $result['user'] = $user;
            return $result;
        } catch (Exception $e) {
            $result['message'] = 'Lỗi hệ thống: ' . $e->getMessage();
            return $result;
        }
    }


    public function getTaiKhoanFormEmail($email)
    {
        try {
            $sql = 'SELECT * FROM tai_khoans WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':email' => $email,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
