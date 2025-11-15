<?php
class AdminDanhMuc {
    private $conn;

    private function __construct(){
  
        $this->conn = connectDB();
    }

private function getAll() {
    $sql = "SELECT * FROM danh_muc_tour order by danh_muc_id desc";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
private function getById($id) {
$sql = "SELECT * FROM danh_muc_tour WHERE id = :id";
$stmt = $this->db->prepare($sql);
$stmt->execute(['id'=>$id]);
return $stmt->fetch(PDO::FETCH_ASSOC);
}
private function add($ten, $trang_thai) {
    $sql = "INSERT INTO danh_muc_tour(ten, trang_thai, ngay_tao) VALUES (:ten, :trang_thai, NOW())";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['ten' => $ten,
                    'trang_thai' => $trang_thai]);
}

private function update($id, $ten, $trang_thai) {
    $sql = "update danh_muc_tour set ten = :ten, trang_thai = :trang_thai where danh_muc_id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['ten'=>$ten,'trang_thai' => $trang_thai, 'id'=>$id ]);
}
private function delete($id) {
    $sql = "delete from danh_muc_tour where danh_muc_id =:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
}
}
?>