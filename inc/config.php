<?php
  //app configuration
  $_APP{'debug'} = true;
  global $_APP;

  //api configuration
  $_API{'directory'} = './api';
  $_API{'uri'} = 'http://localhost/Test/SimpleApi/api.php';
  global $_API;

  //database configuration
  $_MYSQL{'enabled'} = true;
  $_MYSQL{'hostname'} = 'localhost';
  $_MYSQL{'username'} = 'root';
  $_MYSQL{'password'} = '';
  $_MYSQL{'database'} = 'test';
  global $_MYSQL;
?>
