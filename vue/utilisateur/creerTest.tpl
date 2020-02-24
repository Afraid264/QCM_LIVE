<!DOCTYPE html>
<html lang="fr">

	<head>
	  <meta charset="utf-8" />
	  <title>accueil </title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="./vue/styleCSS/creation.css">
	</head>


	<body>
	<div class = "row">
		<header>
			<div id="haut" class = "banner-area fixed-top">
				<div class = "container-fluid">
					<div class = "row align-items-center">
						<div class = "col-12 " style="background: #111">
							<nav class="navbar navbar-expand-xs navbar-dark rounded">
								<img src="./vue/images/logo_pdc.png" class=img-responsive style=width:150px>

								<div class="col-2 ml-5">
									<p>
										<span style = "color:white;">
											<?php
												echo utf8_encode($nom . ' ' .$prenom);
												echo '<br>';
												echo $nb_test .' test(s) en attente';
											?>
										</span>
									</p>
								</div>

								<ul class="navbar-nav ml-auto">
									<li class="nav-item">
										<a class="btn btn-light" href="index.php?controle=utilisateur&action=deconnect" role = "button">Deconnexion</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
	</div>
	<form action="index.php?controle=utilisateur&action=creerNewTest" method="post">
	<div id="container">
		<?php
								foreach($_SESSION['groupes'] as $grp){
								?>
									<input type="checkbox" name="grpe[]" id="<?php echo $grp['num_grpe'] ?>" value="<?php echo $grp['num_grpe'] ?>" />
		<label for = "<?php echo $grp['num_grpe'] ?>"><?php echo $grp['num_grpe'] ?></label>
		<?php
		}
		?>
	</div>

	<div id="container2">
			<p>
			<?php
				foreach($_SESSION['theme'] as $th) {
					echo utf8_encode($th['titre_theme']. ' : ');
			?>
				<br>
				<?php
					foreach($_SESSION['question'] as $qt){
					if ($qt['id_theme'] == $th['id_theme']) {
			?>
						<input type="checkbox" name="qts[]" id="<? echo utf8_encode($qt['texte']) ?>" value="<?php echo utf8_encode($qt['texte'])?>"/>
						<label for="<?php echo utf8_encode($qt['texte']) ?>"><?php echo utf8_encode($qt['texte'])?></label>
				<br>
				<?php
				}
			}
		}
			?>
			</p>
	</div>

	<div class="container3" >
			<p>
				<label for="nomTest">Nom du Test</label> :
				<input type="text" name="nomTest" id="nomTest"/>
			</p>
	</div>
			<a href="index.php"><button id="bouton" type="submit" class="btn btn-primary" >Créer</button></a>
		</form>
	</body>
</html>