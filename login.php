<?php
require_once './DB_Query.php';
$dbQuery = new dbQuery();

function sanitize($before)
{
  $after = htmlspecialchars($before, ENT_QUOTES, 'UTF-8');
  return $after;
}

$names = sanitize($_POST['names']);

try {
  $sql = 'SELECT * FROM member WHERE names =\'' .$names.'\'';
  $rec = $dbQuery->dbQueryReturn($sql);

  if (empty($rec) == false) {
    session_start();
    $_SESSION['login'] = true;
    $_SESSION['code'] = $rec['code'];
    $_SESSION['names'] = $rec['names'];
    header('Location:./main.php');
    exit();
  } else {
    print '登録名簿に名前がありません。<br>';
    print '<a href="./index.html">もどる</a>';
  }
} catch (Exception $e) {
  print '<pre>';
  var_dump($e);
  print '</pre>';
  print '<br><a href="./index.html">もどる</a>';
}