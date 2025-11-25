<?php
require_once 'models/QuanLyTourModel.php';

class QuanLyTourController
{
    public $model;

    public function __construct()
    {
        $this->model = new QuanLyTourModel(); // gọi model
    }

    // hiển thị danh sách tour
    public function listTour()
    {
        $listTour = $this->model->getAllTours();
        require 'views/tour/listTour.php';
    }

    // form thêm tour
    public function formAddtour()
    {
        require 'views/tour/addTour.php';
    }

    // xử lý thêm tour
    public function AddTour()
    {
        $data = [
            'ten' => $_POST['ten'],
            'danh_muc_id' => $_POST['danh_muc_id'],
            'mo_ta_ngan' => $_POST['mo_ta_ngan'],
            'mo_ta' => $_POST['mo_ta'],
            'gia_co_ban' => $_POST['gia_co_ban'],
            'hoat_dong' => $_POST['hoat_dong'],
            'thoi_luong_mac_dinh' => $_POST['thoi_luong_mac_dinh'],
            'chinh_sach' => $_POST['chinh_sach'],
            'nguoi_tao_id' => $_POST['nguoi_tao_id'] ?? 1,
            'ngay_tao' => date('Y-m-d H:i:s'),
            'diem_khoi_hanh' => $_POST['diem_khoi_hanh']
        ];
        $this->model->addTour($data);
        header('Location: ?act=danh-sach-tour');
        exit;
    }

    // form sửa tour
    public function EditTour()
    {
        $id = $_GET['tour_id'];
        $tour = $this->model->getTour($id);
        require 'views/tour/editTour.php';
    }

    // xử lý sửa tour
    public function postEdittour()
    {
        $id = $_POST['id'];
        $data = [
            'ten' => $_POST['ten'],
            'danh_muc_id' => $_POST['danh_muc_id'],
            'mo_ta_ngan' => $_POST['mo_ta_ngan'],
            'mo_ta' => $_POST['mo_ta'],
            'gia_co_ban' => $_POST['gia_co_ban'],
            'hoat_dong' => $_POST['hoat_dong'],
            'thoi_luong_mac_dinh' => $_POST['thoi_luong_mac_dinh'],
            'chinh_sach' => $_POST['chinh_sach'],
            'diem_khoi_hanh' => $_POST['diem_khoi_hanh']
        ];
        $this->model->updateTour($id, $data);
        header('Location: ?act=danh-sach-tour');
        exit;
    }

    // xóa tour
    public function deleteTour()
    {
        $id = $_GET['tour_id'];
        if ($id) {
            $this->model->deleteTour($id);
        }
        header('Location: ?act=danh-sach-tour');

        exit();
    }
}
