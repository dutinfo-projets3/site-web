<?php
require_once('autoload.inc.php');

use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase {

	protected function setUp() {
		/**
		 *
		 *    Inserts à effectuer dans la base de données!
		 *    INSERT INTO Utilisateur (type, nomUtilisateur, nomPers, prenomPers, motDePasse, adresse, ville, codePostal, urlImage)
		 * VALUES (-1, 'test', 'testNom', 'testPrenom', 'f4f263e439cf40925e6a412387a9472a6773c2580212a4fb50d224d3a817de17', '123 grande rue', 'New York', '12345', 'http');
		 */
	}

	/**
	 * Test des utilisateurs standard
	 */

	public function authUserFromDB_works() {
		$_SESSION[Utilisateur::$SESSION_KEY] = array();
		$_SESSION[Utilisateur::$SESSION_KEY]["challenge"] = "challenge_test";

		// Test avecv l'utilisateur test:mdp pour le challenge challenge_test
		$util = Utilisateur::createFromAuth(array("code" => "d2630a8faf7f1a3a389edab5faaf77e595b9e5ad5bf3e49964ed7ddc0fe9ceec"));

		$this->assertInstanceOf(Utilisateur::class, $util);
	}

	public function authUserFromDB_badpass() {

	}

	/**
	 * Test des étudiants
	 */

	/**
	 * Test des professeurs
	 */

	/**
	 * Test de l'administration
	 */
}
