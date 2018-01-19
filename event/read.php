<!DOCTYPE html>
<html lang ="ko">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Set character encoding -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

    <style>
        body {
            margin: 0;
        }
        .image{
            position : relative;
            height: 726px;
            background: url(../darkcafeimage.jpg) no-repeat center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: calc(100vh);
            min-height: 200px;
        }
        .image.container{
        position:absolute;
        color:white;
        }
        .hello{
        color:white;
        font-size:3rem;
        text-align: center;
        }
        .event_read{
        position : absolute;
        color : white;
        }
        table{
        margin-left: auto;
        margin-right:auto;
        text-align: left;
        }
        .read w10 fl{
        text-align: center;
        }
        .read_nl fl{
        text-align: center;
        }
    </style>
    <link rel="icon" href="../../favicon.ico">
    <title>C_Add_Event</title>
    <link rel = "stylesheet" href="../../css/bootstrap.css">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css" />

   <script src="../js/jquery-3.1.0.min.js"></script>
</head>

<body>
    <?php
    include "../db.php";

    header('Content-Type: text/html; charset=utf-8');

        $bno = $_GET['idx'];
        $sql = mq("select * from event where idx='".$bno."'");
        $event = $sql->fetch_array();
    ?>
    <!--메뉴 바-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../index.html">ChungUlLim</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="../index.html">Home</a></li>
            <li><a href="../order.php">Order</a></li>
            <li><a href="../waitinglist.php">Waiting List</a></li>
            <li class="active"><a href="../event.php">Event</a></li>
            <li><a href="../login.php">Administrator Login</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="image"`>
        <br><br><br>
        <div class="container">
            <div class="starter-template">
                <h1 class = "hello">Event</h1>
            </div>
        </div><!-- /.container -->

        <!--event wrtie table-->
        <div class ="container">
        <div class = "jumbotron">
        <div id="event_read">
        <div class="container">
        <table class="table">
            <tr>
                <th width="30%" class="read w10 fl">Title</th>
                <td width="70%" class="read_con">&nbsp;<?php echo $event['title'];?></td>
            </tr>
            <tr>
                <th width="30%" class="read w10 fl">Term</th>
                <td width="70%" class="read_con">&nbsp;<?php echo $event['term'];?></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <th class="read_nl fl">Event</th>
<!--                <td width="70%"> </td>-->
            </tr>
            <tr>
                <td class="read_nl_con"><?php echo nl2br("$event[event]"); ?></td>
            </tr>
        </table>
        </div>
        </div>
            <div class="bo_ser">
                <a href="../event.php"><button type "button" class="btn btn-sm pull-left">Back</button></a>
                <a href="modify.php?idx=<?php echo $event['idx']; ?>"><button type "button" class="btn btn-sm pull-right">Modify</button></a>
                <a href="delete.php?idx=<?php echo $event['idx']; ?>"><button type "button" class="btn btn-sm pull-right">Delete</button></a>
            </div>
            <br>
        </div>
        </div>
    </div>

    <!--notification인데 event에서 쓰면될듯-->
    <!--
    <button class="js-notify-btn">알림 테스트</button>
    <button disabled class="js-push-btn">알림 받기 허용</button><br><br>
    -->

  <section class="js-sub-endpoint" style="display:none;width:80%">
    <h3 calss = "subscription">Subscription Object:</h3>
    <code class="js-subscription-json"></code><br><br><br>
    <h3>Endpoint URL:</h3>
    <code class="js-endpoint-url"></code>
  </section>

<script src="../../js/requestSubscription.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type = "text/javascript" src="../../js/bootstrap.js"></script>

    </body>
</html>
