<?php
	require_once("autoload.inc.php");

try {
	$logout = Utilisateur::logoutIfRequested();
	if (!$logout && isset($_REQUEST['code']) && !empty($_REQUEST['code'])){
		$u = Utilisateur::createUserAuth($_REQUEST);
		$u->saveIntoSession();
		header('Location: /');
	} else if ($logout){
		// Déconnecté, header
		var_dump("déconnecté");
	}
} catch(AuthenticationException $e){
		// Mauvais utilisateur
		var_dump("bad user");

} catch (Exception $e){
		// Autre erreur
		var_dump("lol");
}
