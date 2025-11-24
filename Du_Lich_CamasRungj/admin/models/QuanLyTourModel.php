<?php

class QuanLyTourModel {
    public $conn;

    public function __construct(){
        $this->conn = connectDB();
    }

    // Lấy tất cả tour
    public function getAllTours() {
        $sql = "SELECT tour.*,
                danh_muc_tour.ten as ten_loai_tour
         FROM tour 
        JOIN danh_muc_tour ON danh_muc_tour.danh_muc_id = tour.danh_muc_id
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // Lấy tour theo ID
    public function getById($id) {
        $sql = "SELECT * FROM tour WHERE tour_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Thêm tour mới
    public function insert($data) {
        $sql = "INSERT INTO tour 
                (ten, danh_muc_id, mo_ta_ngan, mo_ta, gia_co_ban, hoat_dong, thoi_luong_mac_dinh, chinh_sach, nguoi_tao_id, ngay_tao, diem_khoi_hanh) 
                VALUES (:ten, :danh_muc_id, :mo_ta_ngan, :mo_ta, :gia_co_ban, :hoat_dong, :thoi_luong_mac_dinh, :chinh_sach, :nguoi_tao_id, NOW(), :diem_khoi_hanh)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten' => $data['ten'],
            'danh_muc_id' => $data['danh_muc_id'],
            'mo_ta_ngan' => $data['mo_ta_ngan'],
            'mo_ta' => $data['mo_ta'],
            'gia_co_ban' => $data['gia_co_ban'],
            'hoat_dong' => $data['hoat_dong'],
            'thoi_luong_mac_dinh' => $data['thoi_luong_mac_dinh'],
            'chinh_sach' => $data['chinh_sach'],
            'nguoi_tao_id' => $data['nguoi_tao_id'],
            'diem_khoi_hanh' => $data['diem_khoi_hanh']
        ]);
    }

    // Cập nhật tour
    public function update($id, $data) {
        $sql = "UPDATE tour SET 
                    ten=:ten,
                    danh_muc_id=:danh_muc_id,
                    mo_ta_ngan=:mo_ta_ngan,
                    mo_ta=:mo_ta,
                    gia_co_ban=:gia_co_ban,
                    hoat_dong=:hoat_dong,
                    thoi_luong_mac_dinh=:thoi_luong_mac_dinh,
                    chinh_sach=:chinh_sach,
                    diem_khoi_hanh=:diem_khoi_hanh
                WHERE tour_id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten' => $data['ten'],
            'danh_muc_id' => $data['danh_muc_id'],
            'mo_ta_ngan' => $data['mo_ta_ngan'],
            'mo_ta' => $data['mo_ta'],
            'gia_co_ban' => $data['gia_co_ban'],
            'hoat_dong' => $data['hoat_dong'],
            'thoi_luong_mac_dinh' => $data['thoi_luong_mac_dinh'],
            'chinh_sach' => $data['chinh_sach'],
            'diem_khoi_hanh' => $data['diem_khoi_hanh'],
            'id' => $id
        ]);
    }

    // Xóa tour
    public function destroyTour($id) {
        try {
            $sql = "DELETE FROM tour WHERE tour_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            echo "Lỗi xóa tour: " . $e->getMessage();
            return false;
        }
    }
}
?>
