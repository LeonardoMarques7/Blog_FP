<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
    include('../inc/functions.php');
    include('../inc/head.php');

    if (isset($_GET['tag'])) {
        $pos_TagId = intval(base64_decode($_GET['tag']));
        $posts = PostsDaTag($pos_TagId);
    } else {
        $posts = []; 
    }

    $tags = AllTags();
?>
    <title>Blog FP | Posts por Tag</title>
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

        .link-turne:hover b,
        .link-turne a:hover {
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
        
        .invisible {
            display: none;
        }

        .form-area {
            width: 100%;
            background-color: #ffffff2f;
            font-weight: bold;
            color: #1b1b1b;
        }

        .form-comentario {
            font-weight: bold;
            color: #1b1b1b;
        }

        .author {
            margin-bottom: .5rem;
        }

        .like {
            color: #39ff;
        }
		
		h2 b {
            font-weight: normal;
            color: #000;
        }

        .hide {
            display: none;
        }
		
		.rounded-video {
			border-radius: 15px; 
			overflow: hidden; 
		}
    </style>
</head>
<body>
    <?php include('../inc/header.php');?>
    <div class="pure-g container">
        <main class="pure-u-1 pure-u-lg-15-24" id="posts-container">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): 
				
				$timestamp = strtotime($post['pos_Date']);
				$data_formatada = date('d/m/Y H:i', $timestamp);

				$foto = !empty($post['pos_Foto']) ? $post['pos_Foto'] : BASE_URL . 'static/posts/semimagem.jpg';
				
				$titulo = htmlspecialchars($post['pos_Titulo']);
				$tag = htmlspecialchars($post['tag']['tag_Titulo']);
				$autor = htmlspecialchars($post['autor']['use_Nome']);
				$slug = htmlspecialchars($post['pos_Slug']);
				$status = htmlspecialchars($post['pos_Publicado']);
				$conteudo = html_entity_decode($post['pos_Conteudo']);
				$limpar = strip_tags($conteudo, '<p><br><strong><em>');
				$conteudo_limpo = preg_replace("/\r|\n/", " ", strip_tags($limpar));
				
				$isVideo = false;

				if (strpos($foto, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com') !== false) {
					$isVideo = true;
				}
                ?>
				<div class="tag-post"><h2>#<?php echo $tag ?></h2></div>
				<br>
                <article class="post">
				<?php if ($isVideo): ?>
					<a href="viewPost.php?slug=<?php echo $slug ?>">
						<div>
							 <video controls>
								<source src="<?php echo htmlspecialchars($foto); ?>" type="video/mp4">
								Seu navegador não suporta a tag <code>video</code>.
							</video>
						</div>
					</a>
					<?php else: ?>
					<a href="viewPost.php?slug=<?php echo $slug ?>" title="Clique e Veja mais">
						<div>
							<img src="<?php echo $foto ?>" alt="Foto do Post" class="image-post">
						</div>
					</a>
					<?php endif; ?>
                    <h3 class="title" title="Clique e veja mais!">
                        <a href="viewPost.php?slug=<?php echo $slug ?>">
                            <?php echo $titulo ?>
                        </a>
                    </h3>
                    <div style="margin-bottom: 16px;">
						<div style=" display: -webkit-box;
									 -webkit-line-clamp: 3; 
									 -webkit-box-orient: vertical;
									 overflow: hidden;
									 text-overflow: ellipsis;
									 text-align: justify;
									 max-height: 3em; 
									 max-width: 52rem; 
									 line-height: 1.5em;">
							<?php echo $conteudo_limpo; ?>
						</div>...
						<strong>
							<a href="viewPost.php?slug=<?php echo $slug; ?>"> Leia mais</a>
						</strong>
					</div>
                    <p class="author">
						<?php echo $autor . " | " . $data_formatada ?>
					</p>
                </article>
                <?php endforeach ?>
            <?php else: ?>
                <p>Nenhum post encontrado para esta tag.</p>
            <?php endif ?>
        </main>
        <?php include('../inc/aside.php'); ?>
    </div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>
