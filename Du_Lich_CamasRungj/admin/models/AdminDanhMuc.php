<?php
class AdminDanhMuc {
    public $conn;

    public function __construct(){
  
        $this->conn = connectDB();
    }

public function getAll() {
    $sql = "SELECT * FROM danh_muc_tour ";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getById($id) {
$sql = "SELECT * FROM danh_muc_tour WHERE danh_muc_id = :id";
$stmt = $this->conn->prepare($sql);
$stmt->execute(['id'=>$id]);
return $stmt->fetch(PDO::FETCH_ASSOC);
}
// thêm danh mục
public function insertDanhMuc($ten, $mo_ta,$trang_thai) {
    $sql = "INSERT INTO danh_muc_tour(ten, mo_ta, trang_thai, ngay_tao) VALUES (:ten,:mo_ta, :trang_thai, NOW())";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute(['ten' => $ten,
    'mo_ta'=>$mo_ta,
    'trang_thai' => $trang_thai,
]);
}
// cập nhật danh mục
public function updateDanhMuc($id, $ten, $mo_ta, $trang_thai, $ngay_tao) {
    $sql = "update danh_muc_tour set ten = :ten,
     mo_ta=:mo_ta,
      trang_thai = :trang_thai,
      ngay_tao = :ngay_tao
       where danh_muc_id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute(['ten'=>$ten,
                            'mo_ta'=>$mo_ta,
                             'trang_thai'=>$trang_thai,
                             'ngay_tao'=>$ngay_tao,
                             'id'=>$id ]);
}
// xóa danh mục
public function destroyDanhMuc ($id)
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
?>