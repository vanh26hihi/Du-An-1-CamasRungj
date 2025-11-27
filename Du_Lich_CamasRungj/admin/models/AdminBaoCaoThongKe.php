<?php
class AdminBaoCaoThongKe
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Tổng doanh thu tất cả
    public function getTongDoanhThu()
    {
        try {
            $sql = "SELECT COALESCE(SUM(tong_tien), 0) as tong_doanh_thu 
                    FROM dat_tour 
                    WHERE trang_thai_id IN (2, 3)"; // Chỉ tính booking đã xác nhận hoặc hoàn thành
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['tong_doanh_thu'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }


    // Doanh thu tháng hiện tại
    public function getDoanhThuThangHienTai()
    {
        try {
            $sql = "SELECT COALESCE(SUM(tong_tien), 0) as doanh_thu 
                    FROM dat_tour 
                    WHERE trang_thai_id IN (2, 3)
                    AND MONTH(ngay_tao) = MONTH(CURRENT_DATE())
                    AND YEAR(ngay_tao) = YEAR(CURRENT_DATE())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['doanh_thu'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    // Tổng số booking
    public function getTongSoBooking()
    {
        try {
            $sql = "SELECT COUNT(*) as tong_booking FROM dat_tour";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['tong_booking'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }


    // Top tour bán chạy (theo doanh thu)
    public function getTopTourBanChay($limit = 5)
    {
        try {
            $sql = "SELECT 
                        t.tour_id,
                        t.ten as ten_tour,
                        COUNT(dt.dat_tour_id) as so_booking,
                        COALESCE(SUM(dt.tong_tien), 0) as tong_doanh_thu
                    FROM tour t
                    LEFT JOIN lich_khoi_hanh lk ON lk.tour_id = t.tour_id
                    LEFT JOIN dat_tour dt ON dt.lich_id = lk.lich_id AND dt.trang_thai_id IN (2, 3)
                    GROUP BY t.tour_id, t.ten
                    HAVING so_booking > 0
                    ORDER BY tong_doanh_thu DESC
                    LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // Booking mới trong tháng
    public function getBookingMoiThangHienTai()
    {
        try {
            $sql = "SELECT COUNT(*) as so_booking 
                    FROM dat_tour 
                    WHERE MONTH(ngay_tao) = MONTH(CURRENT_DATE())
                    AND YEAR(ngay_tao) = YEAR(CURRENT_DATE())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['so_booking'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

}

