<?php
class AdminSanPhamController
{
    public $modelSanPham;
    public function __construct()
    {
        $this->modelSanPham = new AdminSanPham();
    }

    // Lấy ra sản phẩm
    public function danhSachSanPham()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/sanpham/listSanPham.php';
    }

    //Chuyển đến form thêm sản phẩm
    public function formAddSanPham()
    {
        // hàm này dùng để nhập form sản phẩm
        $listDanhMuc = $this->modelSanPham->getAllDanhMuc();
        $listTrangThai = $this->modelSanPham->getAllTrangThai();
        // var_dump($listDanhMuc);
        // die();
        require_once './views/sanpham/addSanPham.php';

        //Xóa session sau khi load lại trang;
        deleteSessionError();
    }

    //Bắt đầu validate form và thêm sản phẩm
    public function postAddSanPham()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $$gia_san_pham = str_replace(',', '', $gia_san_pham);
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
            $gia_khuyen_mai = str_replace(',', '', $gia_khuyen_mai);
            $so_luong = $_POST['so_luong'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $luot_xem = $_POST['luot_xem'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            if ($gia_khuyen_mai === '') {
                $gia_khuyen_mai = null; // hoặc 0
            }

            $hinh_anh = $_FILES['hinh_anh'] ?? null;
            $file_thumb = null;
            // Lấy sản phẩm cũ từ DB để giữ ảnh nếu không thay đổi
            // Kiểm tra có upload ảnh mới không
            if (!empty($hinh_anh['tmp_name'])) {
                $file_thumb = uploadFile($hinh_anh, 'uploads/');
            }

            // mảng hình ảnh
            $img_array = $_FILES['img_array'];

            // validate form add Sản Phẩm
            $error = [];
            if (empty($ten_san_pham)) {
                $error['ten_san_pham'] = 'Tên Sản Phẩm Không Được Để Trống';
            }
            if ($hinh_anh['error'] !== 0) {
                $error['hinh_anh'] = 'Ảnh Sản Phẩm Không Được Để Trống';
            }
            if (empty($gia_san_pham)) {
                $error['gia_san_pham'] = 'Giá Sản Phẩm Không Được Để Trống';
            }
            if (empty($so_luong)) {
                $error['so_luong'] = 'Số Lượng Sản Phẩm Không Được Để Trống';
            }
            if (empty($danh_muc_id)) {
                $error['danh_muc_id'] = 'Danh Muc Sản Phẩm Không Được Để Trống';
            }
            if (empty($trang_thai)) {
                $error['trang_thai'] = 'Trạng Thái Sản Phẩm Không Được Để Trống';
            }
            if (empty($ngay_nhap)) {
                $error['ngay_nhap'] = 'Ngày Nhập Sản Phẩm Không Được Để Trống';
            }
            if (empty($luot_xem)) {
                $error['luot_xem'] = 'Lượt Xem Sản Phẩm Không Được Để Trống';
            }
            $_SESSION['error'] = $error;


            //Nếu Không có lỗi thì tiến hành thêm Sản Phẩm
            if (empty($error)) {
                //Nếu Không có lỗi thì tiến hành thêm Sản Phẩm
                // var_dump("Oke");
                // die();
                $san_pham_id = $this->modelSanPham->insertSanPham($ten_san_pham, $file_thumb, $gia_san_pham, $gia_khuyen_mai, $so_luong, $danh_muc_id, $trang_thai, $luot_xem, $ngay_nhap, $mo_ta);
                //Xử lý thêm album sản phẩm img_array
                if (!empty($img_array['name'])) {
                    foreach ($img_array['name'] as $key => $value) {
                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key]
                        ];

                        $link_hinh_anh = uploadFile($file, './uploads/');
                        $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh);
                    }
                }
                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                // Trả về form vá lỗi
                //  đặt chỉ thị xóa session k=sau khi thi triển
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-san-pham');
                exit();
            }
        }
    }

    //Chuyển đến form edit sản phẩm
    public function formEditSanPham()
    {
        // hàm này dùng để nhập form sản phẩm
        $id = $_GET['id'];
        $SanPham = $this->modelSanPham->getDetailSanPham($id);
        $DanhMuc = $this->modelSanPham->getAllDanhMuc();
        $TrangThai = $this->modelSanPham->getAllTrangThai();
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        if ($SanPham) {
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError();
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
        //Xóa session sau khi load lại trang;

    }

    //Bắt đầu validate form và edit sản phẩm
    public function postEditSanPham()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $id_san_pham = $_POST['id'] ?? '';
            $sanPhamOld = $this->modelSanPham->getDetailSanPham($id_san_pham);
            $old_file = $sanPhamOld['hinh_anh']; //lấy ảnh cũ
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = str_replace(',', '', $_POST['gia_san_pham']) ?? '';
            $gia_khuyen_mai = str_replace(',', '', $_POST['gia_khuyen_mai']) ?? '';
            $gia_khuyen_mai = ($gia_khuyen_mai === '') ? null : $gia_khuyen_mai;
            $so_luong = $_POST['so_luong'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $luot_xem = $_POST['luot_xem'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $hinh_anh = $_FILES['hinh_anh'] ?? null;
            // Lấy sản phẩm cũ từ DB để giữ ảnh nếu không thay đổi

            // validate form Edit Sản Phẩm
            $error = [];
            if (empty($ten_san_pham)) {
                $error['ten_san_pham'] = 'Tên Sản Phẩm Không Được Để Trống';
            }
            // if($hinh_anh['error'] !== 0 ){
            //     $error['hinh_anh']= 'Ảnh Sản Phẩm Không Được Để Trống';
            // }
            if (empty($gia_san_pham)) {
                $error['gia_san_pham'] = 'Giá Sản Phẩm Không Được Để Trống';
            }
            // if(empty($gia_khuyen_mai)){
            //     $error['gia_khuyen_mai']= 'Giá Khuyen Mai Không Được Để Trống';
            // }
            if (empty($so_luong)) {
                $error['so_luong'] = 'Số Lượng Sản Phẩm Không Được Để Trống';
            }

            if (empty($danh_muc_id)) {
                $error['danh_muc_id'] = 'Danh Muc Sản Phẩm Không Được Để Trống';
            }

            if (empty($ngay_nhap)) {
                $error['ngay_nhap'] = 'Ngày Nhập Sản Phẩm Không Được Để Trống';
            }

            if (empty($luot_xem)) {
                $error['luot_xem'] = 'Lượt Xem Sản Phẩm Không Được Để Trống';
            }
            $_SESSION['error'] = $error;
            //Nếu Không có lỗi thì tiến hành thêm Sản Phẩm
            if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
                //upload file ảnh mới lên
                $new_file = uploadfile($hinh_anh, 'uploads/');
            }
            if (!empty($new_file)) {
                deleteFile($old_file);
            } else {
                $new_file = $old_file;
            }

            if (empty($error)) {
                //Nếu Không có lỗi thì tiến hành thêm Sản Phẩm
                // var_dump("Oke");
                // die();
                // $san_pham_id =
                $this->modelSanPham->updateSanPham(
                    $id_san_pham,
                    $ten_san_pham,
                    $new_file,
                    $gia_san_pham,
                    $gia_khuyen_mai,
                    $so_luong,
                    $danh_muc_id,
                    $trang_thai,
                    $luot_xem,
                    $ngay_nhap,
                    $mo_ta
                );
                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                // Trả về form vá lỗi
                //  đặt chỉ thị xóa session k=sau khi thi triển
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id=' . $id_san_pham);
                exit();
            }
        }
    }

    //Xóa sản phẩm
    public function deleteSanPham()
    {
        // hàm này dùng để xóa Sản Phẩm
        $id = $_GET['id'];
        $SanPham = $this->modelSanPham->getDetailSanPham($id);
        $msg = 'fail';

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        if ($SanPham) {
            deleteFile($SanPham['hinh_anh']);
            $this->modelSanPham->destroySanPham($id);
            $msg = 'success';
        }
        if ($listAnhSanPham) {
            foreach ($listAnhSanPham as $key => $anhSP) {
                deleteFile($anhSP['link_hinh_anh']);
                $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
            }
        }

        header("Location:" . BASE_URL_ADMIN . '?act=san-pham&msg=' . $msg);
        exit();
    }

    public function postEditAnhSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $san_pham_id = $_POST['san_pham_id'] ?? '';

            //Lấy danh sách ảnh hiện tai cua san php_uname
            $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);

            //xử lý ảnh sản phẩm
            $img_array = $_FILES['img_array'];
            $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
            $current_img_ids = $_POST['current_img_ids'] ?? [];

            // Khai báo mảng để lưu ảnh thêm mới hoặc thay thế ảnh cũ
            $upload_file = [];

            foreach ($img_array['name'] as $key => $value) {

                if ($img_array['error'][$key] == UPLOAD_ERR_OK) {
                    $new_file = uploadFileAlbum($img_array, './uploads/', $key);
                    if ($new_file) {
                        $upload_file[] = [
                            'id' => $current_img_ids[$key] ?? null,
                            'file' => $new_file
                        ];
                    }
                }
            }

            //Lưu ảnh mới vào và xóa ảnh cũ
            foreach ($upload_file as $file_infor) {
                if ($file_infor['id']) {
                    $old_file = $this->modelSanPham->getDetailAnhSanPham($file_infor['id'])['link_hinh_anh'];
                    var_dump($old_file);
                    die();

                    // Cap nhat anh curl_close
                    $this->modelSanPham->updateAnhSanPham($file_infor['id'], $file_infor['file']);
                    //xoa anh cu
                    deleteFile($old_file);
                } else {
                    //thêm ảnh mới
                    $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $file_infor['file']);
                }
            }

            //Xử lý ảnh
            foreach ($listAnhSanPhamCurrent as $anhSP) {
                $anh_id = $anhSP['id'];
                if (in_array($anh_id, $img_delete)) {
                    //xoa anh 
                    $this->modelSanPham->destroyAnhSanPham($anh_id);

                    //Xoa file
                    deleteFile($anhSP['link_hinh_anh']);
                }
            }
            header("Location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id=' . $san_pham_id);
            exit();
        }
    }

    public function detailSanPham()
    {
        // hàm này dùng để nhập form sản phẩm
        $id = $_GET['id'];
        $SanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
        if ($SanPham) {
            require_once './views/sanpham/detailSanPham.php';
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
        //Xóa session sau khi load lại trang;

    }
    public function updateTrangThaiBinhLuan()
    {
        $id_binh_luan = $_POST['id_binh_luan'];
        $name_view = $_POST['name_view'];
        $binh_luan = $this->modelSanPham->getDetailBinhLuan($id_binh_luan);
        if ($binh_luan) {
            $trang_thai_update = '';
            if ($binh_luan['trang_thai'] == 1) {
                $trang_thai_update = 2;
            } else {
                $trang_thai_update = 1;
            }
            $status = $this->modelSanPham->updateTrangThaiBinhLuan($id_binh_luan, $trang_thai_update);
            if ($status) {
                if ($name_view == 'detail_khach') {
                    header("Location:" . BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $binh_luan['tai_khoan_id']);
                } else {
                    header("Location:" . BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id=' . $binh_luan['san_pham_id']);
                }
            }
        }
    }
}
