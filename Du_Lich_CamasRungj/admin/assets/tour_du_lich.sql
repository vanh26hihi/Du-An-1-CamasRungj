-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2025 at 09:30 AM
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
  `hdv_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `lich_id` int NOT NULL,
  `diem_danh_gia` int NOT NULL DEFAULT 5 COMMENT 'Điểm đánh giá từ 1-5',
  `phan_hoi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danh_gia_tour`
--

INSERT INTO `danh_gia_tour` (`danh_gia_id`, `hdv_id`, `tour_id`, `lich_id`, `diem_danh_gia`, `phan_hoi`, `ngay_tao`) VALUES
(1, 1, 1, 1, 5, 'Hướng dẫn viên nhiệt tình, tour rất hay!', '2025-12-06 10:00:00'),
(2, 2, 2, 2, 4, 'Tour tốt nhưng lịch trình hơi gấp', '2025-12-11 15:30:00'),
(3, 3, 3, 3, 5, 'Tuyệt vời! Sapa đẹp như mơ', '2025-12-16 09:00:00'),
(4, 1, 4, 4, 5, 'HDV chuyên nghiệp, ăn uống ngon', '2025-12-21 14:00:00'),
(5, 4, 5, 5, 4, 'Tour tổ chức tốt, đáng để trải nghiệm', '2025-12-26 11:00:00'),
(6, 5, 6, 6, 5, 'Đà Nẵng đẹp tuyệt vời, HDV thân thiện', '2025-12-31 16:00:00'),
(7, 1, 7, 7, 5, 'Tour Phú Quốc tuyệt vời, biển đẹp', '2026-01-05 10:30:00'),
(8, 2, 8, 8, 4, 'Khách sạn tốt, dịch vụ chuyên nghiệp', '2026-01-10 13:00:00'),
(9, 3, 9, 9, 5, 'Bangkok sôi động, ẩm thực đỉnh cao', '2026-01-15 12:00:00'),
(10, 4, 10, 10, 5, 'Tour Singapore tổ chức chu đáo', '2026-01-20 09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_tour`
--

