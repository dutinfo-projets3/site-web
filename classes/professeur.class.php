<?php

require_once('autoload.inc.php');

class Professeur extends Utilisateur {

	/**
	 * Date d'embauche du professeur
	 */
	private $dateEmbauche;

	/**
	 * Date de départ du professeur
	 * NULL si il est toujours dans l'établissement
	 */
	private $dateDepart;

}
