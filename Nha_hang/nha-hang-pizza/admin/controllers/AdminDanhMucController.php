<?php
class AdminDanhMucController
{
    public $modelDanhMuc;
    public function __construct()
    {
        $this->modelDanhMuc = new AdminDanhMuc();
    }
    public function AdminHome()
    {
        header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
    }

    public function danhSachDanhMuc()
    {
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once './views/danhmuc/listDanhMuc.php';
    }

    public function formAddDanhMuc()
    {
        // hàm này dùng để nhập form sản phẩm
        require_once './views/danhmuc/addDanhMuc.php';
    }

    public function postAddDanhMuc()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];
            $error = [];
            if (empty($ten_danh_muc)) {
                $error['ten_danh_muc'] = 'Tên Danh Mục Không Được Để Trống';
            }

            $_SESSION['error'] = $error;
            //Nếu Không có lỗi thì tiến hành thêm danh mục
            if (empty($error)) {
                $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
            } else {
                $_SESSION['flash'] = true;
                // Trả về form vá lỗi
                header("Location:" . BASE_URL_ADMIN . '?act=form-them-danh-muc');
                exit();
            }
        }
    }
    public function formEditDanhMuc()
    {
        // hàm này dùng để nhập form sản phẩm
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc) {
            require_once './views/danhmuc/editDanhMuc.php';
            deleteSessionError();
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
            exit();
        }
    }

    public function postEditDanhMuc()
    {
        // hàm này dùng để thêm dữ liệu từ form
        // Kiểm tra xem dữ liệu có phải submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lấy dữ liệu
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];
            $id = $_POST['id'];
            $error = [];
            if (empty($ten_danh_muc)) {
                $error['ten_danh_muc'] = 'Tên Danh Mục Không Được Để Trống';
            }
            //Nếu Không có lỗi thì tiến hành sửa danh mục
            if (empty($error)) {
                //Nếu Không có lỗi thì tiến hành sửa danh mục
                // var_dump("Oke");

                $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
                header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
            } else {
                // Trả về form vá lỗi
                $danhMuc = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
                require_once './views/danhmuc/editDanhMuc.php';
            }
        }
    }
    public function deleteDanhMuc()
    {
        // hàm này dùng để xóa danh mục
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        $msg = 'fail';
        if ($danhMuc) {
            $this->modelDanhMuc->destroyDanhMuc($id);
            $msg = 'success';
        }
        header("Location:" . BASE_URL_ADMIN . '?act=danh-muc&msg=' . $msg);
        exit();
    }
}
