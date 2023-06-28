<?php
set_include_path('../../lib/'.PATH_SEPARATOR.'../../conexion/');
//require_once 'seguridadNivel1.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';
include_once 'pagination.php';
//include_once 'ArrayHash.class.php';

$action = (isset($_POST['action'])&& $_POST['action'] !=NULL)?$_POST['action']:'';
$sWhere = "";
$where = array();
$where[] = " c.idEvento = e.id ";
if($action == 'listar'){
	$tables = " calendarioacademico c, evento e ";
	$campos = " c.id, c.AnioLectivo, e.descripcion, c.fechaInicioEvento, c.fechaFinalEvento, e.codigo ";
	$codigo = ( isset($_POST['codigo']) && ($_POST['codigo']) )?($_POST['codigo']):false;
	$anioLectivo = ( isset($_POST['anio']) && ($_POST['anio']) )?($_POST['anio']):false;
    //die('DFDFDFDFjavier'.$anioLectivo.'-'.$codigo);
	if ($codigo) $where[] = 'e.codigo = ' . $codigo;
	if ($anioLectivo) $where[] = 'c.AnioLectivo = ' . $anioLectivo;

    if (count($where)>0) $sWhere =' WHERE ' . implode(" and ",$where);
 	$sWhere .= " ORDER BY c.AnioLectivo desc, c.fechaInicioEvento desc ";

	//PAGINATION VARIABLES
	$page = ( isset($_REQUEST['page']) && !empty($_REQUEST['page']) )?$_REQUEST['page']:1;
	$per_page = ( isset($_REQUEST['per_page']) && ($_REQUEST['per_page']>0) )?$_REQUEST['per_page']:1; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
    $sql = "SELECT count(*) AS numrows FROM $tables $sWhere "; 
	//die($sql);
	$count_query = mysqli_query($conex,$sql);
	if ($row = mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
	$total_pages = ceil($numrows/$per_page);
	//main query to fetch the data
	$sql_2 = "SELECT $campos FROM  $tables $sWhere LIMIT $offset,$per_page";
	//die($sql_2);
	$query = mysqli_query($conex,$sql_2);

	//loop through fetched data
	if ($numrows>0){
		
		$c=0;
			echo '<div class="table-responsive" ">
				<table class="table table-striped table-bordered table-hover" id="tabla_calendario">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="12%">#</th>
							<th class="text-center" width="10%">ID</th>
							<th class="text-center" width="10%"><small><b>AÑO</b></small></th>
							<th class="text-center" width="50%"><small><b>EVENTO</b></small></th>
							<th class="text-center" width="9%"><small><b>F.INICIO</b></small></th>
							<th class="text-center" width="9%"><small><b>F.FINALIZACION</b></small></th>
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
			$espacio = "&nbsp;";
			$accion_editar = '<a href="#" onclick="calendarioEditar('.$row['id'].')" ><img src="../public/assets/img/icons/edit_icon.png" width="20"></a>';
			$accion_eliminar = '<a href="#" onclick="calendarioEliminar('.$row['id'].')" ><img src="../public/assets/img/icons/delete_icon.png" width="17"></a>';
			
			/*$hash = ArrayHash::encode(array($secreto=>$row['id']));*/
        	echo '<tr>';
			echo '   <td align="center">'.$espacio.$accion_eliminar.$espacio.'<b>'.$indice.'</b></td>'.'<td align="center">'.$row['id'].'</td>'.
			     '   <td align="center"><small>'.$row['AnioLectivo'].'</small></td>'.
				 '   <td align="left"><small>'.$row['descripcion'].'&nbsp;<b>('.$row['codigo'].')</b></small></td>'.
				 '   <td align="right"><small>'.$row['fechaInicioEvento'].'</small></td>'.
				 '   <td align="right"><small>'.$row['fechaFinalEvento'].'</small></td>'.
				 '   <td align="left" class="text-left"><small>'.$accion_editar.'</small></td>';
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
