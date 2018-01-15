<?php

class Absence {

	public static function putIntoBD($idEtud,$idSeance){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO absence (idEtudiant, idSeance)
			VALUE (?,?)
SQL
);
		$stmt -> execute(array($idEtud,$idSeance));
	}

	public static function isAbsent($idEtud,$idSeance){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM Absence
			WHERE idEtudiant = ?
			AND idSeance = ?
SQL
);
		$stmt->execute(array($idEtud,$idSeance));
		return $stmt->fetchAll() != array();
	}

	public static function getAbsentSeance($idSeance){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT idEtudiant
			FROM Absence
			WHERE idSeance = ?
SQL
);		
	}
	$stmt-> execute(array($idSeance));
}