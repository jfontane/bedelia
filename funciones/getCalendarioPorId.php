<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$idCalendario = (isset($_POST['calendario']) && $_POST['calendario']!=NULL)?SanitizeVars::INT($_POST['calendario']):false;
$array_resultados = array();

if ($idCalendario) {
    $sql = "SELECT ca.*, e.id as 'idEvento', e.codigo, e.descripcion 
            FROM calendarioacademico ca, evento e 
            WHERE ca.id = $idCalendario and ca.idEvento = e.id";
    $resultado = mysqli_query($conex,$sql);
    if (mysqli_num_rows($resultado)>0) {
      $filas = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
      $array_resultados['codigo'] = 100;
      $array_resultados['data'] = $filas;
    } else {
      $array_resultados['codigo'] = 11;
      $array_resultados['data'] = "No existe el Evento.";
    }
} else {
    $array_resultados['codigo'] = 10;
    $array_resultados['data'] = "Faltan Datos Obligatarios.";
}
echo json_encode($array_resultados);

?>
