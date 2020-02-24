<?php 
/*Fonctions-modèle réalisant la gestion d'une table de la base,
** ou par extension gérant un ensemble de tables. 
** Les appels à ces fcts se fp,t dans c1.
*/
//istudiant
function verif_ident_ETUBD($nom,$num,&$profil,&$test){ 
	require_once ("modele/connect.php") ; 
	$sql_etu="SELECT * FROM `etudiant`      where  login_etu=:nom and pass_etu=:num";	
	$sql_theme="SELECT theme.* FROM (((`theme` INNER JOIN `question` ON theme.id_theme = question.id_theme) INNER JOIN `qcm` ON question.id_quest = qcm.id_quest) INNER JOIN `test` ON qcm.id_test = test.id_test) WHERE test.titre_test =:test   ";
	$sql_qcm="SELECT qcm.* FROM (`qcm` INNER JOIN `question` ON qcm.id_quest = question.id_quest)INNER JOIN `test` ON qcm.id_test = test.id_test where qcm.id_test = (SELECT test.id_test FROM `test`       where test.titre_test=:test) and test.num_grpe = (SELECT etudiant.num_grpe FROM `etudiant`      where  login_etu=:nom and pass_etu=:num) ";
	$sql_question="SELECT question.* FROM (`qcm` INNER JOIN `question` ON qcm.id_quest = question.id_quest)INNER JOIN `test` ON qcm.id_test = test.id_test where qcm.id_test = (SELECT test.id_test FROM `test` where titre_test=:test) AND test.num_grpe = (SELECT etudiant.num_grpe FROM `etudiant`      where  login_etu=:nom and pass_etu=:num)";
	$sql_reponse="SELECT reponse.* FROM `reponse` INNER JOIN `question` ON reponse.id_quest = question.id_quest";
	$sql_test="SELECT test.* FROM `test`INNER JOIN `etudiant` ON test.num_grpe = etudiant.num_grpe WHERE test.titre_test=:test AND test.num_grpe = (SELECT etudiant.num_grpe FROM `etudiant`      where  login_etu=:nom and pass_etu=:num)";
	$sql_bilan="SELECT * FROM bilan WHERE (SELECT test.id_test FROM `test` where titre_test=:test)";
	
	//$profil = array();
	$res_etu= array();  
	$res_theme=array();	
	$res_qcm=array();	
	$res_question=array();
	$res_reponse=array();
	$res_test=array();
	$res_bilan=array();
	
	try {
		$cde_etu = $pdo->prepare($sql_etu);
		$cde_etu->bindParam(':nom', $nom);
		$cde_etu->bindParam(':num', $num);
		$b_etu = $cde_etu->execute();

		$cde_theme = $pdo->prepare($sql_theme);
		$cde_theme->bindParam(':test', $test);
		$b_theme = $cde_theme->execute();

		
		$cde_test = $pdo->prepare($sql_test);
		$cde_test->bindParam(':test', $test);
		$cde_test->bindParam(':nom', $nom);
		$cde_test->bindParam(':num', $num);
		$b_test = $cde_test->execute();

		$cde_qcm = $pdo->prepare($sql_qcm);
		$cde_qcm->bindParam(':test', $test);
		$cde_qcm->bindParam(':nom', $nom);
		$cde_qcm->bindParam(':num', $num);
		$b_qcm = $cde_qcm->execute();
		
		$cde_question = $pdo->prepare($sql_question);
		$cde_question->bindParam(':test', $test);
		$cde_question->bindParam(':nom', $nom);
		$cde_question->bindParam(':num', $num);
		$b_question = $cde_question->execute();
		
		$cde_reponse = $pdo->prepare($sql_reponse);
		$cde_reponse->bindParam(':theme', $theme);
		$b_reponse = $cde_reponse->execute();
		
		$cde_bilan = $pdo->prepare($sql_bilan);
		$cde_bilan->bindParam(':test', $test);
		$b_bilan = $cde_bilan->execute();
		
		if (($b_etu)) {
			$res_etu = $cde_etu->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			$res_theme= $cde_theme->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			$res_test= $cde_test->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			$res_qcm= $cde_qcm->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			$res_question= $cde_question->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			$res_reponse= $cde_reponse->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			$res_bilan= $cde_bilan->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
	
	if ((count($res_etu)> 0)) {
		$profil = $res_etu[0];
		$profil['mode']="etudiant";
		$_SESSION['test'] = $res_test[0];
		$_SESSION['theme'] = array();
		$_SESSION['question'] = array();
		$_SESSION['qcm']= array();
		$_SESSION['reponse']= array();
		$_SESSION['bilan']= array();  // ajouter !!!!!!!!!!!!!!!!!!
		
		foreach ($res_theme as $arrayElement){
			
			$_SESSION['theme'][] = $arrayElement;
		}
		foreach ($res_qcm as $arrayElement){
			
			$_SESSION['qcm'][] = $arrayElement;
		}
		foreach ($res_question as $arrayElement){
			
			$_SESSION['question'][] = $arrayElement;
		}
		foreach ($res_reponse as $arrayElement){
			
			$_SESSION['reponse'][] = $arrayElement;
		}
		
		foreach ($res_bilan as $arrayElement){
			
			$_SESSION['bilan'][] = $arrayElement;
		}
		return true;
	}	
	return false;
}
//isProf
function verif_ident_PROFBD($nom,$num,&$profil){ 
	require ("modele/connect.php") ; 
	$sql_prof="SELECT * FROM `professeur` 	where login_prof=:nom and pass_prof=:num";
	$res_etu= array(); 
	$res_prof= array();
	
	try {
		$cde_prof = $pdo->prepare($sql_prof);
		$cde_prof->bindParam(':nom', $nom);
		$cde_prof->bindParam(':num', $num);
		$b_prof = $cde_prof->execute();
		
		if (($b_prof)) {
			$res_prof= $cde_prof->fetchAll(PDO::FETCH_ASSOC);
			}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die();
	}
	
	if ((count($res_prof)> 0)){
		$profil = $res_prof[0];
		$profil['mode']="professeur";	
		return true;
	}
	
	$profil = array();
	return false;
}

function liste_groupesBD(){
	require ("modele/connect.php");
	$sql_grp="SELECT num_grpe FROM groupe";
	$res_grp=array(); 
	$cde_grp = $pdo->prepare($sql_grp);
	$b_grp = $cde_grp->execute();
	if ($b_grp)
		$res_grp = $cde_grp->fetchAll(PDO::FETCH_ASSOC);
	$_SESSION['groupes'] = array();
	foreach ($res_grp as $grp){
		$_SESSION['groupes'][] = $grp;
	}
}

function liste_testsBD($id){
	require('./modele/connect.php');
	$sql_test="SELECT num_grpe, titre_test FROM `test` where id_prof=:id_prof and bTraite=0";
	$res_test= array();
	$cde_test = $pdo->prepare($sql_test);
	$cde_test->bindParam(':id_prof', $id);
	$b_test = $cde_test->execute();
	if ($b_test){
		$res_test = $cde_test->fetchAll(PDO::FETCH_ASSOC);
	}
	$_SESSION['tests'] = array();
	$_SESSION['tests']['groupes'] = array();
	$_SESSION['tests']['titre'] = array();
	$taille = 0;
	foreach ($res_test as $test){
		$_SESSION['tests']['groupes'][] = $test['num_grpe'];
		$_SESSION['tests']['titre'][] = $test['titre_test'];
		$taille++;
	}
	return $taille;
}

function infos_testBD($id_test){
	require('./modele/connect.php');
	$sql_test ="SELECT titre_test, num_grpe FROM `test` where id_test=:id_test";
	$res_test = array();
	$cde_test = $pdo->prepare($sql_test);
	$cde_test->bindParam(':id_test', $id_test);
	$b_test = $cde_test->execute();
	if ($b_test){
		$res_test = $cde_test->fetchAll(PDO::FETCH_ASSOC);
	}
	foreach($res_test as $test){
		return $test;
	}
}

function lancerTestBD($titre, $grp, $id){
	require('./modele/connect.php');
	$sql_test="UPDATE `test` set bActif = 1 where titre_test=:titre and num_grpe=:grp and id_prof=:id_prof";
	$cde_test = $pdo->prepare($sql_test);
	$cde_test->bindParam(':titre', $titre);
	$cde_test->bindParam(':grp', $grp);
	$cde_test->bindParam(':id_prof', $id);
	$b_test = $cde_test->execute();

	$sql_test ="SELECT id_test FROM `test` where titre_test=:titre and num_grpe=:grp and id_prof=:id_prof";
	$res_test = array();
	$cde_test = $pdo->prepare($sql_test);
	$cde_test->bindParam(':titre', $titre);
	$cde_test->bindParam(':grp', $grp);
	$cde_test->bindParam(':id_prof', $id);
	$b_test = $cde_test->execute();
	if ($b_test){
		$res_test = $cde_test->fetchAll(PDO::FETCH_ASSOC);
	}
	foreach($res_test as $test){
		return $test['id_test'];
	}
}
//return nombre de questions
//Met dans la variable SESSION['qcm']['nbEtuRep'] le nombre d'étudiants ayant choisi chaque réponse
//Met dans la variable SESSION['qcm']['bValide'] 0 ou 1 en fonction de si une reponse est correcte ou pas
//Met dans la variable SESSION['qcm']['nbEtuRep'] le libellé de chaque réponse
function questions_testBD($id_test){
	require('./modele/connect.php');
	$sql_qcm ="SELECT q.id_quest, q.texte, test.num_grpe, test.titre_test FROM `question` as q,`reponse`as r, `qcm`, `test` where qcm.id_test=:id_test and qcm.id_quest = q.id_quest and r.id_quest=qcm.id_quest GROUP BY q.texte ORDER BY 1";
	$res_qcm = array();
	$cde_qcm = $pdo->prepare($sql_qcm);
	$cde_qcm->bindParam(':id_test', $id_test);
	$b_qcm = $cde_qcm->execute();
	if ($b_qcm){
		$res_qcm = $cde_qcm->fetchAll(PDO::FETCH_ASSOC);
	}
	$_SESSION['qcm'] = array();
	$_SESSION['qcm']['id_test'] = array();
	$_SESSION['qcm']['num_groupe'] = array();
	$_SESSION['qcm']['titre'] = array();
	$_SESSION['qcm']['id_test'][0] = $id_test;
	$_SESSION['qcm']['texte'] = array();
	$_SESSION['qcm']['texte_rep'] = array();
	$_SESSION['qcm']['nbEtuRep'] = array();
	$_SESSION['qcm']['idQuest'] = array();
	$_SESSION['qcm']['bValide'] = array();
	$cpt=0;
	$saut = 0;
	foreach($res_qcm as $quest){
		$_SESSION['qcm']['texte'][] = $quest['texte'];
		$_SESSION['qcm']['idQuest'][] = $quest['id_quest'];
		$_SESSION['qcm']['num_groupe'][0] = $quest['num_grpe'];
		$_SESSION['qcm']['titre'][0] = $quest['titre_test'];
		$quest_rep = texteReponse($quest['id_quest']);
		for($i = 0; $i < 4; $i++){
			$_SESSION['qcm']['nbEtuRep'][$i + $saut] = nbRepEtu($id_test, $quest['id_quest'] - 1, $i+1);
			$_SESSION['qcm']['bValide'][] = bvalideReponse($quest['id_quest'], $i+1);
			$_SESSION['qcm']['texte_rep'][] = $quest_rep[$i];
		}

		$cpt++;
		$saut += 4;
	}
	
	return $cpt;
}
//Return les libelles de chaque réponse d'une question
function texteReponse($id_quest){
	require('./modele/connect.php');
	$sql_qcm ="SELECT texte_rep from `reponse` where id_quest=:id_quest";
	$res_qcm = array();
	$cde_qcm = $pdo->prepare($sql_qcm);
	$cde_qcm->bindParam(':id_quest', $id_quest);
	$b_qcm = $cde_qcm->execute();
	if ($b_qcm){
		$res_qcm = $cde_qcm->fetchAll(PDO::FETCH_ASSOC);
	}
	$texte_rep = array();
	foreach($res_qcm as $txt){
		$texte_rep[] = $txt['texte_rep'];
	}
	return $texte_rep;
}
//Permet de savoir si la reponse a une question est la bonne ou pas
function bvalideReponse($id_quest, $numRep){
	require('./modele/connect.php');
	$sql_qcm ="SELECT bvalide from `reponse` where id_quest=:id_quest and id_rep=:id_rep";
	$id_rep = $numRep + (($id_quest-1)*4);
	$res_qcm = array();
	$cde_qcm = $pdo->prepare($sql_qcm);
	$cde_qcm->bindParam(':id_quest', $id_quest);
	$cde_qcm->bindParam(':id_rep', $id_rep);
	$b_qcm = $cde_qcm->execute();
	if ($b_qcm){
		$res_qcm = $cde_qcm->fetchAll(PDO::FETCH_ASSOC);
	}
	$nb = 0;
	foreach($res_qcm as $rep){
		$nb =  $rep['bvalide'];
	}
	return $nb;
}
//Permet de reconstruire la page qcm_live apres l'arret d'une question
function reconstructBD($id_test){
	require('./modele/connect.php');
	$sql_qcm ="SELECT num_grpe, titre_test from `test` where id_test=:id_test";
	$res_qcm = array();
	$cde_qcm = $pdo->prepare($sql_qcm);
	$cde_qcm->bindParam(':id_test', $id_test);
	$b_qcm = $cde_qcm->execute();
	if ($b_qcm){
		$res_qcm = $cde_qcm->fetchAll(PDO::FETCH_ASSOC);
	}
	foreach($res_qcm as $qcm){
		return $qcm;
	}
}
//Permet de savoir les questions bloquées et non-bloquées
function questValideBD($id_test){
	require('./modele/connect.php');
	$sql_qcm ="SELECT bBloque from `qcm` where id_test=:id_test";
	$res_qcm = array();
	$cde_qcm = $pdo->prepare($sql_qcm);
	$cde_qcm->bindParam(':id_test', $id_test);
	$b_qcm = $cde_qcm->execute();
	if ($b_qcm){
		$res_qcm = $cde_qcm->fetchAll(PDO::FETCH_ASSOC);
	}
	$_SESSION['qcm']['questValide'] = array();
	foreach($res_qcm as $qcm){
		$_SESSION['qcm']['questValide'][] = $qcm['bBloque'];
	}
}

function nbRepEtu($idTest, $numQuest, $numRep){
	require('./modele/connect.php');
	$sql_rep ="SELECT count(id_rep) as nbReponses from `resultat` where id_test=:id_test and id_quest=:id_quest and id_rep=:id_rep GROUP BY id_rep, id_quest";
	$id_rep = $numRep + (($numQuest-1)*4);
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $idTest);
	$cde_rep->bindParam(':id_quest', $numQuest);
	$cde_rep->bindParam(':id_rep', $id_rep);
	$b_rep = $cde_rep->execute();
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
	}
	$nbRep = 0;
	foreach($res_rep as $rep){
		$nbRep = $rep['nbReponses'];
	}
	return $nbRep;
}

