<?php
require_once '../commons/env.php';

class DiemDanhModel {

    // Cập nhật điểm danh
    public static function checkIn($data) {
        $sql = "INSERT INTO diem_danh_khach (hanh_khach_id, lich_trinh_id, dia_diem_id, hdv_id, da_den, thoi_gian, ghi_chu)
                VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        db_query($sql, [
            $data['hanh_khach_id'], $data['lich_trinh_id'], $data['dia_diem_id'],
            $data['hdv_id'], $data['da_den'], $data['ghi_chu']
        ]);
    }

    // Lấy danh sách điểm danh theo lịch trình
    public static function getAttendance($lich_trinh_id, $hdv_id) {
        $sql = "SELECT d.*, hk.ho_ten
                FROM diem_danh_khach d
                JOIN hanh_khach_list hk ON hk.hanh_khach_id = d.hanh_khach_id
                WHERE d.lich_trinh_id = ? AND d.hdv_id = ?";
        return db_query($sql, [$lich_trinh_id, $hdv_id])->fetchAll();
    }
}
