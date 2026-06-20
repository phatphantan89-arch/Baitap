<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tieude = trim($_POST['tieude']);
    $noidung = trim($_POST['noidung']);
    $hinhanh = "default.png"; // Ảnh mặc định nếu không up ảnh

    // Xử lý upload file ảnh
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
        $filename = time() . '_' . $_FILES['hinhanh']['name']; // Tránh trùng tên file
        if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], 'uploads/' . $filename)) {
            $hinhanh = $filename;
        }
    }

    if (!empty($tieude) && !empty($noidung)) {
        $sql = "INSERT INTO tuyendung (tieude, hinhanh, noidung) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $tieude, $hinhanh, $noidung);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: admin-tuyen-dung.php");
                exit();
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng tin mới</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #f4f6f9; }
        .form-box { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"], .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
        .btn-submit { background: #007aff; color: white; border: none; padding: 12px 20px; font-weight: bold; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Đăng Tin Tuyển Dụng Mới</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tiêu đề thông báo:</label>
            <input type="text" name="tieude" required placeholder="Ví dụ: THÔNG BÁO TUYỂN THÀNH VIÊN...">
        </div>
        <div class="form-group">
            <label>Hình ảnh minh họa:</label>
            <input type="file" name="hinhanh" accept="image/*">
        </div>
        <div class="form-group">
            <label>Nội dung thông báo chi tiết:</label>
            <textarea name="noidung" rows="8" required placeholder="Nhập nội dung thông báo tại đây..."></textarea>
        </div>
        <button type="submit" class="btn-submit">Đăng bài ngay</button>
        <a href="admin-tuyen-dung.php" style="margin-left: 15px; color:#666;">Hủy bỏ</a>
    </form>
</div>

</body>
</html>

<?php
include 'db.php';

// 1. LOAD DỮ LIỆU CŨ LÊN FORM
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM tuyendung WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $post = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}

// 2. XỬ LÝ LƯU THAY ĐỔI KHI BẤM SUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $tieude = trim($_POST['tieude']);
    $noidung = trim($_POST['noidung']);
    $hinhanh = $_POST['hinhanh_cu']; // Mặc định giữ lại ảnh cũ

    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
        $filename = time() . '_' . $_FILES['hinhanh']['name'];
        if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], 'uploads/' . $filename)) {
            $hinhanh = $filename; // Nếu up ảnh mới thì đổi tên file lưu trữ
        }
    }

    if (!empty($tieude) && !empty($noidung)) {
        $sql_update = "UPDATE tuyendung SET tieude = ?, hinhanh = ?, noidung = ? WHERE id = ?";
        if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, "sssi", $tieude, $hinhanh, $noidung, $id);
            if (mysqli_stmt_execute($stmt_update)) {
                header("Location: admin-tuyen-dung.php");
                exit();
            }
            mysqli_stmt_close($stmt_update);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa tin tuyển dụng</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #f4f6f9; }
        .form-box { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"], .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
        .btn-submit { background: #ffc107; color: #333; border: none; padding: 12px 20px; font-weight: bold; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Chỉnh Sửa Tin Tuyển Dụng</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <input type="hidden" name="hinhanh_cu" value="<?php echo $post['hinhanh']; ?>">

        <div class="form-group">
            <label>Tiêu đề thông báo:</label>
            <input type="text" name="tieude" value="<?php echo htmlspecialchars($post['tieude']); ?>" required>
        </div>
        <div class="form-group">
            <label>Hình ảnh hiện tại:</label>
            <img src="uploads/<?php echo $post['hinhanh']; ?>" width="120" style="display:block; margin-bottom:5px;">
            <input type="file" name="hinhanh" accept="image/*">
        </div>
        <div class="form-group">
            <label>Nội dung chi tiết:</label>
            <textarea name="noidung" rows="8" required><?php echo htmlspecialchars($post['noidung']); ?></textarea>
        </div>
        <button type="submit" class="btn-submit">Cập nhật thay đổi</button>
        <a href="admin-tuyen-dung.php" style="margin-left: 15px; color:#666;">Hủy bỏ</a>
    </form>
</div>

</body>
</html>