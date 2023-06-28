<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$array_resultados = array();

$sql = "SELECT id, codigo, descripcion, descripcion_corta, habilitada, imagen
        FROM carrera 
        WHERE habilitada='Si'
        ORDER BY descripcion ASC";
$resultado = mysqli_query($conex,$sql);
if (mysqli_num_rows($resultado)>0) {
      $filas = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
      $array_resultados['codigo'] = 100;
      $array_resultados['data'] = $filas;
} else {
      $array_resultados['codigo'] = 11;
      $array_resultados['data'] = "No existe la Carrera.";
}
echo json_encode($array_resultados);

?>
