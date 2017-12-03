<?php

class Utilisateur {

	public const TYPES = array("ETUDIANT" => 0, "PROFESSEUR" => 1, "ADMINISTRATION" => 2);
	public static $SESSION_KEY = "__user__";

	/**
	 * Constructeur par copie de Utilisateur
	 * Utilisé par Etudiant / Professeur / Administration
	 * @param $user Utilisateur à copier
	 */
	public function __construct($user = null) {
		if ($user != null) {
			$this->idPersonne = $user->getID();
			$this->nomPers = $user->getNom();
			$this->prenomPers = $user->getPrenom();
			$this->adresse = $user->getAdresse();
			$this->codePostal = $user->getCP();
			$this->ville = $user->getVille();
			$this->urlImage = $user->getURL();
			$this->nomUtilisateur = $user->getUsername();
			$this->mail = $user->getMail();
			$this->numerotel = $user->getNumerotel();
			$this->type = $user->getUserType();
		}
	}

	public static function createFromInfo($nom, $prenom, $adresse, $cp, $ville, $mail, $numtel){
		return (new Utilisateur())->setNom($nom)->setPrenom($prenom)->setAdresse($adresse)->setCP($cp)->setVille($ville)->setMail($mail)->setNumeroTel($numtel);
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
	protected $mail;
	protected $numerotel;

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
	public static function createLoginForm($err = null) {
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
					$val .= "__home.form.badPass__";
					break;
				case "other":
					$val .= "__home.form.serverError__";
					break;
			}
		}

		return $val . <<<HTML
</div>
<div class="row p-lg-0 p-5">
				<div class="form-group col-sm-12 col-lg-9 m-0  pl-lg-2 pr-lg-2 p-0">
					<input type="text" name="user" class="form-control form-control-sm" id="nomUtilisateur" aria-describedby="idHelp" placeholder="__home.form.userName__">
					<input type="password" name="password"  class="form-control form-control-sm mt-2" id="password" placeholder="__home.form.password__">
					<a href="" class="small col-sm-12 text-muted p-0 d-lg-none"> __home.forgottenPassword__</a>
				</div>
				