function arreterQuestionBD($id_test, $id_quest){
	require('./modele/connect.php');
	$sql_rep ="UPDATE qcm set bBloque=1 where id_test=:id_test and id_quest=:id_quest";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $id_test);
	$cde_rep->bindParam(':id_quest', $id_quest);
	$b_rep = $cde_rep->execute();
}

function arreterTestBD($id_test){
	require('./modele/connect.php');
	$sql_rep ="UPDATE test set bTraite=1, bActif=0 where id_test=:id_test";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $id_test);
	$b_rep = $cde_rep->execute();
}

function bilanTestBD($id_test){
	require('./modele/connect.php');
	$sql_rep ="SELECT etudiant.id_etu, etudiant.nom, etudiant.prenom from `etudiant`, `test` where test.id_test=:id_test and etudiant.num_grpe=test.num_grpe";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $id_test);
	$b_rep = $cde_rep->execute();
	$etu = array();
	$etu[] = array();
	$_SESSION['bilan']['noteMax'] = pointsMaxBD($id_test);
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
	}
	foreach($res_rep as $etu){

	}
}

function etuTestBD($id_test){
	require('./modele/connect.php');
	$sql_rep ="SELECT etudiant.id_etu, etudiant.nom, etudiant.prenom from `etudiant`, `test` where test.id_test=:id_test and etudiant.num_grpe=test.num_grpe";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $id_test);
	$b_rep = $cde_rep->execute();
	$etu = array();
	$etu[] = array();
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
	}
	$cpt = 0;
	foreach($res_rep as $etudiant){
		$note = -1;
		$etu[$cpt]['id_etu'] = $etudiant['id_etu'];
		$etu[$cpt]['nom'] = $etudiant['nom'];
		$etu[$cpt]['prenom'] = $etudiant['prenom'];
		$note = noteEtuBD($id_test, $etudiant['id_etu']);
		$etu[$cpt]['note'] = $note;
		$cpt++;
	}
	return $etu;
}

