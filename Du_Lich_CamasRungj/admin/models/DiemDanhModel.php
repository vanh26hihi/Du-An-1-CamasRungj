<?php
require_once '../commons/env.php';

class DiemDanhModel {

    // Cập nhật điểm danh
    public static function checkIn($data) {
        $sql = "INSERT INTO diem_danh_khach (hanh_khach_id, lich_trinh_id, dia_diem_id, hdv_id, da_den, thoi_gian, ghi_chu)
                VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        db_query($sql, [
            $data['hanh_khach_id'], $data['lich_trinh_id'], $data['dia_diem_id'],
            $data['hdv_id'], $data['da_den'], $data['ghi_chu']
        ]);
    }

    // Lấy danh sách điểm danh theo lịch trình
    public static function getAttendance($lich_trinh_id, $hdv_id) {
        $sql = "SELECT d.*, hk.ho_ten
                FROM diem_danh_khach d
                JOIN hanh_khach_list hk ON hk.hanh_khach_id = d.hanh_khach_id
                WHERE d.lich_trinh_id = ? AND d.hdv_id = ?";
        return db_query($sql, [$lich_trinh_id, $hdv_id])->fetchAll();
    }

    // Lấy danh sách khách hàng trong tour để điểm danh theo lich_id
    public static function getCustomersForAttendance($lich_id) {
        // Lấy tour_id từ lich_id
        $sqlTour = "SELECT tour_id FROM lich_khoi_hanh WHERE lich_id = ?";
        $tour = db_query($sqlTour, [$lich_id])->fetch();
        
        if (!$tour) {
            return [];
        }
        
        // Lấy lich_trinh_id đầu tiên của tour (ngày 1) để điểm danh
        $sqlLichTrinh = "SELECT lich_trinh_id FROM lich_trinh WHERE tour_id = ? ORDER BY ngay_thu LIMIT 1";
        $lichTrinh = db_query($sqlLichTrinh, [$tour['tour_id']])->fetch();
        $lichTrinhId = $lichTrinh ? $lichTrinh['lich_trinh_id'] : null;
        
        // Lấy tất cả khách hàng trong lịch này (từ dat_tour) - đảm bảo lấy đầy đủ
        if ($lichTrinhId) {
            $sql = "SELECT hk.hanh_khach_id, hk.ho_ten, hk.gioi_tinh, hk.cccd, hk.so_dien_thoai, hk.email, hk.ghi_chu,
                           d.diem_danh_id, d.da_den, d.thoi_gian, d.ghi_chu AS ghi_chu_diem_danh
                    FROM dat_tour dt
                    JOIN hanh_khach_list hk ON hk.dat_tour_id = dt.dat_tour_id
                    LEFT JOIN diem_danh_khach d ON d.hanh_khach_id = hk.hanh_khach_id 
                        AND d.lich_trinh_id = ?
                    WHERE dt.lich_id = ?
                    ORDER BY hk.ho_ten";
            return db_query($sql, [$lichTrinhId, $lich_id])->fetchAll();
        } else {
            // Nếu không có lich_trinh, vẫn lấy tất cả khách hàng
            $sql = "SELECT hk.hanh_khach_id, hk.ho_ten, hk.gioi_tinh, hk.cccd, hk.so_dien_thoai, hk.email, hk.ghi_chu,
                           NULL AS diem_danh_id, NULL AS da_den, NULL AS thoi_gian, NULL AS ghi_chu_diem_danh
                    FROM dat_tour dt
                    JOIN hanh_khach_list hk ON hk.dat_tour_id = dt.dat_tour_id
                    WHERE dt.lich_id = ?
                    ORDER BY hk.ho_ten";
            return db_query($sql, [$lich_id])->fetchAll();
        }
    }

