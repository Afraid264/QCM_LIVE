<!DOCTYPE html>
<html lang="fr">

	<head>
	  <meta charset="utf-8" />
	  <title>accueil </title>
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	  <link rel="stylesheet" href="./vue/styleCSS/styleBilanProf.css">
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
												echo'<br>';
												echo '    Groupe : '.$num;
											?>
										</span>
									</p>
								</div>
								
								<ul class="navbar-nav ml-auto">
									<li class="nav-item">
										<a class="btn btn-light" href="index.php?controle=utilisateur&action=retourAccueilProf" role = "button">Retour</a>
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
			<div class="row">
			<?php 
			$moyenne = 0;
			$nb = 0;
			echo '<div class="col-8">';
				foreach($etuTest as $etu){
					echo '<div class="etudiant">';
					if ($etu['note'] == -1)
						echo utf8_encode($etu['nom'] . ' ' . $etu['prenom'] . ' : absent');
					else{
						echo utf8_encode($etu['nom'] . ' ' . $etu['prenom'] . ' : ' . $etu['note'] . ' / 20');
						echo '<form method="post" action="index.php?controle=utilisateur&action=voirReponses">';
								echo '<select size="1" class="form-control invisible" name="reponses" action="index.php?controle=utilisateur&action=voirReponses" method="post">';
										echo '
										<option>'.$idTest.'|'.$etu['id_etu'].'|'.$etu['nom'].'|'.$etu['prenom'].'|'.$etu['note'].'|'.$nomTest.'|'.$num.'</option>
										';
								echo '</select>';
								echo '<button type="submit">Voir réponses</button>';
						echo '</form>';
					}
					echo '<br>';
					echo '</div>';
					if ($etu['note'] != -1)
						$moyenne += $etu['note'];
					$nb++;
				}
			echo '</div>';
			echo '<div class="col-4 position-fixed">';
			$moyenne = round(($moyenne/$nb),2);
			echo '<p class="Moyenne">Moyenne Test : '.$moyenne.'/20</p>';
			echo '</div>';

			?>
			</div>
		</div>
	</body>
</html>