<?php
session_start();
if (isset($_SESSION['login']) == false) {
  print 'ログインしてください。';
  print '<br><a href="./index.html">もどる</a>';
  exit();
} else {
  require_once('./DB_Query.php');
?>
  <!DOCTYPE html>
  <html lang="ja">

  <head>
    <meta charset="utf-8">
    <title>時間記録</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- css -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+JP">
    <link rel="icon" href="p-favicon.ico" type="image/x-icon">
    <script src="jquery-3.6.0.min.js"></script>
    <style>
      .bottom {
        display: flex;
        justify-content: space-evenly;
        width: 100%;
      }

      button,
      a {
        color: black;
        text-decoration: none;
        display: block;
        width: fit-content;
      }

      input[type="text"] {
        background-color: #fffaf0;
      }

      td {
        text-align: center;
      }

      .wrapper {
        text-align: center;
        width: 80%;
        height: 55vh;
        background: #fffaf0;
        margin: 10%;
        padding: 2%;
      }

      @media (max-width: 650px) {
        div {
          text-align: center;
        }

        button,
        a {
          display: inline;
          margin-left: 0%;
        }
      }
    </style>
  </head>

  <body>
    <main>
    <?php
      $dbQuery = new dbQuery();
      // 今日分のcontentレコード取得
      $sql = 'select location_name, start_or_stop, time_stamp, detail
              from contents
              LEFT OUTER Join geolocation on contents.place_code = geolocation.code
              where member_code = \''.$_SESSION['code'].'\' AND time_stamp >= CURRENT_DATE
              ORDER BY time_stamp ASC';
      $todayContents = $dbQuery->returnRecAll($sql);
    ?>

      <form id="form1" action="main-branch.php" method="POST">
        <div style="width: 100%;text-align: center;margin-top: 10%;">
          <p>現在の場所は</p>
          <p id="geol"></p>
          <p>です。</p>
        </div>
        <table id="tabledata" style="width: 100%;margin-top: 5%;margin-bottom: 10%;">
        <?php
          if(count($todayContents) > 0) {
            print '<tr>';
            print  '<th>時間</th>';
            print  '<th>終始</th>';
            print  '<th>場所</th>';
            print  '<th>内容</th>';
            print '</tr>';
            foreach($todayContents as $key => $val) {
              print '<tr>';
              print '<td>'.$val['time_stamp'].'</td>';
              print '<td>'.$val['start_or_stop'].'</td>';
              print '<td>'.$val['location_name'].'</td>';
              print '<td>'.$val['detail'].'</td>';
              print '</tr>';
            }
          }
        ?>
          <tr style=" height: 10rem; vertical-align: bottom;">
            <th>時間</th>
            <th>終始</th>
            <th>場所</th>
            <th>内容</th>
          </tr>
          <tr style="text-align: center;">
            <td id="td3">
              <input id="time" type="time" name="time" required>
            </td>
            <td id="td1">
              <label><input id="str" type="radio" name="start_or_stop" value="開始" required>開始</label>
              <label><input id="str" type="radio" name="start_or_stop" value="終了">終了</label>
            </td>
            <td id="td2">
              <input id="location" type="text" name="locationName" required>
            </td>
            <td id="td4">
              <input id="detail" type="text" name="detail" required>
            </td>
          </tr>
        </table>
        <div class="bottom">
          <input id="submitInfo" type="hidden" name="submitInfo">
          <button type="submit">登録</button>
          <a href="./index.html">もどる</a>
          <script>
            'use strict';
            navigator.geolocation.getCurrentPosition(success, fail, {
              enableHighAccuracy: true
            });
            let lat;
            let lng;

            function success(pos) {
              $(document).ready(function() {
                //現在の場所の代入
                lat = pos.coords.latitude;
                lng = pos.coords.longitude;
                let geol = `経度：${lat} / 緯度：${lng}`;
                $('#geol').text(geol);
              });
            }

            function fail(error) {
              alert('位置情報の取得に失敗しました。エラーコード：' + error.code);
            }

            //input type=hiddenに位置情報の値を代入
            $('form').submit(function(e) {
              //e.preventDefault();
              let locationData = {
                'lat': lat,
                'lng': lng
              };
              document.getElementById('submitInfo').value = JSON.stringify(locationData);
              //console.log(document.getElementById('submitInfo').value);
            });
          </script>
        </div>
        <div class="wrapper">
          <legeng>カレンダー</legeng>

          <h3 id="header"></h3>
          <div id="next-prev-button">
            <button id="prev" onclick="prev()">＜</button>
            <button id="next" onclick="next()">＞</button>
          </div>

          <div id="calendar"></div>
        </div>
        <script>
          'use strict';
          const week = ["月", "火", "水", "木", "金", "土", "日"];
          const today = new Date();
          var showDate = new Date(today.getFullYear(), today.getMonth(), 1);
        </script>
      </form>
    </main>
  </body>
<?php }
