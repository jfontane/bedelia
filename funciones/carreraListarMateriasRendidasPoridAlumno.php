<?php
set_include_path('../../lib/'.PATH_SEPARATOR.'../../conexion/');
//require_once 'seguridadNivel1.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';
include_once 'pagination.php';
include_once 'ArrayHash.class.php';

$action = (isset($_POST['action'])&& $_POST['action'] !=NULL)?$_POST['action']:'';
$idCarrera = isset($_POST['carrera_id'])?SanitizeVars::INT($_POST['carrera_id']):FALSE;
$idAlumno = isset($_POST['alumno_id'])?SanitizeVars::INT($_POST['alumno_id']):FALSE;
$hash = isset($_POST['hash'])?SanitizeVars::STRING($_POST['hash']):FALSE;

$sWhere = "";
$where = array();

$where[] = " arm.idAlumno = $idAlumno ";
$where[] = " arm.idMateria IN (SELECT idMateria FROM carrera_tiene_materia WHERE idCarrera = $idCarrera) ";
$where[] = " arm.idMateria = m.id ";

//SELECT * FROM alumno_rinde_materia arm 
//WHERE arm.idAlumno = 635 and arm.idMateria IN (SELECT idMateria FROM carrera_tiene_materia WHERE idCarrera = 15);

if($action == 'listar' && $idCarrera && ArrayHash::check($hash, array($MY_SECRET=>$idAlumno))){

	$tables = " alumno_rinde_materia arm, materia m  ";
	$campos = " arm.id, m.id as idMateria, m.nombre, m.anio,  arm.idCalendario, arm.llamado, arm.condicion, arm.nota, arm.estado_final ";
		
	if (count($where)>0) $sWhere =' WHERE ' . implode(" and ",$where);
	
	$sWhere .= "ORDER BY m.anio ASC,m.nombre ASC,arm.idCalendario ASC,arm.llamado ASC ";
    

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
	//die($sql_2);
	$query = mysqli_query($conex,$sql_2);
	//loop through fetched data
	if ($numrows>0){
		$c=0;
			echo '<div class="table-responsive" ">
				<table class="table table-striped table-bordered table-hover" id="tabla_calendario">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="5%">#</th>
							<th class="text-center" width="35%"><small><b>MATERIA</b><small></th>
							<th class="text-center" width="8%"><small><b>AÑO</b><small></th>
							<th class="text-center" width="8%"><small><b>CALENDARIO</b><small></th>
							<th class="text-center" width="10%"><small><b>LLAMADO</b><small></th>
							<th class="text-center" width="10%"><small><b>CONDICIÓN</b><small></th>
							<th class="text-center" width="7%"><small><b>NOTA</b><small></th>
							<th class="text-center" width="10%"><small><b>ESTADO</b><small></th>
							<th width="25%" class="text-center"><small><b>ACCIONES</b><small></th>
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
			$alumno_id_hash = $hash = ArrayHash::encode(array($MY_SECRET=>$row['id']));
			$espacio = "&nbsp;";
			//$accion_editar = '<a href="#" onclick="carreraEditar('.$row['id'].')" title="Editar"><img src="../public/img/icons/edit_icon.png" width="20"></a>';
			$accion_editar = '<a href="#" onclick="rendidasEditar(\''.$idAlumno.'&'.$row['idMateria'].'&'.$row['nombre'].'&'.$row['idCalendario'].'&'.$row['llamado'].'&'.$row['nota'].'&'.$row['estado_final'].'&'.$row['condicion'].'\')" title="Editar"><img src="../public/img/icons/edit_icon.png" width="20"></a>';
			$accion_eliminar = '<a href="#" onclick="carreraEliminar('.$row['id'].')" title="Eliminar"><img src="../public/img/icons/delete_icon.png" width="17"></a>';
			$nota = "";
			if ($row['nota']=='-1') {
				$nota = "---";
			} else if ($row['nota']=='0') {
				$nota = "...";
			} else {
				$nota = $row['nota'];
			}
			/*$hash = ArrayHash::encode(array($secreto=>$row['id']));*/
        	echo '<tr>';
			echo '   <td align="center">'.'<b>'.$indice.'</b></td>'.
				 '   <td align="left"><small>'.$row['nombre'].'&nbsp;<b>('.$row['idMateria'].')</b></small></td>'.
				 '   <td align="right"><small>'.$row['anio'].'</small></td>'.
				 '   <td align="right"><small>'.$row['idCalendario'].'</small></td>'.
				 '   <td align="right"><small>'.$row['llamado'].'</small></td>'.
				 '   <td align="right"><small>'.$row['condicion'].'</small></td>'.
				 '   <td align="right"><small>'.$nota.'</small></td>'.
				 '   <td align="right"><small>'.$row['estado_final'].'</small></td>'.
				 '   <td align="left" class="text-center"><small>'.$accion_eliminar.$espacio.$accion_editar.$espacio.'</small></td>';
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
