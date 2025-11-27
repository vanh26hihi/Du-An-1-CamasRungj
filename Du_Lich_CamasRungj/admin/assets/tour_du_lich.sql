-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2025 at 11:57 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tour_du_lich`
--

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia_tour`
--

CREATE TABLE `danh_gia_tour` (
  `danh_gia_id` int NOT NULL,
  `hdv_id` int DEFAULT NULL,
  `tour_id` int DEFAULT NULL,
  `lich_id` int DEFAULT NULL,
  `diem_danh_gia` int DEFAULT NULL COMMENT 'Điểm đánh giá từ 1-5',
  `phan_hoi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_tour`
--

CREATE TABLE `danh_muc_tour` (
  `danh_muc_id` int NOT NULL,
  `ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danh_muc_tour`
--

INSERT INTO `danh_muc_tour` (`danh_muc_id`, `ten`, `trang_thai`, `mo_ta`, `ngay_tao`) VALUES
(1, 'Tour trong nước', 'active', 'Trải nghiệm du lịch Hà Nội - Đà Nẵng - Hội An', '2025-11-13 21:06:04'),
(2, 'Tour quốc tế', 'active', '', '2025-11-13 21:06:04'),
(3, 'Tour khuyến mãi', 'active', '', '2025-11-13 21:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `dat_tour`
--

CREATE TABLE `dat_tour` (
  `dat_tour_id` int NOT NULL,
  `lich_id` int DEFAULT NULL,
  `khach_hang_id` int DEFAULT NULL,
  `nguoi_tao_id` int DEFAULT NULL,
  `loai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_nguoi` int DEFAULT NULL,
  `tong_tien` decimal(15,2) DEFAULT NULL,
  `tien_te` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai_id` int NOT NULL DEFAULT '1',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dat_tour`
--

INSERT INTO `dat_tour` (`dat_tour_id`, `lich_id`, `khach_hang_id`, `nguoi_tao_id`, `loai`, `so_nguoi`, `tong_tien`, `tien_te`, `trang_thai_id`, `ngay_tao`, `ngay_cap_nhat`, `ghi_chu`) VALUES
(1, 1, 1, 1, 'group', 5, 17500000.00, 'VND', 1, '2025-11-13 21:19:41', '2025-11-13 21:19:41', 'Đặt online'),
(2, 2, 2, 1, 'individual', 2, 8000000.00, 'VND', 2, '2025-11-13 21:19:41', '2025-11-13 21:19:41', 'Đặt điện thoại'),
(3, 1, 3, 1, 'individual', 3, 10500000.00, 'VND', 3, '2025-11-13 21:19:41', '2025-11-22 12:42:20', 'Đặt trực tiếp tại quầy'),
(7, 2, 10, NULL, 'group', 2, 18000000.00, NULL, 1, '2025-11-21 16:56:11', '2025-11-25 00:11:46', 'Xin Chào');

-- --------------------------------------------------------

--
-- Table structure for table `dia_diem`
--

CREATE TABLE `dia_diem` (
  `dia_diem_id` int NOT NULL,
  `ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `quoc_gia_id` int DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dia_diem`
--

INSERT INTO `dia_diem` (`dia_diem_id`, `ten`, `mo_ta`, `quoc_gia_id`, `ngay_tao`) VALUES
(1, 'Hà Nội', 'Thủ đô Việt Nam', 1, '2025-11-13 21:06:04'),
(2, 'Đà Nẵng', 'Thành phố biển miền Trung', 1, '2025-11-13 21:06:04'),
(3, 'Bangkok', 'Thủ đô Thái Lan sôi động', 2, '2025-11-13 21:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `dia_diem_lich_trinh`
--

CREATE TABLE `dia_diem_lich_trinh` (
  `dia_diem_lich_id` int NOT NULL,
  `lich_trinh_id` int DEFAULT NULL,
  `dia_diem_id` int DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `thu_tu` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dia_diem_lich_trinh`
--

INSERT INTO `dia_diem_lich_trinh` (`dia_diem_lich_id`, `lich_trinh_id`, `dia_diem_id`, `mo_ta`, `thu_tu`) VALUES
(1, 1, 1, 'Văn Miếu', 1),
(2, 2, 2, 'Vịnh Hạ Long', 1),
(3, 3, 3, 'Bà Nà Hills', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dia_diem_tour`
--

CREATE TABLE `dia_diem_tour` (
  `dia_diem_tour_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `dia_diem_id` int DEFAULT NULL,
  `thu_tu` int DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dia_diem_tour`
--

INSERT INTO `dia_diem_tour` (`dia_diem_tour_id`, `tour_id`, `dia_diem_id`, `thu_tu`, `ghi_chu`) VALUES
(3, 2, 1, 1, 'Thủ đô Bangkok'),
(4, 16, 1, 1, 'Xuất Phát Từ Hà Nội'),
(5, 16, 3, 2, 'Điểm Đến Bangkok'),
(6, 1, 1, 1, 'Điểm xuất phát Hà Nội'),
(7, 1, 2, 2, 'Đến Đà Nẵng'),
(8, 1, 3, 3, 'Bay sang Bangkok');

-- --------------------------------------------------------

--
-- Table structure for table `dich_vu_ncc`
--

CREATE TABLE `dich_vu_ncc` (
  `dich_vu_id` int NOT NULL,
  `ncc_id` int DEFAULT NULL,
  `loai_dich_vu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ma` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `gia_mac_dinh` decimal(15,2) DEFAULT NULL,
  `don_vi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dich_vu_ncc`
--

INSERT INTO `dich_vu_ncc` (`dich_vu_id`, `ncc_id`, `loai_dich_vu`, `ma`, `mo_ta`, `gia_mac_dinh`, `don_vi`) VALUES
(1, 1, 'transport', 'DV001', 'Xe đưa đón sân bay 45 chỗ', 5000000.00, 'per trip'),
(2, 2, 'hotel', 'DV002', 'Khách sạn 4 sao, phòng đôi', 1500000.00, 'per room/night'),
(3, 3, 'catering', 'DV003', 'Ăn trưa tại nhà hàng địa phương', 200000.00, 'per pax');

-- --------------------------------------------------------

--
-- Table structure for table `diem_danh_khach`
--

CREATE TABLE `diem_danh_khach` (
  `diem_danh_id` int NOT NULL,
  `hanh_khach_id` int DEFAULT NULL,
  `lich_trinh_id` int DEFAULT NULL,
  `dia_diem_id` int DEFAULT NULL,
  `hdv_id` int DEFAULT NULL,
  `da_den` tinyint(1) DEFAULT NULL,
  `thoi_gian` datetime DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diem_danh_khach`
--

INSERT INTO `diem_danh_khach` (`diem_danh_id`, `hanh_khach_id`, `lich_trinh_id`, `dia_diem_id`, `hdv_id`, `da_den`, `thoi_gian`, `ghi_chu`) VALUES
(4, 1, 1, 1, 2, 1, '2025-12-01 08:00:00', 'Khách đến đúng giờ'),
(5, 2, 1, 1, 2, 0, '2025-12-01 08:05:00', 'Khách đến muộn 5 phút'),
(6, 3, 2, 2, 3, 1, '2025-12-15 09:00:00', 'Khách có yêu cầu đặc biệt');

-- --------------------------------------------------------

--
-- Table structure for table `gia_dv`
--

CREATE TABLE `gia_dv` (
  `lich_ncc_id` int NOT NULL,
  `lich_id` int DEFAULT NULL,
  `dich_vu_id` int DEFAULT NULL,
  `gia` decimal(15,2) DEFAULT NULL,
  `da_xac_nhan` tinyint(1) DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gia_dv`
--

INSERT INTO `gia_dv` (`lich_ncc_id`, `lich_id`, `dich_vu_id`, `gia`, `da_xac_nhan`, `ghi_chu`) VALUES
(13, 1, 1, 5000000.00, 1, 'Xe đưa đón sân bay đã xác nhận'),
(14, 1, 2, 1500000.00, 0, 'Khách sạn chưa xác nhận phòng'),
(15, 2, 3, 200000.00, 1, 'Ăn trưa tại nhà hàng đã xác nhận');

-- --------------------------------------------------------

--
-- Table structure for table `gia_lich_trinh`
--

CREATE TABLE `gia_lich_trinh` (
  `gia_lich_id` int NOT NULL,
  `lich_id` int DEFAULT NULL,
  `gia` decimal(15,2) DEFAULT NULL,
  `tien_te` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hieu_luc_tu` date DEFAULT NULL,
  `hieu_luc_den` date DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gia_lich_trinh`
--

INSERT INTO `gia_lich_trinh` (`gia_lich_id`, `lich_id`, `gia`, `tien_te`, `hieu_luc_tu`, `hieu_luc_den`, `ghi_chu`) VALUES
(1, 1, 3500000.00, 'VND', '2025-11-01', '2025-12-31', 'Giá mùa cao điểm'),
(2, 2, 4000000.00, 'VND', '2025-11-01', '2025-12-31', 'Giá mùa cao điểm'),
(3, 3, 9500000.00, 'VND', '2025-11-01', '2025-12-31', 'Giá tour quốc tế'),
(4, 1, 3500000.00, 'VND', '2025-11-01', '2025-12-31', 'Giá mùa cao điểm'),
(5, 2, 4000000.00, 'VND', '2025-11-01', '2025-12-31', 'Giá mùa cao điểm'),
(6, 3, 9500000.00, 'VND', '2025-11-01', '2025-12-31', 'Giá tour quốc tế');

-- --------------------------------------------------------

--
-- Table structure for table `hanh_khach_list`
--

CREATE TABLE `hanh_khach_list` (
  `hanh_khach_id` int NOT NULL,
  `dat_tour_id` int DEFAULT NULL,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gioi_tinh` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cccd` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `so_ghe` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hanh_khach_list`
--

INSERT INTO `hanh_khach_list` (`hanh_khach_id`, `dat_tour_id`, `ho_ten`, `gioi_tinh`, `cccd`, `so_dien_thoai`, `email`, `ngay_sinh`, `so_ghe`, `ghi_chu`) VALUES
(1, 1, 'Nguyễn Văn A', 'Nam', '123456789', '0909123456', 'a@example.com', '1990-05-12', 'A1', 'Khách VIP'),
(2, 1, 'Trần Thị B', 'Nam', '987654321', '0909234567', 'b@example.com', '1992-08-20', 'A2', ''),
(3, 2, 'Lê Văn C', 'Nữ', '456789123', '0909345678', 'c@example.com', '1988-11-30', 'B1', 'Yêu cầu chỗ gần cửa sổ'),
(8, 7, 'Nguyễn Văn Tùng', 'Nữ', '056738482343', '0932132123', 'luongdinhnam123abc@gmail.com', '2001-12-31', NULL, 'sdasdsa'),
(9, 7, 'Nguyễn Tung Cương', 'Nam', '09348274782', '09577234324', 'mailkhach@gmail.com', '2001-12-03', NULL, 'sdsadd'),
(12, NULL, 'Nguyễn Văn C', 'Nữ', '056738482343', '0932132123', 'luongdinhnam123abc@gmail.com', '2001-12-01', NULL, 'ẻerrer'),
(13, NULL, 'Nguyễn Tung Cương', 'Nam', '09348274782', '09577234324', 'mailkhach@gmail.com', '2001-12-06', NULL, 'jfdjsf');

-- --------------------------------------------------------

--
-- Table structure for table `hinh_anh_dia_diem`
--

CREATE TABLE `hinh_anh_dia_diem` (
  `hinh_id` int NOT NULL,
  `dia_diem_id` int DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thu_tu` int DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hinh_anh_dia_diem`
--

INSERT INTO `hinh_anh_dia_diem` (`hinh_id`, `dia_diem_id`, `url`, `alt_text`, `thu_tu`, `ghi_chu`) VALUES
(1, 1, 'images/hanoi.jpg', 'Hà Nội cổ kính', 1, 'Ảnh minh họa'),
(2, 2, 'images/danang.jpg', 'Biển Đà Nẵng', 1, 'Ảnh minh họa'),
(3, 3, 'images/bangkok.jpg', 'Bangkok về đêm', 1, 'Ảnh minh họa');

-- --------------------------------------------------------

--
-- Table structure for table `hop_dong`
--

CREATE TABLE `hop_dong` (
  `hop_dong_id` int NOT NULL,
  `dat_tour_id` int DEFAULT NULL,
  `ten_hop_dong` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_ky` datetime DEFAULT NULL,
  `ngay_hieu_luc` datetime DEFAULT NULL,
  `ngay_het_han` datetime DEFAULT NULL,
  `nguoi_ky_id` int DEFAULT NULL,
  `khach_hang_id` int DEFAULT NULL,
  `trang_thai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_hop_dong` text COLLATE utf8mb4_unicode_ci,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL,
  `ngay_cap_nhat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hop_dong`
--

INSERT INTO `hop_dong` (`hop_dong_id`, `dat_tour_id`, `ten_hop_dong`, `ngay_ky`, `ngay_hieu_luc`, `ngay_het_han`, `nguoi_ky_id`, `khach_hang_id`, `trang_thai`, `file_hop_dong`, `ghi_chu`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(4, 1, 'Hợp đồng tour Đà Lạt 3N2Đ', '2025-11-01 00:00:00', '2025-11-01 00:00:00', '2025-12-31 00:00:00', 1, 1, 'active', 'hd_001.pdf', 'Hợp đồng ký bởi admin', '2025-11-01 10:00:00', '2025-11-01 10:00:00'),
(5, 2, 'Hợp đồng tour Thái Lan 5N4Đ', '2025-11-05 00:00:00', '2025-11-05 00:00:00', '2025-12-31 00:00:00', 1, 2, 'active', 'hd_002.pdf', 'Hợp đồng ký bởi admin', '2025-11-05 09:30:00', '2025-11-05 09:30:00'),
(6, 3, 'Hợp đồng tour Hà Nội - Hạ Long', '2025-11-10 00:00:00', '2025-11-10 00:00:00', '2025-12-31 00:00:00', 1, 3, 'active', 'hd_003.pdf', 'Hợp đồng ký bởi admin', '2025-11-10 14:00:00', '2025-11-10 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `huong_dan_vien`
--

CREATE TABLE `huong_dan_vien` (
  `hdv_id` int NOT NULL,
  `nguoi_dung_id` int DEFAULT NULL,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kinh_nghiem` text COLLATE utf8mb4_unicode_ci,
  `ngon_ngu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `huong_dan_vien`
--

INSERT INTO `huong_dan_vien` (`hdv_id`, `nguoi_dung_id`, `ho_ten`, `so_dien_thoai`, `email`, `kinh_nghiem`, `ngon_ngu`, `ngay_tao`) VALUES
(1, 2, 'Nguyễn HDV 1', '0909345678', 'hdv1@travel.com', '5 năm dẫn tour nội địa', 'Việt, Anh', '2025-11-13 21:19:41'),
(2, 3, 'Trần HDV 2', '0909456789', 'hdv2@travel.com', '3 năm dẫn tour quốc tế', 'Việt, Thái', '2025-11-13 21:19:41'),
(3, NULL, 'Lê Freelance', '0909777555', 'freelance@travel.com', '2 năm HDV tự do', 'Việt', '2025-11-13 21:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `khach_hang_id` int NOT NULL,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cccd` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dia_chi` text COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`khach_hang_id`, `ho_ten`, `so_dien_thoai`, `email`, `cccd`, `dia_chi`, `ngay_tao`) VALUES
(1, 'Nguyễn Văn A', '0911000001', 'a@travel.com', '0123456789', 'Hà Nội', '2025-11-13 21:06:04'),
(2, 'Trần Thị B', '0911000002', 'b@travel.com', '9876543210', 'Đà Nẵng', '2025-11-13 21:06:04'),
(3, 'Lê Văn C', '0911000003', 'c@travel.com', '1234987654', 'TP.HCM', '2025-11-13 21:06:04'),
(7, 'Nguyễn Trọng Vinh', '0971596111', 'luongdinhnam123abc@gmail.com', '05672339134', 'Phường Xuân Phương, Thành Phố Hà Nội.', NULL),
(8, 'Nguyễn Trọng Vinh', '0971596111', 'luongdinhnam123abc@gmail.com', '05672339134', 'Phường Xuân Phương, Thành Phố Hà Nội.', NULL),
(9, 'Nguyễn Trọng Vinh', '0971596777', 'trungtoan@gmail.com', '05672339134', 'Phường Xuân Phương, Thành Phố Hà Nội.', NULL),
(10, 'Nguyễn Trọng Vinh', '0971596777', 'trungtoan@gmail.com', '555555555555', 'Phường Xuân Phương, Thành Phố Hà Nội.', NULL),
(11, 'Nguyễn Trọng Vinh', '0971596777', 'trungtoan@gmail.com', '05672339134', 'Phường Xuân Phương, Thành Phố Hà Nội.', NULL),
(12, 'Trần Trung Toàn', '0911000003', 'luongdinhnam123abc@gmail.com', '05672339134', 'TP.HCM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lich_khoi_hanh`
--

CREATE TABLE `lich_khoi_hanh` (
  `lich_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai_id` int DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lich_khoi_hanh`
--

INSERT INTO `lich_khoi_hanh` (`lich_id`, `tour_id`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai_id`, `ngay_tao`, `ghi_chu`) VALUES
(1, 1, '2025-12-01', '2025-12-03', 1, '2025-11-13 21:19:41', 'Tour khởi hành đầu tháng'),
(2, 2, '2025-12-05', '2025-12-07', 1, '2025-11-13 21:19:41', 'Tour khởi hành giữa tháng'),
(3, 3, '2025-12-10', '2025-12-15', 1, '2025-11-13 21:19:41', 'Tour Bangkok'),
(7, 1, '2025-11-27', '2025-11-30', 1, '2025-11-26 15:41:47', 'Tour Cuối tháng 11');

-- --------------------------------------------------------

--
-- Table structure for table `lich_trinh`
--

CREATE TABLE `lich_trinh` (
  `lich_trinh_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `ngay_thu` int DEFAULT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lich_trinh`
--

INSERT INTO `lich_trinh` (`lich_trinh_id`, `tour_id`, `ngay_thu`, `tieu_de`, `noi_dung`) VALUES
(1, 1, 1, 'Hà Nội', 'Tham quan Hoàn Kiếm, Văn Miếu'),
(2, 1, 2, 'Hạ Long', 'Tham quan Vịnh Hạ Long'),
(3, 2, 1, 'Đà Nẵng', 'Tham quan Bà Nà Hills');

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `nguoi_dung_id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mat_khau` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vai_tro_id` int DEFAULT NULL,
  `trang_thai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`nguoi_dung_id`, `email`, `mat_khau`, `ho_ten`, `so_dien_thoai`, `vai_tro_id`, `trang_thai`, `ngay_tao`) VALUES
(1, 'admin@travel.com', 'hash123', 'Admin Chính', '0909000001', 1, 'active', '2025-11-13 21:06:04'),
(2, 'guide1@travel.com', 'hash123', 'Hướng dẫn viên A', '0909000002', 2, 'active', '2025-11-13 21:06:04'),
(3, 'guide2@travel.com', 'hash123', 'Hướng dẫn viên B', '0909000003', 2, 'active', '2025-11-13 21:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `nhat_ky_tour`
--

CREATE TABLE `nhat_ky_tour` (
  `nhat_ky_tour_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `hdv_id` int DEFAULT NULL,
  `lich_id` int DEFAULT NULL,
  `dia_diem_id` int DEFAULT NULL,
  `anh_tour` text COLLATE utf8mb4_unicode_ci,
  `ngay_thuc_hien` datetime DEFAULT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhat_ky_tour`
--

INSERT INTO `nhat_ky_tour` (`nhat_ky_tour_id`, `tour_id`, `hdv_id`, `lich_id`, `dia_diem_id`, `anh_tour`, `ngay_thuc_hien`, `noi_dung`) VALUES
(1, 1, 2, 1, 1, 'images/da_lat_1.jpg', '2025-12-01 08:00:00', 'Khởi hành từ TP.HCM, tham quan Hồ Xuân Hương.'),
(2, 1, 2, 1, 2, 'images/da_lat_2.jpg', '2025-12-02 10:00:00', 'Tham quan Thung Lũng Tình Yêu, chụp hình nhóm.'),
(3, 2, 3, 2, 3, 'images/bangkok_1.jpg', '2025-12-15 09:00:00', 'Khởi hành từ Hà Nội, tham quan Chùa Phật Ngọc.');

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `ncc_id` int NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_he` text COLLATE utf8mb4_unicode_ci,
  `dia_chi` text COLLATE utf8mb4_unicode_ci,
  `ma_so_thue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`ncc_id`, `ten`, `lien_he`, `dia_chi`, `ma_so_thue`, `ngay_tao`) VALUES
(1, 'Công ty Vận Tải ABC', '0909123456 - abc@transport.com', 'Hà Nội, Việt Nam', '0102030405', '2025-11-13 21:27:24'),
(2, 'Khách sạn Sunrise', '0912345678 - info@sunrisehotel.com', 'Đà Nẵng, Việt Nam', '0203040506', '2025-11-13 21:27:24'),
(3, 'Nhà hàng Golden Dragon', '0909988776 - contact@goldendragon.com', 'Hạ Long, Việt Nam', '0304050607', '2025-11-13 21:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `phan_cong_hdv`
--

CREATE TABLE `phan_cong_hdv` (
  `phan_cong_id` int NOT NULL,
  `lich_id` int DEFAULT NULL,
  `hdv_id` int DEFAULT NULL,
  `vai_tro` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_phan_cong` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phan_cong_hdv`
--

INSERT INTO `phan_cong_hdv` (`phan_cong_id`, `lich_id`, `hdv_id`, `vai_tro`, `ngay_phan_cong`) VALUES
(1, 1, 1, 'main', '2025-11-13 21:19:41'),
(2, 2, 2, 'main', '2025-11-13 21:19:41'),
(3, 3, 3, 'assistant', '2025-11-13 21:19:41'),
(7, 7, 3, 'main', '2025-11-26 15:41:47'),
(8, 7, 1, 'support', '2025-11-26 15:41:47'),
(9, 7, 2, 'support', '2025-11-26 15:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `phuong_tien_tour`
--

CREATE TABLE `phuong_tien_tour` (
  `phuong_tien_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `so_cho` int DEFAULT NULL,
  `so_cho_con_lai` int DEFAULT NULL,
  `ten_phuong_tien` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gia_phuong_tien` decimal(15,2) DEFAULT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phuong_tien_tour`
--

INSERT INTO `phuong_tien_tour` (`phuong_tien_id`, `tour_id`, `so_cho`, `so_cho_con_lai`, `ten_phuong_tien`, `gia_phuong_tien`, `noi_dung`) VALUES
(1, 1, 45, 10, 'Xe 45 chỗ', 5000000.00, 'Xe khách giường nằm chất lượng cao'),
(2, 2, 150, 80, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi Hà Nội - Bangkok'),
(3, 3, 30, 30, 'Xe Limousine', 7000000.00, 'Xe limousine êm ái, wifi miễn phí');

-- --------------------------------------------------------

--
-- Table structure for table `quoc_gia`
--

CREATE TABLE `quoc_gia` (
  `quoc_gia_id` int NOT NULL,
  `ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quoc_gia`
--

INSERT INTO `quoc_gia` (`quoc_gia_id`, `ten`, `mo_ta`) VALUES
(1, 'Việt Nam', 'Quốc gia Đông Nam Á'),
(2, 'Thái Lan', 'Xứ sở chùa Vàng'),
(3, 'Nhật Bản', 'Đất nước mặt trời mọc');

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `tour_id` int NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `danh_muc_id` int DEFAULT NULL,
  `mo_ta_ngan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `gia_co_ban` decimal(15,2) DEFAULT NULL,
  `thoi_luong_mac_dinh` int DEFAULT NULL,
  `chinh_sach` text COLLATE utf8mb4_unicode_ci,
  `nguoi_tao_id` int DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL,
  `diem_khoi_hanh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoat_dong` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`tour_id`, `ten`, `danh_muc_id`, `mo_ta_ngan`, `mo_ta`, `gia_co_ban`, `thoi_luong_mac_dinh`, `chinh_sach`, `nguoi_tao_id`, `ngay_tao`, `diem_khoi_hanh`, `hoat_dong`) VALUES
(1, 'Tour Hà Nội - Đà Nẵng - BangKok 4N3Đ', 2, 'Khám phá miền Trung', 'Trải nghiệm du lịch Hà Nội - Đà Nẵng - Bangkok', 5000000.00, 4, 'Không hoàn vé sau khi đặt cọc', 1, '2025-11-13 21:06:04', 'Hà Nội', 1),
(2, 'Tour Bangkok 5N4Đ', 2, 'Khám phá Thái Lan', 'Tham quan Bangkok và Pattaya', 9000000.00, 5, 'Thanh toán trước 50%', 1, '2025-11-13 21:06:04', 'TP.HCM', 1),
(3, 'Tour Đà Lạt 3N2Đ', 1, 'Không khí se lạnh', 'Tham quan các điểm nổi bật ở Đà Lạt', 3500000.00, 3, 'Hủy trước 3 ngày không mất phí', 1, '2025-11-13 21:06:04', 'TP.HCM', 1),
(16, 'Tour Hà Nội - Bangkok 4N3D', 1, 'Du Lịch xuyên lục địa', 'Khám Phá từ Hà Nội đến Bangkok cùng với HDV chuyên Nghiệp', 2300000.00, 4, 'Thanh toán trước 50%', 1, '2025-11-25 14:21:06', 'Hà Nội', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tour_ncc`
--

CREATE TABLE `tour_ncc` (
  `tour_ncc_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `dich_vu_id` int DEFAULT NULL,
  `gia_thoa_thuan` decimal(15,2) DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci,
  `ma_hop_dong` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_ncc`
--

INSERT INTO `tour_ncc` (`tour_ncc_id`, `tour_id`, `dich_vu_id`, `gia_thoa_thuan`, `ghi_chu`, `ma_hop_dong`) VALUES
(1, 1, 1, 4800000.00, 'Xe đưa đón sân bay đã thỏa thuận', 'HD001'),
(2, 1, 2, 1400000.00, 'Khách sạn 4 sao, giá đã thương lượng', 'HD002'),
(3, 2, 3, 190000.00, 'Dịch vụ ăn trưa đã được xác nhận', 'HD003');

-- --------------------------------------------------------

--
-- Table structure for table `trang_thai_booking`
--

CREATE TABLE `trang_thai_booking` (
  `trang_thai_id` int NOT NULL,
  `ten_trang_thai` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trang_thai_booking`
--

INSERT INTO `trang_thai_booking` (`trang_thai_id`, `ten_trang_thai`, `mo_ta`) VALUES
(1, 'Chờ xử lý', 'Khách vừa đặt.\r\n\r\nChưa được xác nhận.\r\n\r\nChưa thanh toán hoặc chưa duyệt.'),
(2, 'Đã xác nhận', 'Admin hoặc hệ thống đã duyệt.\r\n\r\nKhách đã thanh toán hoặc được chấp nhận.\r\n\r\nBooking chính thức hợp lệ.'),
(3, 'Đã hủy', 'Khách hoặc admin hủy booking.\r\n\r\nKhông còn hiệu lực.\r\n\r\nKhông được sử dụng nữa.');

-- --------------------------------------------------------

--
-- Table structure for table `trang_thai_lich_khoi_hanh`
--

CREATE TABLE `trang_thai_lich_khoi_hanh` (
  `trang_thai_id` int NOT NULL,
  `ten_trang_thai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trang_thai_lich_khoi_hanh`
--

INSERT INTO `trang_thai_lich_khoi_hanh` (`trang_thai_id`, `ten_trang_thai`, `mo_ta`) VALUES
(1, 'Đang mở', 'Lịch khởi hành đang mở cho khách đăng ký'),
(2, 'Sắp đầy', 'Số lượng khách gần đạt tối đa'),
(3, 'Đã đầy', 'Lịch khởi hành đã đủ khách'),
(4, 'Hủy', 'Lịch khởi hành đã bị hủy');

-- --------------------------------------------------------

--
-- Table structure for table `vai_tro`
--

CREATE TABLE `vai_tro` (
  `vai_tro_id` int NOT NULL,
  `ten` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vai_tro`
--

INSERT INTO `vai_tro` (`vai_tro_id`, `ten`, `mo_ta`) VALUES
(1, 'admin', 'Quản trị hệ thống'),
(2, 'guide', 'Hướng dẫn viên');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `danh_gia_tour`
--
ALTER TABLE `danh_gia_tour`
  ADD PRIMARY KEY (`danh_gia_id`),
  ADD KEY `hdv_id` (`hdv_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `lich_id` (`lich_id`);

--
-- Indexes for table `danh_muc_tour`
--
ALTER TABLE `danh_muc_tour`
  ADD PRIMARY KEY (`danh_muc_id`);

--
-- Indexes for table `dat_tour`
--
ALTER TABLE `dat_tour`
  ADD PRIMARY KEY (`dat_tour_id`),
  ADD KEY `lich_id` (`lich_id`),
  ADD KEY `khach_hang_id` (`khach_hang_id`),
  ADD KEY `dat_tour_ibfk_4` (`trang_thai_id`);

--
-- Indexes for table `dia_diem`
--
ALTER TABLE `dia_diem`
  ADD PRIMARY KEY (`dia_diem_id`),
  ADD KEY `quoc_gia_id` (`quoc_gia_id`);

--
-- Indexes for table `dia_diem_lich_trinh`
--
ALTER TABLE `dia_diem_lich_trinh`
  ADD PRIMARY KEY (`dia_diem_lich_id`),
  ADD KEY `lich_trinh_id` (`lich_trinh_id`),
  ADD KEY `dia_diem_id` (`dia_diem_id`);

--
-- Indexes for table `dia_diem_tour`
--
ALTER TABLE `dia_diem_tour`
  ADD PRIMARY KEY (`dia_diem_tour_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `dia_diem_id` (`dia_diem_id`);

--
-- Indexes for table `dich_vu_ncc`
--
ALTER TABLE `dich_vu_ncc`
  ADD PRIMARY KEY (`dich_vu_id`),
  ADD KEY `ncc_id` (`ncc_id`);

--
-- Indexes for table `diem_danh_khach`
--
ALTER TABLE `diem_danh_khach`
  ADD PRIMARY KEY (`diem_danh_id`),
  ADD KEY `hanh_khach_id` (`hanh_khach_id`),
  ADD KEY `lich_trinh_id` (`lich_trinh_id`),
  ADD KEY `dia_diem_id` (`dia_diem_id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Indexes for table `gia_dv`
--
ALTER TABLE `gia_dv`
  ADD PRIMARY KEY (`lich_ncc_id`),
  ADD KEY `lich_id` (`lich_id`),
  ADD KEY `dich_vu_id` (`dich_vu_id`);

--
-- Indexes for table `gia_lich_trinh`
--
ALTER TABLE `gia_lich_trinh`
  ADD PRIMARY KEY (`gia_lich_id`),
  ADD KEY `lich_id` (`lich_id`);

--
-- Indexes for table `hanh_khach_list`
--
ALTER TABLE `hanh_khach_list`
  ADD PRIMARY KEY (`hanh_khach_id`),
  ADD KEY `dat_tour_id` (`dat_tour_id`);

--
-- Indexes for table `hinh_anh_dia_diem`
--
ALTER TABLE `hinh_anh_dia_diem`
  ADD PRIMARY KEY (`hinh_id`),
  ADD KEY `dia_diem_id` (`dia_diem_id`);

--
-- Indexes for table `hop_dong`
--
ALTER TABLE `hop_dong`
  ADD PRIMARY KEY (`hop_dong_id`),
  ADD KEY `dat_tour_id` (`dat_tour_id`),
  ADD KEY `khach_hang_id` (`khach_hang_id`);

--
-- Indexes for table `huong_dan_vien`
--
ALTER TABLE `huong_dan_vien`
  ADD PRIMARY KEY (`hdv_id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`khach_hang_id`);

--
-- Indexes for table `lich_khoi_hanh`
--
ALTER TABLE `lich_khoi_hanh`
  ADD PRIMARY KEY (`lich_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `lich_khoi_hanh_ibfk_2` (`trang_thai_id`);

--
-- Indexes for table `lich_trinh`
--
ALTER TABLE `lich_trinh`
  ADD PRIMARY KEY (`lich_trinh_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`nguoi_dung_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `vai_tro_id` (`vai_tro_id`);

--
-- Indexes for table `nhat_ky_tour`
--
ALTER TABLE `nhat_ky_tour`
  ADD PRIMARY KEY (`nhat_ky_tour_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `hdv_id` (`hdv_id`),
  ADD KEY `lich_id` (`lich_id`),
  ADD KEY `dia_diem_id` (`dia_diem_id`);

--
-- Indexes for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`ncc_id`);

--
-- Indexes for table `phan_cong_hdv`
--
ALTER TABLE `phan_cong_hdv`
  ADD PRIMARY KEY (`phan_cong_id`),
  ADD KEY `lich_id` (`lich_id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Indexes for table `phuong_tien_tour`
--
ALTER TABLE `phuong_tien_tour`
  ADD PRIMARY KEY (`phuong_tien_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `quoc_gia`
--
ALTER TABLE `quoc_gia`
  ADD PRIMARY KEY (`quoc_gia_id`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `danh_muc_id` (`danh_muc_id`),
  ADD KEY `nguoi_tao_id` (`nguoi_tao_id`);

--
-- Indexes for table `tour_ncc`
--
ALTER TABLE `tour_ncc`
  ADD PRIMARY KEY (`tour_ncc_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `dich_vu_id` (`dich_vu_id`);

--
-- Indexes for table `trang_thai_booking`
--
ALTER TABLE `trang_thai_booking`
  ADD PRIMARY KEY (`trang_thai_id`);

--
-- Indexes for table `trang_thai_lich_khoi_hanh`
--
ALTER TABLE `trang_thai_lich_khoi_hanh`
  ADD PRIMARY KEY (`trang_thai_id`);

--
-- Indexes for table `vai_tro`
--
ALTER TABLE `vai_tro`
  ADD PRIMARY KEY (`vai_tro_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danh_gia_tour`
--
ALTER TABLE `danh_gia_tour`
  MODIFY `danh_gia_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danh_muc_tour`
--
ALTER TABLE `danh_muc_tour`
  MODIFY `danh_muc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dat_tour`
--
ALTER TABLE `dat_tour`
  MODIFY `dat_tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dia_diem`
--
ALTER TABLE `dia_diem`
  MODIFY `dia_diem_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dia_diem_lich_trinh`
--
ALTER TABLE `dia_diem_lich_trinh`
  MODIFY `dia_diem_lich_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dia_diem_tour`
--
ALTER TABLE `dia_diem_tour`
  MODIFY `dia_diem_tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dich_vu_ncc`
--
ALTER TABLE `dich_vu_ncc`
  MODIFY `dich_vu_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `diem_danh_khach`
--
ALTER TABLE `diem_danh_khach`
  MODIFY `diem_danh_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gia_dv`
--
ALTER TABLE `gia_dv`
  MODIFY `lich_ncc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `gia_lich_trinh`
--
ALTER TABLE `gia_lich_trinh`
  MODIFY `gia_lich_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hanh_khach_list`
--
ALTER TABLE `hanh_khach_list`
  MODIFY `hanh_khach_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hinh_anh_dia_diem`
--
ALTER TABLE `hinh_anh_dia_diem`
  MODIFY `hinh_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hop_dong`
--
ALTER TABLE `hop_dong`
  MODIFY `hop_dong_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `huong_dan_vien`
--
ALTER TABLE `huong_dan_vien`
  MODIFY `hdv_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `khach_hang_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lich_khoi_hanh`
--
ALTER TABLE `lich_khoi_hanh`
  MODIFY `lich_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lich_trinh`
--
ALTER TABLE `lich_trinh`
  MODIFY `lich_trinh_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `nguoi_dung_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nhat_ky_tour`
--
ALTER TABLE `nhat_ky_tour`
  MODIFY `nhat_ky_tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `ncc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phan_cong_hdv`
--
ALTER TABLE `phan_cong_hdv`
  MODIFY `phan_cong_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `phuong_tien_tour`
--
ALTER TABLE `phuong_tien_tour`
  MODIFY `phuong_tien_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quoc_gia`
--
ALTER TABLE `quoc_gia`
  MODIFY `quoc_gia_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tour_ncc`
--
ALTER TABLE `tour_ncc`
  MODIFY `tour_ncc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `trang_thai_booking`
--
ALTER TABLE `trang_thai_booking`
  MODIFY `trang_thai_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trang_thai_lich_khoi_hanh`
--
ALTER TABLE `trang_thai_lich_khoi_hanh`
  MODIFY `trang_thai_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vai_tro`
--
ALTER TABLE `vai_tro`
  MODIFY `vai_tro_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dat_tour`
--
ALTER TABLE `dat_tour`
  ADD CONSTRAINT `dat_tour_ibfk_1` FOREIGN KEY (`lich_id`) REFERENCES `lich_khoi_hanh` (`lich_id`),
  ADD CONSTRAINT `dat_tour_ibfk_2` FOREIGN KEY (`khach_hang_id`) REFERENCES `khach_hang` (`khach_hang_id`),
  ADD CONSTRAINT `dat_tour_ibfk_4` FOREIGN KEY (`trang_thai_id`) REFERENCES `trang_thai_booking` (`trang_thai_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dia_diem`
--
ALTER TABLE `dia_diem`
  ADD CONSTRAINT `dia_diem_ibfk_1` FOREIGN KEY (`quoc_gia_id`) REFERENCES `quoc_gia` (`quoc_gia_id`);

--
-- Constraints for table `dia_diem_lich_trinh`
--
ALTER TABLE `dia_diem_lich_trinh`
  ADD CONSTRAINT `dia_diem_lich_trinh_ibfk_1` FOREIGN KEY (`lich_trinh_id`) REFERENCES `lich_trinh` (`lich_trinh_id`),
  ADD CONSTRAINT `dia_diem_lich_trinh_ibfk_2` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`dia_diem_id`);

--
-- Constraints for table `dia_diem_tour`
--
ALTER TABLE `dia_diem_tour`
  ADD CONSTRAINT `dia_diem_tour_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`),
  ADD CONSTRAINT `dia_diem_tour_ibfk_2` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`dia_diem_id`);

--
-- Constraints for table `dich_vu_ncc`
--
ALTER TABLE `dich_vu_ncc`
  ADD CONSTRAINT `dich_vu_ncc_ibfk_1` FOREIGN KEY (`ncc_id`) REFERENCES `nha_cung_cap` (`ncc_id`);

--
-- Constraints for table `diem_danh_khach`
--
ALTER TABLE `diem_danh_khach`
  ADD CONSTRAINT `diem_danh_khach_ibfk_1` FOREIGN KEY (`hanh_khach_id`) REFERENCES `hanh_khach_list` (`hanh_khach_id`),
  ADD CONSTRAINT `diem_danh_khach_ibfk_2` FOREIGN KEY (`lich_trinh_id`) REFERENCES `lich_trinh` (`lich_trinh_id`),
  ADD CONSTRAINT `diem_danh_khach_ibfk_3` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`dia_diem_id`),
  ADD CONSTRAINT `diem_danh_khach_ibfk_4` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_vien` (`hdv_id`);

--
-- Constraints for table `gia_dv`
--
ALTER TABLE `gia_dv`
  ADD CONSTRAINT `gia_dv_ibfk_1` FOREIGN KEY (`lich_id`) REFERENCES `lich_khoi_hanh` (`lich_id`),
  ADD CONSTRAINT `gia_dv_ibfk_2` FOREIGN KEY (`dich_vu_id`) REFERENCES `dich_vu_ncc` (`dich_vu_id`);

--
-- Constraints for table `gia_lich_trinh`
--
ALTER TABLE `gia_lich_trinh`
  ADD CONSTRAINT `gia_lich_trinh_ibfk_1` FOREIGN KEY (`lich_id`) REFERENCES `lich_khoi_hanh` (`lich_id`);

--
-- Constraints for table `hanh_khach_list`
--
ALTER TABLE `hanh_khach_list`
  ADD CONSTRAINT `hanh_khach_list_ibfk_1` FOREIGN KEY (`dat_tour_id`) REFERENCES `dat_tour` (`dat_tour_id`);

--
-- Constraints for table `hinh_anh_dia_diem`
--
ALTER TABLE `hinh_anh_dia_diem`
  ADD CONSTRAINT `hinh_anh_dia_diem_ibfk_1` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`dia_diem_id`);

--
-- Constraints for table `hop_dong`
--
ALTER TABLE `hop_dong`
  ADD CONSTRAINT `hop_dong_ibfk_1` FOREIGN KEY (`dat_tour_id`) REFERENCES `dat_tour` (`dat_tour_id`),
  ADD CONSTRAINT `hop_dong_ibfk_2` FOREIGN KEY (`khach_hang_id`) REFERENCES `hanh_khach_list` (`hanh_khach_id`);

--
-- Constraints for table `huong_dan_vien`
--
ALTER TABLE `huong_dan_vien`
  ADD CONSTRAINT `huong_dan_vien_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`nguoi_dung_id`);

--
-- Constraints for table `lich_khoi_hanh`
--
ALTER TABLE `lich_khoi_hanh`
  ADD CONSTRAINT `lich_khoi_hanh_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`),
  ADD CONSTRAINT `lich_khoi_hanh_ibfk_2` FOREIGN KEY (`trang_thai_id`) REFERENCES `trang_thai_lich_khoi_hanh` (`trang_thai_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `lich_trinh`
--
ALTER TABLE `lich_trinh`
  ADD CONSTRAINT `lich_trinh_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`);

--
-- Constraints for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `nguoi_dung_ibfk_1` FOREIGN KEY (`vai_tro_id`) REFERENCES `vai_tro` (`vai_tro_id`);

--
-- Constraints for table `nhat_ky_tour`
--
ALTER TABLE `nhat_ky_tour`
  ADD CONSTRAINT `nhat_ky_tour_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`),
  ADD CONSTRAINT `nhat_ky_tour_ibfk_2` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_vien` (`hdv_id`),
  ADD CONSTRAINT `nhat_ky_tour_ibfk_3` FOREIGN KEY (`lich_id`) REFERENCES `lich_khoi_hanh` (`lich_id`),
  ADD CONSTRAINT `nhat_ky_tour_ibfk_4` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`dia_diem_id`);

--
-- Constraints for table `phan_cong_hdv`
--
ALTER TABLE `phan_cong_hdv`
  ADD CONSTRAINT `phan_cong_hdv_ibfk_1` FOREIGN KEY (`lich_id`) REFERENCES `lich_khoi_hanh` (`lich_id`),
  ADD CONSTRAINT `phan_cong_hdv_ibfk_2` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_vien` (`hdv_id`);

--
-- Constraints for table `phuong_tien_tour`
--
ALTER TABLE `phuong_tien_tour`
  ADD CONSTRAINT `phuong_tien_tour_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`);

--
-- Constraints for table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`danh_muc_id`) REFERENCES `danh_muc_tour` (`danh_muc_id`),
  ADD CONSTRAINT `tour_ibfk_2` FOREIGN KEY (`nguoi_tao_id`) REFERENCES `nguoi_dung` (`nguoi_dung_id`);

--
-- Constraints for table `tour_ncc`
--
ALTER TABLE `tour_ncc`
  ADD CONSTRAINT `tour_ncc_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`),
  ADD CONSTRAINT `tour_ncc_ibfk_2` FOREIGN KEY (`dich_vu_id`) REFERENCES `dich_vu_ncc` (`dich_vu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
