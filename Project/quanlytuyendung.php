```php
<?php
include 'db.php';

$post = null;
$isEdit = false;
$id = 0;

// ======================
// LOAD DỮ LIỆU KHI SỬA
// ======================
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $isEdit = true;
    $id = (int)$_GET['id'];

    $sql = "SELECT * FROM tuyendung WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if (!$post) {
        die("Không tìm thấy bài viết!");
    }
}

// ======================
// XỬ LÝ SUBMIT
// ======================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tieude = trim($_POST['tieude']);
    $noidung = trim($_POST['noidung']);

    // Mặc định
    $hinhanh = "default.png";

    // Nếu đang sửa thì giữ ảnh cũ
    if ($isEdit && isset($_POST['hinhanh_cu'])) {
        $hinhanh = $_POST['hinhanh_cu'];
    }

    // Upload ảnh mới
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {

        $filename = time() . '_' . basename($_FILES['hinhanh']['name']);

        if (move_uploaded_file(
            $_FILES['hinhanh']['tmp_name'],
            'uploads/' . $filename
        )) {
            $hinhanh = $filename;
        }
    }

    // ===== CHẾ ĐỘ SỬA =====
    if ($isEdit) {

        $sql = "UPDATE tuyendung
                SET tieude = ?, hinhanh = ?, noidung = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $tieude,
            $hinhanh,
            $noidung,
            $id
        );
    }

    // ===== CHẾ ĐỘ THÊM MỚI =====
    else {

        $sql = "INSERT INTO tuyendung
                (tieude, hinhanh, noidung)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $tieude,
            $hinhanh,
            $noidung
        );
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: themtuyendung.php");
        exit();
    } else {
        echo "Có lỗi xảy ra!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">

<title>
<?php echo $isEdit ? 'Sửa tin tuyển dụng' : 'Đăng tin tuyển dụng'; ?>
</title>

<style>
body{
    font-family:'Segoe UI',sans-serif;
    padding:30px;
    background:#f4f6f9;
}

.form-box{
    max-width:700px;
    margin:0 auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

.form-group input[type=text],
.form-group textarea{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:6px;
}

.btn-submit{
    background:#007aff;
    color:#fff;
    border:none;
    padding:12px 20px;
    border-radius:6px;
    cursor:pointer;
}

.btn-cancel{
    margin-left:15px;
    color:#666;
    text-decoration:none;
}

img{
    border-radius:8px;
}
</style>

</head>
<body>

<div class="form-box">

<h2>
<?php
echo $isEdit
    ? "Chỉnh Sửa Tin Tuyển Dụng"
    : "Đăng Tin Tuyển Dụng Mới";
?>
</h2>

<form method="POST" enctype="multipart/form-data">

<?php if($isEdit): ?>
<input type="hidden"
       name="hinhanh_cu"
       value="<?php echo htmlspecialchars($post['hinhanh']); ?>">
<?php endif; ?>

<div class="form-group">
<label>Tiêu đề thông báo:</label>

<input type="text"
       name="tieude"
       required
       value="<?php echo htmlspecialchars($post['tieude'] ?? ''); ?>">
</div>

<div class="form-group">

<label>Hình ảnh:</label>

<?php if($isEdit && !empty($post['hinhanh'])): ?>

<img src="uploads/<?php echo htmlspecialchars($post['hinhanh']); ?>"
     width="150"
     style="display:block;margin-bottom:10px;">

<?php endif; ?>

<input type="file" name="hinhanh" accept="image/*">

</div>

<div class="form-group">

<label>Nội dung:</label>

<textarea name="noidung"
          rows="10"
          required><?php echo htmlspecialchars($post['noidung'] ?? ''); ?></textarea>

</div>

    <button class="btn-submit" type="submit">
        
    <?php echo $isEdit ? 'Cập nhật' : 'Đăng bài'; ?>
    </button>

    <a class="btn-cancel" href="index.php">
    Hủy bỏ
    </a>

</form>

</div>

</body>
</html>
```
