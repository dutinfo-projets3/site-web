<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once("vendor/autoload.php");

	$loader = new \Twig_Loader_Filesystem(__DIR__ . '/twigs');
	$twig   = new \Twig_Environment($loader);

	echo $twig->render('index.html.twig');
