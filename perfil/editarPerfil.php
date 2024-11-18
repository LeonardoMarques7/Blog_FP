<!DOCTYPE html>
<html lang="pt-br">
<?php 
	include('../config/config.php');
	include('../inc/head.php');
?>
    <title>Blog FP | Editando perfil</title>
</head>
<body>
    <?php include('../inc/header.php'); ?>
    <div class="container">
        <main id="posts-container">
            <?php
                $login = $_POST['login'];
                $nome = $_POST['nome'];
                $profissao = $_POST['profissao'];
                $instagram = $_POST['instagram'];
                $twitter = $_POST['twitter'];
                $facebook = $_POST['facebook'];
                $foto = $_FILES['arquivo']['name'];
                $foto_tmp = $_FILES['arquivo']['tmp_name'];

                // Verificar se a conexão com o banco de dados está funcionando
                if (!$conexao) {
                    die('Conexão falhou: ' . mysqli_connect_error());
                }

                // Verificar se um novo arquivo foi enviado
                if (!empty($foto)) {
					
					$extensao = pathinfo($foto, PATHINFO_EXTENSION);
                    $nomeArquivo = pathinfo($foto, PATHINFO_FILENAME);
					
					$nomeArquivoCompleto = $nomeArquivo . '.' . $extensao;
					
                    // Processar o upload do novo arquivo e mover para o destino desejado
                    if (move_uploaded_file($foto_tmp, '../static/img/' . $nomeArquivoCompleto)) {
                        // Atualizar o campo "imagem" na consulta SQL apenas se um novo arquivo foi enviado
                        $sqlupdate = "UPDATE users SET use_Foto='$foto', use_Nome='$nome', use_Profissao='$profissao', use_Facebook='$facebook', use_Instagram='$instagram', use_Twitter='$twitter' WHERE use_Login='$login'";
                    } else {
                        die('Falha em atualizar foto.');
                    }
                } else {
                    // Se nenhum novo arquivo foi enviado, manter o valor atual do campo "imagem"
                    $sqlupdate = "UPDATE users SET use_Nome='$nome', use_Profissao='$profissao', use_Facebook='$facebook', use_Instagram='$instagram', use_Twitter='$twitter' WHERE use_Login='$login'";
                }

                // Executando instrução SQL
                $resultado = mysqli_query($conexao, $sqlupdate);
                if (!$resultado) {
                    echo '<a href="editPerfil.php" class="btn btn-outline-primary w-100">Voltar</a>';
                    die('<b>Query Inválida:</b> ' . mysqli_error($conexao));
                } else {
                    $queryUser = "SELECT * FROM users WHERE use_Login='$login'";
                    $userResult = mysqli_query($conexao, $queryUser);
                    if ($userResult && mysqli_num_rows($userResult) > 0) {
                        $userData = mysqli_fetch_assoc($userResult);
                        // Definindo as variáveis de sessão
                        $_SESSION['login'] = $login;
                        $_SESSION['foto'] = $userData['use_Foto'];
                        $_SESSION['nome'] = $userData['use_Nome'];
                        $_SESSION['id'] = $userData['use_Id'];
                        $_SESSION['tipoUser'] = $userData['use_TypeUser'];
                        $_SESSION['profissao'] = $userData['use_Profissao'];
                        $_SESSION['linkInsta'] = $userData['use_Instagram'];
                        $_SESSION['linkTwitter'] = $userData['use_Twitter'];
                        $_SESSION['linkFace'] = $userData['use_Facebook'];
                        $_SESSION['message'] = "Perfil alterado com sucesso!";
                    }

                    // Reinicia a sessão
                    session_regenerate_id(true);
                    
                    header('Location: ' . BASE_URL . 'perfil/perfilView.php'); 
                }

                mysqli_close($conexao);
            ?>
        </main>
        <aside id="sidebar">
            <section id="search-bar">
                <a href="https://websai.cps.sp.gov.br/">
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
</body>

</html>