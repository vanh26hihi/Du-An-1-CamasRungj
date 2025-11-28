<?php
require_once '../commons/env.php';

class HDVModel {

    // Lấy danh sách tour HDV được phân công
    public static function getToursByHDV($hdv_id) {
        $sql = "SELECT phan_cong_hdv.phan_cong_id, tour.tour_id, tour.ten ten_tour, 
                       lich_khoi_hanh.lich_id, lich_khoi_hanh.ngay_bat_dau, lich_khoi_hanh.ngay_ket_thuc, lich_khoi_hanh.trang_thai_id,
                       phan_cong_hdv.hdv_id, huong_dan_vien.ho_ten hdv_ten
                FROM phan_cong_hdv
                JOIN lich_khoi_hanh ON phan_cong_hdv.lich_id = lich_khoi_hanh.lich_id
                JOIN tour ON lich_khoi_hanh.tour_id = tour.tour_id
                JOIN huong_dan_vien ON phan_cong_hdv.hdv_id = huong_dan_vien.hdv_id
                WHERE phan_cong_hdv.hdv_id = ?
                ORDER BY tour.ten, lich_khoi_hanh.ngay_bat_dau";
        return db_query($sql, [$hdv_id])->fetchAll();
    }
    
    // Lấy danh sách HDV được phân công cho một lịch cụ thể
    public static function getHDVByLich($lich_id) {
        $sql = "SELECT phan_cong_hdv.hdv_id, huong_dan_vien.ho_ten, huong_dan_vien.so_dien_thoai, huong_dan_vien.email, phan_cong_hdv.vai_tro
                FROM phan_cong_hdv
                JOIN huong_dan_vien ON phan_cong_hdv.hdv_id = huong_dan_vien.hdv_id
                WHERE phan_cong_hdv.lich_id = ?
                ORDER BY phan_cong_hdv.vai_tro DESC, huong_dan_vien.ho_ten";
        return db_query($sql, [$lich_id])->fetchAll();
    }

    // Lấy tất cả tour trong DB và nhóm theo tên, hiển thị TẤT CẢ lịch của mỗi tour
    public static function getToursByHDVGrouped($hdv_id = null, $search_hdv_name = null) {
        // Lấy tất cả tour trong DB
        $sqlAllTours = "SELECT tour.tour_id, tour.ten ten_tour
                        FROM tour
                        ORDER BY tour.ten";
        $allTours = db_query($sqlAllTours)->fetchAll();
        
        // Lấy TẤT CẢ lịch khởi hành của tất cả tour (không chỉ lịch được phân công)
        $sqlAllSchedules = "SELECT lich_khoi_hanh.lich_id, lich_khoi_hanh.tour_id, lich_khoi_hanh.ngay_bat_dau, lich_khoi_hanh.ngay_ket_thuc, lich_khoi_hanh.trang_thai_id,
                                   tour.ten ten_tour
                            FROM lich_khoi_hanh
                            JOIN tour ON lich_khoi_hanh.tour_id = tour.tour_id
                            ORDER BY tour.ten, lich_khoi_hanh.ngay_bat_dau";
        $allSchedules = db_query($sqlAllSchedules)->fetchAll();
        
        // Lấy thông tin phân công HDV cho các lịch (để hiển thị HDV được phân công)
        $sqlPhanCong = "SELECT phan_cong_hdv.lich_id, phan_cong_hdv.hdv_id, huong_dan_vien.ho_ten hdv_ten, phan_cong_hdv.vai_tro
                        FROM phan_cong_hdv
                        JOIN huong_dan_vien ON phan_cong_hdv.hdv_id = huong_dan_vien.hdv_id";
        
        $paramsPhanCong = [];
        if (!empty($search_hdv_name)) {
            $sqlPhanCong .= " WHERE huong_dan_vien.ho_ten LIKE ?";
            $paramsPhanCong[] = '%' . $search_hdv_name . '%';
        }
        
        $phanCongData = !empty($paramsPhanCong) 
            ? db_query($sqlPhanCong, $paramsPhanCong)->fetchAll() 
            : db_query($sqlPhanCong)->fetchAll();
        
        // Tạo map phân công theo lich_id
        $phanCongByLich = [];
        foreach ($phanCongData as $pc) {
            $lichId = $pc['lich_id'];
            if (!isset($phanCongByLich[$lichId])) {
                $phanCongByLich[$lichId] = [];
            }
            $phanCongByLich[$lichId][] = $pc;
        }
        
        // Nhóm lịch theo tour_id - LUÔN lấy TẤT CẢ lịch (không lọc theo HDV)
        $schedulesByTour = [];
        foreach ($allSchedules as $schedule) {
            $tourId = $schedule['tour_id'];
            if (!isset($schedulesByTour[$tourId])) {
                $schedulesByTour[$tourId] = [];
            }
            
            // Thêm thông tin HDV được phân công cho lịch này (nếu có)
            $lichId = $schedule['lich_id'];
            $schedule['hdv_list'] = $phanCongByLich[$lichId] ?? [];
            
            // LUÔN thêm lịch vào danh sách (không lọc theo HDV)
            $schedulesByTour[$tourId][] = $schedule;
        }
        
        // Nhóm tất cả tour theo tour_id (hiển thị tất cả tour, kể cả không có lịch)
        $grouped = [];
        foreach ($allTours as $tour) {
            $ten_tour = $tour['ten_tour'];
            $tourId = $tour['tour_id'];
            
            // Sử dụng tour_id làm key để đảm bảo mỗi tour được hiển thị riêng
            $tourKey = $tourId;
            
            if (!isset($grouped[$tourKey])) {
                $grouped[$tourKey] = [
                    'tour_id' => $tourId,
                    'ten_tour' => $ten_tour,
                    'schedules' => []
                ];
            }
            
            // Thêm tất cả lịch của tour này
            if (isset($schedulesByTour[$tourId]) && !empty($schedulesByTour[$tourId])) {
                foreach ($schedulesByTour[$tourId] as $schedule) {
                    $grouped[$tourKey]['schedules'][] = $schedule;
                }
            }
            // Nếu tour không có lịch, vẫn giữ trong danh sách (mảng schedules rỗng)
        }
        
        // Sắp xếp theo số lượng lịch giảm dần (tour có nhiều lịch nhất lên đầu)
        uasort($grouped, function($a, $b) {
            $countA = count($a['schedules']);
            $countB = count($b['schedules']);
            if ($countA == $countB) {
                return 0;
            }
            return ($countA > $countB) ? -1 : 1;
        });
        
        return $grouped;
    }