function noteEtuBD($id_test, $id_etu){
	require('./modele/connect.php');
	$sql_rep ="SELECT note_test from `bilan` where bilan.id_test=:id_test and bilan.id_etu=:id_etu";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $id_test);
	$cde_rep->bindParam(':id_etu', $id_etu);
	$b_rep = $cde_rep->execute();
	$noteEtu = -1;
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
	}
	foreach($res_rep as $etu){
		$noteEtu = $etu['note_test'];
	}
	return $noteEtu;
}

function pointsMaxBD($id_test){
	require('./modele/connect.php');
	$sql_rep ="SELECT count(*) as nbPoints from `reponse`, `qcm` where qcm.id_test=:id_test and qcm.id_quest=reponse.id_quest and reponse.bValide=1";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $id_test);
	$b_rep = $cde_rep->execute();
	$noteMax = 0;
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
	}
	foreach($res_rep as $pts){
		$noteMax = $pts['nbPoints'];
	}
	return $noteMax;
}

function reponsesEtuTestBD($id_test, $id_etu, $id_quest){
	require('./modele/connect.php');
	$sql_rep ="SELECT id_rep from `resultat` where resultat.id_test=:id_test and resultat.id_etu=:id_etu and resultat.id_quest=:id_quest";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_test', $id_test);
	$cde_rep->bindParam(':id_etu', $id_etu);
	$cde_rep->bindParam(':id_quest', $id_quest);
	$b_rep = $cde_rep->execute();
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
	}
	$repQuest = array();
	foreach($res_rep as $rep){
		$repQuest[] = $rep['id_rep'];
	}
	return $repQuest;
}

