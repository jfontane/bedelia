<?php
set_include_path('../../lib/'.PATH_SEPARATOR.'../../conexion/');

//require_once 'controlAcceso.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';
include_once 'pagination.php';
//include_once 'ArrayHash.class.php';

//die(unserialize('a:1:{i:0;s:8:"empleado";}')[0]);

$rol_usuario = '';
//$rol_admin = ($_SESSION['user_rol']=='admin' || $_SESSION['user_rol']=='SYSTEM')?'':'disabledbutton';

$rol_admin = '';


/**********************************************************************************************************************************************************************/
/**************************************************************** RECIBIR PARAMETROS Y SANITIZARLOS *******************************************************************/
/**********************************************************************************************************************************************************************/

$action = (isset($_POST['action'])&& $_POST['action'] !=NULL)?$_POST['action']:'';
$busqueda = isset($_POST['busqueda_rapida'])?$_POST['busqueda_rapida']:false;

$nombre = isset($_POST['nombre'])?SanitizeVars::APELLIDONOMBRES($_POST['nombre']):false;
$dni = isset($_POST['dni'])?$_POST['dni']:false;
$telefono = isset($_POST['telefono'])?$_POST['telefono']:false;
$email = isset($_POST['email'])?$_POST['email']:false;


/**********************************************************************************************************************************************************************/
/**********************************************************************************************************************************************************************/
/**********************************************************************************************************************************************************************/

$andX = array();
$orX = array();

$andX[] = "a.dni = per.dni";

$sql = $sqlCantidadFilas = "";

