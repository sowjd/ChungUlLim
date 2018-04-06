<?php
	include_once "connectDB.php";

    $dbConnect->query("DELETE FROM Customer");
    $rlt = $dbConnect->query("ALTER TABLE Customer AUTO_INCREMENT=1");
    $row=mysqli_fetch_array($rlt);

    echo "<script>alert('마감처리 되었습니다.');</script>";
?>
<meta http-equiv="refresh" content="0 url=../html/control.html" />
