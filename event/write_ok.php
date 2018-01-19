<?php
header('Content-Type: text/html; charset=utf-8');

include "../db.php";
$sql = mq("insert into event(term,title,event) values('".$_POST['term']."','".$_POST['title']."','".$_POST['event']."')");
echo "<script>alert('글쓰기 완료되었습니다.');</script>";
?>
<meta http-equiv="refresh" content="0 url=../../event.php" />
