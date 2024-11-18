<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
	include('../inc/head.php'); 
	include('auth.php');
   
?>
    <title>Blog FP | Logando</title>
</head>
<body>
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
        <?php

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$recaptchaResponse = $_POST['g-recaptcha-response'];

			$secret = RECAPTCHA_SECRET;
			$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptchaData = [
				'secret' => $secret,
				'response' => $recaptchaResponse,
				'remoteip' => $_SERVER['REMOTE_ADDR']
			];

			$options = [
				'http' => [
					'method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query($recaptchaData)
				]
			];

			$context = stream_context_create($options);
			$response = file_get_contents($recaptchaUrl, false, $context);
			$responseKeys = json_decode($response, true);
			
			if ($responseKeys['success']) {
			 
				if ($conexao) {
					
					$login = $_POST['login'];
					
					$sql = "SELECT * FROM users WHERE use_Login = ? AND use_Active = 1"; 
					$stmt = $conexao->prepare($sql);
					$stmt->bind_param('s', $login);
					$stmt->execute();
					$resultado = $stmt->get_result();

					if ($resultado->num_rows > 0) {
						$row = $resultado->fetch_assoc();
						
						// Verifica a senha
						if ($_POST['senha']) { 
							// Senha correta, usuário autenticado
							$_SESSION['login'] = $login;
							$_SESSION['foto'] = $row['use_Foto'];
							$_SESSION['nome'] = $row['use_Nome'];
							$_SESSION['id'] = $row['use_Id'];
							$_SESSION['tipoUser'] = $row['use_TypeUser'];
							$_SESSION['profissao'] = $row['use_Profissao'];
							$_SESSION['linkInsta'] = $row['use_Instagram'];
							$_SESSION['linkTwitter'] = $row['use_Twitter'];
							$_SESSION['linkFace'] = $row['use_Facebook'];
							$_SESSION['message'] = "Bem vindo(a) " . $_SESSION['nome'];
							include("carregando.php");
							
						} else {
							// Senha incorreta
							$_SESSION['messageErrorLogin'] = "Login ou senha incorretos. Tente Novamente!";
							header("Location: login.php");
							exit();
						}
					} else {
						// Usuário não encontrado ou não está ativo
						$_SESSION['messageErrorLogin'] = "Usuário inválido ou não ativado.";
						header("Location: login.php");
						exit();
					}

					$stmt->close();
					mysqli_close($conexao);
					
				} else {
					echo '<h3 class="card-title text-primary fw-bold">Falha ao conectar ao banco de dados!</h3>';
					echo '<center>';
					echo '<a href="index.php" class="text-primary border border-primary rounded-2 icon-link text-decoration-none text-center p-2 px-4 btn-clique">Tente Novamente ;)</a>';
					echo '</center>';
				}
				
			} else {
				$_SESSION['messageErrorLogin'] = 'Falha na validação do reCAPTCHA. Tente novamente.';
				header("Location: login.php");
				exit();
			}
		}
        ?>
        </main>
        <aside id="sidebar">
            <section id="search-bar">
                <a href="https://websai.cps.sp.gov.br/">
                    <figure>
                        <img src="<?= BASE_URL ?>static/img/websai.png" alt="WebSai" title="CPS pesquisa do WEBSAI 2024" class="img-websai">
                    </figure>
                </a>
            </section>
            <section id="categories">
                <h4>Links Úteis</h4>
                <nav>
                    <ul>
                        <li><a href="https://www.etecfernandoprestes.com.br/" title="Site Etec Fernando Prestes">Etec Fernando Prestes</a></li>
                        <li><a href="https://www.vestibulinhoetec.com.br/home/" title="Site Vestibulinho">Vestibulinho</a></li>
                        <li><a href="<?= BASE_URL ?>cursos.php" title="Cursos da Etec Fernando Prestes">Cursos</a></li>
                        <li><a href="<?= BASE_URL ?>suporte.php">Suporte</a></li>
                    </ul>
                </nav>
            </section>
            <section id="redes">
                <h4>Redes Socias</h4>
                <div id="tags-container-2">
                    <a href="https://www.instagram.com/etecfernandoprestes/" title="Instagram" id="instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/etecfernando" title="Facebook" id="facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.youtube.com/@EtecFernandoPrestesCPS" title="Youtube" id="youtube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </section>
        </aside>
    </div>
	<?php include('../inc/footer.php'); ?>
</body>

</html>