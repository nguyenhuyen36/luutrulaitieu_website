<?php
include 'header.php';
require_once 'connect.php';

// Get the id from the URL parameter sent from the delete button
$id = !empty($_GET['idtailieu']) ? (int)$_GET['idtailieu'] : 0;

// Attempt to delete the record from the luutrutailieu table
$deleted = mysqli_query($conn, "DELETE FROM luutrutailieu WHERE idtailieu = $id");

if ($deleted) {
    header('location: tailieu.php'); // Redirect to the list page
    exit; // Ensure no further code is executed
} else {
    echo 'Có lỗi, vui lòng kiểm tra lại';
}
?>
