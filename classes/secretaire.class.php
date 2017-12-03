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
	 * Créé une instance de secretaire à partir des infos
	 */
	public static function createFromInfo($nom, $prenom, $adresse, $cp, $ville, $mail, $numtel, $dateEmbauche = null, $dateDepart = null){
		// Hack dégueux pour avoir le même prototype que dans User et ne pas avoir de warning
		if ($dateEmbauche != null){
			$user = parent::createFromInfo($nom, $prenom, $adresse, $cp, $ville, $mail, $numtel);
			$secr = (new Secretaire($user))->setDateEmbauche($dateEmbauche);

			if ($dateDepart != null){
				$secr->setDateDepart($dateDepart);
			}

			return $secr;
		}
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

	/**
	 * Ajoute un nouvel utilisateur dans la BD
	 * @return Utilisateur avec son id mis à jour
	 */
	public function insertIntoBD($pass){
		$id = parent::insertIntoBD($pass);

		$rq = "INSERT INTO Secretaire (idSecretaire, dateEmbauche, dateDepart) VALUES (:id, :emb, :dpt)";
		$stmt = myPDO::getInstance()->prepare($rq);

		$stmt->execute(array(
			"id"         => $id,
			"emb"        => $this->getDateEmbauche(),
			"dpt"        => $this->getDateDepart()
		));

		return $id;
	}

	/**
	 * Met a jour l'utilisateur dans la base de donnée
	 * Change son mot de passe s'il est spécifié en paramètre
	 */
	public function updateBD($mdp = null){
		parent::updateBD($mdp);
		$rq = "UPDATE Secretaire SET dateEmbauche=:dateEmbauche, dateDepart=:dateDepart WHERE idSecretaire=:id";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->execute(array(
			"dateEmbauche" => $this->getDateEmbauche(),
			"dateDepart" => $this->getDateDepart(),
			"id" => $this->getID()
		));
	}

	/**
	 * Créé une secretaire à partir de son id
	 */
	public static function createFromID($id){
		return Secretaire::createFromUser(Utilisateur::createFromID($id));
	}

	public function getDateEmbauche(){
		return $this->dateEmbauche;
	}

	public function getDateDepart(){
		return $this->dateDepart;
	}

	public function setDateEmbauche($date){
		$this->dateEmbauche = $date;
		return $this;
	}

	public function setDateDepart($date){
		$this->dateDepart = $date;
		return $this;
	}

}
