<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Kiểm tra quyền Admin
if (!isset($_SESSION['vaitro']) || $_SESSION['vaitro'] !== 'admin') {
    die("Bạn không có quyền truy cập trang này!");
}

// 2. XỬ LÝ XÓA (Gộp cả xóa database và xóa file ảnh)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_xoa = (int)$_GET['id'];

    // Lấy tên ảnh trước khi xóa
    $sql_get_img = "SELECT hinhanh FROM tuyendung WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql_get_img)) {
        mysqli_stmt_bind_param($stmt, "i", $id_xoa);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            if (!empty($row['hinhanh']) && file_exists("uploads/" . $row['hinhanh'])) {
                unlink("uploads/" . $row['hinhanh']); // Xóa file ảnh thật
            }
        }
        mysqli_stmt_close($stmt);
    }

    // Xóa record trong DB
    $sql_xoa = "DELETE FROM tuyendung WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql_xoa)) {
        mysqli_stmt_bind_param($stmt, "i", $id_xoa);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: admin-tuyen-dung.php");
    exit();
}

// 3. LẤY DANH SÁCH BÀI ĐĂNG
$sql = "SELECT * FROM tuyendung ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Tuyển dụng</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f6f9; }
        .admin-box { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: bold; }
        .btn-add { background: #28a745; color: white; display: inline-block; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="admin-box">
    <h2>Trang Quản Trị Tin Tuyển Dụng</h2>
    <a href="quanlytuyendung.php" class="btn btn-add">+ Đăng Tin Mới</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Hình ảnh</th>
            <th>Tiêu đề</th>
            <th>Ngày đăng</th>
            <th>Hành động</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="uploads/<?php echo $row['hinhanh']; ?>" width="60" style="object-fit:cover;"></td>
            <td><strong><?php echo htmlspecialchars($row['tieude']); ?></strong></td>
            <td><?php echo $row['ngaydang']; ?></td>
            <td>
                <a href="quanlytuyendung.php" class="btn btn-add">+ Đăng Tin Mới</a>
                <a href="quanlytuyendung.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Sửa</a>
                   class="btn btn-delete" 
                   onclick="return confirm('Bạn chắc chắn muốn xóa tin này không?');">Xóa</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>