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
                <?php echo '<link rel="stylesheet" href="' . BASE_URL .'static/css/style-post.css">'; ?>
                <form name="produto" action="redefinir.php" method="post" enctype="multipart/form-data" class="form-login"><br>
                    <?php 
						if (isset($_SESSION['message'])) {
							echo '<div class="message-error-login">' . $_SESSION['message'] . '</div>';
							clear_message();
						} 
						
						$email = '';
						
						if(!empty($_GET['e'])){
							$email = $_GET['e'];
						}
					?>
                    <h1>Redefinir senha</h1>
                    <div class="col">
                        <b>Login:</b><br>
						<input class="form-control-login  border-primary mb-2" placeholder="Digite o Login" type="text" value="<?php echo $email; ?>" name="login" id="login" maxlength="80" title="Digite o Login" required>
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
