<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
    include('../inc/head.php');
?>
    <title>Blog FP | Deletando perfil</title>
</head>
<body>
    <?php 
		include('../inc/header.php');
		
		if (!isset($_SESSION['login'])) {
			// Se não estiver logado, redirecione para a página de login
			$_SESSION['message'] = "Você precisa estar logado!";
			header("Location: ../login/login.php");
			exit;
		}
	?>
    <div class="container">
        <main id="posts-container">
            <?php
                $perfil = isset($_GET['perfil']) ? $_GET['perfil'] : null;

                if ($perfil === null) {
                    die('Perfil não especificado.');
                }

                // Usar prepared statement para evitar SQL injection
                $stmt = $conexao->prepare("SELECT * FROM users WHERE use_Login = ?");
                $stmt->bind_param("s", $perfil);
                $stmt->execute();
                $perfilResult = $stmt->get_result();
                $perfilRow = $perfilResult->fetch_assoc();
                $perfil_id = $perfilRow['use_Id'] ?? null;

                if (!$perfilRow) {
                    echo "<a href='" . BASE_URL ."index.php' class='btn btn-primary w-100'>Voltar</a>";
                    die("<b>Usuário não encontrado.</b>");
                }

                // Excluir a foto associada
                $foto = $perfilRow['use_Foto'] ?? null;
                if ($foto && $foto !== "Semfoto.png") {
                    $caminho_foto = BASE_URL . "static/img/" . $foto;
                    if (file_exists($caminho_foto) && is_file($caminho_foto)) {
                        unlink($caminho_foto); 
                    }
                }

                // Criar a consulta DELETE com prepared statement
                $stmtDelete = $conexao->prepare("DELETE FROM users WHERE use_Login = ?");
                $stmtDelete->bind_param("s", $perfil);
                $resultado = $stmtDelete->execute();

                if (!$resultado) {
                    echo "<a href='" . BASE_URL ."index.php' class='btn btn-primary w-100'>Voltar</a>";
                    die("<b>Erro ao excluir o usuário:</b> " . $stmtDelete->error);
                } else {
                    header('Location: ../login/logout.php');
                }

                $stmtDelete->close();
                $stmt->close();
                $conexao->close();
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
                        <li>
							<a href="https://www.etecfernandoprestes.com.br/"
							   title="Site Etec Fernando Prestes">
							   Etec Fernando Prestes
							</a>
						</li>
                        <li>
							<a href="https://www.vestibulinhoetec.com.br/home/"
							   title="Site Vestibulinho">
							   Vestibulinho
							</a>
						</li>
                        <li>
							<a href="<?= BASE_URL ?>cursos.php" 
							   title="Cursos da Etec Fernando Prestes">
							   Cursos
							</a>
						</li>
                        <li>	
							<a href="<?= BASE_URL ?>suporte.php">
							   Suporte
							</a>
						</li>
                    </ul>
                </nav>
            </section>
            <section id="redes">
                <h4>Redes Socias</h4>
                <div id="tags-container-2">
                    <a href="https://www.instagram.com/etecfernandoprestes/"
					   title="Instagram" 
					   id="instagram">
						<i class="fab fa-instagram"></i>
					</a>
                    <a href="https://www.facebook.com/etecfernando"
					   title="Facebook" 
					   id="facebook">
						<i class="fab fa-facebook"></i>
					</a>
                    <a href="https://www.youtube.com/@EtecFernandoPrestesCPS"
					   title="Youtube" 
					   id="youtube">
						<i class="fa-brands fa-youtube"></i>
					</a>
                </div>
            </section>
        </aside>
    </div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>