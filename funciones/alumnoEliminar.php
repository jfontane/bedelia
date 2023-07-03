<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'seguridadNivel2.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';
ini_set("default_charset", "UTF-8");
mb_internal_encoding("UTF-8");

/**********************************************************************************************************************************************************************/
/**************************************************************** RECIBIR PARAMETROS Y SANITIZARLOS *******************************************************************/
/**********************************************************************************************************************************************************************/

$entidades_a_eliminar = ( isset($_POST['id']) && $_POST['id']!="" )?$_POST['id']:false;
/**********************************************************************************************************************************************************************/
/**********************************************************************************************************************************************************************/
/**********************************************************************************************************************************************************************/

$array_resultados = array();

if ($entidades_a_eliminar) {
      //die('entrooo');
      $arreglo_entidades = explode(',',$entidades_a_eliminar);
      $cantidad_entidades = count($arreglo_entidades);
      $errorNro = 0;  
      $msg = "";
      db_start_trans($conex);     
      foreach($arreglo_entidades as $idEntidad) {
            $sql = "select dni FROM alumno WHERE id=$idEntidad";
            $res_dni = @mysqli_query($conex,$sql);
            $fila = mysqli_fetch_assoc($res_dni);
                  
            $sql_pertenece_carrera = "DELETE FROM alumno_estudia_carrera
            WHERE idAlumno = $idEntidad";     
            mysqli_query($conex,$sql_pertenece_carrera);
            //die($sql_pertenece_carrera);   
            $sql_rinde_materias = "DELETE FROM alumno_rinde_materia
                                   WHERE idAlumno = $idEntidad";      
            mysqli_query($conex,$sql_rinde_materias);                       
            die($sql_rinde_materias);                                                               
            $sql_cursa_materias = "DELETE FROM alumno_cursa_materia
                                   WHERE idAlumno = $idEntidad";
            mysqli_query($conex,$sql_cursa_materias);                       
            //die($sql_cursa_materias);    
            $sql_usuario = "DELETE FROM usuario
                            WHERE dni =".$fila['dni']."";                       
            //die($sql_usuario); 
            $sql_alumno = "DELETE FROM alumno
            WHERE id = $idEntidad";
            //die($sql_alumno);        
            $sql_persona = "DELETE FROM persona
                    WHERE dni=".$fila['dni']."";
            //die($sql_persona);
            /** SE INICIA LA TRANSACCION **/
           

            mysqli_query($conex,$sql_cursa_materias);
           
            mysqli_query($conex,$sql_usuario);
            $ok_alumno = mysqli_query($conex,$sql_alumno);
            mysqli_query($conex,$sql_persona);
            //PRENGUNTAMOS SI HUBO ERROR
            $errorNro =  mysqli_errno($conex);
            if(!$ok_alumno){
                  db_rollback($conex);
                  break;
            }; 
      } // END FOR

      if ($errorNro) {
            if ($cantidad_entidades>1) {
                  $msg = "Hubo un Error en la Eliminación de los Alumnos. ";
            } else {
                  $msg = "Hubo un Error en la Eliminaciòn del Alumno. Tiene Registros Vinculados.";
            }
            $array_resultados['codigo'] = 10;
            $array_resultados['mensaje'] = $msg;  
      } else {
            db_commit($conex);
            if ($cantidad_entidades>1) {
                  $msg = "La Eliminación de los Alumnos fue exitosa.";
            } else {
                  $msg = "La Eliminación del Alumno fue exitosa.";
            }
            $array_resultados['codigo'] = 100;
            $array_resultados['mensaje'] = $msg;
      };
};

echo json_encode($array_resultados);



?>
