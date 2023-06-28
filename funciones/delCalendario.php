<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$calendario = (isset($_POST['calendario']) && $_POST['calendario']!=NULL)?SanitizeVars::INT($_POST['calendario']):false;

$array_resultados = array();
if ($calendario) {
      $sql = "DELETE FROM calendarioacademico
              WHERE id = $calendario";
      //die($sql);        
      $resultado = mysqli_query($conex,$sql);
      if ($resultado) {
         $array_resultados['codigo'] = 100;
         $array_resultados['data'] = "El Evento del calendario con ID <b>".$calendario."</b>, fue Eliminado Exitosamente.";
      } else {
         $errorNro =  mysqli_errno($conex);
         $array_resultados['codigo'] = 12;
         $array_resultados['data'] = "Hubo un Error en la Eliminaci&oacute;n del Evento al Calendario. ";
      }
} else {
      $array_resultados['codigo'] = 13;
      $array_resultados['data'] = "Faltan Datos para realizar la Eliminaci&oacute;n. ";
}
echo json_encode($array_resultados);



?>
