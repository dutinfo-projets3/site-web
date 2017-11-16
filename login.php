<?php
	require_once("autoload.inc.php");

try {
	if (!Utilisateur::logoutIfRequested() && isset($_REQUEST['code']) && !empty($_REQUEST['code'])){
		$u = Utilisateur::createUserAuth($_REQUEST);
		$u->saveIntoSession();
		var_dump($u);

	} else {
		// Déconnecté, header
	}
} catch(AuthenticationException $e){
	// Mauvais utilisateur

} catch (Exception $e){
	// Autre erreur
}
