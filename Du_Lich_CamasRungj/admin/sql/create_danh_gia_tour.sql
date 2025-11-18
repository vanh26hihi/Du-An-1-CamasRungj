-- Tạo bảng đánh giá tour
CREATE TABLE IF NOT EXISTS `danh_gia_tour` (
  `danh_gia_id` int NOT NULL AUTO_INCREMENT,
  `hdv_id` int DEFAULT NULL,
  `tour_id` int DEFAULT NULL,
  `lich_id` int DEFAULT NULL,
  `diem_danh_gia` int DEFAULT NULL COMMENT 'Điểm đánh giá từ 1-5',
  `phan_hoi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL,
  PRIMARY KEY (`danh_gia_id`),
  KEY `hdv_id` (`hdv_id`),
  KEY `tour_id` (`tour_id`),
  KEY `lich_id` (`lich_id`),
  CONSTRAINT `danh_gia_tour_ibfk_1` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_vien` (`hdv_id`),
  CONSTRAINT `danh_gia_tour_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`),
  CONSTRAINT `danh_gia_tour_ibfk_3` FOREIGN KEY (`lich_id`) REFERENCES `lich_khoi_hanh` (`lich_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

