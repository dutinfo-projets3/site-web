<?php
require_once "../autoload.inc.php";

function checkParam($param){
	return isset($_POST[$param]) && !empty($_POST[$param]);
}
/**
 * Si l'utilisateur n'est pas connecté on lui envoie
 * 401 Unauthorized
 */
if (!Utilisateur::isConnected()){
	http_response_code(401);
	return;
}

/**
 * Si l'utilisateur à bien entré tous les champs
 */
if (checkParam('nom') && checkParam('prenom') && checkParam('adresse') && checkParam('cp') && checkParam('ville') && checkParam('numero') && checkParam('email')){

	$rq = "UPDATE Utilisateur SET nomPers=:nom, prenomPers=:prenom, adresse=:adresse, ville=:ville, codePostal=:cp, mail=:mail, numerotel=:numtel";
	$values = array('nom'     => $_POST['nom'], 
			'prenom'  => $_POST['prenom'],
			'adresse' => $_POST['adresse'],
			'ville'   => $_POST['ville'],
			'cp'      => $_POST['cp'],
			'mail'    => $_POST['mail'],
			'numtel'  => $_POST['numero']
		);

	/**
	 * On regarde si il souhaite changer son mot de passe aussi
	 */
	if (checkParam('pwd')){
		$rq .= ", motDePasse=SHA2(:mdp, 256)";
		$values['mdp'] = $_POST['pwd'];
	}

	$rq .= " FROM Utilisateur WHERE idPersonne=:id";
	$stmt = myPDO::getInstance()->prepare($rq);
	$stmt->execute($values);

} else {
	/**
	 * Si il manque un champ, la requête n'est pas entière, on ne fait rien et on envoie
	 * 400 Bad Request
	 */
	http_response_code(400);
	return;
}