    // Lấy danh sách hành khách của 1 lịch cụ thể
    public static function getPassengersByLich($lich_id) {
        if (empty($lich_id)) {
            // Nếu không truyền lich_id, trả về toàn bộ hành khách
            $sql = "SELECT hanh_khach_list.ho_ten, hanh_khach_list.cccd, hanh_khach_list.so_dien_thoai, hanh_khach_list.ghi_chu
                FROM hanh_khach_list
                ORDER BY hanh_khach_list.ho_ten";
            return db_query($sql)->fetchAll();
        }

        $sql = "SELECT hanh_khach_list.ho_ten, hanh_khach_list.cccd, hanh_khach_list.so_dien_thoai, hanh_khach_list.ghi_chu
            FROM dat_tour
            JOIN hanh_khach_list ON hanh_khach_list.dat_tour_id = dat_tour.dat_tour_id
            WHERE dat_tour.lich_id = ?";
        return db_query($sql, [$lich_id])->fetchAll();
    }

    //Lấy lịch trình chi tiết của tour
    public static function getItinerary($tour_id) {
        $sql = "SELECT lich_trinh_id, ngay_thu, tieu_de, noi_dung 
                FROM lich_trinh WHERE tour_id = ? ORDER BY ngay_thu ASC";
        return db_query($sql, [$tour_id])->fetchAll();
    }


    // Lấy danh sách địa điểm
    public static function getAllDiaDiem() {
        $sql = "SELECT dia_diem_id, ten 
                FROM dia_diem 
                ORDER BY ten";
        return db_query($sql)->fetchAll();
    }

    // Lấy thông tin HDV theo ID
    public static function getHDVById($hdv_id) {
        $sql = "SELECT hdv_id, ho_ten, so_dien_thoai, email, kinh_nghiem, ngon_ngu 
                FROM huong_dan_vien 
                WHERE hdv_id = ?";
        return db_query($sql, [$hdv_id])->fetch();
    }

    // Lấy danh sách tất cả HDV
    public static function getAllHDV() {
        $sql = "SELECT hdv_id, ho_ten, so_dien_thoai, email 
                FROM huong_dan_vien 
                ORDER BY ho_ten";
        return db_query($sql)->fetchAll();
    }

    // Lấy lịch làm việc của HDV từ bảng phan_cong_hdv
    public static function getLichLamViecByHDV($hdv_id) {
        $sql = "SELECT phan_cong_hdv.phan_cong_id, phan_cong_hdv.lich_id, phan_cong_hdv.vai_tro,
                       lich_khoi_hanh.ngay_bat_dau, lich_khoi_hanh.ngay_ket_thuc, lich_khoi_hanh.trang_thai_id,
                       tour.tour_id, tour.ten ten_tour
                FROM phan_cong_hdv
                JOIN lich_khoi_hanh ON phan_cong_hdv.lich_id = lich_khoi_hanh.lich_id
                JOIN tour ON lich_khoi_hanh.tour_id = tour.tour_id
                WHERE phan_cong_hdv.hdv_id = ?
                ORDER BY lich_khoi_hanh.ngay_bat_dau DESC";
        return db_query($sql, [$hdv_id])->fetchAll();
    }

    // Thêm hướng dẫn viên mới
    public static function insertHDV($ho_ten, $so_dien_thoai, $email, $kinh_nghiem, $ngon_ngu) {
        $ngay_tao = date('Y-m-d H:i:s');
        $sql = "INSERT INTO huong_dan_vien (ho_ten, so_dien_thoai, email, kinh_nghiem, ngon_ngu, ngay_tao)
                VALUES (?, ?, ?, ?, ?, ?)";
        return db_query($sql, [$ho_ten, $so_dien_thoai, $email, $kinh_nghiem, $ngon_ngu, $ngay_tao]);
    }

    // Sửa hướng dẫn viên
    public static function updateHDV($hdv_id, $ho_ten, $so_dien_thoai, $email, $kinh_nghiem, $ngon_ngu) {
        $sql = "UPDATE huong_dan_vien 
                SET ho_ten = ?, so_dien_thoai = ?, email = ?, kinh_nghiem = ?, ngon_ngu = ?
                WHERE hdv_id = ?";
        return db_query($sql, [$ho_ten, $so_dien_thoai, $email, $kinh_nghiem, $ngon_ngu, $hdv_id]);
    }

    // Xóa hướng dẫn viên
    public static function deleteHDV($hdv_id) {
        $sql = "DELETE FROM huong_dan_vien WHERE hdv_id = ?";
        return db_query($sql, [$hdv_id]);
    }

}
