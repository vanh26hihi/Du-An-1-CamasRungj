﻿<?php
class AdminBooking
{
    public $conn;

    public function __construct()
    {
        $this->conn  = connectDB();
    }
    public function getAllBooking()
    {
        try {
            $sql = 'SELECT 
                dat_tour.*,
               lich_khoi_hanh.ngay_bat_dau,
                lich_khoi_hanh.ngay_ket_thuc,
                trang_thai_booking.ten_trang_thai,
                khach_hang.ho_ten as ten_khach_hang,
                tour.ten as ten_tour
            FROM dat_tour 
            JOIN lich_khoi_hanh ON lich_khoi_hanh.lich_id = dat_tour.lich_id
            JOIN khach_hang ON khach_hang.khach_hang_id = dat_tour.khach_hang_id
            JOIN tour ON lich_khoi_hanh.tour_id = tour.tour_id
            JOIN trang_thai_booking ON trang_thai_booking.trang_thai_id = dat_tour.trang_thai_id
            ORDER BY dat_tour.dat_tour_id DESC';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function getAllLichAndTour()
    {
        try {
            $sql = 'SELECT lich_khoi_hanh.*,
                     tour.ten as ten_tour,
                     tour.tour_id,
                     tour.mo_ta,
                     tour.gia_co_ban,
                     tour.diem_khoi_hanh,
                     tour.chinh_sach
                FROM lich_khoi_hanh
                JOIN tour ON lich_khoi_hanh.tour_id = tour.tour_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getAllHanhKhachID($id)
    {
        try {
            $sql = 'SELECT * 
                FROM hanh_khach_list
                WHERE dat_tour_id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function getAllBookingID($id)
    {
        try {
            $sql = 'SELECT 
                    dat_tour.*,
                    
                    lich_khoi_hanh.lich_id,
                    lich_khoi_hanh.ngay_bat_dau,
                    
                    tour.tour_id,
                    tour.ten as ten_tour,
                    tour.mo_ta,
                    tour.gia_co_ban,
                    tour.chinh_sach,
                    tour.diem_khoi_hanh,

                    khach_hang.khach_hang_id ,
                    khach_hang.ho_ten,
                    khach_hang.so_dien_thoai,
                    khach_hang.email,
                    khach_hang.cccd,
                    khach_hang.dia_chi

                FROM dat_tour
                JOIN lich_khoi_hanh ON lich_khoi_hanh.lich_id = dat_tour.lich_id
                JOIN tour ON tour.tour_id = lich_khoi_hanh.tour_id
                JOIN khach_hang ON khach_hang.khach_hang_id = dat_tour.khach_hang_id
                WHERE dat_tour.dat_tour_id = :id
                ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function insertBooking($lich_id, $loai, $so_nguoi, $ghi_chu, $khach_hang_id, $nguoi_tao_id, $tong_tien)
    {
        $ten_te = "VND";
        $nguoi_tao_id = 1;
        try {
            $sql = 'INSERT INTO dat_tour(lich_id, loai, so_nguoi, ghi_chu, khach_hang_id ,nguoi_tao_id,tong_tien,ten_te,nguoi_tao_id)
                VALUES(:lich_id, :loai, :so_nguoi, :ghi_chu, :khach_hang_id,:nguoi_tao_id,:tong_tien,:ten_te,:nguoi_tao_id)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':lich_id' => $lich_id,
                ':loai' => $loai,
                ':so_nguoi' => $so_nguoi,
                ':ghi_chu' => $ghi_chu,
                ':khach_hang_id' => $khach_hang_id,
                ':nguoi_tao_id' => $nguoi_tao_id,
                ':tong_tien' => $tong_tien,
                ':ten_te' => $ten_te,
                ':nguoi_tao_id' => $nguoi_tao_id,
            ]);
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function insertKhachHang($ho_ten, $so_dien_thoai, $email, $cccd, $dia_chi)
    {
        try {
            $sql = 'INSERT INTO khach_hang(ho_ten, so_dien_thoai, email, cccd, dia_chi)
                VALUES(:ho_ten, :so_dien_thoai, :email, :cccd, :dia_chi)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':so_dien_thoai' => $so_dien_thoai,
                ':email' => $email,
                ':cccd' => $cccd,
                ':dia_chi' => $dia_chi,
            ]);
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function insertListKhachHang($dat_tour_id, $ho_ten, $so_dien_thoai, $email, $gioi_tinh, $cccd, $ngay_sinh, $ghi_chu, $so_ghe)
    {
        try {
            $sql = 'INSERT INTO hanh_khach_list(dat_tour_id,ho_ten, so_dien_thoai, email, gioi_tinh, cccd, ngay_sinh, ghi_chu, so_ghe)
                VALUES(:dat_tour_id,:ho_ten, :so_dien_thoai, :email, :gioi_tinh, :cccd, :ngay_sinh, :ghi_chu, :so_ghe)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':dat_tour_id' => $dat_tour_id,
                ':ho_ten' => $ho_ten,
                ':so_dien_thoai' => $so_dien_thoai,
                ':email' => $email,
                ':gioi_tinh' => $gioi_tinh,
                ':cccd' => $cccd,
                ':ngay_sinh' => $ngay_sinh,
                ':ghi_chu' => $ghi_chu,
                ':so_ghe' => $so_ghe,

            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    // public function getDetailBooking($id)
    // {
    //     try {
    //         $sql = 'SELECT * FROM dat_tour WHERE id = :id';
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([
    //             ':id' => $id,
    //         ]);
    //         return $stmt->fetch();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    public function updateBooking($dat_tour_id, $lich_id, $loai, $so_nguoi, $ghi_chu, $khach_hang_id, $nguoi_tao_id, $tong_tien)
    {
        try {
            $sql = 'UPDATE dat_tour SET 
                    lich_id = :lich_id,
                    loai = :loai,
                    so_nguoi = :so_nguoi,
                    ghi_chu = :ghi_chu,
                    khach_hang_id = :khach_hang_id,
                    nguoi_tao_id = :nguoi_tao_id,
                    tong_tien = :tong_tien
                WHERE dat_tour_id = :dat_tour_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':lich_id' => $lich_id,
                ':loai' => $loai,
                ':so_nguoi' => $so_nguoi,
                ':ghi_chu' => $ghi_chu,
                ':khach_hang_id' => $khach_hang_id,
                ':nguoi_tao_id' => $nguoi_tao_id,
                ':tong_tien' => $tong_tien,
                ':dat_tour_id' => $dat_tour_id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function updateKhachHang($khach_hang_id, $ho_ten, $so_dien_thoai, $email, $cccd, $dia_chi)
    {
        try {
            $sql = 'UPDATE khach_hang SET 
                    ho_ten = :ho_ten,
                    so_dien_thoai = :so_dien_thoai,
                    email = :email,
                    cccd = :cccd,
                    dia_chi = :dia_chi
                WHERE khach_hang_id = :khach_hang_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':so_dien_thoai' => $so_dien_thoai,
                ':email' => $email,
                ':cccd' => $cccd,
                ':dia_chi' => $dia_chi,
                ':khach_hang_id' => $khach_hang_id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function updateListKhachHang($hanh_khach_id, $ho_ten, $so_dien_thoai, $email, $gioi_tinh, $cccd, $ngay_sinh, $ghi_chu, $so_ghe)
    {
        try {
            $sql = 'UPDATE hanh_khach_list SET 
                    ho_ten = :ho_ten,
                    so_dien_thoai = :so_dien_thoai,
                    email = :email,
                    gioi_tinh = :gioi_tinh,
                    cccd = :cccd,
                    ngay_sinh = :ngay_sinh,
                    ghi_chu = :ghi_chu,
                    so_ghe = :so_ghe
                WHERE hanh_khach_id = :hanh_khach_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':so_dien_thoai' => $so_dien_thoai,
                ':email' => $email,
                ':gioi_tinh' => $gioi_tinh,
                ':cccd' => $cccd,
                ':ngay_sinh' => $ngay_sinh,
                ':ghi_chu' => $ghi_chu,
                ':so_ghe' => $so_ghe,
                ':hanh_khach_id' => $hanh_khach_id,
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function deleteListKhachHang($oldId)
    {
        try {
            $sql = "DELETE FROM hanh_khach_list WHERE `hanh_khach_list`.`hanh_khach_id` = :oldId";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':oldId' => $oldId,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function destroyKhachHang($id)
    {
        try {
            $sql = "DELETE FROM khach_hang WHERE `khach_hang`.`khach_hang_id` = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function destroyBooking($id)
    {
        try {
            $sql = "DELETE FROM dat_tour WHERE `dat_tour`.`dat_tour_id` = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function destroyListKhachHang($id)
    {
        try {
            $sql = "DELETE FROM hanh_khach_list WHERE `hanh_khach_list`.`hanh_khach_id` = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    function getDetailBooking($id)
    {
        try {
            $sql = 'SELECT * FROM dat_tour WHERE dat_tour_id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
