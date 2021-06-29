<?php
 	session_start();
	if(isset($_POST['logout'])){
		unset($_SESSION['dangnhap']);
	}
	header('location:index.php?xem=cart');
?>