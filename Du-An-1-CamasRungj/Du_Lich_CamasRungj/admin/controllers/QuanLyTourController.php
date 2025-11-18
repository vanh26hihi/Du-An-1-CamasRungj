<?php
require_once ".../commons/env.php";       // KẾT NỐI DATABASE
require_once "./models/QuanLyTour.php";    // MODEL

class QuanLyTourController
{
    private $model;
    private $conn;

    public function __construct()
    {
        global $conn;          // LẤY BIẾN $conn TỪ connect.php
        $this->conn = $conn;

        // TRUYỀN ĐÚNG KẾT NỐI VÀO MODEL
        $this->model = new Tour($conn);

        // KIỂM TRA KẾT NỐI (debug nếu cần)
        if ($conn === null) {
            die("Lỗi: Không kết nối được database!");
        }
    }

    public function index()
    {
        $tours = $this->model->getAll();
        include "./views/tour/list.php";
    }

    public function addForm()
    {
        include "./views/tour/addTour.php";
    }

    public function add()
    {
        $data = [
            ":ten" => $_POST['ten'],
            ":danh_muc_id" => $_POST['danh_muc_id'],
            ":mo_ta_ngan" => $_POST['mo_ta_ngan'],
            ":mo_ta" => $_POST['mo_ta'],
            ":gia_co_ban" => $_POST['gia_co_ban'],
            ":thoi_luong_mac_dinh" => $_POST['thoi_luong_mac_dinh'],
            ":chinh_sach" => $_POST['chinh_sach'],
            ":nguoi_tao_id" => $_POST['nguoi_tao_id'],
            ":ngay_tao" => date('Y-m-d'),
            ":diem_khoi_hanh" => $_POST['diem_khoi_hanh'],
            ":hoat_dong" => $_POST['hoat_dong']
        ];

        $this->model->insert($data);
        header("Location: ?act=danh-sach-tour");
        exit();
    }

    public function editForm()
    {
        $id = $_GET['id'];
        $tour = $this->model->getById($id);

        if (!$tour) {
            echo "Tour không tồn tại!";
            exit;
        }

        include "./views/tour/editTour.php";
    }

    public function update()
    {
        $data = [
            ":tour_id" => $_POST['tour_id'],
            ":ten" => $_POST['ten'],
            ":danh_muc_id" => $_POST['danh_muc_id'],
            ":mo_ta_ngan" => $_POST['mo_ta_ngan'],
            ":mo_ta" => $_POST['mo_ta'],
            ":gia_co_ban" => $_POST['gia_co_ban'],
            ":thoi_luong_mac_dinh" => $_POST['thoi_luong_mac_dinh'],
            ":chinh_sach" => $_POST['chinh_sach'],
            ":diem_khoi_hanh" => $_POST['diem_khoi_hanh'],
            ":hoat_dong" => $_POST['hoat_dong']
        ];

        $this->model->update($data);

        header("Location: ?act=danh-sach-tour");
        exit();
    }

    public function delete()
    {
        $id = $_GET['id'];

        $this->model->delete($id);

        header("Location: ?act=danh-sach-tour");
        exit();
    }
}
