<?php


if (!$sql) {
    die("<b>Query Inválida: </b>" . @mysqli_error($conexao));
}

$query = $conexao->query($sql);

// Verificando se algo na query - que tem no banco de dados..
if ($query->num_rows == 0) {
    echo '<div class="error"><h4>Nenhum resultado para <strong>' . htmlentities($data) . '</strong>.</h4>Tente verificar a ortografia ou usar termos mais genéricos</div>';
    echo '<div class="custom-loader"></div>';
    echo '<script>
            var Caminho = window.location.pathname;
            setTimeout(function() {
                window.location.href = Caminho;
            }, 2500);
        </script>';
} else if ($query->num_rows != 0 && htmlentities($data)) {
    // Se há resultados, exibir a mensagem com a quantidade de posts encontrados
    echo '<div class="encontrados">Encontramos ' . $query->num_rows . ' post(s) para <strong>' . htmlentities($data) . '</strong></div>';
}