<?php
try {
  session_start();
  $whom = $_SESSION['code'];

  $start_or = $_POST['start_or'];
  $loc = $_POST['loc'];
  $timess = $_POST['timess'];
  $content = $_POST['content'];

  $text = $_POST['text'];
  $text = json_decode($text, true);

  $lat = $text['array1'];
  $long = $text['array2'];

  require_once './DB.php';

  $dbh = new PDO($dsn, $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES, false
  ]);
  $sql = 'INSERT INTO geolocation(whom, start_or, timess, content, location_name, latitude, longitude)
          VALUES(:whom, :start_or, :timess, :content, :loc, :lat, :long)';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':whom', $whom, PDO::PARAM_STR);
  $stmt->bindValue(':start_or', $start_or, PDO::PARAM_STR);
  $stmt->bindValue(':timess', $timess, PDO::PARAM_STR);
  $stmt->bindValue(':content', $content, PDO::PARAM_STR);
  $stmt->bindValue(':loc', $loc, PDO::PARAM_STR);
  $stmt->bindValue(':lat', $lat, PDO::PARAM_STR);
  $stmt->bindValue(':long', $long, PDO::PARAM_STR);
  $stmt->execute();
  $dbh = null;
  header('Location:./main.php');
} catch (Exception $e) {
  var_dump($e);
  exit('接続エラーです。<a href="../registration/index.php">もどる</a>');
}