    // Điểm danh khách hàng trong chuyến đi (theo lich_id)
    public static function checkInCustomer($hanh_khach_id, $lich_id, $hdv_id, $da_den = 1, $ghi_chu = '') {
        // Lấy tour_id từ lich_id
        $sqlTour = "SELECT tour_id FROM lich_khoi_hanh WHERE lich_id = ?";
        $tour = db_query($sqlTour, [$lich_id])->fetch();
        
        if (!$tour) {
            return false;
        }
        
        // Lấy lich_trinh_id đầu tiên của tour (ngày 1) để điểm danh
        $sqlLichTrinh = "SELECT lich_trinh_id FROM lich_trinh WHERE tour_id = ? ORDER BY ngay_thu LIMIT 1";
        $lichTrinh = db_query($sqlLichTrinh, [$tour['tour_id']])->fetch();
        
        if (!$lichTrinh) {
            return false;
        }
        
        $lichTrinhId = $lichTrinh['lich_trinh_id'];
        
        // Kiểm tra xem đã điểm danh chưa
        $sqlCheck = "SELECT diem_danh_id, da_den FROM diem_danh_khach 
                     WHERE hanh_khach_id = ? AND lich_trinh_id = ?";
        $existing = db_query($sqlCheck, [$hanh_khach_id, $lichTrinhId])->fetch();
        
        if ($existing) {
            // Cập nhật trạng thái (toggle nếu không truyền da_den, hoặc set theo giá trị truyền vào)
            $newStatus = $da_den !== null ? $da_den : (1 - $existing['da_den']);
            $sql = "UPDATE diem_danh_khach 
                    SET da_den = ?, thoi_gian = NOW(), ghi_chu = ?, hdv_id = ?
                    WHERE diem_danh_id = ?";
            return db_query($sql, [$newStatus, $ghi_chu, $hdv_id, $existing['diem_danh_id']]);
        } else {
            // Lấy dia_diem_id từ lich_trinh (nếu có)
            $sqlDiaDiem = "SELECT dia_diem_id FROM dia_diem_lich_trinh 
                          WHERE lich_trinh_id = ? 
                          ORDER BY thu_tu LIMIT 1";
            $diaDiem = db_query($sqlDiaDiem, [$lichTrinhId])->fetch();
            $dia_diem_id = $diaDiem ? $diaDiem['dia_diem_id'] : null;
            
            // Thêm mới - điểm danh theo lich_trinh_id (ngày đầu tiên của tour)
            $sql = "INSERT INTO diem_danh_khach (hanh_khach_id, lich_trinh_id, dia_diem_id, hdv_id, da_den, thoi_gian, ghi_chu)
                    VALUES (?, ?, ?, ?, ?, NOW(), ?)";
            return db_query($sql, [$hanh_khach_id, $lichTrinhId, $dia_diem_id, $hdv_id, $da_den, $ghi_chu]);
        }
    }

    // Chuyển trạng thái điểm danh (toggle)
    public static function toggleAttendance($hanh_khach_id, $lich_id, $hdv_id) {
        // Lấy tour_id từ lich_id
        $sqlTour = "SELECT tour_id FROM lich_khoi_hanh WHERE lich_id = ?";
        $tour = db_query($sqlTour, [$lich_id])->fetch();
        
        if (!$tour) {
            return false;
        }
        
        // Lấy lich_trinh_id đầu tiên của tour (ngày 1)
        $sqlLichTrinh = "SELECT lich_trinh_id FROM lich_trinh WHERE tour_id = ? ORDER BY ngay_thu LIMIT 1";
        $lichTrinh = db_query($sqlLichTrinh, [$tour['tour_id']])->fetch();
        
        if (!$lichTrinh) {
            return false;
        }
        
        $lichTrinhId = $lichTrinh['lich_trinh_id'];
        
        // Kiểm tra trạng thái hiện tại
        $sqlCheck = "SELECT diem_danh_id, da_den FROM diem_danh_khach 
                     WHERE hanh_khach_id = ? AND lich_trinh_id = ?";
        $existing = db_query($sqlCheck, [$hanh_khach_id, $lichTrinhId])->fetch();
        
        if ($existing) {
            // Chuyển trạng thái (toggle)
            $newStatus = 1 - $existing['da_den'];
            $sql = "UPDATE diem_danh_khach 
                    SET da_den = ?, thoi_gian = NOW(), hdv_id = ?
                    WHERE diem_danh_id = ?";
            return db_query($sql, [$newStatus, $hdv_id, $existing['diem_danh_id']]);
        } else {
            // Lấy dia_diem_id từ lich_trinh (nếu có)
            $sqlDiaDiem = "SELECT dia_diem_id FROM dia_diem_lich_trinh 
                          WHERE lich_trinh_id = ? 
                          ORDER BY thu_tu LIMIT 1";
            $diaDiem = db_query($sqlDiaDiem, [$lichTrinhId])->fetch();
            $dia_diem_id = $diaDiem ? $diaDiem['dia_diem_id'] : null;
            
            // Nếu chưa có, tạo mới với trạng thái "Có mặt"
            $sql = "INSERT INTO diem_danh_khach (hanh_khach_id, lich_trinh_id, dia_diem_id, hdv_id, da_den, thoi_gian, ghi_chu)
                    VALUES (?, ?, ?, ?, 1, NOW(), '')";
            return db_query($sql, [$hanh_khach_id, $lichTrinhId, $dia_diem_id, $hdv_id]);
        }
    }

    // ========== CÁC PHƯƠNG THỨC MỚI CHO ĐIỂM DANH THEO TIMELINE ==========
    
    // Lấy tất cả lịch trình của tour theo lich_id
    public static function getTourSchedules($lich_id) {
        $sql = "SELECT lt.*, lkh.ngay_bat_dau, lkh.ngay_ket_thuc
                FROM lich_khoi_hanh lkh
                JOIN lich_trinh lt ON lt.tour_id = lkh.tour_id
                WHERE lkh.lich_id = ?
                ORDER BY lt.ngay_thu, lt.gio_bat_dau";
        return db_query($sql, [$lich_id])->fetchAll();
    }

