<?php 
	// connect to database
	$conexao = mysqli_connect("localhost", "root", "", "blog_teste");

	if (!$conexao) {
			die("Error connecting to database: " . mysqli_connect_error());
	}
	$conexao -> set_charset("utf8");

	if (!defined('SALT')) define('SALT', '$2a$08$Cf1f11ePArKlBJomM0F6aJ$');
	if (!defined('RECAPTCHA_SECRET')) define('RECAPTCHA_SECRET', '6LfsEV8qAAAAAPMinS7PmNC9737pf6r4vvmZd9qx');
	
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost/Projeto_BLOG/');
?>