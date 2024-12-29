<?php
include 'header.php';
require_once 'connect.php';
require_once 'uploadfiles.php';

// Fetching catalog data
$catelog = mysqli_query($conn, "SELECT * FROM catelog");

$error = '';
if (isset($_POST['tentailieu'])) {
    $idnhanhang = $_POST['catelogid'];
    $tentailieu = $_POST['tentailieu'];
    $desc = $_POST['noidung']; // Keep the description field

    // Validate document name
    if (empty($tentailieu)) {
        $error = 'Tên tài liệu không được để trống';
    }

    // Handle image upload
    $isUploadOk = uploadFile($_FILES["imgae"], $tentailieu);
    $image = str_replace(" ", "_", $tentailieu) . ".jpg"; // Default image name

    if (!$isUploadOk) {
        $error = "Upload file ảnh thất bại";
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
                    $uploadedFiles[] = $sanitizedFileName; // Store the sanitized file name
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

    // If no errors, insert data into the database
    if (empty($error)) {
        $filePaths = !empty($uploadedFiles) ? implode(",", $uploadedFiles) : '';

        // Insert into the database (removed noidungchitiet)
        $sql = "INSERT INTO `luutrutailieu`(`catelogid`, `tentailieu`, `imgae`, `noidung`, `tailieu`) 
                VALUES ('$idnhanhang','$tentailieu','$image','$desc', '$filePaths')";

        if (mysqli_query($conn, $sql)) {
            header('location: tailieu.php');
            exit();
        } else {
            $error = 'Có lỗi khi lưu vào cơ sở dữ liệu, vui lòng thử lại.';  // Error in SQL execution
        }
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Thêm mới tài liệu</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="">Tên môn học</label>
                <select name="catelogid" class="form-control" required>
                    <option value="">Chọn môn học</option>
                    <?php foreach ($catelog as $row) : ?>
                        <option value="<?php echo $row['catelogid']; ?>"><?php echo $row['catelogname']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Tên tài liệu</label>
                <input type="text" class="form-control" name="tentailieu" placeholder="Nhập tên tài liệu" required>
            </div>
            <div class="form-group">
                <label for="">Ảnh Mẫu</label>
                <input type="file" class="form-control" name="imgae" required> 
            </div>
            <div class="form-group">
                <label for="">Mô tả</label>
                <input type="text" class="form-control" name="noidung" placeholder="Nhập mô tả" required>
            </div>
            <div class="form-group">
                <label for="">Tài liệu học tập</label>
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
