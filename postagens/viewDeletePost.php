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
    <title>Blog FP | Deletando postagem</title>
</head>
<body>
    <?php 
	include('../inc/header.php'); 
	?>
    <div class="pure-g container">
        <main class="pure-u-1 pure-u-lg-18-24" id="posts-container">
		<?php

		if (!isset($_SESSION['login']) || $_SESSION['tipoUser'] !== 0) {
			$_SESSION['message'] = "Você precisa ser administrador!";
			header('Location: ' . BASE_URL . 'login/login.php');
			exit;
		}
		
		$timestamp = strtotime($post['pos_Criacao']);
		$data_formatada = date('d/m/Y H:i', $timestamp);
		
		$foto = !empty($post['pos_Foto']) ? $post['pos_Foto'] : BASE_URL . 'static/posts/semimagem.jpg';
	
		$titulo = htmlspecialchars($post['pos_Titulo']);
		$conteudo = htmlspecialchars($post['pos_Conteudo']); 
		$tag = htmlspecialchars($post['tag']['tag_Titulo']);
		$autor = htmlspecialchars($post['autor']['use_Nome']);
		$slug = htmlspecialchars($post['pos_Slug']);
		
		$isVideo = false;

		if (strpos($foto, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
			$isVideo = true;
		}
		?>		
            <form name="produto" action="deletePost.php?slug=<?php echo $slug; ?>" class="form border rounded shadow-lg" method="post" enctype="multipart/form-data">
				<br><br>
				<div class="espaco_criacao">
					<h1 style="color: #39f;"><i class="fa-solid fa-square-minus"></i> Deletando Post</h1><br>
					<div class="col form-control">
					<?php if ($isVideo): ?>
						<video class="video-post" controls readonly>
							<source src="<?php echo htmlspecialchars($foto); ?>" type="video/mp4">
							Seu navegador não suporta a tag <code>video</code>.
						</video>
					<?php else: ?>
						<!-- Exibe a imagem -->
						<img src="<?php echo $foto; ?>" alt="Foto do Post" class="image-post" readonly>
					<?php endif; ?>
					</div><br>
					<div class="col">
						<b>Título do Post:</b><br><input class="form-control border-primary" type="text" name="titulo" id="titulo" maxlength="80" placeholder="Sem dados!" title="Não é possível Alterar no DELETE" value="<?php echo $titulo; ?>" readonly>
					</div><br>
					<div class="col form-control" required>
						<b>Conteudo do Post:</b><br>
						<textarea id="classic" name="assuntoCompleto"><?php echo html_entity_decode($conteudo); ?></textarea>
					</div><br>
					<div class="col text-start">
						<b>Autor do Post:</b><br><input class="form-control border-primary" type="text" name="autor" id="autor" placeholder="Sem dados!" title="Não é possível Alterar no DELETE" value="<?php echo $autor; ?>" readonly></input>
					</div><br>
					<div class="col text-start">
						<b>Data de Cadastro do Post:</b><br><input class="form-control text-center border-primary" name="datePost" id="datePost" placeholder="Sem dados!" title="Não é possível Alterar no DELETE" value="<?php echo $data_formatada; ?>" readonly></input>
					</div><br>
					<div class="d-grid col-md-9">
						<button class="btn btn-primary" type="submit" title="Excluir" style="color: 444;"><i class="fa-solid fa-trash"></i> Excluir</button>
						<a href="<?= BASE_URL ?>dashboard.php"><button class="btn btn-outline-danger" type="button" title="Voltar" style="color: 444;"><i class="fa-solid fa-rotate-left"></i> Cancelar</button></a>
					</div>
				</div>
                <br><br><br><br><br><br>
            </form>
			<br><br>
        </main>
        <?php include('../inc/aside.php'); ?>
    </div>
    <?php include('../inc/footer.php'); ?>
	<script src="https://cdn.tiny.cloud/1/jwa0nh6lscbm8dwxheybcbd9yfe5xb02mcwwz4lfnwdrtybj/tinymce/7/tinymce.min.js" referrerpolicy="origin">
	</script>
	<script>
		tinymce.init({
			selector: 'textarea#classic',
			setup: function (editor) {
				editor.on('init', function () {
					editor.getBody().setAttribute('contenteditable', false); 
				});
			},
			menubar: false,
			toolbar: false,
			statusbar: false
		});
	</script>
</body>
</html>