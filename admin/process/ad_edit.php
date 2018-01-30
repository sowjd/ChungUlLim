<?php
    include "connectDB.php";
    $bno = $_GET['idx'];
    $rlt = $dbConnect->query("select * from Customer where idx='$bno';");
    $Customer = mysqli_fetch_array($rlt);
?>
<!DOCTYPE html>
<html lang ="ko">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Set character encoding -->
  <meta charset="utf-8">
  <title>A_Push</title>
  <link rel = "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>
<body>
    <style>
        body {
            margin: 0;
        }
        .image{
            position : relative;
            height: 726px;
            background: url(../images/darkcafeimage.jpg) no-repeat center center;
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
        .push_edit{
        position : absolute;
        color : white;
        }
        .text-center{
            text-align: center;
        }
				tr{
					text-align: center;
				}
    </style>
    <!--메뉴 바-->
    <!--
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
            <li><a href="../order/order.php">Order</a></li>
            <li><a href="../waiting/waitinglist.php">Waiting List</a></li>
            <li><a href="../event/event.php">Event</a></li>
            <li><a href="../administrator/login.php">Administrator Login</a></li>
          </ul>
        </div>
      </div>
    </nav>-->

    <div class="image"`>
        <br><br><br>
        <div class="container">
            <div class="starter-template">
                <h1 class = "hello">Push Page</h1>
            </div>
        </div><!-- /.container -->

        <!--event table-->
        <div class ="container">
        <div class = "jumbotron">
        <div id="push_edit">
          <form action="ad_edit_ok.php" method="post">
          <input type="hidden" name="idx" value="<?=$bno?>">
                  <table id="eventWrite">
                      <tr>
                          <td class="tb"><label for="unickname">Nickname</label></td>
                      </tr>
                      <tr>
                          <td height="30"><textarea name="nickname" id="unickname" class="form-control form-control-sm" id="inh" rows="1"><?php echo $Customer['nickname']; ?></textarea>
                          </td>
                      </tr>
                      <tr>
                          <td class="tb"><label for="utime">Time</label></td>
                      </tr>
                      <tr>
                          <td height="30"><textarea name="time" id="utime" class="form-control form-control-sm" rows="1"><?php echo $Customer['time']; ?></textarea>
                          </td>
                      </tr>
                      <tr>
                          <td class="tb"><label for="ureception">Reception</label></td>
                      </tr>
                      <tr>
                          <td height="30"><textarea name="reception" id="ureception" class="form-control form-control-sm" rows="1"><?php echo $Customer['reception']; ?></textarea>
                          </td>
                      </tr>
                  </table>
              <div class="bt_se">
                  <input type="submit" class="btn btn-default btn-sm" value="수정하기">
              </div>
          </form>
        </div>
        </div>
        </div>

    </div>

<script src="../../bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>

    </body>
</html>
