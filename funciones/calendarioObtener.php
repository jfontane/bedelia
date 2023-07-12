<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'controlAcceso.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$array_resultados = array();
$search = (isset($_GET['searchTerm']))?$_GET['searchTerm']:false;
$json = [];
if($search) {
        $sql = "SELECT c.id, c.AnioLectivo, c.fechaInicioEvento, c.fechaFinalEvento, c.idEvento, c.idPeriodoCuatrimestreActivo, e.descripcion, e.codigo
                FROM calendarioacademico c, (SELECT * FROM `evento` WHERE codigo=1000 or codigo=1005 or codigo=1006 or codigo=1007 or codigo=1008) e
                WHERE (c.idEvento = e.id) and 
                      (e.codigo like '%$search%' or e.descripcion like '%$search%' or c.AnioLectivo like '%$search%')"; 

        //die($sql);         
        $resultado = mysqli_query($conex,$sql);
        if (mysqli_num_rows($resultado)>0) {
                while($row = mysqli_fetch_assoc($resultado)){
                        $json[] = ['id'=>$row['id'], 'text'=>$row['AnioLectivo'].' - '.$row['descripcion'].' ('.$row['codigo'].')'];
                }
        };
} else {
        $json = [];   
}
echo json_encode($json);

?>
