<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Kiểm tra quyền admin
if (!isset($_SESSION['vaitro']) || $_SESSION['vaitro'] !== 'admin') {
    die("Bạn không có quyền truy cập!");
}

$thong_bao = "";

// 2. XỬ LÝ XÓA
if (isset($_GET['xoa_id'])) {
    $id = (int)$_GET['xoa_id']; // Ép kiểu số để bảo mật
    
    $res = mysqli_query($conn, "SELECT hinhanh FROM tuyendung WHERE id = '$id'");
    if ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['hinhanh']) && file_exists("uploads/" . $row['hinhanh'])) {
            unlink("uploads/" . $row['hinhanh']);
        }
    }
    mysqli_query($conn, "DELETE FROM tuyendung WHERE id = '$id'");
    
    // Chuyển hướng về chính nó để xóa tham số xoa_id trên URL, tránh lỗi khi F5
    header("Location: themtuyendung.php");
    exit();
}

// 3. XỬ LÝ THÊM (Chỉ chạy khi nhấn nút Đăng tin)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_dang'])) {
    $tieude = trim($_POST['tieude']);
    $noidung = trim($_POST['noidung']);
    $hinhanh = $_FILES['hinhanh']['name'];
    $target = "uploads/" . basename($hinhanh);

    if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], $target)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO tuyendung (tieude, noidung, hinhanh, ngaydang) VALUES (?, ?, ?, NOW())");
        mysqli_stmt_bind_param($stmt, "sss", $tieude, $noidung, $hinhanh);
        if (mysqli_stmt_execute($stmt)) {
            $thong_bao = "Đăng tin thành công!";
        }
        mysqli_stmt_close($stmt);
    } else {
        $thong_bao = "Lỗi upload ảnh! Hãy kiểm tra thư mục uploads.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tin tuyển dụng</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .box { max-width: 800px; background: white; padding: 25px; margin: auto; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; box-sizing: border-box; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Đăng tin mới</h2>
        <?php if($thong_bao) echo "<p style='color:green; font-weight:bold;'>$thong_bao</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="tieude" placeholder="Tiêu đề" required>
            <textarea name="noidung" placeholder="Nội dung..." required></textarea>
            <input type="file" name="hinhanh" required>
            <button type="submit" name="btn_dang">Đăng tin</button>
        </form>

        <hr>
        <h2>Danh sách tin</h2>
        <table>
            <tr><th>Tiêu đề</th><th>Hành động</th></tr>
            <?php
            $data = mysqli_query($conn, "SELECT * FROM tuyendung ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['tieude']); ?></td>
                <td><a href="?xoa_id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa tin này?');" style="color:red; text-decoration:none;">Xóa</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>