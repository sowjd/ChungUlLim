<?php
	include_once "connectDB.php";
	//header('Content-Type: text/html; charset=utf-8');

	$bno = $_POST['idx'];
	//$rlt = $connectDB->query("select * from Customer where idx='$bno';");
	//$event = mysqli_fetch_array($rlt);

    $rlt = $dbConnect->query("Update EventList set title='".$_POST['title']."',content='".$_POST['content']."',term='".$_POST['term']."',imgfile='".$_POST['imgfile']."' where idx='".$bno."'");
    $row=mysqli_fetch_array($rlt);

echo "<script>alert('수정되었습니다.');</script>";
?>
<meta http-equiv="refresh" content="0 url=../html/control.html" />
