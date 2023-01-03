<?php

class dbQuery {
  private $dsn;
  private $user;
  private $password;

  function __construct() {
    if($_SERVER['HTTP_HOST'] == 'localhost') {
      $this->dsn = 'mysql:host=localhost;dbname=portfolio2;charset=utf8';
      $this->user = 'yuki';
      $this->password = 'hy1733505';
    } else {
      $this->dsn = 'mysql:host=mysql207.phy.lolipop.lan;dbname=LAA1452799-portfolio2;charset=utf8';
      $this->user = 'LAA1452799';
      $this->password = 'hy1733505';
    }
  }

  public function returnRecAll($sql) {
    try {
      $dbh = new PDO($this->dsn, $this->user, $this->password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $dbh = null;
      return $rec;
    } catch(Exception $e) {
      print $sql;
      //print $e;
    }
  }

  public function returnRec($sql) {
    try {
      $dbh = new PDO($this->dsn, $this->user, $this->password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      $dbh = null;
      return $rec;
    } catch(Exception $e) {
      print $sql;
      //print $e;
    }
  }
}