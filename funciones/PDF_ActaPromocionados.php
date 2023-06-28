<?php
set_include_path('../../lib/fpdf'.PATH_SEPARATOR.'../../conexion/');
require_once('conexion.php');
require_once('fpdf.php');

function convierteNota($numero) {
   $numeroNota=0;
    switch($numero) {
        case 6:{
                $numeroNota="Seis";
                break;
                }
        case 7:{
                $numeroNota="Siete";
                break;
                }
        case 8:{
                $numeroNota="Ocho";
                break;
                }
        case 9:{
                $numeroNota="Nueve";
                break;
                }
        case 10:{
                $numeroNota="Diez";
                break;
                }
                
   };
   return $numeroNota;
};

class PDF extends FPDF
{
//Cabecera de pagina
function Header()
{
global $conex; 

$parametros = explode('_',$_GET['parametros']);
$idCarrera = $parametros[0];
$idCalemdario = $parametros[1];
$idMateria = $parametros[2];
//die($idCarrera.'_'.$idCalemdario.'_'.$idMateria);
$sql="SELECT c.nombre as nombre, c.anio as anio, f.descripcion as descripcion, c.promocionable as promocionable
      FROM materia c, formato f 
      WHERE c.id = $idMateria and 
            c.idFormato=f.id";      

$resultado = mysqli_query($conex, $sql);
$fila1 = mysqli_fetch_assoc($resultado);
$nombreMateria = strtoupper($fila1['nombre']);
$anioMateria = $fila1['anio'];
$formato = $fila1['descripcion'];
$promocionable = $fila1['promocionable'];
if ($anioMateria == 1) $anioCompleto='PRIMERO';
else if ($anioMateria == 2) $anioCompleto='SEGUNDO';
else if ($anioMateria == 3) $anioCompleto='TERCERO';
else if ($anioMateria == 4) $anioCompleto='CUARTO';

$sqlCarrera = "SELECT c.descripcion_corta
               FROM carrera c 
               WHERE c.id=$idCarrera"; 
$resultadoCarrera = mysqli_query($conex, $sqlCarrera);
$filaCarrera = mysqli_fetch_assoc($resultadoCarrera);
$nombreCarrera = $filaCarrera['descripcion_corta'];
if ($formato == 'Materia' && $promocionable == 'S') $determinacionActa = "PROMOCIONADOS";
else $determinacionActa = "APROBADOS";




    $this->SetLeftMargin(10);
    $this->Image('../../public/img/logo.jpg',15,4,139,13);
    $this->Ln(15);
    //Arial bold 15
    $this->SetFont('courier','B',10);
    //Movernos a la derecha
   //   $this->Cell(80);
    //T�tulo
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->Cell(190,7,'ACTA VOLANTE DE '.$determinacionActa,0,1,'R',true);

    $this->Ln(1);
    $this->SetFillColor(204,204,204);
    $this->SetTextColor(0,0,0);
	
	
	
		
    //$this->Cell(190,5,'',0,1,'C',true);
	

    $anio=utf8_decode('AÑO');	
    
    $this->SetFillColor(255,255,255);	
    $this->Cell(52,7,'EVALUACIONES DE ALUMNOS:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(105,7,$determinacionActa,0,0,'L',TRUE);
    $this->SetFont('courier','B',10);
    $this->Cell(10,7,'DIA',1,0,'L',TRUE);
    $this->Cell(10,7,'MES',1,0,'L',TRUE);
    $this->Cell(10,7,$anio,1,1,'L',TRUE);
    
    $this->Cell(25,7,'ASIGNATURA:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(132,7,utf8_decode($nombreMateria),0,0,'L',TRUE);
    $this->Cell(10,9,'',1,0,'L',TRUE);
    $this->Cell(10,9,'',1,0,'L',TRUE);
    $this->Cell(10,9,'',1,1,'L',TRUE);
    
    $this->SetFont('courier','B',10);
    $this->Cell(18,7,'CARRERA:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(60,7,utf8_decode($nombreCarrera),0,0,'L',false);
    $this->SetFont('courier','B',10);
    $this->Cell(10,7,$anio.':',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(25,7,$anioCompleto,0,0,'L',false);
    $this->SetFont('courier','B',10);
    $this->Cell(20,7,'DIVISION:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(20,7,' UNICA',0,0,'L',false);
    $this->SetFont('courier','B',10);
    $this->Cell(14,7,'TURNO:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(18,7,'VESPERTINO',0,1,'L',false);

    
    $this->SetFont('courier','',8);
    $this->Cell(15,10,'Orden',1,0,'C',true);
    $this->Cell(15,10,'Permiso',1,0,'C',true);
    $this->Cell(32,10,'DOC. DE IDENTIDAD',1,0,'C',true);
    $this->Cell(68,10,'APELLIDO Y NOMBRES',1,0,'C',true);
    $this->Cell(30,10,'EVALUACIONES',1,0,'C',true);
    $this->Cell(30,10,'OBSERVACIONES',1,1,'C',true);

} 

//Pie de p�gina
function FooterMio()
{
    //Posici�n: a 1,5 cm del final
    $this->SetY(-60);
    $this->SetX(10);
    //Arial italic 8
    
    //N�mero de p�gina
    $this->SetFont('courier','B',10);
    $this->Cell(25,10,'Presidente:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(45,10,'____________________',0,0,'L',false);
    $this->SetFont('courier','B',10);
    $this->Cell(15,10,'Vocal:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(45,10,'____________________',0,0,'L',false);
    $this->SetFont('courier','B',10);
    $this->Cell(15,10,'Vocal:',0,0,'L',false);
    $this->SetFont('courier','',10);
    $this->Cell(45,10,'____________________',0,1,'L',false);
    $this->Cell(190,5,'Total de alumnos:_______________',0,1,'R',false);
    $this->Cell(190,5,'Aprobados:_______________',0,1,'R',false);
    $this->Cell(190,5,'SAN CRISTOBAL:_______ de _______________ de ________         Desaprobados:_______________',0,1,'R',false);
    $this->Cell(190,5,'Ausentes:_______________',0,1,'R',false);
    
 }
} // END Class


//Creaci�n del objeto de la clase heredada

//$sqlMateriasInscriptas="SELECT a.idMateria, b.nombre as nombreMateria, a.llamado, b.anio, a.idCalendario
//FROM alumno_rinde_materia a, materia b
//WHERE a.idAlumno={$idAlumno} and
//  a.idCalendario={$idTurno} and 
//  a.idMateria=b.id";
//
//$resultadoMateriasInscriptas=mysqli_query($conex,$sqlMateriasInscriptas);

$parametros = explode('_',$_GET['parametros']);
$idCarrera = $parametros[0];
$idCalemdario = $parametros[1];
$idMateria = $parametros[2];
//die($idCarrera.'_'.$idCalemdario.'_'.$idMateria);

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('courier','',8);


$anioActual=date('Y');
/*$sql="SELECT b.id, b.apellido, b.nombre, b.dni, c.nombre as nombreMateria, c.anio, a.nota
      FROM alumno_cursa_materia a, alumno b, materia c 
      WHERE a.idMateria = $idMateria and
            (a.estado_final = 'Promociono' or a.estado_final = 'Aprobo') and 
            a.idAlumno = b.id and a.idMateria = c.id and
            a.anioCursado = $anioActual
      ORDER BY b.apellido, b.nombre";  */

$sql = "SELECT b.id, b.apellido, b.nombre, b.dni, c.nombre as nombreMateria, c.anio, a.nota
        FROM alumno_rinde_materia a, alumno b, materia c 
        WHERE a.idCalendario = $idCalemdario and
              a.idMateria = $idMateria and
              a.condicion = 'Promocion' and 
              a.estado_final = 'Aprobo' and 
              a.idAlumno = b.id and 
              a.idMateria = c.id
        ORDER BY b.apellido, b.nombre";

$resultado = mysqli_query($conex, $sql);


if (mysqli_num_rows($resultado) > 0)
{
 $i=1;   
 while ($fila=mysqli_fetch_assoc($resultado))
  {
    $pdf->Cell(15,5,$i,1,0,'C',false);
    $pdf->Cell(15,5,'',1,0,'R',false);
    $pdf->Cell(32,5,$fila['dni'],1,0,'C',false);
    $pdf->Cell(68,5,utf8_decode($fila['apellido']).', '.utf8_decode($fila['nombre']),1,0,'L',false);
    $pdf->Cell(15,5,$fila['nota'],1,0,'R',false);
    $pdf->Cell(15,5,convierteNota($fila['nota']),1,0,'R',false);
    $pdf->Cell(30,5,'',1,1,'R',false);
    $anioMateria=$fila['anio'];
    $nombreMateria=$fila['nombreMateria'];
    $i++;
 };
 $_SESSION['anioMateria']=$anioMateria;
 
};
if (mysqli_num_rows($resultado) < 34) $pdf->FooterMio();
//mysqli_free_result($resultadoMateriasInscriptas);


$pdf->Output();
?>
