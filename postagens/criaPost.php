<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
	include('../inc/head.php');
?>
    <title>Blog FP | Criando postagem</title>
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
		
		function formatadata($date, $formato)
		{
			$dt = new DateTime($date, new DateTimeZone("America/Sao_Paulo"));
			return $dt->format($formato);
		}
		
		if (!isset($_SESSION['login']) || $_SESSION['tipoUser'] !== 0) {
			
			$_SESSION['message'] = "Você precisa ser administrador!";
			header('Location: ' . BASE_URL . 'login/login.php');
			exit;
		}

		echo '<link rel="stylesheet" href="' . BASE_URL .'static/css/style-post.css">' 
	?>
	
    <div class="pure-g container">
        <main class="pure-u-1 pure-u-lg-18-24" id="posts-container">
			<form name="produto" action="criarPost.php" class="form" method="post" enctype="multipart/form-data">
				<br><br>
				<div class="espaco_criacao">
					<h1 style="color: #39f; text-transform: uppercase;">
						<i class="fa-solid fa-square-plus"></i> Criando Post
					</h1>
					<br>
					<div class="col text-start">
						<b>Imagem do Post:</b>
						<br>
						<img src="<?= BASE_URL ?>static/posts/semimagem.jpg" id="imgPreview" alt="Foto do Post" class="form-control ">
						<input class="form-control border-primary input-file" type="file" name="arquivo" id="arquivo" title="Imagem do Post" onchange="loadFile(event)">
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
					<div class="col">
						<b>Título do Post:</b><br>
						<input class="form-control border-primary" placeholder="Digite o Título" type="text" name="titulo" id="titulo" maxlength="80" title="Digite o Título" required>
					</div><br>
					<div class="col form-control" required>
						<b>Conteudo do Post:</b><br>
						<textarea id="classic" name="assuntoCompleto"></textarea>
					</div><br>
					<div class="col text-start">
						<b>Tag do Post: </b>
						<div class="tag-container">
							<ul class="d-flex">
								<label for="tag-input">#</label>
								<input type="text" class="tag-input" name="tag-input" id="tag-input" placeholder="Digite a Tag e pressione ENTER" title="Digite a TAG e pressione ENTER!" maxlength="30">
							</ul>
							<div class="tags">
								<ul></ul>
							</div>
						</div>
						<script>
							
							const tags = document.querySelector(".tags ul");

							const tag_input = document.querySelector(".tag-input");
							
							tag_input.addEventListener('keydown', (e) => {

								if (e.key === "Enter") {

									const getUserInput = tag_input.value;
									// Remova todas as tags existentes

									while (tags.firstChild) {

										tags.removeChild(tags.firstChild);

									}
									
									if (getUserInput.trim() !== "") {

										const tag = document.createElement('li');

										tag.textContent = getUserInput;

										tags.appendChild(tag);
										
										const remove = document.createElement('span');

										remove.textContent = "X";

										tag.appendChild(remove);

										remove.classList.add("remove");
										
										remove.addEventListener('click', () => {

											tag.style.display = "none";
											tag_input.value = "";

										});
									}
								}
							});
						</script>
					</div><br>
					<div class="col form-control">
						<ul class="d-flex">
							<label><i class="fa-solid fa-eye" style="color: #ffffff;"></i></label>
							<select name="statusPost" class="form-control border-primary" type="submit" required>
								<option value="0">Visível apenas para o administrador (Privado)</option>
								<option value="1" selected>Visível para todos (Público)</option>
							</select>
						</ul>
					</div><br>
					<div class="col text-start dataCad">
						<input class="form-control text-center border-primary" type="hidden" name="datePost" id="datePost" placeholder="A data será informada só quando enviar!" title="Digite data do Post" disabled></input>
					</div>
					<div class="d-grid col-md-9" style="display: flex; gap: .5rem">
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
							<i class="fa-solid fa-rotate-left"></i> Cancelar</button>
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
    <script src="<?= BASE_URL ?>static/js/script-post.js"></script>
	
	<!-- Place the first <script> tag in your HTML's <head> -->

	<script src="https://cdn.tiny.cloud/1/jwa0nh6lscbm8dwxheybcbd9yfe5xb02mcwwz4lfnwdrtybj/tinymce/7/tinymce.min.js" referrerpolicy="origin">
	</script>
	<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
	<script>
	  const demoBaseConfig = {
		  selector: 'textarea#classic',
		  width: "90%",
		  height: 400,
		  resize: false,
		  autosave_ask_before_unload: false,
		  powerpaste_allow_local_images: true,
		  plugins: [
			'image', 'lists', 'link', 'media', 'preview', 'table',
		  ],
		  toolbar: 'a11ycheck undo redo | bold italic | forecolor backcolor | codesample | alignleft aligncenter alignright alignjustify | bullist numlist',
		  spellchecker_dialog: true,
		  spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
		  tinydrive_demo_files_url: '../_images/tiny-drive-demo/demo_files.json',
		  tinydrive_token_provider: (success, failure) => {

			success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });

		  },
		  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
		  setup: function (editor) {
			editor.on('init', function () {
			// Remova o tamanho da textarea
			editor.getContainer().style.height = '300px';
			editor.getContainer().style.width = 'auto';
			editor.getContainer().style.marginTop = '5px';
			});
		  }
		};
		tinymce.init(demoBaseConfig);
	</script>
</body>
</html>