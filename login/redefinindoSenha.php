<?php
include('../config/config.php'); // Inclua o arquivo de configuração se `$conexao` estiver definido aqui

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $login = $_POST['login'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verifica se as senhas coincidem
    if ($new_password === $confirm_password) {
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Verifica a conexão
        if ($conexao->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
        }

        // Atualiza a senha no banco de dados
        $stmt = $conexao->prepare("UPDATE users SET use_Senha = ?, use_Active = 1, use_ActivatedAt = CURRENT_TIMESTAMP WHERE use_Login = ?");
        $stmt->bind_param("ss", $hashed_password, $login);
		
		$mensagem = '';
		
        if ($stmt->execute()) {
            $mensagem = "<div class='message'>Senha redefinida com sucesso! Agora você pode <a href='login.php'>fazer login</a>.</div>";
        } else {
            $mensagem = "<div class='message'>Erro ao redefinir a senha! Tente novamente mais tarde.</div>";
        }

        $stmt->close();
        
    } else {
        $mensagem = "<div class='message'>As senhas não coincidem. Por favor, tente novamente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<?php
    include('../inc/head.php'); 
    $email = $_GET['e'];
?>
    <title>Blog FP | Redefinindo a senha</title>
</head>
<body>
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
            <div class="form">
                <?php echo '<link rel="stylesheet" href="' . BASE_URL .'static/css/style-post.css">'; ?>
                <form method="POST" action="" class="form-login">
					<?php echo $mensagem; ?>
					<br>
                    <h1>Redefinir senha</h1>
                    <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($email); ?>" class="d-none"><br><br>
                    <div class="col">
                        <label for="new_password" class="">Nova Senha:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control-login" required>
                    </div>
                    <div class="col">
                        <label for="confirm_password" class="">Confirme a Nova Senha:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control-login" required><br><br>
                    </div>
                    <div class="d-grid col-md-9">
                        <button type="submit" class="btn btn-entrar">Redefinir Senha</button>
                    </div>
                    <br><br>
                </form>
            </div>
        </main>
    </div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>
