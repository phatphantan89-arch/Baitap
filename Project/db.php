<?php
$host = "localhost";
$user = "root";
$pass = ""; // Mặc định của WampServer là để trống "". Nếu không kết nối được bạn mới thử đổi thành "root" nhé.
$dbname = "qldb"; // ⚠️ BẠN CẦN SỬA CHỖ NÀY: Điền đúng tên Database bạn đã tạo trong phpMyAdmin

// Tiến hành kết nối đến MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Kiểm tra xem kết nối có thành công không
if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

// Cấu hình hỗ trợ gõ tiếng Việt không bị lỗi font xuyn/hỏi/ngã
mysqli_set_charset($conn, "utf8mb4");
?>