<?php
/**
 * Created by Alexandre
 */

class Salle {
	private $idSalle;
	private $numero;
	private $batiment;

	/**
	 * Getter pour idSalle
	 * @return idSalle
	 */
	public function getIdSalle() {
		return $this->idSalle;
	}

	/**
	 * Getter pour duree
	 * @return duree
	 */
	public function getFormatedSalle() {
		return $this->batiment . $this->numero;
	}

	public function getBatiment(){
		return $this->batiment;
	}

	public function getNumero(){
		return $this->numero;
	}


	/**
	 * Retourne une Salle depuis son ID
	 * @param $idSalle L'id de la salle voulue
	 * @throws SalleException
	 * @return Salle instance
	 *
	 */
	public static function createFromID($idSalle) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Salle
		WHERE idSalle = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Salle');
		$stmt->execute(array($idSalle));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new SalleException();
		} else {
			return $obj;
		}
	}

	public static function getSalle() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Salle
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__);
		$stmt->execute();
		return $stmt->fetchAll();
	}

}

class SalleException extends Exception {
	public function __construct($message = "Pas de salle disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
