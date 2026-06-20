<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<header>
    <div class="logo">KhoaHocTre.vn</div>
    <nav class="main-menu">
        <ul class="menu-public">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="tuyendung.php">Tuyển dụng</a></li>
        </ul>
    </nav>
</header>