<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
    include('../inc/head.php');
	include('../login/auth.php');
?>
    <title>Blog FP | Editando postagem</title>
</head>
<body>
    <?php 
	include('../inc/header.php');
	echo '<link rel="stylesheet" href="' . BASE_URL . 'static/css/style-post.css">' 
	?>
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
		
			$slugPost = isset($_GET['slug']) ? $_GET['slug'] : null;

			if ($slugPost === null) {
				die('Slug não especificado.');
			}
			
			// Recuperando o ID do post baseado no slug
            $sqlGetPostId = "SELECT pos_Id, pos_Titulo, pos_Conteudo, pos_Foto FROM post WHERE pos_Slug = '$slugPost'";
            $postResult = mysqli_query($conexao, $sqlGetPostId);
            $postRow = mysqli_fetch_assoc($postResult);
            $post_id = $postRow['pos_Id'] ?? null;

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						
				// Recuperando dados do formulário
				// Recuperando dados do formulário
				$titulo = $_POST['titulo'] ?? '';
				$assuntoCompleto = $_POST['assuntoCompleto'] ?? '';
				$tag = $_POST['tag-input'] ?? '';
				$postStatus = $_POST['statusPost'] ?? '';

				// Criando o slug a partir do título
				$titulo_slug = strtolower(trim($titulo));
				$slug = preg_replace('/\s+/', '-', $titulo_slug);
				$slug = preg_replace('/[^a-z0-9-]+/', '', $slug);

				// Função para gerar um slug único
				function geraSlugUnico($slug, $conexao, $postId = null) {
					$novoSlug = $slug;
					$contador = 1;

					$sql = "SELECT COUNT(*) as count FROM post WHERE pos_Slug = '$novoSlug'" . ($postId ? " AND pos_Id != '$postId'" : "");
					$resultado = mysqli_query($conexao, $sql);
					$row = mysqli_fetch_assoc($resultado);

					while ($row['count'] > 0) {
						$novoSlug = $slug . '-' . $contador;
						$sql = "SELECT COUNT(*) as count FROM post WHERE pos_Slug = '$novoSlug'" . ($postId ? " AND pos_Id != '$postId'" : "");
						$resultado = mysqli_query($conexao, $sql);
						$row = mysqli_fetch_assoc($resultado);
						$contador++;
					}
					return $novoSlug;
				}

				// Gerar slug único se necessário
				if ($titulo !== "") {
					$slug = geraSlugUnico($slug, $conexao, $post_id);
				} else {
					$slug = $slugPost; // Manter o slug existente
				}
				
				$data_formatada = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
				$datePost = $data_formatada->format("Y-m-d H:i");
				
				if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
					
					$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
					$arquivo_nome = $_FILES['arquivo']['name'];
					$arquivo_tipo = $_FILES['arquivo']['type'];
					
					if (!empty($arquivo_nome)) {
						// Definido como padrão
						$arquivoLink = ''; 
						
						// Tipos permitidos
						$videoTypes = ['video/mp4', 'video/avi', 'video/mov'];
						$imageTypes = ['image/jpeg', 'image/png', 'image/gif'];

						// Verifica se o arquivo é uma imagem
						if (in_array($arquivo_tipo, $imageTypes)) {
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
								die("Erro no upload da imagem: " . ($result['error']['message'] ?? 'Erro desconhecido'));
							}

						} elseif (in_array($arquivo_tipo, $videoTypes)) {	
							
							// Inicializa o Firebase
							$factory = (new Factory)->withServiceAccount('../config/firebase_credentials.json');
							$storage = $factory->createStorage();
							
							$arquivoNome = uniqid() . '-' . $arquivo_nome;
							$filePath = "videos/$arquivoNome";
							
							// URL completa salva no banco
							$url = $postRow['pos_Foto'] ?? null;
							if ($url) {
								$path = parse_url($url, PHP_URL_PATH); 
								$decodedPath = urldecode($path);
								$fileName = basename($decodedPath);
							} else {
								echo "URL do arquivo não encontrada.";
							}
							
							$arquivoAtualPath = "videos/$fileName";
							
							try {
								$bucket = $storage->getBucket();
								$bucket->object($arquivoAtualPath)->delete();

								$bucket->upload(
									file_get_contents($arquivo_tmp),
									['name' => $filePath]
								);

								// Obtém a URL pública do vídeo
								$object = $bucket->object($filePath);
								$arquivoLink = "https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com/o/videos%2F$arquivoNome?alt=media";
								
							} catch (Exception $e) {
								echo "Erro no upload do vídeo: " . $e->getMessage();
							}

						} else {
							die("Formato de arquivo não suportado.");
						}
						
						// Insere os dados no banco de dados
						$sqlupdate = "UPDATE post SET pos_Foto='$arquivoLink', pos_Titulo='$titulo', pos_Conteudo='$assuntoCompleto', pos_Slug='$slug', pos_Publicado='$postStatus', pos_Date='$datePost' WHERE pos_Slug = '$slugPost'";
						
					}
					else {
						$sqlupdate = "UPDATE post 
									  SET pos_Titulo='$titulo', pos_Conteudo='$assuntoCompleto', pos_Slug='$slug', pos_Publicado='$postStatus', pos_Date='$datePost' 
									  WHERE pos_Slug = '$slugPost'";
					}
								  
				} else {
					$sqlupdate = "UPDATE post 
								  SET pos_Titulo='$titulo', pos_Conteudo='$assuntoCompleto', pos_Slug='$slug', pos_Publicado='$postStatus', pos_Date='$datePost' 
								  WHERE pos_Slug = '$slugPost'";
				}
				
				$resultado = @mysqli_query($conexao, $sqlupdate);

				if (!$resultado) {
					echo '<a href="index.php" class="btn btn-outline-primary w-100">Voltar</a>';
					die('<b>Query Inválida:</b>' . @mysqli_error($conexao));
					
				} 
					
				// Processando tags
				if (!empty($tag)) {
					$tag_slug = strtolower(trim($tag));
					$tag_slug = preg_replace('/[^a-z0-9-]+/', '-', $tag_slug);
					$tag_status = $_POST['statusPost'];

					// Inserir ou atualizar a tag
					$sqlTagInsert = "INSERT INTO tags (tag_Titulo, tag_Slug, tag_Status) VALUES ('$tag', '$tag_slug', '$tag_status') ON DUPLICATE KEY UPDATE tag_Slug = '$tag_slug', tag_Status = '$tag_status'";
					mysqli_query($conexao, $sqlTagInsert);

					// Recupera o ID da tag
					$sqlGetTagId = "SELECT tag_Id FROM tags WHERE tag_Slug = '$tag_slug' LIMIT 1";
					$tagResult = mysqli_query($conexao, $sqlGetTagId);
					
					if ($tagResult && mysqli_num_rows($tagResult) > 0) {
						$tagRow = mysqli_fetch_assoc($tagResult);
						$tag_id = $tagRow['tag_Id'];

						// Verifica se a associação já existe
						$sqlCheckPostTag = "SELECT * FROM post_tags WHERE pos_PostId = '$post_id' AND pos_TagId = '$tag_id'";
						$checkResult = mysqli_query($conexao, $sqlCheckPostTag);

						if (mysqli_num_rows($checkResult) == 0) {
							// Inserindo a nova associação na tabela `post_tags` se não existir
							$sqlPostTagInsert = "UPDATE post_tags SET pos_TagId = '$tag_id' WHERE pos_PostId = '$post_id'";
							mysqli_query($conexao, $sqlPostTagInsert);
						}
					}

				}
			
				include('../carregando.php');
				mysqli_close($conexao);
				
			} else {
				echo "Método inválido. Use POST para enviar dados.";
			}
			
			?>
        </main>
        <aside id="sidebar">
            <section id="search-bar">
                <h4>Busca</h4>
                <div id="form">
                    <input type="search" placeholder="Pesquise no blog" id="pesquisar">
                    <button type="button" class="btn-busca" onclick="searchData()"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </section>
            <section id="categories">
                <h4>Links Úteis</h4>
                <nav>
                    <ul>
                        <li><a href="https://www.etecfernandoprestes.com.br/" title="Site Etec Fernando Prestes">Etec Fernando Prestes</a></li>
                        <li><a href="https://www.vestibulinhoetec.com.br/home/" title="Site Vestibulinho">Vestibulinho</a></li>
                        <li><a href="<?= BASE_URL ?>cursos.php" title="Cursos da Etec Fernando Prestes">Cursos</a></li>
                        <li><a href="criadores.php" title="Veja os Criadores!">Criadores</a></li>
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