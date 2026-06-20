-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th6 20, 2026 lúc 03:00 PM
-- Phiên bản máy phục vụ: 8.4.7
-- Phiên bản PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qldb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baiviet`
--

DROP TABLE IF EXISTS `baiviet`;
CREATE TABLE IF NOT EXISTS `baiviet` (
  `mabaiviet` int NOT NULL AUTO_INCREMENT,
  `tieude` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `noiDung` longtext COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `anhDaiDien` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `trangThai` enum('chờ duyệt','đã duyệt','Từ chối','bản nháp') COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `noibat` tinyint(1) NOT NULL,
  `ngaydang` datetime NOT NULL,
  `ngayduyet` datetime DEFAULT NULL,
  `mataikhoan` int NOT NULL,
  `madanhmuc` int NOT NULL,
  `luotxem` int DEFAULT NULL,
  `nguoiduyet` int DEFAULT NULL,
  PRIMARY KEY (`mabaiviet`),
  KEY `mataikhoan` (`mataikhoan`),
  KEY `madanhmuc` (`madanhmuc`),
  KEY `nguoiduyet` (`nguoiduyet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

DROP TABLE IF EXISTS `binhluan`;
CREATE TABLE IF NOT EXISTS `binhluan` (
  `maBinhLuan` int NOT NULL AUTO_INCREMENT,
  `noiDung` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `ngayBinhLuan` datetime NOT NULL,
  `maTaiKhoan` int NOT NULL,
  `maBaiViet` int NOT NULL,
  PRIMARY KEY (`maBinhLuan`),
  KEY `maTaiKhoan` (`maTaiKhoan`),
  KEY `maBaiViet` (`maBaiViet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE IF NOT EXISTS `danhmuc` (
  `madanhmuc` int NOT NULL AUTO_INCREMENT,
  `tendanhmuc` varchar(100) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `mota` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  PRIMARY KEY (`madanhmuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
CREATE TABLE IF NOT EXISTS `taikhoan` (
  `mataikhoan` int NOT NULL AUTO_INCREMENT,
  `hoten` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `matkhau` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `vaitro` enum('admin','user','bientapvien') COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `ngaytao` datetime NOT NULL,
  PRIMARY KEY (`mataikhoan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`mataikhoan`, `hoten`, `email`, `matkhau`, `vaitro`, `ngaytao`) VALUES
(1, 'nhat', 'minh@gmail.com', '12', 'admin', '2026-06-19 16:15:07'),
(2, '2', '2@gmail.com', '$2y$10$8NSCAkdoEdBo72u2/tvO9u2UL6dv.MV3QTJ519/zFJmYOky3Ye1gG', 'user', '2026-06-20 17:56:06'),
(3, '3', '3@gmail.com', '$2y$10$B2Zm.fDZhEP6f2vh40ldbusObR3gofS9Wllq8BwWl7CTjev2o1cQm', 'admin', '2026-06-20 20:28:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

DROP TABLE IF EXISTS `thongbao`;
CREATE TABLE IF NOT EXISTS `thongbao` (
  `maThongBao` int NOT NULL AUTO_INCREMENT,
  `noiDung` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `daDoc` tinyint(1) NOT NULL,
  `ngayTao` datetime NOT NULL,
  `maTaiKhoan` int NOT NULL,
  PRIMARY KEY (`maThongBao`),
  KEY `maTaiKhoan` (`maTaiKhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tuyendung`
--

DROP TABLE IF EXISTS `tuyendung`;
CREATE TABLE IF NOT EXISTS `tuyendung` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tieude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhanh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `noidung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngaydang` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tuyendung`
--

INSERT INTO `tuyendung` (`id`, `tieude`, `hinhanh`, `noidung`, `ngaydang`) VALUES
(1, '1', 'Screenshot 2026-06-01 171036.png', '1', '2026-06-20 21:31:07'),
(2, '2', 'Screenshot 2026-06-03 211347.png', '2', '2026-06-20 21:32:40');

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD CONSTRAINT `baiviet_ibfk_1` FOREIGN KEY (`mataikhoan`) REFERENCES `taikhoan` (`mataikhoan`),
  ADD CONSTRAINT `baiviet_ibfk_2` FOREIGN KEY (`madanhmuc`) REFERENCES `danhmuc` (`madanhmuc`),
  ADD CONSTRAINT `baiviet_ibfk_3` FOREIGN KEY (`nguoiduyet`) REFERENCES `taikhoan` (`mataikhoan`);

--
-- Ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`maTaiKhoan`) REFERENCES `taikhoan` (`mataikhoan`),
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`maBaiViet`) REFERENCES `baiviet` (`mabaiviet`);

--
-- Ràng buộc cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD CONSTRAINT `thongbao_ibfk_1` FOREIGN KEY (`maTaiKhoan`) REFERENCES `taikhoan` (`mataikhoan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
