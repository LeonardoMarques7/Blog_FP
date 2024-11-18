<!DOCTYPE html>
<html lang="pt-br">
<?php 
    include('../config/config.php');
	include('auth.php');
    include('../inc/head.php');
?>
    <title>Blog FP | Validação</title>
</head>
<body>
    <?php include('../inc/header.php') ?>
    <div class="container">
        <main id="posts-container">
		<?php
		
		$email = $_GET['e'];
		$code = $_GET['c'];

		$user = find_unverified_user($code, $email);

		if ($user && activate_user($user['use_Id'])) {
			echo '<div class="custom-loader"></div>';
			echo '<script>
					setTimeout(function() {
						window.location.href = "login.php";
					}, 1000);
				  </script>';
		} else {
			echo '<div class="custom-loader"></div>';
			echo '<script>
					setTimeout(function() {
						window.location.href = "login.php";
					}, 1000);
				  </script>';
		}

		?>
        </main>
	</div>
    <?php include('../inc/footer.php'); ?>
</body>
</html>