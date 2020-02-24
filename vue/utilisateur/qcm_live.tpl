<!DOCTYPE html>
<html lang="fr">

	<head>
	  <meta charset="utf-8" />
	  <title>accueil </title>
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	  <link rel="stylesheet" href="./vue/styleCSS/styleQCM.css">
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
												echo utf8_encode($nomTest);
												echo '<br>';
												echo 'Groupe : ' .$num;
											?>
										</span>
									</p>
								</div>
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
					if ($questValide[$i - 1] == 0)
						echo '<div class="Question align-middle" id="question . $i">';
					else
						echo '<div class="QuestionBloque" id="question . $i">';
						echo 'Question ' .$i .' : ';
						echo '   ';
						echo '<p class="titre_question">';
							echo utf8_encode($quest_titre[$i - 1]);
						echo '</p>';
						echo '  ';
						for ($j = 1; $j <= 4; $j++){
							if ($repValide[$j - 1 + $saut] == 1)
								echo '<p class="Valide">';
							else
								echo '<p class="Invalide">';
								echo utf8_encode($texte_rep[$j - 1 + $saut]);
								echo ' : ' .nbRepEtu($idTest, $idQuestions[$i - 1] ,$j) . ' étudiant(s)';
							echo '</p>';
						}
						echo '<form method="post" action="index.php?controle=utilisateur&action=arreterQuestion">';
							echo '<select size="1" class="form-control invisible" name="question" action="index.php?controle=utilisateur&action=arreterQuestion" method="post">';
									echo '
									<option>'.$idTest.' | '.$idQuestions[$i - 1].'</option>
									';
							echo '</select>';
							echo '<button type="submit">Arrêter</button>';
						echo '</form>';
					echo '</div>';
					$saut += 4;
					echo '<br>';
				}
				echo '</div>';//col6
				echo '<div class="position-fixed">';
					echo '<p class="infosTest">'.$nomTest.'</p>';
					echo '<p class="groupe">';
					echo 'Groupe ' .$num;
					echo ' : ';
					echo $etuCo;
					echo '/';
					echo $etuTot;
					echo '</p>';
					echo '<form method="post" action="index.php?controle=utilisateur&action=arreterTest">';
							echo '<select size="1" class="form-control invisible" name="infoTest" action="index.php?controle=utilisateur&action=arreterTest" method="post">';
									echo '
									<option>'.$idTest.'</option>
									';
							echo '</select>';
							echo '<button type="submit">Arrêter Test</button>';
						echo '</form>';
				echo '</div>';
			echo '</div>';//row
		?>
		</div>

	</body>
</html>