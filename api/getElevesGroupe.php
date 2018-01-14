<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 13/01/2018
 * Time: 21:09
 */
require_once('../autoload.inc.php');
$idGroupe = $_GET["idGroupe"];

$pdo = myPDO::getInstance();
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