<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $matkhau = $_POST['matkhau'];

    $sql = "SELECT * FROM taikhoan WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Kiểm tra mật khẩu đã mã hóa
        if (password_verify($matkhau, $row['matkhau'])) {
            $_SESSION['user_id'] = $row['mataikhoan'];
            $_SESSION['user_name'] = $row['hoten'];
            header("Location: index.php"); // Chuyển hướng sang trang chủ
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Email không tồn tại!";
    }
}
?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="matkhau" placeholder="Mật khẩu" required>
    <button type="submit">Đăng nhập</button>
</form>