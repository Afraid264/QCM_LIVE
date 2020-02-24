<?php 
/*controleur c1.php :
  fonctions-action de gestion (c1)
*/

function ident() {
	$nom=  isset($_POST['nom'])?($_POST['nom']):'';
	$num=  isset($_POST['num'])?($_POST['num']):'';
	$test= isset($_POST['test'])?($_POST['test']):'';
	$mode = isset($_POST['mode'])?($_POST['mode']):'';
	$msg='';
	$acces = false;
	$profil = array();
	if  (count($_POST)==0)
              require ("./vue/utilisateur/ident.tpl") ;
    else {
		if ($mode == "Etudiant")
			$acces = verif_ident_etu($nom,$num, $profil, $test);
		else
			$acces = verif_ident_prof($nom, $num, $profil);
	    if  (!$acces) {
			$_SESSION['profil']=array();
			$msg ="Utilisateur inconnu";
	        require ("./vue/utilisateur/ident.tpl") ;
		}
	    else {
			$_SESSION['profil']= $profil;
			if ($mode == 'Etudiant'){
				$url = "index.php?controle=utilisateur&action=accueil_etu";
			}
			else {
				$url = "index.php?controle=utilisateur&action=accueil_prof";
			}
			header ("Location:" .$url) ;
		}
    }	
}

function verif_ident_etu($nom,$num, &$profil, &$test){
	require ('./modele/utilisateurBD.php');
	return verif_ident_ETUBD($nom,$num,$profil, $test);
}

function verif_ident_prof($nom,$num,&$profil) {
	require ('./modele/utilisateurBD.php');
	return verif_ident_PROFBD($nom,$num,$profil);
}


function accueil_etu() {
	connect();
	$nom = $_SESSION['profil']['nom'];
	$prenom =$_SESSION['profil']['prenom'];
	$id = $_SESSION['profil']['id_etu'];
	$group=$_SESSION['profil']['num_grpe'];
	$test = $_SESSION['test'];
	$test_done=test_done($_SESSION['profil']['id_etu']);
	require ("./vue/utilisateur/accueil.tpl");
}

function accueil_prof() {
	connect();
	liste_groupes();
	$nb_test = liste_tests();
	$nom = $_SESSION['profil']['nom'];
	$prenom = $_SESSION['profil']['prenom'];
	$id = $_SESSION['profil']['id_prof'];
	$groupes = $_SESSION['groupes'];
	$tests = $_SESSION['tests'];
	require_once ("./vue/utilisateur/accueil_prof.tpl");
}

function retourProf(){
	liste_groupes();
	$nb_test = liste_tests();
	$nom = $_SESSION['profil']['nom'];
	$prenom = $_SESSION['profil']['prenom'];
	$id = $_SESSION['profil']['id_prof'];
	$groupes = $_SESSION['groupes'];
	$tests = $_SESSION['tests'];
	require_once ("./vue/utilisateur/accueil_prof.tpl");
}

function retourAccueilProf(){
	accueil_prof();
}

function lancerTest(){
	$id = $_SESSION['profil']['id_prof'];
	$infos_test = explode("|", $_POST['tests']);
	require ('./modele/utilisateurBD.php');
	$id_test = lancerTestBD(trim($infos_test[0]), trim($infos_test[1]), $id);
	qcm_live($id_test, trim($infos_test[1]), trim($infos_test[0]));
}

function qcm_live($id_test, $num_groupe, $titre){
	$cpt = questions_test($id_test);
	$quest_titre = $_SESSION['qcm']['texte'];
	$texte_rep = $_SESSION['qcm']['texte_rep'];
	$num = $num_groupe;
	$_SESSION['qcm']['num_groupe'] = $num;
	$idQuestions = $_SESSION['qcm']['idQuest'];
	$idTest = $id_test;
	$nomTest = $titre;
	$_SESSION['qcm']['titre'] = $nomTest;
	$repValide = $_SESSION['qcm']['bValide'];
	$etuCo = nbEtuCo($num);
	$etuTot = nbEtuTotal($num);
	questValide($id_test);
	$questValide = $_SESSION['qcm']['questValide'];
	require('./vue/utilisateur/qcm_live.tpl');
}

