<?php

require_once './DB_Query.php';

function sanitize($before)
{
  $after = htmlspecialchars($before, ENT_QUOTES, 'UTF-8');
  return $after;
}

$names = sanitize($_POST['names']);
if ($names == '') {
  print '記入してください。<br>';
  print '<a href="./index.html">もどる</a>';
} else {
  try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = 'SELECT * FROM member WHERE names = :names';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':names', $names, PDO::PARAM_STR);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rec) {
      print 'この名前は使用中なので別のものにしてください。';
      print '<a href="index.html">もどる</a>';
    } else {
      $sql = 'INSERT INTO member (names) VALUES (:names)';
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':names', $names, PDO::PARAM_STR);
      $stmt->execute();
      $dbh = null;

      session_start();
      $_SESSION['login'] = true;
      $_SESSION['names'] = $rec['names'];
      $_SESSION['code'] = $rec['code'];
      header('Location:./main.php');
    }
  } catch (Exception $e) {
    print '<pre>';
    var_dump($e);
    print '</pre>';
    print '<br>やり直してください。<br>';
    print '<a href="./index.html">もどる</a>';
  }
}
