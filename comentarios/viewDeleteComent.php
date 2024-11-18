<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
	include('../inc/functions.php');
    include('../inc/head.php');
?>
    <title>Blog FP | Deletando comentário</title>
</head>
<body>
    <?php include('../inc/header.php');?>
    <div class="pure-g container">
        <main class="pure-u-1 pure-u-lg-15-24" id="posts-container">
            <?php
			 
			if (isset($_GET['Excluir']) && is_numeric(base64_decode($_GET['Excluir']))) {
				$comentId = base64_decode($_GET['Excluir']);
			} else {
				header('Location: ' . BASE_URL . 'dashboard.php');
			}
			
			$comentarios = DeleteComent($comentId);

			if (!$comentarios):
				die("<b>Query Inválida:</b>" . mysqli_error($conexao));
			else:
				foreach ($comentarios as $coment): 
                    $timestamp = strtotime($coment['com_Criacao']);
                    $data_formatada = date('d/m/Y', $timestamp);

                    // Verifique se a imagem do post está disponível
                    $foto = empty($coment['autor']['use_Foto']) ? BASE_URL . 'static/img/Semfoto.png' : BASE_URL . 'static/img/' . $coment['autor']['use_Foto'];
                    
                    $slug = $coment['post']['pos_Slug'];
                    $comName = $coment['autor']['use_Nome'];
                    $comId = $coment['com_Id'];
                    $comentario = $coment['com_Comentario'];
                    
                    $comentario_id = base64_encode($comId);
                        
                    ?>
                    <form name="produto" action="deleteComent.php" class="form border rounded shadow-lg" method="post" enctype="multipart/form-data">
						<br><br>
                        <h1 style="color: #39f;"><i class="fa-solid fa-square-minus"></i> Deletando Comentário</h1><br>
                        <div class="col text-start">
                            <b>Usuário:</b><br>
                            <div class="comentario">
                                <div class="img-title-coment">
                                    <a href="<?= BASE_URL ?>perfil/view.php?perfil=<?php echo $comName ?>">
                                        <img src="<?php echo $foto ?>" class="" style="max-width: 65px; max-height: 65px; width: 100%; object-fit: cover;"/>
                                    </a>
                                    <h5 class="title-comentario" style="margin-left: 0.75em;">
                                        <a href="<?= BASE_URL ?>perfil/view.php?perfil=<?php echo $comName ?>">
                                            <?php echo $comName ?>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div><br>
                        <div class="col text-start">
                            <b>Comentário:</b><br>
							<div class="comentario" style="max-width: 100%; word-wrap: break-word; background-color: #ffff;">
								<?php echo html_entity_decode($comentario); ?>
							</div>
                        </div><br>
                        <div class="col text-start">
                            <b>Data:</b><br>
                            <div class="comentario">
                                <?php echo $data_formatada ?>
                            </div>
                        </div><br>
                        <div class="d-grid col-md-9">
                            <input type="hidden" name="codigo" value="<?php echo $comentario_id ?>">
                            <input type="hidden" name="slug" value="<?php echo $slug ?>">
                            <button class="btn btn-primary" type="submit" title="Excluir" style="color: 444;"><i class="fa-solid fa-trash"></i> Excluir</button>
                            <a href="<?= BASE_URL ?>postagens/viewPost.php?slug=<?php echo $slug ?>"><button class="btn btn-outline-danger" type="button" title="Voltar" style="color: 444;"><i class="fa-solid fa-rotate-left"></i> Cancelar</button></a>
                        </div>
                        <br><br>
                    <?php endforeach ?>
				<?php endif; ?>
			</form>
        </main>
        <?php include('../inc/aside.php'); ?>
    </div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>