<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
    include('../inc/functions.php');
    include('../inc/head.php');
    
	if (isset($_GET['slug'])) {
			$post = ViewPost($_GET['slug']);
	}
	$tags = AllTags();
?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Blog FP | Post</title>
</head>
<style>
#posts-container {
	padding-top: 0;
}

@media screen and (max-width: 31.25em) {
	.container{
		margin: 8.5rem auto; 
	}
}
</style>
<body>
	<?php include('../inc/header.php'); ?>
    <div class="pure-g container">
		<main class="pure-u-lg-15-24 pure-u-md-24-24 pure-u-sm-24-24" id="posts-container">
		<?php 
		$timestamp = strtotime($post['pos_Date']);
		$data_formatada = date('d/m/Y H:i', $timestamp);
		
		$foto = !empty($post['pos_Foto']) ? $post['pos_Foto'] : BASE_URL . 'static/posts/semimagem.jpg';
		
		$titulo = htmlspecialchars($post['pos_Titulo']);
		$conteudo = htmlspecialchars($post['pos_Conteudo']); 
		$tag = !empty($post['tag']['tag_Titulo']) ? $post['tag']['tag_Titulo'] : '';
		$autor = htmlspecialchars($post['autor']['use_Nome']);
		$slug = htmlspecialchars($post['pos_Slug']);
		
		$isVideo = false;

		if (strpos($foto, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
			$isVideo = true;
		}
		?>
		<?php if ($post['pos_Publicado'] == false): ?>
			<strong style="font-size: 18px;">Publicação <?php echo $titulo ?> </strong> - Não localizada!!<br><br>
			<div class="col-md-4">
				<a href="<?= BASE_URL ?>index.php" class="btn btn-outline-primary w-100">Voltar</a>
			</div>
		<?php else: ?>
			<article class="post">
				<br>
				<div>
					<?php if($tag != ''): ?>
						<div class="tag-post">
							<a href="viewTag.php?tag=<?php echo base64_encode($post['tag']['tag_Id']); ?>">
								<?php echo $tag ?>
							</a> 
						</div>
					<?php endif; ?>
				</div>
				<center>
					<h1 class="title title-share" style="font-size: 2.5rem; text-align: justify;"><?php echo $titulo ?></h1>
				</center>
				<div class="author">
					<h5>
						<?php echo $data_formatada; ?> | 
						Por <a href="<?= BASE_URL ?>perfil/view.php?perfil=<?php echo $autor; ?>"><?php echo $autor; ?></a><br>
					</h5> 
				</div>
				<?php
					if (isset($_SESSION['tipoUser'])) {
						if ($_SESSION['tipoUser'] == 0) {
							echo "<div class='post-buttons'>";
							echo "<div class='direita-edit'><a href='" . BASE_URL . "postagens/viewUpdatePost.php?slug=$slug' title='Editar'><i class='fa-regular fa-pen-to-square'></i></a></div>";
							echo "<div class='direita'><a href='" . BASE_URL . "postagens/viewDeletePost.php?slug=$slug' title='Apagar'><i class='fa-solid fa-trash-can'></i></a></div></div>";
						}
					}
					$url_base = 'https://blog-fp.infinityfreeapp.com/postagens/viewPost.php?slug=';
					$url_compartilhamento = $url_base . $slug;
				?>
				<?php if ($isVideo): ?>
					<video controls>
						<source src="<?php echo htmlspecialchars($foto); ?>" type="video/mp4">
						Seu navegador não suporta a tag <code>video</code>.
					</video>
				<?php else: ?>
					<img src="<?php echo $foto ?>" alt="Foto do Post" class="image-post">
				<?php endif; ?>
				<br>
                <div class="description" style="max-width: 53.5rem; word-wrap: break-word;">
					<?php echo html_entity_decode($conteudo); ?>
				</div>
				<br>				
				<?php
				$id = $post['pos_Id'];
				
				$sql_count_likes = "SELECT COUNT(*)FROM likes WHERE lik_IdPost = ?";
				$stmt_count_likes = $conexao->prepare($sql_count_likes);
				$stmt_count_likes->bind_param('i', $id);
				$stmt_count_likes->execute();
				$stmt_count_likes->bind_result($likes);
				$stmt_count_likes->fetch();
				$stmt_count_likes->close();
				
				if(isset($_SESSION['login'])):
					echo "<span class='share-container'>";
					echo "<span class='area-like'><span id='likeButton'><i class='fa-regular fa-heart'></i></span>";
					echo "<span id='likeCount'>$likes</span></span>";
					echo "</span>";
                endif;
				?>
				
				<div class="title-share-container">
					<div class="social-share-icons">
						<a href="https://api.whatsapp.com/send?text=<?php urlencode($titulo) ?>Para acessar a postagem, clique no link: <?php echo $url_compartilhamento ?>" target="_blank" title="Compartilhe no WhatsApp">
							<i class="fab fa-whatsapp"></i>
						</a>
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_compartilhamento ?>" title="Compartilhe no Facebook">
							<i class="fab fa-facebook"></i>
						</a>
						<a href="https://twitter.com/intent/tweet?url=<?php echo $url_compartilhamento ?>&text=<?php urlencode($titulo) ?>Para acessar a postagem, clique no link: <?php echo $url_compartilhamento ?>" title="Compartilhe no X">
							<i class="fab fa-twitter"></i>
						</a>
						<a href="https://telegram.me/share/url?url=<?php echo $url_compartilhamento ?>&text=<?php urlencode("Postagem no Blog FP") ?>" title="Compartilhe no Telegram">
							<i class="fab fa-telegram"></i>
						</a>
					</div>
				</div>
				
		<?php endif ?>
				
                <form action="<?= BASE_URL ?>comentarios/sendComent.php?Com=<?php echo base64_encode($post['pos_Id']); ?>" method="post">
					<input class="form-control border-primary invisible" type="number" name="id" id="codigo" title="Não alterável!" value="">
					<h2 class="title">Comentários: </h2>
					<?php 
						
						$postId = $post['pos_Id'] ?? null;
						$comentarios = ComentPost($postId);
						
						if (!$comentarios):
							echo "Nenhum comentário encontrado.";
							
						else:
							foreach ($comentarios as $coment): 
							
								$timestamp = strtotime($coment['com_Criacao']);
								$data_formatada = date('d/m/Y', $timestamp);
								
								$foto = $coment['autor']['use_Foto'];
								
								$comName = $coment['autor']['use_Nome'];
								$comIdUser = $coment['autor']['use_Id'];
								$comId = $coment['com_Id'];
								$comentario = $coment['com_Comentario'];
						
								$comentario_id = base64_encode($comId);
								?>
								<div class="comentario" style="word-wrap: break-word;">
									<div class="img-title-coment" style="gap: 8px;">
										<a href="<?= BASE_URL ?>perfil/view.php?perfil=<?php echo base64_encode($comIdUser); ?>">
											<img src="<?= BASE_URL ?>static/img/<?php echo $foto ?>" class="image-coment" />
										</a>
										<h5>
											<a href="<?= BASE_URL ?>perfil/view.php?perfil=<?php echo base64_encode($comIdUser); ?>">
												<?php echo $comName ?>
											</a>
										</h5>
									</div>
									<div class="title-comentario" style="margin-left: 2rem;">
										<h4><?php echo html_entity_decode($comentario); ?></h4>
										<div class="pure-g" style="margin-top: 0.65rem; margin-bottom: 0.25rem;">
											<div class="pure-u-3-4">
												<p class="coment">Comentado em: <?php echo $data_formatada ?></p>
											</div>
											<div class="pure-u-1-4" style="text-align: right;"> 
												<?php 	
												if (isset($_SESSION['login'])) {
													if ($_SESSION['nome'] === $comName) {
														echo "<a href='" . BASE_URL . "comentarios/viewDeleteComent.php?Excluir=$comentario_id' class='btn btn-delete-coment'>
																<i class='fa-solid fa-trash'></i>
															</a>";
													} else if ($_SESSION['tipoUser'] === 0) {
														echo "<a href='" . BASE_URL . "comentarios/viewDeleteComent.php?Excluir=$comentario_id' class='btn btn-delete-coment'><i class='fa-solid fa-trash'></i></a>";
													}
												}
												?>
											</div>
										</div>
									</div>
								</div>	
							<?php endforeach ?>
						<?php endif; ?>
					<?php 	
					if (isset($_SESSION['login']) && $autor != $_SESSION['nome']) {
						echo "<textarea placeholder='Escreva aqui seu comentário' class='form-area' name='comentario' id='comentario' maxlength='1000' required></textarea>";
						echo "<input type='hidden' name='slug' value='$slug'>";
						echo "<button type='submit' class='btn-primary btn-mt-2'>Enviar <i class='fa-regular fa-paper-plane'></i></button>";
					} else if (!isset($_SESSION['login'])) {
						echo "<h4>Para comentar, faça <a href='" . BASE_URL . "login/login.php' class='link-login'>login</a> ou <a href=''" . BASE_URL . "login/criandoConta.php' class='link-login'>crie uma conta</a>.</h4>";
					}
					?>
                </form>
			</article>
        </main>
        <?php include('../inc/aside.php'); ?>
		<section class="pure-u-1" id="related-posts">
			<h2>Posts Relacionados</h2>
			<div class="pure-g related-posts-container">
				<?php
				$slug = htmlspecialchars($post['pos_Slug']);

				$sqlConsultaRelacionados = "SELECT * FROM post WHERE pos_Slug != '$slug' AND pos_Publicado != '0' LIMIT 3";
				$resultadoRelacionados = @mysqli_query($conexao, $sqlConsultaRelacionados);

				if ($resultadoRelacionados) {
					while ($dadosRelacionados = mysqli_fetch_array($resultadoRelacionados)) {

						$id = $post['pos_Id'];
						$buscaAutor = "SELECT u.* FROM users u
									   JOIN post p ON u.use_Id = p.pos_UserId
									   WHERE p.pos_Id = '$id'";
									   
						$busca = mysqli_query($conexao, $buscaAutor);
						$autorData = mysqli_fetch_array($busca);
						$autor = $autorData['use_Nome']; 
						$slug = $dadosRelacionados['pos_Slug'];
						
						$timestampRelacionados = strtotime($dadosRelacionados['pos_Date']);
						$dataFormatadaRelacionados = date('d/m/Y', $timestampRelacionados);

						$imagemRelacionados = !empty($dadosRelacionados['pos_Foto']) ? $dadosRelacionados['pos_Foto'] : BASE_URL . 'static/posts/semimagem.jpg';
						
						$isVideo = false;

						if (strpos($imagemRelacionados, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
							$isVideo = true;
						}
						
						$Postconteudo = mb_strimwidth(html_entity_decode($dadosRelacionados['pos_Conteudo']), 0, 220, "... <strong><a href='viewPost.php?slug=$slug'>Leia mais</a></strong>");
				?>
				<article class="related-post" style="margin-bottom: 0.80em;">
				<?php if ($isVideo): ?>
					<video width="240" controls>
						<source src="<?php echo htmlspecialchars($imagemRelacionados); ?>" type="video/mp4">
						Seu navegador não suporta a tag <code>video</code>.
					</video>
				<?php else: ?>
				
					<img src="<?php echo $imagemRelacionados; ?>" alt="Imagem do post relacionado" class="img-post-mais" style="margin-bottom: 0.35em;">
				<?php endif; ?>
					<a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug; ?>">
						<h3 class="title">
							<?php echo $dadosRelacionados['pos_Titulo']; ?>
						</h3>
					</a>
					<p class="date">Postado em: <strong><?php echo $dataFormatadaRelacionados; ?></strong></p>
				</article>
				<?php 
					} // end while
				} else {
					echo "Erro na consulta: " . mysqli_error($conexao); 
				}
				mysqli_close($conexao);
				?>
			</div>
		</section>
    </div>
    <?php include('../inc/footer.php'); ?>
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=667b5a96bcdd3d0019d7e65b&product=inline-share-buttons&source=platform" async="async" defer></script>
	<script>     
	document.addEventListener('DOMContentLoaded', function() {
		var likeButton = document.getElementById('likeButton');
		var likeCount = document.getElementById('likeCount');

		var userId = "<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>";

		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'checkUserLike.php', true);

		var formData = new FormData();
		formData.append('id', "<?php echo $id; ?>");
		formData.append('userId', userId);

		xhr.onload = function() {
			if (xhr.status === 200) {
				var result = xhr.responseText;

				if (result === 'true') {
					likeButton.innerHTML = '<i class="fas fa-heart like"></i>';
					likeButton.classList.add('liked');
				} else {
					likeButton.innerHTML = '<i class="fa-regular fa-heart like"></i>';
					likeButton.classList.remove('liked'); 
				}
			} else {
				console.error('Erro ao verificar as curtidas do usuário: ' + xhr.statusText);
			}
		};

		xhr.send(formData);

		likeButton.addEventListener('click', function() {
			if (likeButton.classList.contains('liked')) {
				updateLikes('deslike');
			} else {
				updateLikes('like');
			}
		});

		function updateLikes(action) {
			var updateXHR = new XMLHttpRequest();
			updateXHR.open('POST', 'updateLikes.php', true);

			updateXHR.onload = function() {
				if (updateXHR.status === 200) {
					var likes = parseInt(updateXHR.responseText);
					likeCount.textContent = likes;

					if (action === 'like') {
						likeButton.innerHTML = '<i class="fas fa-heart like"></i>';
						likeButton.classList.add('liked'); 
					} else if (action === 'deslike') {
						likeButton.innerHTML = '<i class="fa-regular fa-heart like"></i>';
						likeButton.classList.remove('liked'); 
					}
				} else {
					console.error('Erro ao atualizar as curtidas: ' + updateXHR.statusText);
				}
			};

			var updateFormData = new FormData();
			updateFormData.append('id', "<?php echo $id; ?>");
			updateFormData.append('userId', userId);
			updateFormData.append('action', action);

			updateXHR.send(updateFormData);
		}
	});
	</script>
</body>
</html>