<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
    include('../inc/head.php');
?>
    <title>Blog FP | Deletando comentário</title>
</head>
<body>
    <?php 
		include('../inc/header.php');
	?>
    <div class="container">
        <main id="posts-container">
            <?php

                if (!isset($_SESSION['login'])) {
                    header("Location: /login/login.php");
                    exit;
                }

				$comentId = base64_decode($_POST['codigo']);
				$slug = $_POST['slug'];

                $sqldelete = "DELETE FROM comentarios WHERE com_Id = '$comentId'";

                $resultado = mysqli_query($conexao, $sqldelete);

                if (!$resultado) {
                    echo "<a href='viewPost.php?slug=$slug' class='btn btn-primary w-100'>Voltar</a>";
                    die("<b>Query Inválida:</b>" . mysqli_error($conexao));
                } else {
                    echo "<div class='custom-loader'></div>";
					echo "<script>
							setTimeout(function() {
								window.location.href = '" . BASE_URL . "postagens/viewPost.php?slug=$slug';
							}, 1000);
						  </script>";
                }

                mysqli_close($conexao);
            ?>
        </main>
        <aside id="sidebar">
            <section id="search-bar">
                <a href="https://websai.cps.sp.gov.br/">
                    <figure>
                        <img src="<?= BASE_URL ?>static/img/websai.png" alt="WebSai" title="CPS pesquisa do WEBSAI 2024" class="img-websai" />
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