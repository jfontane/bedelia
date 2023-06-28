<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$anio_lectivo = (isset($_POST['anio']) && $_POST['anio']!=NULL)?SanitizeVars::INT($_POST['anio']):false;
$evento = (isset($_POST['evento']) && $_POST['evento']!=NULL)?SanitizeVars::INT($_POST['evento']):false;
$calendario = (isset($_POST['calendario']) && $_POST['calendario']!=NULL)?SanitizeVars::INT($_POST['calendario']):false;
$fecha_inicio = (isset($_POST['fecha_inicio']) && $_POST['fecha_inicio']!=NULL)?SanitizeVars::DATE($_POST['fecha_inicio']):false;
$fecha_finalizacion = (isset($_POST['fecha_finalizacion']) && $_POST['fecha_finalizacion']!=NULL)?SanitizeVars::DATE($_POST['fecha_finalizacion']):false;


$array_resultados = array();
if ($anio_lectivo && $evento && $fecha_inicio && $fecha_finalizacion) {
      $sql = "UPDATE calendarioacademico
              SET AnioLectivo=$anio_lectivo, 
                  fechaInicioEvento='$fecha_inicio',
                  fechaFinalEvento = '$fecha_finalizacion',
                  idEvento = $evento
              WHERE id = $calendario";
      //die($sql);        
      $resultado = mysqli_query($conex,$sql);
      if ($resultado) {
         $array_resultados['codigo'] = 100;
         $array_resultados['data'] = "El Evento del calendario fue Actualizado Exitosamente.";
      } else {
         $errorNro =  mysqli_errno($conex);
         $array_resultados['codigo'] = 12;
         $array_resultados['data'] = "Hubo un Error en la Actualizacion del Evento al Calendario. ";
      }
} else {
      $array_resultados['codigo'] = 13;
      $array_resultados['data'] = "Faltan Datos para realizar la Actualizacion. ";
}
echo json_encode($array_resultados);



?>
