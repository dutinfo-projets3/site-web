<?php
/**
 * Created by Alexandre
 */

class Matiere {
	private $idMatiere;
	private $idFormation;
	private $nomMatiere;
	private $coef;

	/**
	 * Getter pour idMatiere
	 * @return idMatiere
	 */
	public function getIdMatiere() {
		return $this->idMatiere;
	}

	/**
	 * Getter pour la formation
	 * @return Instance formation
	 */
	public function getFormation() {
		return Formation::createFromID($this->idFormation);
	}

	/**
	 * Getter pour nomMatiere
	 * @return nomMatiere
	 */
	public function getNomMatiere() {
		return $this->nomMatiere;
	}

	/**
	 * Getter pour coeff
	 * @return coeff
	 */
	public function getCoeff() {
		return $this->coef;
	}

	/**
	 * Retourne un Matiere depuis son ID
	 * @param $idMatiere L'id de la matiere voulue
	 * @throws MatiereException
	 * @return Matiere instance
	 *
	 */
	public static function createFromID($idMatiere) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Matiere
		WHERE idMatiere = ?;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Matiere');
		$stmt->execute(array($idMatiere));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new MatiereException();
		} else {
			return $obj;
		}
	}

	/**
	 * renvoie les matieres en fonction de l'ID de la formation passé en paramètre
	 */
	public static function getMatiereFromFormation($idFormation) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Matiere
		WHERE idFormation = ?;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute(array($idFormation));
		$arrayMatieres = $stmt->fetchAll();
		if ($arrayMatieres != null) {
			return $arrayMatieres;
		}
		throw new MatiereException();


	}

	/**
	 * Permet de tansformer un objet en array
	 * @return array
	 */
	public function toArray() {
		return array("idMatiere" => $this->idMatiere, "idFormation" => $this->idFormation, "nomMatiere" => $this->nomMatiere, "coeff" => $this->coeff);
	}

	/**
	 * Permet ajouter une matiere et de retourner l'id de la matiere qui vient être inséré
	 * @param $nomFormation
	 * @return le dernier id de la formation
	 */
	public static function addMatiere($nomMatiere, $idFormation) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		INSERT INTO Matiere (nomMatiere, idFormation) VALUE (?, ?);
SQL
		);
		if ($stmt->execute(array($nomMatiere, $idFormation))) {
			return myPDO::getInstance()->lastInsertId();
		}
		throw new MatiereException("Impossible inserer une nouvelle matiere");
	}

	/**
	 * suppression de la matiere en fonction de son id
	 * @param $idMatiere
	 * @throws MatiereException
	 */
	public static function removeMatiere($idMatiere) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		DELETE FROM Matiere
		WHERE idMatiere = ?;
SQL
		);
		if (!$stmt->execute(array($idMatiere))) {
			throw new MatiereException();
		}
	}
}


class MatiereException extends Exception {
	public function __construct($message = "Pas de matiere disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
