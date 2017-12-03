<?php

require_once ("../autoload.inc.php");

//$user = Etudiant::createFromID(16)->setINE("Iner")->setVille("Toulouse")->updateBD();
$user = Professeur::createFromID(28)->setDateDepart("2017-12-22")->updateBD();
