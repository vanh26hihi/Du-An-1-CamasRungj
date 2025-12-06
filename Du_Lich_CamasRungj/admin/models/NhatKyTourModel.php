<?php
require_once '../commons/env.php';

class NhatKyTourModel {

    // Thêm nhật ký tour (ảnh + nội dung)
    public static function add($data) {
        $sql = "INSERT INTO nhat_ky_tour (tour_id, hdv_id, lich_id, dia_diem_id, anh_tour, ngay_thuc_hien, noi_dung)
                VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        db_query($sql, [
            $data['tour_id'], $data['hdv_id'], $data['lich_id'],
            $data['dia_diem_id'], $data['anh_tour'], $data['noi_dung']
        ]);
    }

    // Xem nhật ký tour theo HDV
    public static function getByHDV($hdv_id) {
        $sql = "SELECT nk.nhat_ky_tour_id, nk.ngay_thuc_hien, nk.noi_dung, nk.anh_tour,
                       d.ten AS dia_diem, t.ten AS tour
                FROM nhat_ky_tour nk
                JOIN dia_diem d ON d.dia_diem_id = nk.dia_diem_id
                JOIN tour t ON t.tour_id = nk.tour_id
                WHERE nk.hdv_id = ?
                ORDER BY nk.ngay_thuc_hien DESC";
        return db_query($sql, [$hdv_id])->fetchAll();
    }

    // Lấy nhật ký tour theo lich_id
    public static function getByLich($lich_id) {
        $sql = "SELECT nhat_ky_tour.nhat_ky_tour_id, 
                       nhat_ky_tour.ngay_thuc_hien,
                       nhat_ky_tour.noi_dung,
                       nhat_ky_tour.anh_tour,
                       COALESCE(dia_diem.ten, 'Chưa xác định') as dia_diem,
                       tour.ten as tour
                FROM nhat_ky_tour
                LEFT JOIN dia_diem ON dia_diem.dia_diem_id = nhat_ky_tour.dia_diem_id
                LEFT JOIN tour ON tour.tour_id = nhat_ky_tour.tour_id
                WHERE nhat_ky_tour.lich_id = ?
                ORDER BY nhat_ky_tour.ngay_thuc_hien DESC";
        return db_query($sql, [$lich_id])->fetchAll();
    }
    
    // Lấy tất cả nhật ký tour (của tất cả HDV)
    public static function getAll() {
        $sql = "SELECT nk.nhat_ky_tour_id, nk.ngay_thuc_hien, nk.noi_dung, nk.anh_tour,
                       d.ten AS dia_diem, t.ten AS tour, nk.hdv_id, hdv.ho_ten AS hdv_ten
                FROM nhat_ky_tour nk
                JOIN dia_diem d ON d.dia_diem_id = nk.dia_diem_id
                JOIN tour t ON t.tour_id = nk.tour_id
                LEFT JOIN huong_dan_vien hdv ON nk.hdv_id = hdv.hdv_id
                ORDER BY nk.ngay_thuc_hien DESC";
        return db_query($sql)->fetchAll();
    }

    // Lấy chi tiết nhật ký theo ID
    public static function getById($nhat_ky_id) {
        $sql = "SELECT * FROM nhat_ky_tour WHERE nhat_ky_tour_id = ?";
        return db_query($sql, [$nhat_ky_id])->fetch();
    }

