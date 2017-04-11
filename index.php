<?php
	include 'inc/Sparky.php';

	\Sparky\Router::route('/', function() {
		echo \Sparky\Templater::inflate(Array(), 'tpl/index.tpl');
	});

	\Sparky\Router::route('/users', function() {
		$users = \Sparky\Api::getUsers();

		$data = Array(
			'title' => 'User List',
			'users' => $users
		);

		echo \Sparky\Templater::inflate($data, 'tpl/users.tpl');
	});

	\Sparky\Router::route('/user/:id', function($id) {
		$user = \Sparky\Api::getUser($id);

		$data = Array(
			'title' => 'User Profile',
			'user' => $user
		);

		echo \Sparky\Templater::inflate($data, 'tpl/user.tpl');
	});
?>
