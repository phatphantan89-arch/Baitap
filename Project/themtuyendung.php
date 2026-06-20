<?php
include 'db.php';
session_start();

// Kiểm tra quyền admin cho mọi thao tác
if (!isset($_SESSION['vaitro']) || $_SESSION['vaitro'] !== 'admin') {
    die("Bạn không có quyền truy cập!");
}

$thong_bao = "";

// 1. XỬ LÝ XÓA (Nếu có id gửi lên từ link)
if (isset($_GET['xoa_id'])) {
    $id = $_GET['xoa_id'];
    
    // Xóa ảnh
    $res = mysqli_query($conn, "SELECT hinhanh FROM tuyendung WHERE id = '$id'");
    if ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['hinhanh']) && file_exists("uploads/" . $row['hinhanh'])) {
            unlink("uploads/" . $row['hinhanh']);
        }
    }
    // Xóa database
    mysqli_query($conn, "DELETE FROM tuyendung WHERE id = '$id'");
    header("Location: them_tuyendung.php");
    exit();
}

// 2. XỬ LÝ THÊM (Nếu nhấn nút Đăng tin)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tieude = $_POST['tieude'];
    $noidung = $_POST['noidung'];
    $hinhanh = $_FILES['hinhanh']['name'];
    $target = "uploads/" . basename($hinhanh);

    if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], $target)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO tuyendung (tieude, noidung, hinhanh, ngaydang) VALUES (?, ?, ?, NOW())");
        mysqli_stmt_bind_param($stmt, "sss", $tieude, $noidung, $hinhanh);
        if (mysqli_stmt_execute($stmt)) {
            $thong_bao = "Đăng tin thành công!";
        }
    } else {
        $thong_bao = "Lỗi upload ảnh!";
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
        .box { max-width: 800px; background: white; padding: 25px; margin: auto; border-radius: 8px; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Đăng tin mới</h2>
        <?php if($thong_bao) echo "<p style='color:green;'>$thong_bao</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="tieude" placeholder="Tiêu đề" required>
            <textarea name="noidung" placeholder="Nội dung..." required></textarea>
            <input type="file" name="hinhanh" required>
            <button type="submit">Đăng tin</button>
        </form>

        <hr>
        <h2>Danh sách tin</h2>
        <table>
            <?php
            $data = mysqli_query($conn, "SELECT * FROM tuyendung ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?php echo $row['tieude']; ?></td>
                <td><a href="?xoa_id=<?php echo $row['id']; ?>" onclick="return confirm('Xóa nhé?');" style="color:red;">Xóa</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>