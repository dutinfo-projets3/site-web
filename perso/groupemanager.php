<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 13/01/2018
 * Time: 13:32
 */
require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
    header('Location: /');
    return;
}
$groupes = Groupe::getGroupes();
$formations = Formation::getFormations();
$listeNoms = array();
$listeId = array();
$listeForm = array();

foreach($formations as $value){
    array_push($listeId,$value->getIdFormation());
    array_push($listeNoms,$value->getNomFormation());
}

$pdo = myPDO::getInstance();
$stmt = $pdo->prepare("SELECT idPersonne,nomUtilisateur,nomPers,prenomPers 
                      FROM utilisateur 
                      WHERE type = 0");
$stmt->execute();
$etudiants = $stmt->fetchAll();

$listeForm = array_combine($listeId,$listeNoms);

echo TwigLoader::getInstance()->render('', 'perso/groupe', array('groupes'=>$groupes,'formations'=>$listeForm,'etudiants'=>$etudiants));