<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 14/01/2018
 * Time: 16:22
 */
require_once("../autoload.inc.php");

$idStudent = $_GET["idStudent"];
$idGroupe = $_GET["idGroupe"];

$pdo = myPDO::getInstance();
$stmt = $pdo->prepare("DELETE FROM appartient 
                      WHERE idGroupe=? AND idEtudiant=?");
$stmt->execute([$idGroupe,$idStudent]);

$stmt = $pdo->prepare("SELECT idPersonne,nomUtilisateur,nomPers,prenomPers 
                      FROM utilisateur 
                      WHERE idPersonne IN (SELECT idEtudiant
                                          FROM appartient
                                          WHERE idGroupe = ?)");
$stmt->execute([$idGroupe]);
$etudiants = $stmt->fetchAll();

$res = array();
$numero=0;
foreach($etudiants as $value){
    $tab=array('id'=>$value['idPersonne'],'nom'=>$value["nomPers"],'prenom'=>$value["prenomPers"],'userName'=>$value['nomUtilisateur']);
    array_push($res,$tab);
    $numero++;
}
echo(json_encode($res));