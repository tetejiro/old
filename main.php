<?php
session_start();
if (isset($_SESSION['login']) == false) {
  print 'ログインしてください。';
  print '<br><a href="./index.html">もどる</a>';
  exit();
} else {
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
      <div style="width: 100%;text-align: center;margin-top: 10%;">
        <p>現在の場所は</p>
        <p id="geol"></p>
        <p>です。</p>
      </div>
      <table id="tabledata" style="width: 100%;margin-top: 10%;margin-bottom: 10%;">
        <tr>
          <th>終始</th>
          <th>場所</th>
          <th>時間</th>
          <th>内容</th>
        </tr>
        <tr style="text-align: center;">
          <td id="td1">
            <form id="form1" action="main-branch.php" method="POST">
              <label><input id="str" type="radio" name="start_or_stop" value="開始" required>開始</label>
              <label><input id="str" type="radio" name="start_or_stop" value="終了">終了</label>
          </td>
          <td id="td2">
            <input id="location" type="text" name="location" required>
          </td>
          <td id="td3">
            <input id="time" type="time" name="time" required>
          </td>
          <td id="td4">
            <input id="detail" type="text" name="detail" required>
          </td>
        </tr>
      </table>
      <div class="bottom">
        <input id="submitInfo" type="hidden" name="text">
        <button type="submit">登録</button>
        <a href="./index.html">もどる</a>
        </form>
        <script>
          'use strict';
          navigator.geolocation.getCurrentPosition(success, fail, {enableHighAccuracy: true});
          let lat;
          let long;
          let accu;

          function success(pos) {
            $(document).ready(function() {
              //現在の場所の代入
              lat = pos.coords.latitude;
              long = pos.coords.longitude;
              accu = pos.coords.accuracy;
              let geol = `経度：${lat} / 緯度：${long} / 高度 : ${accu}`;
              $('#geol').text(geol);
            });
          }

          function fail(error) {
            alert('位置情報の取得に失敗しました。エラーコード：' + error.code);
          }

          //input type=hidden にPOSTする値を代入
          $('form').submit(function(e) {
            //e.preventDefault();
            let locationData = {
              'lat': lat,
              'long': long,
              'start_or_stop': document.querySelector('input[name=start_or_stop]:checked').value,
              'locationName': document.getElementById('location').value,
              'time': document.getElementById('time').value,
              'detail': document.getElementById('detail').value
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
    </main>
  </body>
<?php }
