<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once("autoload.inc.php");

	$loader = new \Twig_Loader_Filesystem(__DIR__ . '/twigs');
	$twig   = new \Twig_Environment($loader);


	$loginForm = "";

	if (Utilisateur::isConnected()){
		$u = Utilisateur::createFromSession();
		$loginForm = $u->createLogoutForm();
	} else {
		$loginForm = Utilisateur::createLoginForm();
	}

	echo $twig->render('index.html.twig', array('form' => $loginForm));

