<?php
session_start();
ob_start();
    if (!isset($_SESSION['admin']['username'])) {
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title site</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container" style="display: flex; justify-content: space-between; align-items:center; width: 100%; height: 10vh; background-color: #124773">
            <a href="/shop/backend/"><img src="https://png.pngtree.com/png-vector/20240515/ourlarge/pngtree-an-open-book-logo-png-image_12467718.png" alt="Logo" style="max-width: 45px"></a>
            <ul class="nav navbar-nav">
                <li><a href="/shop/backend/" style="color: #ffffff; font-size: 16px">Trang chủ</a></li>
                <li><a href="/shop/backend/nhan_hang.php/" style="color: #ffffff; font-size: 16px">Môn học</a></li>
                <li><a href="/shop/backend/tailieu.php/" style="color: #ffffff; font-size: 16px"; >Tải lên & Quản lý tài liệu</a></li>
            </ul>
            <div>
                <?php
                    if (isset($_SESSION['admin']['username'])) {
                        echo "<a href=\"logout.php\" style=\"font-size: 16px; padding: 8px; background-color: #d4cbce; border-radius: 5px\">Đăng xuất</a>";
                    } else {
                        echo "<li style=\"font-size: 16px; margin-top: 12px; color:white;\">AD Đăng nhập</li><li><a href=\"login.php\" style=\"font-size: 20px; \">Tại đây</a></li>";
                    }
                ?>
            </div>
        </div>
    </nav>
    <div class="container"> <!-- Thẻ mở .container -->