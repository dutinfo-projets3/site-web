<?php
	require_once("vendor/autoload.php");

	spl_autoload_register(function ($class) {
		// Très important, sinon les classes ne se chargent pas dans un sous dossier.
		echo "Trying to load " . $class . " from " . $_SERVER['DOCUMENT_ROOT'] . '/classes/' . strtolower($class) . '.class.php';
		include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . strtolower($class) . '.class.php';
	});
