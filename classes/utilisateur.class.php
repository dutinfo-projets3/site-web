<?php

class Utilisateur
{

    public const TYPES = array("ETUDIANT" => 0, "PROFESSEUR" => 1, "ADMINISTRATION" => 2);
    public static $SESSION_KEY = "__user__";

    /**
     * Constructeur par copie de Utilisateur
     * Utilisé par Etudiant / Professeur / Administration
     * @param $user Utilisateur à copier
     */
    public function __construct($user = null)
    {
        if ($user != null) {
            $this->idPersonne = $user->getID();
            $this->nomPers = $user->getNom();
            $this->prenomPers = $user->getPrenom();
            $this->adresse = $user->getAdresse();
            $this->codePostal = $user->getCP();
            $this->ville = $user->getVille();
            $this->urlImage = $user->getURL();
            $this->nomUtilisateur = $user->getUsername();
            $this->type = $user->getUserType();
        }
    }

    /**
     * ID de l'utilisateur
     */
    protected $idPersonne;

    /**
     * Informations privées de l'utilisateur
     */
    protected $nomPers;
    protected $prenomPers;
    protected $adresse;
    protected $codePostal;
    protected $ville;
    protected $nomUtilisateur;

    /**
     * Image de l'utilisateur
     */
    protected $urlImage;

    /**
     * Type de l'utilisateur
     * 0: Etudiant
     * 1: Professeur
     * 2: Administration
     */
    protected $type;

    /**
     * Renvoie le formulaire de connection de l'utilisateur, avec un challenge
     */
    public static function createLoginForm($err = null)
    {
        //formulaire de connexion
        //générer un challenge
        $challenge = self::randomString(20);
        $_SESSION[self::$SESSION_KEY]['challenge'] = $challenge;
        $urlActuelUser = $_SERVER['PHP_SELF'] . $_SERVER['QUERY_STRING'];
        $val = <<<HTML
			<form action="login.php" class="form m-2" method="POST" onsubmit="hash()">
<div class="row bg-danger text-center" style="margin-bottom: 10px; display: block;">
HTML;
        if ($err != null) {
            switch ($err) {
                case "badpass":
                    $val .= "Mauvais mot de passe!";
                    break;
                case "other":
                    $val .= "Erreur serveur!";
                    break;
            }
        }

        return $val . <<<HTML
</div>
<div class="row p-lg-0 p-5">
				<div class="form-group col-sm-12 col-lg-9 m-0  pl-lg-2 pr-lg-2 p-0">
					<input type="text" name="user" class="form-control form-control-sm" id="nomUtilisateur" aria-describedby="idHelp" placeholder="Nom d'Utilisateur">
					<input type="password" name="password"  class="form-control form-control-sm mt-2" id="password" placeholder="Mot de passe">
					<a href="" class="small col-sm-12 text-muted p-0 d-lg-none"> Mot de passe oublié ? </a>
				</div>
				
				<input hidden name="url" value="{$urlActuelUser}">
				<input hidden name="code">
				<button type="submit" class="btn btn-primary col-lg-2 col-12  mt-lg-0 mt-1">&rarr;</button>
</div>
				<div class="row d-none d-lg-block">
					<a href="" class="small col-sm-12 text-muted"> Mot de passe oublié ? </a>
				</div>

			</form>
		<script src="assets/js/sha256.js"></script>
		<script>
			function hash() {
				//sha(sha(password).challenge.sha(user))
				code = sha256(sha256(
				document.getElementsByName('password')[0].value) + "{$challenge}" + sha256(document.getElementsByName('user')[0].value));
				document.getElementsByName('code')[0].value = code;
				document.getElementsByName('password')[0].value = "";
				document.getElementsByName('user')[0].value = "";
			}
		</script>
HTML;
    }