function arreterQuestion(){
	$infos_test = explode("|", $_POST['question']);
	require('./modele/utilisateurBD.php');
	arreterQuestionBD(trim($infos_test[0]), trim($infos_test[1]));
	$testReconstruit = reconstruct(trim($infos_test[0]));
	$id_test = trim($infos_test[0]);
	$titre = $testReconstruit['titre_test'];
	$num_grpe = $testReconstruit['num_grpe'];
	qcm_live($id_test, $num_grpe, $titre);
}

function reconstruct($id_test){
	return reconstructBD($id_test);
}

function questValide($id_test){
	questValideBD($id_test);
}

function arreterTest(){
	$infos_test = $_POST['infoTest'];
	require ('./modele/utilisateurBD.php');
	arreterTestBD($infos_test);
	bilanTest($infos_test);
}

function bilanTest($id_test){
	$idTest = $id_test;
	$etuTest = etuTest($id_test);
	$noteMax = pointsMax($id_test);
	$infos_test = infos_test($id_test);
	$nomTest = $infos_test['titre_test'];
	$num = $infos_test['num_grpe'];
	require('./vue/utilisateur/bilan_prof.tpl');
}
function infos_test($id_test){
	return infos_testBD($id_test);
}

function retourBilanProf(){
	require('./modele/utilisateurBD.php');
	$id_test = $_SESSION['qcm']['id_test'][0];
	bilanTest($id_test);
}

function voirReponses(){
	$infos = explode("|",$_POST['reponses']);
	$idTest = $infos[0];
	$id_etu = $infos[1];
	$nom_etu = $infos[2];
	$prenom_etu = $infos[3];
	$note = $infos[4];
	$nomTest = $infos[5];
	$groupe = $infos[6];
	require('./modele/utilisateurBD.php');
	$cpt = questions_test($idTest);
	$quest_titre = $_SESSION['qcm']['texte'];
	$texte_rep = $_SESSION['qcm']['texte_rep'];
	$idQuestions = $_SESSION['qcm']['idQuest'];
	$repValide = $_SESSION['qcm']['bValide'];
	$aRepondu = array();
	for($i = 0; $i <$cpt*4; $i++){
		$aRepondu[$i] = 0;
	}
	$nb = 0;
	$repEtu = array();
	foreach($idQuestions as $id_quest){
		$repEtu = reponsesEtuTest($idTest, $id_etu, $id_quest);
		foreach($repEtu as $aRep){
			$index = ($nb*4) + (($aRep-1)%4);
			$aRepondu[$index] = 1;
		}
		$nb++;
	}
	require('./vue/utilisateur/reponseEtu.tpl');
}

function etuTest($id_test){
	return etuTestBD($id_test);
}

function pointsMax($id_test){
	return pointsMaxBD($id_test);
}

function reponsesEtuTest($id_test, $id_etu, $id_quest){
	return reponsesEtuTestBD($id_test, $id_etu, $id_quest);
}

function nbEtuCo($num_groupe){
	return nbEtuCoBD($num_groupe);
}

function nbEtuTotal($num_groupe){
	return nbEtuTotalBD($num_groupe);
}
function questions_test($id_test){
	return questions_testBD($id_test);
}

function liste_groupes() {
	liste_groupesBD();
}
function liste_tests(){
	$id = $_SESSION['profil']['id_prof'];
	return liste_testsBD($id);
}
function creerTest(){
	if(!empty($_POST['groupes'])){
		foreach($_POST['groupes'] as $selected){
			echo $selected."</br>";
		}
	}
}

function enregistrerResultat() {
	require_once('./modele/utilisateurBD.php');
	enregistrerResultatBD();
}
function enregistrerBilan($note) {
	require_once('./modele/utilisateurBD.php');
	enregistrerBilanBD($note);
}
function test_done($id_etu){
	foreach($_SESSION['bilan'] as $bilan) {
	if($bilan['id_etu']==$id_etu && $bilan['id_test']==$_SESSION['test']['id_test']){ 
			return true;
		}
	}
	return false;
}

