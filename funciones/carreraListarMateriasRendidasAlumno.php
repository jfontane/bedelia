<?php
set_include_path('../../lib/'.PATH_SEPARATOR.'../../conexion/');

//require_once 'controlAcceso.php';
include_once 'conexion.php';
include_once 'Sanitize.class.php';
include_once 'pagination.php';
include_once 'ArrayHash.class.php';

//die(unserialize('a:1:{i:0;s:8:"empleado";}')[0]);

$rol_usuario = '';
//$rol_admin = ($_SESSION['user_rol']=='admin' || $_SESSION['user_rol']=='SYSTEM')?'':'disabledbutton';

$rol_admin = '';


/**********************************************************************************************************************************************************************/
/**************************************************************** RECIBIR PARAMETROS Y SANITIZARLOS *******************************************************************/
/**********************************************************************************************************************************************************************/

$action = (isset($_POST['action'])&& $_POST['action'] !=NULL)?$_POST['action']:'';
$idCarrera = isset($_POST['carrera_id'])?SanitizeVars::INT($_POST['carrera_id']):FALSE;
$idAlumno = isset($_POST['alumno_id'])?SanitizeVars::INT($_POST['alumno_id']):FALSE;
$hash = isset($_POST['hash'])?SanitizeVars::STRING($_POST['hash']):FALSE;

//die($action.'-'.$idCarrera.'-'.$idAlumno.'-'.$hash);

/**********************************************************************************************************************************************************************/
/**********************************************************************************************************************************************************************/
/**********************************************************************************************************************************************************************/

$andX = array();

$andX[] = " arm.idAlumno = $idAlumno ";
$andX[] = " arm.idMateria IN (SELECT idMateria FROM carrera_tiene_materia WHERE idCarrera = $idCarrera) ";
$andX[] = " arm.idMateria = m.id ";


$sql = $sqlCantidadFilas = "";

