<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<body>

<?php
 $new_id=$_POST['new_id'];
 $new_pw=$_POST['new_pw'];
 $new_name=$_POST['new_name'];

if (filter_var($new_id, FILTER_VALIDATE_EMAIL) === false) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('유효하지 않은 이메일입니다.');";
    echo "window.location.replace('signup.php');</script>";
    exit;
  }

if ($new_pw=="") {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('비밀번호를 입력해 주세요.');";
    echo "window.location.replace('signup.php');</script>";
    exit;
}

if ($new_name=="") {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('카페이름을 입력해 주세요.');";
    echo "window.location.replace('signup.php');</script>";
    exit;
}
  
include("../db.php");
 $mysqli = new mysqli($host, $user, $pw, $dbName); //mysql로 접근 하도록 설정
 $sql = "insert into Admin (id, pw, cafeName)";
 $sql = $sql. "values('$new_id','$new_pw','$new_name')"; //$sql = $sql.  점의 의미는 기존변수의 문자열에 다른 문자를 추가시키는 의미입니다.
 
 if($mysqli->query($sql)){ //쿼리문이 잘 들어갔다면
  //echo 'success inserting';
  header("Content-Type: text/html; charset=UTF-8");
  echo "<p>가입완료!</p>";
  echo "</br>\n";
  echo "<p><a href=\"../index.html\">[홈페이지]</a></p>";
  echo "<p><a href=\"../login/login.php\">[로그인]</a></p>";
 }else{
  echo 'fail to insert sql';
 }
?>
 
<script src"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>