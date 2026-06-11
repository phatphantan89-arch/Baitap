<?php
// Giả lập xử lý logic sau khi người dùng bấm nút "Đăng nhập"
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Giả sử tài khoản đúng trong Database là admin@gmail.com / 123456
    if ($email === "admin@gmail.com" && $password === "123456") {
        // Đăng nhập thành công, chuyển hướng về trang chủ
        header("Location: index.php");
        exit();
    } else {
        // Nếu sai, gán câu thông báo lỗi
        $error_message = "Mật khẩu hoặc tài khoản không chính xác. Vui lòng thử lại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Khoa Học Trẻ</title>
    <style>
        :root {
            --primary-color: #0056b3; 
            --primary-hover: #004494;
            --secondary-color: #f39c12; 
            --text-dark: #333;
            --bg-light: #f4f7f6;
            --error-color: #dc3545; /* Màu đỏ cho thông báo lỗi */
            --error-bg: #f8d7da;
            --error-border: #f5c6cb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }

        body {
            background-color: var(--bg-light);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .logo {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 30px;
            text-decoration: none;
            display: block;
        }

        .logo span { color: var(--secondary-color); }

        h2 { text-align: center; color: var(--text-dark); margin-bottom: 25px; font-size: 20px; }

        /* THIẾT KẾ KHUNG BÁO LỖI */
        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-color);
            border: 1px solid var(--error-border);
            padding: 12px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark); font-size: 14px; }
        .form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; outline: none; }
        
        /* Đổi màu viền input thành đỏ nếu có lỗi */
        .input-error { border-color: var(--error-color) !important; }

        .form-group input:focus { border-color: var(--primary-color); }
        .form-options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; font-size: 13px; }
        .form-options label { display: flex; align-items: center; gap: 5px; color: #666; cursor: pointer; }
        .form-options a { color: var(--primary-color); text-decoration: none; font-weight: 600; }
        .btn-submit { width: 100%; padding: 12px; background-color: var(--primary-color); color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; }
        .btn-submit:hover { background-color: var(--primary-hover); }
        .register-link { text-align: center; margin-top: 20px; font-size: 14px; color: #666; }
        .register-link a { color: var(--primary-color); font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>

    <div class="login-container">
        <a href="index.html" class="logo">KhoaHocTre<span>.vn</span></a>
        <h2>Đăng nhập hệ thống</h2>

        <?php if(!empty($error_message)): ?>
            <div class="alert-error">
                ⚠️ <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Tài khoản Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập email của bạn..." 
                       class="<?php echo !empty($error_message) ? 'input-error' : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu..." 
                       class="<?php echo !empty($error_message) ? 'input-error' : ''; ?>" required>
            </div>

            <div class="form-options">
                <label><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label>
                <a href="#">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn-submit">Đăng nhập</button>
        </form>

        <div class="register-link">
            Chưa có tài khoản? <a href="#">Đăng ký ngay</a>
        </div>
    </div>

</body>
</html>