<?php
class AdminDonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn  = connectDB();
    }

    //Lấy Tất cả trong bảng sản phẩm
    public function getAllDonHang()
    {
        try {
            $sql = 'SELECT don_hangs.*,
                    trang_thai_don_hangs.ten_trang_thai,
                    phuong_thuc_thanh_toans.ten_phuong_thuc
                    FROM don_hangs 
                    INNER JOIN trang_thai_don_hangs 
                    ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                    INNER JOIN phuong_thuc_thanh_toans 
                    ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDonHangFromKhachHang($id)
    {
        try {
            $sql = 'SELECT don_hangs.*,
                    trang_thai_don_hangs.ten_trang_thai,
                    phuong_thuc_thanh_toans.ten_phuong_thuc
                    FROM don_hangs 
                    INNER JOIN trang_thai_don_hangs 
                    ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                    INNER JOIN phuong_thuc_thanh_toans 
                    ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
                    WHERE don_hangs.tai_khoan_id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function getAllTrangThai()
    {
        try {
            $sql = 'SELECT * FROM trang_thai_don_hangs ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function getAllThanhToan()
    {
        try {
            $sql = 'SELECT * FROM phuong_thuc_thanh_toans ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    //Lấy Sản Phẩm có ID tương ứng
    public function getDetailDonHang($id)
    {
        try {
            $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai,phuong_thuc_thanh_toans.ten_phuong_thuc, tai_khoans.ho_ten,tai_khoans.email,tai_khoans.so_dien_thoai
            FROM don_hangs
                    INNER JOIN trang_thai_don_hangs 
                        ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                    INNER JOIN phuong_thuc_thanh_toans 
                        ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
                    INNER JOIN tai_khoans 
                        ON don_hangs.tai_khoan_id = tai_khoans.id
                    WHERE don_hangs.id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getListSPDonHang($id)
    {
        try {
            $sql = 'SELECT chi_tiet_don_hangs.*,san_phams.ten_san_pham
             FROM chi_tiet_don_hangs
             INNER JOIN san_phams 
                        ON chi_tiet_don_hangs.san_pham_id = san_phams.id_san_pham
                  WHERE chi_tiet_don_hangs.don_hang_id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    //Xử lý và Sửa Sản phẩm
    public function updateDonHang(
        $id_don_hang,
        $ten_nguoi_nhan,
        $email_nguoi_nhan,
        $sdt_nguoi_nhan,
        $dia_chi_nguoi_nhan,
        $ghi_chu,
        $trang_thai_id
    ) {
        try {
            $sql = 'UPDATE don_hangs SET ten_nguoi_nhan = :ten_nguoi_nhan ,
                                        email_nguoi_nhan = :email_nguoi_nhan,
                                        sdt_nguoi_nhan = :sdt_nguoi_nhan ,
                                        dia_chi_nguoi_nhan = :dia_chi_nguoi_nhan,
                                        ghi_chu  = :ghi_chu,
                                        trang_thai_id = :trang_thai_id
                                        WHERE id = :id_don_hang';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id_don_hang' => $id_don_hang,
                ':ten_nguoi_nhan' => $ten_nguoi_nhan,
                ':email_nguoi_nhan' => $email_nguoi_nhan,
                ':sdt_nguoi_nhan' => $sdt_nguoi_nhan,
                ':dia_chi_nguoi_nhan' => $dia_chi_nguoi_nhan,
                ':ghi_chu' => $ghi_chu,
                ':trang_thai_id' => $trang_thai_id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
