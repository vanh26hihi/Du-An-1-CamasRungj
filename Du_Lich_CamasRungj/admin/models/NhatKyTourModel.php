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
            // trong DB lưu dạng '../img/nhatky/filename'
            $relative = str_replace('../', '', $row['anh_tour']);
            $filePath = PATH_ROOT . $relative;
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
