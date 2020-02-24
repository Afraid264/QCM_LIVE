<!DOCTYPE html>
<html lang = "fr">
<head>
	<meta charset="UTF-8">
    <title>Title</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link type="text/css" rel="stylesheet" href="./vue/styleCSS/styleAccueilEtu.css">
	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>

<div class = "container-fluid h-100">


<!-- le header -->
	<div class = "row">
		<div id="header">
			<div id="haut" class = "banner-area fixed-top">
				<div class = "container-fluid">
					<div class = "row align-items-center">
						<div class = "col-12 " style="background: #111">
							<nav class="navbar navbar-expand-xs navbar-dark rounded">
								<img src="./vue/images/logo_pdc.png" class=img-responsive style=width:150px>
								
								<div class="col-7 ml-5">
									<p>
										<span style = "color:white;">
											<?php 	
												echo $nom . "  " . $prenom;
												echo "<br>" . $group ;
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
		</div>
	</div>

	
	<!-- le contenu de la page -->
	<div id = "contenu" class = "row pb-5 mb-5">
		<div class="col-10 offset-1 pt-5 mt-5">
		
		<article id = "Test">
			<!-- afficher le test -->
			<h4>
				Test : 
				
				<?php
				
					if($test_done){
						echo 'Test déjà fait';
					}
					else{
						if($test['bActif'] == 1){				
							echo $test['titre_test'];
						}
						else {
							echo 'Test inexistant ou inactif';
						}
					}
				?>
				
			</h4>
			
		
			<?php
				if(!$test_done){
					if(isset($_POST['Valider'])) {

						echo '<article id= "Question">';
					
						require_once("./controle/utilisateur.php");
						enregistrerResultat();
						
						$note = 0;
						
						for($i = 0; $i < count($_SESSION['question']); $i++){
						
							foreach($_SESSION['qcm'] as $qcm){		
											
								if ($qcm['id_quest'] == $_SESSION['question'][$i]['id_quest']){
									if($qcm['bBloque'] != 1){
						
										for($k = 0; $k < count($_SESSION['theme']); $k++){
											if($_SESSION['question'][$i]['id_theme'] == $_SESSION['theme'][$k]['id_theme']){
												echo '<br><p id ="Theme">Thème : ' . $_SESSION['theme'][$k]['titre_theme'] . '</p>';
												break;
											}
										}
									
										echo '<p id="AfficherQuestion">' . $_SESSION['question'][$i]['texte'] . '</p>';
										
										echo 'Votre réponse : <br>';
										
											if(isset($_POST["reponseSimple$i"])){
											
												$id_rep = $_POST['reponseSimple'.$i];
												
												for($j=0; $j < count($_SESSION['reponse']); $j++){
													if($id_rep == $_SESSION['reponse'][$j]['id_rep']){
														echo '- ' . $_SESSION["reponse"][$j]["texte_rep"] . '<br>';
														if($_SESSION['reponse'][$j]['bvalide'] == 1){
															$note++;
														}
													}
												}
												
											}
										
											if(isset($_POST["reponseMultiple$i"])){
											
												for($j=0; $j < count($_SESSION['reponse']); $j++){
												
													foreach($_POST["reponseMultiple$i"] as $val){
														if($val == $_SESSION['reponse'][$j]['id_rep']){
															echo '- ' . $_SESSION["reponse"][$j]["texte_rep"] . '<br>';
															if($_SESSION['reponse'][$j]['bvalide'] == 1){
																$note++;
															}
															else {
																$note = $note-0.5;
															}
														}
													}
													
												}
											}
										
										
										echo '<br><p id="bonneReponse">Bonne(s) réponse(s) : </p>';
										
										for($j = 0; $j < count($_SESSION['reponse']); $j++){
											if($_SESSION['reponse'][$j]['bvalide'] == 1 and $_SESSION['reponse'][$j]['id_quest'] == $_SESSION['question'][$i]['id_quest']){
												echo '- ' . $_SESSION['reponse'][$j]['texte_rep'] . '<br>';
											}
										}
										
									}
								}
							}
						}
						
						echo '</article>';
						
						
						$notemax = 0;
						for ($i=0; $i < count($_SESSION['qcm']); $i++){
							foreach($_SESSION['qcm'] as $qcm){		
											
								if ($qcm['id_quest'] == $_SESSION['question'][$i]['id_quest']){
									if($qcm['bBloque'] != 1){
										if($_SESSION['qcm'][$i]['id_test'] == $test['id_test']){
											for($j=0; $j < count($_SESSION['reponse']); $j++){
												if($_SESSION['reponse'][$j]['bvalide'] == 1 && $_SESSION['qcm'][$i]['id_quest'] == $_SESSION['reponse'][$j]['id_quest']){
													$notemax++;
												}
											}
										}
									}
								}
							}
						}
						
						if($notemax != 0){
						
							$note = (($note*20)/$notemax);
							require_once("./controle/utilisateur.php");
							enregistrerBilan($note);
							
							echo '<article id ="Note"><br>Votre note : ' . $note .' / 20 </article>';
						}
					}
					else {
						if($test['bActif'] == 1){
						
							
							
							
								echo '<form id ="formquest" action="" method="POST">';
								
								
							
								for($i = 0; $i < count($_SESSION['question']); $i++){
									foreach($_SESSION['qcm'] as $qcm){		
										
										if ($qcm['id_quest'] == $_SESSION['question'][$i]['id_quest']){
											if($qcm['bBloque'] != 1){
												if($_SESSION['question'][$i]['bmultiple'] != 0){
												
													for($k = 0; $k < count($_SESSION['theme']); $k++){
														if($_SESSION['question'][$i]['id_theme'] == $_SESSION['theme'][$k]['id_theme']){
															echo '<br><p id ="Theme">Thème : ' . $_SESSION['theme'][$k]['titre_theme'] . '</p>';
															break;
														}
													}
													
													echo '<p id="AfficherQuestion">' . $_SESSION['question'][$i]['texte'] . '<br>(Choix multiple)</p>';
													
														for($j = 0; $j < count($_SESSION['reponse']); $j++){
															if($_SESSION['reponse'][$j]['id_quest'] == $_SESSION['question'][$i]['id_quest']){
																echo '<input type="checkbox" id="reponseMultiple" name="reponseMultiple'. $i .'[]" value="' . $_SESSION['reponse'][$j]['id_rep'] . '">	' 
																	. $_SESSION['reponse'][$j]['texte_rep'] . '<br>';
															}
														}
												}
												else{										
													for($k = 0; $k < count($_SESSION['theme']); $k++){
														if($_SESSION['question'][$i]['id_theme'] == $_SESSION['theme'][$k]['id_theme']){
															echo '<br><p id ="Theme">Thème : ' . $_SESSION['theme'][$k]['titre_theme'] . '</p>';
															break;
														}
													}
													
													echo '<p id="AfficherQuestion">' . $_SESSION['question'][$i]['texte'] . '</p>';
													
													for($j = 0; $j < count($_SESSION['reponse']); $j++){
														
														if($_SESSION['reponse'][$j]['id_quest'] == $_SESSION['question'][$i]['id_quest']){
															
															echo '<input type="radio" id="reponseSimple" name="reponseSimple'. $i .'" value="' . $_SESSION['reponse'][$j]['id_rep'] . '">	' 
															. $_SESSION['reponse'][$j]['texte_rep'] . '<br>';
															
														}
													}
												}
											}	
										}		
									}
								}
						}
								echo '<br><input type="submit" id="Valider" name="Valider" value="Valider">';
								
								
								echo '</form>';
							
						
					}
					
				}
			

			?>		
			
			</article>
		</div>
		
	</div>

	
</div>

</body>
</html>
