<?php 
/*Fonctions-modèle réalisant la gestion d'une table de la base,
** ou par extension un même ensemble de tables. 
** Cette gestion est invoquée dans les actions d'un contrôleur, 
** comme c2.
*/

	//echo ("Penser à modifier les paramètres de connect.php avant l'inclusion du fichier <br/>");
	//require ("connect.php") ; //connexion $link à MYSQL et sélection de la base
	

function read_contacts_BD($idu) {

		require ("modele/connect.php") ; 
		//global $pdo;
		
	$sql="select nom, prenom, email 
				from contact c, utilisateur u 
				where c.id_nom = :idu
				and c.id_contact = u.id_nom
				limit 0,30";
	$resultat= array(); 
	
	try {
		$commande = $pdo->prepare($sql);
		$commande->bindParam(':idu', $idu);
		$bool = $commande->execute();
		if ($bool) {
			$resultat = $commande->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			/*
				var_dump($resultat);     die ('arret ici');
			ou
				echo ('<pre>'); 
				print_r($resultat); 
				echo ('</pre>'); 	die ('arret ici');	
			ou encore
				while ($ligne = $commande->fetch()) { // ligne par ligne
				echo ('<pre>');
				print_r($ligne);
				echo ('</pre>');
				die('arret ici');
				}
			*/
			}
		}
	catch (PDOException $e) {
		$msg = utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die($msg); // On arrête tout.
	}
	
	return $resultat;

}
?>
