<?php

class Secretaire extends Utilisateur {

	/**
	 * Date d'embauche de la personne
	 */
	private $dateEmbauche;

	/**
	 * Date où la personne à quitté l'école
	 */
	private $dateDepart;

	/**
	 * Créé une instance de secrétaire depuis un utilisateur
	 */
	public function __construct($user){
		parent::__construct($user);
		$this->type = Utilisateur::TYPES["ADMINISTRATION"];
	}
	
	/**
	 * Créé une instance de secrétaire à partir d'un utilisateur
	 * Il créé une copie de User dans une instance de secrétaire
	 * Puis il va chercher les champs manquant dans la base de donnée
	 */
	public static function createFromUser($user){
		$secretaire = new Secretaire($user);

		$rq = "SELECT * FROM Secretaire WHERE idSecretaire=?";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute(array($secretaire->getID()));

		$tab = $stmt->fetch();
		$secretaire->setDateEmbauche($tab["dateEmbauche"]);
		$secretaire->setDateDepart($tab["dateDepart"]);

		return $secretaire;
	}


	public function setDateEmbauche($date){
		$this->dateEmbauche = $date;
	}

	public function setDateDepart($date){
		$this->dateDepart = $date;
	}

}
