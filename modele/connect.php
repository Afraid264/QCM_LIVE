<?php
		
	/*Connexion IUT*/
	$hostname = "vs-wamp";
	$base= "pweb19_cusin";
	$loginBD= "pweb19_cusin";
	$passBD="x26122000";

	/*Connexion HOME
	$hostname = "localhost";
	$base= "pweb19_";
	$loginBD= "root";
	$passBD="";*/


try {

	$pdo = new PDO ("mysql:server=$hostname; dbname=$base", "$loginBD", "$passBD" , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	//die('OK connexion');
}

catch (PDOException $e) {
	die  ("Echec de connexion : " . utf8_encode($e->getMessage()) . "\n");
}

///////////////////////////////////////////
//Voici 2 lignes pour tester la connexion seule, en invoquant ce fichier.
//   Eliminer ces 2 lignes si le test est réussi !

//		$ok = 'connexion ok';
//		die ($ok); 




/********************************************************
Ancienne ecriture plus directe pour mysql mais pas polymorphe
if (! isset ($link)) {


$link = mysqli_connect($hote, $login, $pass) 
		or die ("erreur de connexion :" . mysqli_connect_error() 
		. 'numéro :' . mysqli_connect_errno()); 
mysqli_select_db($link, $bd) 
		or die ("erreur d'accès à la base :" . $bd);
		
}
*/




?>