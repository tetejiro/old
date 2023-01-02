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
            <input id="loc" type="text" name="loc" required>
          </td>
          <td id="td3">
            <input id="tim" type="time" name="time" required>
          </td>
          <td id="td4">
            <input id="con" type="text" name="detail" required>
          </td>
        </tr>
      </table>
      <div class="bottom">
        <input id="reg" type="hidden" name="text" value="">
        <button>登録</button>
        </form>
        <a href="./index.html">もどる</a>
        <script>
          'use strict';
          navigator.geolocation.getCurrentPosition(success, fail);

          function success(pos) {
            $(document).ready(function() {
              //上側の現在の場所の入力
              var lat = pos.coords.latitude;
              var long = pos.coords.longitude;
              var accu = pos.coords.accuracy;
              let geol = `経度：${lat} / 緯度：${long} / accu : ${accu}`;
              console.log(geol + "\n" + accu);
              $('#geol').text(geol);

              //formのvalueに代入
              $('button').on('click', function() {
                let locationData = {
                  'lat': lat,
                  'long': long
                };
                document.getElementById('reg').value = JSON.stringify(locationData);

                //代入
                let start_or_stop = document.getElementsByName('str').value;
                let loc = document.getElementById('loc').value;
                let time = document.getElementById('tim').value;
                let detail = document.getElementById('con').value;

                //空じゃなければ
                if (start_or_stop == '' && loc == '' && time == '' && detail == '') {
                  window.alert('記入漏れがあります。');
                }
              });
            });
          }

          function fail(error) {
            alert('位置情報の取得に失敗しました。エラーコード：' + error.code);
          }
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
