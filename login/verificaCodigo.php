<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
	include('auth.php');
    include('../inc/head.php');
?>
    <title>Blog FP | Validação</title>
</head>
<body>
    <?php include('../inc/header.php') ?>
    <div class="container">
        <main id="posts-container">
		<?php
		
		if (isset($_POST['login']) && isset($_POST['codigo'])) {
			$email = $_POST['login'];
			$code = $_POST['codigo'];
			
			$user = verificacao_codigo($code, $email);
			if ($user) {
				echo '<div class="custom-loader"></div>';
				echo '<script>
						setTimeout(function() {
							window.location.href = "redefinindoSenha.php?e=" + "' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '";
						}, 1000);
					  </script>';
			} else {
				echo '<div class="custom-loader"></div>';
				echo '<script>
						setTimeout(function() {
							window.location.href = "redefinir.php";
						}, 1000);
					  </script>';
			}
			
		} else {
			echo "Está com erro!!";
		}

		?>
        </main>
	</div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>