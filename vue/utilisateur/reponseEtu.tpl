<!DOCTYPE html>
<html lang="fr">

	<head>
	  <meta charset="utf-8" />
	  <title>accueil </title>
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	  <link rel="stylesheet" href="./vue/styleCSS/styleRepEtu.css">
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
												echo $nomTest;
												echo '    Groupe : '.$groupe;
											?>
										</span>
									</p>
								</div>
								
								<ul class="navbar-nav ml-auto">
									<li class="nav-item">
										<a class="btn btn-light" href="index.php?controle=utilisateur&action=retourBilanProf" role = "button">Retour</a>
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
		<?php
			echo '<div class="row">';
				echo '<div class="col-6">';
				$saut = 0;
				for($i = 1; $i <= $cpt; $i++){
					echo '<div class="Question align-middle" id="question . $i">';
						echo 'Question ' .$i .' : ';
						echo '   ';
						echo '<p class="titre_question">';
							echo utf8_encode($quest_titre[$i - 1]);
						echo '</p>';
						echo '  ';
						for ($j = 1; $j <= 4; $j++){
							if ($repValide[$j - 1 + $saut] == 1){
								if ($aRepondu[$j - 1 + $saut] == 1)
									echo '<p class="ValideReponse">';
								else
									echo '<p class="Valide">';
							}
							else{
								if ($aRepondu[$j - 1 + $saut] == 1)
									echo '<p class="InvalideReponse">';
								else
									echo '<p class="Invalide">';
							}
								echo utf8_encode($texte_rep[$j - 1 + $saut]);
							echo '</p>';
						}
					echo '</div>';
					$saut += 4;
					echo '<br>';
				}
				echo '</div>';//col6
				echo '<div class="position-fixed">';
					echo '<div class="legendeCouleurs"><h5><u>Légende des couleurs</u></h5>';
						echo '<p><span class="bleu">Bleu</span> : Réponse manquante</p>';
						echo '<p><span class="vert">Vert</span> : Bonne réponse</p>';
						echo '<p><span class="rouge">Rouge</span> : Mauvaise réponse</p>';
						echo '<p><span class="gras">Gras</span> : Réponse étudiant</p>';
					echo '</div>';
					echo $nom_etu . ' ' .$prenom_etu . ' : ' . $note . ' / 20';
				echo '</div>';
			echo '</div>';//row
		?>
		</div>

	</body>
</html>