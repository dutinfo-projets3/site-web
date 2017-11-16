<?php

require_once('autoload.inc.php');

class Etudiant extends Utilisateur {

	private function __construct(){
		$this->type = Utilisateur::TYPES["ETUDIANT"];
	}
	
	/**
	 * Identifiant National Etudiant
	 */
	private $INE;

	/**
	 * Date d'entrée dans la formation
	 */
	private $dateEntree;

	/**
	 * Créé une instance d'étudiant à partir d'un utilisateur
	 * Il créé une copie de User dans une instance d'Etudiant
	 * Puis il va chercher les champs manquant dans la base de donnée
	 */
	public static function createFromUser($user){
		$etudiant = new Etudiant();

		$etudiant->setID($user->getID());
		$etudiant->setNom($user->getNom());
		$etudiant->setPrenom($user->getPrenom());
		$etudiant->setAdresse($user->getAdresse());
		$etudiant->setCP($user->getCP());
		$etudiant->setVille($user->getVille());
		$etudiant->setURL($user->getURL());

		$rq = "SELECT INE, dateEntree FROM Etudiant WHERE idEtudiant=?";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute(array($etudiant->getID()));

		$tab = $stmt->fetch();
		$etudiant->setINE($tab["INE"]);
		$etudiant->setDateEntree($tab["dateEntree"]);

		return $etudiant;
	}

	public function setINE($ine){
		$this->INE = $ine;
	}

	public function setDateEntree ($de){
		$this->dateEntree = $de;
	}

}
