
<?php
/**
 * ============================================================================
 * ADMIN DANH MUC MODEL
 * ============================================================================
 * Quản lý dữ liệu Tour và Danh mục Tour
 * - Danh mục Tour (Category)
 * - Tour (Product)
 * - Địa điểm Tour (Tour Destinations)
 * - Lịch trình (Schedule)
 * ============================================================================
 */

class AdminDanhMuc
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ========================================================================
    // GET METHODS - QUERY DATA
    // ========================================================================

    /**
     * Lấy danh sách tour kèm thông tin danh mục
     * @return array List of tours with category info
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
                    JOIN danh_muc_tour ON tour.danh_muc_id = danh_muc_tour.danh_muc_id
                    ORDER BY tour.tour_id DESC";

            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi getToursWithCategory: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Lấy thông tin tour theo ID
     * @param int $id Tour ID
     * @return array|false Tour data or false
     */
    public function getTourById($id)
    {
        try {
            $sql = "SELECT * FROM tour WHERE tour_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi getTourById: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy tất cả danh mục tour
     * @return array List of categories
     */
    public function getDanhMuc()
    {
        try {
            $sql = "SELECT * FROM danh_muc_tour ORDER BY danh_muc_id ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi getDanhMuc: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Lấy tất cả địa điểm kèm quốc gia
     * @return array List of destinations with country info
     */
    public function getDiaDiemTour()
    {
        try {
            $sql = "SELECT 
                        dia_diem.*,
                        quoc_gia.ten as ten_quoc_gia,
                        quoc_gia.mo_ta as mo_ta_quoc_gia
                    FROM dia_diem
                    JOIN quoc_gia ON dia_diem.quoc_gia_id = quoc_gia.quoc_gia_id
                    ORDER BY quoc_gia.ten ASC, dia_diem.ten ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi getDiaDiemTour: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Lấy danh sách địa điểm của một tour
     * @param int $tourId Tour ID
     * @return array List of tour destinations with full info
     */
    public function getDiaDiemTourByTour($tourId)
    {
        try {
            $sql = "SELECT 
                        ddt.*, 
                        dd.ten as ten_dia_diem, 
                        dd.mo_ta as mo_ta_dia_diem, 
                        qg.ten as ten_quoc_gia, 
                        qg.mo_ta as mo_ta_quoc_gia
                    FROM dia_diem_tour ddt
                    JOIN dia_diem dd ON ddt.dia_diem_id = dd.dia_diem_id
                    JOIN quoc_gia qg ON dd.quoc_gia_id = qg.quoc_gia_id
                    WHERE ddt.tour_id = :tour_id
                    ORDER BY ddt.thu_tu ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['tour_id' => $tourId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi getDiaDiemTourByTour: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Lấy lịch trình của tour kèm thông tin địa điểm
     * @param int $tourId Tour ID
     * @return array List of schedule items
     */
    public function getLichTrinhByTour($tourId)
    {
        try {
            $sql = "SELECT 
                        lt.*, 
                        ddt.dia_diem_id,
                        ddt.dia_diem_tour_id,
                        dd.ten as ten_dia_diem,
                        dd.mo_ta as mo_ta_dia_diem
                    FROM lich_trinh lt
                    LEFT JOIN dia_diem_tour ddt ON lt.dia_diem_tour_id = ddt.dia_diem_tour_id
                    LEFT JOIN dia_diem dd ON ddt.dia_diem_id = dd.dia_diem_id
                    WHERE lt.tour_id = :tour_id 
                    ORDER BY lt.ngay_thu ASC, lt.gio_bat_dau ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['tour_id' => $tourId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi getLichTrinhByTour: " . $e->getMessage();
            return [];
        }
    }

    // ========================================================================
    // INSERT METHODS - CREATE DATA
    // ========================================================================

    /**
     * Thêm tour mới
     * @param array $data Tour data
     * @return int|false Inserted tour_id or false
     */
    public function insertTour($data)
    {
        try {
            $sql = "INSERT INTO tour 
                    (ten, danh_muc_id, mo_ta_ngan, mo_ta, gia_co_ban, thoi_luong_mac_dinh, 
                     chinh_sach, diem_khoi_hanh, hoat_dong, nguoi_tao_id, ngay_tao) 
                    VALUES 
                    (:ten, :danh_muc_id, :mo_ta_ngan, :mo_ta, :gia_co_ban, :thoi_luong_mac_dinh, 
                     :chinh_sach, :diem_khoi_hanh, 1, 1, NOW())";
            
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

            return $result ? $this->conn->lastInsertId() : false;
        } catch (Exception $e) {
            echo "Lỗi insertTour: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Thêm địa điểm cho tour
     * @param array $data Destination data
     * @return int|false Inserted dia_diem_tour_id or false
     */
    public function insertDiaDiemTour($data)
    {
        try {
            $sql = "INSERT INTO dia_diem_tour (tour_id, dia_diem_id, thu_tu, ghi_chu) 
                    VALUES (:tour_id, :dia_diem_id, :thu_tu, :ghi_chu)";
            
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'tour_id' => $data['tour_id'],
                'dia_diem_id' => $data['dia_diem_id'],
                'thu_tu' => $data['thu_tu'],
                'ghi_chu' => $data['ghi_chu']
            ]);
            
            return $result ? $this->conn->lastInsertId() : false;
        } catch (Exception $e) {
            echo "Lỗi insertDiaDiemTour: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Thêm lịch trình cho tour
     * @param array $data Schedule data
     * @return int|false Inserted lich_trinh_id or false
     */
    public function insertLichTrinh($data)
    {
        try {
            $sql = "INSERT INTO lich_trinh 
                    (tour_id, ngay_thu, gio_bat_dau, gio_ket_thuc, dia_diem_tour_id, noi_dung) 
                    VALUES 
                    (:tour_id, :ngay_thu, :gio_bat_dau, :gio_ket_thuc, :dia_diem_tour_id, :noi_dung)";
            
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'tour_id' => $data['tour_id'],
                'ngay_thu' => $data['ngay_thu'],
                'gio_bat_dau' => $data['gio_bat_dau'],
                'gio_ket_thuc' => $data['gio_ket_thuc'],
                'dia_diem_tour_id' => $data['dia_diem_tour_id'],
                'noi_dung' => $data['noi_dung']
            ]);

            return $result ? $this->conn->lastInsertId() : false;
        } catch (Exception $e) {
            echo "Lỗi insertLichTrinh: " . $e->getMessage();
            return false;
        }
    }

    // ========================================================================
    // UPDATE METHODS - MODIFY DATA
    // ========================================================================

    /**
     * Cập nhật thông tin tour
     * @param int $id Tour ID
     * @param array $data Tour data to update
     * @return bool Success status
     */
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
            echo "Lỗi updateTour: " . $e->getMessage();
            return false;
        }
    }

    // ========================================================================
    // DELETE METHODS - REMOVE DATA
    // ========================================================================

    /**
     * Xóa danh mục tour (category)
     * @param int $id Category ID
     * @return bool Success status
     */
    public function destroyDanhMuc($id)
    {
        try {
            $sql = "DELETE FROM danh_muc_tour WHERE danh_muc_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi destroyDanhMuc: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Xóa tất cả địa điểm của một tour
     * @param int $tourId Tour ID
     * @return bool Success status
     */
    public function deleteDiaDiemTourByTour($tourId)
    {
        try {
            $sql = "DELETE FROM dia_diem_tour WHERE tour_id = :tour_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['tour_id' => $tourId]);
        } catch (Exception $e) {
            echo "Lỗi deleteDiaDiemTourByTour: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Xóa toàn bộ lịch trình của tour
     * @param int $tourId Tour ID
     * @return bool Success status
     */
    public function deleteLichTrinhByTour($tourId)
    {
        try {
            $sql = "DELETE FROM lich_trinh WHERE tour_id = :tour_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['tour_id' => $tourId]);
        } catch (Exception $e) {
            echo "Lỗi deleteLichTrinhByTour: " . $e->getMessage();
            return false;
        }
    }
}
