<?php
	include "db.php";
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
            background: url(darkcafeimage.jpg) no-repeat center center; 
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
        .event_area{
        position : absolute;
        color : white;
        }
        .text-center{
            text-align: center;
        }
    </style>
    <link rel="icon" href="../../favicon.ico">
    <title>C_Event</title>
    <link rel = "stylesheet" href="../css/bootstrap.css">    
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />

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
          <a class="navbar-brand" href="index.html">ChungUlLim</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a href="waitinglist.php">Waiting List</a></li>
            <li class="active"><a href="event.php">Event</a></li>
            <li><a href="login.php">Administrator Login</a></li>
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
        
        <!--event table-->
        <div class ="container">
        <div class = "jumbotron">
        <div id="event_area">
            <div class="container">
            <button type="button" class="btn btn-sm pull-left" class="js-notify-btn">알림 테스트</button>
            <button type="button" class="btn btn-sm pull-left" disabled class="js-push-btn">알림 받기 허용</button><br><br><br>
                
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="10%">Num</th>
                        <th width="70%">Sale</th>
                        <th width="20%">Term</th>
                    </tr>
                </thead>
            <?php
                $sql = mq("select * from event order by idx desc limit 0,5");
                    while($event = $sql->fetch_array()){
                        $title=$event["title"];
                            if(strlen($title)>30){
                                $title=str_replace($event["title"],mb_substr($event["title"],0,30,"utf-8")."...",$event["title"]);
                            }
            ?>
                <tbody>
                    <tr>
                      <td width="10%"><?php echo $event['idx']; ?></td>
                      <td width="70%"><a href="event/read.php?idx=<?php echo $event['idx']; ?>"><?php echo $title;?></a></td>
                      <td width="20%"><?php echo $event['term']?></td>
                </tr>
                </tbody>
            <?php } ?>
            </table>
            </div>
            <div class="write_btn">
                <a href="event/write.php"><button type="button" class="btn btn-sm pull-right">New Event</button></a>
            </div>
            <div class = "text-center">
                <ul class= "pagination">
                    <li><a href="#" class="btn-sm">1</a></li>
                    <li><a href="#" class="btn-sm">2</a></li>
                    <li><a href="#" class="btn-sm">3</a></li>
                    <li><a href="#" class="btn-sm">4</a></li>
                    <li><a href="#" class="btn-sm">5</a></li>
                </ul>
            </div>
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

<script src="../js/requestSubscription.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type = "text/javascript" src="../js/bootstrap.js"></script>

    </body> 
</html>
