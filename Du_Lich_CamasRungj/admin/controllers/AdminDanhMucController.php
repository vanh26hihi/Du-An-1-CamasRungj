<?php
require_once 'models/AdminDanhMuc.php';
class AdminDanhMucController {
    private $model;
    private function __contruct(){
        $this->model = new AdminDanhMuc(); //gọi model
    }

    //hiển thị danh mục
    private function listDanhMuc() {
    $danhmuc = $this->models->getAll();
    require 'views/danhmuc/listDanhMuc.php';
    }
    // thêm danh mục 
    private function formAddDanhMuc(){
        require 'views/danhmuc/addDanhMuc.php';
    }
    // xử lí thêm danh mục
    private function postAddDanhMuc() {
        $ten = $_POST['ten'];
        $trang_thai = $_POST['trang_thai'];
        $this->model->insert($ten, $trang_thai);
        header('Location: ?act=danh-muc-tour');
        exit;
            
        
    }
    // sửa danh mục
    private function formEditDanhMuc($id) {
        $id = $_GET['id'];
        $danhmuc = $this->model->getById($id);
        require 'views/danhmuc/editDanhMuc.php';
    }
    //xử lí sửa danh mục
    private function postEditDanhMuc($id) {
        $id = $_POST['id'];
        $ten = $_POST['ten'];
        $trang_thai = $_POST['trang_thai'];
        $this->model->$update($id, $ten, $trang_thai);
                header('Location: ?act=danh-muc-tour');
                exit;

        
    }
    private function deleteDanhMuc($id) {
        $id = $_GET['id'];
        $this->model->delete($id);
                header('Location: ?act=danh-muc-tour');
                exit;

    }
    }
?>
