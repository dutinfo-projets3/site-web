<?php
/**
 * Created by Alexandre
 */

class Formation{
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
	public static function createFromID($idFormation){
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
	
}

class FormationException extends Exception {
	public function __construct($message = "Pas de formation disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}