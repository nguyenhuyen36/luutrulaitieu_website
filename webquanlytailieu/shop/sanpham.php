<?php
require_once 'dieuhuong.php'; 
require_once 'ketnoi.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài liệu</title>
    <link rel="stylesheet" href="main.css">

    <style>
        /* Document display container */
        .fe {
            width: calc(20% - 20px); /* 5 documents per row with some margin */
            height: auto;
            text-align: center;
            padding: 10px;
            margin: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fafafa;
        }

        /* Image styling */
        .fe img {
            width: auto; /* Width set to auto */
            height: 160px; /* Fixed height */
            object-fit: cover;
            border-radius: 8px;
        }

        /* Document name */
        .document-name {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #333;
        }

        /* Button styling */
        .btn-outline-primary {
            display: inline-block;
            padding: 10px; /* Bigger padding for PDF */
            border: 1px solid #007bff;
            color: #007bff;
            background-color: transparent;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 5px;
            font-size: 14px; /* Bigger font size for PDF */
            transition: all 0.3s ease;
        }

        .btn-outline-docx {
            display: inline-block;
            padding: 2px 4px; /* Smaller padding for DOCX */
            border: 1px solid #007bff;
            color: #007bff;
            background-color: transparent;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 5px;
            font-size: 10px; /* Smaller font size for DOCX */
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-outline-docx:hover {
            background-color: #007bff;
            color: white;
        }

        .block {
            display: flex;
            flex-direction: column;
        }

        .block-right {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .phantrang {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .phan-trang {
            width: 100%;
            text-align: center;
            list-style: none;
            font-weight: bold;
            font-size: 1.5em;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .phan-trang li {
            display: inline;
        }

        .phan-trang a {
            padding: 10px;
            border: 1px solid #ebebeb;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="block">
        <div>
            <div class="block-left" style="background: radial-gradient(827px at 47.3% 48%, rgb(255, 255, 255) 0%, rgb(138, 192, 216) 90%); height:100vh; margin:5vh 0;">
                <?php require_once 'catelog.php'; ?>
            </div>

            <div class="block-right" style="height:100vh; margin:5vh 0">
                <?php
                // Pagination logic
                $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;

                // Set up the base SQL query for luutrutailieu
                $sql = "SELECT * FROM luutrutailieu";

                // Append WHERE clause for catalog ID if provided
                if (isset($_GET['catelogid'])) {
                    $catelogid = mysqli_real_escape_string($conn, $_GET['catelogid']);
                    $sql .= " WHERE catelogid = '$catelogid'";
                }

                // Append WHERE clause for search keyword if provided
                if (isset($_GET["search"])) {
                    $search = mysqli_real_escape_string($conn, $_GET["search"]);
                    $sql .= (strpos($sql, 'WHERE') === false) ? ' WHERE' : ' AND';
                    $sql .= " tentailieu LIKE '%$search%'";
                }

                // Count the total number of rows
                $result = mysqli_query($conn, $sql);
                $totalRows = mysqli_num_rows($result);
                $totalpage = ceil($totalRows / 5); // Display 5 documents per page

                // Calculate OFFSET based on current page
                $offset = ($page > 1) ? ($page - 1) * 5 : 0;

                // Update the SQL query to include LIMIT and OFFSET
                $sql .= " LIMIT $offset, 5";

                // Fetch documents based on the updated SQL query
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) {
                ?>
                        <div class="fe">
                            <div>
                                <img src="uploads/<?php echo htmlspecialchars($row["imgae"]); ?>" alt="<?php echo htmlspecialchars($row["tentailieu"]); ?>">
                            </div>
                            <br>
                            <div style="height:15vh">
                                <span class="document-name"><?php echo htmlspecialchars($row["tentailieu"]); ?></span><br>
                            </div>
                            <div>
                                <?php
                                if (!empty($row["tailieu"])) {
                                    $tailieu = explode(",", $row["tailieu"]); // Assume tailieu are comma-separated paths
                                    foreach ($tailieu as $file) {
                                        $filePath = 'uploads/' . htmlspecialchars($file);
                                        $extension = pathinfo($file, PATHINFO_EXTENSION);

                                        // Display based on file type
                                        switch ($extension) {
                                            case 'jpg':
                                            case 'jpeg':
                                            case 'png':
                                                echo "<img src='$filePath' width='auto' height='160px' alt='Tài liệu'><br>";
                                                echo "<a href='$filePath' download class='btn btn-outline-primary'>Download Image</a><br>";
                                                break;
                                            case 'pdf':
                                                echo "<embed src='$filePath' width='100%' height='200px' type='application/pdf'><br>";
                                                echo "<a href='$filePath' download class='btn btn-outline-primary'>Download PDF</a><br>";
                                                break;
                                            case 'docx':
                                            case 'ppt':
                                            case 'pptx':
                                                echo "<iframe src='https://docs.google.com/gview?url=$filePath&embedded=true' width='100%' height='200px' frameborder='0'></iframe><br>";
                                                echo "<a href='$filePath' download class='btn btn-outline-primary
                                                '>Download File</a><br>";
                                                break;
                                            default:
                                                echo "<p>Unsupported file type.</p>";
                                                break;
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <br>
                        </div>
                <?php
                    }
                ?>
                <br>
                <!-- Pagination -->
                <div class="phantrang">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- Previous page link -->
                            <?php if ($page > 1) : ?>
                                <li class="page-item"><a class="page-link" href="sanpham.php?page=<?php echo $page - 1 ?>"><<</a></li>
                            <?php endif; ?>

                            <!-- Page number links -->
                            <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="sanpham.php?page=<?php echo $i ?>"><?php echo $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next page link -->
                            <?php if ($page < $totalpage) : ?>
                                <li class="page-item"><a class="page-link" href="sanpham.php?page=<?php echo $page + 1 ?>">>></a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php
                } else {
                    echo "<p>Không có tài liệu nào.</p>";
                }
                ?>
            </div>
        </div>
        <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
    </div>
</body>

</html>
