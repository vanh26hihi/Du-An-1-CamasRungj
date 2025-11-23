<?php
require_once 'models/AdminDanhMuc.php';
class AdminDanhMucController {
    public $model;
    public function __construct(){
        $this->model = new AdminDanhMuc(); //gọi model
    }

    //hiển thị danh mục
    public function listDanhMuc() {
    $listDanhMuc = $this->model->getAll();
    require 'views/danhmuc/listDanhMuc.php';
    }
    // thêm danh mục 
    public function formAddDanhMuc(){
        require 'views/danhmuc/addDanhMuc.php';
    }
    // xử lí thêm danh mục

    public function postAddDanhMuc() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ten = $_POST['ten'];
        $trang_thai = $_POST['trang_thai'];
        $mo_ta = $_POST['mo_ta'];
        $ngay_tao = date('Y-m-d H:i:s');
            if($ten == ''){
                $error = "Tên danh mục không được để trống";
                include 'views/danhmuc/addDanhMuc.php';
                return;
            }

            $this->model->insertDanhMuc($ten,$mo_ta,$trang_thai);

        header('Location: ?act=danh-muc-tour');
        exit;
            
       } 
    }
    // sửa danh mục
    public function formEditDanhMuc() {
        $id = $_GET['id'];
        $danhmuc = $this->model->getById($id);
        require 'views/danhmuc/editDanhMuc.php';
    }
    //xử lí sửa danh mục
   
    public function postEditDanhMuc($id) {
         if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST['id'];
        $ten = $_POST['ten'];
        $mo_ta = $_POST['mo_ta'];
        $trang_thai = $_POST['trang_thai'];
        $ngay_tao = date('Y-m-d H:i:s');
            // kiểm tra
            if($ten == ""){
                $_SESSION['error'] = "Tên danh mục không được để trống";
                header("Location: ?act=form-sua-danh-muc&id=". $id);
                exit;

            }

            // gọi model cập nhật
            $this->model->updateDanhMuc($id, $ten,$mo_ta, $trang_thai,$ngay_tao);
            $_SESSION['success'] = "Cập nhật thành công";
            header("Location: ?act=danh-muc-tour");
            exit;

        }
    }
    
    public function deleteDanhMuc()
    {
        // hàm này dùng để xóa danh mục
        $id = $_GET['id'];
            $this->model->destroyDanhMuc($id);
        header("Location:" . BASE_URL_ADMIN . '?act=danh-muc-tour');
        exit();
    }
    }
?>