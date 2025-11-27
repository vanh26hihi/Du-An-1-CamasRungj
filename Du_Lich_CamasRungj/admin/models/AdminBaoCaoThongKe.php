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
            $sql = "SELECT SUM(tong_tien) as tong_doanh_thu 
                    FROM dat_tour 
                    WHERE trang_thai_id = 2 OR trang_thai_id = 3";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            // Nếu không có dữ liệu thì trả về 0
            if ($result['tong_doanh_thu'] == null) {
                return 0;
            }
            return $result['tong_doanh_thu'];
        } catch (Exception $e) {
            return 0;
        }
    }


    // Doanh thu tháng hiện tại
    public function getDoanhThuThangHienTai()
    {
        try {
            // Lấy tháng và năm hiện tại
            $thang = date('m');
            $nam = date('Y');
            
            $sql = "SELECT SUM(tong_tien) as doanh_thu 
                    FROM dat_tour 
                    WHERE (trang_thai_id = 2 OR trang_thai_id = 3)
                    AND MONTH(ngay_tao) = $thang
                    AND YEAR(ngay_tao) = $nam";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            // Nếu không có dữ liệu thì trả về 0
            if ($result['doanh_thu'] == null) {
                return 0;
            }
            return $result['doanh_thu'];
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
            $result = $stmt->fetch();
            return $result['tong_booking'];
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
                        SUM(dt.tong_tien) as tong_doanh_thu
                    FROM tour t
                    JOIN lich_khoi_hanh lk ON lk.tour_id = t.tour_id
                    JOIN dat_tour dt ON dt.lich_id = lk.lich_id
                    WHERE dt.trang_thai_id = 2 OR dt.trang_thai_id = 3
                    GROUP BY t.tour_id, t.ten
                    ORDER BY tong_doanh_thu DESC
                    LIMIT $limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
            
            // Xử lý null thành 0
            foreach ($results as $key => $row) {
                if ($row['tong_doanh_thu'] == null) {
                    $results[$key]['tong_doanh_thu'] = 0;
                }
            }
            
            return $results;
        } catch (Exception $e) {
            return [];
        }
    }

    // Booking mới trong tháng
    public function getBookingMoiThangHienTai()
    {
        try {
            // Lấy tháng và năm hiện tại
            $thang = date('m');
            $nam = date('Y');
            
            $sql = "SELECT COUNT(*) as so_booking 
                    FROM dat_tour 
                    WHERE MONTH(ngay_tao) = $thang
                    AND YEAR(ngay_tao) = $nam";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['so_booking'];
        } catch (Exception $e) {
            return 0;
        }
    }

}

