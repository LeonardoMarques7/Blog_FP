<?php
	session_start();
	include('../config/config.php'); // Conexão com o banco de dados

	$postId = $_POST['id'];
	$userId = $_SESSION['id'];

	$sql_verifica_like = "SELECT lik_Id FROM likes WHERE lik_IdPost = ? AND lik_IdUser = ?";
	$stmt_verifica_like = $conexao->prepare($sql_verifica_like);
	$stmt_verifica_like->bind_param('ii', $postId, $userId);
	$stmt_verifica_like->execute();
	$stmt_verifica_like->store_result();
	$num_rows = $stmt_verifica_like->num_rows;

	if ($num_rows > 0) {
		echo 'true';
	} else {
		echo 'false'; 
	}

	$stmt_verifica_like->close();
	mysqli_close($conexao);
