<?php
session_start();
ob_start();
require_once 'ketnoi.php';
$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>

    <link rel="stylesheet" href="main.css">

    <link rel="stylesheet" href="FontAwesome.Pro.6.3.0/css/all.css">

    <!--  -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />

    <style>
        swiper-container {
            width: 100%;
            height: 40vh;
        }

        swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart {
            width: 110px;
            height: auto;
            float: right;
            padding: 5px;
        }

        .cart>.g {
            color: black;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
        }

        .cart>.i {
            color: black;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            box-sizing: border-box;
        }

        .thoat {
            width: 110px;
            height: auto;
            float: right;
            padding: 5px;
            box-sizing: border-box;
            font-weight: bold;
        }

        .contact-links {
            display: flex;
        }

        .contact-links {
            display: flex;
            justify-content: space-between;
            /* Horizontal adjustment */
            align-items: center;
            /* Vertical adjustment */
            margin-top: 10px;
            /* Adjust top margin as needed */
            margin-bottom: 10px;
            /* Adjust bottom margin as needed */
        }

        .contact-links a {
            text-decoration: none;
            color: light blue;
            /* Adjust color as needed */
        }

        .contact-links a i {
            margin-right: 10px;
            /* Adjust right margin of the icon */
            margin-left: 10px;
            /* Adjust left margin of the icon */
        }

        .contact-links a:last-child {
            margin-left: auto;
            /* Push the Zalo link to the right */
        }
    </style>

</head>

<body>
    <div class="all">
        <div class="thanh">
            <swiper-container class="mySwiper" navigation="true" pagination="true" keyboard="true" mousewheel="true"
                css-mode="true">
                <swiper-slide><img style="object-fit: fill"
                        src="https://wowslider.com/sliders/demo-76/data1/images/bookshelf349946_1280.jpg" /></swiper-slide>
                <swiper-slide>Slide 2</swiper-slide>
                <swiper-slide>Slide 3</swiper-slide>
            </swiper-container>

            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
        </div>

        <div>
            <nav class="navbar navbar-expand-lg navbar-dark"
                style="display: flex; justify-content: space-between; background-color: #124773; height:10vh">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" style="display: flex; align-items: center; gap: 4px"
                            href="/shop/sanpham.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                color="white" class="bi bi-house" viewBox="0 0 16 16">
                                <path
                                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                            </svg>Trang chủ</a>
                    </li>
                </ul>
                <div style="display: flex; align-items:center; justify-content: space-between; width: 50%;">

                    <!-- tìm kiếm -->
                    <form style="display:flex; align-items:center; gap:12px;" action="/shop/sanpham.php" method="get">
                        <input style="padding: 4px; border-radius: 10px; width: 50vh" type="text" name="search"
                            id="search" placeholder="Tìm kiếm...">
                        <button style="padding: 0 8px 4px ; border-radius: 10px;" type="submit"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg></button>
                    </form>

                    <div style="width:1px; height: 6vh; background-color: gray"></div>

                    <!-- tài khoản -->
                    <a href="login.php" class="cart" style="display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-user" style="color: white; width: 24px"></i>
                        <?php
                        if (isset($_SESSION['login']['username'])) {
                            echo "<span style=\"font-weight:bold;color: white;\">{$_SESSION['login']['username']}</span>";
                            echo "<a href=\"login.php\" style=\"font-size: 16px; padding: 8px; background-color: #d4cbce; border-radius: 5px\">Đăng xuất</a>";
                        } else if (isset($_SESSION['admin']['username'])) {
                            echo "<span style=\"font-weight:bold;color: white;\">{$_SESSION['admin']['username']}</span>";
                            echo "<a href=\"login.php\" style=\"font-size: 16px; padding: 8px; background-color: #d4cbce; border-radius: 5px\">Đăng xuất</a>";
                        }
                        ?>
                    </a>
                </div>

            </nav>
        </div>
    </div>
</body>

</html>