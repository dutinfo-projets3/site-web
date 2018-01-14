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
}