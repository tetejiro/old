<?php
try {
  session_start();
  $member_code = $_SESSION['code'];

  $text = json_decode($_POST['text'], true);
  $lat = $text['lat'];
  $long = $text['long'];
  $start_or_stop = $text['start_or_stop'];
  $locationName = $text['locationName'];
  $time = $text['time'];
  $detail = $text['detail'];

  print_r($text);

  require_once './DB_Query.php';
  $dbQuery = new dbQuery();
  // $sql = 'INSERT INTO contents(member_code, start_or_stop, place_code, detail)
  //         VALUES(\''.$member_code.'\', \''.$start_or_stop.'\', \''.$detail.'\')';
  // $rec = $dbQuery->dbQueryReturn($sql);//, \''.$loc.'\', \''.$lat.'\', \''.$long.'\'

  // $sql = 'INSERT INTO geolocation (location_name, latitude, longitude)
  //         VALUES()';

  // header('Location:./main.php');
} catch (Exception $e) {
  var_dump($e);
  exit('接続エラーです。<a href="../registration/index.php">もどる</a>');
}
