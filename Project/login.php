<?php
// 1. XỬ LÝ LOGIC PHP (Đặt trên cùng để xử lý dữ liệu trước khi vẽ giao diện)
if (file_exists('db.php')) { include 'db.php'; }
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $matkhau_raw = $_POST['matkhau'];

    if (!empty($email) && !empty($matkhau_raw)) {
        $sql = "SELECT * FROM taikhoan WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                if ($matkhau_raw == $row['matkhau']) {
                    // Trong login.php, khi đăng nhập thành công:
$_SESSION['user_id'] = $row['mataikhoan'];
$_SESSION['user_name'] = $row['hoten'];
$_SESSION['vaitro'] = $row['vaitro']; // Dùng 'vaitro' làm tên biến thống nhất
                    exit();
                } else { $thong_bao = "Sai mật khẩu!"; }
            } else { $thong_bao = "Email không tồn tại!"; }
            mysqli_stmt_close($stmt);
        }
    } else { $thong_bao = "Vui lòng nhập đầy đủ!"; }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - KhoaHocTre.vn</title>
    <style>
        /* GIỮ NGUYÊN CSS CŨ CỦA BẠN */
        :root { --primary-color: #007aff; --secondary-color: #f39c12; }
        body { background: linear-gradient(135deg, #e4f0ff 0%, #a1c4fd 100%); height: 100vh; display: flex; justify-content: center; align-items: center; font-family: sans-serif; }
        .register-container { background-color: white; width: 100%; max-width: 420px; padding: 40px 35px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .logo { text-align: center; font-size: 26px; font-weight: bold; color: var(--primary-color); margin-bottom: 25px; display: block; text-decoration: none; }
        .logo span { color: var(--secondary-color); }
        .form-group { margin-bottom: 20px; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; }
        .btn-submit { width: 100%; padding: 12px; background-color: var(--primary-color); color: white; border: none; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>

<div class="register-container">
    <a href="index.php" class="logo">KhoaHocTre<span>.vn</span></a>
    <h2 style="text-align:center; margin-bottom:20px;">Đăng nhập hệ thống</h2>
    
    <?php if($thong_bao): ?>
        <p style="color:red; text-align:center; margin-bottom:15px;"><?php echo $thong_bao; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <input type="email" name="email" placeholder="Nhập email của bạn..." required>
        </div>
        <div class="form-group">
            <input type="password" name="matkhau" placeholder="Nhập mật khẩu..." required>
        </div>
        <button type="submit" class="btn-submit">Đăng nhập</button>
    </form>
    
    <div style="text-align:center; margin-top:20px; font-size:14px;">
        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
    </div>
</div>

</body>
</html>