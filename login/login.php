<!DOCTYPE html>
<html lang="pt-br">
<?php
    include('../config/config.php'); 
    include('../inc/head.php'); 
?>
    <title>Blog FP | Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- reCAPTCHA -->
</head>
<body>
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
            <div class="form-center">
                <?php echo '<link rel="stylesheet" href="' . BASE_URL .'static/css/style-post.css">'; ?>
                <form name="produto" action="logando.php" method="post" enctype="multipart/form-data" class="form-login"><br>
                    <?php 
						if (isset($_SESSION['message'])) {
							echo '<div class="message-error-login">' . $_SESSION['message'] . '</div>';
							clear_message();
						} 
					?>
					<figure class="mb-2">
                        <img src="<?= BASE_URL ?>static/img/288-logo-etec-fernando-prestes.svg" alt="" class="logo-fp">
                        <figcaption>
                            <small style="opacity: 50%;" class="text-small">Projeto TCC: <b>Blog do Fernando Prestes</b></small>
                        </figcaption>
                    </figure>
                    <div class="col">
                        <b>Login:</b><br><input class="form-control-login  border-primary mb-2" placeholder="Digite o Login" type="text" name="login" id="login" maxlength="80" title="Digite o Login" required>
                    </div>
                    <div class="col senha-col">
                        <b>Senha:</b><br><input class="form-control-login  border-primary" placeholder="Digite o Senha" type="password" name="senha" id="senha" maxlength="80" title="Digite a Senha" required>
                    </div>
                    <b class="title-cria">Não tem uma conta? </b>
                    <a href="criandoConta.php" class="link-login">Clique aqui</a><br><br>
                    <a href="redefenirSenha.php?e" class="link-login-senha" id="EsqueciSenha">Esqueci a senha</a>
                    <div class="br"></div><br>
                    <div class="g-recaptcha" data-sitekey="6LfsEV8qAAAAANXmOkSHh8UZFZxoGlTPW_3iA_p1"></div><br>
                    <div class="d-grid col-md-9">
                        <button class="btn btn-entrar" type="submit" title="Entrar">Entrar</button>
                    </div><br>
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
	<script>
    document.addEventListener("DOMContentLoaded", function() {
        var loginInput = document.getElementById("login");
        var EsqueciaSenhaLink = document.getElementById("EsqueciSenha");

        // Função para atualizar o link
        function updateForgotPasswordLink() {
            var login = loginInput.value.trim();
            if (EsqueciaSenhaLink.textContent.trim() === 'Esqueci a senha') {
                EsqueciaSenhaLink.href = "redefenirSenha.php?e=" + login;
            }
        }

        // Adiciona o listener para a mudança do campo
        loginInput.addEventListener("change", updateForgotPasswordLink);
    });
</script>
</body>
</html>