    /**
     * Créé le formulaire de déconnexion (Affiche aussi le nom d'utilisateurs et les infos importantes)
     */
    public function createLogoutForm(bool $displayPanelButton)
    {
        $val = <<< HTML
    <div class="row p-lg-0">
		<div class="row col-12 m-0 d-flex justify-content-center">
			<span>Bienvenue, $this->prenomPers $this->nomPers</span>
		</div>
		<div class="row col-12 m-0 pt-2 pb-2 pr-5 pl-5 p-lg-0 mt-lg-2 mb-lg-1">
HTML;
        if ($displayPanelButton) {
            $val .= '<a class="btn btn-primary col-lg-5 col-5 " href="/perso">
                        <div class="row pr-2 pl-2">
                            <i data-feather="grid" class="col-12 col-lg-2 p-0"></i>
                            <span class="col-10 d-none d-lg-inline p-0">Scolarité</span>
                        </div>
                    </a>';
            $val .= '<a class="btn btn-danger col-lg-6 offset-2 offset-lg-1 col-5" href="/login.php?logout=true">
                        <div class="row pr-2 pl-2">
                            <i data-feather="log-out" class="col-12 p-0 col-lg-2"></i>
                            <span class="col-10 d-none d-lg-inline p-0">Déconnexion</span>
                        </div>
                    </a>';
        } else {
            $val .= '<a class="btn btn-danger  col-12 col-lg-6 offset-lg-3" href="/login.php?logout=true">
                        <div class="row pr-2 pl-2">
                            <i data-feather="log-out" class="col-2 p-0"></i>
                            <span class="col-10 p-0">Déconnexion</span>
                        </div>
                    </a>';
        }
        $val .= <<< HTML
		</div>
    </div>
HTML;
        return $val;
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
    public static function isConnected()
    {
        $res = false;
        Session::start();
        if (isset($_SESSION[self::$SESSION_KEY]) && !empty($_SESSION[self::$SESSION_KEY]) &&
            isset($_SESSION[self::$SESSION_KEY]['connected']) && !empty($_SESSION[self::$SESSION_KEY]['connected'])) {
            $res = $_SESSION[self::$SESSION_KEY]['connected'] == true; // Car si connected != boolean ça doit pas mettre n'import quoi
        }
        return $res;
    }

    /**
     * Connecte l'utilisateur et stock les informations dans la session.
     * @throws AuthenticationException
     */
    public static function createUserAuth(array $data)
    {
        Session::start();
        $rq = "SELECT * FROM Utilisateur WHERE SHA2(CONCAT(MOTDEPASSE, ?, SHA2(NOMUTILISATEUR, '256')), '256') = ?;";

        $stmt = myPDO::getInstance()->prepare($rq);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Utilisateur");
        $stmt->execute(array($_SESSION[self::$SESSION_KEY]['challenge'], $data['code']));

        $obj = $stmt->fetch();
        if ($obj == null) {
            throw new AuthenticationException();
        } else {
            $_SESSION[self::$SESSION_KEY] = array("connected" => true);

            switch ($obj->type) {
                case self::TYPES["ETUDIANT"]:
                    $obj = Etudiant::createFromUser($obj);
                    break;
                case self::TYPES["PROFESSEUR"]:
                    $obj = Professeur::createFromUser($obj);
                    break;
                case self::TYPES["ADMINISTRATION"]:
                    $obj = Secretaire::createFromUser($obj);
                    break;
                default:
                    var_dump("SOMETHING WENT WRNG");
                    $obj = null;
            }

        }
        return $obj;
    }

    /**
     * Créé une instance d'Etudiant, Professeur ou Secretaire en fonction de la présence dans la SESSION
     * @throws NotInSessionException si personne n'est connecté.
     */
    public static function createFromSession()
    {
        Session::start();

        if (isset($_SESSION[self::$SESSION_KEY]) && !empty($_SESSION[self::$SESSION_KEY])) {
            return $_SESSION[self::$SESSION_KEY]["user"];
        } else {
            throw new NotInSessionException();
        }
    }


    /**
     * Sauvegarde les données de l'utilisateur dans la session actuelle
     */
    public function saveIntoSession()
    {
        if (self::isConnected()) {
            $_SESSION[self::$SESSION_KEY] = array("connected" => true, "user" => $this);
            return true;
        }
        return false;
    }

    /**
     * Déconnecte l'utilisateur si le champ logout est passé dans la requête
     */
    public static function logoutIfRequested()
    {
        if (isset($_REQUEST['logout']) && !empty($_REQUEST['logout']) && self::isConnected()) {
            $_SESSION[self::$SESSION_KEY]["connected"] = false;
            $_SESSION[self::$SESSION_KEY]["user"] = NULL;
            $_SESSION[self::$SESSION_KEY] = NULL;
            return true;
        }
        return false;
    }

    /***
     * Getters & Setters
     **/

    public function getID()
    {
        return $this->idPersonne;
    }

    public function setID($id)
    {
        $this->idPersonne = $id;
    }

    public function getNom()
    {
        return $this->nomPers;
    }

    public function setNom($nom)
    {
        $this->nomPers = $nom;
    }

    public function getPrenom()
    {
        return $this->prenomPers;
    }

    public function setPrenom($nom)
    {
        $this->prenomPers = $nom;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adr)
    {
        $this->adresse = $adr;
    }

    public function getCP()
    {
        return $this->codePostal;
    }

    public function setCP($cp)
    {
        $this->codePostal = $cp;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($v)
    {
        $this->ville = $v;
    }

    public function getURL()
    {
        return $this->urlImage;
    }

    public function setURL($u)
    {
        $this->urlImage = $u;
    }

    public function getUsername()
    {
        return $this->nomUtilisateur;
    }

    public function setUsername($u)
    {
        $this->nomUtilisateur = $u;
    }

    public function getUserType()
    {
        return $this->type;
    }

}

class AuthenticationException extends Exception
{

    public function __construct($code = 0, Exception $previous = null)
    {
        parent::__construct("Aucun utilisateur avec ce couple pseudo/mdp", $code, $previous);
    }

}

class NotInSessionException extends Exception
{

    public function __construct($code = 0, Exception $prev = null)
    {
        parent::__construct("Trying to access a saved user which is not in the SESSION", $code, $prev);
    }

}