function connect(){
	require ('./modele/utilisateurBD.php');
	connectBD();
}
function deconnect(){
	require ('./modele/utilisateurBD.php');
	deconnectBD();
	header('location: ./index.php');
}

function liste_question() {
	require ('./modele/utilisateurBD.php');
	liste_questionBaseD();
}

function liste_theme() {
	liste_themeBaseD();
}

function enregistrerNewTest($grpe){
	return newTestBd($grpe);

}

function enregistrerNewQCM($val,$idTest){
    newQCMBd($val,$idTest);
}

function enregistrerNewTh(){
    require ('./modele/utilisateurBD.php');
    newThBd();
}

function recupgroup() {
    require ('./modele/utilisateurBD.php');
    $grpe = null;
if (isset ($_POST["grpe"])) {
    foreach ($_POST["grpe"] as $key => $value) {
        $grpe = $value;
        $idTest = enregistrerNewTest($grpe);
        if (isset ($_POST["qts"])) {
            foreach ($_POST["qts"] as $key => $value) {
                $val = $value;
                enregistrerNewQCM($val , $idTest);
            }
        }

        }
    }
}


function creerQuestion(){
    require ('./modele/utilisateurBD.php');
    if (isset ($_POST["th"])) {
        foreach ($_POST["th"] as $key => $value) {
            $v = $value;
            if (isset ($_POST["choix"])) {
                    $ch = $_POST["choix"];
                    creerQtBd($v, $ch);
            }
        }
    }
}

function creerReponse(){

    $rep = $_POST['Rep1'];
    if (isset ($_POST["rep1"]))
        $rp = 1;
    else
        $rp = 0;
    creerRepBd($rep,$rp);
    $rep = $_POST['Rep2'];
    if (isset ($_POST["rep2"]))
        $rp = 1;
    else
        $rp = 0;
    creerRepBd($rep,$rp);
    $rep = $_POST['Rep3'];
    if (isset ($_POST["rep3"]))
        $rp = 1;
    else
        $rp = 0;
    creerRepBd($rep,$rp);
    $rep = $_POST['Rep4'];
    if (isset ($_POST["rep4"]))
        $rp = 1;
    else
        $rp = 0;
    creerRepBd($rep,$rp);
}

function creationTest() {
    liste_question();
    liste_theme();
    $id = $_SESSION['profil']['id_prof'];
	$nom = $_SESSION['profil']['nom'];
	$prenom = $_SESSION['profil']['prenom'];
	$nb_test = liste_tests();
	require('./vue/utilisateur/creerTest.tpl');
}

function creerNewTest () {
    recupgroup();
    $id = $_SESSION['profil']['id_prof'];
    $nom = $_SESSION['profil']['nom'];
    $prenom = $_SESSION['profil']['prenom'];
    $nb_test = liste_tests();
    retourProf();
}

function creationquestion(){
    require ('./modele/utilisateurBD.php');
    liste_theme();
    $id = $_SESSION['profil']['id_prof'];
    $nom = $_SESSION['profil']['nom'];
    $prenom = $_SESSION['profil']['prenom'];
    $nb_test = liste_tests();
    require ('./vue/utilisateur/creerQuestion.tpl');
}

function creerNewQuestion() {
    creerQuestion();
    creerReponse();
    $id = $_SESSION['profil']['id_prof'];
    $nom = $_SESSION['profil']['nom'];
    $prenom = $_SESSION['profil']['prenom'];
    $nb_test = liste_tests();
    retourProf();
}

function creationTheme(){
    $id = $_SESSION['profil']['id_prof'];
    $nom = $_SESSION['profil']['nom'];
    $prenom = $_SESSION['profil']['prenom'];
    require ('./modele/utilisateurBD.php');
    $nb_test = liste_tests();
    require ('./vue/utilisateur/creerTheme.tpl');
}

function creerNewTheme(){
    enregistrerNewTh();
    $id = $_SESSION['profil']['id_prof'];
    $nom = $_SESSION['profil']['nom'];
    $prenom = $_SESSION['profil']['prenom'];
    $nb_test = liste_tests();
    retourProf();
}
?>
