<?php
 
include('config/config.php');
include('inc/functions.php');
include('inc/head.php');

// Obtenha posts e tags
$posts = AllPosts();
$tags = AllTags();

 
$q = isset($_GET['search']) ? mysqli_real_escape_string($conexao, $_GET['search']) : '';
 
// SQL para buscar posts com base na consulta

$sql = "SELECT * FROM post 
        WHERE pos_Publicado = true 
        AND (pos_Titulo LIKE '%$q%' 
             OR pos_Conteudo LIKE '%$q%' 
             OR pos_Date LIKE '%$q%')";
 
$result = mysqli_query($conexao, $sql);
 
if (mysqli_num_rows($result) > 0) {
    while ($post = mysqli_fetch_assoc($result)) {
        $titulo = htmlspecialchars($post['pos_Titulo']);
        $slug = htmlspecialchars($post['pos_Slug']);
        $conteudo = htmlspecialchars($post['pos_Conteudo']);
        echo "
<article class='post'>
<h3 class='title'>
<a href='viewPost.php?slug=$slug'>$titulo</a>
</h3>
<div class='description'>
                    " . substr(html_entity_decode($conteudo), 0, 180) . "... 
<strong><a href='viewPost.php?slug=$slug'>Leia mais</a></strong>
</div>
</article>";
    }
} else {
    echo "<p>Nenhuma publicação encontrada.</p>";
}
?>

 