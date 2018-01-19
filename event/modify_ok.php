<?php
	include "../db.php";
	header('Content-Type: text/html; charset=utf-8');

	$bno = $_POST['idx'];
	$sql = mq("select * from event where idx='$bno';");
	$event = $sql->fetch_array();

$sql2 = mq("update event set term='".$_POST['term']."',title='".$_POST['title']."',event='".$_POST['event']."' where idx='".$bno."'");
echo "<script>alert('수정되었습니다.');</script>";
?>
<meta http-equiv="refresh" content="0 url=../../event.php" />
