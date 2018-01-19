<?php
	include "../db.php";
    header('Content-Type: text/html; charset=utf-8');
	$bno = $_GET['idx'];
	$sql = mq("select * from event where idx='$bno';");
	$event = $sql->fetch_array();
?>
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
        .event_write{
        position : absolute;
        color : white;
        }
        .text-center{
        text-align: center;
        }
        table{
        margin-left: auto;
        margin-right:auto;
        }
    </style>
    <link rel="icon" href="../../favicon.ico">
    <title>C_Modify_Event</title>
    <link rel = "stylesheet" href="../../css/bootstrap.css">    
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css" />

   <script src="../js/jquery-3.1.0.min.js"></script>
</head>    
        
<body>
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
        
        <!--event modify table-->
        <div class ="container">
        <div class = "jumbotron">
        <div id="event_write">
            <form action="modify_ok.php/<?php echo $event['idx']; ?>" method="post">
            <input type="hidden" name="idx" value="<?=$bno?>">
                    <table id="eventWrite">
                        <tr>
                            <td class="tb"><label for="utitle">Title</label></td>
                        </tr>
                        <tr>
                            <td height="30"><textarea name="title" id="utitle" class="form-control form-control-sm" rows="1"><?php echo $event['title']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb"><label for="uname">Term</label></td>
                        </tr>
                        <tr>
                            <td height="30"><textarea name="term" id="uname" class="form-control form-control-sm" id="inh" rows="1"><?php echo $event['term']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb"><label for="ucontent">Event</label></td>
                        </tr>
                        <tr>
                            <td height="30"><textarea name="event" id="ucontent" class="form-control form-control-sm" rows="6"><?php echo $event['event']; ?></textarea></td>
                        </tr>
                    </table>
                <div class="bt_se">
                    <button type "button" class ="btn btn-default btn-sm">Repost</button>
                </div>
            </form>
        </div>
            
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
