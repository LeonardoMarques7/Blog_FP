<!DOCTYPE html>
<html lang="pt-br">
<?php 
	include('../config/config.php');
	include('../inc/head.php'); 
?>
    <title>Blog | Editando perfil</title>
</head>
<style>
    input[type="checkbox"] {
        appearance: none;
    }

    label,
    input[type="checkbox"]:hover {
        cursor: pointer;
    }

    #nav-links .img-modo {
        width: 18px;
        margin-top: 2px;
    }

    .post img {
        border-radius: 5px !important;
        margin-bottom: 0px;
    }

    .image-user {
        border-radius: 5px !important;
    }

    .post-user {
        width: 50%;
    }

    .container-post-user {
        margin-top: 1rem;
        display: flex;
        flex-direction: row;
        gap: 10px;
    }

    @media (max-width: 900px) {
        .container-post-user {
            flex-wrap: wrap;

        }

        .post-user {
            width: 100%;
        }
    }

    .author-post-user {
        font-weight: bold;
        font-size: .9rem;
        opacity: .6;
    }

    .alert-message {
        margin-top: 10px;
    }

    .input-edit-name {
        appearance: none;
        border: none;
        background-color: transparent;
        font-size: 24px;
        font-weight: bold;
    }

    .input-edit-name:focus {
        outline: none;
        border-bottom: 1px solid #ccc;
    }

    .input-edit-profissao {
        appearance: none;
        border: none;
        background-color: transparent;
        font-weight: bold;
        font-size: 16px;
        color: #39f;
    }

    .input-edit-profissao:focus {
        outline: none;
        border-bottom: 1px solid #ccc;
    }

    .perfil {
        gap: 1rem;
    }

    .btn-editar {
        border: none;
        border-radius: 25px;
        background-color: #39f;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: .5s;
    }

    .btn-editar:hover {
        background-color: #1877f2;
    }

    .d {
        display: flex;
        flex-direction: column;
        justify-content: start;
    }

    @media (max-width: 800px) {
		.perfil {
			display: flex;
			justify-content: start;
			align-items: flex-start;
			flex-direction: column;
		}
    }
</style>
<body>
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
            <div class="">
				<div style="padding-bottom: 10px;">
					<a href="perfilView.php">
						<button class="btn btn-editar">Cancelar</button>
					</a>
				</div>
                <div class="faixa-cards">
                    <form action="editarPerfil.php" method="post" enctype="multipart/form-data">
                        <div class="perfil">
                            <div class="d">
                                <img src="<?php echo BASE_URL ?>static/img/<?php echo $_SESSION['foto'] ?>" id="imgPreview" alt="Sua foto de usuario" />
                                <label class="custom-file-label" for="fileInput">
                                    <i class="fas fa-camera"></i> Selecionar Foto
                                </label>
                                <input type="file" id="fileInput" name="arquivo" class="custom-file-input" value="<?php echo $foto; ?>" onchange="loadFile(event)">

                            </div>

                            <div class="">
                                <h2><input type="text" class="input-edit-name" name="nome" value="<?php echo $_SESSION['nome'] ?>"></h2>
                                <b><input type="text" class="input-edit-profissao" name="profissao" value="<?php echo $_SESSION['profissao'] ?>"></b>
                                <input type="hidden" class="input-edit-profissao" name="login" value="<?php echo $_SESSION['login'] ?>">
                                <br>
                                <br>
                                <div class="redes">
                                    <div class="form-edit-group">
                                        <label for="instagram"><i class="fa-brands fa-instagram"></i></label>
                                        <input type="text" id="instagram" class="input-edit-redes" name="instagram" value="<?php echo $_SESSION['linkInsta'] ?>">
                                    </div>
                                    <div class="form-edit-group">
                                        <label for="twitter"><i class="fa-brands fa-twitter"></i></label>
                                        <input type="text" id="twitter" class="input-edit-redes" name="twitter" value="<?php echo $_SESSION['linkTwitter'] ?>">
                                    </div>
                                    <div class="form-edit-group">
                                        <label for="facebook"><i class="fa-brands fa-facebook"></i></label>
                                        <input type="text" id="facebook" class="input-edit-redes" name="facebook" value="<?php echo $_SESSION['linkFace'] ?>">
                                    </div>
                                </div>  
                                <button class="btn btn-editar" type="submit"><i class="fas fa-save"></i> Salvar</button>
								
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <?php include('../inc/footer.php'); ?>
	<script>
	  var loadFile = function(event) {
		var output = document.getElementById('imgPreview');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
		  URL.revokeObjectURL(output.src) 
		}
	  };
	</script>
</body>
</html>