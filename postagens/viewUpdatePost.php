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
    <title>Blog FP | Editando postagem</title>
</head>
<style>

.btn-primary {
  position: relative;
  display: inline-block;
}

</style>
<body>
    <?php
		include('../inc/header.php'); 
	?>
    <div class="pure-g container">
		<main class="pure-u-1 pure-u-lg-18-24" id="posts-container">
            <?php

            if (!isset($_SESSION['login']) || $_SESSION['tipoUser'] !== 0) {
                $_SESSION['message'] = "Você precisa ser administrador!";
                header('Location: ' . BASE_URL . 'login\login.php');

                exit;
            }

            $timestamp = strtotime($post['pos_Date']);
            $data_formatada = date('d/m/Y H:i', $timestamp);
			$slug = isset($_GET['slug']) ? $_GET['slug'] : null;
			
			if ($slug === null) {
				die('Slug não especificado.');
			}
			
            mysqli_close($conexao);
			
            $foto = !empty($post['pos_Foto']) ? $post['pos_Foto'] : BASE_URL . 'static/posts/semimagem.jpg';
			
			$isVideo = false;

			if (strpos($foto, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
				$isVideo = true;
			}
            ?>
            <form name="produto" action="alterarPost.php?slug=<?php echo $slug; ?>" class="form border rounded shadow-lg" method="post" enctype="multipart/form-data">
				<br><br>
                <h1 style="color: #39f;">
					<i class="fa-solid fa-square-pen"></i> Editando Post
				</h1>
				<br>
				<div class="espaco_criacao">
					<div class="col form-control">
					<?php if ($isVideo): ?>
						<video class="video-post" controls>
							<source src="<?php echo htmlspecialchars($foto); ?>" type="video/mp4">
							Seu navegador não suporta a tag <code>video</code>.
						</video>
					<?php else: ?>
						<img src="<?php echo $foto ?>" alt="Foto do Post" id="imgPreview" class="image-post">
					<?php endif; ?>
					</div>
					<br>
					<div class="col text-start">
						<b>Imagem do Post:</b><br>
						<input class="form-control border-primary input-file" type="file" name="arquivo" id="arquivo" title="Imagem do Post" value="<?php echo $foto; ?>" onchange="loadFile(event)">
						<script>
						  var loadFile = function(event) {
							var output = document.getElementById('imgPreview');
							output.src = URL.createObjectURL(event.target.files[0]);
							output.onload = function() {
							  URL.revokeObjectURL(output.src) 
							}
						  };
						</script>
					</div>
					<br>
					<div class="col ">
						<b>Título do Post:</b>
						<br>
						<input class="form-control border-primary" placeholder="Digite o Título" type="text" name="titulo" id="titulo" maxlength="80" title="Digite o Título" value="<?php echo $post['pos_Titulo']; ?>">
					</div>
					<br>
					<div class="col form-control">
						<b>Conteudo do Post:</b>
						<br>
						<textarea name="assuntoCompleto" id="assuntoCompleto"><?php echo $post['pos_Conteudo']; ?>
						</textarea>
						<br>
					</div>
					<br>
					<div class="col text-start">
						<b>Tag do Post: </b>
						<div class="tag-container">
							<ul class="d-flex">
								<label for="tag-input">#</label>
								<input type="text" class="tag-input" name="tag-input" id="tag-input" placeholder="Digite a Tag e pressione ENTER" title="Digite a TAG e pressione ENTER!" maxlength="30" value="<?php echo $post['tag']['tag_Titulo']; ?>">
							</ul>
							<div class="tags">
								<ul></ul>
							</div>
						</div>
					</div><br>
					<div class="col text-start">
						<b>Data de Cadastro do Post:</b><br>
						<input class="form-control text-center border-primary" name="datePost" id="datePost" type="datetime-local" title="A data será envianda após a alteração!" value="<?php echo $post['pos_Date']; ?>" disabled></input>
					</div><br>
					<div class="col form-control">
						<ul class="d-flex">
							<label><i class="fa-solid fa-eye" style="color: #ffffff;"></i></label>
							<select name="statusPost" class="form-control border-primary statusPost" type="submit" required>
								<option value="<?php echo $post['pos_Publicado']; ?>" selected>
									<?php if ($post['pos_Publicado'] == 0): ?>
									Visível apenas para o administrador (Privado)
									<?php else: ?>
									Visível para todos (Público)
									<?php endif; ?>
								</option>
								<option value="<?php 
												if ($post['pos_Publicado'] == 0){
													echo "1";
												} else {
													echo "0";
												}
												?>
								">
									<?php if ($post['pos_Publicado'] == 0): ?>
									Visível para todos (Público)
									<?php else: ?>
									Visível apenas para o administrador (Privado)
									<?php endif; ?>
								</option>
							</select>
						</ul>
					</div><br>
					<div class="d-grid col-md-9" style="display: flex; gap: .5rem;">
						<button class="btn btn-primary" title="Enviar" style="color: 444;">
							<i class="fa-regular fa-paper-plane"></i> Enviar
						</button>
						<button class="btn btn-functions" type="reset" title="Limpar" onclick="limpar()">
							<i class="fa-solid fa-trash"></i>Limpar
						</button>
						<script>
						function limpar() {
							document.getElementById('arquivo').value = '';
							document.getElementById('imgPreview').src = '<?= BASE_URL ?>static/posts/semimagem.jpg';
						}
						</script>
						<a href="<?= BASE_URL ?>dashboard.php">
							<button class="btn btn-functions" type="button" title="Voltar">
								<i class="fa-solid fa-rotate-left"></i> Cancelar
							</button>
						</a>
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
	const demoBaseConfig = {
  		selector: 'textarea#assuntoCompleto',
 		height: 400,
		resize: false,
  		autosave_ask_before_unload: false,
  		powerpaste_allow_local_images: true,
 		plugins: [
			'image', 'lists', 'link', 'media', 'preview', 'table',
		],
        setup: function (editor) {
            editor.on('init', function () {
                editor.getContainer().style.height = '300px';
                editor.getContainer().style.width = 'auto';
                editor.getContainer().style.marginTop = '5px';
            });
        },
		toolbar: 'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | codesample | alignleft aligncenter alignright alignjustify | bullist numlist',
		spellchecker_dialog: true,
		spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
		tinydrive_demo_files_url: '../_images/tiny-drive-demo/demo_files.json',
		tinydrive_token_provider: (success, failure) => {
		success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });
		},
		content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
	};
	tinymce.init(demoBaseConfig);
    
   </script>
</body>
</html>