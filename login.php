<?php
	require_once("autoload.inc.php");

$err = null;

try {
	$logout = Utilisateur::logoutIfRequested();
	if (!$logout && isset($_REQUEST['code']) && !empty($_REQUEST['code'])){
		$u = Utilisateur::createUserAuth($_REQUEST);
		$u->saveIntoSession();
	} 
} catch(AuthenticationException $e){
		// Mauvais utilisateur
		$err = "badpass";
} catch (Exception $e){
		// Autre erreur
		$err = "other";
		var_dump($e);
}
$location = "/index.php";

if ($err != null){
	$location .= "?err=" . $err;
}

header('Location: ' . $location);
