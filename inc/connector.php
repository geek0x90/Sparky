<?php
  include_once 'config.php';

  class DB
  {
    public static $mysql;
  }

  DB::$mysql = $_MYSQL{'enabled'} ? new mysqli($_MYSQL{'hostname'}, $_MYSQL{'username'}, $_MYSQL{'password'}, $_MYSQL{'database'}) : null;
  global $_DB;
?>
