<?php
require_once "../autoload.inc.php";

function writeCentered($pdf, $text){
	$pdf->SetX(($pdf->GetPageWidth() / 2) - ($pdf->GetStringWidth($text) / 2));
	$pdf->Cell(0, 10, $text);
}


$notes = [
	"Mathematiques" => [ 2, [ [ 2, 1], [15, 2], [15, 2] , [12, 3] ] ],
	"Java" => [ 1, [ [20, 2], [20, 2], [19, 5] ] ],
	"Theorie du complot" => [1, [ [20, 1], [20, 2] ] ]
];


if (Utilisateur::isConnected()){
	$user = Utilisateur::createFromSession();

	$pdf = new FPDF();
	$pdf->SetFont("Arial", "B", 16);

	$pdf->AddPage();

	writeCentered($pdf, "Bulletin de notes");
	$pdf->SetY(18);
	$pdf->SetFont("Arial", "", 12);
	writeCentered($pdf, "Annee scolaire XXXX - XXXX");
	$pdf->SetFont("Arial", "", 10);
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
	$pdf->SetFont("Arial", "", 8);
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
			$pdf->Cell($size[0], 7, "      Note", "LR");
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


	$pdf->Output();
}
