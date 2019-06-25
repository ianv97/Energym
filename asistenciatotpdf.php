<?php
require "TCPDF/tcpdf.php";
$contenido='<html>';
$contenido.='<head>';
$contenido.='<title>Energym - Asistencias totales PDF</title>';
$contenido.='<link rel="shortcut icon" href="imagen/logo.ico"/>';
$contenido.='</head>';
$contenido.='<body>';
$contenido.='<header>';
$contenido.='<img src="imagen/logo.svg"/>';
$contenido.='<h3 style="text-align:right;">'.date('d/m/Y').'</h3>';
$contenido.='<h1 style="text-align:center;text-decoration:underline;">Informe de Asistencias Totales de Clientes</h1>';
$contenido.='<h1 style="text-align:center;margin-bottom:5vh;">'.DateTime::createFromFormat('Y-m-d', $_POST['asistenciatotpdf-finicio'])->format('d/m/Y').'   A   '.DateTime::createFromFormat('Y-m-d', $_POST['asistenciatotpdf-ffin'])->format('d/m/Y').'</h1>';
$contenido.='<h1></h1>';
$contenido.='</header>';
$contenido.='<table cellspacing="0" cellpadding="1" border="1" style="text-align:center;">';
	$contenido.='<tr>';
		$contenido.='<td><h3>Apellido y Nombre</h3></td>';
		$contenido.='<td><h3>Presente/Total</h3></td>';
		$contenido.='<td><h3>% Asistencia</h3></td>';
	$contenido.='</tr>';
$tabla=explode("!",$_POST["asistenciatotpdf-tabla"]);
$tamaño=count($tabla);
for ($i=0; $i<$tamaño-1; $i++){
	$fila=explode("*", $tabla[$i]);
	$contenido.='<tr>';
		$contenido.='<td>'.$fila[0].'</td>';
		$contenido.='<td>'.$fila[1].'</td>';
		$contenido.='<td>'.$fila[2].'</td>';
	$contenido.='</tr>';
};
$contenido.='</table>';
$contenido.='</body>';
$contenido.='</html>';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetTitle('Energym-Asistencias totales de clientes');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();
$pdf->writeHTMLCell(0, 0, '', '', $contenido, 0, 1, 0, true, '', true);

class MYPDF extends TCPDF {
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 12);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 12));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->output('Energym-Asistencias totales de clientes.pdf', 'I');
?>