CREATE TABLE `danh_muc_tour` (
  `danh_muc_id` int NOT NULL,
  `ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danh_muc_tour`
--

INSERT INTO `danh_muc_tour` (`danh_muc_id`, `ten`, `trang_thai`, `mo_ta`, `ngay_tao`) VALUES
(1, 'Tour Miền Bắc', 'active', 'Khám phá vẻ đẹp văn hóa và thiên nhiên miền Bắc Việt Nam', '2025-12-03 15:24:38'),
(2, 'Tour Miền Trung', 'active', 'Trải nghiệm di sản và biển đảo miền Trung', '2025-12-03 15:24:38'),
(3, 'Tour Miền Nam', 'active', 'Khám phá sông nước và miệt vườn Nam Bộ', '2025-12-03 15:24:38'),
(4, 'Tour Đông Nam Á', 'active', 'Du lịch các nước láng giềng Đông Nam Á', '2025-12-03 15:24:38'),
(5, 'Tour Đông Bắc Á', 'active', 'Trải nghiệm văn hóa Nhật Bản, Hàn Quốc', '2025-12-03 15:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `dat_tour`
--

CREATE TABLE `dat_tour` (
  `dat_tour_id` int NOT NULL,
  `lich_id` int DEFAULT NULL,
  `khach_hang_id` int DEFAULT NULL,
  `nguoi_tao_id` int DEFAULT NULL,
  `loai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_nguoi` int DEFAULT NULL,
  `tong_tien` decimal(15,2) DEFAULT NULL,
  `tien_te` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai_id` int NOT NULL DEFAULT '1',
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dat_tour`
--

INSERT INTO `dat_tour` (`dat_tour_id`, `lich_id`, `khach_hang_id`, `nguoi_tao_id`, `loai`, `so_nguoi`, `tong_tien`, `tien_te`, `trang_thai_id`, `ngay_tao`, `ngay_cap_nhat`, `ghi_chu`) VALUES
(1, 1, 6, 1, 'individual', 2, 7000000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(2, 2, 1, 1, 'group', 5, 17500000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(3, 3, 6, 1, 'group', 5, 17500000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(4, 4, 4, 1, 'individual', 2, 8400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(5, 5, 8, 1, 'group', 4, 16800000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(6, 6, 4, 1, 'group', 5, 21000000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(7, 7, 3, 1, 'individual', 3, 8400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(8, 8, 10, 1, 'group', 4, 11200000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(9, 9, 9, 1, 'individual', 3, 8400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(10, 10, 10, 1, 'group', 4, 20800000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(11, 11, 9, 1, 'group', 5, 26000000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(12, 12, 4, 1, 'individual', 3, 15600000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(13, 13, 5, 1, 'group', 4, 26000000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(14, 14, 4, 1, 'group', 4, 26000000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(15, 15, 10, 1, 'group', 5, 32500000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(16, 16, 6, 1, 'group', 4, 19200000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(17, 17, 2, 1, 'individual', 3, 14400000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(18, 18, 9, 1, 'group', 4, 19200000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(19, 19, 1, 1, 'individual', 3, 11400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(20, 20, 1, 1, 'group', 5, 19000000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(21, 21, 8, 1, 'individual', 2, 7600000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(22, 22, 10, 1, 'individual', 2, 4400000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(23, 23, 10, 1, 'individual', 2, 4400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(24, 24, 3, 1, 'individual', 2, 4400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(25, 25, 8, 1, 'group', 4, 12800000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(26, 26, 7, 1, 'individual', 2, 6400000.00, 'VND', 2, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(27, 27, 5, 1, 'individual', 2, 6400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(28, 28, 1, 1, 'individual', 2, 14400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(29, 29, 8, 1, 'group', 5, 36000000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online'),
(30, 30, 10, 1, 'individual', 2, 14400000.00, 'VND', 1, '2025-12-03 15:24:38', '2025-12-03 15:24:38', 'Booking online');

-- --------------------------------------------------------

--
-- Table structure for table `dia_diem`
--

CREATE TABLE `dia_diem` (
  `dia_diem_id` int NOT NULL,
  `ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `quoc_gia_id` int DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dia_diem`
--

INSERT INTO `dia_diem` (`dia_diem_id`, `ten`, `mo_ta`, `quoc_gia_id`, `ngay_tao`) VALUES
(1, 'Hà Nội', 'Thủ đô ngàn năm văn hiến với 36 phố phường cổ kính', 1, '2025-12-03 15:24:38'),
(2, 'Hạ Long', 'Di sản thiên nhiên thế giới với vịnh biển kỳ vĩ', 1, '2025-12-03 15:24:38'),
(3, 'Sapa', 'Thị trấn miền núi với ruộng bậc thang tuyệt đẹp', 1, '2025-12-03 15:24:38'),
(4, 'Ninh Bình', 'Vịnh Hạ Long trên cạn với phong cảnh thơ mộng', 1, '2025-12-03 15:24:38'),
(5, 'Huế', 'Cố đô với kiến trúc cung đình và ẩm thực đặc sắc', 1, '2025-12-03 15:24:38'),
(6, 'Đà Nẵng', 'Thành phố đáng sống với bãi biển đẹp và cầu Rồng', 1, '2025-12-03 15:24:38'),
(7, 'Hội An', 'Phố cổ di sản UNESCO với đèn lồng rực rỡ', 1, '2025-12-03 15:24:38'),
(8, 'Nha Trang', 'Thành phố biển với làn nước trong xanh', 1, '2025-12-03 15:24:38'),
(9, 'Đà Lạt', 'Thành phố ngàn hoa với khí hậu mát mẻ quanh năm', 1, '2025-12-03 15:24:38'),
(10, 'TP.HCM', 'Thành phố năng động với ẩm thực đường phố phong phú', 1, '2025-12-03 15:24:38'),
(11, 'Cần Thơ', 'Trung tâm đồng bằng sông Cửu Long với chợ nổi độc đáo', 1, '2025-12-03 15:24:38'),
(12, 'Phú Quốc', 'Đảo ngọc với bãi biển hoang sơ và hải sản tươi ngon', 1, '2025-12-03 15:24:38'),
(13, 'Bangkok', 'Thủ đô sôi động với chùa Vàng và chợ đêm', 2, '2025-12-03 15:24:38'),
(14, 'Phuket', 'Hòn đảo nghỉ dưỡng nổi tiếng với bãi Patong', 2, '2025-12-03 15:24:38'),
(15, 'Chiang Mai', 'Thành phố cổ kính với chùa chiền và làng thủ công', 2, '2025-12-03 15:24:38'),
(16, 'Singapore', 'Đảo quốc hiện đại với Gardens by the Bay', 3, '2025-12-03 15:24:38'),
(17, 'Tokyo', 'Thủ đô Nhật Bản với sự kết hợp truyền thống và hiện đại', 4, '2025-12-03 15:24:38'),
(18, 'Osaka', 'Thành phố ẩm thực với lâu đài và khu phố sầm uất', 4, '2025-12-03 15:24:38'),
(19, 'Seoul', 'Thủ đô Hàn Quốc với cung điện và văn hóa K-pop', 5, '2025-12-03 15:24:38'),
(20, 'Busan', 'Thành phố cảng với chợ hải sản và làng văn hóa Gamcheon', 5, '2025-12-03 15:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `dia_diem_lich_trinh`
--

CREATE TABLE `dia_diem_lich_trinh` (
  `dia_diem_lich_id` int NOT NULL,
  `lich_trinh_id` int NOT NULL,
  `dia_diem_id` int NOT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thu_tu` int NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dia_diem_lich_trinh`
--

INSERT INTO `dia_diem_lich_trinh` (`dia_diem_lich_id`, `lich_trinh_id`, `dia_diem_id`, `mo_ta`, `thu_tu`) VALUES
(1, 1, 1, 'Tham quan Văn Miếu Quốc Tử Giám', 1),
(2, 2, 2, 'Tham quan vịnh Hạ Long', 2),
(3, 3, 3, 'Khám phá ruộng bậc thang Sapa', 1),
(4, 4, 3, 'Đi bộ qua các bản làng dân tộc', 2),
(5, 5, 6, 'Tham quan bán đảo Sơn Trà', 1),
(6, 6, 7, 'Khám phá phố cổ Hội An', 2),
(7, 7, 10, 'Tham quan Bến Nhà Rồng', 1),
(8, 8, 12, 'Tắm biển Bãi Sao', 2),
(9, 9, 10, 'Xuất phát từ TP.HCM', 1),
(10, 10, 13, 'Tham quan chùa Vàng Bangkok', 2);

-- --------------------------------------------------------

--
-- Table structure for table `dia_diem_tour`
--

CREATE TABLE `dia_diem_tour` (
  `dia_diem_tour_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `dia_diem_id` int DEFAULT NULL,
  `thu_tu` int DEFAULT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dia_diem_tour`
--

INSERT INTO `dia_diem_tour` (`dia_diem_tour_id`, `tour_id`, `dia_diem_id`, `thu_tu`, `ghi_chu`) VALUES
(1, 1, 1, 1, 'Điểm khởi hành'),
(2, 1, 2, 2, 'Điểm đến chính'),
(3, 2, 1, 1, 'Điểm khởi hành'),
(4, 2, 3, 2, 'Điểm đến Sapa'),
(5, 10, 10, 1, 'Khởi hành từ TP.HCM'),
(6, 10, 12, 2, 'Đến Phú Quốc'),
(7, 11, 10, 1, 'Khởi hành từ TP.HCM'),
(8, 11, 13, 2, 'Đến Bangkok');

-- --------------------------------------------------------

--
-- Table structure for table `dich_vu_ncc`
--

CREATE TABLE `dich_vu_ncc` (
  `dich_vu_id` int NOT NULL,
  `ncc_id` int DEFAULT NULL,
  `loai_dich_vu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ma` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gia_mac_dinh` decimal(15,2) DEFAULT NULL,
  `don_vi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dich_vu_ncc`
--

INSERT INTO `dich_vu_ncc` (`dich_vu_id`, `ncc_id`, `loai_dich_vu`, `ma`, `mo_ta`, `gia_mac_dinh`, `don_vi`) VALUES
(1, 1, 'transport', 'DV001', 'Xe 45 chỗ có điều hòa, WiFi', 5000000.00, 'per trip'),
(2, 1, 'transport', 'DV002', 'Xe 16 chỗ limousine cao cấp', 3500000.00, 'per trip'),
(3, 2, 'hotel', 'DV003', 'Phòng Superior 2 người, view biển', 1500000.00, 'per room/night'),
(4, 2, 'hotel', 'DV004', 'Phòng Deluxe 2 người, view biển + ban công', 2000000.00, 'per room/night'),
(5, 3, 'catering', 'DV005', 'Set ăn trưa buffet hải sản', 200000.00, 'per pax'),
(6, 3, 'catering', 'DV006', 'Set ăn tối cao cấp', 300000.00, 'per pax'),
(7, 4, 'guide', 'DV007', 'Hướng dẫn viên tiếng Việt', 800000.00, 'per day'),
(8, 4, 'guide', 'DV008', 'Hướng dẫn viên tiếng Anh', 1200000.00, 'per day'),
(9, 5, 'ticket', 'DV009', 'Vé VinWonders Phú Quốc', 600000.00, 'per pax'),
(10, 5, 'ticket', 'DV010', 'Vé Safari Phú Quốc', 500000.00, 'per pax');

-- --------------------------------------------------------

--
-- Table structure for table `diem_danh_khach`
--

CREATE TABLE `diem_danh_khach` (
  `diem_danh_id` int NOT NULL,
  `hanh_khach_id` int NOT NULL,
  `lich_trinh_id` int NOT NULL,
  `dia_diem_id` int DEFAULT NULL,
  `hdv_id` int NOT NULL,
  `da_den` tinyint(1) NOT NULL DEFAULT 0,
  `thoi_gian` datetime NOT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diem_danh_khach`
--

INSERT INTO `diem_danh_khach` (`diem_danh_id`, `hanh_khach_id`, `lich_trinh_id`, `dia_diem_id`, `hdv_id`, `da_den`, `thoi_gian`, `ghi_chu`) VALUES
(1, 1, 1, 1, 1, 1, '2025-12-05 08:00:00', 'Khách đến đúng giờ'),
(2, 2, 1, 1, 1, 1, '2025-12-05 08:05:00', 'Khách đến đúng giờ'),
(3, 3, 2, 2, 2, 1, '2025-12-10 07:30:00', 'Khách đến sớm'),
(4, 4, 2, 2, 2, 1, '2025-12-10 07:35:00', 'Khách đến đúng giờ'),
(5, 8, 3, 6, 3, 1, '2025-12-15 08:00:00', 'Khách đi đúng lịch trình'),
(6, 9, 3, 6, 3, 0, '2025-12-15 08:10:00', 'Khách đến muộn 10 phút'),
(7, 15, 5, 10, 4, 1, '2025-12-18 09:00:00', 'Khách háo hức tham quan'),
(8, 16, 5, 10, 4, 1, '2025-12-18 09:00:00', 'Khách đi đầy đủ'),
(9, 19, 6, 7, 5, 1, '2025-12-20 08:30:00', 'Khách yêu thích Hội An'),
(10, 20, 6, 7, 5, 1, '2025-12-20 08:35:00', 'Khách hài lòng');

-- --------------------------------------------------------

--
-- Table structure for table `gia_dv`
--

CREATE TABLE `gia_dv` (
  `lich_ncc_id` int NOT NULL,
  `lich_id` int NOT NULL,
  `dich_vu_id` int NOT NULL,
  `gia` decimal(15,2) NOT NULL,
  `da_xac_nhan` tinyint(1) NOT NULL DEFAULT 0,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gia_dv`
--

INSERT INTO `gia_dv` (`lich_ncc_id`, `lich_id`, `dich_vu_id`, `gia`, `da_xac_nhan`, `ghi_chu`) VALUES
(1, 1, 1, 5000000.00, 1, 'Xe đã xác nhận cho tour Hà Nội - Hạ Long'),
(2, 1, 3, 1500000.00, 1, 'Khách sạn đã xác nhận'),
(3, 1, 5, 200000.00, 1, 'Ăn trưa buffet hải sản'),
(4, 2, 1, 5000000.00, 1, 'Xe 45 chỗ tour Sapa'),
(5, 2, 3, 1500000.00, 1, 'Khách sạn Sapa'),
(6, 2, 7, 800000.00, 1, 'HDV tiếng Việt'),
(7, 3, 1, 5000000.00, 1, 'Xe tour Hạ Long - Hà Nội'),
(8, 3, 3, 1500000.00, 1, 'Khách sạn view vịnh'),
(9, 4, 2, 3500000.00, 1, 'Xe limousine cao cấp'),
(10, 4, 4, 2000000.00, 1, 'Phòng Deluxe'),
(11, 5, 2, 3500000.00, 1, 'Xe limousine Sapa'),
(12, 5, 4, 2000000.00, 1, 'Khách sạn Deluxe Sapa'),
(13, 6, 1, 5000000.00, 1, 'Xe tour Đà Nẵng'),
(14, 6, 3, 1500000.00, 1, 'Khách sạn Đà Nẵng'),
(15, 7, 1, 5000000.00, 1, 'Xe tour TP.HCM'),
(16, 7, 5, 200000.00, 1, 'Ăn trưa tại nhà hàng'),
(17, 8, 2, 3500000.00, 1, 'Xe limousine Phú Quốc'),
(18, 8, 9, 600000.00, 1, 'Vé VinWonders'),
(19, 9, 1, 5000000.00, 1, 'Xe tour Đà Lạt'),
(20, 9, 3, 1500000.00, 1, 'Khách sạn Đà Lạt'),
(21, 10, 1, 5000000.00, 1, 'Xe tour TP.HCM - Phú Quốc'),
(22, 10, 4, 2000000.00, 1, 'Phòng Deluxe Phú Quốc'),
(23, 10, 9, 600000.00, 1, 'Vé VinWonders Phú Quốc'),
(24, 11, 1, 5000000.00, 1, 'Xe tour Bangkok'),
(25, 11, 3, 1500000.00, 1, 'Khách sạn Bangkok'),
(26, 11, 8, 1200000.00, 1, 'HDV tiếng Anh'),
(27, 12, 2, 3500000.00, 1, 'Xe limousine Singapore'),
(28, 12, 4, 2000000.00, 1, 'Khách sạn Singapore'),
(29, 13, 1, 5000000.00, 1, 'Xe tour Phuket'),
(30, 13, 3, 1500000.00, 1, 'Khách sạn Phuket');

-- --------------------------------------------------------

--
-- Table structure for table `gia_lich_trinh`
--

CREATE TABLE `gia_lich_trinh` (
  `gia_lich_id` int NOT NULL,
  `lich_id` int DEFAULT NULL,
  `gia` decimal(15,2) DEFAULT NULL,
  `tien_te` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hieu_luc_tu` date DEFAULT NULL,
  `hieu_luc_den` date DEFAULT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gia_lich_trinh`
--

INSERT INTO `gia_lich_trinh` (`gia_lich_id`, `lich_id`, `gia`, `tien_te`, `hieu_luc_tu`, `hieu_luc_den`, `ghi_chu`) VALUES
(1, 1, 3500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(2, 2, 3500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(3, 3, 3500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(4, 4, 4200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(5, 5, 4200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(6, 6, 4200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(7, 7, 2800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(8, 8, 2800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(9, 9, 2800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(10, 10, 5200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(11, 11, 5200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(12, 12, 5200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(13, 13, 6500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(14, 14, 6500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(15, 15, 6500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(16, 16, 4800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(17, 17, 4800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(18, 18, 4800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(19, 19, 3800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(20, 20, 3800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(21, 21, 3800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(22, 22, 2200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(23, 23, 2200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(24, 24, 2200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(25, 25, 3200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(26, 26, 3200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(27, 27, 3200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(28, 28, 7200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(29, 29, 7200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(30, 30, 7200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(31, 31, 9500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(32, 32, 9500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(33, 33, 9500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(34, 34, 12500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(35, 35, 12500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(36, 36, 12500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(37, 37, 8800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(38, 38, 8800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(39, 39, 8800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(40, 40, 15800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(41, 41, 15800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(42, 42, 15800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(43, 43, 28500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(44, 44, 28500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(45, 45, 28500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(46, 46, 32000000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(47, 47, 32000000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(48, 48, 32000000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(49, 49, 18500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(50, 50, 18500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(51, 51, 18500000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(52, 52, 16800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(53, 53, 16800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(54, 54, 16800000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(55, 55, 15200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(56, 56, 15200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(57, 57, 15200000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(58, 58, 8900000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(59, 59, 8900000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng'),
(60, 60, 8900000.00, 'VND', '2025-12-03', '2026-06-03', 'Giá áp dụng 6 tháng');

-- --------------------------------------------------------

--
-- Table structure for table `hanh_khach_list`
--

CREATE TABLE `hanh_khach_list` (
  `hanh_khach_id` int NOT NULL,
  `dat_tour_id` int DEFAULT NULL,
  `ho_ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gioi_tinh` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cccd` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `so_ghe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hanh_khach_list`
--

INSERT INTO `hanh_khach_list` (`hanh_khach_id`, `dat_tour_id`, `ho_ten`, `gioi_tinh`, `cccd`, `so_dien_thoai`, `email`, `ngay_sinh`, `so_ghe`, `ghi_chu`) VALUES
(1, 1, 'Hoàng Văn An', 'Nam', '928361799672', '0975604025', 'an0@gmail.com', '1987-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(2, 1, 'Nguyễn Văn Phong', 'Nam', '169188860013', '0992812915', 'phong1@gmail.com', '1982-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(3, 2, 'Nguyễn Văn Hà', 'Nam', '848777910977', '0928831834', 'hà0@gmail.com', '1992-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(4, 2, 'Phạm Thị Em', 'Nam', '649933773296', '0987268308', 'em1@gmail.com', '1976-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(5, 2, 'Lê Văn Giang', 'Nam', '620806433900', '0952323062', 'giang2@gmail.com', '1995-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(6, 2, 'Trần Thị Cường', 'Nữ', '602117071018', '0962309840', 'cường3@gmail.com', '1976-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(7, 2, 'Nguyễn Văn Dung', 'Nữ', '639926921502', '0976861419', 'dung4@gmail.com', '1990-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(8, 3, 'Lê Văn Em', 'Nam', '533367952812', '0955108317', 'em0@gmail.com', '1975-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(9, 3, 'Trần Thị Giang', 'Nữ', '958261556758', '0979437676', 'giang1@gmail.com', '1973-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(10, 3, 'Phạm Thị Cường', 'Nữ', '378150592065', '0930903829', 'cường2@gmail.com', '1992-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(11, 3, 'Lê Văn Phong', 'Nam', '805049825044', '0950726048', 'phong3@gmail.com', '1998-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(12, 3, 'Trần Thị Cường', 'Nam', '447764892811', '0913364869', 'cường4@gmail.com', '1980-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(13, 4, 'Phạm Thị An', 'Nam', '983202611462', '0948430124', 'an0@gmail.com', '1994-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(14, 4, 'Hoàng Văn Hà', 'Nam', '851063095878', '0979264438', 'hà1@gmail.com', '1999-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(15, 5, 'Phạm Thị Dung', 'Nam', '697521827957', '0936858430', 'dung0@gmail.com', '1965-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(16, 5, 'Lê Văn Cường', 'Nam', '600051178430', '0917850498', 'cường1@gmail.com', '1987-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(17, 5, 'Trần Thị Phong', 'Nữ', '328459493113', '0912655933', 'phong2@gmail.com', '1998-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(18, 5, 'Phạm Thị Em', 'Nữ', '248779035518', '0927676909', 'em3@gmail.com', '2002-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(19, 6, 'Hoàng Văn An', 'Nữ', '590914039678', '0933893825', 'an0@gmail.com', '1997-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(20, 6, 'Lê Văn Bình', 'Nam', '166010022120', '0967363126', 'bình1@gmail.com', '1979-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(21, 6, 'Trần Thị Phong', 'Nam', '893170711161', '0972779207', 'phong2@gmail.com', '1972-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(22, 6, 'Trần Thị Dung', 'Nam', '776276425997', '0964695148', 'dung3@gmail.com', '1990-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(23, 6, 'Hoàng Văn Em', 'Nữ', '394765326004', '0953798136', 'em4@gmail.com', '1973-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(24, 7, 'Phạm Thị Em', 'Nữ', '901901500381', '0942962966', 'em0@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(25, 7, 'Trần Thị Hà', 'Nữ', '380496699071', '0914103945', 'hà1@gmail.com', '1989-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(26, 7, 'Phạm Thị Dung', 'Nam', '557593512857', '0926958152', 'dung2@gmail.com', '1979-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(27, 8, 'Phạm Thị Dung', 'Nữ', '980670217032', '0973435988', 'dung0@gmail.com', '1967-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(28, 8, 'Phạm Thị An', 'Nam', '131718050226', '0998113803', 'an1@gmail.com', '1977-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(29, 8, 'Phạm Thị Giang', 'Nam', '165649275798', '0912384936', 'giang2@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(30, 8, 'Lê Văn Dung', 'Nữ', '348865401392', '0988080913', 'dung3@gmail.com', '1967-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(31, 9, 'Lê Văn An', 'Nam', '461718580111', '0943193071', 'an0@gmail.com', '2002-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(32, 9, 'Trần Thị Hà', 'Nam', '562479867352', '0915496840', 'hà1@gmail.com', '2003-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(33, 9, 'Trần Thị Phong', 'Nam', '554858470957', '0973815538', 'phong2@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(34, 10, 'Phạm Thị Giang', 'Nữ', '704559723061', '0937409384', 'giang0@gmail.com', '2000-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(35, 10, 'Hoàng Văn Em', 'Nữ', '552610328247', '0997120103', 'em1@gmail.com', '1997-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(36, 10, 'Nguyễn Văn Phong', 'Nữ', '585772932228', '0956975453', 'phong2@gmail.com', '1981-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(37, 10, 'Trần Thị Cường', 'Nam', '446786925134', '0912908629', 'cường3@gmail.com', '1978-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(38, 11, 'Phạm Thị Dung', 'Nam', '488371847481', '0952675008', 'dung0@gmail.com', '1976-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(39, 11, 'Hoàng Văn Bình', 'Nam', '835639628200', '0914560018', 'bình1@gmail.com', '1972-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(40, 11, 'Lê Văn Cường', 'Nam', '496091513027', '0991407602', 'cường2@gmail.com', '1976-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(41, 11, 'Nguyễn Văn Cường', 'Nam', '882493441076', '0926254613', 'cường3@gmail.com', '1986-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(42, 11, 'Phạm Thị Phong', 'Nữ', '165353627840', '0944724304', 'phong4@gmail.com', '1976-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(43, 12, 'Nguyễn Văn Em', 'Nam', '235864787853', '0941424973', 'em0@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(44, 12, 'Nguyễn Văn Giang', 'Nam', '272143027102', '0923302837', 'giang1@gmail.com', '1983-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(45, 12, 'Hoàng Văn Phong', 'Nam', '899718737365', '0941678373', 'phong2@gmail.com', '1989-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(46, 13, 'Lê Văn An', 'Nữ', '249185916311', '0966101563', 'an0@gmail.com', '2000-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(47, 13, 'Nguyễn Văn Cường', 'Nữ', '961254900710', '0933978773', 'cường1@gmail.com', '1985-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(48, 13, 'Trần Thị Em', 'Nữ', '428226544430', '0933366331', 'em2@gmail.com', '1999-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(49, 13, 'Lê Văn Giang', 'Nữ', '966347342376', '0911974531', 'giang3@gmail.com', '1991-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(50, 14, 'Nguyễn Văn Dung', 'Nữ', '928953061652', '0978111992', 'dung0@gmail.com', '1993-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(51, 14, 'Nguyễn Văn Cường', 'Nam', '345193326393', '0917722642', 'cường1@gmail.com', '1969-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(52, 14, 'Hoàng Văn Giang', 'Nam', '820599483916', '0945393434', 'giang2@gmail.com', '2003-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(53, 14, 'Trần Thị Cường', 'Nữ', '971837486614', '0987893032', 'cường3@gmail.com', '1976-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(54, 15, 'Nguyễn Văn Dung', 'Nam', '628686449193', '0974451050', 'dung0@gmail.com', '1968-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(55, 15, 'Lê Văn An', 'Nữ', '789080722030', '0950313011', 'an1@gmail.com', '1983-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(56, 15, 'Lê Văn Giang', 'Nam', '466482688837', '0975435722', 'giang2@gmail.com', '1975-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(57, 15, 'Phạm Thị Cường', 'Nữ', '306787938065', '0932886810', 'cường3@gmail.com', '1965-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(58, 15, 'Lê Văn Bình', 'Nam', '214719588479', '0940375547', 'bình4@gmail.com', '1966-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(59, 16, 'Trần Thị Hà', 'Nam', '595233331828', '0998688121', 'hà0@gmail.com', '1973-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(60, 16, 'Nguyễn Văn Em', 'Nữ', '262254580143', '0960880409', 'em1@gmail.com', '2005-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(61, 16, 'Trần Thị Dung', 'Nữ', '496208001058', '0963139646', 'dung2@gmail.com', '1972-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(62, 16, 'Lê Văn Hà', 'Nữ', '383058286735', '0935158638', 'hà3@gmail.com', '1974-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(63, 17, 'Trần Thị Bình', 'Nữ', '342704285906', '0950701325', 'bình0@gmail.com', '1977-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(64, 17, 'Phạm Thị Em', 'Nữ', '992211489727', '0996831681', 'em1@gmail.com', '1978-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(65, 17, 'Hoàng Văn Hà', 'Nữ', '767157283870', '0918046711', 'hà2@gmail.com', '1966-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(66, 18, 'Trần Thị Giang', 'Nam', '884814050702', '0917691383', 'giang0@gmail.com', '1966-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(67, 18, 'Lê Văn Phong', 'Nữ', '526329318823', '0959632803', 'phong1@gmail.com', '1996-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(68, 18, 'Lê Văn Bình', 'Nam', '179186235564', '0917573254', 'bình2@gmail.com', '1998-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(69, 18, 'Lê Văn Hà', 'Nam', '155157240671', '0955291990', 'hà3@gmail.com', '1993-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(70, 19, 'Phạm Thị Giang', 'Nữ', '798759875144', '0959198990', 'giang0@gmail.com', '2003-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(71, 19, 'Phạm Thị Cường', 'Nam', '251798987417', '0938736509', 'cường1@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(72, 19, 'Lê Văn Giang', 'Nữ', '470236643915', '0924872372', 'giang2@gmail.com', '1993-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(73, 20, 'Nguyễn Văn An', 'Nữ', '439568956671', '0968718672', 'an0@gmail.com', '1995-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(74, 20, 'Hoàng Văn Phong', 'Nam', '603230109396', '0983501458', 'phong1@gmail.com', '1985-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(75, 20, 'Nguyễn Văn Hà', 'Nữ', '355549293152', '0943918626', 'hà2@gmail.com', '1965-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(76, 20, 'Lê Văn Dung', 'Nữ', '332770366923', '0938718644', 'dung3@gmail.com', '1976-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(77, 20, 'Lê Văn Em', 'Nam', '916125480090', '0917082235', 'em4@gmail.com', '2005-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(78, 21, 'Phạm Thị Phong', 'Nam', '655101487639', '0968064639', 'phong0@gmail.com', '1993-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(79, 21, 'Phạm Thị Em', 'Nữ', '833474204021', '0929175916', 'em1@gmail.com', '1994-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(80, 22, 'Nguyễn Văn Em', 'Nam', '295549549995', '0963529380', 'em0@gmail.com', '1996-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(81, 22, 'Trần Thị Em', 'Nam', '698628041176', '0975610089', 'em1@gmail.com', '2002-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(82, 23, 'Trần Thị Cường', 'Nữ', '846068218730', '0983456566', 'cường0@gmail.com', '1998-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(83, 23, 'Trần Thị Cường', 'Nữ', '668944618215', '0935888749', 'cường1@gmail.com', '1991-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(84, 24, 'Hoàng Văn An', 'Nữ', '674696447234', '0913824821', 'an0@gmail.com', '1998-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(85, 24, 'Phạm Thị Dung', 'Nữ', '523842305220', '0966201556', 'dung1@gmail.com', '1974-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(86, 25, 'Nguyễn Văn Giang', 'Nữ', '314531906667', '0975377674', 'giang0@gmail.com', '2005-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(87, 25, 'Trần Thị An', 'Nam', '726152472695', '0991895230', 'an1@gmail.com', '1997-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(88, 25, 'Lê Văn Giang', 'Nam', '637048462237', '0933231800', 'giang2@gmail.com', '1965-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(89, 25, 'Lê Văn Giang', 'Nữ', '952777538391', '0942894198', 'giang3@gmail.com', '1971-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(90, 26, 'Nguyễn Văn An', 'Nữ', '264049628713', '0916688888', 'an0@gmail.com', '2003-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(91, 26, 'Lê Văn Hà', 'Nữ', '897642512670', '0994762596', 'hà1@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(92, 27, 'Lê Văn Phong', 'Nữ', '849868412074', '0986788044', 'phong0@gmail.com', '1979-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(93, 27, 'Hoàng Văn Giang', 'Nữ', '144457833557', '0977828993', 'giang1@gmail.com', '1979-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(94, 28, 'Nguyễn Văn Cường', 'Nam', '835807416094', '0967116540', 'cường0@gmail.com', '1981-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(95, 28, 'Lê Văn Bình', 'Nam', '380977072730', '0971851148', 'bình1@gmail.com', '1984-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(96, 29, 'Nguyễn Văn Hà', 'Nam', '202156289573', '0999804940', 'hà0@gmail.com', '2000-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(97, 29, 'Phạm Thị Phong', 'Nữ', '809496355623', '0974513104', 'phong1@gmail.com', '1975-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(98, 29, 'Phạm Thị Hà', 'Nam', '283242772805', '0931212902', 'hà2@gmail.com', '1966-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(99, 29, 'Trần Thị Em', 'Nữ', '418843007394', '0932472814', 'em3@gmail.com', '1986-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(100, 29, 'Nguyễn Văn An', 'Nữ', '940021228055', '0936075434', 'an4@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(101, 30, 'Hoàng Văn Em', 'Nam', '153057501705', '0928832800', 'em0@gmail.com', '2001-12-03', 'A1', 'Không có ghi chú đặc biệt'),
(102, 30, 'Phạm Thị Cường', 'Nam', '452202894500', '0990548446', 'cường1@gmail.com', '1996-12-03', 'A102', 'Không có ghi chú đặc biệt');

-- --------------------------------------------------------

--
-- Table structure for table `hinh_anh_dia_diem`
--

CREATE TABLE `hinh_anh_dia_diem` (
  `hinh_id` int NOT NULL,
  `dia_diem_id` int NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thu_tu` int NOT NULL DEFAULT 1,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hinh_anh_dia_diem`
--

INSERT INTO `hinh_anh_dia_diem` (`hinh_id`, `dia_diem_id`, `url`, `alt_text`, `thu_tu`, `ghi_chu`) VALUES
(1, 1, 'uploads/dia_diem/hanoi_hokiem.jpg', 'Hồ Hoàn Kiếm Hà Nội', 1, 'Ảnh chụp từ cầu Thê Húc'),
(2, 1, 'uploads/dia_diem/hanoi_vănmieu.jpg', 'Văn Miếu Quốc Tử Giám', 2, 'Di tích lịch sử văn hóa'),
(3, 2, 'uploads/dia_diem/halong_vinh.jpg', 'Vịnh Hạ Long', 1, 'Di sản thiên nhiên thế giới'),
(4, 2, 'uploads/dia_diem/halong_dongthiencung.jpg', 'Động Thiên Cung', 2, 'Động đẹp nhất Hạ Long'),
(5, 3, 'uploads/dia_diem/sapa_ruongbacthang.jpg', 'Ruộng bậc thang Sapa', 1, 'Ảnh chụp vào mùa lúa chín'),
(6, 3, 'uploads/dia_diem/sapa_fansipan.jpg', 'Đỉnh Fansipan', 2, 'Nóc nhà Đông Dương'),
(7, 6, 'uploads/dia_diem/danang_cauRong.jpg', 'Cầu Rồng Đà Nẵng', 1, 'Cầu biểu tượng của thành phố'),
(8, 6, 'uploads/dia_diem/danang_banahill.jpg', 'Bà Nà Hills', 2, 'Khu du lịch trên núi'),
(9, 7, 'uploads/dia_diem/hoian_phoco.jpg', 'Phố cổ Hội An', 1, 'Di sản UNESCO'),
(10, 7, 'uploads/dia_diem/hoian_denlong.jpg', 'Đêm đèn lồng Hội An', 2, 'Cảnh đẹp về đêm'),
(11, 8, 'uploads/dia_diem/nhatrang_bien.jpg', 'Bãi biển Nha Trang', 1, 'Bãi biển đẹp nhất Việt Nam'),
(12, 9, 'uploads/dia_diem/dalat_hoaxuanhuong.jpg', 'Hồ Xuân Hương', 1, 'Trung tâm Đà Lạt'),
(13, 10, 'uploads/dia_diem/hcm_benNharong.jpg', 'Bến Nhà Rồng', 1, 'Di tích lịch sử'),
(14, 10, 'uploads/dia_diem/hcm_phoTay.jpg', 'Phố Tây Bùi Viện', 2, 'Khu vui chơi sầm uất'),
(15, 12, 'uploads/dia_diem/phuquoc_baisao.jpg', 'Bãi Sao Phú Quốc', 1, 'Bãi biển đẹp nhất đảo ngọc'),
(16, 13, 'uploads/dia_diem/bangkok_chuavang.jpg', 'Chùa Vàng Bangkok', 1, 'Wat Phra Kaew'),
(17, 16, 'uploads/dia_diem/singapore_marinabay.jpg', 'Marina Bay Sands', 1, 'Biểu tượng Singapore'),
(18, 17, 'uploads/dia_diem/tokyo_tower.jpg', 'Tokyo Tower', 1, 'Tháp biểu tượng Tokyo'),
(19, 19, 'uploads/dia_diem/seoul_cungdien.jpg', 'Cung điện Gyeongbokgung', 1, 'Cung điện hoàng gia Seoul'),
(20, 20, 'uploads/dia_diem/busan_gamcheon.jpg', 'Làng văn hóa Gamcheon', 1, 'Làng Santorini của Hàn Quốc');

-- --------------------------------------------------------

--
-- Table structure for table `hop_dong`
--

CREATE TABLE `hop_dong` (
  `hop_dong_id` int NOT NULL,
  `dat_tour_id` int DEFAULT NULL,
  `ten_hop_dong` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_ky` datetime DEFAULT NULL,
  `ngay_hieu_luc` datetime DEFAULT NULL,
  `ngay_het_han` datetime DEFAULT NULL,
  `nguoi_ky_id` int DEFAULT NULL,
  `khach_hang_id` int DEFAULT NULL,
  `trang_thai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_hop_dong` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL,
  `ngay_cap_nhat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hop_dong`
--

INSERT INTO `hop_dong` (`hop_dong_id`, `dat_tour_id`, `ten_hop_dong`, `ngay_ky`, `ngay_hieu_luc`, `ngay_het_han`, `nguoi_ky_id`, `khach_hang_id`, `trang_thai`, `file_hop_dong`, `ghi_chu`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 1, 'Hợp đồng tour số 1', '2025-11-18 10:00:00', '2025-11-19 00:00:00', '2026-11-19 00:00:00', 1, 1, 'Đã ký', 'uploads/hop_dong/hd_1.pdf', 'Hợp đồng tour du lịch', '2025-11-18 10:00:00', '2025-12-03 00:00:00'),
(2, 2, 'Hợp đồng tour số 2', '2025-11-17 14:30:00', '2025-11-18 00:00:00', '2026-11-18 00:00:00', 1, 2, 'Đã ký', 'uploads/hop_dong/hd_2.pdf', 'Hợp đồng tour du lịch', '2025-11-17 14:30:00', '2025-12-03 00:00:00'),
(3, 3, 'Hợp đồng tour số 3', '2025-11-05 09:00:00', '2025-11-06 00:00:00', '2026-11-06 00:00:00', 1, 3, 'Đã ký', 'uploads/hop_dong/hd_3.pdf', 'Hợp đồng tour du lịch', '2025-11-05 09:00:00', '2025-12-03 00:00:00'),
(4, 4, 'Hợp đồng tour số 4', '2025-11-15 11:15:00', '2025-11-16 00:00:00', '2026-11-16 00:00:00', 1, 4, 'Chờ ký', 'uploads/hop_dong/hd_4.pdf', 'Hợp đồng tour du lịch', '2025-11-15 11:15:00', '2025-12-03 00:00:00'),
(5, 5, 'Hợp đồng tour số 5', '2025-11-11 15:45:00', '2025-11-12 00:00:00', '2026-11-12 00:00:00', 1, 5, 'Đã ký', 'uploads/hop_dong/hd_5.pdf', 'Hợp đồng tour du lịch', '2025-11-11 15:45:00', '2025-12-03 00:00:00'),
(6, 6, 'Hợp đồng tour số 6', '2025-11-21 08:30:00', '2025-11-22 00:00:00', '2026-11-22 00:00:00', 1, 6, 'Đã ký', 'uploads/hop_dong/hd_6.pdf', 'Hợp đồng tour du lịch', '2025-11-21 08:30:00', '2025-12-03 00:00:00'),
(7, 7, 'Hợp đồng tour số 7', '2025-11-12 13:20:00', '2025-11-13 00:00:00', '2026-11-13 00:00:00', 1, 7, 'Chờ ký', 'uploads/hop_dong/hd_7.pdf', 'Hợp đồng tour du lịch', '2025-11-12 13:20:00', '2025-12-03 00:00:00'),
(8, 8, 'Hợp đồng tour số 8', '2025-11-17 10:00:00', '2025-11-18 00:00:00', '2026-11-18 00:00:00', 1, 8, 'Đã ký', 'uploads/hop_dong/hd_8.pdf', 'Hợp đồng tour du lịch', '2025-11-17 10:00:00', '2025-12-03 00:00:00'),
(9, 9, 'Hợp đồng tour số 9', '2025-11-04 16:00:00', '2025-11-05 00:00:00', '2026-11-05 00:00:00', 1, 9, 'Đã ký', 'uploads/hop_dong/hd_9.pdf', 'Hợp đồng tour du lịch', '2025-11-04 16:00:00', '2025-12-03 00:00:00'),
(10, 10, 'Hợp đồng tour số 10', '2025-11-17 09:30:00', '2025-11-18 00:00:00', '2026-11-18 00:00:00', 1, 10, 'Đã ký', 'uploads/hop_dong/hd_10.pdf', 'Hợp đồng tour du lịch', '2025-11-17 09:30:00', '2025-12-03 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `huong_dan_vien`
--

CREATE TABLE `huong_dan_vien` (
  `hdv_id` int NOT NULL,
  `nguoi_dung_id` int DEFAULT NULL,
  `ho_ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kinh_nghiem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngon_ngu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `huong_dan_vien`
--

INSERT INTO `huong_dan_vien` (`hdv_id`, `nguoi_dung_id`, `ho_ten`, `so_dien_thoai`, `email`, `kinh_nghiem`, `ngon_ngu`, `ngay_tao`) VALUES
(1, 2, 'Nguyễn Văn Hùng', '0909000002', 'guide1@travel.com', '5 năm dẫn tour miền Bắc và Trung', 'Việt, Anh, Trung', '2025-11-13 21:06:04'),
(2, 3, 'Trần Thị Linh', '0909000003', 'guide2@travel.com', '7 năm dẫn tour quốc tế', 'Việt, Anh, Hàn, Nhật', '2025-11-13 21:06:04'),
(3, 4, 'Lê Minh Tuấn', '0909000004', 'guide3@travel.com', '4 năm dẫn tour miền Nam và Tây Nguyên', 'Việt, Anh, Pháp', '2025-11-15 08:20:15'),
(4, 5, 'Phạm Thu Hà', '0909000005', 'guide4@travel.com', '6 năm dẫn tour Châu Âu', 'Việt, Anh, Đức, Pháp', '2025-11-16 09:30:22'),
(5, 6, 'Hoàng Đức Anh', '0909000006', 'guide5@travel.com', '3 năm dẫn tour Đông Nam Á', 'Việt, Anh, Thái', '2025-11-18 10:15:30'),
(6, 7, 'Đặng Thị Mai', '0909000007', 'guide6@travel.com', '8 năm dẫn tour Châu Á', 'Việt, Anh, Hàn, Nhật, Trung', '2025-11-20 14:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `khach_hang_id` int NOT NULL,
  `ho_ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cccd` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dia_chi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`khach_hang_id`, `ho_ten`, `so_dien_thoai`, `email`, `cccd`, `dia_chi`, `ngay_tao`) VALUES
(1, 'Nguyễn Văn An', '0911111111', 'nguyenvanan@gmail.com', '001234567890', 'Quận 1, TP.HCM', '2025-12-03 15:24:38'),
(2, 'Trần Thị Bình', '0922222222', 'tranbinhthi@gmail.com', '002345678901', 'Quận 3, TP.HCM', '2025-12-03 15:24:38'),
(3, 'Lê Hoàng Cường', '0933333333', 'lehoangcuong@gmail.com', '003456789012', 'Ba Đình, Hà Nội', '2025-12-03 15:24:38'),
(4, 'Phạm Thu Dung', '0944444444', 'phamthudung@gmail.com', '004567890123', 'Đống Đa, Hà Nội', '2025-12-03 15:24:38'),
(5, 'Hoàng Minh Duy', '0955555555', 'hoangminhduy@yahoo.com', '005678901234', 'Hải Châu, Đà Nẵng', '2025-12-03 15:24:38'),
(6, 'Vũ Thị Hoa', '0966666666', 'vuthihoa@outlook.com', '006789012345', 'Sơn Trà, Đà Nẵng', '2025-12-03 15:24:38'),
(7, 'Đặng Quốc Hưng', '0977777777', 'dangquochung@gmail.com', '007890123456', 'Nha Trang, Khánh Hòa', '2025-12-03 15:24:38'),
(8, 'Ngô Lan Anh', '0988888888', 'ngolanhanh@gmail.com', '008901234567', 'Đà Lạt, Lâm Đồng', '2025-12-03 15:24:38'),
(9, 'Bùi Văn Khôi', '0999999999', 'buivankhoi@gmail.com', '009012345678', 'Huế, Thừa Thiên Huế', '2025-12-03 15:24:38'),
(10, 'Đinh Thị Lan', '0900000000', 'dinhthilan@gmail.com', '010123456789', 'Cần Thơ, Cần Thơ', '2025-12-03 15:24:38');

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
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lich_khoi_hanh`
--

INSERT INTO `lich_khoi_hanh` (`lich_id`, `tour_id`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai_id`, `ngay_tao`, `ghi_chu`) VALUES
(1, 1, '2025-12-23', '2025-12-26', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(2, 1, '2026-01-15', '2026-01-18', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(3, 1, '2026-02-18', '2026-02-21', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(4, 2, '2025-12-07', '2025-12-11', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(5, 2, '2026-01-22', '2026-01-26', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(6, 2, '2026-02-26', '2026-03-02', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(7, 3, '2025-12-24', '2025-12-26', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(8, 3, '2026-01-25', '2026-01-27', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(9, 3, '2026-02-12', '2026-02-14', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(10, 4, '2025-12-10', '2025-12-14', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(11, 4, '2026-01-15', '2026-01-19', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(12, 4, '2026-02-08', '2026-02-12', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(13, 5, '2025-12-06', '2025-12-11', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(14, 5, '2026-01-22', '2026-01-27', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(15, 5, '2026-02-10', '2026-02-15', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(16, 6, '2025-12-22', '2025-12-26', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(17, 6, '2026-01-08', '2026-01-12', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(18, 6, '2026-02-12', '2026-02-16', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(19, 7, '2025-12-14', '2025-12-17', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(20, 7, '2026-01-05', '2026-01-08', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(21, 7, '2026-03-02', '2026-03-05', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(22, 8, '2025-12-20', '2025-12-22', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(23, 8, '2026-01-31', '2026-02-02', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(24, 8, '2026-02-13', '2026-02-15', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(25, 9, '2025-12-28', '2025-12-31', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(26, 9, '2026-01-21', '2026-01-24', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(27, 9, '2026-02-07', '2026-02-10', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(28, 10, '2025-12-13', '2025-12-17', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(29, 10, '2026-01-19', '2026-01-23', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(30, 10, '2026-02-15', '2026-02-19', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(31, 11, '2025-12-04', '2025-12-09', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(32, 11, '2026-01-25', '2026-01-30', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(33, 11, '2026-02-23', '2026-02-28', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(34, 12, '2025-12-12', '2025-12-18', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(35, 12, '2026-01-11', '2026-01-17', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(36, 12, '2026-02-24', '2026-03-02', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(37, 13, '2025-12-11', '2025-12-16', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(38, 13, '2026-01-05', '2026-01-10', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(39, 13, '2026-03-02', '2026-03-07', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(40, 14, '2025-12-21', '2025-12-25', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(41, 14, '2026-01-12', '2026-01-16', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(42, 14, '2026-03-02', '2026-03-06', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(43, 15, '2025-12-04', '2025-12-10', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(44, 15, '2026-01-15', '2026-01-21', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(45, 15, '2026-03-02', '2026-03-08', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(46, 16, '2025-12-27', '2026-01-03', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(47, 16, '2026-01-11', '2026-01-18', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(48, 16, '2026-02-08', '2026-02-15', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(49, 17, '2025-12-27', '2026-01-02', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(50, 17, '2026-01-10', '2026-01-16', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(51, 17, '2026-02-26', '2026-03-04', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(52, 18, '2025-12-08', '2025-12-13', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(53, 18, '2026-01-19', '2026-01-24', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(54, 18, '2026-03-01', '2026-03-06', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(55, 19, '2025-12-11', '2025-12-16', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(56, 19, '2026-01-22', '2026-01-27', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(57, 19, '2026-02-26', '2026-03-03', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14'),
(58, 20, '2025-12-26', '2026-01-02', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 12'),
(59, 20, '2026-01-12', '2026-01-19', 1, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 13'),
(60, 20, '2026-02-08', '2026-02-15', 2, '2025-12-03 15:24:38', 'Lịch khởi hành tháng 14');

-- --------------------------------------------------------

--
-- Table structure for table `lich_trinh`
--

CREATE TABLE `lich_trinh` (
  `lich_trinh_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `ngay_thu` int DEFAULT NULL,
  `gio_bat_dau` time DEFAULT NULL,
  `gio_ket_thuc` time DEFAULT NULL,
  `dia_diem_tour_id` int DEFAULT NULL,
  `noi_dung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lich_trinh`
--

INSERT INTO `lich_trinh` (`lich_trinh_id`, `tour_id`, `ngay_thu`, `gio_bat_dau`, `gio_ket_thuc`, `dia_diem_tour_id`, `noi_dung`) VALUES
(1, 1, 1, '08:00:00', '17:00:00', 1, 'Ngày 1: Tham quan Văn Miếu, Lăng Bác, Hồ Hoàn Kiếm, chùa Một Cột'),
(2, 1, 2, '06:00:00', '20:00:00', 2, 'Ngày 2: Khởi hành Hạ Long, du thuyền qua đêm, tham quan hang Thiên Cung'),
(3, 1, 3, '07:00:00', '18:00:00', 2, 'Ngày 3: Ngắm bình minh, tham quan làng chài, về Hà Nội'),
(4, 2, 1, '08:00:00', '18:00:00', 3, 'Ngày 1: Hà Nội - Sapa, tham quan thị trấn Sapa'),
(5, 2, 2, '07:00:00', '17:00:00', 4, 'Ngày 2: Chinh phục Fansipan bằng cáp treo, ngắm cảnh đỉnh núi'),
(6, 2, 3, '08:30:00', '16:30:00', 4, 'Ngày 3: Tham quan bản Cát Cát, thác Bạc, chợ tình Sapa'),
(7, 2, 4, '09:00:00', '19:00:00', 4, 'Ngày 4: Trekking ruộng bậc thang Mường Hoa, về Hà Nội'),
(8, 10, 1, '10:00:00', '15:00:00', 5, 'Ngày 1: TP.HCM - Phú Quốc, nghỉ ngơi, tự do khám phá đảo'),
(9, 10, 2, '08:00:00', '17:00:00', 6, 'Ngày 2: Cáp treo Hòn Thơm, lặn ngắm san hô, tắm biển'),
(10, 10, 3, '09:00:00', '20:00:00', 6, 'Ngày 3: VinWonders + Safari, Grand World, chợ đêm'),
(11, 10, 4, '08:30:00', '16:00:00', 6, 'Ngày 4: Làng chài Hàm Ninh, dinh Cậu, về TP.HCM'),
(12, 11, 1, '09:00:00', '18:00:00', 7, 'Ngày 1: TP.HCM - Bangkok, tham quan chùa Phật Vàng, Hoàng Cung'),
(13, 11, 2, '07:00:00', '19:00:00', 8, 'Ngày 2: Chợ nổi Damnoen Saduak, Pattaya, chợ đêm'),
(14, 11, 3, '08:00:00', '17:00:00', 8, 'Ngày 3: Vườn Nong Nooch, biểu diễn voi, tắm biển'),
(15, 11, 4, '09:00:00', '20:00:00', 8, 'Ngày 4: Show Alcazar, chùa Chân Lý, về Bangkok'),
(16, 11, 5, '10:00:00', '15:00:00', 8, 'Ngày 5: Mua sắm, về TP.HCM');

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `nguoi_dung_id` int NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mat_khau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ho_ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vai_tro_id` int DEFAULT NULL,
  `trang_thai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`nguoi_dung_id`, `email`, `mat_khau`, `ho_ten`, `so_dien_thoai`, `vai_tro_id`, `trang_thai`, `ngay_tao`) VALUES
(1, 'admin@travel.com', '$2y$10$g1ccPdOYlpI/ETl1C57wGOWdXF3dgWr8niG7hqrRIGoy9oODpaL62', 'Admin Nam', '0909999999', 1, 'active', '2025-11-13 21:06:04'),
(2, 'guide1@travel.com', '$2y$10$EyjiplcJMyg0.s5LP0tEIufC0wVr.e8rcpgYBMBPhGEzVbt.b3Emu', 'Nguyễn Văn Hùng', '0909000002', 2, 'active', '2025-11-13 21:06:04'),
(3, 'guide2@travel.com', '$2y$10$Y18LlOsf39D3hjqdkZ.DreOHBIspbjIzqulgMo3pT6tJ/tSk1l5iS', 'Trần Thị Linh', '0909000003', 2, 'active', '2025-11-13 21:06:04'),
(4, 'guide3@travel.com', '$2y$10$EyjiplcJMyg0.s5LP0tEIufC0wVr.e8rcpgYBMBPhGEzVbt.b3Emu', 'Lê Minh Tuấn', '0909000004', 2, 'active', '2025-11-15 08:20:15'),
(5, 'guide4@travel.com', '$2y$10$Y18LlOsf39D3hjqdkZ.DreOHBIspbjIzqulgMo3pT6tJ/tSk1l5iS', 'Phạm Thu Hà', '0909000005', 2, 'active', '2025-11-16 09:30:22'),
(6, 'guide5@travel.com', '$2y$10$EyjiplcJMyg0.s5LP0tEIufC0wVr.e8rcpgYBMBPhGEzVbt.b3Emu', 'Hoàng Đức Anh', '0909000006', 2, 'active', '2025-11-18 10:15:30'),
(7, 'guide6@travel.com', '$2y$10$Y18LlOsf39D3hjqdkZ.DreOHBIspbjIzqulgMo3pT6tJ/tSk1l5iS', 'Đặng Thị Mai', '0909000007', 2, 'active', '2025-11-20 14:25:45'),
(8, 'admin2@travel.com', '$2y$10$g1ccPdOYlpI/ETl1C57wGOWdXF3dgWr8niG7hqrRIGoy9oODpaL62', 'Võ Thị Hương', '0909888888', 1, 'active', '2025-11-22 16:10:20'),
(9, 'customer1@gmail.com', '$2y$10$EyjiplcJMyg0.s5LP0tEIufC0wVr.e8rcpgYBMBPhGEzVbt.b3Emu', 'Nguyễn Thị Lan', '0901234567', 3, 'active', '2025-11-25 08:00:00'),
(10, 'customer2@gmail.com', '$2y$10$Y18LlOsf39D3hjqdkZ.DreOHBIspbjIzqulgMo3pT6tJ/tSk1l5iS', 'Trần Văn Bình', '0902345678', 3, 'active', '2025-11-26 09:15:30'),
(11, 'customer3@gmail.com', '$2y$10$EyjiplcJMyg0.s5LP0tEIufC0wVr.e8rcpgYBMBPhGEzVbt.b3Emu', 'Lê Thị Hoa', '0903456789', 3, 'active', '2025-11-27 10:20:15'),
(17, 'luongdinhnam123abc@gmail.com', '$2y$10$ryxBuwzYLjwYwsM9JmyLwu2Yi2wKYL4wWSIlpKwNto/VJK4RByRI2', 'Lường Đình Nam', '0971596111', 1, 'active', '2025-12-02 21:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `nhat_ky_tour`
--

CREATE TABLE `nhat_ky_tour` (
  `nhat_ky_tour_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `hdv_id` int NOT NULL,
  `lich_id` int NOT NULL,
  `dia_diem_id` int NOT NULL,
  `anh_tour` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_thuc_hien` datetime NOT NULL,
  `noi_dung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhat_ky_tour`
--

INSERT INTO `nhat_ky_tour` (`nhat_ky_tour_id`, `tour_id`, `hdv_id`, `lich_id`, `dia_diem_id`, `anh_tour`, `ngay_thuc_hien`, `noi_dung`) VALUES
(1, 1, 1, 1, 1, 'uploads/nhatky/tour1_hanoi.jpg', '2025-12-05 08:30:00', 'Khởi hành từ Hà Nội, đoàn 45 người tham gia tour. Thời tiết đẹp, khách háo hức.'),
(2, 1, 1, 1, 2, 'uploads/nhatky/tour1_halong.jpg', '2025-12-06 10:00:00', 'Tham quan vịnh Hạ Long, khách rất hài lòng với cảnh đẹp. Chụp ảnh tại động Thiên Cung.'),
(3, 2, 2, 2, 3, 'uploads/nhatky/tour2_sapa.jpg', '2025-12-11 09:00:00', 'Đoàn đến Sapa, thời tiết se lạnh. Tham quan ruộng bậc thang, khách thích thú.'),
(4, 2, 2, 2, 3, 'uploads/nhatky/tour2_banlao.jpg', '2025-12-12 14:00:00', 'Trekking bản Lao Chải, khách trải nghiệm văn hóa dân tộc H`Mông.'),
(5, 3, 3, 3, 6, 'uploads/nhatky/tour3_danang.jpg', '2025-12-16 10:30:00', 'Tham quan Đà Nẵng, cầu Rồng, Bà Nà Hills. Khách rất thích cảnh đẹp.'),
(6, 10, 4, 10, 10, 'uploads/nhatky/tour10_hcm.jpg', '2025-12-25 08:00:00', 'Xuất phát từ TP.HCM đi Phú Quốc, 30 khách tham gia. Bay sáng, thời tiết đẹp.'),
(7, 10, 4, 10, 12, 'uploads/nhatky/tour10_phuquoc.jpg', '2025-12-26 11:00:00', 'Tham quan Hòn Thơm, lặn ngắm san hô. Khách rất hài lòng với biển đẹp.'),
(8, 10, 4, 10, 12, 'uploads/nhatky/tour10_vinwonders.jpg', '2025-12-27 09:30:00', 'Chơi tại VinWonders và Safari, trẻ em rất thích. Tối đi chợ đêm mua sắm.'),
(9, 11, 5, 11, 13, 'uploads/nhatky/tour11_bangkok.jpg', '2025-12-30 10:00:00', 'Đoàn đến Bangkok, tham quan chùa Phật Vàng và Hoàng Cung. Khách ấn tượng với kiến trúc.'),
(10, 11, 5, 11, 13, 'uploads/nhatky/tour11_pattaya.jpg', '2025-12-31 15:00:00', 'Di chuyển đến Pattaya, tắm biển và tham quan chợ đêm. Khách thích thú với không khí sôi động.');

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `ncc_id` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_he` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dia_chi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ma_so_thue` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`ncc_id`, `ten`, `lien_he`, `dia_chi`, `ma_so_thue`, `ngay_tao`) VALUES
(1, 'Công ty TNHH Vận Tải Du Lịch Sài Gòn', '0909123456 - saigontransport@gmail.com', '123 Điện Biên Phủ, Q.1, TP.HCM', '0102030405', '2025-12-03 15:24:38'),
(2, 'Khách sạn Sunrise Nha Trang', '0258 352 9999 - info@sunrise-nhatrang.vn', '12-14 Tôn Đản, Nha Trang', '0203040506', '2025-12-03 15:24:38'),
(3, 'Nhà hàng Hương Biển', '0909988776 - huongbien@seafood.vn', '56 Trần Phú, Nha Trang', '0304050607', '2025-12-03 15:24:38'),
(4, 'Công ty Du Lịch Hanoitourist', '024 3826 4154 - booking@hanoitourist.com.vn', '18 Lý Thường Kiệt, Hà Nội', '0405060708', '2025-12-03 15:24:38'),
(5, 'VinWonders Phú Quốc', '1900 23 23 32 - contact@vinwonders.com', 'Bãi Dài, Phú Quốc', '0506070809', '2025-12-03 15:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `phan_cong_hdv`
--

CREATE TABLE `phan_cong_hdv` (
  `phan_cong_id` int NOT NULL,
  `lich_id` int DEFAULT NULL,
  `hdv_id` int DEFAULT NULL,
  `vai_tro` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_phan_cong` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phan_cong_hdv`
--

INSERT INTO `phan_cong_hdv` (`phan_cong_id`, `lich_id`, `hdv_id`, `vai_tro`, `ngay_phan_cong`) VALUES
(1, 1, 1, 'main', '2025-12-01 08:00:00'),
(2, 1, 3, 'support', '2025-12-01 08:00:00'),
(3, 2, 2, 'main', '2025-12-01 09:15:00'),
(4, 2, 5, 'support', '2025-12-01 09:15:00'),
(5, 3, 3, 'main', '2025-12-01 10:30:00'),
(6, 3, 1, 'support', '2025-12-01 10:30:00'),
(7, 4, 4, 'main', '2025-12-01 11:45:00'),
(8, 4, 6, 'support', '2025-12-01 11:45:00'),
(9, 5, 5, 'main', '2025-12-01 13:00:00'),
(10, 5, 2, 'support', '2025-12-01 13:00:00'),
(11, 6, 6, 'main', '2025-12-01 14:15:00'),
(12, 6, 4, 'support', '2025-12-01 14:15:00'),
(13, 7, 1, 'main', '2025-12-01 15:30:00'),
(14, 7, 2, 'support', '2025-12-01 15:30:00'),
(15, 8, 2, 'main', '2025-12-01 16:45:00'),
(16, 8, 3, 'support', '2025-12-01 16:45:00'),
(17, 9, 3, 'main', '2025-12-02 08:00:00'),
(18, 9, 4, 'support', '2025-12-02 08:00:00'),
(19, 10, 4, 'main', '2025-12-02 09:15:00'),
(20, 10, 5, 'support', '2025-12-02 09:15:00'),
(21, 11, 5, 'main', '2025-12-02 10:30:00'),
(22, 11, 6, 'support', '2025-12-02 10:30:00'),
(23, 12, 6, 'main', '2025-12-02 11:45:00'),
(24, 12, 1, 'support', '2025-12-02 11:45:00'),
(25, 13, 1, 'main', '2025-12-02 13:00:00'),
(26, 14, 2, 'main', '2025-12-02 14:15:00'),
(27, 14, 3, 'support', '2025-12-02 14:15:00'),
(28, 15, 3, 'main', '2025-12-02 15:30:00'),
(29, 15, 4, 'support', '2025-12-02 15:30:00'),
(30, 16, 1, 'main', '2025-12-03 15:24:38'),
(31, 17, 2, 'main', '2025-12-03 15:24:38'),
(32, 18, 1, 'main', '2025-12-03 15:24:38'),
(33, 18, 2, 'support', '2025-12-03 15:24:38'),
(34, 19, 1, 'main', '2025-12-03 15:24:38'),
(35, 19, 2, 'support', '2025-12-03 15:24:38'),
(36, 20, 1, 'main', '2025-12-03 15:24:38'),
(37, 20, 2, 'support', '2025-12-03 15:24:38'),
(38, 21, 1, 'main', '2025-12-03 15:24:38'),
(39, 21, 2, 'support', '2025-12-03 15:24:38'),
(40, 22, 1, 'main', '2025-12-03 15:24:38'),
(41, 22, 2, 'support', '2025-12-03 15:24:38'),
(42, 23, 2, 'main', '2025-12-03 15:24:38'),
(43, 24, 1, 'main', '2025-12-03 15:24:38'),
(44, 24, 2, 'support', '2025-12-03 15:24:38'),
(45, 25, 2, 'main', '2025-12-03 15:24:38'),
(46, 26, 1, 'main', '2025-12-03 15:24:38'),
(47, 27, 1, 'main', '2025-12-03 15:24:38'),
(48, 27, 2, 'support', '2025-12-03 15:24:38'),
(49, 28, 2, 'main', '2025-12-03 15:24:38'),
(50, 29, 1, 'main', '2025-12-03 15:24:38'),
(51, 29, 2, 'support', '2025-12-03 15:24:38'),
(52, 30, 1, 'main', '2025-12-03 15:24:38'),
(53, 30, 2, 'support', '2025-12-03 15:24:38'),
(54, 31, 1, 'main', '2025-12-03 15:24:38'),
(55, 31, 2, 'support', '2025-12-03 15:24:38'),
(56, 32, 1, 'main', '2025-12-03 15:24:38'),
(57, 32, 2, 'support', '2025-12-03 15:24:38'),
(58, 33, 1, 'main', '2025-12-03 15:24:38'),
(59, 33, 2, 'support', '2025-12-03 15:24:38'),
(60, 34, 2, 'main', '2025-12-03 15:24:38'),
(61, 35, 1, 'main', '2025-12-03 15:24:38'),
(62, 35, 2, 'support', '2025-12-03 15:24:38'),
(63, 36, 1, 'main', '2025-12-03 15:24:38'),
(64, 36, 2, 'support', '2025-12-03 15:24:38'),
(65, 37, 1, 'main', '2025-12-03 15:24:38'),
(66, 37, 2, 'support', '2025-12-03 15:24:38'),
(67, 38, 1, 'main', '2025-12-03 15:24:38'),
(68, 38, 2, 'support', '2025-12-03 15:24:38'),
(69, 39, 2, 'main', '2025-12-03 15:24:38'),
(70, 40, 1, 'main', '2025-12-03 15:24:38'),
(71, 40, 2, 'support', '2025-12-03 15:24:38'),
(72, 41, 1, 'main', '2025-12-03 15:24:38'),
(73, 42, 1, 'main', '2025-12-03 15:24:38'),
(74, 42, 2, 'support', '2025-12-03 15:24:38'),
(75, 43, 1, 'main', '2025-12-03 15:24:38'),
(76, 43, 2, 'support', '2025-12-03 15:24:38'),
(77, 44, 2, 'main', '2025-12-03 15:24:38'),
(78, 45, 1, 'main', '2025-12-03 15:24:38'),
(79, 45, 2, 'support', '2025-12-03 15:24:38'),
(80, 46, 1, 'main', '2025-12-03 15:24:38'),
(81, 46, 2, 'support', '2025-12-03 15:24:38'),
(82, 47, 1, 'main', '2025-12-03 15:24:38'),
(83, 47, 2, 'support', '2025-12-03 15:24:38'),
(84, 48, 1, 'main', '2025-12-03 15:24:38'),
(85, 48, 2, 'support', '2025-12-03 15:24:38'),
(86, 49, 1, 'main', '2025-12-03 15:24:38'),
(87, 49, 2, 'support', '2025-12-03 15:24:38'),
(88, 50, 2, 'main', '2025-12-03 15:24:38'),
(89, 51, 1, 'main', '2025-12-03 15:24:38'),
(90, 51, 2, 'support', '2025-12-03 15:24:38'),
(91, 52, 1, 'main', '2025-12-03 15:24:38'),
(92, 52, 2, 'support', '2025-12-03 15:24:38'),
(93, 53, 1, 'main', '2025-12-03 15:24:38'),
(94, 54, 1, 'main', '2025-12-03 15:24:38'),
(95, 55, 2, 'main', '2025-12-03 15:24:38'),
(96, 56, 2, 'main', '2025-12-03 15:24:38'),
(97, 57, 1, 'main', '2025-12-03 15:24:38'),
(98, 57, 2, 'support', '2025-12-03 15:24:38'),
(99, 58, 1, 'main', '2025-12-03 15:24:38'),
(100, 58, 2, 'support', '2025-12-03 15:24:38'),
(101, 59, 1, 'main', '2025-12-03 15:24:38'),
(102, 59, 2, 'support', '2025-12-03 15:24:38'),
(103, 60, 1, 'main', '2025-12-03 15:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `phuong_tien_tour`
--

CREATE TABLE `phuong_tien_tour` (
  `phuong_tien_id` int NOT NULL,
  `tour_id` int DEFAULT NULL,
  `so_cho` int DEFAULT NULL,
  `so_cho_con_lai` int DEFAULT NULL,
  `ten_phuong_tien` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gia_phuong_tien` decimal(15,2) DEFAULT NULL,
  `noi_dung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phuong_tien_tour`
--

INSERT INTO `phuong_tien_tour` (`phuong_tien_id`, `tour_id`, `so_cho`, `so_cho_con_lai`, `ten_phuong_tien`, `gia_phuong_tien`, `noi_dung`) VALUES
(1, 1, 45, 12, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(2, 2, 45, 13, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(3, 3, 45, 30, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(4, 4, 45, 10, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(5, 5, 45, 26, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(6, 6, 45, 15, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(7, 7, 45, 19, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(8, 8, 45, 11, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(9, 9, 45, 22, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(10, 10, 45, 18, 'Xe 45 chỗ điều hòa', 5000000.00, 'Xe khách cao cấp, WiFi miễn phí'),
(11, 11, 150, 96, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(12, 12, 150, 93, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(13, 13, 150, 74, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(14, 14, 150, 73, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(15, 15, 150, 82, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(16, 16, 150, 52, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(17, 17, 150, 54, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(18, 18, 150, 70, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(19, 19, 150, 73, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg'),
(20, 20, 150, 87, 'Máy bay', 15000000.00, 'Vé máy bay khứ hồi, hành lý 23kg');

-- --------------------------------------------------------

--
-- Table structure for table `quoc_gia`
--

CREATE TABLE `quoc_gia` (
  `quoc_gia_id` int NOT NULL,
  `ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quoc_gia`
--

INSERT INTO `quoc_gia` (`quoc_gia_id`, `ten`, `mo_ta`) VALUES
(1, 'Việt Nam', 'Quốc gia Đông Nam Á với lịch sử lâu đời'),
(2, 'Thái Lan', 'Xứ sở chùa Vàng và đất nước của nụ cười'),
(3, 'Singapore', 'Quốc đảo sư tử hiện đại và xanh'),
(4, 'Nhật Bản', 'Đất nước mặt trời mọc với văn hóa độc đáo'),
(5, 'Hàn Quốc', 'Xứ sở kim chi với K-pop và công nghệ');

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `tour_id` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `danh_muc_id` int DEFAULT NULL,
  `mo_ta_ngan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gia_co_ban` decimal(15,2) DEFAULT NULL,
  `thoi_luong_mac_dinh` int DEFAULT NULL,
  `chinh_sach` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nguoi_tao_id` int DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL,
  `diem_khoi_hanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoat_dong` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`tour_id`, `ten`, `danh_muc_id`, `mo_ta_ngan`, `mo_ta`, `gia_co_ban`, `thoi_luong_mac_dinh`, `chinh_sach`, `nguoi_tao_id`, `ngay_tao`, `diem_khoi_hanh`, `hoat_dong`) VALUES
(1, 'Tour Hà Nội - Hạ Long 3N2Đ', 1, 'Khám phá Thủ đô và Di sản Vịnh Hạ Long', 'Tham quan Văn Miếu, Lăng Bác, Hồ Hoàn Kiếm. Du thuyền qua đêm Vịnh Hạ Long.', 3500000.00, 3, 'Hủy trước 7 ngày hoàn 80%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(2, 'Tour Sapa - Fansipan 4N3Đ', 1, 'Chinh phục nóc nhà Đông Dương', 'Chinh phục Fansipan bằng cáp treo, tham quan bản Cát Cát, thác Bạc.', 4200000.00, 4, 'Hủy trước 5 ngày hoàn 70%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(3, 'Tour Ninh Bình - Tràng An 2N1Đ', 1, 'Vịnh Hạ Long trên cạn', 'Đi thuyền Tràng An, Tam Cốc, chùa Bái Đính, Vân Long.', 2800000.00, 2, 'Hủy trước 3 ngày hoàn 90%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(4, 'Tour Huế - Phong Nha 4N3Đ', 2, 'Cố đô và động Phong Nha', 'Đại Nội Huế, lăng Khải Định, động Phong Nha - Kẻ Bàng.', 5200000.00, 4, 'Hủy trước 7 ngày hoàn 75%', 1, '2025-12-03 15:24:38', 'Đà Nẵng', 1),
(5, 'Tour Đà Nẵng - Hội An - Bà Nà 5N4Đ', 2, 'Tam giác du lịch miền Trung', 'Bà Nà Hills, Cầu Vàng, phố cổ Hội An, Cù Lao Chàm, biển Mỹ Khê.', 6500000.00, 5, 'Hủy trước 10 ngày hoàn 80%', 1, '2025-12-03 15:24:38', 'Đà Nẵng', 1),
(6, 'Tour Nha Trang - Vinpearl 4N3Đ', 2, 'Biển xanh cát trắng', 'Tắm biển, Vinpearl Land, lặn ngắm san hô, tháp Bà Ponagar.', 4800000.00, 4, 'Hủy trước 5 ngày hoàn 70%', 1, '2025-12-03 15:24:38', 'TP.HCM', 1),
(7, 'Tour Đà Lạt Lãng Mạn 3N2Đ', 2, 'Thành phố ngàn hoa', 'Thung lũng Tình Yêu, thác Datanla, đồi chè Cầu Đất, hồ Xuân Hương.', 3800000.00, 3, 'Hủy trước 3 ngày hoàn 85%', 1, '2025-12-03 15:24:38', 'TP.HCM', 1),
(8, 'Tour TP.HCM - Vũng Tàu 2N1Đ', 3, 'Thành phố biển gần Sài Gòn', 'Tượng Chúa Kitô, ngọn hải đăng, Bạch Dinh, biển Bãi Sau.', 2200000.00, 2, 'Hủy trước 2 ngày hoàn 90%', 1, '2025-12-03 15:24:38', 'TP.HCM', 1),
(9, 'Tour Cần Thơ - Cà Mau 3N2Đ', 3, 'Miệt vườn sông nước', 'Chợ nổi Cái Răng, vườn trái cây, Mũi Cà Mau, rừng tràm Trà Sư.', 3200000.00, 3, 'Hủy trước 4 ngày hoàn 80%', 1, '2025-12-03 15:24:38', 'TP.HCM', 1),
(10, 'Tour Phú Quốc - Hòn Thơm 4N3Đ', 3, 'Đảo ngọc Việt Nam', 'Cáp treo Hòn Thơm, Grand World, VinWonders, Safari, lặn ngắm san hô.', 7200000.00, 4, 'Hủy trước 7 ngày hoàn 75%', 1, '2025-12-03 15:24:38', 'TP.HCM', 1),
(11, 'Tour Bangkok - Pattaya 5N4Đ', 4, 'Chùa Vàng và biển Thái', 'Hoàng Cung, chùa Phật Vàng, chợ nổi, Nong Nooch, show Alcazar.', 9500000.00, 5, 'Hủy trước 10 ngày hoàn 70%', 1, '2025-12-03 15:24:38', 'TP.HCM', 1),
(12, 'Tour Phuket - Phi Phi Island 6N5Đ', 4, 'Thiên đường biển đảo', 'Đảo Phi Phi, vịnh Phang Nga, Big Buddha, chùa Chalong, biển Patong.', 12500000.00, 6, 'Hủy trước 14 ngày hoàn 70%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(13, 'Tour Chiang Mai - Chiang Rai 5N4Đ', 4, 'Miền Bắc Thái Lan', 'Doi Suthep, Chùa Trắng, Xanh, làng dân tộc, thác Bua Tong, đèn trời.', 8800000.00, 5, 'Hủy trước 7 ngày hoàn 75%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(14, 'Tour Singapore Hiện Đại 4N3Đ', 4, 'Sư tử biển Đông Nam Á', 'Gardens by the Bay, Marina Bay Sands, Universal, Sentosa, Merlion.', 15800000.00, 4, 'Hủy trước 10 ngày hoàn 65%', 1, '2025-12-03 15:24:38', 'TP.HCM', 1),
(15, 'Tour Tokyo - Phú Sĩ 6N5Đ', 5, 'Thủ đô và núi Phú Sĩ', 'Núi Phú Sĩ, Sensoji, Skytree, Shibuya, Akihabara, Disneyland Tokyo.', 28500000.00, 6, 'Hủy trước 21 ngày hoàn 60%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(16, 'Tour Osaka - Kyoto - Nara 7N6Đ', 5, 'Tam giác vàng Nhật Bản', 'Lâu đài Osaka, Kiyomizu, Arashiyama, vườn hươu Nara, Todaiji, Gion.', 32000000.00, 7, 'Hủy trước 21 ngày hoàn 60%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(17, 'Tour Seoul - Jeju 6N5Đ', 5, 'K-pop và đảo Jeju', 'Gyeongbokgung, Hanok, N Seoul, Myeongdong, đảo Jeju, Hallasan.', 18500000.00, 6, 'Hủy trước 14 ngày hoàn 65%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(18, 'Tour Seoul - Nami - Everland 5N4Đ', 5, 'Hàn Quốc mùa thu', 'Đảo Nami, Everland, Petite France, Morning Calm, Dongdaemun.', 16800000.00, 5, 'Hủy trước 10 ngày hoàn 70%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(19, 'Tour Busan - Gyeongju 5N4Đ', 5, 'Cảng biển và cố đô', 'Haedong Yonggungsa, Gamcheon, Jagalchi, Gyeongju, Bulguksa.', 15200000.00, 5, 'Hủy trước 10 ngày hoàn 70%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1),
(20, 'Tour Miền Bắc Tổng Hợp 7N6Đ', 1, 'Hà Nội - Hạ Long - Sapa', 'Tour combo 3 điểm: Thủ đô, Vịnh Hạ Long, Sapa núi rừng.', 8900000.00, 7, 'Hủy trước 10 ngày hoàn 75%', 1, '2025-12-03 15:24:38', 'Hà Nội', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tour_ncc`
--

CREATE TABLE `tour_ncc` (
  `tour_ncc_id` int NOT NULL,
  `lich_id` int NOT NULL,
  `dich_vu_id` int NOT NULL,
  `gia_thoa_thuan` decimal(15,2) NOT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ma_hop_dong` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_ncc`
--

INSERT INTO `tour_ncc` (`tour_ncc_id`, `lich_id`, `dich_vu_id`, `gia_thoa_thuan`, `ghi_chu`, `ma_hop_dong`) VALUES
(1, 1, 1, 4800000.00, 'Xe 45 chỗ tour Hạ Long', 'HD2025001'),
(2, 1, 3, 1400000.00, 'Khách sạn 3 sao Hạ Long', 'HD2025002'),
(3, 1, 5, 190000.00, 'Buffet hải sản Hạ Long', 'HD2025003'),
(4, 2, 1, 4800000.00, 'Xe tour Sapa', 'HD2025004'),
(5, 2, 3, 1400000.00, 'Khách sạn Sapa view đẹp', 'HD2025005'),
(6, 2, 7, 750000.00, 'HDV tiếng Việt kinh nghiệm', 'HD2025006'),
(7, 3, 1, 4800000.00, 'Xe tour Hạ Long về HN', 'HD2025007'),
(8, 3, 3, 1400000.00, 'Khách sạn view vịnh đẹp', 'HD2025008'),
(9, 4, 2, 3300000.00, 'Limousine cao cấp Sapa', 'HD2025009'),
(10, 4, 4, 1900000.00, 'Phòng Deluxe Sapa', 'HD2025010'),
(11, 5, 2, 3300000.00, 'Limousine Sapa hạng sang', 'HD2025011'),
(12, 5, 4, 1900000.00, 'Khách sạn 4 sao Sapa', 'HD2025012'),
(13, 6, 1, 4800000.00, 'Xe tour Đà Nẵng', 'HD2025013'),
(14, 6, 3, 1400000.00, 'Khách sạn Đà Nẵng gần biển', 'HD2025014'),
(15, 7, 1, 4800000.00, 'Xe tour TP.HCM - Phú Quốc', 'HD2025015'),
(16, 7, 5, 190000.00, 'Ăn trưa tại nhà hàng địa phương', 'HD2025016'),
(17, 8, 2, 3300000.00, 'Limousine Phú Quốc', 'HD2025017'),
(18, 8, 9, 570000.00, 'Vé VinWonders giá ưu đãi', 'HD2025018'),
(19, 9, 1, 4800000.00, 'Xe tour Đà Lạt', 'HD2025019'),
(20, 9, 3, 1400000.00, 'Khách sạn Đà Lạt trung tâm', 'HD2025020'),
(21, 10, 1, 4800000.00, 'Xe TP.HCM - Phú Quốc', 'HD2025021'),
(22, 10, 4, 1900000.00, 'Resort Phú Quốc view biển', 'HD2025022'),
(23, 10, 9, 570000.00, 'Combo VinWonders + Safari', 'HD2025023'),
(24, 11, 1, 4800000.00, 'Xe tour Bangkok - Pattaya', 'HD2025024'),
(25, 11, 3, 1400000.00, 'Khách sạn Bangkok trung tâm', 'HD2025025'),
(26, 11, 8, 1150000.00, 'HDV tiếng Anh giỏi', 'HD2025026'),
(27, 12, 2, 3300000.00, 'Limousine Singapore cao cấp', 'HD2025027'),
(28, 12, 4, 1900000.00, 'Hotel Singapore 4 sao', 'HD2025028'),
(29, 13, 1, 4800000.00, 'Xe tour Phuket', 'HD2025029'),
(30, 13, 3, 1400000.00, 'Khách sạn Phuket gần biển', 'HD2025030');

-- --------------------------------------------------------

--
-- Table structure for table `trang_thai_booking`
--

CREATE TABLE `trang_thai_booking` (
  `trang_thai_id` int NOT NULL,
  `ten_trang_thai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trang_thai_booking`
--

INSERT INTO `trang_thai_booking` (`trang_thai_id`, `ten_trang_thai`, `mo_ta`) VALUES
(1, 'Chờ xử lý', 'Booking mới chờ xác nhận'),
(2, 'Đã xác nhận', 'Đã xác nhận và thanh toán'),
(3, 'Đã hủy', 'Booking đã bị hủy');

-- --------------------------------------------------------

--
-- Table structure for table `trang_thai_lich_khoi_hanh`
--

CREATE TABLE `trang_thai_lich_khoi_hanh` (
  `trang_thai_id` int NOT NULL,
  `ten_trang_thai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trang_thai_lich_khoi_hanh`
--

INSERT INTO `trang_thai_lich_khoi_hanh` (`trang_thai_id`, `ten_trang_thai`, `mo_ta`) VALUES
(1, 'Đang mở', 'Lịch đang mở đăng ký'),
(2, 'Sắp đầy', 'Gần đạt số lượng tối đa'),
(3, 'Đã đầy', 'Đã đủ khách'),
(4, 'Hủy', 'Lịch đã hủy');

-- --------------------------------------------------------

--
-- Table structure for table `vai_tro`
--

CREATE TABLE `vai_tro` (
  `vai_tro_id` int NOT NULL,
  `ten` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
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
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `lich_trinh_ibfk_2` (`dia_diem_tour_id`);

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
  ADD KEY `dich_vu_id` (`dich_vu_id`),
  ADD KEY `tour_ncc_ibfk_1` (`lich_id`);

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
  MODIFY `danh_muc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dat_tour`
--
ALTER TABLE `dat_tour`
  MODIFY `dat_tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `dia_diem`
--
ALTER TABLE `dia_diem`
  MODIFY `dia_diem_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dia_diem_lich_trinh`
--
ALTER TABLE `dia_diem_lich_trinh`
  MODIFY `dia_diem_lich_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `dia_diem_tour`
--
ALTER TABLE `dia_diem_tour`
  MODIFY `dia_diem_tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dich_vu_ncc`
--
ALTER TABLE `dich_vu_ncc`
  MODIFY `dich_vu_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `diem_danh_khach`
--
ALTER TABLE `diem_danh_khach`
  MODIFY `diem_danh_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `gia_dv`
--
ALTER TABLE `gia_dv`
  MODIFY `lich_ncc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `gia_lich_trinh`
--
ALTER TABLE `gia_lich_trinh`
  MODIFY `gia_lich_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `hanh_khach_list`
--
ALTER TABLE `hanh_khach_list`
  MODIFY `hanh_khach_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `hinh_anh_dia_diem`
--
ALTER TABLE `hinh_anh_dia_diem`
  MODIFY `hinh_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `hop_dong`
--
ALTER TABLE `hop_dong`
  MODIFY `hop_dong_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `huong_dan_vien`
--
ALTER TABLE `huong_dan_vien`
  MODIFY `hdv_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `khach_hang_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lich_khoi_hanh`
--
ALTER TABLE `lich_khoi_hanh`
  MODIFY `lich_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `lich_trinh`
--
ALTER TABLE `lich_trinh`
  MODIFY `lich_trinh_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `nguoi_dung_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `nhat_ky_tour`
--
ALTER TABLE `nhat_ky_tour`
  MODIFY `nhat_ky_tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `ncc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phan_cong_hdv`
--
ALTER TABLE `phan_cong_hdv`
  MODIFY `phan_cong_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `phuong_tien_tour`
--
ALTER TABLE `phuong_tien_tour`
  MODIFY `phuong_tien_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `quoc_gia`
--
ALTER TABLE `quoc_gia`
  MODIFY `quoc_gia_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tour_ncc`
--
ALTER TABLE `tour_ncc`
  MODIFY `tour_ncc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
