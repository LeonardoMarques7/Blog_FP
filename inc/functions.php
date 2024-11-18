<?php

/**
 * Retorna todos os posts publicados com suas tags e autores.
 *
 * @return array Lista de posts completos com tags e autores
 */
function AllPosts($searchTerm = '') {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM post WHERE pos_Publicado=true";

    if (!empty($searchTerm)) {
        $searchTerm = mysqli_real_escape_string($conexao, $searchTerm);
        $sql .= " AND (pos_Titulo LIKE '%$searchTerm%')";
    }

    $sql .= " ORDER BY pos_Criacao DESC";
    $result = mysqli_query($conexao, $sql);

    if (!$result) {
        die('Query falhou: ' . mysqli_error($conexao));
    }

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $post_completo = array();

    foreach ($posts as $post) {
        $post['tag'] = PostTags($post['pos_Id']);
        $post['autor'] = PostAutor($post['pos_Id']);
        array_push($post_completo, $post);
    }

    return $post_completo;
}

function PostsPriv($searchTerm = '') {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM post WHERE pos_Publicado=false";

    if (!empty($searchTerm)) {
        $searchTerm = mysqli_real_escape_string($conexao, $searchTerm);
        $sql .= " AND (pos_Titulo LIKE '%$searchTerm%')";
    }

    $sql .= " ORDER BY pos_Criacao DESC";
    $result = mysqli_query($conexao, $sql);

    if (!$result) {
        die('Query falhou: ' . mysqli_error($conexao));
    }

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $post_completo = array();

    foreach ($posts as $post) {
        $post['tag'] = PostTags($post['pos_Id']);
        $post['autor'] = PostAutor($post['pos_Id']);
        array_push($post_completo, $post);
    }

    return $post_completo;
}

/**
 * Recebe o ID do post e retorna o autor relacionado.
 *
 * @param int $pos_Id ID do post
 * @return array|false Dados do usuário ou false em caso de erro
 */
function PostAutor($pos_Id) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("
        SELECT u.* 
        FROM users u
        JOIN post p ON u.use_Id = p.pos_UserId
        WHERE p.pos_Id = ?
    ");

    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('i', $pos_Id);
    $stmt->execute();
    $result = $stmt->get_result();
    $autor = $result->fetch_assoc();
    $stmt->close();

    return $autor;
}

/**
 * Recebe o ID do comentario e retorna o autor relacionado.
 *
 * @param int $com_PostId ID do post
 * @return array|false Dados do usuário ou false em caso de erro
 */
function ComentAutor($comId) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("
        SELECT u.* 
        FROM users u
        JOIN comentarios c ON u.use_Id = c.com_IdUser
        WHERE c.com_Id = ?
    ");

    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('i', $comId);
    $stmt->execute();
    $result = $stmt->get_result();
    $autor = $result->fetch_assoc();
    $stmt->close();

    return $autor;
}

function DadosPostCom($comId) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("
        SELECT p.* 
        FROM post p
        JOIN comentarios c ON p.pos_Id = c.com_IdPost
        WHERE c.com_Id = ?
    ");

    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('i', $comId);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    return $post;
}
/**
 * Recebe o ID do post e retorna a tag relacionada a ele.
 *
 * @param int $pos_Id ID do post
 * @return array|false Dados da tag ou false em caso de erro
 */
