<?php
    session_start();
    include('../config/config.php');

    $id_post = $_GET['id_post'];
    $id_user = $_SESSION['id']; // Assumindo que o ID do usuário está armazenado na sessão

    $query = "SELECT * FROM likes WHERE id_post = ? AND id_user = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param('ii', $id_post, $id_user);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo 'liked';
    } else {
        echo 'not_liked';
    }
?>
