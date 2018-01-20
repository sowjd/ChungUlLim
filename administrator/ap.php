<!DOCTYPE html>
<?php session_start(); ?> 
<html>
    <head>
        <meta charset="utf-8" /> <!-- 한글 쓸수있게!-->
        <title>Administrator</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    </head>

    <body>
    <?php
    if(!isset($_SESSION['user_id'])) {
         header("Content-Type: text/html; charset=UTF-8");
         echo "<script>alert('로그인이 필요합니다.');";
         echo "window.location.replace('../login/login.php');</script>";
         exit;
     }  
    ?>

    <div class="container">
    <button class="btn btn-lg btn-block" onclick="location.href='ap_orderlist.php'">푸시알림 보내기</button>
    <button class="btn btn-lg btn-block">매출 확인</button>
    <button class ="btn btn-lg btn-block">음료메뉴 관리</button>
    <button class="btn btn-lg btn-block">이벤트 관리</button>
    </div>

    <script src"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    </body>
</html>