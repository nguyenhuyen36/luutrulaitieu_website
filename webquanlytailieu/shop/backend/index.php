<?php include 'header.php'; ?>
<div class="jumbotron">
    <div class="container">
        <?php
            if (isset($_SESSION['admin']['username'])) {
                echo "<p style=\"font-size: 24px; margin-top: 10px; color: black;\">Xin chào <b style=\"font-weight: bold; color:#124773;\">{$_SESSION['admin']['username']}</b></p> ";
            } 
            ?>
        <h1 style="text-align:center; margin: 10% auto">Hệ Thống Quản Lý Lưu Trữ Tài Liệu Học Tập</h1>
        <p style="text-align:center;">
            <a href="/shop/sanpham.php" class="btn btn-primary btn-lg">Xem web lưu trữ tài liệu học tập!</a>
        </p>
    </div>
</div>