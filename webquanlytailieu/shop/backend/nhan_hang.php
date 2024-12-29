<?php
include 'header.php';
require_once 'connect.php';
// Truy vấn dữ liệu bảng lớp học
$catelog = mysqli_query($conn, "SELECT * FROM catelog");
?>

<?php
$error = '';
if (isset($_POST['catelogname'])) {
    $name = $_POST['catelogname'];
    if (empty($name)) {
        $error = 'Tên nhãn hàng không được để trống';
    }
    // nếu không có lỗi thì tiến hành thêm mới vào bảng
    if (!$error) {
        $sql = "INSERT INTO catelog(catelogname) VALUES('$name')";
        if (mysqli_query($conn, $sql)) {

            //Nếu thêm mới thành công, chuyển hướng trang

            header('location: nhan_hang.php');
        } else {

            // echo mysqli_error($conn);
            $error = 'Có lỗi, vui lòng thử lại';
        }
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title" >Thêm mới môn học</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form">
            <div class="form-group">
                <label for="">Tên môn học</label>

                <input type="text" class="form-control" name="catelogname" placeholder="Nhập tên môn học">

            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách môn học</h3>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên môn học</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- duyệt dữ liệu sử dụng vòng lặp foreach -->
            <?php foreach ($catelog as $row) : ?>
                <tr>
                    <td><?php echo $row['catelogid']; ?></td>
                    <td><?php echo $row['catelogname']; ?></td>
                    <td><?php echo $row['status'] == 1 ? 'Đang hoạt động' : 'Khóa'; ?></td>
                    <td>
                        <a href="/shop/backend/sua_nhan_hang.php?Catid=<?php echo $row['catelogid']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                        <a href="/shop/backend/xoa_nhan_hang.php?Catid=<?php echo $row['catelogid']; ?>" class="btn btn-xs btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>