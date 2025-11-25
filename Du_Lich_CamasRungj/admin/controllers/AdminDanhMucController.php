<?php
require_once 'models/AdminDanhMuc.php';
class AdminDanhMucController
{
    public $model;
    public function __construct()
    {
        $this->model = new AdminDanhMuc(); //gọi model
    }

    //hiển thị danh mục
    public function listDanhMuc()
    {
        // Lấy danh sách tour kèm thông tin danh mục để hiển thị
        $listDanhMuc = $this->model->getToursWithCategory();
        require 'views/danhmuc/listDanhMuc.php';
    }
    // thêm danh mục 
    public function formAddDanhMuc()
    {
        $danhmuc = $this->model->getDanhMuc();
        $diaDiemTour = $this->model->getDiaDiemTour();
        $error = $_SESSION['error'] ?? [];
        $old = $_SESSION['old'] ?? [];
        require 'views/danhmuc/addDanhMuc.php';
        deleteSessionError();
    }
    // xử lí thêm danh mục

    public function postAddDanhMuc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $gia_co_ban = $_POST['gia_co_ban'] ?? '';
            $thoi_luong_mac_dinh = $_POST['thoi_luong_mac_dinh'] ?? '';
            $chinh_sach = $_POST['chinh_sach'] ?? '';
            $diem_khoi_hanh = $_POST['diem_khoi_hanh'] ?? '';
            $mo_ta_ngan = $_POST['mo_ta_ngan'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';
            $dia_diem_id = $_POST['dia_diem_id'] ?? [];
            $thu_tu = $_POST['thu_tu'] ?? [];
            $ghi_chu = $_POST['ghi_chu'] ?? [];

            // Validate Tab 1
            $error = [];
            if (empty($ten)) {
                $error['ten'] = "Tên danh mục không được để trống";
            }
            if (empty($danh_muc_id)) {
                $error['danh_muc_id'] = "Vui lòng chọn loại tour";
            }
            if (empty($gia_co_ban)) {
                $error['gia_co_ban'] = "Giá cơ bản không được để trống";
            }
            if (empty($thoi_luong_mac_dinh)) {
                $error['thoi_luong_mac_dinh'] = "Số ngày du lịch không được để trống";
            }
            if (empty($chinh_sach)) {
                $error['chinh_sach'] = "Chính sách không được để trống";
            }
            if (empty($diem_khoi_hanh)) {
                $error['diem_khoi_hanh'] = "Điểm khởi hành không được để trống";
            }
            if (empty($mo_ta_ngan)) {
                $error['mo_ta_ngan'] = "Mô tả ngắn không được để trống";
            }
            if (empty($mo_ta)) {
                $error['mo_ta'] = "Mô tả không được để trống";
            }

            // Validate Tab 2
            if (empty($dia_diem_id) || count(array_filter($dia_diem_id)) === 0) {
                $error['dia_diem'] = "Vui lòng chọn ít nhất 1 địa điểm";
            } else {
                foreach ($dia_diem_id as $idx => $dd_id) {
                    if (empty($dd_id)) {
                        $error['dia_diem_' . $idx] = "Địa điểm " . ($idx + 1) . " chưa được chọn";
                    }
                }
            }

            // Nếu có lỗi, lưu session và redirect
            if (!empty($error)) {
                $_SESSION['flash'] = true;
                $_SESSION['error'] = $error;
                $_SESSION['old'] = [
                    'ten' => $ten,
                    'danh_muc_id' => $danh_muc_id,
                    'gia_co_ban' => $gia_co_ban,
                    'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
                    'chinh_sach' => $chinh_sach,
                    'diem_khoi_hanh' => $diem_khoi_hanh,
                    'mo_ta_ngan' => $mo_ta_ngan,
                    'mo_ta' => $mo_ta,
                    'dia_diem' => array_map(function ($id, $tt, $gc) {
                        return ['dia_diem_id' => $id, 'thu_tu' => $tt, 'ghi_chu' => $gc];
                    }, $dia_diem_id, $thu_tu, $ghi_chu)
                ];
                header('Location: ' . BASE_URL_ADMIN . '?act=form-them-danh-muc');
                exit;
            }

            // Insert tour vào bảng tour
            $tourData = [
                'ten' => $ten,
                'danh_muc_id' => $danh_muc_id,
                'mo_ta_ngan' => $mo_ta_ngan,
                'mo_ta' => $mo_ta,
                'gia_co_ban' => $gia_co_ban,
                'thoi_luong_mac_dinh' => $thoi_luong_mac_dinh,
                'chinh_sach' => $chinh_sach,
                'diem_khoi_hanh' => $diem_khoi_hanh
            ];
            $tourId = $this->model->insertTour($tourData);

            // Insert địa điểm cho tour
            if ($tourId) {
                foreach ($dia_diem_id as $idx => $dd_id) {
                    if (!empty($dd_id)) {
                        $this->model->insertDiaDiemTour([
                            'tour_id' => $tourId,
                            'dia_diem_id' => $dd_id,
                            'thu_tu' => $thu_tu[$idx] ?? ($idx + 1),
                            'ghi_chu' => $ghi_chu[$idx] ?? ''
                        ]);
                    }
                }

                unset($_SESSION['error']);
                unset($_SESSION['old']);
                unset($_SESSION['flash']);

                header('Location: ?act=danh-muc-tour');
                exit;
            }
        }
    }
    // sửa danh mục
    public function formEditDanhMuc()
    {
        $id = $_GET['id'] ?? null;
        $error = $_SESSION['error'] ?? [];
        $old = $_SESSION['old'] ?? [];

        // Nếu tồn tại tour với id này, hiển thị form chỉnh sửa tour (giống add nhưng đổ sẵn dữ liệu)
        $tour = $this->model->getTourById($id);
        if ($tour) {
            $danhmuc = $this->model->getDanhMuc(); // danh sách loại tour để select
            $diaDiemTour = $this->model->getDiaDiemTour(); // danh sách dia_diem để chọn
            $tourDiaDiem = $this->model->getDiaDiemTourByTour($id); // các địa điểm đã gắn với tour
            require 'views/danhmuc/editDanhMuc.php';
            deleteSessionError();
            return;
        }

        // Nếu không phải là tour (giữ hành vi cũ: chỉnh sửa bản ghi danh_muc)
        $danhmuc = $this->model->getDanhMucID($id);
        require 'views/danhmuc/editDanhMuc.php';
    }
    //xử lí sửa danh mục

    public function postEditDanhMuc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['id'];
            $ten = $_POST['ten'];
            $mo_ta = $_POST['mo_ta'];
            $trang_thai = $_POST['trang_thai'];
            $ngay_tao = date('Y-m-d H:i:s');
            // kiểm tra
            if ($ten == "") {
                $_SESSION['error'] = "Tên danh mục không được để trống";
                header("Location: ?act=form-sua-danh-muc&id=" . $id);
                exit;
            }

            // gọi model cập nhật
            $this->model->updateDanhMuc($id, $ten, $mo_ta, $trang_thai, $ngay_tao);
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
