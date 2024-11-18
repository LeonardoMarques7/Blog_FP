<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
	include('../inc/head.php'); 
?>
    <title>Blog FP | Home</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
            <?php
			
			if(!empty($_SESSION['messageErrorLogin'])){
                echo "<span class='message-captcha'>" . $_SESSION['messageErrorLogin'] . "</span>";
                clear_message();
            }
            ?>
            <form class="form-cria-login" action="criarConta.php" method="post" enctype="multipart/form-data">
				<?php 
                    if(isset($_SESSION['message'])) {
                        echo '<div class="message">' . $_SESSION['message'] . '</div>';
                        clear_message();
                    }
                ?>
                <div class="form-group">
                    <label class="label-cria-login">Nome<span class="span-form">*</span> </label>
                    <input type="text" name="nome" class="input-cria-login" required placeholder="Digite seu nome" required>
                </div>

                <div class="form-group">
                    <label class="label-cria-login">Login<span class="span-form">*</span></label>
                    <input type="email" name="login" class="input-cria-login" required placeholder="Digite seu login (gmail)">
                </div>

                <div class="form-group">
                    <label class="label-cria-login">Senha<span class="span-form">*</span></label>
                    <div class="text-senha">
                        <input type="password" name="senha" class="input-senha input-senha-no-border" placeholder="Senha">
                        <span>
                        <i class="fa fa-eye" id="icon-senha" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
                        </span>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="label-cria-login text-cofirm">Confirme a senha<span class="span-form">*</span></label>
                    <input type="password" name="senhaConfirm" class="input-cria-login" required placeholder="Digite sua senha">
                </div>

                <div class="form-group d-none">
                    <label class="label-cria-login">Tipo do usuário </label>
                    <select name="tipoUser" class="select-cria-login tipoUser-select" required>
                        <?php if (isset($_SESSION['login']) && $_SESSION['tipoUser'] === 0) : ?>
                            <option value="0">Administrador</option>
                        <?php endif; ?>
                        <option value="1" selected>Usuário</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label-cria-login">Profissão </label>
                    <input type="text" name="profissao" class="input-cria-login" placeholder="Digite sua profissão">
                </div>

                <!-- Social Media Section -->
                <details>
                    <summary class="label-cria-login summary-user">Quer adicionar suas redes socias?</summary>
                    <div class="form-group icon-input">
                        <label class="label-cria-login"><i class="fa-brands fa-instagram"></i></label>
                        <input type="text" name="instagram" class="input-cria-login" placeholder="Digite seu Instagram">
                    </div>
                    <div class="form-group icon-input">
                        <label class="label-cria-login"><i class="fa-brands fa-twitter"></i></label>
                        <input type="text" name="twitter" class="input-cria-login" placeholder="Digite seu Twitter">
                    </div>
                    <div class="form-group icon-input">
                        <label class="label-cria-login"><i class="fa-brands fa-facebook"></i></label>
                        <input type="text" name="facebook" class="input-cria-login" placeholder="Digite seu Facebook">
                    </div>
                </details>


                <!-- <label class="label-cria-login">Foto: </label>
                <input type="file" name="foto" class="file-cria-login"> -->
                <label for="images" class="drop-container" id="dropcontainer">
                    <span class="drop-title">Solte a foto aqui!</span>
                    or
                    <input type="file" name="arquivo" id="images" accept="image/*">
                </label>
                <div class="g-recaptcha" data-sitekey="6LfsEV8qAAAAANXmOkSHh8UZFZxoGlTPW_3iA_p1"></div>
                <button type="submit" class="btn-cria-login">Criar conta</button>
            </form>
        </main>
        <aside id="sidebar">
            <section id="search-bar">
                <a href="https://websai.cps.sp.gov.br/acesso/Login?ReturnUrl=%2FFormulario%2FLista">
                    <figure>
                        <img src="<?= BASE_URL ?>static/img/websai.png" alt="WebSai" title="CPS pesquisa do WEBSAI 2024" class="img-websai">
                    </figure>
                </a>
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>

</html>