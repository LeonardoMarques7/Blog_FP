<?php
    session_start(); // Inicia a sessão

    // Inclui o arquivo de conexão
        include('../config/config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['userId']) && isset($_POST['action'])) {
        $postId = $_POST['id'];
        $userId = $_POST['userId'];
        $action = $_POST['action'];

        if ($action === 'like') {
            // Verificar se o usuário já curtiu o post
            $sql_check_like = "SELECT COUNT(*) FROM likes WHERE lik_IdPost = ? AND lik_IdUser = ?";
            $stmt_check_like = $conexao->prepare($sql_check_like);
            $stmt_check_like->bind_param('ii', $postId, $userId);
            $stmt_check_like->execute();
            $stmt_check_like->bind_result($like_count);
            $stmt_check_like->fetch();
            $stmt_check_like->close();

            if ($like_count == 0) {
                // Se não curtiu, insere o like
                $sql_insert_like = "INSERT INTO likes (lik_IdPost, lik_IdUser) VALUES (?, ?)";
                $stmt_insert_like = $conexao->prepare($sql_insert_like);
                $stmt_insert_like->bind_param('ii', $postId, $userId);
                $stmt_insert_like->execute();
                $stmt_insert_like->close();
            }
        } elseif ($action === 'deslike') {
            // Verificar se o usuário já curtiu o post
            $sql_check_like = "SELECT COUNT(*) FROM likes WHERE lik_IdPost = ? AND lik_IdUser = ?";
            $stmt_check_like = $conexao->prepare($sql_check_like);
            $stmt_check_like->bind_param('ii', $postId, $userId);
            $stmt_check_like->execute();
            $stmt_check_like->bind_result($like_count);
            $stmt_check_like->fetch();
            $stmt_check_like->close();

            if ($like_count > 0) {
                // Se já curtiu, remove o like
                $sql_remove_like = "DELETE FROM likes WHERE lik_IdPost = ? AND lik_IdUser = ?";
                $stmt_remove_like = $conexao->prepare($sql_remove_like);
                $stmt_remove_like->bind_param('ii', $postId, $userId);
                $stmt_remove_like->execute();
                $stmt_remove_like->close();
            }
        }
        
        // Contar quantos likes o post tem agora
        $sql_count_likes = "SELECT COUNT(*) FROM likes WHERE lik_IdPost = ?";
        $stmt_count_likes = $conexao->prepare($sql_count_likes);
        $stmt_count_likes->bind_param('i', $postId);
        $stmt_count_likes->execute();
        $stmt_count_likes->bind_result($likes);
        $stmt_count_likes->fetch();
        $stmt_count_likes->close();

        // Retorna a contagem atualizada de likes
        echo $likes;
    }

    $conexao->close();
