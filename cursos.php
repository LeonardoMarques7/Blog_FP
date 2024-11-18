<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('config/config.php');
    include('inc/head.php');
?>
    <title>Blog FP | Home</title>
</head>
<style>
	#map {
		max-height: 250px;
		width: 100%;
		border-radius: 10px;
		display: block;
	}
</style>
<body>
	<?php include('inc/header.php'); ?>
	<div class="pure-g container">
		<main class="pure-u-1 pure-u-xl-17-24 pure-u-lg-15-24" id="posts-container">
			<h1 class="title-curso">Etec Fernando Prestes</h1>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3658.576057709761!2d-47.47376852534445!3d-23.511774759771008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c58aeb7987bac9%3A0xbafed5f1761e6f47!2sEscola%20T%C3%A9cnica%20Estadual%20Fernando%20Prestes!5e0!3m2!1spt-BR!2sbr!4v1703168870089!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" id="map"></iframe>
				<script>
					document.getElementById('map').onload = function() {
						document.getElementById('map').style.display = 'block';
					}

					document.getElementById('map').onerror = function() {
						document.getElementById('map').style.display = 'none';
					}
				</script>
				<p class="infos-fp text-color fw-bold">
				<i class="fa-solid fa-map-location-dot info"></i>
				R. Natal, 340 - Jd. Paulistano CEP 18040-810 - Sorocaba/SP
			</p>
			<p class="infos-fp">
				<i class="fa-solid fa-phone info"></i> Telefone: (15) 3221-9677 
				<i class="fa-solid fa-phone info"></i> Telefone: (15) 3221-2044
			</p>
			<p class="infos-fp">
				<i class="fa-solid fa-at info"></i>
				E-mail:     
				<a href="mailto:e016dir@cps.sp.gov.br" class="link"> 
					e016dir@cps.sp.gov.br
				</a>
			</p>
			<p class="infos-fp">
				<i class="fa-solid fa-globe info"></i> 
				Site:
				<a href="https://www.etecfernandoprestes.com.br/" class="link">
					www.etecfernandoprestes.com.br
				</a>
			</p>
			<div class="border-info"></div>
			<div class="container-curso">
				<h2 class="title-curso-dark">Cursos oferecidos:</h2>
				<br/>
				<ul>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=501"
						   class="curso-link">
						   Administração
						</a>
						<br/><br/>
						<span>Período: Tarde - 40 vagas</span>
					</li>
					<li class="li-curso">
						<a href="https://www.etecfernandoprestes.com.br/Curso/1/administrao-modular"
						   class="curso-link">
						   Administração - (EaD - On-line)
						</a>
						<br/><br/>
						<span>Período: Tarde \ Período: Noite</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=1489"
						   class="curso-link">
						   Comércio - (EaD - On-line)
						</a>
						<br/><br/>
						<span>Período: On-line</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=506"
						   class="curso-link">
						   Contabilidade
						</a>
						<br/><br/>
						<span>Período: Noite - 40 vagas</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=1500"
						   class="curso-link">
						   Desenvolvimento de Sistemas
						</a>
						<br/><br/>
						<span>Período: Noite - 40 vagas</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=1568"
						   class="curso-link">
						   Desenvolvimento de Sistemas (EaD - On-line)
						</a>
						<br/><br/>
						<span>Período: On-line</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=1113"
						   class="curso-link">
						   Design de Interiores
						</a>
						<br/><br/>
						<span>Período: Noite - 40 vagas</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=1580"
						   class="curso-link">
						   Edificações (com até 20% online)
						</a>
						<br/><br/>
						<span>Período: Noite - 40 vagas</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=508"
						   class="curso-link">
						   Finanças
						</a>
						<br/><br/>
						<span>Período: Noite - 40 vagas</span>
					</li>
					<li class="li-curso">
						<a href="https://www.vestibulinhoetec.com.br/unidades-cursos/curso.asp?c=511"
						   class="curso-link">
						   Logística
						</a>
						<br/><br/>
						<span>Período: Noite - 40 vagas</span>
					</li>
				</ul>
			</div>
		</main>
		<?php include('inc/aside.php'); ?>
	</div>
	<?php include('inc/footer.php'); ?>
	</body>
</html>