				<input hidden name="url" value="{$urlActuelUser}">
				<input hidden name="code">
				<button type="submit" class="btn btn-primary col-lg-2 col-12  mt-lg-0 mt-1">&rarr;</button>
</div>
				<div class="row d-none d-lg-block">
					<a href="" class="small col-sm-12 text-muted"> __home.forgottenPassword__ </a>
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
	public function createLogoutForm(bool $displayPanelButton) {
		$val = <<< HTML
    <div class="row p-lg-0">
		<div class="row col-12 m-0 d-flex justify-content-center">
			<span>__home.text.welcome__ $this->prenomPers $this->nomPers</span>
		</div>
		<div class="row col-12 m-0 pt-2 pb-2 pr-5 pl-5 p-lg-0 mt-lg-2 mb-lg-1">
HTML;
		if ($displayPanelButton) {
			$val .= '<a class="btn btn-primary col-lg-5 col-5 " href="/perso">
                        <div class="row pr-2 pl-2">
                            <i data-feather="grid" class="col-12 col-lg-2 p-0"></i>
                            <span class="col-10 d-none d-lg-inline p-0">__home.button.education__</span>
                        </div>
                    </a>';
			$val .= '<a class="btn btn-danger col-lg-6 offset-2 offset-lg-1 col-5" href="/login.php?logout=true">
                        <div class="row pr-2 pl-2">
                            <i data-feather="log-out" class="col-12 p-0 col-lg-2"></i>
                            <span class="col-10 d-none d-lg-inline p-0">__home.button.disconnect__</span>
                        </div>
                    </a>';
		} else {
			$val .= '<a class="btn btn-danger  col-12 col-lg-6 offset-lg-3" href="/login.php?logout=true">
                        <div class="row pr-2 pl-2">
                            <i data-feather="log-out" class="col-2 p-0"></i>
                            <span class="col-10 p-0">__home.button.disconnect__</span>
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
	public static function randomString($size) {
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
	public static function isConnected() {
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
	public static function createUserAuth(array $data) {
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
			$obj = Utilisateur::createUserKind($obj);
		}
		return $obj;
	}

	/**
	 * Renvoie une instance d'Etudiant si l'utilistateur est un étudiant, de prof si l'util est un prof, etc...
	 */
	private static function createUserKind($user) {
		$obj = null;
		switch ($user->type) {
			case self::TYPES["ETUDIANT"]:
				$obj = Etudiant::createFromUser($user);
				break;
			case self::TYPES["PROFESSEUR"]:
				$obj = Professeur::createFromUser($user);
				break;
			case self::TYPES["ADMINISTRATION"]:
				$obj = Secretaire::createFromUser($user);
				break;
			default:
				var_dump("SOMETHING WENT WRNG");
		}
		return $obj;
	}

	/**
	 * Créé une instance d'Etudiant, Professeur ou Secretaire en fonction de la présence dans la SESSION
	 * @throws NotInSessionException si personne n'est connecté.
	 */
	public static function createFromSession() {
		Session::start();

		if (isset($_SESSION[self::$SESSION_KEY]) && !empty($_SESSION[self::$SESSION_KEY])) {
			return $_SESSION[self::$SESSION_KEY]["user"];
		} else {
			throw new NotInSessionException();
		}
	}

	/**
	 * Créé une instance de l'utilisateur en fonction de l'ID proposé
	 * @throws InvalidArgumentException si l'utilisateur n'existe pas
	 */
	public static function createFromID($id) {
		$rq = "SELECT * FROM Utilisateur WHERE idPersonne=:id;";
		$stmt = myPDO::getInstance()->prepare($rq);

		$stmt->bindValue(":id", $id);

		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');

		$res = null;
		if ($stmt->execute())
			$res = $stmt->fetch();
		return $res;
	}

	/**
	 * Ajoute un nouvel utilisateur dans la BD
	 * @return Utilisateur avec son id mis à jour
	 */
	public function insertIntoBD($mdp){
		$rq = "INSERT INTO Utilisateur (idPersonne, type, nomUtilisateur, nomPers, prenomPers, motDePasse, adresse, ville, codePostal, mail, numerotel) VALUES (null, :type, null, :nom, :prenom, SHA2(:mdp, 256), :adresse, :ville, :cp, :mail, :numerotel)";
		$stmt = myPDO::getInstance()->prepare($rq);

		$stmt->execute(array(
			"type"      => $this->getUserType(),
			"nom"       => $this->getNom(),
			"prenom"    => $this->getPrenom(),
			"mdp"       => $mdp,
			"adresse"   => $this->getAdresse(),
			"ville"     => $this->getVille(),
			"cp"        => $this->getCP(),
			"mail"      => $this->getMail(),
			"numerotel" => $this->getNumerotel()
		));

		return myPDO::getInstance()->lastInsertId();
	}

	/**
	 * Met a jour l'utilisateur dans la base de donnée
	 * Change son mot de passe s'il est spécifié en paramètre
	 */
	public function updateBD($mdp = null){
		$rq = "UPDATE Utilisateur SET nomPers=:nom, prenomPers=:prenom, adresse=:adr, ville=:ville, codePostal=:cp, mail=:mail, numerotel=:numtel";
		$values = array(
			"id"        => $this->getID(),
			"nom"       => $this->getNom(),
			"prenom"    => $this->getPrenom(),
			"adr"       => $this->getAdresse(),
			"ville"     => $this->getVille(),
			"cp"        => $this->getCP(),
			"mail"      => $this->getMail(),
			"numtel"    => $this->getNumerotel()
		);
		if ($mdp != null) {
			$rq .= ", motDePasse=SHA2(:mdp, 256)";
			$values["mdp"] = $mdp;
		}

		$rq .= " WHERE idPersonne=:id";

		$stmt = myPDO::getInstance()->prepare($rq);
		$stmt->execute($values);

	}

	/**
	 * Sauvegarde les données de l'utilisateur dans la session actuelle
	 */
	public function saveIntoSession() {
		if (self::isConnected()) {
			$_SESSION[self::$SESSION_KEY] = array("connected" => true, "user" => $this);
			return true;
		}
		return false;
	}

	/**
	 * Déconnecte l'utilisateur si le champ logout est passé dans la requête
	 */
	public static function logoutIfRequested() {
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

	public function getID() {
		return $this->idPersonne;
	}

	public function setID($id) {
		$this->idPersonne = $id;
		return $this;
	}

	public function setType($type){
		$this->type = $type;
		return $this;
	}

	public function getNom() {
		return $this->nomPers;
	}

	public function setNom($nom) {
		$this->nomPers = $nom;
		return $this;
	}

	public function getPrenom() {
		return $this->prenomPers;
	}

	public function setPrenom($nom) {
		$this->prenomPers = $nom;
		return $this;
	}

	public function getAdresse() {
		return $this->adresse;
	}

	public function setAdresse($adr) {
		$this->adresse = $adr;
		return $this;
	}

	public function getCP() {
		return $this->codePostal;
	}

	public function setCP($cp) {
		$this->codePostal = $cp;
		return $this;
	}

	public function getVille() {
		return $this->ville;
	}

	public function setVille($v) {
		$this->ville = $v;
		return $this;
	}

	public function getURL() {
		return $this->urlImage;
	}

	public function setURL($u) {
		$this->urlImage = $u;
		return $this;
	}

	public function getUsername() {
		return $this->nomUtilisateur;
	}

	public function setUsername($u) {
		$this->nomUtilisateur = $u;
		return $this;
	}

	public function getUserType() {
		return $this->type;
	}

	public function getNumerotel() {
		return $this->numerotel;
	}

	public function getMail() {
		return $this->mail;
	}

	public function setNumeroTel($numtel){
		$this->numerotel = $numtel;
		return $this;
	}

	public function setMail($mail){
		$this->mail = $mail;
		return $this;
	}

}

class AuthenticationException extends Exception {

	public function __construct($code = 0, Exception $previous = null) {
		parent::__construct("Aucun utilisateur avec ce couple pseudo/mdp", $code, $previous);
	}

}

class NotInSessionException extends Exception {

	public function __construct($code = 0, Exception $prev = null) {
		parent::__construct("Trying to access a saved user which is not in the SESSION", $code, $prev);
	}

}

