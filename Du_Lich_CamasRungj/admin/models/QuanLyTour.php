<?php
class Tour
{
    private $conn;
    private $table = "tour";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy danh sách tour
    public function getAll()
    {
        $sql = "SELECT  tour.* , danh_muc_tour.ten FROM tour
        JOIN danh_muc_tour 
                 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy 1 tour theo id
    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE tour_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm tour
    public function insert($data)
    {
        $sql = "INSERT INTO $this->table 
            (ten, danh_muc_id, mo_ta_ngan, mo_ta, gia_co_ban, thoi_luong_mac_dinh,
             chinh_sach, nguoi_tao_id, ngay_tao, diem_khoi_hanh, hoat_dong)
            VALUES
            (:ten, :danh_muc_id, :mo_ta_ngan, :mo_ta, :gia_co_ban, :thoi_luong_mac_dinh,
             :chinh_sach, :nguoi_tao_id, :ngay_tao, :diem_khoi_hanh, :hoat_dong)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật tour
    public function update($data)
    {
        $sql = "UPDATE $this->table SET 
            ten = :ten,
            danh_muc_id = :danh_muc_id,
            mo_ta_ngan = :mo_ta_ngan,
            mo_ta = :mo_ta,
            gia_co_ban = :gia_co_ban,
            thoi_luong_mac_dinh = :thoi_luong_mac_dinh,
            chinh_sach = :chinh_sach,
            diem_khoi_hanh = :diem_khoi_hanh,
            hoat_dong = :hoat_dong
            WHERE tour_id = :tour_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa tour
    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE tour_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
