<?php
require "TCPDF/tcpdf.php";
$contenido='<html>';
$contenido.='<head>';
$contenido.='<title>Energym - Asistencia PDF</title>';
$contenido.='<link rel="shortcut icon" href="imagen/logo.ico"/>';
$contenido.='</head>';
$contenido.='<body>';
$contenido.='<header>';
$contenido.='<img src="imagen/logo.svg"/>';
$contenido.='<h3 style="text-align:right;">'.date('d/m/Y').'</h3>';
$contenido.='<h1 style="text-align:center;text-decoration:underline;">Informe de Asistencia de Empleados</h1>';
$contenido.='<h1 style="text-align:center;margin-bottom:5vh;">'.DateTime::createFromFormat('Y-m-d', $_POST['asistenciaemppdf-finicio'])->format('d/m/Y').'   A   '.DateTime::createFromFormat('Y-m-d', $_POST['asistenciaemppdf-ffin'])->format('d/m/Y').'</h1>';
$contenido.='</header>';
$tabla=explode("!",$_POST["asistenciaemppdf-tabla"]);
$tamaño=count($tabla);
$i=0;
$fila=explode("*", $tabla[0]);
while ($i<$tamaño-1){
	$auxsuc=$fila[0];
	$cambiosuc=false;
	$asistencias=0;
	$faltas=0;
	$contenido.='<h2></h2><h2></h2>';
	$contenido.='<h2>Sucursal Nº ';$contenido.=$fila[0];$contenido.='</h2>';
	$contenido.='<table cellspacing="0" cellpadding="1" border="1" style="text-align:center;">';
		$contenido.='<tr>';
			$contenido.='<td><h3>Fecha</h3></td>';
			$contenido.='<td><h3>Apellido y Nombre</h3></td>';
			$contenido.='<td><h3>Presente</h3></td>';
			$contenido.='<td><h3>Horas trabajadas</h3></td>';
		$contenido.='</tr>';
	while ($i<$tamaño-1 AND $cambiosuc==false){
		$contenido.='<tr>';
			$contenido.='<td>'.DateTime::createFromFormat('Y-m-d', $fila[1])->format('d/m/y').'</td>';
			$contenido.='<td>'.$fila[2].'</td>';
			if ($fila[3]==1){
				$contenido.='<td><img src="imagen/check.svg" style="width:15; height:15;"/></td>';
				$asistencias+=1;
			}else{
				$contenido.='<td><img src="imagen/times.svg" style="width:15; height:15;"/></td>';
				$faltas+=1;
			};
			$contenido.='<td>'.$fila[4].'</td>';
		$contenido.='</tr>';
		$i+=1;
		if ($i<$tamaño-1){
			$fila=explode("*", $tabla[$i]);
			if ($fila[0]!=$auxsuc){
				$cambiosuc=true;
			};
		};
	};
	$contenido.='</table>';
	$contenido.='<h3>Asistencias/Total: ';$contenido.=$asistencias;$contenido.='/';$contenido.=($asistencias+$faltas);$contenido.='</h3>';
};
$contenido.='</body>';
$contenido.='</html>';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetTitle('Energym-Asistencia de empleados');
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
        $this->Cell(0, 10, 'Pag '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 12));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->output('Energym-Asistencia de empleados.pdf', 'I');
?>