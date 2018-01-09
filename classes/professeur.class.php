<?php

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

	public function __construct($user){
		parent::__construct($user);
		$this->type = Utilisateur::TYPES["PROFESSEUR"];
	}

	/**
	 * Créé une instance de professeur à partir des infos
	 */
	public static function createFromInfo($nom, $prenom, $adresse, $cp, $ville, $mail, $numtel, $dateEmbauche = null, $dateDepart = null){
		// Hack dégueux pour avoir le même prototype que dans User et ne pas avoir de warning
		if ($dateEmbauche != null){
			$user = parent::createFromInfo($nom, $prenom, $adresse, $cp, $ville, $mail, $numtel);
			$prof = (new Professeur($user))->setDateEmbauche($dateEmbauche);

			if ($dateDepart != null){
				$prof->setDateDepart($dateDepart);
			}

			return $prof;
		}
	}

	/**
	 * Créé une instance de professeur à partir d'un utilisateur
	 * Il créé une copie de User dans une instance de Professeur
	 * Puis il va chercher les champs manquant dans la base de donnée
	 */
	public static function createFromUser($user){
		$prof = new Professeur($user);

		$rq = "SELECT * FROM Professeur WHERE idProfesseur=?";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute(array($prof->getID()));

		$tab = $stmt->fetch();
		$prof->dateEmbauche = $tab["dateEmbauche"];
		$prof->dateDepart   = $tab["dateDepart"];
		return $prof;
	}

	/**
	 * Ajoute un nouvel utilisateur dans la BD
	 * @return Utilisateur avec son id mis à jour
	 */
	public function insertIntoBD($pass){
		$id = parent::insertIntoBD($pass);

		$rq = "INSERT INTO Professeur (idProfesseur, dateEmbauche, dateDepart) VALUES (:id, :emb, :dpt)";
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
		$rq = "UPDATE Professeur SET dateEmbauche=:dateEmbauche, dateDepart=:dateDepart WHERE idProfesseur=:id";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->execute(array(
			"dateEmbauche" => $this->getDateEmbauche(),
			"dateDepart" => $this->getDateDepart(),
			"id" => $this->getID()
		));
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

	 public function getSeances(){
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM seance
            WHERE idProfesseur = ?
SQL
);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Seance');
        $stmt->execute(array($this->idPersonne));
        $seances = $stmt->fetchAll();
        return $seances;
    }

}