    // Thêm nhật ký tour mới (dùng cấu trúc bảng hiện tại)
    public static function insert($data) {
        // Nếu dùng cấu trúc mới (có dia_diem, mo_ta, ngay_ghi)
        if (isset($data[':dia_diem']) && isset($data[':mo_ta'])) {
            // Thử insert với cấu trúc mới trước
            try {
                $sql = "INSERT INTO nhat_ky_tour (lich_id, dia_diem, mo_ta, ngay_ghi, nguoi_tao_id)
                        VALUES (:lich_id, :dia_diem, :mo_ta, :ngay_ghi, :nguoi_tao_id)";
                $stmt = connectDB()->prepare($sql);
                return $stmt->execute($data);
            } catch (Exception $e) {
                // Nếu lỗi, dùng cấu trúc cũ
            }
        }
        
        // Dùng cấu trúc cũ (tour_id, hdv_id, lich_id, dia_diem_id, noi_dung)
        // Lấy tour_id từ lich_id
        $sqlLich = "SELECT tour_id FROM lich_khoi_hanh WHERE lich_id = ?";
        $lichInfo = db_query($sqlLich, [$data[':lich_id']])->fetch();
        if (!$lichInfo) {
            return false;
        }
        
        // Lấy hdv_id từ data hoặc từ nguoi_tao_id
        $hdv_id = $data[':hdv_id'] ?? null;
        if (!$hdv_id && isset($data[':nguoi_tao_id'])) {
            require_once './models/HDVModel.php';
            $hdvInfo = HDVModel::getHDVByNguoiDungId($data[':nguoi_tao_id']);
            $hdv_id = $hdvInfo ? $hdvInfo['hdv_id'] : null;
        }
        
        // Lấy dia_diem_id từ tên địa điểm (tìm trong bảng dia_diem)
        $dia_diem_id = null;
        if (isset($data[':dia_diem']) && !empty($data[':dia_diem'])) {
            $sqlDiaDiem = "SELECT dia_diem_id FROM dia_diem WHERE ten LIKE ? LIMIT 1";
            $diaDiem = db_query($sqlDiaDiem, ['%' . $data[':dia_diem'] . '%'])->fetch();
            $dia_diem_id = $diaDiem ? $diaDiem['dia_diem_id'] : null;
        }
        
        // Nếu không tìm thấy, lấy địa điểm đầu tiên của tour
        if (!$dia_diem_id) {
            $sqlDiaDiemTour = "SELECT dia_diem_id FROM dia_diem_tour WHERE tour_id = ? LIMIT 1";
            $diaDiemTour = db_query($sqlDiaDiemTour, [$lichInfo['tour_id']])->fetch();
            $dia_diem_id = $diaDiemTour ? $diaDiemTour['dia_diem_id'] : null;
        }
        
        // Nếu vẫn không có, lấy địa điểm đầu tiên trong hệ thống
        if (!$dia_diem_id) {
            $sqlDiaDiemDefault = "SELECT dia_diem_id FROM dia_diem LIMIT 1";
            $diaDiemDefault = db_query($sqlDiaDiemDefault)->fetch();
            $dia_diem_id = $diaDiemDefault ? $diaDiemDefault['dia_diem_id'] : 1;
        }
        
        // Lưu nội dung: "Địa điểm: [dia_diem]\nMô tả: [mo_ta]"
        $noi_dung = '';
        if (isset($data[':dia_diem']) && !empty($data[':dia_diem'])) {
            $noi_dung = "Địa điểm: " . $data[':dia_diem'] . "\n";
        }
        if (isset($data[':mo_ta']) && !empty($data[':mo_ta'])) {
            $noi_dung .= "Mô tả: " . $data[':mo_ta'];
        }
        
        // Xác định ngày thực hiện
        $ngay_thuc_hien = isset($data[':ngay_ghi']) ? $data[':ngay_ghi'] . ' 00:00:00' : date('Y-m-d H:i:s');
        
        // Insert với cấu trúc cũ
        $sql = "INSERT INTO nhat_ky_tour (tour_id, hdv_id, lich_id, dia_diem_id, anh_tour, ngay_thuc_hien, noi_dung)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        return db_query($sql, [
            $lichInfo['tour_id'],
            $hdv_id,
            $data[':lich_id'],
            $dia_diem_id,
            '', // anh_tour
            $ngay_thuc_hien,
            $noi_dung
        ]);
    }

    // Cập nhật nhật ký tour
    public static function update($data) {
        $sql = "UPDATE nhat_ky_tour 
                SET noi_dung = ?, anh_tour = ?
                WHERE nhat_ky_tour_id = ?";
        return db_query($sql, [
            $data['noi_dung'], 
            $data['anh_tour'] ?? null, 
            $data['nhat_ky_id']
        ]);
    }

    // Xóa nhật ký và file ảnh liên quan (nếu có)
    public static function delete($nhat_ky_id) {
        // Lấy bản ghi trước để biết đường dẫn ảnh
        $row = self::getById($nhat_ky_id);
        if (!$row) return false;

        $sql = "DELETE FROM nhat_ky_tour WHERE nhat_ky_tour_id = ?";
        $res = db_query($sql, [$nhat_ky_id]);

        // Xóa file ảnh trên đĩa nếu tồn tại và có đường dẫn
        if (!empty($row['anh_tour'])) {
            $anh = $row['anh_tour'];
            if (strpos($anh, '../') === 0) {
                $anh = str_replace('../', '', $anh);
            }
            if (strpos($anh, 'assets/') !== 0) {
                $anh = 'assets/img/nhatky/' . basename($anh);
            }
            $filePath = PATH_ROOT . $anh;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        return $res;
    }
// thêm phản hồi tour
    public static function addFeedback($data) {
        // Tự động tạo bảng nếu chưa tồn tại
        self::createTableIfNotExists();
        
        $sql = "INSERT INTO danh_gia_tour (hdv_id, tour_id, lich_id, diem_danh_gia, phan_hoi, ngay_tao)
                VALUES (?, ?, ?, ?, ?, NOW())";
        return db_query($sql, [
            $data['hdv_id'], 
            $data['tour_id'], 
            $data['lich_id'], 
            $data['diem_danh_gia'], 
            $data['phan_hoi']
        ]);
    }

    // Lấy danh sách đánh giá tour theo HDV
    public static function getFeedbackByHDV($hdv_id) {
        // Tự động tạo bảng nếu chưa tồn tại
        self::createTableIfNotExists();
        
        $sql = "SELECT dg.*, t.ten AS ten_tour, l.ngay_bat_dau, l.ngay_ket_thuc
                FROM danh_gia_tour dg
                LEFT JOIN tour t ON t.tour_id = dg.tour_id
                LEFT JOIN lich_khoi_hanh l ON l.lich_id = dg.lich_id
                WHERE dg.hdv_id = ?
                ORDER BY dg.ngay_tao DESC";
        return db_query($sql, [$hdv_id])->fetchAll();
    }

    // Tạo bảng danh_gia_tour nếu chưa tồn tại
    private static function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS `danh_gia_tour` (
            `danh_gia_id` int NOT NULL AUTO_INCREMENT,
            `hdv_id` int DEFAULT NULL,
            `tour_id` int DEFAULT NULL,
            `lich_id` int DEFAULT NULL,
            `diem_danh_gia` int DEFAULT NULL COMMENT 'Điểm đánh giá từ 1-5',
            `phan_hoi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
            `ngay_tao` datetime DEFAULT NULL,
            PRIMARY KEY (`danh_gia_id`),
            KEY `hdv_id` (`hdv_id`),
            KEY `tour_id` (`tour_id`),
            KEY `lich_id` (`lich_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        try {
            db_query($sql);
        } catch (Exception $e) {
            // Nếu lỗi foreign key, tạo lại không có foreign key
            $sql = "CREATE TABLE IF NOT EXISTS `danh_gia_tour` (
                `danh_gia_id` int NOT NULL AUTO_INCREMENT,
                `hdv_id` int DEFAULT NULL,
                `tour_id` int DEFAULT NULL,
                `lich_id` int DEFAULT NULL,
                `diem_danh_gia` int DEFAULT NULL COMMENT 'Điểm đánh giá từ 1-5',
                `phan_hoi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                `ngay_tao` datetime DEFAULT NULL,
                PRIMARY KEY (`danh_gia_id`),
                KEY `hdv_id` (`hdv_id`),
                KEY `tour_id` (`tour_id`),
                KEY `lich_id` (`lich_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            db_query($sql);
        }
    }
}