function PostTags($pos_Id) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("
        SELECT t.* 
        FROM tags t
        JOIN post_tags pt ON t.tag_Id = pt.pos_TagId 
        WHERE pt.pos_PostId = ?
        LIMIT 1
    ");

    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('i', $pos_Id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tag = $result->fetch_assoc();
    $stmt->close();

    return $tag;
}

/**
 * Retorna todos os posts que usam a tag especificada.
 *
 * @param int $pos_TagId ID da tag
 * @return array Lista de posts completos com tags e autores
 */
function PostsDaTag($pos_TagId) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("
        SELECT ps.* 
        FROM post ps
        JOIN post_tags pt ON ps.pos_Id = pt.pos_PostId
        WHERE pt.pos_TagId = ?
        GROUP BY ps.pos_Id
        HAVING COUNT(pt.pos_TagId) = 1
    ");

    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('i', $pos_TagId);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $post_completo = array();

    foreach ($posts as $post) {
        $post['tag'] = PostTags($post['pos_Id']);
        $post['autor'] = PostAutor($post['pos_Id']);
        array_push($post_completo, $post);
    }

    $stmt->close();

    return $post_completo;
}

/**
 * Retorna o nome da tag especificada.
 *
 * @param int $tag_Id ID da tag
 * @return string|false Nome da tag ou false em caso de erro
 */
function TagNome($tag_Id) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("SELECT tag_Titulo FROM tags WHERE tag_Id = ?");
    
    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('i', $tag_Id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tag = $result->fetch_assoc();
    $stmt->close();

    return $tag ? $tag['tag_Titulo'] : false;
}

/**
 * Retorna os detalhes do post com base no slug fornecido.
 *
 * @param string $slug Slug do post
 * @return array|false Detalhes do post ou false em caso de erro
 */
function ViewPost($slug) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("
        SELECT * 
        FROM post 
        WHERE pos_Slug = ? AND pos_Publicado = true
    ");

    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post) {
        $post['tag'] = PostTags($post['pos_Id']);
		$post['autor'] = PostAutor($post['pos_Id']);
    }

    $stmt->close();

    return $post;
}


function ViewPriv($slug) {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

    $stmt = $conexao->prepare("
        SELECT * 
        FROM post 
        WHERE pos_Slug = ? AND pos_Publicado = false
    ");

    if ($stmt === false) {
        die('Prepare falhou: ' . $conexao->error);
    }

    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post) {
        $post['tag'] = PostTags($post['pos_Id']);
		$post['autor'] = PostAutor($post['pos_Id']);
    }

    $stmt->close();

    return $post;
}


function ComentPost($postId) {
	
	global $conexao;
	
    $sql = "SELECT * FROM comentarios WHERE com_IdPost= '$postId'";
    $result = mysqli_query($conexao, $sql);

    if (!$result) {
        die('<b>Query Inválida:</b>' . mysqli_error($conexao));
    } else {
		$comentario = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$coment_completo = array();
	}
	
    foreach ($comentario as $coment) {
		$comId = $coment['com_Id'];
        $coment['autor'] = ComentAutor($comId);
        array_push($coment_completo, $coment);
    }

    return $coment_completo;
	
}

function DeleteComent($comId) {
	
	global $conexao;
	
    $sql = "SELECT * FROM comentarios WHERE com_Id = '$comId'";
    $result = mysqli_query($conexao, $sql);

    if (!$result) {
        die('<b>Query Inválida:</b>' . mysqli_error($conexao));
    } else {
		$comentario = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$coment_completo = array();
	}
	
    foreach ($comentario as $coment) {
		$comId = $coment['com_Id'];
        $coment['autor'] = ComentAutor($comId);
		$coment['post'] = DadosPostCom($comId);
        array_push($coment_completo, $coment);
    }

    return $coment_completo;
	
}

/**
 * Retorna todas as tags disponíveis.
 *
 * @return array Lista de tags
 */
function AllTags() {
    global $conexao;

    if (!$conexao) {
        die('Conexão falhou: ' . mysqli_connect_error());
    }

	/**$sqlTagsStatus = "
		UPDATE tags 
		SET tag_Status = false 
		WHERE tag_Id NOT IN (
			SELECT DISTINCT pos_TagId 
			FROM post_tags
		)"; */

	$sqlTagsStatus = "
		DELETE FROM tags 
		WHERE tag_Id NOT IN (
		SELECT DISTINCT pos_TagId 
		FROM post_tags
	)"; 

 
	mysqli_query($conexao, $sqlTagsStatus);
							
	$sql = "SELECT * FROM tags WHERE tag_Status = true AND tag_Titulo != ''";
	// $sql = "SELECT * FROM tags";
	$result = mysqli_query($conexao, $sql);
	

    if (!$result) {
        die('Query falhou: ' . mysqli_error($conexao));
    }

    $tags = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $tags;
}

?>
