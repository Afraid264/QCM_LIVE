<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <title>accueil </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./vue/styleCSS/styleProf.css">
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
	<div class="container">
	<br>
	<br>
	<?php
		if ($nb_test == 0){
			echo '<p class="messagePasTest">Créez de nouveaux tests pour en lancer !</p>';
		}
		else{
			echo '
			<p> Lancement d\'une session de test </p>
			<form action="index.php?controle=utilisateur&action=lancerTest" method="post">
			<select size="1" class=form-control name="tests" action="index.php?controle=utilisateur&action=lancerTest" method="post">
			';
			for($i = 0; $i < $nb_test; $i++){
				echo '
				<option>'.$tests['titre'][$i].' | '.$tests['groupes'][$i].'</option>
				';
			}
			echo '
			</select>
			<br>
			<button type="submit" class="btn btn-primary">Lancer</button>
			</form>
			';
		}
	?>
	<div class="container5">
		<p> Création session de test : </p>
		<a href="./index.php?controle=utilisateur&action=creationTest" <button type="submit" class="btn btn-primary">Créer</button></a>
		</div>
		<br>
		<br>
		<br>
		<div class="container5">
		<p> Création d'une question :</p>
		<a href="./index.php?controle=utilisateur&action=creationquestion" <button type="submit" class="btn btn-primary">Créer</button></a>
		</div>
		<br>
		<br>
		<br>
		<div class="container5">
		<p> Création d'un theme : </p>
		<a href="./index.php?controle=utilisateur&action=creationTheme" <button type="submit" class="btn btn-primary">Créer</button></a>
		</div>
		<br>
		<br>
		<br>
	</div>
	</div>
</body>
</html>