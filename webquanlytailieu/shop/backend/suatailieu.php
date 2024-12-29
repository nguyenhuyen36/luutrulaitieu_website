<?php
include 'header.php';
require_once 'connect.php';
require_once 'uploadfiles.php';

// Fetching catalog data
$catelog = mysqli_query($conn, "SELECT * FROM catelog");

// Fetching the document details for update
$id = !empty($_GET['idtailieu']) ? (int)$_GET['idtailieu'] : 0;
$result = mysqli_query($conn, "SELECT l.idtailieu, c.catelogid, c.catelogname as 'tenNhanHang', l.tentailieu, l.imgae, l.noidung, l.tailieu
                                FROM luutrutailieu l JOIN catelog c ON l.catelogid = c.catelogid WHERE l.idtailieu = $id");
$rowTL = mysqli_fetch_assoc($result);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idnhanhang = $_POST['catelogid'];
    $tentailieu = $_POST['tentailieu'];
    $desc = $_POST['noidung'];

    // Validate document name
    if (empty($tentailieu)) {
        $error = 'Tên tài liệu không được để trống';
    }

    // Handle image upload
    $image = $rowTL['imgae']; // Keep the existing image if not replaced
    if (!empty($_FILES["imgae"]["name"])) {
        $isUploadOk = uploadFile($_FILES["imgae"], $tentailieu);
        if ($isUploadOk) {
            $image = str_replace(" ", "_", $tentailieu) . ".jpg"; // Default image name
        } else {
            $error = "Upload file ảnh thất bại";
        }
    }

    // Handle multiple file uploads (PDF, DOCX, PPT, Images)
    $uploadedFiles = [];
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/shop/uploads/'; // Absolute path

    // Ensure the directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Create the directory if it doesn't exist
    }

    foreach ($_FILES['tailieu']['name'] as $key => $fileName) {
        if ($_FILES['tailieu']['error'][$key] == 0) {
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = ['pdf', 'docx', 'ppt', 'jpg', 'jpeg', 'png'];

            // Check if file type is allowed
            if (in_array(strtolower($fileType), $allowedTypes)) {
                $sanitizedFileName = str_replace(" ", "_", basename($fileName)); // Replace spaces with underscores
                $targetFile = $targetDir . $sanitizedFileName;

                // Check for file upload success
                if (move_uploaded_file($_FILES["tailieu"]["tmp_name"][$key], $targetFile)) {
                    $uploadedFiles[] = $sanitizedFileName;  // Store the sanitized file name
                } else {
                    $error = "Không thể tải tệp tin " . $fileName . " vào thư mục: " . $targetFile . "<br>";
                }
            } else {
                $error = "Định dạng tệp tin " . $fileName . " không được hỗ trợ.<br>";
            }
        } elseif ($_FILES['tailieu']['error'][$key] != 0) {
            $error = "Lỗi tải lên tệp tin: " . $_FILES['tailieu']['error'][$key] . "<br>";
        }
    }

    // If no errors, update data in the database
    if (empty($error)) {
        $filePaths = !empty($uploadedFiles) ? implode(",", $uploadedFiles) : $rowTL['tailieu']; // Keep existing if no new uploads

        $sql = "UPDATE luutrutailieu SET catelogid ='$idnhanhang', `tentailieu`='$tentailieu', `imgae`='$image', `noidung`='$desc',
                `tailieu`='$filePaths' WHERE `idtailieu`= $id";

        if (mysqli_query($conn, $sql)) {
            header('Location: tailieu.php');
            exit;
        } else {
            $error = 'Có lỗi, vui lòng thử lại';
        }
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Cập nhật tài liệu</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="catelogid">Tên nhãn hàng</label>
                <select name="catelogid" class="form-control" required>
                    <option value="">Chọn Nhãn Hàng</option>
                    <?php foreach ($catelog as $row): ?>
                        <option value="<?php echo $row['catelogid']; ?>" <?php echo ($row['catelogid'] == $rowTL['catelogid']) ? 'selected' : ''; ?>>
                            <?php echo $row['catelogname']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tentailieu">Tên tài liệu</label>
                <input type="text" class="form-control" name="tentailieu" value="<?php echo isset($rowTL['tentailieu']) ? htmlspecialchars($rowTL['tentailieu']) : ''; ?>" placeholder="Nhập tên tài liệu" required>
            </div>
            <div class="form-group">
                <label for="imgae">Ảnh Mẫu</label>
                <input type="file" class="form-control" name="imgae">
                <?php if (!empty($rowTL['imgae'])): ?>
                    <img width="200" height="200" src="<?php echo "/shop/uploads/" . htmlspecialchars($rowTL['imgae']); ?>" alt="Ảnh mẫu">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="noidung">Mô tả</label>
                <input type="text" class="form-control" name="noidung" value="<?php echo isset($rowTL['noidung']) ? htmlspecialchars($rowTL['noidung']) : ''; ?>" placeholder="Nhập mô tả" required>
            </div>
            <div class="form-group">
                <label for="tailieu">Tài liệu học tập</label>
                <input type="file" class="form-control" name="tailieu[]" multiple accept=".pdf,.docx,.ppt,.jpg,.jpeg,.png">
                <small class="form-text text-muted">Chấp nhận các định dạng: PDF, DOCX, PPT, JPG, PNG.</small>
            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</div>