    // Lấy lịch trình hiện tại dựa trên thời gian thực
    public static function getCurrentSchedule($lich_id) {
        // Lấy ngày bắt đầu tour
        $sqlLich = "SELECT tour_id, ngay_bat_dau, ngay_ket_thuc FROM lich_khoi_hanh WHERE lich_id = ?";
        $lichInfo = db_query($sqlLich, [$lich_id])->fetch();
        
        if (!$lichInfo) {
            return null;
        }
        
        // Tính số ngày từ ngày bắt đầu tour đến hiện tại
        $ngayBatDau = new DateTime($lichInfo['ngay_bat_dau']);
        $ngayHienTai = new DateTime();
        $gioHienTai = $ngayHienTai->format('H:i:s');
        
        // Tính ngày thứ mấy của tour
        $diff = $ngayBatDau->diff($ngayHienTai);
        $ngayThu = $diff->days + 1; // +1 vì ngày đầu là ngày 1
        
        // Nếu chưa đến ngày tour hoặc đã qua ngày tour
        if ($ngayHienTai < $ngayBatDau) {
            $ngayThu = 1; // Chưa bắt đầu, hiển thị ngày 1
        }
        
        // Lấy lịch trình hiện tại dựa vào ngày thứ và giờ hiện tại
        $sql = "SELECT lt.*, 
                       CASE 
                           WHEN ? < lt.gio_bat_dau THEN 'upcoming'
                           WHEN ? BETWEEN lt.gio_bat_dau AND lt.gio_ket_thuc THEN 'current'
                           ELSE 'completed'
                       END AS status
                FROM lich_trinh lt
                WHERE lt.tour_id = ? AND lt.ngay_thu = ?
                ORDER BY lt.gio_bat_dau";
        
        $schedules = db_query($sql, [$gioHienTai, $gioHienTai, $lichInfo['tour_id'], $ngayThu])->fetchAll();
        
        // Tìm lịch trình đang diễn ra hoặc sắp tới
        foreach ($schedules as $schedule) {
            if ($schedule['status'] === 'current') {
                return $schedule; // Trả về lịch trình đang diễn ra
            }
        }
        
        // Nếu không có lịch trình đang diễn ra, trả về lịch trình sắp tới
        foreach ($schedules as $schedule) {
            if ($schedule['status'] === 'upcoming') {
                return $schedule;
            }
        }
        
        // Nếu tất cả đã hoàn thành trong ngày, trả về lịch trình cuối cùng
        if (!empty($schedules)) {
            return end($schedules);
        }
        
        return null;
    }

    // Lấy danh sách khách hàng để điểm danh theo lich_trinh_id cụ thể
    public static function getCustomersForSchedule($lich_id, $lich_trinh_id) {
        $sql = "SELECT hk.hanh_khach_id, hk.ho_ten, hk.gioi_tinh, hk.cccd, hk.so_dien_thoai, hk.email, hk.ghi_chu,
                       d.diem_danh_id, d.da_den, d.thoi_gian, d.ghi_chu AS ghi_chu_diem_danh
                FROM dat_tour dt
                JOIN hanh_khach_list hk ON hk.dat_tour_id = dt.dat_tour_id
                LEFT JOIN diem_danh_khach d ON d.hanh_khach_id = hk.hanh_khach_id 
                    AND d.lich_trinh_id = ?
                WHERE dt.lich_id = ?
                ORDER BY hk.ho_ten";
        return db_query($sql, [$lich_trinh_id, $lich_id])->fetchAll();
    }

    // Điểm danh cho lịch trình cụ thể
    public static function toggleAttendanceForSchedule($hanh_khach_id, $lich_trinh_id, $hdv_id) {
        // Kiểm tra trạng thái hiện tại
        $sqlCheck = "SELECT diem_danh_id, da_den FROM diem_danh_khach 
                     WHERE hanh_khach_id = ? AND lich_trinh_id = ?";
        $existing = db_query($sqlCheck, [$hanh_khach_id, $lich_trinh_id])->fetch();
        
        if ($existing) {
            // Chuyển trạng thái (toggle)
            $newStatus = 1 - $existing['da_den'];
            $sql = "UPDATE diem_danh_khach 
                    SET da_den = ?, thoi_gian = NOW(), hdv_id = ?
                    WHERE diem_danh_id = ?";
            return db_query($sql, [$newStatus, $hdv_id, $existing['diem_danh_id']]);
        } else {
            // Lấy dia_diem_id từ lich_trinh (nếu có)
            $sqlDiaDiem = "SELECT dia_diem_id FROM dia_diem_lich_trinh 
                          WHERE lich_trinh_id = ? 
                          ORDER BY thu_tu LIMIT 1";
            $diaDiem = db_query($sqlDiaDiem, [$lich_trinh_id])->fetch();
            $dia_diem_id = $diaDiem ? $diaDiem['dia_diem_id'] : null;
            
            // Nếu chưa có, tạo mới với trạng thái "Có mặt"
            $sql = "INSERT INTO diem_danh_khach (hanh_khach_id, lich_trinh_id, dia_diem_id, hdv_id, da_den, thoi_gian, ghi_chu)
                    VALUES (?, ?, ?, ?, 1, NOW(), '')";
            return db_query($sql, [$hanh_khach_id, $lich_trinh_id, $dia_diem_id, $hdv_id]);
        }
    }
}