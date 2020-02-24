<?php 
/*controleur de gestion des contacts
*/

/**
liste_c implémente le service de liste de constcta d'un utilisateur
$idu est un parametre de la requete index.php?controle=contact&action=liste_c&idu=1
pour l'utilisateur numéro 1
**/
function liste_c() {
		require ('./modele/contactBD.php');
		$idu = $_GET['idu'];
		$L =read_contacts_BD($idu);
		require ('./vue/contact/liste_c.tpl');		
}



function creer_c() {
}
function modifier_c() {
}