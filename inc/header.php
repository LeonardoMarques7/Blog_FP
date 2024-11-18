<header id="home">
		<nav id="navbar">
			<div id="navbar-inner">
				<style>
					.active a {
						border: 1px solid #39f;
						background-color: #39f;
						color: #fff;
						padding: 5px 10px;
						border-radius: 5px;
					}

					.perfil-header {
						width: 30px;
						border-radius: 50%;
						cursor: pointer;
						padding: 2px;
						border: 2px solid #707070;
					}
				</style>
				<a href="<?= BASE_URL ?>index.php">
					<img src="<?php echo BASE_URL ?>static/img/288-logo-etec-fernando-prestes.svg" alt="" id="logo-page" style="filter: invert(100%);">
				</a>
				<ul id="nav-links">
					<li><a href="<?= BASE_URL ?>index.php">Home</a></li>
					<?php
					session_start();

					if (!isset($_SESSION['login'])) {
						echo '<li><a href="' . BASE_URL . 'login/login.php">Logar</a></li>';
					} else {
						if ($_SESSION['tipoUser'] == 0) {
							echo '<li><a href="' . BASE_URL . 'dashboard.php">Dashboard</a></li>';
						};
						echo '<li class="active"><a href="#" onclick="confirmLogout(event)">Sair</a></li>';
					}
					?>					
					<?php

					if (isset($_SESSION['login'])) {
						$foto = $_SESSION['foto'];
						echo "<a href='". BASE_URL ."perfil/perfilView.php'><li><img src='" . BASE_URL . "static/img/$foto' class='perfil-header'/></li></a>";
					}

					function clear_message()
					{
						$_SESSION['message'] = null;
						$_SESSION['messageErrorLogin'] = null;
					}
					?>
				</ul>
			</div>
		</nav>
	</header>
	<div id="logoutModal" style="display: none">
		<div class="modal-content">
			<p>Tem certeza de que deseja sair?</p>
			<button onclick="logout()" class="btn-sair-modal">Sair</button>
			<button onclick="closeModal()" class="btn-cancelar-modal">Cancelar</button>
		</div>
	</div> 
	
	<script>
		
		// Modal sair
		function confirmLogout(event) {
			event.preventDefault(); // Impede o redirecionamento imediato
			document.getElementById('logoutModal').style.display = 'flex';
		}

		function closeModal() {
			document.getElementById('logoutModal').style.display = 'none';
		}

		function logout() {
			window.location.href = '<?= BASE_URL ?>login/logout.php';
		}
	</script>