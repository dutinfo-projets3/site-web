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

	/**
	 * Créé une instance de professeur à partir d'un utilisateur
	 * Il créé une copie de User dans une instance de Professeur
	 * Puis il va chercher les champs manquant dans la base de donnée
	 */
	public static function createFromUser($user){
		$prof = new Professeur($user);

		$rq = "SELECT * FROM Etudiant WHERE idProfesseur=?";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute(array($prof->getID()));

		$tab = $stmt->fetch();
		$prof->setDateEmbauche($tab["dateEmbauche"]);
		$prof->setDateDepart($tab["dateDepart"]);
		return $prof;
	}

}
