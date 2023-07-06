<?php
set_include_path('../../conexion'.PATH_SEPARATOR.'../../lib');
//include_once 'controlAcceso.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';

$array_resultados = array();
$search = (isset($_GET['searchTerm']))?$_GET['searchTerm']:false;
$json = [];
if($search) {
        $sql = "SELECT c.id, c.descripcion, c.codigo
                FROM carrera c
                WHERE (c.codigo like '%$search%' or c.descripcion like '%$search%') and c.habilitada = 'Si'";       
        //die($sql);         
        $resultado = mysqli_query($conex,$sql);
        if (mysqli_num_rows($resultado)>0) {
                while($row = mysqli_fetch_assoc($resultado)){
                        $json[] = ['id'=>$row['id'], 'text'=>$row['descripcion'].' ('.$row['codigo'].')'];
                }
        };
} else {
        $json = [];   
}
echo json_encode($json);

?>
