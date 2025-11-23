<?php
class AdminDanhMuc
{
    public $conn;

    public function __construct()
    {

        $this->conn = connectDB();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM danh_muc_tour ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM danh_muc_tour WHERE id = :id";

        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function add($ten, $trang_thai)
    {
        $sql = "INSERT INTO danh_muc_tour(ten, trang_thai, ngay_tao) VALUES (:ten, :trang_thai, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'ten' => $ten,
            'trang_thai' => $trang_thai
        ]);
    }

    public function update($id, $ten, $trang_thai)
    {
        $sql = "update danh_muc_tour set ten = :ten, trang_thai = :trang_thai where danh_muc_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ten' => $ten, 'trang_thai' => $trang_thai, 'id' => $id]);
    }

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
}
