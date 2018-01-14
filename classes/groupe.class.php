<?php
/**
 * Created by Alexandre
 */

class Groupe{
	private $idGroupe;
	private $nomGroupe;

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
		return $this->nomGroupe;
	}

	/**
	 * Retourne un Groupe depuis son ID
	 * @param $idGroupe L'id du groupe voulu
	 * @throws GroupeException
	 * @return Groupe instance
	 *
	 */
	public static function createFromId($idGroupe){
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

	public function getSeances(){
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

	public static function getGroupes(){
	    $stmt = myPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM groupe
SQL
        );
	    $stmt->execute();
	    $obj = $stmt->fetchAll();
	    return $obj;
    }
	
}

class GroupeException extends Exception {
	public function __construct($message = "Pas de groupe disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}