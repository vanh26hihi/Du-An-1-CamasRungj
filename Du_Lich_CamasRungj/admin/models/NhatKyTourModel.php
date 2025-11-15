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
// thêm phản hồi tour
    public static function addFeedback($data) {
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
}
