<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
    include('../inc/head.php');
	include('../login/app.php');
?>
    <title>Blog FP | Criando postagem</title>
</head>
<body>
    <?php include('../inc/header.php') ?>
    <div class="container">
        <main id="posts-container">
		<?php
		require '../vendor/autoload.php';
		use Kreait\Firebase\Factory;
		use Kreait\Firebase\Storage;
		use Kreait\Firebase\Exception\StorageException;
		
		if (!isset($_SESSION['login']) || $_SESSION['tipoUser'] !== 0) {
			// Se não estiver logado, redirecione para a página de login
			header('Location: ' . BASE_URL . 'login/login.php');
			exit;
		}
		
		function sanitizeInput($data) {
			return htmlspecialchars(trim($data));
		}
			
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$titulo = sanitizeInput($_POST['titulo']);
			$assuntoCompleto = sanitizeInput($_POST['assuntoCompleto']);
			$tag = sanitizeInput($_POST['tag-input']);
			$autor = $_SESSION['id'];
			$postStatus = sanitizeInput($_POST['statusPost']);

			// Validação de campos obrigatórios
			if (empty($titulo) || empty($assuntoCompleto)) {
				die("Título e conteúdo são obrigatórios.");
			}
			
			// Criando o slug a partir do título
			$titulo_slug = strtolower(trim($titulo));
			$slug = preg_replace('/\s+/', '-', $titulo_slug);
			$slug = preg_replace('/[^a-z0-9-]+/', '', $slug);

			// Função para gerar um slug único
			function geraSlugUnico($slug, $conexao) {
				$novoSlug = $slug;
				$contador = 1;

				// Consulta para verificar se o slug já existe
				$sql = "SELECT COUNT(*) as count FROM post WHERE pos_Slug = '$novoSlug'";
				$resultado = mysqli_query($conexao, $sql);
				$row = mysqli_fetch_assoc($resultado);

				// Se existir, incrementa o slug com um número
				while ($row['count'] > 0) {
					$novoSlug = $slug . '-' . $contador;
					$sql = "SELECT COUNT(*) as count FROM post WHERE pos_Slug = '$novoSlug'";
					$resultado = mysqli_query($conexao, $sql);
					$row = mysqli_fetch_assoc($resultado);
					$contador++;
				}
				return $novoSlug;
			}

			// Gerar slug único se já existir no banco
			$slug = geraSlugUnico($slug, $conexao);
			
			// Pegando a hora atual
			$data_formatada = new DateTime ('now', new DateTimeZone ('America/Sao_Paulo'));
			$datePost = $data_formatada->format("Y-m-d H:i");
			
			if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
				$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
				$arquivo_nome = $_FILES['arquivo']['name'];
				$arquivo_tipo = $_FILES['arquivo']['type'];
				
				$arquivoLink = 'semimagem.jpg'; 
				$maxFileSize = 7 * 1024 * 1024; // 7MB
				
				// Tipos permitidos
				$videoTypes = ['video/mp4', 'video/avi', 'video/mov'];
				$imageTypes = ['image/jpeg', 'image/png', 'image/gif'];

				// Verifica se o arquivo é uma imagem
				if (in_array($arquivo_tipo, $imageTypes)) {
					
					if ($_FILES['arquivo']['size'] > $maxFileSize) {
						die("Imagem excede o limite de 2MB.");
					}
						
					// Upload para ImageShack
					$ch = curl_init();
					$url = 'https://api.imageshack.com/v2/images';

					$postData = [
						'file' => new CURLFile($arquivo_tmp, $arquivo_tipo, $arquivo_nome),
						'key' => IMAGE_SHACK_KEY,
					];

					curl_setopt_array($ch, [
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $postData,
					]);

					$response = curl_exec($ch);
					$error = curl_error($ch);
					curl_close($ch);

					if ($error) {
						die("Erro no upload de imagem: $error");
					}

					$result = json_decode($response, true);

					if (isset($result['result']['images'][0]['direct_link'])) {
						$arquivoLink = 'https://'. $result['result']['images'][0]['direct_link'];
					} else {
						die("Erro no upload da imagem: " . ($result['error']['message'] ?? header("Location: carregando.php") ));
					}

				} elseif (in_array($arquivo_tipo, $videoTypes)) {
					
					if ($_FILES['arquivo']['size'] > $maxFileSize) {
						die("Vídeo excede o limite de 2MB.");
					}
						
					// Inicializa o Firebase
					$factory = (new Factory)->withServiceAccount('../config/firebase_credentials.json');
					$storage = $factory->createStorage();
					
					$arquivoNome = uniqid() . '-' . $arquivo_nome;
					$filePath = "videos/$arquivoNome";
	
					try {
						// Upload do arquivo para o Firebase Storage
						$bucket = $storage->getBucket();
						$bucket->upload(
							file_get_contents($arquivo_tmp),
							['name' => $filePath]
						);

						// Obtém a URL pública do vídeo
						$object = $bucket->object($filePath);
						$arquivoLink = "https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com/o/videos%2F$arquivoNome?alt=media";

					} catch (Exception $e) {
						die("Erro no upload do vídeo: " . $e->getMessage());
					}

				} else {
					die("Formato de arquivo não suportado.");
				}

				// Insere os dados no banco de dados
				$sqlinsert = "INSERT INTO post (pos_Titulo, pos_Conteudo, pos_Slug, pos_UserId, pos_Date, pos_Foto, pos_Publicado) 
							  VALUES ('$titulo', '$assuntoCompleto', '$slug', '$autor', '$datePost', '$arquivoLink', '$postStatus')";
							  
			} else {
				$foto = '';
				$sqlinsert = "INSERT INTO post (pos_Titulo, pos_Conteudo, pos_Slug, pos_UserId, pos_Date, pos_Foto, pos_Publicado) VALUES ('$titulo', '$assuntoCompleto', '$slug', '$autor', '$datePost', '$foto', '$postStatus')";
			}
			
			$resultado = @mysqli_query($conexao, $sqlinsert);
		
			if (!$resultado) {
				echo '<a href="' . BASE_URL . 'index.php" class="btn btn-outline-primary w-100">Voltar</a>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao));
			} 
			
			// Criar slug da tag
			$tag_slug = strtolower(trim($tag));
			$tag_slug = preg_replace('/[^a-z0-9-]+/', '-', $tag_slug);

			// Insere a tag na tabela `tags` se não existir e retorna o ID
			$sqlTagInsert = "INSERT INTO tags (tag_Titulo, tag_Slug, tag_Status) VALUES ('$tag', '$tag_slug', '$postStatus') ON DUPLICATE KEY UPDATE tag_Slug = '$tag_slug'";
			
			mysqli_query($conexao, $sqlTagInsert);

			// Recupera o ID da tag (se foi inserida ou já existia)
			$sqlGetTagId = "SELECT tag_Id FROM tags WHERE tag_Slug = '$tag_slug' LIMIT 1";
			$tagResult = mysqli_query($conexao, $sqlGetTagId);
			
			// Recupera o ID da tag (se foi inserida ou já existia)
			$sqlGetLPostId = "SELECT pos_Id FROM post WHERE pos_Slug = '$slug' LIMIT 1";
			$PostResult = mysqli_query($conexao, $sqlGetLPostId);

			if ($tagResult && mysqli_num_rows($tagResult) > 0) {
				if ($PostResult && mysqli_num_rows($PostResult) > 0) {
				
					$tagRow = mysqli_fetch_assoc($tagResult);
					$tag_id = $tagRow['tag_Id'];
					$postRow = mysqli_fetch_assoc($PostResult);
					$post_id = $postRow['pos_Id'];

					// Inserindo a associação na tabela `post_tags`
					$sqlPostTagInsert = "INSERT INTO post_tags (pos_PostId, pos_TagId) VALUES ('$post_id', '$tag_id')";
					mysqli_query($conexao, $sqlPostTagInsert);
				}
			}

			include("../carregando.php");
			mysqli_close($conexao);
		
		} else {
			echo "Método inválido. Use POST para enviar dados.";
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