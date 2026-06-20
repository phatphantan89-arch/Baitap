<?php
if (file_exists('db.php')) { include 'db.php'; }
$thong_bao = ""; $loai = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = trim($_POST['hoten']); $email = trim($_POST['email']); $pass = password_hash($_POST['matkhau'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO taikhoan (hoten, email, matkhau, vaitro) VALUES (?, ?, ?, 'user')";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $hoten, $email, $pass);
        if (mysqli_stmt_execute($stmt)) {
            $thong_bao = "Đăng ký thành công! <a href='login.php'>Đăng nhập</a>"; $loai = "success";
        } else { $thong_bao = "Lỗi!"; $loai = "error"; }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - KhoaHocTre.vn</title>
    <style>
        :root { --primary-color: #007aff; --secondary-color: #f39c12; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #e4f0ff 0%, #a1c4fd 100%); height: 100vh; display: flex; justify-content: center; align-items: center; }
        .container { background: white; width: 100%; max-width: 420px; padding: 40px 35px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .logo { text-align: center; font-size: 26px; font-weight: bold; color: var(--primary-color); margin-bottom: 25px; display: block; text-decoration: none; }
        .logo span { color: var(--secondary-color); }
        h2 { text-align: center; margin-bottom: 25px; font-size: 20px; }
        .alert { padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center; }
        .error { background: #f8d7da; color: #dc3545; }
        .success { background: #d4edda; color: #28a745; }
        .form-group { margin-bottom: 20px; }
        .form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; }
        .btn-submit { width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        .link { text-align: center; margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="logo">KhoaHocTre<span>.vn</span></a>
        <h2>Đăng ký tài khoản</h2>
        <?php if($thong_bao): ?><div class="alert <?php echo $loai; ?>"><?php echo $thong_bao; ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group"><input type="text" name="hoten" placeholder="Họ và tên..." required></div>
            <div class="form-group"><input type="email" name="email" placeholder="Email..." required></div>
            <div class="form-group"><input type="password" name="matkhau" placeholder="Mật khẩu..." required></div>
            <button type="submit" class="btn-submit">Đăng ký</button>
        </form>
        <div class="link">Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></div>
    </div>
</body>
</html>