if($action == 'listar' && $idCarrera && ArrayHash::check($hash, array($MY_SECRET=>$idAlumno))){
	$tables = " alumno_rinde_materia arm, materia m  ";
	$campos = " arm.id, m.id as idMateria, m.nombre, m.anio,  arm.idCalendario, arm.llamado, arm.condicion, arm.nota, arm.estado_final ";

	/*if ($id) $andX[] = 'c.id = ' . $id;
	if ($anioLectivo) $andX[] = 'c.AnioLectivo = ' . $anioLectivo;
	if ($evento) $andX[] = "(e.descripcion like '%" . $evento ."%' or e.codigo='$evento')";
	if ($fechaInicio) $andX[] = "c.fechaInicioEvento like '" . $fechaInicio . "'";
	if ($fechaFinalizacion) $andX[] = "c.fechaFinalEvento like '" . $fechaFinalizacion . "'";*/

	if (count($andX)>0) $where = ' WHERE (' . implode(" and ",$andX) . ') ';
	else $where = '';
    
	$where = $where . " ORDER BY m.anio ASC ";
    $sql = "";

	if ($busqueda) 
	{
		/*$campos_nuevos = "  x.id, x.AnioLectivo, x.descripcion, x.fechaInicioEvento, x.fechaFinalEvento, x.codigo ";
		$subConsultaFiltros = "SELECT $campos FROM  $tables $where";
		//die($subConsultaFiltros);
		$sqlCantidadFilas =  "SELECT count(*) AS numrows FROM  ($subConsultaFiltros) x
							  WHERE (x.descripcion like '%$busqueda%' or x.codigo='$busqueda')";
		$sqlFinal =  "SELECT $campos_nuevos FROM  ($subConsultaFiltros) x 
		              WHERE (x.descripcion like '%$busqueda%' or x.codigo=$busqueda)";
		//die($sqlFinal);*/
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
	$labelCampo1 = "ID";$labelCampo2 = "MATERIA"; $labelCampo3 = "AÑO"; $labelCampo4 = "CALENDARIO"; 
	$labelCampo5 = "LLAMADO";$labelCampo6 = "CONDICIÓN";$labelCampo7 = "NOTA";$labelCampo8 = "ESTADO";
	$campo1 = "Id";$campo2 = "Materia"; $campo3 = "Anio"; $campo4 = "Calendario"; $campo5 = "LLamado";
	$campo6 = "Condicion";$campo7 = "Nota"; $campo8 = "Estado"; 
	//*********************************************************** */
	//*****
?>	

<div class="table-responsive" >
      <table class="table table-striped table-bordered table-hover bg2" id="tabla_calendario">
        <thead>
          <tr>
            <th class="text-left" colspan="13">
               <table class="table borderless" width="100%">
                  <tr>
                  <th class="text-left" colspan="5">
                    <button class="btn btn-primary rol_admin" onclick="entidadCrear()">Agregar</button>&nbsp;
                    <button class="btn btn-primary rol_admin" onclick="entidadEliminarSeleccionados()">Borrar Seleccionados</button>&nbsp;
                  </th>
                  <th class="text-right" colspan="7">
                      <div class="col-7">
                      <div class="input-group">
                        <input id="inputBusquedaRapida" placeholder="Busqueda Rapida" type="text" class="form-control" value="<?=$busqueda?>"> 
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
          <tr>
            <th class="text-center" width="5%"><small><b><input type="checkbox" class="" id="seleccionar_todos"></b></small></th>
            <th width="5%" class="text-center text-primary" colspan=3><small><b>ACCIONES</b><small></th>
            <th class="text-center text-primary" width="40%"><small><b><?=$labelCampo2?></b></small></th>
            <th class="text-center text-primary" width="5%"><small><b><?=$labelCampo3?></b></small></th>
            <th class="text-center text-primary" width="5%"><small><b><?=$labelCampo4?></b></small></th>
            <th class="text-center text-primary" width="5%"><small><b><?=$labelCampo5?></b></small></th>
			<th class="text-center text-primary" width="10%"><small><b><?=$labelCampo6?></b></small></th>
			<th class="text-center text-primary" width="10%"><small><b><?=$labelCampo7?></b></small></th>
			<th class="text-center text-primary" width="10%"><small><b><?=$labelCampo8?></b></small></th>
          </tr>
          <tr>
            <th class="text-right" colspan=4>
                <button class="btn btn-primary btn-sm" onclick="quitarFiltro()" title="Quitar Filtro"><img src="../public/img/icons/filterminus.png" width="22"></button>
                <button class="btn btn-primary btn-sm" onclick="aplicarFiltro()" title="Aplicar Filtro"><img src="../public/img/icons/filter.png" width="22"></button>
              </th>
			<th class="text-center"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo2?>" value="<?=$campo1?>"></b></small></th>
            <th class="text-center"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo3?>" value="<?=$campo1?>"></b></small></th>
            <th class="text-center"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo4?>" value="<?=$campo1?>"></b></small></th>
            <th class="text-center"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo5?>" value="<?=$campo1?>"></b></small></th>
			<th class="text-center"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo6?>" value="<?=$campo1?>"></b></small></th>
            <th class="text-center"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo7?>" value="<?=$campo1?>"></b></small></th>
            <th class="text-center"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo8?>" value="<?=$campo1?>"></b></small></th>
          </tr>
        </thead>
		<tbody>
<?php
if ($numrows>0){
	$finales = $c = 0;
	$pagina = (($page-1)*$per_page);
	while ($row=mysqli_fetch_assoc($query)) {
				$c++;
				$indice = $pagina + $c;
				$alumno_id_hash = $hash = ArrayHash::encode(array($MY_SECRET=>$row['id']));
				

				if ($row['nota']=='-1') {
					$nota = "---";
				} else if ($row['nota']=='0') {
					$nota = "...";
				} else {
					$nota = $row['nota'];
				}

				$rowIdCampo1 = $row['id'];
				$rowCampo2 = $row['nombre'].' <strong>('.$row['idMateria'].')</strong>';
				$rowCampo3 = $row['anio'];
				$rowCampo4 = $row['idCalendario'];
				$rowCampo5 = $row['llamado'];
				$rowCampo6 = $row['condicion'];
				$rowCampo7 = $nota;
				$rowCampo8 = $row['estado_final'];
?>						
       
            <tr>
                  <td align="center"><small><b><input type="checkbox" class=" check" id="check_<?=$rowIdCampo1?>" name="check_usu[]" value="<?=$rowIdCampo1?>"></b></small></td>
                      <td align="center" colspan="3">
                      <div class="btn-group pull-right" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a class=" dropdown-item small" href="#" onclick="entidadVer('<?=$rowIdCampo1?>')"><i class="fa fa-address-card-o"></i>&nbsp;Ver</a>
                          <a class=" dropdown-item small" href="#" onclick="entidadEditar('<?=$rowIdCampo1?>')"><i class="fa fa-edit"></i>&nbsp;Editar</a>
                          <a class=" dropdown-item small" href="#" data-toggle="modal" data-target="#confirmarModal" data-id="<?=$rowIdCampo1?>"><i class="fa fa-trash"></i>&nbsp;Borrar</a>
                          <a class=" dropdown-item small disabledbutton" href="#" onclick="enviarEmail('<?=$rowIdCampo1?>')"><i class="fa fa-envelope"></i>&nbsp;Enviar Email</a>
                        </div>
                        </div>
                  </td>
                  <td align="left"><small><?=$rowCampo2;?><small></td>
                  <td align="left"><small><?=$rowCampo3;?></small></td>
                  <td align="center"><small><?=$rowCampo4;?></small></td>
				  <td align="center"><small><?=$rowCampo5;?></small></td>
				  <td align="left"><small><?=$rowCampo6;?></small></td>
				  <td align="center"><small><?=$rowCampo7;?></small></td>
				  <td align="left"><small><?=$rowCampo8;?></small></td>
                  
              </tr>
		<?php 
				$finales++;
			};
		?>	  
        </tbody>
         <tfoot>
             <tr>
				<td colspan='11'> <!-- CANTIDAD DE COLUMNAS + 2 -->
					<?php
						$inicios=$offset+1;
						$finales+=$inicios-1;
						echo "<br>";
						echo "Mostrando <strong>$inicios</strong> al <strong>$finales</strong> de <strong>$numrows</strong> registros";
						echo "<br><p>";
						echo paginate($page, $total_pages, $adjacents);
					?>
			    </td>
			</tr>
        </tfoot>
        </table>
		<?php
			} else {
		?>
				<tbody>
				<tr><td colspan="9">
							  <div class="alert alert-exclamation" role="alert">
									<span style="color: #000000;">
										<i class="fa fa-info-circle" aria-hidden="true"></i>
										&nbsp;<strong>Atención:</strong> No existen Resultados.
									</span>
							   </div>
						  </td></tr>
				</tbody>
				</table>
		<?php		
			};
		};
		?>
    </div>
