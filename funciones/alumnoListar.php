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
            <th class="text-center text-primary" width="30%"><small><b><?=$campo2?></b></small></th>
            <th class="text-center text-primary" width="5%"><small><b><?=$campo3?></b></small></th>
            <th class="text-center text-primary" width="25%"><small><b><?=$campo4?></b></small></th>
            <th class="text-center text-primary" width="30%"><small><b><?=$campo5?></b></small></th>
          </tr>
          <tr>
            <th class="text-right" colspan=4>
                <button class="btn btn-primary" onclick="quitarFiltro()" title="Quitar Filtro"><img src="../public/img/icons/filterminus.png" width="22"></button>
                <button class="btn btn-primary" onclick="aplicarFiltro()" title="Aplicar Filtro"><img src="../public/img/icons/filter.png" width="22"></button>
              </th>
            <th class="text-center" width="15%"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo2?>" value="<?=$nombre?>"></b></small></th>
            <th class="text-center" width="9%"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo3?>" value="<?=$dni?>"></b></small></th>
            <th class="text-center" width="9%"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo4?>" value="<?=$telefono?>"></b></small></th>
            <th class="text-center" width="9%"><small><b><input type="text" class="form-control" id="inputFiltro<?=$campo5?>" value="<?=$email?>"></b></small></th>
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
				$rowIdCampo1 = $row['id'];
				$rowCampo2 = $row['apellido'].', '.$row['nombre'].' ('.$row['id'].')';
				$rowCampo3 = $row['dni'];
				$wsp = ($row['telefono_caracteristica']!=NULL && $row['telefono_numero']!=null)?'<a href="https://api.whatsapp.com/send/?phone=549'.$row['telefono_caracteristica'].$row['telefono_numero'].'&text=Hola&type=phone_number&app_absent=0" target="_blank"><img src="../public/img/icons/whatsapp.png" width="20"></a>&nbsp;':'';
				$rowCampo4 = ($row['telefono_caracteristica']!=NULL && $row['telefono_numero']!=null)?$wsp.' ('.$row['telefono_caracteristica'].') '.$row['telefono_numero']:'';
				$rowCampo5 = $row['email'];
				
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
                          <a class=" dropdown-item small" href="#" onclick="vincularCarrera('<?=$rowIdCampo1?>')"><i class="fa fa-graduation-cap"></i>&nbsp;Vincular Carrera</a>
                        </div>
                                    </div>
                  </td>
                  <td align="left"><small><?=$rowCampo2;?><small></td>
                  <td align="left"><small><?=$rowCampo3;?></small></td>
                  <td align="left"><small><?=$rowCampo4;?></small></td>
                  <td align="left"><small><a href="mailto:<?=$rowCampo5?>"><?=$rowCampo5;?></a></small></td>
              </tr>
		<?php 
				$finales++;
			};
		?>	  
        </tbody>
         <tfoot>
             <tr>
				<td colspan='8'>
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
				<tr><td colspan="6">
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
