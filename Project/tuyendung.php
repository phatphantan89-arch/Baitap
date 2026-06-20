<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// XỬ LÝ XÓA: Nếu có yêu cầu xóa gửi lên
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_xoa = (int)$_GET['id'];
    $sql_xoa = "DELETE FROM tuyendung WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql_xoa)) {
        mysqli_stmt_bind_param($stmt, "i", $id_xoa);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: admin-tuyen-dung.php"); // Xóa xong tải lại trang
    exit();
}

// LẤY DANH SÁCH BÀI ĐĂNG
$sql = "SELECT * FROM tuyendung ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Tuyển dụng - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #f4f6f9; }
        .admin-box { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { margin-bottom: 20px; color: #1d1d1f; }
        .btn { display: inline-block; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; }
        .btn-add { background: #28a745; color: white; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007aff; color: white; }
        .btn-edit { background: #ffc107; color: #333; margin-right: 5px; }
        .btn-delete { background: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="admin-box">
    <h2>Trang Quản Trị Tin Tuyển Dụng</h2>
    <a href="themtuyendung.php" class="btn-tuyendung" style="background:#28a745; color:white; padding:10px; text-decoration:none; border-radius:5px; display:inline-block; margin-bottom:20px;">
    + Đăng Tin Tuyển Dụng Mới </a>

    <table>
        <tr>
            <th>ID</th>
            <th>Hình ảnh</th>
            <th>Tiêu đề bài đăng</th>
            <th>Ngày đăng</th>
            <th>Hành động</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="uploads/<?php echo $row['hinhanh']; ?>" width="80" height="50" style="object-fit:cover;"></td>
            <td><strong><?php echo htmlspecialchars($row['tieude']); ?></strong></td>
            <td><?php echo $row['ngaydang']; ?></td>
            <td>
                <a href="tuyen-dung-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Sửa</a>
                <a href="admin-tuyen-dung.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa tin này không?');">Xóa</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>