<?php
  session_start();

  $member_code = $_SESSION['code'];
  $start_or_stop = $_POST['start_or_stop'];
  $locationName = $_POST['locationName'];
  $time = $_POST['time'];
  $detail = $_POST['detail'];
  $location = json_decode($_POST['submitInfo'], true);
  $lat = $location['lat'];
  $lng = $location['lng'];

  require_once './DB_Query.php';
  $dbQuery = new dbQuery();

  $sql = 'SELECT code FROM geolocation WHERE location_name =\''.$locationName.'\'';

  // 未登録の場所の場合、場所レコードインサート
  if(empty($dbQuery->returnRec($sql))) {
    $sql = 'INSERT INTO geolocation (location_name, latitude, longitude)
            VALUES (\''.$locationName.'\',\''.$lat.'\',\''.$lng.'\')';
    $dbQuery->returnRec($sql);
    $sql = 'SELECT code FROM geolocation WHERE location_name =\''.$locationName.'\'';
  }

  // 場所コード取得
  $locationCode = $dbQuery->returnRec($sql)['code'];

  // 内容レコードを挿入
  $sql = 'INSERT INTO contents (member_code, start_or_stop, place_code, detail)
          VALUES (\''.$member_code.'\',\''.$start_or_stop.'\',\''.$locationCode.'\',\''.$detail.'\')';
  $dbQuery->returnRec($sql);

  header('Location:./main.php');