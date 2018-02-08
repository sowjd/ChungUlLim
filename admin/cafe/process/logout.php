<?php
    session_start();
    
	include_once "connectDB.php";

    unset($_SESSION['auth']);

    echo "<script>alert('로그아웃되었습니다.!');</script>";
    header("Refresh: 0; url='../html/login.html'");
?>