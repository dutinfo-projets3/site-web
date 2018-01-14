<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 14/01/2018
 * Time: 18:38
 */
require_once("../autoload.inc.php");

$idGroupe = $_GET["idGroupe"];

$pdo = myPDO::getInstance();
$stmt=$pdo->prepare("DELETE FROM appartient WHERE idGroupe=?");
$stmt->execute([$idGroupe]);

$nomGroupe = Groupe::createFromId($idGroupe);
$nomGroupe = $nomGroupe->getNomGroupe();

echo $nomGroupe;

$stmt=$pdo->prepare("DELETE FROM groupe WHERE idGroupe=?");
$stmt->execute([$idGroupe]);
