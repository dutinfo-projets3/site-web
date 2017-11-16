<?php

class Utilisateur {

	public const TYPES = array("ETUDIANT" => 0, "PROFESSEUR" => 1, "ADMINISTRATION" => 2);
	public const SESSION_KEY = "__user__";

	/**
	 * ID de l'utilisateur
	 */
	private $idPersonne;

	/**
	 * Informations privées de l'utilisateur
	 */
	private $nomPers;
	private $prenom;
	private $adresse;
	private $codePostal;
	private $ville;

	/**
	 * Image de l'utilisateur
	 */
	private $urlImage;

	/**
	 * Type de l'utilisateur
	 * 0: Etudiant
	 * 1: Professeur
	 * 2: Administration
	 */
	private $type;

	/**
	 * Renvoie le formulaire de connection de l'utilisateur, avec un challenge
	 */
	public static function createLoginFrom(){


	}

    /**
     * Renvoie true si l'utilisateur est connecté et inversement
     * @return bool
     */
	public static function isConnected(){
	    $res = false;
        Session::start();
        if(!empty($_SESSION[self::SESSION_KEY]) && isset($_SESSION_KEY) &&(!empty($_SESSION[self::SESSION_KEY]['connected']) && isset($_SESSION[self::SESSION_KEY]['connected']))){
            if($_SESSION[self::SESSION_KEY]['connected'] == true){
                $res = true;
            }
        }
        return $res;
    }

	/**
	 * Connecte l'utilisateur et stock les informations dans la session.
	 */
	public function createUserAuth(){
	}

}

