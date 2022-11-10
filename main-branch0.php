<?php
require_once './DB.php';

$dbh = new PDO($dbh, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$member = $_SESSION['code'];

$sql = 'SELECT start_or, timess, content, location_name FROM geolocation WHERE whom = $member';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
$dbh = null;

if (isset($rec)) {
  $start_or = $rec['start_or'];
  $timess = $rec['timess'];
  $content = $rec['content'];
  $location_name = $rec['location_name'];
}
