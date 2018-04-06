<?php
	include_once "connectDB.php";

    $dbConnect->query("DELETE FROM Customer WHERE reception='수신 확인'");
    
?>
<meta http-equiv="refresh" content="0 url=../html/control.html" />
