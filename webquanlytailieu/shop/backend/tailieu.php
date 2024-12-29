<?php
include 'header.php';
require_once 'connect.php';

// Count total pages for luutrutailieu
$sql = "SELECT CEIL((SELECT COUNT(*) FROM `luutrutailieu`) / 6) AS 'totalpage'";
$result = mysqli_query($conn, $sql);
$totalpage = mysqli_fetch_assoc($result)['totalpage'] ?? 1;

// Get the current page
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$page = max(1, min($page, $totalpage)); // Ensure page is within bounds
$offset = ($page - 1) * 6; // Calculate offset for LIMIT clause

// Fetch paginated results from luutrutailieu, ordered by idtailieu
$sql = "SELECT l.idtailieu, c.catelogname AS 'tenNhanHang', l.tentailieu, l.imgae, l.noidung, l.tailieu 
        FROM luutrutailieu l 
        JOIN catelog c ON l.catelogid = c.catelogid 
        ORDER BY l.idtailieu ASC 
        LIMIT $offset, 6";
$tailieu = mysqli_query($conn, $sql);
?>

<style>
    .phan-trang {
        width: 100%;
        text-align: center;
        list-style: none;
        font-weight: bold;
        font-size: 1.5em;
        overflow: hidden;
        margin: 20px auto;
    }

    .phan-trang li {
        display: inline;
        border: 1px solid #ebebeb;
    }

    .phan-trang a {
        padding: 25px 15px;
        text-decoration: none;
    }
</style>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách tài liệu</h3>
    </div>
    
    <?php if (mysqli_num_rows($tailieu) > 0): ?>
        <ul class="phan-trang">
            <?php for ($i = 1; $i <= $totalpage; $i++): ?>
                <li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
        
        <table class="table table-bordered table-hover" style="border: solid #ebebeb 1px">
            <thead>
                <tr>
                    <th>ID tài liệu</th>
                    <th>Môn học</th>
                    <th>Tên tài liệu</th>
                    <th>Ảnh mẫu</th>
                    <th>Nội dung</th>
                    <th>Tài liệu học tập</th>
                    <th>
                        <a href="/shop/backend/themtailieu.php" class="btn btn-primary">Thêm tài liệu</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($tailieu)): ?>
                    <?php 
                    // Split multiple tailieu into an array
                    $tailieuFiles = explode(",", $row['tailieu']);
                    ?>
                    <tr>
                        <td><?php echo $row['idtailieu']; ?></td>
                        <td><?php echo $row['tenNhanHang']; ?></td>
                        <td><?php echo $row['tentailieu']; ?></td>
                        <td>
                            <img width="100px" height="auto" src="/shop/uploads/<?php echo $row["imgae"]; ?>" alt="<?php echo $row["tentailieu"]; ?>">
                        </td>
                        <td><?php echo $row['noidung']; ?></td>
                        <td>
                            <?php foreach ($tailieuFiles as $file): ?>
                                <?php $extension = pathinfo($file, PATHINFO_EXTENSION); ?>
                                <?php if (in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                    <img src='/shop/uploads/<?php echo $file; ?>' width='100px' height='auto' alt='Tài liệu'><br>
                                <?php elseif (in_array($extension, ['pdf', 'docx', 'ppt'])): ?>
                                    <a href='/shop/uploads/<?php echo $file; ?>' target='_blank'><?php echo basename($file); ?></a><br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <a href="/shop/backend/suatailieu.php?idtailieu=<?php echo $row['idtailieu']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                            <a href="/shop/backend/xoatailieu.php?idtailieu=<?php echo $row['idtailieu']; ?>" class="btn btn-xs btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có tài liệu nào.</p>
    <?php endif; ?>
</div>
