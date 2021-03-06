<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 20/11/2017
 * Time: 19:20
 */

class News {
	private $idNews;
	private $idSecretaire;
	private $nomEvenement;
	private $description;
	private $datePublication;

	/**
	 * Getter pour idNews
	 * @return idNews
	 */
	public function getIdNews() {
		return $this->idNews;
	}

	/**
	 * Setter pour idNews
	 * @param Integer $idNews
	 */
	public function setIdNews($idNews) {
		$this->idNews = $idNews;
	}

	/**
	 * Getter pour idSecretaire
	 * @return idSecretaire
	 */
	public function getIdSecretaire() {
		return $this->idSecretaire;
	}

	/**
	 * Setter pour idSecretaire
	 * @param Integer $idSecretaire
	 */
	public function setIdSecretaire($idSecretaire) {
		$this->idSecretaire = $idSecretaire;
	}

	/**
	 * Getter pour le nom de la news
	 * @return String nomEvenement
	 */
	public function getNomEvenement() {
		return $this->nomEvenement;
	}

	/**
	 * Setter pour le nom de la news
	 * @param String $nomEvenement
	 */
	public function setNomEvenement($nomEvenement) {
		$this->nomEvenement = $nomEvenement;
	}

	/**
	 * @TODO ???
	 * Getter pour numero
	 * @return Integer numero
	 */
	public function getNumero() {
		return $this->numero;
	}

	/**
	 * @TODO ???
	 * Setter pour numero
	 * @param Integer $numero
	 */
	public function setNumero($numero) {
		$this->numero = $numero;
	}

	/**
	 * Getter pour le contenu de la news
	 * Non parsée
	 * @return String $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Setter pour le contenu
	 * @param String
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Getter pour la date de publication
	 * @return Date $datePublication
	 */
	public function getDatePublication() {
		return $this->datePublication;
	}

	/**
	 * Setter pour la date de publication
	 * @param Date $datePublication
	 */
	public function setDatePublication($datePublication) {
		$this->datePublication = $datePublication;
	}

	/**
	 * Retourne le nombre de news qui se trouve dans la base de donnée
	 * @return Nombre de news dans la base de données
	 */
	public static function getCountNumbers() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT COUNT(idNews) FROM News;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();

		return $stmt->fetch()['COUNT(idNews)'];
	}

	/**
	 * Retourne les news en fonction de la page où l'on se trouve
	 * @param $start Offset du numéro de news
	 * @param $range nombre de news à retourner
	 * @throws InvalidArgumentException
	 * @return News array
	 *
	 * @TODO Test
	 *
	 */
	public static function createNewsNext($start = 0, $range = 5) {

		if ($start >= 0 && $start <= self::getCountNumbers()) {
			$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM News
		ORDER BY datePublication DESC
		LIMIT :start, :range;
SQL
			);
			$stmt->setFetchMode(PDO::FETCH_CLASS, "News");
			$stmt->bindParam(':start', $start, PDO::PARAM_INT);
			$stmt->bindParam(':range', $range, PDO::PARAM_INT);
			$stmt->execute();
			$news = $stmt->fetchAll();

			for ($i = 0; $i < count($news); $i++) {
				$value = json_decode($news[$i]->getDescription(), true);
				$n = 0;
				if (!is_array($value['ops'][$n]['insert'])) {
					while (strlen($value['ops'][$n]['insert']) == 1) {
						$n++;
					}
					$news[$i]->setDescription(substr($value['ops'][$n]['insert'], 0) . "...");
				} else {
					$news[$i]->setDescription("Images" . "...");
				}
			}
			return $news;
		} else {
			throw new InvalidArgumentException("Le numéro de page ne peut être inferieur à 0");

		}

	}

	/**
	 * Retourne une news depuis son ID
	 * @param $idNews L'id de la news voulue
	 * @throws NewsException
	 * @return News instance
	 *
	 * @TODO Test
	 *
	 */
	public static function createFromID($idNews) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT * FROM News
		WHERE idNews = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'News');
		$stmt->execute(array($idNews));
		$obj = $stmt->fetch();
		if ($obj == null) {
			throw new NewsException();
		} else {
			return $obj;
		}
	}

	/**
	 * Insert une news
	 * @param $idSecretaire id du secretaire qui insére la news
	 * @param $title  titre de la new
	 * @param $description contenue de la new
	 * @throws NewsInsertException
	 * @return true si la news a été postées
	 *
	 * @TODO Test
	 *
	 */
	public static function insertIntoBD($idSecretaire, $title, $description) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		INSERT INTO News (idSecretaire, nomEvenement, description, datePublication) 
		VALUES (?, ?, ?, NOW());
SQL
		);
		$succes = $stmt->execute(array($idSecretaire, $title, $description));
		if ($succes == false) {
			throw new NewsInsertException();
		} else {
			return true;
		}
	}

	/**
	 * Permet d'obtenir le nom et l'id chaque news classer par ordre d'édition
	 * @return mixed
	 */
	public static function getNewsNames() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT idNews, nomEvenement, datePublication
		FROM News
		ORDER BY datePublication DESC ;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/**
	 * Permet de mettre a jour un news dans la BD en fonction de son id
	 * @param $idNews
	 * @param $title
	 * @param $description
	 * @return true si l'update c'est bien passé
	 */
	public static function updateNews($idNews, $title, $description) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE News SET nomEvenement = ? , description = ?
			WHERE idNews = ?; 
SQL
		);

		return $stmt->execute(array($title, $description, $idNews));
	}

	/**
	 * Permet de supprimer une news suivant sont id
	 * @param $idNews
	 * @return true si la suppression à eu lieu
	 */
	public static function deleteNews($idNews) {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
	DELETE FROM News
	WHERE idNews = ?;
SQL
		);
		return $stmt->execute(array($idNews));

	}
}

class NewsException extends Exception {
	public function __construct($message = "Pas de news disponible avec cet ID", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}

class NewsInsertException extends Exception {
	public function __construct($message = "Impossible d'insérer une new", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}