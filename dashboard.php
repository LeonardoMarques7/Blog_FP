<!DOCTYPE html>
<html lang="pt-br">
<?php 
include('config/config.php');
include('inc/functions.php');
include('inc/head.php');

$posts = AllPosts();
$tags = AllTags();
	
?>
    <title>Blog FP | Modo ADM</title>
</head>
<body>
    <?php include('inc/header.php') ?>
    <div class="pure-g container">
        <main class="pure-u-sm-1 pure-u-lg-15-24 pure-u-md-17-24 l-box" id="posts-container">
		<?php 
		if (!isset($_SESSION['login']) || $_SESSION['tipoUser'] !== 0) {
			header("Location: index.php");
			exit;
		}
		if(isset($_SESSION['message'])) {
			echo '<div class="message">' . $_SESSION['message'] . '</div>';
			clear_message();
		}
		
		$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
		$posts = AllPosts($searchTerm);
		
		?>
		<a href="<?= BASE_URL ?>postagens/criaPost.php">
			<button class="btn-add" style="text-transform: uppercase; font-weight: bold; align-items: center;">
				<i class="fa-solid fa-square-plus"></i> Adicione um Post
			</button>
		</a>
		<br><br>
		<a href="<?= BASE_URL ?>postagens/privados.php">
			<button class="btn-add" style="text-transform: uppercase; font-weight: bold; align-items: center;">
				<i class="fa-solid fa-lock"></i> Publicações privadas
			</button>
		</a>
		<br><br><br>
		<?php
		
		if (count($posts) > 0):
		
		foreach ($posts as $post): 
			$timestamp = strtotime($post['pos_Date']);
			$data_formatada = date('d/m/Y H:i', $timestamp);

			$foto = !empty($post['pos_Foto']) ? $post['pos_Foto'] : BASE_URL . 'static/posts/semimagem.jpg';
                			
			$titulo = htmlspecialchars($post['pos_Titulo']);
			$tag = !empty($post['tag']['tag_Titulo']) ? $post['tag']['tag_Titulo'] : '';
			$autor = htmlspecialchars($post['autor']['use_Nome']);
			$slug = htmlspecialchars($post['pos_Slug']);
			
			$conteudo = html_entity_decode($post['pos_Conteudo']);
			$limpar = strip_tags($conteudo, '<p><br><strong><em>');
			$conteudo_limpo = preg_replace("/\r|\n/", " ", strip_tags($limpar));
			
			$isVideo = false;

			if (strpos($foto, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
				$isVideo = true;
			}
            ?>
            <article class="post">
                <?php if ($isVideo): ?>
					 <a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug ?>">
						<div>
							 <video controls>
								<source src="<?php echo htmlspecialchars($foto); ?>" type="video/mp4">
								Seu navegador não suporta a tag <code>video</code>.
							</video>
						</div>
					</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug ?>" title="Clique e Veja mais">
						<div>
							<img src="<?php echo $foto ?>" alt="Foto do Post" class="image-post">
						</div>
					</a>
                <?php endif; ?>
				<?php if (isset($_SESSION['tipoUser'])) {
					if ($_SESSION['tipoUser'] == 0) {
						echo "<div class='post-buttons'>";
						echo "<div class='direita-edit'><a href='" . BASE_URL ."postagens/viewUpdatePost.php?slug=$slug' title='Editar'><i class='fa-regular fa-pen-to-square'></i></a></div>";
						echo "<div class='direita'><a href='" . BASE_URL ."postagens/viewDeletePost.php?slug=$slug' title='Apagar'><i class='fa-solid fa-trash-can'></i></a></div></div>";
					}
				} ?>
                <h3 class="title" title="Clique e veja mais!">
                    <a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug ?>">
                        <?php echo $titulo ?>
                    </a>
                </h3>
                <div style="margin-bottom: 16px;">
					<div style=" display: -webkit-box;
								 -webkit-line-clamp: 3; 
								 -webkit-box-orient: vertical;
								 overflow: hidden;
								 text-overflow: ellipsis;
								 text-align: justify;
								 max-height: 3em; 
								 max-width: 52rem; 
								 line-height: 1.5em;">
						<?php echo $conteudo_limpo; ?>
					</div>...
					<strong><a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug; ?>"> Leia mais</a></strong>
				</div>
				<?php if($tag != ''): ?>
				<p class="tag">
                    <a href="<?= BASE_URL ?>postagens/viewTag.php?tag=<?php echo $post['tag']['tag_Id'] ?>" class="tag-post btn category">
                        <?php echo $tag ?>
                    </a>
                </p>
				<?php endif; ?>
                <p class="author">
                    <?php echo $autor . " | " . $data_formatada ?>
                </p>
            </article>
            <?php endforeach ?>
		<?php else: ?>
			<p>Nenhuma publicação encontrada.</p>
		<?php endif; ?>
		
        </main>
        <aside class="pure-u-1 pure-u-lg-7-24 pure-u-md-7-24 l-box" id="sidebar">
			<section id="search-bar">
				<h4>Busca</h4>
				<form action="" method="GET">
					<div id="form" class="pure-g" style="">
						<input type="search" class="pure-u-20-24 pure-u-lg-4-5" name="search" placeholder="Pesquise no blog" id="pesquisar">
						<button type="submit" class="btn-busca pure-u-2-24 pure-u-lg-1-5">
							<i class="fa-solid fa-magnifying-glass"></i>
						</button>
					</div>
				</form>
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
			<section id="categories">
				<h4>Hashtags</h4>
				<nav>
					<ul>
						<?php if (count($tags) > 0): ?>
							<?php foreach ($tags as $tag): ?>
								<li>
									<p class="tag-container-post">
										<a href="<?= BASE_URL ?>postagens/viewTag.php?tag=<?php echo base64_encode($tag['tag_Id']); ?>">
											<?php echo htmlspecialchars($tag['tag_Titulo']); ?>
										</a>
									</p>
								</li>
							<?php endforeach ?>
						<?php else: ?>
							<li>Nenhuma tag encontrada.</li>
						<?php endif; ?>
					</ul>
				</nav>
			</section>
			<section id="redes">
				<h4>Redes Sociais</h4>
				<div id="tags-container-2">
					<a href="https://www.instagram.com/etecfernandoprestes/" title="Instagram" id="instagram"><i class="fab fa-instagram"></i></a>
					<a href="https://www.facebook.com/etecfernando" title="Facebook" id="facebook"><i class="fab fa-facebook"></i></a>
					<a href="https://www.youtube.com/@EtecFernandoPrestesCPS" title="Youtube" id="youtube"><i class="fa-brands fa-youtube"></i></a>
				</div>
			</section>
		</aside>
    </div>
    <?php include('inc/footer.php'); ?>
</body>
</html>