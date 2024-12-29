<?php
ob_start();
include_once 'connect.php';

if (
    isset($_POST['dangky']) &&
    !empty($_POST['username']) &&
    !empty($_POST['password']) &&
    !empty($_POST['repassword']) &&
    isset($_POST['level'])
) {
    $name = htmlspecialchars($_POST['username']);
    $pas = htmlspecialchars($_POST['password']);
    $repass = htmlspecialchars($_POST['repassword']);
    $lev = htmlspecialchars($_POST['level']);

    if (strlen($pas) < 4) {
        echo "Mật khẩu phải có ít nhất 4 ký tự.";
    } elseif ($pas !== $repass) {
        echo "Mật khẩu không khớp.";
    } else {
        $pas = md5($pas);
        $repass = md5($repass);

        $sql = "INSERT INTO `admin`(`username`, `password`, `repassword`, `level`) VALUES 
            ('$name','$pas','$repass','$lev')";

        $dk_sql = mysqli_query($conn, $sql);

        if ($dk_sql) {
            echo "Đăng ký tài khoản thành công";
        } else {
            echo "Đăng ký tài khoản thất bại";
        }
    }
}
// Generate a secret token and store it in the session
$_SESSION['secret'] = md5(uniqid(rand(), true));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>

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
    <style>
        body {
            background-image: url("https://images.tmcnet.com/tmc/misc/articles/image/2019-mar/9594372213-bigstock-Abstract-blue-background-SUPERSIZE.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        legend {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .login-link {
            color: #007bff;
            text-decoration: none;
        }

        .login-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .eye-icon {
            cursor: pointer;
        }
    </style>

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="form-container">
            <form action="register.php" method="post">
                <legend class="text-center">Đăng Ký</legend>
                <div class="form-group">
                    <label for="">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <!-- <span class="input-group-text eye-icon" id="show-password-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye" viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                    </span> -->
                    <div class="alert alert-danger mt-2" id="password-error" style="display: none;">
                        Mật khẩu phải chứa ít nhất 4 ký tự số.
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Nhập lại mật khẩu</label>
                    <input type="password" name="repassword" class="form-control" required>
                </div>
                <!-- <div class="form-group">
                    <label for="">Level</label>
                    <input type="number" name="level" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="">Secret</label>
                    <input type="text" name="secret" class="form-control" required>
                </div> -->

                <button type="submit" name="dangky" class="btn btn-primary">Đăng ký</button>

                <div class="form-group text-center">
                    Bạn đã có tài khoản? <a href="login.php" class="login-link">Đăng nhập</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var passwordInput = document.getElementById('password');
            var passwordError = document.getElementById('password-error');
            var passwordToggleBtn = document.getElementById('show-password-toggle');

            passwordInput.addEventListener('input', function () {
                var passwordValue = passwordInput.value;

                if (passwordValue.length < 4 || /[^A-Za-z0-9]/.test(passwordValue)) {
                    passwordError.style.display = 'block';
                } else {
                    var numericCount = (passwordValue.match(/\d/g) || []).length;
                    if (numericCount < 4) {
                        passwordError.style.display = 'block';
                    } else {
                        passwordError.style.display = 'none';
                    }
                }
            });

            passwordToggleBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/><path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/></svg>';
                } else {
                    passwordInput.type = 'password';
                    passwordToggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/></svg>';
                }
            });
        });
    </script>

</body>

</html>