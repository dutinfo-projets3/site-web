<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 20/11/2017
 * Time: 19:20
 */
require_once 'autoload.inc.php';

class News
{

    private $idNews;
    private $idSecretaire;
    private $nomEvenement;
    private $numero;
    private $description;
    private $datePublication;

    /**
     * @return mixed
     */
    public function getIdNews()
    {
        return $this->idNews;
    }

    /**
     * @param mixed $idNews
     */
    public function setIdNews($idNews)
    {
        $this->idNews = $idNews;
    }

    /**
     * @return mixed
     */
    public function getIdSecretaire()
    {
        return $this->idSecretaire;
    }

    /**
     * @param mixed $idSecretaire
     */
    public function setIdSecretaire($idSecretaire)
    {
        $this->idSecretaire = $idSecretaire;
    }

    /**
     * @return mixed
     */
    public function getNomEvenement()
    {
        return $this->nomEvenement;
    }

    /**
     * @param mixed $nomEvenement
     */
    public function setNomEvenement($nomEvenement)
    {
        $this->nomEvenement = $nomEvenement;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $descirpion
     */
    public function setDescirpion($descirpion)
    {
        $this->descirpion = $descirpion;
    }

    /**
     * @return mixed
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * @param mixed $datePublication
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    }

    //A tester

    /**
     * retourne le nombre de news qui se trouve dans la base de donnée
     * @return int
     */
    public static function getCountNumbers()
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        SELECT COUNT(idNews) FROM News;
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();


        return $stmt->fetch()['COUNT(idNews)'];
    }

    //A tester

    /**
     * retourne les news en fonction de la page ou l'on se trouve(indexiation page accueil des news) et de leur date de pulication
     * @param int $nextHope
     * @return News
     */
    public static function createNewsNext($start = 0, $range = 5)
    {
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
        return $stmt->fetchAll();
    }

    //A tester
    // nous serviras pour charger le nom du secretaire qui a écrit la new
    public static function createNewsFromId($idNews)
    {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM News
        WHERE idNews = ?
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'News');
        $stmt->execute(Array($idNews));
        $obj = $stmt->fetch();
        if ($obj == null) {
            throw new NewsException();
        } else {
            return $obj;
        }
    }

}

class NewsException extends Exception
{
    public function __construct($message, $code, Exception $previous)
    {
        parent::__construct($message = "Pas de news disponible avec cette id", $code = 0, $previous = null);
    }
}