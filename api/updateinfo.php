<?php
require_once "../autoload.inc.php";

function checkParam($param){
	return isset($_GET[$param]) && !empty($_GET[$param]);
}
/**
 * Si l'utilisateur n'est pas connecté on lui envoie
 * 401 Unauthorized
 */
if (!Utilisateur::isConnected()){
	http_response_code(401);
	return;
}

$util = Utilisateur::createFromSession();

/**
 * Si l'utilisateur tente de se modifier lui même OU que l'utilisateur est un secrétaire
 */
if (checkParam('id') && ($util->getID() == $_GET["id"] || $util->getUserType() == Utilisateur::TYPES["ADMINISTRATION"])){
	/**
	 * Si l'utilisateur à bien entré tous les champs
	 */
	if (checkParam('nom') && checkParam('prenom') && checkParam('adresse') && checkParam('cp') && checkParam('ville') && checkParam('numero') && checkParam('email')){

	$utilisateur = ($util->getID() == $_GET["id"]) ? $util : Utilisateur::createFromID($_GET["id"]);

	$utilisateur->setNom($_GET["nom"])
		    ->setPrenom($_GET["prenom"])
		    ->setAdresse($_GET["adresse"])
		    ->setCP($_GET["cp"])
		    ->setVille($_GET["ville"])
		    ->setNumeroTel($_GET["numero"])
		    ->setMail($_GET["email"]);

	if ($utilisateur instanceof Etudiant) {
		if (checkParam("INE"))
			$utilisateur->setINE($_GET["INE"]);
		if (checkParam("dateEntree"))
			$utilisateur->setDateEntree($_GET["dateEntree"]);
	}

	if ($utilisateur instanceof Secretaire || $utilisateur instanceof Professeur){
		if (checkParam("dateEmbauche"))
			$utilisateur->setDateEmbauche($_GET["dateEmbauche"]);
		if (checkParam("dateDepart"))
			$utilisateur->setDateDepart($_GET["dateDepart"]);
	}

	$utilisateur->updateBD(isset($_GET["mdp"]) ? $_GET["mdp"] : null);

	} else {
		/**
		 * Si il manque un champ, la requête n'est pas entière, on ne fait rien et on envoie
		 * 400 Bad Request
		 */
		http_response_code(400);
		return;
	}
} else {
	http_response_code(401);
	return;
}
