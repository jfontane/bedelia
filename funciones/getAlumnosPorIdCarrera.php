<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$idCarrera = SanitizeVars::INT($_POST['carrera_id']);

$array_resultados = array();

if ($idCarrera) {
    $sql = "SELECT a.*
            FROM alumno_estudia_carrera aec, alumno a 
            WHERE aec.idCarrera = $idCarrera AND
                  aec.idAlumno = a.id
            ORDER BY apellido asc, nombre asc";
    $resultado = mysqli_query($conex,$sql);
    if (mysqli_num_rows($resultado)>0) {
      $filas = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
      $array_resultados['codigo'] = 100;
      $array_resultados['datos'] = $filas;
    } else {
      $array_resultados['codigo'] = 11;
      $array_resultados['datos'] = "No existe la Carrera.";
    }
} else {
    $array_resultados['codigo'] = 10;
    $array_resultados['datos'] = "Faltan Datos Obligatarios.";
}
echo json_encode($array_resultados);

?>
