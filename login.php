<?php
require_once './DB.php';

function sanitize($before)
{
  $after = htmlspecialchars($before, ENT_QUOTES, 'UTF-8');
  return $after;
}

$names = sanitize($_POST['names']);

try {
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $sql = 'SELECT * FROM member WHERE names = :names';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':names', $names, PDO::PARAM_STR);
  $stmt->execute();
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $dbh = null;

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
