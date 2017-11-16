<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	require_once("autoload.inc.php");

	Session::start();
	$_SESSION["__user__"]["challenge"] = "LOL";

	var_dump($_SESSION);

	User::createUserAuth(array("code"=> 
		hash("SHA256", 
			hash("SHA256", "nathan") . "test". hash("SHA256", "janc0000")
		)));

	var_dump($_SESSION);

