<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
	include('auth.php');
    include('../inc/head.php');
?>
    <title>Blog FP | Criando Post</title>
</head>
<style>
    input[type="checkbox"] {
        appearance: none;
    }

    label, input[type="checkbox"]:hover {
        cursor: pointer;
    }

    #nav-links .img-modo {
        width: 18px;
        margin-top: 2px;
    }
    
    a b {
        font-weight: bold;
        font-size: 12px;
        border: 1px solid #e50000;
        padding: 2px;
        border-radius: 2px;
        background-color: #e50000;
        color: #fff;
        transition: 0.4s;
    }

    .link-turne:hover b, .link-turne a:hover{
        color: #fff;
    }

    a:hover b {
        border: 1px solid #a70000;
        background-color: #a70000;
    }

    #foto-user {
        width: 24pt; 
        margin-right: 5px;
    }

    h2 b {
        font-weight: normal;
        color: #000;
    } 

    .btn-login {
        margin-top: 30px;
        background-color: #39f;
        color: #fff;
        border: 1px solid #39f;
        border-radius: 5px;
        padding: 5px 10px;
    }
</style>
<body>
    <?php include('../inc/header.php') ?>
    <div class="container">
        <main id="posts-container">
            <?php
                // Recuperando dados do formulário
                $nome = $_POST['nome'];
                $login = $_POST['login'];
                $tipoUser = $_POST['tipoUser'];
                $senha = $_POST['senha'];
                $senhaConfirm = $_POST['senhaConfirm'];
                $profissao = $_POST['profissao'];
                $instagram = $_POST['instagram'];
                $twitter = $_POST['twitter'];
                $facebook = $_POST['facebook'];
                $foto = $_FILES['arquivo']['name'];
                $foto_tmp = $_FILES['arquivo']['tmp_name'];

                if($senha === $senhaConfirm) {
                    // Validando o ReCAPTCHA
                    $recaptchaResponse = $_POST['g-recaptcha-response'];
                    $secret = RECAPTCHA_SECRET; // Defina sua constante RECAPTCHA_SECRET
                    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
                    $recaptchaData = [
                        'secret'   => $secret,
                        'response' => $recaptchaResponse,
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    ];

                    $options = [
                        'http' => [
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded',
                            'content' => http_build_query($recaptchaData)
                        ]
                    ];

                    $context = stream_context_create($options);
                    $response = file_get_contents($recaptchaUrl, false, $context);
                    $responseKeys = json_decode($response, true);

                    if ($responseKeys['success']) {
                        // Verificar se o email já está cadastrado
                        $sqlCheckLogin = "SELECT * FROM users WHERE use_login = '$login'";
                        $resultCheckLogin = mysqli_query($conexao, $sqlCheckLogin);

                        if (mysqli_num_rows($resultCheckLogin) > 0) {
                            // Se o login já estiver cadastrado
                            $_SESSION['messageErrorLogin'] = 'Email já cadastrado. Tente novamente.';
                            header('Location: criandoConta.php');
                            exit();
                        }

                        // Gerando código de ativação
                        $codigo_active = generate_activation_code();
                        
                        // Criptografando senha
                        $senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

                        if (!empty($foto)) {
                            // Obter extensão do arquivo
                            $extensao = pathinfo($foto, PATHINFO_EXTENSION);
                            $nomeArquivo = pathinfo($foto, PATHINFO_FILENAME);
                        
                            // Combine o nome único com a extensão
                            $nomeArquivoCompleto = $nomeArquivo . '.' . $extensao;
                        
                            // Mover o arquivo com o nome completo
                            if (move_uploaded_file($foto_tmp, '../static/img/' . $nomeArquivoCompleto)) {
                                $foto = $nomeArquivoCompleto; // Atualize o nome da imagem para salvar no banco
                            } else {
                                $_SESSION['messageErrorLogin'] = 'Erro ao enviar a foto.';
                                header('Location: criandoConta.php');
                                exit();
                            }
                        } else {
                            $foto = 'Semfoto.png';
                        }
                        

                        // Inserindo dados no banco de dados
                        $sqlinsert = register_user($login, $nome, $senhaHash, $foto, $profissao, $instagram, $twitter, $facebook, $codigo_active, $tipoUser);

                        if (!$sqlinsert) {
                            echo '<a href="index.php" class="btn btn-outline-primary w-100">Voltar</a>';
                            die('<b>Query Inválida:</b>' . mysqli_error($conexao));
                        } else {
                            // Enviando e-mail de ativação
                            send_activation_email(email: $login, activation_code: $codigo_active);
                            echo 'Verifique seu email para validar sua conta!';
                            echo '<br><br><a href="' .  BASE_URL .'login/login.php" class="btn btn-login">Página de login</a>';
                        }

                    } else {
                        // Falha no ReCAPTCHA
                        $_SESSION['messageErrorLogin'] = 'Falha na validação do reCAPTCHA. Tente novamente.';
                        header('Location: criandoConta.php');
                        exit();
                    }

                    mysqli_close($conexao);
                }else {
                    $_SESSION['message'] = 'Senhas não iguais.';
                    header('Location: criandoConta.php');
                }
            ?>
        </main>

        <aside id="sidebar">
            <section id="search-bar">
                <a href="https://websai.cps.sp.gov.br/">
                    <figure>
                        <img src="<?= BASE_URL ?>static/img/websai.png" alt="WebSai" title="CPS pesquisa do WEBSAI 2023" class="img-websai">
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