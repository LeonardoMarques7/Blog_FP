<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('config/config.php');
	include('inc/head.php');
?>
    <title>Blog FP | Home</title>
</head>
<body>
    <?php include('inc/header.php') ?>
    <div class="pure-g container">
        <main class="pure-u-1 pure-u-xl-17-24 pure-u-lg-15-24" id="posts-container" style="margin-bottom: 7rem;">
            <h1>Suporte</h1><div class="linha mt-2"></div><br>
            <form  action="https://api.staticforms.xyz/submit" class="suporte-form" method="post">
                <input type="hidden" name="accessKey" value="e8c141b5-2b3b-47bf-affe-d675e2e016a4">
                <label for="nome">Nome:</label>
                <input type="text" id="nameForm" name="name" class="input-nome-suporte" required placeholder="Digite seu nome">

                <label for="email">Email:</label>
                <input type="email" id="emailForm" name="email" class="input-email-suporte" required placeholder="Digite seu email">

                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagemForm" name="message" rows="4" required class="textarea-suporte" placeholder="Digite o assunto"></textarea>
                <input type="hidden" name="redirectTo" value="https://blog-fp.infinityfreeapp.com/index.php?m=Mensagem">
                <button type="submit" class="btn-add-suporte">Enviar Mensagem</button>
            </form>
        </main>
        <?php include('inc/aside.php'); ?>
    </div>
    <?php include('inc/footer.php'); ?>
</body>
</html>