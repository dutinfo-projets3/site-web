<?php

	require_once("vendor/autoload.php");

	spl_autoload_register(function ($class) {
		include 'classes/' . strtolower($class) . '.class.php';
	});
