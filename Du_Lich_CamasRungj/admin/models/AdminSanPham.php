<?php
class AdminSanPham
{
  public $conn;

  public function __construct()
  {
    $this->conn  = connectDB();
  }

  //Lấy Tất cả trong bảng sản phẩm
  public function getAllSanPham()
  {
    try {
      $sql = 'SELECT * FROM san_phams
                  INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                  INNER JOIN trang_thai_san_pham ON san_phams.trang_thai = trang_thai_san_pham.id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  //Lấy Tất cả trong bảng danh mục
  public function getAllDanhMuc()
  {
    try {
      $sql = 'SELECT * FROM `danh_mucs`';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  //Lấy tất cả trong trạng thái sản phẩm
  public function getListAnhSanPham($id)
  {
    try {
      $sql = 'SELECT * FROM `hinh_anh_san_phams`WHERE `san_pham_id` = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':id' => $id,
      ]);
      return $stmt->fetchAll();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }
  //Lấy list ảnh sản phẩm
  public function getAllTrangThai()
  {
    try {
      $sql = 'SELECT * FROM `trang_thai_san_pham`';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }
  // xử lý và thêm sản phẩm
  public function insertSanPham($ten_san_pham, $hinh_anh, $gia_san_pham, $gia_khuyen_mai, $so_luong, $danh_muc_id, $trang_thai, $luot_xem, $ngay_nhap, $mo_ta)
  {
    try {
      $sql = 'INSERT INTO san_phams(ten_san_pham , hinh_anh , gia_san_pham,gia_khuyen_mai , so_luong , danh_muc_id , trang_thai , luot_xem , ngay_nhap , mo_ta)
                VALUES(:ten_san_pham , :hinh_anh , :gia_san_pham, :gia_khuyen_mai , :so_luong , :danh_muc_id , :trang_thai , :luot_xem , :ngay_nhap , :mo_ta)';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':ten_san_pham' => $ten_san_pham,
        ':hinh_anh' => $hinh_anh,
        ':gia_khuyen_mai' => $gia_khuyen_mai,
        ':gia_san_pham' => $gia_san_pham,
        ':so_luong' => $so_luong,
        ':danh_muc_id' => $danh_muc_id,
        ':trang_thai' => $trang_thai,
        ':luot_xem' => $luot_xem,
        ':ngay_nhap' => $ngay_nhap,
        ':mo_ta' => $mo_ta,
      ]);

      //Lấy id sản phẩm vừa thêm
      return $this->conn->lastInsertId();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  //Lấy Sản Phẩm có ID tương ứng
  public function getDetailSanPham($id)
  {
    try {
      $sql = 'SELECT * FROM san_phams 
                  INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                  INNER JOIN trang_thai_san_pham ON san_phams.trang_thai = trang_thai_san_pham.id
                  WHERE san_phams.id_san_pham = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':id' => $id,
      ]);
      return $stmt->fetch();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }
  public function getDetailBinhLuan($id)
  {
    try {
      $sql = 'SELECT * FROM binh_luans WHERE id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':id' => $id,
      ]);
      return $stmt->fetch();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  //Xử lý và Sửa Sản phẩm
  public function updateSanPham($id, $ten_san_pham, $hinh_anh, $gia_san_pham, $gia_khuyen_mai, $so_luong, $danh_muc_id, $trang_thai, $luot_xem, $ngay_nhap, $mo_ta)
  {
    try {
      $sql = 'UPDATE san_phams SET ten_san_pham = :ten_san_pham, hinh_anh = :hinh_anh , gia_san_pham = :gia_san_pham ,gia_khuyen_mai = :gia_khuyen_mai, so_luong = :so_luong , danh_muc_id = :danh_muc_id, trang_thai = :trang_thai , luot_xem = :luot_xem , ngay_nhap  = :ngay_nhap, mo_ta = :mo_ta WHERE id_san_pham = :id';

      $stmt = $this->conn->prepare($sql);

      $stmt->execute([
        ':id' => $id,
        ':ten_san_pham' => $ten_san_pham,
        ':hinh_anh' => $hinh_anh,
        ':gia_san_pham' => $gia_san_pham,
        ':gia_khuyen_mai' => $gia_khuyen_mai,
        ':so_luong' => $so_luong,
        ':danh_muc_id' => $danh_muc_id,
        ':trang_thai' => $trang_thai,
        ':luot_xem' => $luot_xem,
        ':ngay_nhap' => $ngay_nhap,
        ':mo_ta' => $mo_ta,
      ]);
      return true;
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  public function updateTrangThaiBinhLuan($id, $trang_thai)
  {
    try {
      $sql = 'UPDATE binh_luans SET trang_thai = :trang_thai WHERE id = :id';

      $stmt = $this->conn->prepare($sql);

      $stmt->execute([
        ':id' => $id,
        ':trang_thai' => $trang_thai,
      ]);
      return true;
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  //Xóa sản phẩm được chọn
  public function destroySanPham($id)
  {
    try {
      $sql = "DELETE FROM san_phams WHERE `id_san_pham` = :id";

      $stmt = $this->conn->prepare($sql);

      $stmt->execute([
        ':id' => $id,
      ]);
      return true;
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  //Thêm Album sản phẩm
  public function insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh)
  {
    try {
      $sql = 'INSERT INTO hinh_anh_san_phams(san_pham_id , link_hinh_anh ) VALUES(:san_pham_id , :link_hinh_anh )';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':san_pham_id' => $san_pham_id,
        ':link_hinh_anh' => $link_hinh_anh,
      ]);

      //Lấy id sản phẩm vừa thêm
      return true;
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  public function getDetailAnhSanPham($id)
  {
    try {
      $sql = 'SELECT * FROM hinh_anh_san_phams WHERE id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':id' => $id,
      ]);
      return $stmt->fetch();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  public function updateAnhSanpham($id, $new_file)
  {
    try {
      $sql = 'UPDATE hinh_anh_san_phams SET link_hinh_anh = :new_file, WHERE id = :id';

      $stmt = $this->conn->prepare($sql);

      $stmt->execute([
        ':id' => $id,
        ':new_file' => $new_file,
      ]);
      return true;
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  public function destroyAnhSanPham($id)
  {
    try {
      $sql = "DELETE FROM hinh_anh_san_phams WHERE `id` = :id";

      $stmt = $this->conn->prepare($sql);

      $stmt->execute([
        ':id' => $id,
      ]);
      return true;
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }
  public function getBinhLuanFromKhachHang($id)
  {
    try {
      $sql = 'SELECT binh_luans.*,san_phams.ten_san_pham
      FROM binh_luans
                  INNER JOIN san_phams ON binh_luans.san_pham_id = san_phams.id_san_pham
                  WHERE binh_luans.tai_khoan_id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':id' => $id,
      ]);
      return $stmt->fetchAll();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }

  public function getBinhLuanFromSanPham($id)
  {
    try {
      $sql = 'SELECT binh_luans.*,tai_khoans.ho_ten
      FROM binh_luans
                  INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
                  WHERE binh_luans.san_pham_id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':id' => $id,
      ]);
      return $stmt->fetchAll();
    } catch (Exception $e) {
      echo "Lỗi" . $e->getMessage();
    }
  }
}
