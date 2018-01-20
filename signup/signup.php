<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>SignUp</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    </head>
    <body>
        <?php if(!isset($_SESSION['user_id'])) { ?>
        <h2>회원가입</h2>
        <form method="post" action="signup_save.php">
        <p>아이디: <input type="text" name="new_id" placeholder="유효한 이메일을 적어주세요"/></p>
        <p>비밀번호: <input type="password" name="new_pw" placeholder="15자 이내" /></p>
        <p>카페이름: <input type="text" name="new_name" placeholder="10자 이내" /></p>
        <p><input type="submit" value="가입" /></p>
        </form>
        <?php } 
        else {
            header("Content-Type: text/html; charset=UTF-8");
            echo "<script>alert('잘못된 접근입니다.');";
            echo "window.location.replace('../index.html');</script>";
            exit;
            } 
        ?>

        <script src"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
    </body>
</html>