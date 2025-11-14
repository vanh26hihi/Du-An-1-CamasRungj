<?php
require_once '../commons/env.php';

class HDVModel {

    // Lấy danh sách tour HDV được phân công
    public static function getToursByHDV($hdv_id) {
        $sql = "SELECT p.phan_cong_id, t.tour_id, t.ten AS ten_tour, 
                       l.lich_id, l.ngay_bat_dau, l.ngay_ket_thuc, l.trang_thai
                FROM phan_cong_hdv p
                JOIN lich_khoi_hanh l ON p.lich_id = l.lich_id
                JOIN tour t ON l.tour_id = t.tour_id
                WHERE p.hdv_id = ?";
        return db_query($sql, [$hdv_id])->fetchAll();
    }

    // Lấy danh sách hành khách của 1 lịch cụ thể
    public static function getPassengersByLich($lich_id) {
        $sql = "SELECT hk.ho_ten, hk.cccd, hk.so_dien_thoai, hk.ghi_chu
                FROM dat_tour dt
                JOIN hanh_khach_list hk ON hk.dat_tour_id = dt.dat_tour_id
                WHERE dt.lich_id = ?";
        return db_query($sql, [$lich_id])->fetchAll();
    }

    //Lấy lịch trình chi tiết của tour
    public static function getItinerary($tour_id) {
        $sql = "SELECT lich_trinh_id, ngay_thu, tieu_de, noi_dung 
                FROM lich_trinh WHERE tour_id = ? ORDER BY ngay_thu ASC";
        return db_query($sql, [$tour_id])->fetchAll();
    }

    // Lấy yêu cầu đặc biệt của khách trong tour
    public static function getSpecialRequests($lich_id) {
        $sql = "SELECT hk.hanh_khach_id, hk.ho_ten, hk.yeu_cau_dac_biet
                FROM dat_tour dt
                JOIN hanh_khach_list hk ON hk.dat_tour_id = dt.dat_tour_id
                WHERE dt.lich_id = ? AND hk.yeu_cau_dac_biet IS NOT NULL
                ORDER BY hk.ho_ten";
        return db_query($sql, [$lich_id])->fetchAll();
    }

    // Lấy chi tiết khách hàng
    public static function getCustomerDetails($khach_hang_id) {
        $sql = "SELECT hanh_khach_id, ho_ten, yeu_cau_dac_biet
                FROM hanh_khach_list
                WHERE hanh_khach_id = ?";
        return db_query($sql, [$khach_hang_id])->fetch();
    }

    // Cập nhật yêu cầu đặc biệt của khách
    public static function updateSpecialRequest($data) {
        $sql = "UPDATE hanh_khach_list 
                SET yeu_cau_dac_biet = ?
                WHERE hanh_khach_id = ?";
        return db_query($sql, [$data['yeu_cau_dac_biet'], $data['khach_hang_id']]);
    }

}
