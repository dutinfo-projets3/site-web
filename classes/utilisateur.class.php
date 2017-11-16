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
	    $res = "";
        if(self::isConnected()){
            //Affichage du nom et bouton de déconnexion

        }else{
            //formulaire de connexion
            //générer un challenge
            $challenge = self::randomString(20);
            $_SESSION[self::SESSION_KEY]['challenge'] = $challenge;
            $urlActuelUser = $_SERVER['php_self'].$_SERVER['query_string'];
            $res = <<<HTML
            <form action="/login.php" method="POST" onsubmit="hash()">
                 <div class="form-group">
                    <label for="nomUtilisateur">Nom utilisateur</label>
                    <input type="text" name="user" class="form-control" id="nomUtilisateur" aria-describedby="idHelp" placeholder="Nom utilisateur">
                    <small id="idHelp" class="form-text text-muted">Ne jamais divulguer cette identifiant</small>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                  </div>
                  <input hidden name="url" value="{$urlActuelUser}"
                  <input hidden name="code" value="">
                   <button type="submit" class="btn btn-primary">Connexion</button>
            </form>
            <script src="/assets/js/sha256.js"></script>
            <script>
                function hash() {
                    //sha(sha(password).challenge.sha(user))
                  var code = sha256(sha256(document.getElementsByName('password')) + {$challenge} + sha256(document.getElementsByName('user')));
                  document.getElementsByName('code')[0].value = code;
                  document.getElementsByName('password')[0].value = "";
                  document.getElementsByName('user')[0].value = "";
                }
            </script>
HTML;

return $res;
        }

	}

    /**
     * Génère une chaine aléatoire de caractère en fonction de la taille passé en paramètre
     * @param $size
     * @return string
     */

    public static function randomString($size)
    {
        $res = "";
        for ($i = 0; $i < $size; $i++) {
            $choose = rand(1, 3);
            switch ($choose) {
                case 1 :
                    $res .= chr(rand((ord("a")), (ord("z"))));
                    break;
                case 2 :
                    $res .= chr(rand((ord("A")), (ord("Z"))));
                    break;
                case 3 :
                    $res .= chr(rand((ord("0")), (ord("9"))));
                    break;
                default :
            }
        }
        return $res;
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
	 * @throws AuthenticationException
	 */
	public static function createUserAuth(array $data){
		Session::start();
		$rq = "SELECT * FROM PERSONNE WHERE SHA2(CONCAT(MOTDEPASSE, ?, SHA2(NOMUTILISATEUR, '256')), '256') = ?;";

		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->setFetchMode(PDO::FETCH_CLASS, "Utilisateur");
		$stmt->execute(array($_SESSION[self::SESSION_KEY]['challenge'], $data['code']));

		$obj = $stmt->fetch();
		if ($obj == null){
			throw new AuthenticationException();
		} else {
			$_SESSION[self::SESSION_KEY] = array("connected" => true);
		}
	}

}

class AuthenticationException extends Exception{
	
	public function __construct($code = 0, Exception $previous = null){ 
		parent::__construct("Aucun utilisateur avec ce couple pseudo/mdp", $code, $previous);
	}

}
