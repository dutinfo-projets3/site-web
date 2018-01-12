<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 12/01/2018
 * Time: 10:44
 */
require_once("../autoload.inc.php");
$formations = Formation::getFormations();
$res = array();
$numero=0;
foreach($formations as $value){
    $tab=array('nom'=>$value->getNomFormation(),'id'=>$value->getIdFormation());
    array_push($res,$tab);
    $numero++;
}
echo(json_encode($res));
