<?php

class Seance {

	private $idSeance;
	private $idSalle;
	private $idMatiere;
	private $idGroupe;
	private $idProfesseur;
	private $dateDebut;
	private $dateFin;

	/**
	 * Retourne une news depuis son ID
	 * @param $idNews L'id de la news voulue
	 * @throws NewsException
	 * @return News instance
	 *
	 * @TODO Test
	 *
	 */
	public static function createFromID($idNews) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM News
		WHERE idNews = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, '');
		$stmt->execute(array($idNews));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new NewsException();
		} else {
			return $obj;
		}
	}

	/**
	 * Getter pour l'ID de la séance
	 * @return idSeance
	 */
	public function getId(){
		return $this->idSeance;
	}

	/**
	 * Setter pour l'id de la séance
	 * @return l'objet courant
	 */
	public function setId($id){
		$this->idSeance = $id;
		return $this;
	}

	/**
	 * Getter pour l'ID de la salle
	 * @return idSalle
	 */
	public function getSalle(){
		return $this->idSalle;
	}

	/**
	 * Setter pour l'id de la salle
	 * @return l'objet courant
	 */
	public function setSalle($id){
		$this->idSalle = $id;
		return $this;
	}

}
