<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once("autoload.inc.php");


echo TwigLoader::getInstance()->render('progetude','programme', array());
