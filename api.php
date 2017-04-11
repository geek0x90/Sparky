<?php
  include 'inc/Api.php';

  $result = Api::core(); //call the core, listen for $_REQUEST to process the remote api

  echo json_encode($result);
?>
