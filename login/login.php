<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    </head>
    <body>
        <hr />
        <h2>로그인</h2>
        <?php if(!isset($_SESSION['user_id'])) { ?>
        <form method="post" action="login_check.php">
            <p>아이디: <input type="text" name="user_id" /></p>
            <p>비밀번호: <input type="password" name="user_pw" /></p>
            <p><input type="submit" value="로그인" /></p>
            </br>
            <p><a href="../signup/signup.php"> [회원가입]</a></p>
        </form>
        <?php } else {
              /*
             $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['user_name'];
          
            echo "<p><strong>$user_name</strong>($user_id)님은 이미 로그인하고 있습니다. ";
            echo "<a href=\"../index.html\">[돌아가기]</a> ";
            echo "<a href=\"logout.php\">[로그아웃]</a></p>";
            */
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('잘못된 접근입니다.');";
        echo "window.location.replace('../index.html');</script>";
        exit;
    
        } ?>

        <script src"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
    </body>
</html>