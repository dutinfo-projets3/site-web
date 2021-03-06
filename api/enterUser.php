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
$formation="";
$INE="";
$embauche="";

if($type==0){
    $formation = $_GET["formation"];
    $INE = $_GET["INE"];
}
else{
    $embauche=$_GET["date"];
}


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

$user = $pdo->lastInsertId();

if($type==0){
    $stmt = $pdo->prepare("SELECT annee FROM anneescolaire WHERE idFormation=?");
    $stmt->execute([$formation]);
    $date = $stmt->fetch();

    if($todayDate = new DateTime("now"));
    $dateLimite = new DateTime(date("Y")."-10-01");

    $dateARentrer=date("Y");

    if($todayDate>$dateLimite){
        $dateARentrer=date("Y")+1;
    }

    if($date["annee"]!= date("Y")){
        $stmt = $pdo->prepare("INSERT INTO anneescolaire(idFormation,annee)VALUES(?,?)");
        $stmt->execute([$formation,$dateARentrer]);
    }

    $dateARentrer="01/10/".$dateARentrer;

    $stmt = $pdo->prepare("INSERT INTO etudiant(idEtudiant,ine,dateEntree)VALUES(?,?,STR_TO_DATE(?,'%d/%m/%Y'))");
    $stmt->execute([$user,$INE,$dateARentrer]);
}

else{
    $stmt = $pdo->prepare("INSERT INTO professeur(idProfesseur,dateEmbauche)VALUES(?,STR_TO_DATE(?,'%d/%m/%Y'))");
    $stmt->execute([$user,$embauche]);
}

$user = utilisateur::createFromID($user);
$texte = "Username : ".$user->getUsername()." Password : ".$randomPass;


echo $texte;


/*$from = "smtp.gmail.com";

$to = $mail;

$subject = "Inscription";

$message = "Inscription PAUWES : Nom d'utilisateur Mot de passe temporaire (merci de le changer à votre première connection) :".$randomPass ;

$headers = "From:" . $from;

mail($to,$subject,$message, $headers);*/
