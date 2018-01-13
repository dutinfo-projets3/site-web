<?php
/**
 * Created by Alexandre
 */

class Groupe {
	private $idGroupe;
	private $nom;
	private $idFormation;

	/**
	 * Getter pour idGroupe
	 * @return idGroupe
	 */
	public function getIdGroupe() {
		return $this->idGroupe;
	}

	/**
	 * Getter pour nomGroupe
	 * @return nomGroupe
	 */
	public function getNomGroupe() {
		return $this->nom;
	}

	/**
	 * Retourne un Groupe depuis son ID
	 * @param $idGroupe L'id du groupe voulu
	 * @throws GroupeException
	 * @return Groupe instance
	 *
	 */
	public static function createFromId($idGroupe) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Groupe
		WHERE idGroupe = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Groupe');
		$stmt->execute(array($idGroupe));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new GroupeException();
		} else {
			return $obj;
		}
	}

	public function getSeances() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Seance
		WHERE idGroupe = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Seance');
		$stmt->execute(array($this->idGroupe));
		$obj = $stmt->fetchAll();
		if ($obj == null) {
			throw new GroupeException();
		} else {
			return $obj;
		}
	}


	public static function getGroupeFromFormation($idFormation) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Groupe
		WHERE idFormation = ?;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute(array($idFormation));
		$groupe = $stmt->fetchAll();
		if($groupe == null){
			throw new GroupeException("Pas de groupe disponible pour cette formation");
		}
		return $groupe;
	}

	public function toArray() {
		return array("idGroupe" => $this->idGroupe, "nom" => $this->nom, "idFormation" => $this->idFormation);
	}

}

class GroupeException extends Exception {
	public function __construct($message = "Pas de groupe disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}