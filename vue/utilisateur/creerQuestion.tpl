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
	<form action="index.php?controle=utilisateur&action=creerNewQuestion" method="post">

		<div class="container4">
			<p>
				<?php
				foreach($_SESSION['theme'] as $th) {
				?>
					<input type="radio" name="th[]" id="<? echo $th['titre_theme'] ?>" value="<?php echo $th['titre_theme']?>"/>
				<label for="<?php echo $th['titre_theme']?>"><?php echo utf8_encode($th['titre_theme'])?></label>
				<br>
				<?php
				}
			?>
			</p>
		</div>
	<div class="container3" >
			<p>
				<label for="titreQt">Titre de la question</label> :
				<input type="text" name="titreQt" id="titreQt"/>
			</p>
	</div>

		<div class="container3" >
			<p>
				<label for="descQt">Description de la question</label> :
				<input type="text" name="descQt" id="descQt"/>
			</p>
		</div>

		<div class="container3" >
			<p>
				<label for="Rep1">Réponse 1</label> :
				<input type="Rep1" name="Rep1" id="Rep1"/>
			</p>
			<P>
				<label for="Rep2">Réponse 2</label> :
				<input type="Rep2" name="Rep2" id="Rep2"/>
			</P>
			<P>
				<label for="Rep3">Réponse 3</label> :
				<input type="Rep3" name="Rep3" id="Rep3"/>
			</P>
			<P>
				<label for="Rep4">Réponse 4</label> :
				<input type="Rep4" name="Rep4" id="Rep4"/>
			</p>
		</div>

		<div class="container3" >
			<p>
		<input type="radio" name="choix" id="choix1" value="choix1" checked onclick="show2()"/>
		<label for="choix1"> Choix multiple </label>
			</p>
			<P>
		<input type="radio" name="choix" id="choix2" value="choix2" onclick="show1()"/>
		<label for="choix2">Choix simple </label>
			</p>
		</div>
		<div class="container3">
			<p>
				Choix Bonne réponse :
			</p>
			<p>
				<input type="checkbox" name="rep1" id="rep1" value="rep1"/>
				<label for="rep1"> Réponse1 </label>
			</p>
			<p>
				<input type="checkbox" name="rep2" id="rep2" value="rep2"/>
				<label for="rep2"> Réponse2 </label>
			</p>
			<p>
				<input type="checkbox" name="rep3" id="rep3" value="rep3"/>
				<label for="rep3"> Réponse3 </label>
			</p>
			<p>
				<input type="checkbox" name="rep4" id="rep4" value="rep4"/>
				<label for="rep4"> Réponse4 </label>
			</p>
		</div>

			<a href="index.php"><button id="bouton" type="submit" class="btn btn-primary" >Créer</button></a>
		</form>
	</body>
</html>