function nbEtuCoBD($num_groupe){
	require('./modele/connect.php');
	$sql_rep ="SELECT count(*) as nbEtu from `etudiant` where num_grpe=:id_grpe and bConnect = 1";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_grpe', $num_groupe);
	$b_rep = $cde_rep->execute();
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
		if (count($res_rep) == 0)
			return 0;
		else {
			foreach($res_rep as $rep){
			return $rep['nbEtu'];
			}
		}
	}
}

function nbEtuTotalBD($num_groupe){
	require('./modele/connect.php');
	$sql_rep ="SELECT count(*) as nbEtu from `etudiant` where num_grpe=:id_grpe";
	$res_rep = array();
	$cde_rep = $pdo->prepare($sql_rep);
	$cde_rep->bindParam(':id_grpe', $num_groupe);
	$b_rep = $cde_rep->execute();
	if ($b_rep){
		$res_rep = $cde_rep->fetchAll(PDO::FETCH_ASSOC);
	}
	foreach($res_rep as $rep){
		return $rep['nbEtu'];
	}
}

function connectBD(){
	require ("modele/connect.php");
	
	if ($_SESSION['profil']['mode'] == "etudiant"){
		$sql_co = "UPDATE `etudiant` set bConnect = 1 where id_etu =:id_etu";
	}
	else{
		$sql_co = "UPDATE `professeur` set bConnect = 1 where id_prof =:id_prof";
	}
	try {
		$cde_co = $pdo->prepare($sql_co);
		if ($_SESSION['profil']['mode'] == "etudiant"){
			$cde_co->bindParam(':id_etu', $_SESSION['profil']['id_etu']);
		}
		else{
			$cde_co->bindParam(':id_prof', $_SESSION['profil']['id_prof']);
		}
		$b_co = $cde_co->execute();
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
}

function deconnectBD(){
	require ("modele/connect.php");
	
	if ($_SESSION['profil']['mode'] == "etudiant"){
		$sql_co = "UPDATE `etudiant` set bConnect = 0 where id_etu =:id_etu";
	}
	else{
		$sql_co = "UPDATE `professeur` set bConnect = 0 where id_prof =:id_prof";
	}
	try {
		$cde_co = $pdo->prepare($sql_co);
		if ($_SESSION['profil']['mode'] == "etudiant"){
			$cde_co->bindParam(':id_etu', $_SESSION['profil']['id_etu']);
		}
		else{
			$cde_co->bindParam(':id_prof', $_SESSION['profil']['id_prof']);
		}
		$b_co = $cde_co->execute();
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
}

function enregistrerResultatBD(){
	if(!empty($_POST)){
					
		require ("./modele/connect.php") ; 
		$id_test = $_SESSION['test']['id_test'];
		$date = date("Y-m-d");
		$id_etu = $_SESSION['profil']['id_etu'];

		for($i = 0; $i < count($_SESSION["question"]); $i++){
			if(isset($_POST["reponseSimple$i"])){
				
				$id_quest = $_SESSION["question"][$i]['id_quest'];
				$id_rep = $_POST['reponseSimple'.$i];
						
				$sql_insertRes = "INSERT INTO `resultat` (`id_res`, `id_test`, `id_etu`, `id_quest`, `date_res`, `id_rep`) VALUES (NULL, '$id_test', '$id_etu', '$id_quest', '$date', '$id_rep');";
				$req_insertRes = $pdo->prepare($sql_insertRes);
				$res = $req_insertRes->execute();
			}
		
			if(isset($_POST["reponseMultiple$i"])){
				foreach($_POST["reponseMultiple$i"] as $val){
				
					$id_quest = $_SESSION["question"][$i]['id_quest'];
					
					$sql_insertRes = "INSERT INTO `resultat` (`id_res`, `id_test`, `id_etu`, `id_quest`, `date_res`, `id_rep`) VALUES (NULL, '$id_test', '$id_etu', '$id_quest', '$date', '$val');";
					$req_insertRes = $pdo->prepare($sql_insertRes);
					$res = $req_insertRes->execute();					
				}
			}
		}
	}
}

function enregistrerBilanBD($note){

	if($note >= null){
		require ("./modele/connect.php") ; 
		
		$date = date("Y-m-d");
		$id_test = $_SESSION['test']['id_test'];
		$id_etu = $_SESSION['profil']['id_etu'];
		
		$sql_insertBilan = "INSERT INTO `bilan` (`id_bilan`, `id_test`, `id_etu`, `note_test`, `date_bilan`) VALUES (NULL, '$id_test', '$id_etu', '$note', '$date');";
		$req_insertBilan = $pdo->prepare($sql_insertBilan);
		$res = $req_insertBilan->execute();
	}
}

function liste_questionBaseD() {
	require ("./modele/connect.php");
	$sql_qt = "SELECT titre, id_theme, texte FROM `question`";
	$res_qt = array();
	$cde_qt = $pdo->prepare($sql_qt);
	$b_qt = $cde_qt->execute();
	if ($b_qt)
		$res_qt = $cde_qt->fetchAll(PDO::FETCH_ASSOC);
	$_SESSION['question'] = array();
	foreach ($res_qt as $qt){
		$_SESSION['question'][] = $qt;
	}
}

function liste_themeBaseD() {
	require ("./modele/connect.php");
	$sql_th = "SELECT titre_theme, id_theme  FROM `theme`";
	$res_th = array();
	$cde_th = $pdo->prepare($sql_th);
	$b_th = $cde_th->execute();
	if ($b_th)
		$res_th = $cde_th->fetchAll(PDO::FETCH_ASSOC);
	$_SESSION['theme'] = array();
	foreach ($res_th as $th){
		$_SESSION['theme'][] = $th;
	}
}

function newTestBd($grpe)
{
	require("./modele/connect.php");
	$nametest = $_POST['nomTest'];
	$id_prof = $_SESSION['profil']['id_prof'];
	$sql_insertNewTest = "INSERT INTO `test` (`id_test`, `id_prof`, `num_grpe`, `titre_test`, `bActif`) VALUES (NULL, '$id_prof', '$grpe', '$nametest',0);";
	$req_insertNewTest = $pdo->prepare($sql_insertNewTest);
	$res = $req_insertNewTest->execute();
	$b_test = $pdo->query('SELECT id_test FROM test ORDER BY 1 DESC LIMIT 0,1');
	while ($donnees = $b_test->fetch())
	{
		$valtest =  $donnees['id_test'];
	}
	$b_test->closeCursor();
	return $valtest;
}

function newQCMBd($val,$idTest){
	require("./modele/connect.php");
	$b_qt = $pdo->query("SELECT id_quest FROM `question` WHERE question.texte = '$val'");
	while ($donnees = $b_qt->fetch())
	{
		$valqt =  $donnees['id_quest'];
	}
	$b_qt->closeCursor();
	$sql_insertNewQcm = "INSERT INTO `qcm` (`id_qcm`, `id_test`, `id_quest`, `bAutorise`, `bBloque`, `bAnnule`) VALUES (NULL, '$idTest', '$valqt', 1 , 0 , 0);";
	$req_insertNewQcm = $pdo->prepare($sql_insertNewQcm);
	$res = $req_insertNewQcm->execute();

}

function newThBd(){
	require("./modele/connect.php");
	$nameTh = $_POST['nomTheme'];
	$nameDescTh = $_POST['descTheme'];
	$sql_insertNewTh = "INSERT INTO `theme` (`id_theme`, `titre_theme`, `desc_theme`) VALUES (NULL, '$nameTh', '$nameDescTh');";
	$req_insertNewTh = $pdo->prepare($sql_insertNewTh);
	$res = $req_insertNewTh->execute();

}

function creerQtBd($v, $ch) {
	require("./modele/connect.php");
	$titreQt = $_POST['titreQt'];
	$descQt = $_POST['descQt'];
	$b_th = $pdo->query("SELECT id_theme FROM theme WHERE theme.titre_theme = '$v'");
	while ($donnees = $b_th->fetch())
	{
		$valtest =  $donnees['id_theme'];
	}
	$b_th->closeCursor();

	if($ch == "choix1")
		$num = 1;
	else
		$num = 0;


	$sql_insertNewQt = "INSERT INTO `question` (`id_quest`, `id_theme`, `titre`, `texte`, `bmultiple`) VALUES (NULL, '$valtest', '$titreQt', '$descQt', $num);";
	$req_insertNewQt = $pdo->prepare($sql_insertNewQt);
	$res = $req_insertNewQt->execute();
}

function creerRepBd($rep,$rp){
	require("./modele/connect.php");
	$b_rep = $pdo->query("SELECT id_quest FROM question ORDER BY id_quest DESC LIMIT 0,1");
	while ($donnees = $b_rep->fetch())
	{
		$valqt =  $donnees['id_quest'];
	}
	$b_rep->closeCursor();
	$sql_insertNewRep = "INSERT INTO `reponse` (`id_rep`, `id_quest`, `texte_rep`, `bvalide`) VALUES (NULL, '$valqt', '$rep', '$rp');";
	$req_insertNewRep = $pdo->prepare($sql_insertNewRep);
	$res = $req_insertNewRep->execute();

}

?>
