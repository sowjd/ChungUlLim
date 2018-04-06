<?php
    include "connectDB.php";
    $bno = $_GET['idx'];
    $rlt = $dbConnect->query("select * from EventList where idx='$bno';");
    $List = mysqli_fetch_array($rlt);
?>
<!DOCTYPE html>
<html lang ="ko">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Set character encoding -->
  <meta charset="utf-8">
  <title>A_Push</title>
  <link rel = "stylesheet" href="../../../bootstrap/css/bootstrap.css">
</head>
<body>
    <style>
        body {
            margin: 0;
        }
        .image{
            position : relative;
            height: 726px;
            background: url(../../../images/orange.jpg) no-repeat center center;
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
 <div class="image"`>
        <br><br><br>
        <div class="container">
            <div class="starter-template">
                <h1 class = "hello">이벤트 수정</h1>
            </div>
        </div>

        <div class ="container">
        <div class = "jumbotron">
        <div id="push_edit">
        <form action="ad_edit_ok.php" method="post">
        <input type="hidden" name="idx" value="<?=$bno?>">
        <div class="form-group">
          <label for="title">제목</label>
         <textarea class="form-control" id="title" name="title" rows="3"><?php echo $List['title']; ?></textarea>       
        </div>
        <div class="form-group">
          <label for="content">내용</label>
          <textarea class="form-control" id="content" name="content" rows="3"><?php echo $List['content']; ?></textarea> 
        </div>
        <div class="form-group">
          <label for="term">진행기간</label>
          <textarea class="form-control" id="term" name="term"><?php echo $List['term']; ?></textarea> 
        </div>

        <div class="form-group">
        이미지 기존거 어떻게 나타내냐...ㅠㅠ
<input type="file" size=100 name="upload"><?php echo $List['imgfile']; ?><hr>
    </div>
<button type="submit" class="btn btn-primary pull-right">완료</button>
      </form>
      </div>
  </div>
  </div>
  </body>
  </html>



<!--

  
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
!-->
<script src="../../../bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.js"></script>

    </body>
</html>
