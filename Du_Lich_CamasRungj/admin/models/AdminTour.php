<?php
class AdminTour
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ===== TOUR METHODS =====

    // Lấy danh sách tour để chọn (cho form thêm lịch khởi hành)
    public function getAllToursForSelect()
    {
        try {
            $sql = "SELECT tour_id, ten, danh_muc_id FROM tour ORDER BY tour_id DESC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // Lấy danh sách tour kèm info: tên tour, danh mục, lịch khởi hành (ngày bắt đầu), HDV
    public function getAllToursList()
    {
        try {
            $sql = "SELECT 
                        t.tour_id,
                        t.ten AS ten_tour,
                        t.gia_co_ban,
                        lk.lich_id,
                        lk.ngay_bat_dau,
                        t.diem_khoi_hanh AS diem_khoi_hanh,
                        GROUP_CONCAT(CONCAT(h.ho_ten, ' (', pch.vai_tro, ')') SEPARATOR ', ') AS danh_sach_hdv
                    FROM tour t
                    INNER JOIN lich_khoi_hanh lk ON lk.tour_id = t.tour_id
                    LEFT JOIN phan_cong_hdv pch ON pch.lich_id = lk.lich_id
                    LEFT JOIN huong_dan_vien h ON h.hdv_id = pch.hdv_id
                    GROUP BY t.tour_id, lk.lich_id
                    ORDER BY t.tour_id DESC, lk.ngay_bat_dau DESC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // Lấy tour theo ID
    public function getTourById($id)
    {
        $sql = "SELECT * FROM tour WHERE tour_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin chi tiết tour (bao gồm danh mục và địa điểm)
    public function getTourDetailById($id)
    {
        try {
            $sql = "SELECT t.*, dm.ten as ten_danh_muc, dm.mo_ta as mo_ta_danh_muc
                    FROM tour t
                    LEFT JOIN danh_muc_tour dm ON t.danh_muc_id = dm.danh_muc_id
                    WHERE t.tour_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return null;
        }
    }

    // Thêm tour
    public function insertTour($data)
    {
        try {
            $sql = "INSERT INTO tour (ten, danh_muc_id, gia_co_ban, mo_ta_ngan, mo_ta) 
                    VALUES (:ten, :danh_muc_id, :gia_co_ban, :mo_ta_ngan, :mo_ta)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'ten' => $data['ten'],
                'danh_muc_id' => $data['danh_muc_id'],
                'gia_co_ban' => $data['gia_co_ban'],
                'mo_ta_ngan' => $data['mo_ta_ngan'],
                'mo_ta' => $data['mo_ta']
            ]);
            return $result ? $this->conn->lastInsertId() : false;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật tour
    public function updateTour($id, $data)
    {
        try {
            $sql = "UPDATE tour SET ten = :ten, danh_muc_id = :danh_muc_id, 
                    mo_ta_ngan = :mo_ta_ngan, mo_ta = :mo_ta WHERE tour_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'ten' => $data['ten'],
                'danh_muc_id' => $data['danh_muc_id'],
                'mo_ta_ngan' => $data['mo_ta_ngan'],
                'mo_ta' => $data['mo_ta']
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Xóa tour
    public function deleteTour($id)
    {
        try {
            $this->conn->beginTransaction();

            // Xóa lich_trinh
            $sql1 = "DELETE FROM lich_trinh WHERE tour_id = :id";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute(['id' => $id]);

            // Xóa lich_khoi_hanh
            $sql2 = "DELETE FROM lich_khoi_hanh WHERE tour_id = :id";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute(['id' => $id]);

            // Xóa phan_cong_hdv qua lich_khoi_hanh
            $sql3 = "DELETE pc FROM phan_cong_hdv pc 
                     JOIN lich_khoi_hanh lkh ON pc.lich_id = lkh.lich_id 
                     WHERE lkh.tour_id = :id";
            $stmt3 = $this->conn->prepare($sql3);
            $stmt3->execute(['id' => $id]);

            // Xóa tour_dich_vu (nếu có bảng này)
            // $sql4 = "DELETE FROM tour_dich_vu WHERE tour_id = :id";
            // $stmt4 = $this->conn->prepare($sql4);
            // $stmt4->execute(['id' => $id]);

            // Xóa tour
            $sql5 = "DELETE FROM tour WHERE tour_id = :id";
            $stmt5 = $this->conn->prepare($sql5);
            $stmt5->execute(['id' => $id]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // ===== DANH MUC METHODS =====

    public function getDanhMuc()
    {
        $sql = "SELECT * FROM danh_muc_tour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // ===== LICH KHOI HANH METHODS =====

    public function insertLichKhoiHanh($data)
    {
        try {
            $sql = "INSERT INTO lich_khoi_hanh (tour_id, ngay_bat_dau, ngay_ket_thuc, trang_thai_id, ghi_chu, ngay_tao) 
                    VALUES (:tour_id, :ngay_bat_dau, :ngay_ket_thuc, :trang_thai_id, :ghi_chu, NOW())";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'tour_id' => $data['tour_id'],
                'ngay_bat_dau' => $data['ngay_bat_dau'],
                'ngay_ket_thuc' => $data['ngay_ket_thuc'],
                'trang_thai_id' => $data['trang_thai_id'],
                'ghi_chu' => $data['ghi_chu']
            ]);
            return $result ? $this->conn->lastInsertId() : false;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function getLichKhoiHanhByTour($tourId)
    {
        $sql = "SELECT * FROM lich_khoi_hanh WHERE tour_id = :tour_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLichKhoiHanhById($lichId)
    {
        $sql = "SELECT lk.*, tt.ten_trang_thai 
                FROM lich_khoi_hanh lk 
                LEFT JOIN trang_thai_lich_khoi_hanh tt ON lk.trang_thai_id = tt.trang_thai_id 
                WHERE lk.lich_id = :lich_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['lich_id' => $lichId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLichKhoiHanh($lichId, $data)
    {
        try {
            $sql = "UPDATE lich_khoi_hanh SET 
                    tour_id = :tour_id,
                    ngay_bat_dau = :ngay_bat_dau,
                    ngay_ket_thuc = :ngay_ket_thuc,
                    trang_thai_id = :trang_thai_id,
                    ghi_chu = :ghi_chu
                    WHERE lich_id = :lich_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'lich_id' => $lichId,
                'tour_id' => $data['tour_id'],
                'ngay_bat_dau' => $data['ngay_bat_dau'],
                'ngay_ket_thuc' => $data['ngay_ket_thuc'],
                'trang_thai_id' => $data['trang_thai_id'],
                'ghi_chu' => $data['ghi_chu']
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // ===== LICH TRINH METHODS =====

    public function insertLichTrinh($data)
    {
        try {
            // Insert vào lich_trinh (chỉ có tour_id, ngay_thu, tieu_de, noi_dung)
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

    // ===== HDV METHODS =====

    public function getAllHDV()
    {
        $sql = "SELECT * FROM huong_dan_vien ORDER BY ho_ten ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHDVById($id)
    {
        try {
            $sql = "SELECT * FROM huong_dan_vien WHERE hdv_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return null;
        }
    }

    public function insertPhanCongHDV($data)
    {
        try {
            $sql = "INSERT INTO phan_cong_hdv (lich_id, hdv_id, vai_tro, ngay_phan_cong) 
                    VALUES (:lich_id, :hdv_id, :vai_tro, NOW())";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'lich_id' => $data['lich_id'],
                'hdv_id' => $data['hdv_id'],
                'vai_tro' => $data['vai_tro'] ?? 'main'
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function getPhanCongHDVByLich($lichId)
    {
        $sql = "SELECT pc.*, h.ho_ten FROM phan_cong_hdv pc 
                JOIN huong_dan_vien h ON pc.hdv_id = h.hdv_id 
                WHERE pc.lich_id = :lich_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['lich_id' => $lichId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLichTrinhByLichId($lichId)
    {
        $sql = "SELECT lt.*, dd.ten as ten_dia_diem 
                FROM lich_trinh lt
                LEFT JOIN dia_diem dd ON lt.dia_diem_id = dd.dia_diem_id
                WHERE lt.lich_id = :lich_id
                ORDER BY lt.ngay_thu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['lich_id' => $lichId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateLichTrinh($lichTrinhId, $data)
    {
        try {
            // Cập nhật nội dung trong lich_trinh
            $sql = "UPDATE lich_trinh SET noi_dung = :noi_dung WHERE lich_trinh_id = :lich_trinh_id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'lich_trinh_id' => $lichTrinhId,
                'noi_dung' => $data['noi_dung']
            ]);

            // Nếu có mo_ta, cập nhật trong dia_diem_lich_trinh
            if (isset($data['mo_ta'])) {
                $sql2 = "UPDATE dia_diem_lich_trinh SET mo_ta = :mo_ta WHERE lich_trinh_id = :lich_trinh_id";
                $stmt2 = $this->conn->prepare($sql2);
                $stmt2->execute([
                    'lich_trinh_id' => $lichTrinhId,
                    'mo_ta' => $data['mo_ta']
                ]);
            }

            return $result;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function deletePhanCongHDVByLich($lichId)
    {
        try {
            $sql = "DELETE FROM phan_cong_hdv WHERE lich_id = :lich_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['lich_id' => $lichId]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // ===== TRANG THAI METHODS =====

    public function getAllTrangThaiLichKhoiHanh()
    {
        try {
            $sql = "SELECT * FROM trang_thai_lich_khoi_hanh ORDER BY trang_thai_id ASC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // ===== DICH VU METHODS =====

    // Lấy id dịch vụ đã chọn cho 1 lịch khởi hành (lấy từ tour_ncc)
    public function getDichVuByLich($lichId)
    {
        try {
            $sql = "SELECT tn.dich_vu_id, tn.ghi_chu, dv.loai_dich_vu
                    FROM tour_ncc tn
                    LEFT JOIN dich_vu_ncc dv ON tn.dich_vu_id = dv.dich_vu_id
                    WHERE tn.lich_id = :lich_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['lich_id' => $lichId]);
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result = [
                'transport_id' => '',
                'transport_ghi_chu' => '',
                'hotel_id' => '',
                'hotel_ghi_chu' => '',
                'catering_id' => '',
                'catering_ghi_chu' => ''
            ];

            foreach ($services as $service) {
                if ($service['loai_dich_vu'] == 'transport') {
                    $result['transport_id'] = $service['dich_vu_id'];
                    $result['transport_ghi_chu'] = $service['ghi_chu'];
                } elseif ($service['loai_dich_vu'] == 'hotel') {
                    $result['hotel_id'] = $service['dich_vu_id'];
                    $result['hotel_ghi_chu'] = $service['ghi_chu'];
                } elseif ($service['loai_dich_vu'] == 'catering') {
                    $result['catering_id'] = $service['dich_vu_id'];
                    $result['catering_ghi_chu'] = $service['ghi_chu'];
                }
            }
            return $result;
        } catch (Exception $e) {
            return [
                'transport_id' => '',
                'transport_ghi_chu' => '',
                'hotel_id' => '',
                'hotel_ghi_chu' => '',
                'catering_id' => '',
                'catering_ghi_chu' => ''
            ];
        }
    }

    // Lấy danh sách dịch vụ đầy đủ cho một lịch khởi hành (dùng cho hiển thị chi tiết)
    public function getDichVuListByLich($lichId)
    {
        try {
            $sql = "SELECT tn.dich_vu_id, tn.ghi_chu, tn.gia_thoa_thuan,
                           dv.loai_dich_vu, dv.ma, dv.mo_ta, dv.gia_mac_dinh,
                           ncc.ten as ten_nha_cung_cap, ncc.lien_he, ncc.dia_chi
                    FROM tour_ncc tn
                    LEFT JOIN dich_vu_ncc dv ON tn.dich_vu_id = dv.dich_vu_id
                    LEFT JOIN nha_cung_cap ncc ON dv.ncc_id = ncc.ncc_id
                    WHERE tn.lich_id = :lich_id
                    ORDER BY dv.loai_dich_vu ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['lich_id' => $lichId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }



    public function getAllDichVu()
    {
        // Alias ten_dich_vu tổng hợp từ mã hoặc mô tả (rút gọn) để dùng thống nhất trên view
        $sql = "SELECT dv.*, 
                       COALESCE(dv.ma, LEFT(dv.mo_ta, 60)) AS ten_dich_vu,
                       ncc.ten as ten_nha_cung_cap, ncc.lien_he, ncc.dia_chi 
                FROM dich_vu_ncc dv
                LEFT JOIN nha_cung_cap ncc ON dv.ncc_id = ncc.ncc_id
                ORDER BY dv.loai_dich_vu, ncc.ten";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDichVuByType($loaiDichVu)
    {
        try {
            $sql = "SELECT dv.*, 
                           COALESCE(dv.ma, LEFT(dv.mo_ta, 60)) AS ten_dich_vu,
                           ncc.ten as ten_nha_cung_cap, ncc.lien_he, ncc.dia_chi 
                    FROM dich_vu_ncc dv
                    LEFT JOIN nha_cung_cap ncc ON dv.ncc_id = ncc.ncc_id
                    WHERE dv.loai_dich_vu = :loai 
                    ORDER BY ncc.ten ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['loai' => $loaiDichVu]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function getGiaMacDinhByDichVuId($dichVuId)
    {
        try {
            $sql = "SELECT gia_mac_dinh FROM dich_vu_ncc WHERE dich_vu_id = :dich_vu_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['dich_vu_id' => $dichVuId]);
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function insertDichVuTour($lichId, $dichVuData)
    {
        try {
            // Xóa dịch vụ cũ của lịch này (nếu có)
            $this->deleteDichVuTour($lichId);

            // Insert các dịch vụ mới
            // $dichVuData = [
            //   ['dich_vu_id' => 1, 'gia_thoa_thuan' => 1000000, 'ghi_chu' => '...'],
            //   ...
            // ]
            foreach ($dichVuData as $dv) {
                if (!empty($dv['dich_vu_id'])) {
                    $sql = "INSERT INTO tour_ncc (lich_id, dich_vu_id, gia_thoa_thuan, ghi_chu, ma_hop_dong) 
                            VALUES (:lich_id, :dich_vu_id, :gia_thoa_thuan, :ghi_chu, NULL)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        'lich_id' => $lichId,
                        'dich_vu_id' => $dv['dich_vu_id'],
                        'gia_thoa_thuan' => $dv['gia_thoa_thuan'] ?? 0,
                        'ghi_chu' => $dv['ghi_chu'] ?? ''
                    ]);
                }
            }
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function deleteDichVuTour($lichId)
    {
        try {
            $sql = "DELETE FROM tour_ncc WHERE lich_id = :lich_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['lich_id' => $lichId]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function insertTourDichVu($tourId, $dichVuId)
    {
        try {
            // Lưu ý: Nếu có bảng tour_dich_vu riêng thì dùng, nếu không thì lưu trực tiếp vào bảng khác
            // Tạm thời comment vì chưa rõ cấu trúc liên kết tour-dịch vụ
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function getTourDichVu($tourId)
    {
        // Placeholder - cần xác định bảng liên kết tour-dịch vụ
        return [];
    }

    // ===== DELETE TOUR CASCADE =====
    public function deleteLichKhoiHanh($lichId)
    {
        try {
            $this->conn->beginTransaction();

            // 1. Xóa lịch trình của lịch khởi hành
            $sql = "DELETE FROM lich_trinh WHERE lich_id = :lich_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['lich_id' => $lichId]);

            // 2. Xóa phân công HDV
            $sql = "DELETE FROM phan_cong_hdv WHERE lich_id = :lich_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['lich_id' => $lichId]);

            // 3. Xóa dịch vụ tour_ncc
            $this->deleteDichVuTour($lichId);

            // 4. Xóa lịch khởi hành
            $sql = "DELETE FROM lich_khoi_hanh WHERE lich_id = :lich_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['lich_id' => $lichId]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Lỗi xóa lịch khởi hành: " . $e->getMessage();
            return false;
        }
    }

    public function getAllLichKhoiHanhByTour($tourId)
    {
        try {
            $sql = "SELECT lich_id FROM lich_khoi_hanh WHERE tour_id = :tour_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['tour_id' => $tourId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy lịch khởi hành mới nhất (làm template sao chép HDV & dịch vụ)
    public function getLatestLichByTour($tourId)
    {
        try {
            $sql = "SELECT * FROM lich_khoi_hanh WHERE tour_id = :tour_id ORDER BY ngay_bat_dau DESC, lich_id DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['tour_id' => $tourId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Xóa tất cả lịch khởi hành của tour
     */
    public function deleteLichKhoiHanhByTour($tourId)
    {
        try {
            // Lấy tất cả lich_id của tour
            $lichIds = $this->getAllLichKhoiHanhByTour($tourId);
            
            // Xóa từng lịch (cascade delete lịch trình, HDV, dịch vụ)
            foreach ($lichIds as $lichId) {
                $this->deleteLichKhoiHanh($lichId);
            }
            
            return true;
        } catch (Exception $e) {
            echo "Lỗi deleteLichKhoiHanhByTour: " . $e->getMessage();
            return false;
        }
    }
    
    /**
     * Xóa tour theo tour_id
     */
    public function deleteTourById($tourId)
    {
        try {
            $sql = "DELETE FROM tour WHERE tour_id = :tour_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['tour_id' => $tourId]);
        } catch (Exception $e) {
            echo "Lỗi deleteTourById: " . $e->getMessage();
            return false;
        }
    }
}
