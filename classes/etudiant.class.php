<?php

class Etudiant extends Utilisateur {

	/**
	 * Identifiant National Etudiant
	 */
	private $INE;

	/**
	 * Date d'entrée dans la formation
	 */
	private $dateEntree;

	/**
	 * Créé une instance d'Etudiant depuis un utilisateur
	 */
	public function __construct($user){
		parent::__construct($user);
		$this->type = Utilisateur::TYPES["ETUDIANT"];
	}

	/**
	 * Créé une instance d'Etudiant à partir des infos
	 */
	public static function createFromInfo($nom, $prenom, $adresse, $cp, $ville, $mail, $numtel, $INE = null, $dateEntree = null){
		// Hack dégueux pour avoir le même prototype que dans User et ne pas avoir de warning
		if ($INE != null && $dateEntree != null){
			$user = parent::createFromInfo($nom, $prenom, $adresse, $cp, $ville, $mail, $numtel);
			return (new Etudiant($user))->setINE($INE)->setDateEntree($dateEntree);
		}
	}

	
	/**
	 * Créé une instance d'étudiant à partir d'un utilisateur
	 * Il créé une copie de User dans une instance d'Etudiant
	 * Puis il va chercher les champs manquant dans la base de donnée
	 */
	public static function createFromUser($user){
		$etudiant = new Etudiant($user);

		$rq = "SELECT * FROM Etudiant WHERE idEtudiant=?";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute(array($etudiant->getID()));

		$tab = $stmt->fetch();
		if (isset($tab["INE"]) && !empty($tab["INE"]))
			$etudiant->setINE($tab["INE"]);

		if (isset($tab["dateEntree"]) && !empty($tab["dateEntree"]))
			$etudiant->setDateEntree($tab["dateEntree"]);

		return $etudiant;
	}

	/**
	 * Ajoute un nouvel utilisateur dans la BD
	 * @return Utilisateur avec son id mis à jour
	 */
	public function insertIntoBD($pass){
		$id = parent::insertIntoBD($pass);

		$rq = "INSERT INTO Etudiant (idEtudiant, INE, dateEntree) VALUES (:id, :ine, :dateentree)";
		$stmt = myPDO::getInstance()->prepare($rq);

		$stmt->execute(array(
			"id"         => $id,
			"ine"        => $this->getINE(),
			"dateentree" => $this->getDateEntree()
		));

		return $id;
	}

	/**
	 * Met a jour l'utilisateur dans la base de donnée
	 * Change son mot de passe s'il est spécifié en paramètre
	 */
	public function updateBD($mdp = null){
		parent::updateBD($mdp);
		$rq = "UPDATE Etudiant SET INE=:ine, dateEntree=:dateEntree WHERE idEtudiant=:id";
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->execute(array(
			"ine" => $this->getINE(),
			"dateEntree" => $this->getDateEntree(),
			"id" => $this->getID()
		));
	}

	public function setINE($ine){
		$this->INE = $ine;
		return $this;
	}

	public function setDateEntree ($de){
		$this->dateEntree = $de;
		return $this;
	}

	public function getINE(){
		return $this->INE;
	}

	public function getDateEntree(){
		return $this->dateEntree;
	}

	public function getGroupes(){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT idGroupe FROM Appartient
		WHERE idEtudiant = ?
SQL
		);
		$stmt->execute(array($this->idPersonne));
		$obj = $stmt->fetchAll();
		$res = array();
		foreach($obj as $val){
			$res[] = Groupe::createFromId($val['idGroupe']);
		}
		return $res;
	}

	public function getSeances(){
		$groupes = $this->getGroupes();
		$seances = array();
		foreach($groupes as $g){
			$seances[] = $g->getSeances();
		}
		var_dump($seances);
	}
}
