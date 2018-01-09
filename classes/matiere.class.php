<?php
/**
 * Created by Alexandre
 */

class Matiere{
    private $idMatiere;
    private $idFormation;
    private $nomMatiere;
    private $coeff;

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
    public function getFormation(){
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
        return $this->coeff;
    }

    /**
	 * Retourne un Matiere depuis son ID
	 * @param $idMatiere L'id de la matiere voulue
	 * @throws MatiereException
	 * @return Matiere instance
	 *
     */
	public static function createFromID($idMatiere){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Matiere
		WHERE idMatiere = ?
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
	
}

class MatiereException extends Exception {
	public function __construct($message = "Pas de matiere disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}