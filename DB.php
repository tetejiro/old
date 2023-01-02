<?php

if($_SERVER['HTTP_HOST'] == 'localhost') {
  $dsn = 'mysql:host=localhost;dbname=portfolio2;charset=utf8';
  $user = 'yuki';
  $password = 'hy1733505';
} else {
  $dsn = 'mysql:host=mysql207.phy.lolipop.lan;dbname=LAA1452799-portfolio2;charset=utf8';
  $user = 'LAA1452799';
  $password = 'hy1733505';
}