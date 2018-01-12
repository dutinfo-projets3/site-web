<?php

require_once "../autoload.inc.php";
ob_start();

if (!isset($_GET["annee"]) || empty($_GET["annee"]) || !isset($_GET["formation"]) || empty($_GET["formation"])){ 
	http_response_code(400);
	return;
}

function writeCentered($pdf, $text){
	$pdf->SetX(($pdf->GetPageWidth() / 2) - ($pdf->GetStringWidth($text) / 2));
	$pdf->Cell(0, 10, $text);
}


if (Utilisateur::isConnected()){
	$user = Utilisateur::createFromSession();

	$notes = Note::buildArray($user->getID(), $_GET["formation"], Annee::createFromUserYear($user->getID(), $_GET["formation"], $_GET["annee"]));
	
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->SetAuthor('PanAfrican University');
	$pdf->SetTitle('Bulletin ');
	$pdf->SetSubject('Notes');
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);


	$pdf->AddPage();

	writeCentered($pdf, "Bulletin de notes");
	$pdf->SetY(18);
	$pdf->SetFont("times", "", 12);
	writeCentered($pdf, "Annee scolaire {$_GET['annee']} - " . ($_GET["annee"] + 1));
	$pdf->SetFont("times", "", 10);
	$pdf->SetY(24);
	writeCentered($pdf, "Periode du XX/XX/XXXX au XX/XX/XXXX");
	$pdf->Ln(20);
	$pdf->Cell(0, 10, $user->getNom() . " " . $user->getPrenom());
	$pdf->Ln(20);

	$size = [ 110, 25, 25, 25 ];
	$header = [ "Matiere", "Note", "Coef", "Moyenne" ];

	for($i = 0; $i < count($header); ++$i){
		$pdf->Cell($size[$i], 7, $header[$i], true);
	}

	$pdf->Ln(7);
	$pdf->SetFont("times", "", 8);
	$pdf->SetFillColor(220, 220, 220);

	$moyennes = array();

	foreach ($notes as $k => $v){
		$moy = 0;
		$tot = 0;
		foreach($v[1] as $note){
			$moy += $note[0] * $note[1];
			$tot += $note[1];
		}

		$moy = round(($moy/$tot), 2);

		$pdf->Cell($size[0], 7, $k, "LR", 0, "L", true);
		$pdf->Cell($size[1], 7, "", "LR", 0, "C", true);
		$pdf->Cell($size[2], 7, $v[0], "LR", 0, "C", true);
		$pdf->Cell($size[3], 7, $moy, "LR", 1, "C", true);

		foreach($v[1] as $note){
			$pdf->Cell($size[0], 7, "", "LR");
			$pdf->Cell($size[1], 7, $note[0], "LR", 0, "C");
			$pdf->Cell($size[2], 7, $note[1], "LR", 0, "C");
			$pdf->Cell($size[3], 7, "", "LR", 1);
		}

		array_push($moyennes, [ $moy, $v[0]]);
	}

	$moyGen = 0;
	$totGen = 0;

	foreach($moyennes as $note){
		$moyGen += $note[0] * $note[1];
		$totGen += $note[1];
	}

	$pdf->Cell($size[0] + $size[1] + $size[2], 7, "Moyenne generale", 1, 0, "C");
	$pdf->Cell($size[3], 7, round(($moyGen/$totGen), 2), 1, 1, "C");
	$pdf->Cell($size[0] + $size[1] + $size[2], 7, "Journee d'absences", 1, 0, "C");
	$pdf->Cell($size[3], 7, "0", 1, 1, "C");

ob_end_clean();
	$pdf->Output();
} else {

	http_response_code(401);
	return;

}

