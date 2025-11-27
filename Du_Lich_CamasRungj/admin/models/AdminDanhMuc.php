<?php
class AdminDanhMuc
{
    public $conn;

    public function __construct()
    {

        $this->conn = connectDB();
    }

    /**
     * Lấy danh sách tour kèm thông tin danh mục
     * Trả về các trường: tour_id, ten_tour, danh_muc_id, ten_danh_muc, mo_ta, gia_co_ban, chinh_sach, diem_khoi_hanh
     */
    public function getToursWithCategory()
    {
        try {
            $sql = "SELECT 
                        tour.tour_id,
                        tour.ten AS ten_tour,
                        danh_muc_tour.danh_muc_id,
                        danh_muc_tour.ten AS ten_danh_muc,
                        tour.mo_ta AS mo_ta,
                        tour.gia_co_ban,
                        tour.chinh_sach,
                        tour.diem_khoi_hanh
                    FROM tour
                    JOIN danh_muc_tour ON tour.danh_muc_id = danh_muc_tour.danh_muc_id";

            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function getDanhMucID($id)
    {
        $sql = "SELECT * FROM danh_muc_tour WHERE danh_muc_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDanhMuc()
    {
        $sql = "SELECT * FROM danh_muc_tour ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDiaDiemTour()
    {
        $sql = "SELECT dia_diem.*,
                quoc_gia.ten as ten_quoc_gia,
                quoc_gia.mo_ta as mo_ta_quoc_gia
                FROM dia_diem
                JOIN quoc_gia ON dia_diem.quoc_gia_id = quoc_gia.quoc_gia_id
                ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin tour theo id
    public function getTourById($id)
    {
        try {
            $sql = "SELECT * FROM tour WHERE tour_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    // Lấy danh sách dia_diem_tour cho 1 tour (kèm thông tin dia_diem và quoc_gia)
    public function getDiaDiemTourByTour($tourId)
    {
        try {
            $sql = "SELECT ddt.*, dd.ten as ten_dia_diem, dd.mo_ta as mo_ta_dia_diem, qg.ten as ten_quoc_gia, qg.mo_ta as mo_ta_quoc_gia
                    FROM dia_diem_tour ddt
                    JOIN dia_diem dd ON ddt.dia_diem_id = dd.dia_diem_id
                    JOIN quoc_gia qg ON dd.quoc_gia_id = qg.quoc_gia_id
                    WHERE ddt.tour_id = :tour_id
                    ORDER BY ddt.thu_tu ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['tour_id' => $tourId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // cập nhật danh mục
    public function updateDanhMuc($id, $ten, $mo_ta, $trang_thai)
    {
        $sql = "UPDATE danh_muc_tour set ten = :ten, mo_ta=:mo_ta, trang_thai = :trang_thai where danh_muc_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten' => $ten,
            'mo_ta' => $mo_ta,
            'trang_thai' => $trang_thai,
            'id' => $id
        ]);
    }
    // xóa danh mục
    public function destroyDanhMuc($id)
    {
        try {
            $sql = "DELETE FROM danh_muc_tour WHERE `danh_muc_tour`.`danh_muc_id` = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    // Thêm tour vào bảng tour
    public function insertTour($data)
    {
        try {
            $sql = "INSERT INTO tour 
                    (ten, danh_muc_id, mo_ta_ngan, mo_ta, gia_co_ban, thoi_luong_mac_dinh, chinh_sach, diem_khoi_hanh, hoat_dong, nguoi_tao_id, ngay_tao) 
                    VALUES (:ten, :danh_muc_id, :mo_ta_ngan, :mo_ta, :gia_co_ban, :thoi_luong_mac_dinh, :chinh_sach, :diem_khoi_hanh, 1, 1, NOW())";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'ten' => $data['ten'],
                'danh_muc_id' => $data['danh_muc_id'],
                'mo_ta_ngan' => $data['mo_ta_ngan'],
                'mo_ta' => $data['mo_ta'],
                'gia_co_ban' => $data['gia_co_ban'],
                'thoi_luong_mac_dinh' => $data['thoi_luong_mac_dinh'],
                'chinh_sach' => $data['chinh_sach'],
                'diem_khoi_hanh' => $data['diem_khoi_hanh']
            ]);

            if ($result) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Insert địa điểm cho tour
    public function insertDiaDiemTour($data)
    {
        try {
            $sql = "INSERT INTO dia_diem_tour (tour_id, dia_diem_id, thu_tu, ghi_chu) 
                    VALUES (:tour_id, :dia_diem_id, :thu_tu, :ghi_chu)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'tour_id' => $data['tour_id'],
                'dia_diem_id' => $data['dia_diem_id'],
                'thu_tu' => $data['thu_tu'],
                'ghi_chu' => $data['ghi_chu']
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật tour
    public function updateTour($id, $data)
    {
        try {
            $sql = "UPDATE tour SET 
                    ten = :ten,
                    danh_muc_id = :danh_muc_id,
                    mo_ta_ngan = :mo_ta_ngan,
                    mo_ta = :mo_ta,
                    gia_co_ban = :gia_co_ban,
                    thoi_luong_mac_dinh = :thoi_luong_mac_dinh,
                    chinh_sach = :chinh_sach,
                    diem_khoi_hanh = :diem_khoi_hanh
                    WHERE tour_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'ten' => $data['ten'],
                'danh_muc_id' => $data['danh_muc_id'],
                'mo_ta_ngan' => $data['mo_ta_ngan'],
                'mo_ta' => $data['mo_ta'],
                'gia_co_ban' => $data['gia_co_ban'],
                'thoi_luong_mac_dinh' => $data['thoi_luong_mac_dinh'],
                'chinh_sach' => $data['chinh_sach'],
                'diem_khoi_hanh' => $data['diem_khoi_hanh']
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Xóa tất cả dia_diem_tour cho một tour
    public function deleteDiaDiemTourByTour($tourId)
    {
        try {
            $sql = "DELETE FROM dia_diem_tour WHERE tour_id = :tour_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['tour_id' => $tourId]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Hàm cũ (giữ lại cho tương thích)
    public function insertDanhMucTour($data)
    {
        return $this->insertTour($data);
    }
    
    // ===== LỊCH TRÌNH METHODS =====
    
    public function insertLichTrinh($data)
    {
        try {
            // Insert vào lich_trinh
            $sql = "INSERT INTO lich_trinh (tour_id, ngay_thu, tieu_de, noi_dung) 
                    VALUES (:tour_id, :ngay_thu, :tieu_de, :noi_dung)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'tour_id' => $data['tour_id'],
                'ngay_thu' => $data['ngay_thu'],
                'tieu_de' => $data['tieu_de'] ?? '',
                'noi_dung' => $data['noi_dung']
            ]);
            
            if ($result) {
                $lichTrinhId = $this->conn->lastInsertId();
                
                // Nếu có dia_diem_id, insert vào dia_diem_lich_trinh
                if (!empty($data['dia_diem_id'])) {
                    $this->insertDiaDiemLichTrinh([
                        'lich_trinh_id' => $lichTrinhId,
                        'dia_diem_id' => $data['dia_diem_id'],
                        'thu_tu' => $data['ngay_thu'], // Sử dụng ngay_thu làm thứ tự
                        'mo_ta' => $data['mo_ta'] ?? ''
                    ]);
                }
                
                return $lichTrinhId;
            }
            return false;
        } catch (Exception $e) {
            echo "Lỗi insertLichTrinh: " . $e->getMessage();
            return false;
        }
    }
    
    public function insertDiaDiemLichTrinh($data)
    {
        try {
            $sql = "INSERT INTO dia_diem_lich_trinh (lich_trinh_id, dia_diem_id, thu_tu, mo_ta) 
                    VALUES (:lich_trinh_id, :dia_diem_id, :thu_tu, :mo_ta)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'lich_trinh_id' => $data['lich_trinh_id'],
                'dia_diem_id' => $data['dia_diem_id'],
                'thu_tu' => $data['thu_tu'] ?? 1,
                'mo_ta' => $data['mo_ta'] ?? ''
            ]);
        } catch (Exception $e) {
            echo "Lỗi insertDiaDiemLichTrinh: " . $e->getMessage();
            return false;
        }
    }
    
    public function getLichTrinhByTour($tourId)
    {
        $sql = "SELECT lt.*, ddlt.mo_ta, ddlt.dia_diem_id, dd.ten as ten_dia_diem 
                FROM lich_trinh lt
                LEFT JOIN dia_diem_lich_trinh ddlt ON lt.lich_trinh_id = ddlt.lich_trinh_id
                LEFT JOIN dia_diem dd ON ddlt.dia_diem_id = dd.dia_diem_id
                WHERE lt.tour_id = :tour_id 
                ORDER BY lt.ngay_thu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function deleteLichTrinhByTour($tourId)
    {
        try {
            // Xóa dia_diem_lich_trinh trước (foreign key)
            $sql1 = "DELETE ddlt FROM dia_diem_lich_trinh ddlt 
                     JOIN lich_trinh lt ON ddlt.lich_trinh_id = lt.lich_trinh_id 
                     WHERE lt.tour_id = :tour_id";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute(['tour_id' => $tourId]);
            
            // Xóa lich_trinh
            $sql2 = "DELETE FROM lich_trinh WHERE tour_id = :tour_id";
            $stmt2 = $this->conn->prepare($sql2);
            return $stmt2->execute(['tour_id' => $tourId]);
        } catch (Exception $e) {
            echo "Lỗi deleteLichTrinhByTour: " . $e->getMessage();
            return false;
        }
    }
}
