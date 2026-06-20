<?php
// 1. Khởi động lại session để hệ thống biết session nào đang chạy mà xóa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Xóa sạch tất cả các biến đã lưu trong session (user_id, user_name, vaitro...)
session_unset();

// 3. Hủy hoàn toàn phiên làm việc của session này trên máy chủ
session_destroy();

// 4. Xóa xong thì tự động chuyển hướng người dùng quay về lại trang chủ index.php
header("Location: index.php");
exit();
?>