<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

function existePersonaCreada($conex,$dni){
    $sql = "SELECT * FROM persona WHERE dni='$dni'";
    $resultado = mysqli_query($conex,$sql);
    //die($sql);
    if (mysqli_num_rows($resultado)>0) {
        return true;
    } else {
         return false;
    };
}


$entidad = "Profesor";
$accion = (isset($_POST['accion']) && $_POST['accion']!=NULL)?SanitizeVars::STRING($_POST['accion']):false;
$apellido = (isset($_POST['apellido']) && $_POST['apellido']!=NULL)?SanitizeVars::STRING($_POST['apellido']):false;
$nombres = (isset($_POST['nombres']) && $_POST['nombres']!=NULL)?SanitizeVars::STRING($_POST['nombres']):false;
$dni = (isset($_POST['dni']) && $_POST['dni']!=NULL)?SanitizeVars::INT($_POST['dni']):false;
$domicilio = (isset($_POST['domicilio']) && $_POST['domicilio']!=NULL)?SanitizeVars::STRING($_POST['domicilio']):false;
$telefono_caracteristica = (isset($_POST['telefono_caracteristica']) && $_POST['telefono_caracteristica']!=NULL)?SanitizeVars::INT($_POST['telefono_caracteristica']):false;
$telefono_numero = (isset($_POST['telefono_numero']) && $_POST['telefono_numero']!=NULL)?SanitizeVars::INT($_POST['telefono_numero']):false;
$email = (isset($_POST['email']) && $_POST['email']!=NULL)?SanitizeVars::EMAIL($_POST['email']):false;
$localidad_id = (isset($_POST['localidad_id']) && $_POST['localidad_id']!=NULL)?SanitizeVars::INT($_POST['localidad_id']):false;
$fecha_nacimiento = (isset($_POST['fecha_nacimiento']) && $_POST['fecha_nacimiento']!=NULL)?SanitizeVars::DATE($_POST['fecha_nacimiento']):false;

//die($accion.'-'.$apellido.'-'.$nombres.'-'.$dni.'-'.$domicilio.'-'.$telefono_caracteristica.'-'.$telefono_numero.'-'.$email.'-'.$localidad_id.'-'.$fecha_nacimiento);

$array_resultados = array();

if ($accion=='editar') {
      $sql_persona = "UPDATE persona
              SET apellido ='$apellido', 
                  nombre = '$nombres',
                  fechaNacimiento = '$fecha_nacimiento',
                  idLocalidad = '$localidad_id',
                  domicilio = '$domicilio',
                  email = '$email',
                  telefono_caracteristica = '$telefono_caracteristica',
                  telefono_numero = '$telefono_numero'
              WHERE dni = $dni";
      //die($sql_persona);        
      $resultado_1 = mysqli_query($conex,$sql_persona);
      $filas_afectadas_1 = mysqli_affected_rows($conex);
      $sql_profesor = "UPDATE profesor
              SET apellido = '$apellido', 
                  nombre = '$nombres'
              WHERE dni = $dni";
      //die($sql_profesor);   
      $resultado_2 = mysqli_query($conex,$sql_profesor);
      $filas_afectadas_2 = mysqli_affected_rows($conex);           
      if ($filas_afectadas_1!=-1 && $filas_afectadas_2!=-1) {
         $array_resultados['codigo'] = 100;
         $array_resultados['mensaje'] = "Los datos del $entidad fueron Actualizados Exitosamente.";
      } else {
         $errorNro =  mysqli_errno($conex);
         $array_resultados['codigo'] = 12;
         $array_resultados['mensaje'] = "Hubo un Error en la Actualizacion de los datos del $entidad. ";
      }
} else if ($accion=='nuevo') {
      $sql_persona = "";
      if (existePersonaCreada($conex,$dni)) {
            $sql_persona = "UPDATE persona
                            SET apellido ='$apellido', 
                                nombre = '$nombres',
                                fechaNacimiento = '$fecha_nacimiento',
                                idLocalidad = '$localidad_id',
                                domicilio = '$domicilio',
                                email = '$email',
                                telefono_caracteristica = '$telefono_caracteristica',
                                telefono_numero = '$telefono_numero'
                            WHERE dni = $dni";
                            //die($sql_persona);
      } else {
            $sql_persona = "INSERT persona(dni,apellido,nombre,fechaNacimiento,nacionalidad,idLocalidad,domicilio,email,telefono_caracteristica,telefono_numero) VALUES
                       ('$dni','$apellido','$nombres','$fecha_nacimiento','Argentina',$localidad_id,'$domicilio','$email','$telefono_caracteristica','$telefono_numero')";
      };
      $resultado_1 = mysqli_query($conex,$sql_persona);
      $filas_afectadas_1 = mysqli_affected_rows($conex);
      $sql_profesor = "INSERT profesor(dni,apellido,nombre) VALUES('$dni','$apellido','$nombres')";
      $resultado_2 = mysqli_query($conex,$sql_profesor);
      $filas_afectadas_2 = mysqli_affected_rows($conex);  
      $sql_usuario = "INSERT usuario(dni,idtipo,pass) VALUES('$dni',2,'".md5($dni)."')";
      $resultado_3 = mysqli_query($conex,$sql_usuario);
      $filas_afectadas_3 = mysqli_affected_rows($conex);   

      //die( $sql_persona.'**'.$sql_profesor);
      if ($filas_afectadas_1>0 && $filas_afectadas_2>0 && $filas_afectadas_3>0) {
            $array_resultados['codigo'] = 100;
            $array_resultados['mensaje'] = "El $entidad <strong>$apellido, $nombres</strong> fueron creado Exitosamente.";
      } else {
            $errorNro =  mysqli_errno($conex);
            $array_resultados['codigo'] = 12;
            $array_resultados['mensaje'] = "Hubo un Error en la creación del $entidad. ";
      }  
};

echo json_encode($array_resultados);



?>
