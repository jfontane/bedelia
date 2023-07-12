<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'controlAcceso.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$id = ( isset($_POST['id']) )?SanitizeVars::INT($_POST['id']):false;

$array_resultados = array();
if ($id) {
    $sql = "SELECT arm.*, a.dni, a.apellido, a.nombre, m.nombre as 'materia_nombre', e.codigo, e.descripcion, c.AnioLectivo
            FROM alumno_rinde_materia arm, alumno a, materia m, calendarioacademico c, evento e
            WHERE arm.id=$id AND
                  arm.idAlumno = a.id AND
                  arm.idMateria = m.id AND
                  arm.idCalendario = c.id AND
                  c.idEvento = e.id"; 
    //die($sql);        
    $resultado = mysqli_query($conex,$sql);
    if (mysqli_num_rows($resultado)>0) {
      $filas = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
      $array_resultados['codigo'] = 100;
      $array_resultados['datos'] = $filas;
    } else {
      $array_resultados['codigo'] = 11;
      $array_resultados['datos'] = "No existe Registro.";
    }
} else {
  $array_resultados['codigo'] = 10;
  $array_resultados['datos'] = "El ID es Incorrecto.";
}

echo json_encode($array_resultados);

?>