if($action == 'listar'){
	$tables = " alumno a, persona per ";
	$campos = " a.id, a.dni, a.apellido, a.nombre, per.telefono, per.telefono_caracteristica, per.telefono_numero, per.email ";
    if ($nombre) $andX[] = '(a.apellido like "%' . $nombre . '%" or a.nombre like "%' . $nombre . '%")';  
	if ($dni) $andX[] = 'per.dni like "%' . $dni . '%"';
	if ($telefono) $andX[] = 'per.telefono like "%' . $telefono . '%"';
	if ($email) $andX[] = 'per.email like "%' . $email . '%"';
	if (count($andX)>0) $where = ' WHERE (' . implode(" and ",$andX) . ') ';
	else $where = '';
    
	$where = $where . " ORDER BY a.id asc ";
    $sql = "";

	if ($busqueda) 
	{
		$campos_nuevos = "  x.id, x.dni, x.apellido, x.nombre, x.telefono, x.telefono_caracteristica, x.telefono_numero, x.email ";
		$subConsultaFiltros = "SELECT $campos FROM  $tables $where";
		//die($subConsultaFiltros);
		$sqlCantidadFilas =  "SELECT count(*) AS numrows FROM  ($subConsultaFiltros) x
							  WHERE (x.apellido like '%$busqueda%' or 
									 x.nombre like '%$busqueda%' or 
									 x.dni like '%$busqueda%' or
									 x.email like '%$busqueda%')";
		$sqlFinal =  "SELECT $campos_nuevos FROM  ($subConsultaFiltros) x 
		              WHERE (x.apellido like '%$busqueda%' or 
							 x.nombre like '%$busqueda%' or 
							 x.dni like '%$busqueda%' or
							 x.email like '%$busqueda%')";
		//die($sqlFinal);
	} else {
		$sqlCantidadFilas = "SELECT count(*) AS numrows FROM $tables $where "; 
		$sqlFinal = "SELECT $campos FROM  $tables $where";
		//die("".$sqlFinal);
	}


	//PAGINATION VARIABLES
	$page = ( isset($_REQUEST['page']) && !empty($_REQUEST['page']) )?$_REQUEST['page']:1;
	$per_page = ( isset($_REQUEST['per_page']) && ($_REQUEST['per_page']>0) )?$_REQUEST['per_page']:1; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
   
	//die($sqlCantidadFilas);
	$count_query = mysqli_query($conex,$sqlCantidadFilas);
	if ($row = mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
	$total_pages = ceil($numrows/$per_page);
	//main query to fetch the data
	$sqlFinal .=  " LIMIT $offset,$per_page ";
	//die($sqlFinal);
	$query = mysqli_query($conex,$sqlFinal);

	//*********************************************************** */
	//****************  PONER LOS NOMBRES DE LOS CAMPOS ********* */
	//*********************************************************** */
	$campo1 = "Id";$campo2 = "Nombres"; $campo3 = "Dni"; $campo4 = "Telefono"; $campo5 = "Email"; 
	//*********************************************************** */
	//*********************************************************** */
	
	echo '<div class="table-responsive">
				<table class="table-bordered table-hover border border-dark" id="tabla_calendario">
					<thead>
						<tr class="table-muted">
							<th class="text-left" colspan="13" >
							   <table width="100%">
							 	   <tr class="table-light">
										<th class="text-left" colspan="5">
											<button class="btn btn-primary '.$rol_admin.'" onclick="entidadCrear()">Agregar</button>&nbsp;
											<button class="btn btn-primary '.$rol_admin.'" onclick="entidadEliminarSeleccionados()">Borrar Seleccionados</button>&nbsp;
										</th>
										<th class="text-right" colspan="7">
												<div class="col-7">
												<div class="input-group">
													<input id="inputBusquedaRapida" placeholder="Busqueda Rapida" type="text" class="form-control" value="'.$busqueda.'"> 
													<div class="input-group-append">
													<div class="input-group-text">
														<a href="#" onclick="aplicarBusquedaRapida()"><i class="fa fa-search"></i></a>
													</div>
													</div>
												</div>
												</div>
									    </th>
									</tr>  
							   </table>
							</th>
        				</tr>
						<tr class="table-danger">
							<th class="text-center" width="5%"><small><b><input type="checkbox" class="'.$rol_admin.'" id="seleccionar_todos"></b></small></th>
							<th width="5%" class="text-center text-primary" colspan=3><small><b></b><small></th>
							<th class="text-center text-dark" width="30%"><small><b>'.strtoupper($campo2).'</b></small></th>
							<th class="text-center text-dark" width="10%"><small><b>'.strtoupper($campo3).'</b></small></th>
							<th class="text-center text-dark" width="15%"><small><b>'.strtoupper($campo4).'</b></small></th>
							<th class="text-center text-dark" width="25%"><small><b>'.strtoupper($campo5).'</b></small></th>
						</tr>';
	//-- FILTROS --
	echo '<tr class="table-success">
							<th class="text-right"  style="padding: 7px;" colspan=4>
							        <button class="btn btn-primary btn-sm" onclick="quitarFiltro()" title="Quitar Filtro"><img src="../public/img/icons/filterminus.png" width="22"></button>
									<button class="btn btn-primary btn-sm" onclick="aplicarFiltro()" title="Aplicar Filtro"><img src="../public/img/icons/filter.png" width="22"></button>
						    </th>
							<th class="text-center" width="15%" style="padding: 7px;"><small><b><input type="text" class="form-control" id="inputFiltro'.$campo2.'" value="'.$nombre.'" autocomplete="off"></b></small></th>
							<th class="text-center" width="12%" style="padding: 7px;"><small><b><input type="text" class="form-control" id="inputFiltro'.$campo3.'" value="'.$dni.'" autocomplete="off" maxlength=8></b></small></th>
							<th class="text-center" width="12%" style="padding: 7px;"><small><b><input type="text" class="form-control" id="inputFiltro'.$campo4.'" value="'.$telefono.'" autocomplete="off"></b></small></th>
							<th class="text-center" width="9%" style="padding: 7px;"><small><b><input type="text" class="form-control" id="inputFiltro'.$campo5.'" value="'.$email.'" autocomplete="off"></b></small></th>
						</tr>';
	echo '</thead>';
			
	if ($numrows>0){
			$finales = $c = 0;
			$pagina = (($page-1)*$per_page);

			//$tipo_organismo = substr($_SESSION['organismo_codigo'],0,1);
			echo '<tbody>';
			while ($row=mysqli_fetch_assoc($query)) {
						$c++;
						$indice = $pagina + $c;
						$rowIdCampo1 = $row['id'];
						$rowCampo2 = $row['apellido'].', '.$row['nombre'];
						$rowCampo3 = $row['dni'];
						$rowCampo4 = $row['telefono'];
						$rowCampo5 = $row['email'];
						$wsp = '';
						if ($row['telefono_caracteristica']!="" && $row['telefono_numero']!="") {
							$wsp = '<a href="https://api.whatsapp.com/send/?phone=549'.$row['telefono_caracteristica'].$row['telefono_numero'].'&text=Hola&type=phone_number&app_absent=0" target="_blank"><img src="../public/img/icons/wsp_icon.png" width="25"></a>';
						}

						echo '<tr class="table-primary">';
						echo '   <td align="center"><small><b><input type="checkbox" class="'.$rol_admin.' check" id="check_'.$rowIdCampo1.'" name="check_usu[]" value="'.$rowIdCampo1.'"></b></small></td>'.
							 '   <td align="center" colspan="3" style="padding: 6px;">
							 		<div class="btn-group pull-right" role="group">
										<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Acciones
										</button>
										<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
											<a class="'.$rol_usuario.'dropdown-item small" href="#" onclick="entidadVer('.$rowIdCampo1.')"><i class="fa fa-address-card-o"></i>&nbsp;Ver</a>
											<a class="'.$rol_usuario.' dropdown-item small" href="#" onclick="entidadEditar('.$rowIdCampo1.')"><i class="fa fa-edit"></i>&nbsp;Editar</a>
											<a class="'.$rol_admin.' dropdown-item small" href="#" data-toggle="modal" data-target="#confirmarModal" data-id="'.$rowIdCampo1.'"><i class="fa fa-trash"></i>&nbsp;Borrar</a>
											<a class="'.$rol_admin.' dropdown-item small" href="#" onclick="enviarEmail(\''.$rowIdCampo1.'\')"><i class="fa fa-envelope"></i>&nbsp;Enviar Email</a>
										</div>
                             		</div>
							 </td>'.
							 '   <td align="left" style="padding: 6px;"><small>'.$rowCampo2.'<small></td>'.
							 '   <td align="center" style="padding: 6px;"><small>'.$rowCampo3.'</small></td>'.
							 '   <td align="left" style="padding: 6px;"><small>'.$wsp.'&nbsp;('.$row['telefono_caracteristica'].') '.$row['telefono_numero'].'</small></td>'.
							 '   <td align="left" style="padding: 6px;"><small><a href="mailto:'.$rowCampo5.'">'.$rowCampo5.'</a></small></td>';
						echo '</tr>';
					$finales++;
			};
			echo "</tbody><tfoot><tr><td colspan='13'>";
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
	echo '<tbody>';
	echo '<tr><td colspan="13">
	              <div class="alert alert-exclamation" role="alert">
				        <span style="color: #000000;">
				            <i class="fa fa-info-circle" aria-hidden="true"></i>
						    &nbsp;<strong>Atención:</strong> No existen Resultados.
					    </span>
			       </div>
			  </td></tr>';
	echo '</tbody>';
	echo '</table>';
};
};

?>
