<?php
/**
 * Created by Alexandre
 */

class Formation {
	private $idFormation;
	private $nomFormation;
	private $duree;

	/**
	 * Getter pour idFormation
	 * @return idFormation
	 */
	public function getIdFormation() {
		return $this->idFormation;
	}

	/**
	 * Getter pour nomFormation
	 * @return nomFormation
	 */
	public function getNomFormation() {
		return $this->nomFormation;
	}

	/**
	 * Getter pour duree
	 * @return duree
	 */
	public function getDuree() {
		return $this->duree;
	}

	/**
	 * Retourne une Formation depuis son ID
	 * @param $idFormation L'id de la formation voulue
	 * @throws FormationException
	 * @return Formation instance
	 *
	 */
	public static function createFromID($idFormation) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Formation
		WHERE idFormation = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Formation');
		$stmt->execute(array($idFormation));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new FormationException();
		} else {
			return $obj;
		}
	}

	/**
	 * Renvoie toute les formation disponible
	 * @return tableau de formation
	 *
	 */
	public static function getFormations() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Formation;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		return $arrayFormation = $stmt->fetchAll();

	}

	/**
	 * Permet ajouter une formation et de retourner l'id de la formation qui vient être inséré
	 * @param $nomFormation
	 * @return le dernier id de la formation
	 */
	public static function addFormation($nomFormation){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		INSERT INTO Formation (nomFormation) VALUE (?);
SQL
		);

		if($stmt->execute(array($nomFormation))){
			return myPDO::getInstance()->lastInsertId();
		}
		throw new FormationException();

	}

}

class FormationException extends Exception {
	public function __construct($message = "Pas de formation disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}