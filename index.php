<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once("autoload.inc.php");

	$loader = new \Twig_Loader_Filesystem(__DIR__ . '/twigs');
	$twig   = new \Twig_Environment($loader);
<<<<<<< HEAD
    $loginForm = Utilisateur::createLoginFrom();
	echo $twig->render('index.html.twig', array('loginForm' => $loginForm));
=======

	echo $twig->render('index.html.twig');
>>>>>>> b5d37f784d2f48afe2d851a0c9f97cca9092a1d0
