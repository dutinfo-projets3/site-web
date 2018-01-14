<?php
/**
 * Created by Alexandre
 */

class Seance {
	private $idSeance;
	private $idSalle;
	private $idGroupe;
	private $idProfesseur;
	private $idMatiere;
	private $dateDebut;
	private $dateFin;
	private $notes;

	/**
	 * Getter pour idSeance
	 * @return idSeance
	 */
	public function getIdSeance() {
		return $this->idSeance;
	}

	/**
	 * Getter pour la salle
	 * @return Instance salle
	 */
	public function getSalle() {
		return Salle::createFromId($this->idSalle);
	}

	/**
	 * Getter pour la groupe
	 * @return Instance groupe
	 */
	public function getGroupe() {
		return Groupe::createFromId($this->idGroupe);
	}

	/**
	 * Getter pour la matiere
	 * @return Instance matiere
	 */
	public function getMatiere() {
		return Matiere::createFromId($this->idMatiere);
	}

	/**
	 * Getter pour la professeur
	 * @return Instance professeur
	 */
	public function getProfesseur() {
		return Professeur::createFromId($this->idProfesseur);
	}

	/**
	 * Getter pour dateDebut
	 * @return dateDebut
	 */
	public function getDateDebut() {
		return $this->dateDebut;
	}

	/**
	 * Getter pour dateFin
	 * @return dateFin
	 */
	public function getDateFin() {
		return $this->dateFin;
	}

	/**
	 * Getter pour notes
	 * @return notes
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * Retourne un Seance depuis son ID
	 * @param $idSeance L'id de la seance voulue
	 * @throws SeanceException
	 * @return Seance instance
	 *
	 */
	public static function createFromId($idSeance) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Seance
		WHERE idSeance = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Seance');
		$stmt->execute(array($idSeance));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new SeanceException();
		} else {
			return $obj;
		}
	}

	public static function getSeances() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Seance
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__);
		$stmt->execute();
		$seances = $stmt->fetchAll();
		if($seances != null){
			return $seances;
		}
		throw new SeancException("Pas seance disponible");
	}

	public static function addSeance($idSalle, $idMatiere, $idGroupe, $idProfesseur, $dateDebut, $dateFin) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		INSERT INTO Seance (idSalle, idMatiere, idGroupe, idProfesseur, dateDebut, dateFin) VALUE (?,?,?,?,?,?)
SQL
		);
		if ($stmt->execute(array($idSalle, $idMatiere, $idGroupe, $idProfesseur, $dateDebut, $dateFin))) {
			return myPDO::getInstance()->lastInsertId();
		};
		throw new SeancException("Erreur");

	}

	/**
	* CF doc getEleves dans la classe groupe
	*/
	public function getEleves(){
		return Groupe::createFromId($this->idGroupe)->getEleves();
	}
}

class SeancException extends Exception {
	public function __construct($message = "Pas de Seance disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}