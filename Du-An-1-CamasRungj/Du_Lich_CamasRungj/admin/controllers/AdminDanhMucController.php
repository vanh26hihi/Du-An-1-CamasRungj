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
        $ten = $_POST['ten'];
        $trang_thai = $_POST['trang_thai'];
        $this->model->insert($ten, $trang_thai);
        header('Location: ?act=danh-muc-tour');
        exit;
            
        
    }
    // sửa danh mục
    public function formEditDanhMuc($id) {
        $id = $_GET['id'];
        $danhmuc = $this->model->getById($id);
        require 'views/danhmuc/editDanhMuc.php';
    }
    //xử lí sửa danh mục
    public function postEditDanhMuc($id) {
        $id = $_POST['id'];
        $ten = $_POST['ten'];
        $trang_thai = $_POST['trang_thai'];
        $this->model->$update($id, $ten, $trang_thai);
                header('Location: ?act=danh-muc-tour');
                exit;

        
    }
    public function deleteDanhMuc()
    {
        // hàm này dùng để xóa danh mục
        $id = $_GET['danh_muc_id'];
            $this->model->destroyDanhMuc($id);
        header("Location:" . BASE_URL_ADMIN . '?act=danh-muc-tour');
        exit();
    }
    }
?>
