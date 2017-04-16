<?php
  function getUsers() {
    $query = DB::$mysql->query("SELECT * FROM users WHERE 1");

  	$users = Array();

  	while($user = $query->fetch_object()) {
  		$users[] = $user;
  	}

  	return $users;
  }

  function getUser($id) {
    $query = DB::$mysql->query("SELECT * FROM users WHERE id = '".$id."'");

  	$user = $query->fetch_object();

  	return $user;
  }
?>
