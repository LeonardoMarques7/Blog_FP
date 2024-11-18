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
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
			<?php	
		
			$user = isset($_GET['perfil']) ? $_GET['perfil'] : null;
			$useId = base64_decode($user);
			
			if (!$useId) {
				echo "Usuário não localizado.";
				exit;
			}

			if ($useId) {
				$sqlconsulta =  "SELECT * FROM users WHERE use_Id = '$useId'";
			}

			$resultado = mysqli_query($conexao, $sqlconsulta);

			if (!$resultado):
				die('<b>Query Invalida:</b>' . mysqli_error($conexao));
			else:
				$num = mysqli_num_rows($resultado);
				if ($num == 0) {
					echo "<strong style='font-size: 18px;'>Usuário não localizado.</strong><br><br>";
					echo "<div class='col-md-4'><a href='view.php' class='btn btn-outline-primary w-100'>Voltar</a></div>";
					exit;
				} else {
					$dados = mysqli_fetch_array($resultado);
				}

				$autor = $dados['use_Nome'];
				$autorId = $dados['use_Id'];
				$foto = $dados['use_Foto'];
				$profissao = $dados['use_Profissao'];
				$insta = $dados['use_Instagram'];
				$twitter = $dados['use_Twitter'];
				$facebook = $dados['use_Facebook'];
			?>
			<div class="faixa-cards">
				<div class="perfil">
					<img src="<?= BASE_URL ?>static/img/<?php echo $foto?>" alt="" style="heigth: 30px; object-fit: cover;" />
					<div class="text">
						<h2>
							<?php echo $autor; ?>
						</h2>
						<?php if($profissao != "") :?>
							<b><?php echo $profissao; ?></b><br><br>
						<?php else:?>
							<b>O perfil não adicionou nenhuma profissao.</b><br><br>
						<?php endif; ?>
						<?php if($insta != "") :?>
						<a href="https://www.instagram.com/<?php echo $insta; ?>">
							<i class="fa-brands fa-instagram"></i>
						</a>
						<?php endif; ?>
						<?php if ($twitter != "") :?>
						<a href="https://x.com/<?php echo $twitter; ?>">
							<i class="fa-brands fa-twitter"></i>
						</a>
						<?php endif; ?>
						<?php if ($facebook != "") : ?>
						<a href="https://www.facebook.com/<?php echo $facebook; ?>">
							<i class="fa-brands fa-facebook"></i>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<br>
			<?php
				$tipoUser = $dados['use_TypeUser'];
				if ($tipoUser == 0){
					echo "<h2>Publicações</h2>";
				}
			?>
			<div class="container-post-user">
				<?php
				
				$sqlconsulta = "SELECT * FROM post WHERE pos_UserId = '$autorId' and pos_Publicado != '0'";
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
					<img src="<?php echo $foto ?>" alt="Foto do Post" >
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
				<?php endif; ?>
			</div>
		</main>
    </div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>