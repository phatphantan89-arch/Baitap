
<?php
if (file_exists('db.php')) { 
    include 'db.php'; 
}

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $matkhau_raw = $_POST['matkhau'];

    $sql = "SELECT * FROM taikhoan WHERE email = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

            // Kiểm tra mật khẩu
            if (password_verify($matkhau_raw, $row['matkhau'])) {

                // Lưu session
                $_SESSION['user_id'] = $row['mataikhoan'];
                $_SESSION['user_name'] = $row['hoten'];
                $_SESSION['vaitro'] = $row['vaitro'];

                // Chuyển về trang chủ
                header("Location: index.php");
                exit();

            } else {
                $thong_bao = "Sai mật khẩu!";
            }

        } else {
            $thong_bao = "Email không tồn tại!";
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - KhoaHocTre.vn</title>
    <style>
        :root { --primary-color: #007aff; --secondary-color: #f39c12; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #e4f0ff 0%, #a1c4fd 100%); height: 100vh; display: flex; justify-content: center; align-items: center; }
        .container { background: white; width: 100%; max-width: 420px; padding: 40px 35px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .logo { text-align: center; font-size: 26px; font-weight: bold; color: var(--primary-color); margin-bottom: 25px; display: block; text-decoration: none; }
        .logo span { color: var(--secondary-color); }
        h2 { text-align: center; margin-bottom: 25px; font-size: 20px; }
        .alert { padding: 10px; background: #f8d7da; color: #dc3545; border-radius: 6px; margin-bottom: 15px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        .form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; }
        .btn-submit { width: 100%; padding: 12px; background: var(--primary-color); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        .link { text-align: center; margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="logo">KhoaHocTre<span>.vn</span></a>

        <h2>Đăng nhập</h2>

        <?php if($thong_bao): ?>
            <div class="alert"><?php echo $thong_bao; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email..." required>
            </div>

            <div class="form-group">
                <input type="password" name="matkhau" placeholder="Mật khẩu..." required>
            </div>

            <button type="submit" class="btn-submit">Đăng nhập</button>
        </form>

        <div class="link">
            Chưa có tài khoản?
            <a href="register.php">Đăng ký ngay</a>
        </div>
    </div>
</body>
</html>
```
