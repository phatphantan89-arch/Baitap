<?php
// Bật Session ở đầu trang để hệ thống nhận diện trạng thái đăng nhập
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Khoa Học Trẻ TP.HCM (Bản cải tiến)</title>
    <style>
        /* CSS Reset cơ bản */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary-color: #0056b3; 
            --primary-hover: #004494;
            --secondary-color: #f39c12; 
            --text-dark: #333;
            --text-light: #666;
            --bg-light: #f8f9fa;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* 1. HEADER & MENU */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            text-decoration: none;
        }

        .logo span {
            color: var(--secondary-color);
        }

        .nav-menu {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-menu li a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav-menu li a:hover {
            color: var(--primary-color);
        }

        /* KHU VỰC TÌM KIẾM VÀ ĐĂNG NHẬP */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-bar input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* CSS Mới cho lời chào thành viên */
        .user-welcome {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .btn-logout {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            margin-left: 5px;
            transition: color 0.3s;
        }
        .btn-logout:hover {
            color: #bd2130;
        }

        .btn-outline {
            padding: 8px 16px;
            border: 1.5px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-fill {
            padding: 8px 16px;
            border: 1.5px solid var(--primary-color);
            color: white;
            background: var(--primary-color);
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-fill:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        /* 2. BANNER NỔI BẬT (HERO SECTION) */
        .hero {
            background: linear-gradient(rgba(0, 86, 179, 0.8), rgba(0, 86, 179, 0.8)), url('https://via.placeholder.com/1200x500') center/cover;
            color: white;
            padding: 80px 20px;
            text-align: center;
        }

        .hero h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background-color: #d68910;
        }

        /* 3. KHU VỰC NỘI DUNG (MAIN CONTENT) */
        .main-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 40px;
            color: var(--primary-color);
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: var(--secondary-color);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .news-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }

        .news-card:hover {
            transform: translateY(-10px);
        }

        .news-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #ddd;
        }

        .news-content {
            padding: 20px;
        }

        .news-category {
            display: inline-block;
            background-color: #e9ecef;
            color: var(--primary-color);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .news-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .news-desc {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .news-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        /* 4. FOOTER */
        footer {
            background-color: #222;
            color: #ccc;
            text-align: center;
            padding: 30px 20px;
            margin-top: 60px;
        }

        footer p {
            margin-bottom: 10px;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 900px) {
            .nav-menu, .search-bar {
                display: none; 
            }
            .hero h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="nav-container">
        <a href="index.php" class="logo">KhoaHocTre<span>.vn</span></a>
        
       <ul class="nav-menu">
    <li><a href="index.php">Trang chủ</a></li>
    <li><a href="#">Cuộc thi</a></li>
    <li><a href="#">Nghiên cứu KH</a></li>
    <li><a href="#">Tài liệu</a></li>
    <li><a href="#">Liên hệ</a></li>
    
    <li><a href="tuyendung.php">Tuyển dụng</a></li>

    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['vaitro']) && ($_SESSION['vaitro'] === 'admin' || $_SESSION['vaitro'] === 'bientapvien')): ?>
        <li>
            <a href="quanlytuyendung.php" style="color: #d9534f; font-weight: bold;">
                🛠️ Quản lý tuyển dụng
            </a>
        </li>
    <?php endif; ?>
</ul>

        <div class="header-actions">
            <div class="search-bar">
                <input type="text" placeholder="Tìm kiếm tin tức...">
            </div>
            
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="user-welcome">👋 Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="logout.php" class="btn-logout">Đăng xuất</a>
                <?php else: ?>
                    <a href="login.php" class="btn-outline">Đăng nhập</a>
                    <a href="register.php" class="btn-fill">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

    <section class="hero">
        <h1>Khoa Trung tâm công nghệ 2026</h1>
        <p>Sân chơi học thuật lớn nhất dành cho sinh viên đam mê nghiên cứu khoa học và đổi mới sáng tạo.</p>
        <a href="#" class="btn-primary">Đăng ký tham gia ngay</a>
    </section>

    <main class="main-container">
        <h2 class="section-title">Tin Tức & Sự Kiện Mới Nhất</h2>
        
        <div class="news-grid">
            <div class="news-card">
                <img src="https://via.placeholder.com/400x200" alt="Hội thi Tin học trẻ" class="news-img">
                <div class="news-content">
                    <span class="news-category">Cuộc thi</span>
                    <h3 class="news-title">Phát động Hội thi Tin học trẻ TP.HCM lần thứ 35</h3>
                    <p class="news-desc">Hội thi nhằm phát hiện, tập hợp và phát huy những năng khiếu tin học trẻ, góp phần xây dựng nguồn nhân lực CNTT chất lượng cao.</p>
                    <div class="news-footer">
                        <span>📅 04/06/2026</span>
                        <a href="#" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Xem thêm &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="news-card">
                <img src="https://via.placeholder.com/400x200" alt="Học bổng" class="news-img">
                <div class="news-content">
                    <span class="news-category">Học bổng</span>
                    <h3 class="news-title">Danh sách nhận học bổng "Vườn ươm Tài năng" 2026</h3>
                    <p class="news-desc">Chúc mừng 50 gương mặt sinh viên xuất sắc đã vượt qua các vòng xét duyệt gắt gao để nhận được sự hỗ trợ từ quỹ Vườn ươm.</p>
                    <div class="news-footer">
                        <span>📅 01/06/2026</span>
                        <a href="#" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Xem thêm &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="news-card">
                <img src="https://via.placeholder.com/400x200" alt="Hội thảo" class="news-img">
                <div class="news-content">
                    <span class="news-category">Hội thảo</span>
                    <h3 class="news-title">Workshop: Ứng dụng AI trong lập trình và tối ưu hóa hệ thống</h3>
                    <p class="news-desc">Chương trình giao lưu cùng các chuyên gia hàng đầu, hướng dẫn ứng dụng các công cụ AI vào thực tiễn phát triển phần mềm.</p>
                    <div class="news-footer">
                        <span>📅 28/05/2026</span>
                        <a href="#" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Xem thêm &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p><strong>Trung tâm Phát triển Khoa học và Công nghệ Trẻ TP.HCM</strong></p>
        <p>Địa chỉ: Số 1 Phạm Ngọc Thạch, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh</p>
        <p>&copy; 2026 Bản quyền thuộc về Khoahoctre.vn (Bản Demo Cải tiến)</p>
    </footer>

</body>
</html>