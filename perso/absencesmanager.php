<?php

require_once("../autoload.inc.php");

try {
	$user = Utilisateur::createFromSession();
}catch (Exception $e){

	header('Location: /');
}

if($user->getType()==0){
	header('Location: /');
}

$params = array();
$params['usertype']=$user->getType();
$params["displayPanelButton"] = false;

echo TwigLoader::getInstance()->render('','perso/absencesmanager',$params);