<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
    include('../inc/head.php');
?>
    <title>Blog FP | Deletando postagem</title>
</head>
<body>
    <?php 
		include('../inc/header.php');
		
		if (!isset($_SESSION['login']) || $_SESSION['tipoUser'] !== 0) {
			// Se não estiver logado, redirecione para a página de login
			$_SESSION['message'] = "Você precisa ser administrador!";
			header('Location: ../login/login.php');
			exit;
		}
	?>
    <div class="container">
        <main id="posts-container">
            <?php
			include '../vendor/autoload.php';
			use Kreait\Firebase\Factory;
			use Kreait\Firebase\Storage;
			use Kreait\Firebase\Exception\StorageException;
			
			$slugPost = isset($_GET['slug']) ? $_GET['slug'] : null;

			if ($slugPost === null) {
				die('Slug não especificado.');
			}

            // Recuperando o ID do post baseado no slug
            $sqlGetPostId = "SELECT * FROM post WHERE pos_Slug = '$slugPost'";
			
            $postResult = mysqli_query($conexao, $sqlGetPostId);
            $postRow = mysqli_fetch_assoc($postResult);
            $post_id = $postRow['pos_Id'] ?? null;

            if (!$postResult) {
                echo "<a href='index.php' class='btn btn-primary w-100'>Voltar</a>";
                die("<b>Query Inválida:</b>" . mysqli_error($conexao));
            } else {
				
                $post = mysqli_fetch_assoc($postResult);
                $foto = $postRow['pos_Foto']?? null;

                $caminho_foto = '../static/posts/' . $foto; 
                if($foto !== 'semimagem.jpg') {
                    if (file_exists($caminho_foto) && is_file($caminho_foto)) {
                        unlink($caminho_foto); 
                    }
                }
				
				$isVideo = false;
				
				if (strpos($foto, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
					$isVideo = true;
				}
				
				if($isVideo){
					
					$factory = (new Factory)->withServiceAccount('../config/firebase_credentials.json');
					$storage = $factory->createStorage();
					
					$url = $postRow['pos_Foto'] ?? null;
					if ($url) {
						$path = parse_url($url, PHP_URL_PATH); 
						$decodedPath = urldecode($path);
						$fileName = basename($decodedPath);
					} else {
						echo "URL do arquivo não encontrada.";
					}
					
					$videoPost = "videos/$fileName";
					
					try {
						$bucket = $storage->getBucket();
						$bucket->object($videoPost)->delete();
						
					} catch (Exception $e) {
						echo "Erro na exclusão do vídeo: " . $e->getMessage();
					}
				}

                $sqldelete = "DELETE FROM post WHERE pos_Id = $post_id";
				
                $resultado = mysqli_query($conexao, $sqldelete);

                if (!$resultado) {
                    echo "<a href='index.php' class='btn btn-primary w-100'>Voltar</a>";
                    die("<b>Query Inválida:</b>" . mysqli_error($conexao));
                } else {
                    include('../carregando.php');
                }
            }
            mysqli_close($conexao);
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