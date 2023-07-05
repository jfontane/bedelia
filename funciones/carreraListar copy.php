<?php
set_include_path('../../lib/'.PATH_SEPARATOR.'../../conexion/');
//require_once 'seguridadNivel1.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';
include_once 'pagination.php';
include_once 'ArrayHash.class.php';

$action = (isset($_POST['action'])&& $_POST['action'] !=NULL)?$_POST['action']:'';
$sWhere = "";

if($action == 'listar'){
	$tables = " carrera c ";
	$campos = " c.id, c.codigo, c.descripcion, c.descripcion_corta, c.habilitada, c.imagen ";
 	$sWhere .= " ORDER BY c.codigo desc  ";
	//PAGINATION VARIABLES
	$page = ( isset($_REQUEST['page']) && !empty($_REQUEST['page']) )?$_REQUEST['page']:1;
	$per_page = ( isset($_REQUEST['per_page']) && ($_REQUEST['per_page']>0) )?$_REQUEST['per_page']:10; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
    $sql = "SELECT count(*) AS numrows FROM $tables $sWhere "; 
	$count_query = mysqli_query($conex,$sql);
	if ($row = mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
	$total_pages = ceil($numrows/$per_page);
	//main query to fetch the data
	$sql_2 = "SELECT $campos FROM  $tables $sWhere LIMIT $offset,$per_page";
	$query = mysqli_query($conex,$sql_2);
	//loop through fetched data
	if ($numrows>0){
		$c=0;
			echo '<div class="table-responsive" ">
				<table class="table table-striped table-bordered table-hover" id="tabla_calendario">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="5%">#</th>
							<th class="text-center" width="5%"><small><b>CÓDIGO</b></small></th>
							<th class="text-center" width="50%"><small><b>DESCRIPCIÓN</b></small></th>
							<th class="text-center" width="5%"><small><b>HABILITADA</b></small></th>
							<th width="10%"><small><b>ACCIONES</b></small></th>
						</tr>
					</thead>';
		echo '<tbody>';
		$finales=0;
		$c=0;
		$pagina = (($page-1)*$per_page);
	    //$tipo_organismo = substr($_SESSION['organismo_codigo'],0,1);
    while ($row=mysqli_fetch_assoc($query)) {
        	$c++;
			$indice = $pagina + $c;
			
			$carrera_id_hash = $hash = ArrayHash::encode(array($MY_SECRET=>$row['id']));
			
			$espacio = "&nbsp;";
			
			$accion_editar = '<a href="#" class="disabledbutton" onclick="carreraEditar('.$row['id'].')" ><img src="../public/img/icons/edit_icon.png" width="20"></a>';
			$accion_eliminar = '<a href="#" onclick="carreraEliminar('.$row['id'].')" ><img src="../public/img/icons/delete_icon.png" width="17"></a>';
			$accion_ver_alumnos = '<a href="menuCarreraAlumnos.php?id='.$row['id'].'&hash='.$carrera_id_hash.'" title="Ver Alumnos"><img src="../public/img/icons/student_icon.png" width="24"></a>';
			
			/*$hash = ArrayHash::encode(array($secreto=>$row['id']));*/
        	echo '<tr>';
			echo '   <td align="center"><b>'.$indice.'</b></td>'.
			     '   <td align="center"><small>'.$row['codigo'].'</small></td>'.
				 '   <td align="left"><small>'.$row['descripcion'].'&nbsp;<b>('.$row['codigo'].')</b></small></td>'.
				 '   <td align="right"><small>'.$row['habilitada'].'</small></td>'.
				 '   <td align="left" class="text-left"><small>'.$accion_editar.$espacio.$accion_ver_alumnos.'</small></td>';
			echo '</tr>';
        $finales++;
    };
	echo "</tbody><tfoot><tr><td colspan='7'>";
	$inicios=$offset+1;
	$finales+=$inicios-1;
	echo "<br>";
	echo "Mostrando <strong>$inicios</strong> al <strong>$finales</strong> de <strong>$numrows</strong> registros";
	echo "<br><p>";
	echo paginate($page, $total_pages, $adjacents);
	echo "</td></tr>";
    echo '</tfoot>';
	echo '</table>';
} else {
	echo '<table class="table">';
	echo '<tbody>';
	echo '<tr><td><div class="alert alert-danger" role="alert">
				 <b>Atenci&oacute;n:</b> No existen Eventos en el calendario.
			 </div></td></tr>';
	echo '</tbody>';
	echo '</table>';
};
};

?>
