<?php
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
    // public function insertBooking($ten_booking, $mo_ta)
    // {
    //     try {
    //         $sql = 'INSERT INTO dat_tour(ten_booking,mo_ta)
    //             VALUES(:ten_booking , :mo_ta)';
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([
    //             ':ten_booking' => $ten_booking,
    //             ':mo_ta' => $mo_ta,
    //         ]);
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }
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
    // public function updateBooking($id, $ten_booking, $mo_ta)
    // {
    //     try {
    //         $sql = 'UPDATE dat_tour SET ten_booking = :ten_booking, mo_ta = :mo_ta WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':ten_booking' => $ten_booking,
    //             ':mo_ta' => $mo_ta,
    //             ':id' => $id,
    //         ]);
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }
    // public function destroyBooking($id)
    // {
    //     try {
    //         $sql = "DELETE FROM dat_tour WHERE `dat_tour`.`id` = :id";

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':id' => $id,
    //         ]);
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }
}

