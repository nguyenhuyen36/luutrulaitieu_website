<?php
ob_start();
require_once 'connect.php';
if (isset($_GET["invoiceId"])) {	
	$id = $_GET["invoiceId"];	
	
	// Cập nhật trạng thái đơn hàng
	$sql = "UPDATE `hoadon` SET `status`=2 WHERE `idhoadon` = ".$id;
	if (mysqli_query($conn, $sql)) {
		header("Location: order.php");
	} else {
		echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
	}
}
?>