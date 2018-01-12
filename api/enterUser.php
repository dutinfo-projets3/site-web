<?php

require_once('../autoload.inc.php');

$nom = $_GET["nom"];
$prenom =$_GET["prenom"];
$adresse=$_GET["adresse"];
$ville=$_GET["ville"];
$cp=$_GET["cp"];
$numerotel=$_GET["numerotel"];
$mail=$_GET["mail"];
$type=$_GET["type"];


$randomPass="";
for($i=0;$i<15;$i++){
    $rdm = 0;
    $rdm = rand(1,3);
    if($rdm == 1){
        $randomPass .= chr(rand(48,57));
    }
    else if($rdm == 2){
        $randomPass .= chr(rand(65,90));
    }
    else{
        $randomPass .= chr(rand(97,122));
    }
}

$randomPassSHA = hash("sha256",$randomPass);

$pdo = myPDO::getInstance();
$stmt = $pdo->prepare("INSERT INTO utilisateur(type,nomPers,prenomPers,motDePasse,adresse,ville,codePostal,mail,numerotel)VALUES(?,?,?,?,?,?,?,?,?)");
$stmt->execute([$type,$nom,$prenom,$randomPassSHA,$adresse,$ville,$cp,$mail,$numerotel]);



$from = "smtp.gmail.com";

$to = $mail;

$subject = "Inscription";

$message = "Inscription PAUWES : Mot de passe temporaire (merci de le changer à votre première connection) :".$randomPass ;

$headers = "From:" . $from;

mail($to,$subject,$message, $headers);
