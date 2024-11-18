<!DOCTYPE html>
<html lang="pt-br">
<?php
    include('../config/config.php'); 
    include('../inc/head.php'); 
    include('auth.php');
?>
    <title>Blog FP | Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- reCAPTCHA -->
</head>
<body>
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
            <div class="form">
				<?php
					echo '<link rel="stylesheet" href="' . BASE_URL .'static/css/style-post.css">'; 
						
					$email = $_POST['login'];
					
					// Gerando código de ativação
					$codigo_active = gerarCodigoNumerico();

					// Inserindo dados no banco de dados
					$sqlinsert = redefinindo_senha($email, $codigo_active);

					if (!$sqlinsert) {
						echo '<a href="index.php" class="btn btn-outline-primary w-100">Voltar</a>';
						die('<b>Query Inválida:</b>' . mysqli_error($conexao));
					} else {
						// Enviando e-mail de ativação
						send_password_email(email: $email, activation_code: $codigo_active);
					}
					
				?>
                <form name="produto" action="verificaCodigo.php" method="post" enctype="multipart/form-data" class="form-login"><br>
                    <?php 
						if (isset($_SESSION['message'])) {
							echo '<div class="message-error-login">' . $_SESSION['message'] . '</div>';
							clear_message();
						} 
					?>
					
                    <h1>Código de Segurança</h1>
                    <div class="col">
						<input class="form-control-login  border-primary mb-2" type="text" name="login" id="login" value="<?php echo $email; ?>" maxlength="80" required>
                        <b>Enviamos um código de segurança para seu email. Digite o código para continuar:</b><br>
						<input class="form-control-login  border-primary mb-2" placeholder="Digite o codigo de segurança" type="text" name="codigo" id="codigo" maxlength="80" title="Digite o codigo de segurança" required>
                    </div>
                    <div class="d-grid col-md-9">
                        <button class="btn btn-entrar" type="submit" title="Entrar">Enviar</button>
                    </div>
					<br>
                    <?php if (isset($_SESSION['messageErrorLogin'])): ?>
						<div class="message message-error">
							<?php 
								echo $_SESSION['messageErrorLogin']; 
								clear_message(); 
							?>
						</div>
					<?php endif; ?>
                    <br><br>
                </form>
            </div>
        </main>
    </div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>
