<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once("autoload.inc.php");

	$loader = new \Twig_Loader_Filesystem(__DIR__ . '/twigs');
	$twig   = new \Twig_Environment($loader);
<<<<<<< HEAD

    $loginForm = Utilisateur::createLoginFrom();



	echo ($twig->render('index.html.twig'));
=======

	$loginForm = "";

	if (Utilisateur::isConnected()){
		$loginForm = Utilisateur::createLogoutForm();
	} else {
		$loginForm = Utilisateur::createLoginForm();
	}

	echo $twig->render('index.html.twig', array('form' => $loginForm));
>>>>>>> 02982ff36f81885b7fcb267a1097e7edcb4f6083
