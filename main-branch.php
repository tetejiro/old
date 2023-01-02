<?php
try {
  session_start();
  $member_code = $_SESSION['code'];

  $start_or_stop = $_POST['start_or_stop'];
  $loc = $_POST['loc'];
  $time = $_POST['time'];
  $detail = $_POST['detail'];

  $text = $_POST['text'];
  $text = json_decode($text, true);
  print_r($text);

  $lat = $text['array1'];
  $long = $text['array2'];

  require_once './DB_Query.php';
  $dbQuery = new dbQuery();
  // $sql = 'INSERT INTO contents(member_code, start_or_stop, place_code, detail)
  //         VALUES(\''.$member_code.'\', \''.$start_or_stop.'\', \''.$detail.'\')';
  // $rec = $dbQuery->dbQueryReturn($sql);//, \''.$loc.'\', \''.$lat.'\', \''.$long.'\'

  // $sql = 'INSERT INTO geolocation (location_name, latitude, longitude)
  //         VALUES()';

  header('Location:./main.php');
} catch (Exception $e) {
  var_dump($e);
  exit('接続エラーです。<a href="../registration/index.php">もどる</a>');
}
