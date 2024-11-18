<!DOCTYPE html>
<html lang="pt-br">
<?php 
	include('../config/config.php');
	include('../inc/head.php'); 
?>
	<title>Blog FP | Perfil</title>
</head>
<style>
	.post-user {
		max-width: 100%;
		box-sizing: border-box;
	}
		
	@media (min-width: 56.2em){
		.post-user {
			max-width: 277.67px;
			width: 100%;
			box-sizing: border-box;
		}
	}
</style>
<body>
	<?php include('../inc/header.php') ?>
	<div class="container">
        <main id="posts-container">
			<?php 
				if (!isset($_SESSION['login'])) {
					$_SESSION['message'] = "Você precisa estar logado!";
					header("Location: ../login/login.php");
					exit;
				}
				if(isset($_SESSION['message'])) {
					echo '<div class="message">' . $_SESSION['message'] . '</div>';
					clear_message();
				}	
			?>
			<div class="faixa-cards">
				<div class="perfil">
					<img src="<?= BASE_URL ?>static/img/<?php echo $foto?>" alt="" style="heigth: 30px; object-fit: cover;" />
					<div class="text">
						<h2>
							<?php
								echo $_SESSION['nome'];
								$login = $_SESSION['login'];
							?>
							<button class="button-view-edit">
								<a href="editPerfil.php" class="link-edit">
									<i class="fa-solid fa-pen"></i>
								</a>
							</button>
							<button class="button-view-edit">
							<a href="#" class="link-edit" onclick="confirmExclusao(event)">
									<i class="fa-solid fa-trash"></i>
								</a>
							</button>
						</h2>
						<?php if($_SESSION['profissao'] != "") :?>
							<b><?php echo $_SESSION['profissao']?></b><br><br>
						<?php else:?>
							<b>O perfil não adicionou nenhuma profissao.</b><br><br>
						<?php endif; ?>
						<?php if($_SESSION['linkInsta'] != "") :?>
						<a href="https://www.instagram.com/<?php echo $_SESSION['linkInsta']?>">
							<i class="fa-brands fa-instagram"></i>
						</a>
						<?php endif; ?>
						<?php if ($_SESSION['linkTwitter'] != "") :?>
						<a href="https://x.com/<?php echo $_SESSION['linkTwitter']?>">
							<i class="fa-brands fa-twitter"></i>
						</a>
						<?php endif; ?>
						<?php if ($_SESSION['linkFace'] != "") : ?>
						<a href="https://www.facebook.com/<?php echo $_SESSION['linkFace']?>">
							<i class="fa-brands fa-facebook"></i>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<br>
			<?php
				$tipoUser = $_SESSION['tipoUser'];
				if ($tipoUser == 0){
					echo "<h2>Publicações</h2>";
				}
			?>
			<div class="container-post-user">
				<?php
				$foto = $_SESSION['foto'];
				$loginId = $_SESSION['id'];

				$sqlconsulta = "SELECT * FROM post WHERE pos_UserId = '$loginId'";

				$resultado = mysqli_query($conexao, $sqlconsulta);
				
				if (!$resultado):
					die("<b>Query Inválida:</b>" . mysqli_error($conexao));
				
				else:
					$num = mysqli_num_rows($resultado);
					
					if ($tipoUser == 0 && $num == 0):
						echo "<div class='alert-message'>
								<b class='alert-user'>
									Esse usuário ainda não fez nenhum post...
								</b>
							 </div>";
					else:
					
						while($dados = mysqli_fetch_array($resultado)):
							$timestamp = strtotime($dados['pos_Date']);
							$data_formatada = date('d/m/Y H:i', $timestamp);
							$slug = $dados['pos_Slug'];
							
							$foto = !empty($dados['pos_Foto']) ? $dados['pos_Foto'] : BASE_URL . 'static/posts/semimagem.jpg';
			
							$isVideo = false;

							if (strpos($foto, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
								$isVideo = true;
							}
				?>
				<article class="post post-user">
				<?php if ($isVideo): ?>
					<video width="400" controls>
						<source src="<?php echo htmlspecialchars($foto); ?>" type="video/mp4">
						Seu navegador não suporta a tag <code>video</code>.
					</video>
				<?php else: ?>
					<!-- Exibe a imagem -->
					<img src="<?php echo $foto ?>" alt="Foto do Post">
				<?php endif; ?>
					<h4 class="title-post-user" title="Clique e veja mais!">
						<a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug ?>">
							<?php echo $dados['pos_Titulo'] ?>
						</a>
					</h4>
					<p class="date-post-user"><?php echo $data_formatada ?></p>
					<a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug ?>" title="Clique e veja mais!" class="btn btn-vermais">Ler mais</a>
				</article>
				<?php endwhile; ?>
				<?php endif; ?>
				<?php endif; ?>
			</div>
		</main>
	</div>
	<div id="ExclusaoModal" style="display: none">
		<div class="modal-content">
			<h2>Deletando perfil</h2>
			<span>Para confirmar, digite "<?php echo $_SESSION['nome']?>" na caixa abaixo</span><br><br>	
			<form action="deletePerfilConfirm.php?perfil=<?php echo $login ?>" method="post">
				<input type="text" name="nome" id="nome" class="input-modeal"><br>
				<button type="submit" class="btn-sair-modal">Excluir</button>
				<button onclick="closeModal()" class="btn-cancelar-modal">Cancelar</button>
			</form>
		</div>
	</div> 
	<script>
		// Modal sair
		function confirmExclusao(event) {
			event.preventDefault(); // Impede o redirecionamento imediato
			document.getElementById('ExclusaoModal').style.display = 'flex';
		}

		function closeModal() {
			document.getElementById('ExclusaoModal').style.display = 'none';
		}

	</script>
	<?php include('../inc/footer.php'); ?>
</body>
</html>
