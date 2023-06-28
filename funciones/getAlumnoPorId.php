<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$idAlumno = SanitizeVars::INT($_POST['alumno_id']);

$array_resultados = array();

if ($idAlumno) {
    $sql = "SELECT id, apellido, nombre, dni, anioIngreso, debeTitulo, habilitado
            FROM alumno 
            WHERE id = $idAlumno";
    $resultado = mysqli_query($conex,$sql);
    if (mysqli_num_rows($resultado)>0) {
      $filas = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
      $array_resultados['codigo'] = 100;
      $array_resultados['data'] = $filas;
    } else {
      $array_resultados['codigo'] = 11;
      $array_resultados['data'] = "No existe el Alumno.";
    }
} else {
    $array_resultados['codigo'] = 10;
    $array_resultados['data'] = "Faltan Datos Obligatarios.";
}
echo json_encode($array_resultados);

?>
