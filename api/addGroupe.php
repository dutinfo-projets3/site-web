<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 14/01/2018
 * Time: 17:54
 */
require_once("../autoload.inc.php");

$nom = $_GET["nom"];
$idFormation = $_GET["idFormation"];

$pdo = myPDO::getInstance();
$stmt = $pdo->prepare("INSERT INTO groupe(nom,idFormation)VALUES(?,?)");
$stmt->execute([$nom,$idFormation]);

$res = array();
array_push($res,$pdo->lastInsertId());

$formation = Formation::createFromID($idFormation);
array_push($res,$formation->getNomFormation());

echo(json_encode($res));