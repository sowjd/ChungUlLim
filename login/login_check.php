<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<body>
    <script src"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>

<?php
  $user_id = $_POST['user_id'];
  $user_pw = $_POST['user_pw'];
  include("../db.php");
  $mysqli = new mysqli($host, $user, $pw, $dbName); //mysql로 접근 하도록 설정

  if(($user_id =='')||($user_pw == '')){
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('아이디 또는 비밀번호 입력이 완전하지 않습니다.');";
    echo "window.location.replace('login.php');</script>";
    exit;
    }

  
    $sql = "SELECT cafeName FROM Admin WHERE id = '$user_id' AND pw = '$user_pw'";
    $res = $mysqli->query($sql); //실행결과는 $res에 저장
   $row = $res->fetch_array(MYSQLI_ASSOC); // 넘어온 결과를 한 행씩 패치해서 $row라는 배열에 담는다.
   
   if ($row == null) { 
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('로그인 정보가 옳바르지 않습니다.');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }
    /* If success */
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_pw'] = $user_pw;
    $_SESSION['user_name'] = $row['cafeName'];
?>
<meta http-equiv="refresh" content="0;url=../index.html" />