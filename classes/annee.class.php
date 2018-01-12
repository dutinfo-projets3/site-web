<?php

// Micmac "AnneeScolaire" / "InscriptionEleve" dans la BD

class Annee {

	private $idAnnee;
	private $idFormation;
	private $annee;
	private $anneeForma;

	public static function createFromUserYear($user, $formation, $year){
		$rq =<<<SQL
		SELECT * FROM AnneeScolaire WHERE idFormation = ? AND annee = ?
SQL
;
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Annee');
		$stmt->execute(array($formation, $year));
		$ann = $stmt->fetch();
		if ($ann == null)
			throw new Exception("Année non trouvée!");
		return $ann;
	}

	public static function createFromUser($user, $formation){
		$rq =<<<SQL
		SELECT * FROM AnneeScolaire where idAnnee = (
			SELECT idAnnee FROM InscriptionEleve WHERE idEtudiant = ?
		) AND idFormation = ?
SQL
;
		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Annee');
		$stmt->execute(array($user, $formation));
		return $stmt->fetchAll();
	}

	public function getId(){
		return $this->idAnnee;
	}

	public function getAnnee(){
		return $this->annee;
	}
}
