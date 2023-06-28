<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$parametros=$_GET['parametros'];
$arrCarreraTurnoLlamado=explode('_',$parametros);
$idCarrera=$arrCarreraTurnoLlamado[0];
$idCalendario=$arrCarreraTurnoLlamado[1];
$llamado=$arrCarreraTurnoLlamado[2];
$arrayMateriasAprobadasPorCarrera=array();
$sqlMateriasPorCarrera="SELECT DISTINCT c.id, c.nombre, COUNT( * ) as cantidad, c.anio
                        FROM alumno_rinde_materia a, carrera_tiene_materia b, materia c
                        WHERE a.idCalendario ={$idCalendario} AND
                              a.llamado ={$llamado} AND
                              a.idMateria = b.idMateria AND
                              b.idCarrera ={$idCarrera} AND
                              b.idMateria = c.id AND
                              a.condicion not like '%Promocion%' AND
                              a.condicion not like '%Homologacion%' 
                        GROUP BY c.nombre
                        ORDER BY c.anio";

//echo $sqlMateriasPorCarrera;die;
$resultadoMateriasPorCarrera=mysqli_query($conex,$sqlMateriasPorCarrera);
$arraytodasMateriasConInscriptosPorCarrera=array();
while ($filaMateriasPorCarrera=mysqli_fetch_assoc($resultadoMateriasPorCarrera)) {
    $arrayMateriaPorCarrera=array(); 
    //(idMateria, nombreMateria)
    
        array_push($arrayMateriaPorCarrera,$filaMateriasPorCarrera['id'],$filaMateriasPorCarrera['nombre'],$filaMateriasPorCarrera['anio'],$filaMateriasPorCarrera['cantidad']);
        array_push($arraytodasMateriasConInscriptosPorCarrera,$arrayMateriaPorCarrera);
            
    }
   
    
echo "<table class=\"pgui-grid grid legacy stripped\">";
$band=true;

function sacaMateriaPorAnio($anio) {
 global $arraytodasMateriasConInscriptosPorCarrera;
 global $parametros;
 $band=false;$str="";
 foreach ($arraytodasMateriasConInscriptosPorCarrera as $valor) {
   if ($valor[2]==$anio) {
     $str.="<tr id='tr_{$parametros}_{$valor[0]}' onmouseover=\"cambiar_color_over(this)\" onmouseout=\"cambiar_color_out(this)\" "
          ." onclick=\"window.open('./funciones/PDF_ActaVolante.php?parametros=".$parametros.'_'.$valor[0]."','_blank')\">"
          ."<td style='text-align: left;'>$valor[1]</td><td style='text-align: center;'>$valor[3]</td></tr>";
     $band=true;
     }
 }
 if ($band) return $str;
 else return "<tr><td style='text-align: center;color:red' colspan='2'>No Existen Alumnos que rindan materias de este A&ntilde;o</td></tr>";
}


          echo "<tr><th colspan=2 style='text-align: center;background-color: #80A5EF;'>PRIMER A&Ntilde;O</th></tr>";
          echo "<tr><th style='text-align: center;'>Asignatura</th><th style='text-align: center;'>Cantidad Inscriptos</th></tr>";
          echo sacaMateriaPorAnio(1);
          echo "<tr><th colspan=2 style='text-align: center;background-color: #80A5EF;' >SEGUNDO A&Ntilde;O</th></tr>";
          echo "<tr><th style='text-align: center;'>Asignatura</th><th style='text-align: center;'>Cantidad Inscriptos</th></tr>";
          echo sacaMateriaPorAnio(2);
          echo "<tr><th colspan=2 style='text-align: center;background-color: #80A5EF;' >TERCER A&Ntilde;O</th></tr>";
          echo "<tr><th style='text-align: center;'>Asignatura</th><th style='text-align: center;'>Cantidad Inscriptos</th></tr>";
          echo sacaMateriaPorAnio(3);
          echo "<tr><th colspan=2 style='text-align: center;background-color: #80A5EF;' >CUARTO A&Ntilde;O</th></tr>";
          echo "<tr><th style='text-align: center;'>Asignatura</th><th style='text-align: center;'>Cantidad Inscriptos</th></tr>";
          echo sacaMateriaPorAnio(4);
     
      
echo "</table>";
    
?>