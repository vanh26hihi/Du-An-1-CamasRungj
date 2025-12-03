<?php
require_once './commons/function.php';
require_once './models/HDVModel.php';
require_once './models/DiemDanhModel.php';
require_once './models/NhatKyTourModel.php';

class HDVLichLamViecController {

    // Helper: Lấy thông tin lịch khởi hành
    private function getLichInfo($lich_id) {
        $sql = "SELECT lkh.*, t.ten as ten_tour, t.mo_ta, t.hinh_anh,
                       t.gia_co_ban, t.so_ngay, t.diem_khoi_hanh, t.diem_ket_thuc
                FROM lich_khoi_hanh lkh
                JOIN tour t ON t.tour_id = lkh.tour_id
                WHERE lkh.lich_id = ?";
        return db_query($sql, [$lich_id])->fetch();
    }

    // Trang lịch làm việc của HDV (home page)
    public function danhSachLichLamViec() {
        $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
        
        // Lấy hdv_id từ nguoi_dung_id
        $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
        
        if ($hdvInfo) {
            // Lấy lịch làm việc từ bảng phan_cong_hdv
            $lichLamViec = HDVModel::getLichLamViecByHDV($hdvInfo['hdv_id']);
        } else {
            $lichLamViec = [];
        }
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/lich-lam-viec-home.php';
        require_once './views/layout/footer.php';
    }

    // Danh sách khách hàng trong tour
    public function danhSachKhach() {
        $lich_id = $_GET['lich_id'] ?? null;
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        $lichInfo = $this->getLichInfo($lich_id);
        $data = HDVModel::getPassengersByLich($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/danh-sach-khach.php';
        require_once './views/layout/footer.php';
    }

    // Trang điểm danh
    public function diemDanh() {
        $lich_id = $_GET['lich_id'] ?? null;
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        $lichInfo = $this->getLichInfo($lich_id);
        $danhSachDiemDanh = DiemDanhModel::getCustomersForAttendance($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/diem-danh.php';
        require_once './views/layout/footer.php';
    }

    // Xử lý điểm danh
    public function xuLyDiemDanh() {
        $hanh_khach_id = null;
        $lich_id = null;
        
        // Hỗ trợ cả GET và POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hanh_khach_id = $_POST['hanh_khach_id'] ?? null;
            $lich_id = $_POST['lich_id'] ?? null;
        } else {
            $hanh_khach_id = $_GET['hanh_khach_id'] ?? null;
            $lich_id = $_GET['lich_id'] ?? null;
        }
        
        $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
        
        if ($hanh_khach_id && $lich_id && $nguoi_dung_id) {
            // Lấy hdv_id từ nguoi_dung_id
            $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
            if ($hdvInfo) {
                $result = DiemDanhModel::toggleAttendance($hanh_khach_id, $lich_id, $hdvInfo['hdv_id']);
                if ($result) {
                    $_SESSION['success'] = "Cập nhật điểm danh thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi khi cập nhật điểm danh!";
                }
            } else {
                $_SESSION['error'] = "Không tìm thấy thông tin hướng dẫn viên!";
            }
        } else {
            $_SESSION['error'] = "Thông tin không hợp lệ!";
        }
        header('Location: ?act=hdv-diem-danh&lich_id=' . $lich_id);
        exit();
    }

    // Trang nhật ký tour
    public function nhatKyTour() {
        $lich_id = $_GET['lich_id'] ?? null;
        
        if (!$lich_id) {
            header('Location: ?act=hdv-lich-lam-viec');
            exit();
        }
        
        $lichInfo = $this->getLichInfo($lich_id);
        $nhatKyList = NhatKyTourModel::getByLich($lich_id);
        
        require_once './views/layout/header.php';
        require_once './views/layout/navbar.php';
        require_once './views/layout/sidebar.php';
        require_once './views/lich-lam-viec/nhat-ky-tour.php';
        require_once './views/layout/footer.php';
    }

    // Thêm nhật ký tour
    public function themNhatKyTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lich_id = $_POST['lich_id'] ?? null;
            $noi_dung = $_POST['noi_dung'] ?? '';
            $ngay_ghi = $_POST['ngay_ghi'] ?? date('Y-m-d');
            $nguoi_dung_id = $_SESSION['user_admin']['nguoi_dung_id'] ?? null;
            
            // Lấy hdv_id từ nguoi_dung_id
            $hdvInfo = HDVModel::getHDVByNguoiDungId($nguoi_dung_id);
            
            if ($hdvInfo && $lich_id && $noi_dung) {
                $data = [
                    ':lich_id' => $lich_id,
                    ':hdv_id' => $hdvInfo['hdv_id'],
                    ':noi_dung' => $noi_dung,
                    ':ngay_ghi' => $ngay_ghi
                ];
                NhatKyTourModel::insert($data);
                
                $_SESSION['success'] = "Thêm nhật ký tour thành công!";
            } else {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            }
            
            header('Location: ?act=hdv-nhat-ky-tour&lich_id=' . $lich_id);
            exit();
        }
    }
}
