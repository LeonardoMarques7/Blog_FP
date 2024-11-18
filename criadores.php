<!DOCTYPE html>
<html lang="pt-br">
<?php 
include('config/config.php');
include('inc/head.php');
?>
    <title>Blog | Criadores</title>
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
</style>
<body>
    <?php include('inc/header.php') ?>
    <div class="pure-g  container">
        <main class="pure-u-1 pure-u-xl-17-24 pure-u-lg-15-24" id="posts-container">
			<div class="container-criadores">
				<div class="card-criador">
					<img src="static/img/leo.png"
						 alt="Foto"
						 class="img-criador"/>
					<h2>Leonardo Marques</h2>
					<div class="content-card">
						<strong class="profile-insta"><a href="">@leonardoMarques</a></strong>
						<a href="https://delve.office.com/?u=9e95e692-b83f-4ebc-9972-d94809f4e0c7&v=work">
							<button class="contato-button">
								<i class="fa-regular fa-envelope"></i>
							</button>
						</a>
					</div>
				</div>
				<div class="card-criador">
					<img src="static/img/manu.png"
						 alt="Foto"
						 class="img-criador"/>
					<h2>Manoela Moraes</h2>
					<div class="content-card">
						<strong class="profile-insta"><a href="https://www.instagram.com/manu.tjx/">@manu.tjx</a></strong>
						<a href="https://delve.office.com/?u=8cc24190-c073-48af-8b84-1f35a108bf07&v=work" >
							<button class="contato-button">
								<i class="fa-regular fa-envelope"></i>
							</button>
						</a>
					</div>
				</div>
				<div class="card-criador">
					<img src="static/img/geo.png"
						 alt="Foto"
						 class="img-criador"/>
					<h2>Geovana Terra</h2>
					<div class="content-card">
						<strong class="profile-insta"><a href="https://www.instagram.com/__te777/">@__te777</a></strong>
						<a href="https://delve.office.com/?u=a603630d-56b0-4b35-aef4-446f1631cacc&v=work">
							<button class="contato-button">
								<i class="fa-regular fa-envelope"></i>
							</button>
						</a>
					</div>
				</div>
				<div class="card-criador">
					<img src="static/img/nathy.png"
						 alt="Foto"
						 class="img-criador"/>
					<h2>Natália Hidemi</h2>
					<div class="content-card">
						<strong class="profile-insta"><a href="https://www.instagram.com/nat_sski/">@nat_sski</a></strong>
						<a href="https://delve.office.com/?u=e24f47a8-33f8-43d4-bb62-a471078bdf42&v=work">
							<button class="contato-button">
								<i class="fa-regular fa-envelope"></i>
							</button>
						</a>
					</div>
				</div>
				<div class="card-criador">
					<img src="static/img/matteus.jpg"
						 alt="Foto"
						 class="img-criador"/>
					<h2>Matteus Guilherme</h2>
					<div class="content-card">
						<strong class="profile-insta"><a href="https://www.instagram.com/mattetteus/">@mattetteus</a></strong>
						<a href="https://delve.office.com/?u=907ca394-9b97-470f-ab47-81f81813c60f&v=work">
							<button class="contato-button">
								<i class="fa-regular fa-envelope"></i>
							</button>
						</a>
					</div>
				</div>
			</div>
        </main>
        <?php include('inc/aside.php'); ?>
    </div>
    <?php include('inc/footer.php'); ?>
</body>

</html>