<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	require_once("vendor/autoload.php");

	spl_autoload_register(function ($class) {
		include 'classes/' . strtolower($class) . '.class.php';
	});
