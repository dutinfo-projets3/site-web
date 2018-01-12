<?php

class Note {

	private $idNote;
	private $idMatiere;
	private $idPersonne;
	private $valeur;
	private $coeff;

	public function getValeur(){
		return $this->valeur;
	}

	public function getCoeff(){
		return $this->coeff;
	}

	public static function createFomID($id){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Note
		WHERE idNote = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Note');
		$stmt->execute(array($id));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new NoteException();
		} else {
			return $obj;
		}

	}

	public static function buildArray($user, $formation, $annee){
		$mats = Matiere::getMatiereFromFormation($formation);
		$matieres = array();
		foreach($mats as $currMat){
			$currMatArr = array($currMat->getCoeff());
			$notes = array();

			$notesInstance = Note::createFromUserMatYear($user, $currMat->getIdMatiere(), $annee->getId());

			foreach($notesInstance as $nte){
				array_push($notes, array($nte->getValeur(), $nte->getCoeff()));
			}

			if (count($notes) > 0){
				array_push($currMatArr, $notes);
				$matName = $currMat->getNomMatiere();
				$matieres[$matName] = $currMatArr;
			}
		}
		
		return $matieres;
	}

	public static function createFromUserMatYear($user, $mat, $year){
		$rq = <<<SQL
			SELECT * FROM Notes WHERE idAnneeScolaire = ? AND idPersonne = ? AND idMatiere = ?
SQL
		;
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_CLASS, "Note");

		$stmt->execute(array($year, $user, $mat));
		return $stmt->fetchAll();
	}

	public static function createFromUser($user, $matiere){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM Notes WHERE idPersonne = ? AND idMatiere = ?
SQL
);
		$stmt->setFetchMode(PDO::FETCH_CLASS, "Note");
		$stmt->execute(array($user, $matiere));
		return $stmt->fetchAll();
	}

}


class NoteException extends Exception{
	public function __construct($message = "Pas de note disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
