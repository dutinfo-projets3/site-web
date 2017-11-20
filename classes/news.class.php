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


    public static function createNews()
    {
        $listNews = array();

        $stmt = myPDO::getInstance()->prepare(<<<SQL
        SELECT idNews FROM News
        ORDER BY datePublication DESC;
SQL
  );
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $listIdNews = $stmt->fetchAll();
        foreach($listIdNews as $idNew){
            array_push($listNews, self::createNewsFromId($idNew['idNews']));
        }

        return $listNews;
    }

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