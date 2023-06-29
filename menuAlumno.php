<?php 
require_once('seguridad.php');
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SiGeAl - Bedelia</title>
   <?php include_once('componente_header.html'); ?>
   <?php include("componente_script_jquery.html"); ?>
  
  
    <style>
    .dropdown-item:hover{
          background-color: #CFC290;
        }        
     footer.nb-footer {
        background: #222;
        border-top: 4px solid #b78c33; }
    footer.nb-footer .about {
        margin: 0 auto;
        margin-top: 30px;
        max-width: 1170px;
        text-align: center; }
    footer.nb-footer .about p {
        font-size: 13px;
        color: #999;
        margin-top: 30px; }
    footer.nb-footer .about .social-media {
        margin-top: 15px; }
    footer.nb-footer .about .social-media ul li a {
        display: inline-block;
        width: 45px;
        height: 45px;
        line-height: 45px;
        border-radius: 50%;
        font-size: 16px;
        color: #b78c33;
        border: 1px solid rgba(255, 255, 255, 0.3); }
    footer.nb-footer .about .social-media ul li a:hover {
        background: #b78c33;
        color: #fff;
        border-color: #b78c33; }
    footer.nb-footer .footer-info-single {
        margin-top: 30px; }
    footer.nb-footer .footer-info-single .title {
        color: #aaa;
        text-transform: uppercase;
        font-size: 16px;
        border-left: 4px solid #b78c33;
        padding-left: 5px; }
    footer.nb-footer .footer-info-single ul li a {
        display: block;
        color: #aaa;
        padding: 2px 0; }
    footer.nb-footer .footer-info-single ul li a:hover {
        color: #b78c33; }
    footer.nb-footer .footer-info-single p {
        font-size: 13px;
        line-height: 20px;
        color: #aaa; }
    footer.nb-footer .copyright {
        margin-top: 15px;
        background: #111;
        padding: 7px 0;
        color: #999; }
    footer.nb-footer .copyright p {
        margin: 0;
        padding: 0; }
    .thead-green {
        background-color: rgb(0, 99, 71);
        color: white;
    }
    .disabledbutton {
          pointer-events: none;
          opacity: 0.5;
      }

    .select2-container {
          border: 1px solid black;
          border-radius: 2px;
          height: 36px !important;
    }; 

    .select2-container:focus {
        border-color: rgba(126, 239, 104, 0.8);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(126, 239, 104, 0.6);
        outline: 0 none;
    }
    
    .input-form {
          border: 1px solid black;
          border-radius: 2px;
          height: 36px !important;
    }
    
    
   </style>    
</head>
<body>
 

 
 <!-- NAVBAR -->
 <header>
    <?php include("componente_navbar.php"); ?>
  </header>

<article>
    <div id="breadcrumb">
      <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb">
              <li class="breadcrumb-item" aria-current="page"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Carreras</li>
          </ol>
      </nav>
    </div>
</article>

<article class="container-fluid">
    <div id="titulo"></div>
</article>
  
<article  class="container">
    <section id="principal">
    </section>  
    <section id="resultado_accion">
    </section>         
</article>
  

<!-- FOOTER -->
<?php include("componente_footer.html"); ?>

<!-- JAVASCRIPT CUSTOM -->
<script src="./js/funciones.js"></script>
<script>

function valideKeySoloNumerosSinPrimerCero(evt,val){
    var inputValue = val;
    //alert(val);
    // Verificar si el primer carácter es cero
    if (inputValue.length === 0 && evt.which === 48) {
        evt.preventDefault();
        return false;
    }
    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { // backspace.
      return true;
    } else if(code>=48 && code<=57 && inputValue.charAt(0)!== '0') { // is a number.
      return true;
    } else{ // other keys.
      return false;
    }
}

function valideKeySoloNumeros(evt){
    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { // backspace.
      return true;
    } else if(code>=48 && code<=57) { // is a number.
      return true;
    } else{ // other keys.
      return false;
    }
}
   
   
   
   
//************************************************************************************************ */
//************************************************************************************************ */
//*********************************** LISTADO DE ENTIDADES *************************************** */
//************************************************************************************************ */
//************************************************************************************************ */
let entidad_nombre = "alumno";
let entidad_titulo1 = "ALUMNOS";
let entidad_titulo2 = "Alumnos";
let campo1 = "Id";
let campo2 = "Dni";
let campo3 = "Apellido";
let campo4 = "Nombre";
let campo5 = "Telefono";
let campo6 = "Email";

$(function () {
    load(1);
});
  
//****************************************** */
// CARGA EL LISTADO DE TODOS LAS ENTIDADES   */
//****************************************** */
function load(page) {
    let nombre = $("#inputFiltroNombres").val();
    let dni = $("#inputFiltroDni").val();
    let telefono = $("#inputFiltroTelefono").val();
    let email = $("#inputFiltroEmail").val();
    let busqueda = $("#inputBusquedaRapida").val();
    let per_page = 10;
    let parametros = {"action": "listar","page": page,"per_page": per_page, "nombre":nombre, "dni":dni, "telefono":telefono, "email":email, "busqueda_rapida":busqueda};
    let titulo = "<h1><i><u>Alumnos</u></i></h1>";
    let breadcrumb = `<nav aria-label="breadcrumb" role="navigation">
                              <ol class="breadcrumb">
                                  <li class="breadcrumb-item" aria-current="page"><a href="home.php">Home</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">`+entidad_titulo2+`</li>
                              </ol>
                          </nav>`;
  
    $("#titulo").html(titulo);
    $("#breadcrumb").html(breadcrumb);
    $.ajax({
            url: 'funciones/'+entidad_nombre+'Listar.php',
            data: parametros,
            method: 'POST',
            beforeSend: function () {
              //$("#resultado").html("<img src='../assets/img/load_icon.gif' width='50' >");  
            },
            success: function (data) {
                $("#principal").slideDown("slow").html(data);
            }
    });
};
  

//************************************************************************************************ 
//************************************************************************************************ 
//************************************* GESTION DE  FILTROS  ************************************* 
//************************************************************************************************ 
//************************************************************************************************ 

//********************************************* 
// APLICA EL FILTRO AL LISTADO DE ENTIDADES     
//********************************************* 

  function aplicarFiltro() {
    let nombre = $("#inputFiltroNombres").val();
    let dni = $("#inputFiltroDni").val();
    let telefono = $("#inputFiltroTelefono").val();
    let email = $("#inputFiltroEmail").val();
    let busqueda = $("#inputBusquedaRapida").val();
    let per_page = 10;
    let parametros = {"action": "listar","page": 1,"per_page": per_page, "nombre":nombre, "dni":dni, "telefono":telefono, "email":email,"busqueda_rapida":busqueda};
    let titulo = "<h1><i><u>"+entidad_titulo1+"</u></i></h1>";
    $("#titulo").html(titulo);
        $.ajax({
            url: 'funciones/'+entidad_nombre+'Listar.php',
            data: parametros,
            method: 'POST',
            success: function (data) {
                $("#principal").slideDown("slow").html(data);
            }
        });
  };
  
  //******************************************* 
  // APLICA EL FILTRO AL LISTADO DE ENTIDADES   
  //******************************************* 
  function aplicarBusquedaRapida() {
        let nombre = $("#inputFiltroNombres").val();
        let dni = $("#inputFiltroDni").val();
        let telefono = $("#inputFiltroTelefono").val();
        let email = $("#inputFiltroEmail").val();
        let busqueda = $("#inputBusquedaRapida").val();
        let per_page = 10;
        let parametros = {"action": "listar","page": 1,"per_page": per_page, "nombre":nombre, "dni":dni, "telefono":telefono, "email":email, "busqueda_rapida":busqueda};
        //console.info(parametros);
        let titulo = "<h1><i><u>"+entidad_titulo1+"</u></i></h1>";
        $("#titulo").html(titulo);
        $.ajax({
            url: 'funciones/'+entidad_nombre+'Listar.php',
            data: parametros,
            method: 'POST',
            success: function (data) {
                $("#principal").slideDown("slow").html(data);
            }
        });
  };
 
//******************************************* 
// QUITA EL FILTRO DEL LISTADO DE ENTIDADES   
//******************************************* 
function quitarFiltro() {
        $("#inputBusquedaRapida").val(""); 
        $("#inputFiltroNombres").val("");
        $("#inputFiltroDni").val("");
        $("#inputFiltroTelefono").val("");
        $("#inputFiltroEmail").val("");
        load(1);  
};
  
//************************************************** 
// NOS PERMITE BUSCAR UNA ENTIDAD POR ID       
//************************************************** 
function entidadObtenerPorId(entidad_id){
    let url = "funciones/"+entidad_nombre+"ObtenerPorId.php";
    let resultado;
    
    $.ajaxSetup({
        async: false
      });
    $.post(url, {"id":entidad_id}, function (data) {
          resultado = data;
    },"json")
    return resultado;
};

function entidadGuardar() {
    let accion = $("#inputAccion").val();
    if (accion=='nuevo') {
        entidadGuardarNuevo();
    } else if (accion=='editar') {
        entidadGuardarEditado();
    }
}

//************************************************************************************************ 
//************************************************************************************************ 
//*********************************** CREACION DE UNA ENTIDAD ************************************ 
//************************************************************************************************ 
//************************************************************************************************ 

//************************************************ 
// NOS PERMITE CREAR UNA ENTIDAD                   
//************************************************ 
function entidadCrear(){
      let arreglo="";
      let parametros = "";
      let url = "html/"+entidad_nombre+".html";
      let url_select2_obtener = "funciones/localidadObtener.php";// Esto puede cambiar
      let breadcrumb = `<nav aria-label="breadcrumb" role="navigation">
                              <ol class="breadcrumb">
                                  <li class="breadcrumb-item" aria-current="page"><a href="home.php">Home</a></li>
                                  <li class="breadcrumb-item" aria-current="page"><a href="#" onclick="load(1)">`+entidad_titulo2+`</></a></li>
                                  <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                              </ol>
                          </nav>`;
      $("#breadcrumb").slideDown("slow").html(breadcrumb);                    
      
      $.get(url,function(data) {
            $("#resultado_accion").html("");
            $("#principal").slideDown("slow").html(data);
            $("#inputFechaNacimiento").datepicker({
                dateFormat: 'dd/mm/yy',
                maxDate: new Date()
                //startDate: '-3d'
            });
            $("#inputTelefono").attr('type','hidden');
            $("#inputAccion").val('nuevo');
            $('#inputLocalidad').select2({
                    theme: "bootstrap",
                    placeholder: "Buscar",
                    ajax: {
                        url: url_select2_obtener,
                        dataType: 'json',
                        delay: 250,
                        data: function (data) {
                            return {
                                searchTerm: data.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results:response
                            };
                        },
                        cache: true
                    }
            });

      });
}
  
//************************************************* 
// GRABA LA ENTIDAD NUEVO EN LA BASE DE DATOS       
//************************************************* 
  function entidadGuardarNuevo(){
    let accion = $("#inputAccion").val();
    let apellido = $("#inputApellido").val();
    let nombres = $("#inputNombre").val();
    let dni = $("#inputDocumento").val();
    let domicilio = $("#inputDomicilio").val();
    let telefono_caracteristica = $("#inputCaracteristicaTelefono").val();
    let telefono_numero = $("#inputNumeroTelefono").val();
    let email = $("#inputEmail").val();
    let localidad_id = $("#inputLocalidad").val();
    let fecha_nacimiento = $("#inputFechaNacimiento").val();
    let parametros = {"accion":accion, "apellido":apellido, "nombres":nombres, "dni":dni, "domicilio":domicilio, "telefono_caracteristica":telefono_caracteristica, "telefono_numero":telefono_numero ,"email":email, "localidad_id":localidad_id, "fecha_nacimiento":fecha_nacimiento};
    let url = "funciones/"+entidad_nombre+"Guardar.php";
    if (accion!="" && apellido!="" && nombres!=="" && dni!="" && domicilio!=""  && telefono_caracteristica!="" && telefono_numero!="" && email!="" && localidad_id!="" && fecha_nacimiento!="") {
            $.post(url,parametros, function(data) {
                if (data.codigo==100) {
                        $("#resultado_accion").html(`
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                                    <span style="color: #000000;">
                                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                        &nbsp;<strong>Atenci&oacute;n:</strong> `+data.mensaje+`
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>   
                                                    </span>    
                                                </div>`);
                } else {
                        $("#resultado_accion").html(`
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger">
                                                    <span style="color: #000000;">
                                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                        &nbsp;<strong>Atenci&oacute;n:</strong> `+data.mensaje+`
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>   
                                                    </span>    
                                                </div>`);
                }
            },"json"); 
            load(1);
    } else {
        $("#resultado_accion").html(`
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger">
            <span style="color: #000000;">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                &nbsp;<strong>Atenci&oacute;n:</strong> Debe completar todos los datos.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>   
            </span>    
        </div>`);
    };
}


//************************************************************************************************ 
//************************************************************************************************ 
//*********************************** VER DATOS DE LA ENTIDAD ************************************ 
//************************************************************************************************ 
//************************************************************************************************ 



//************************************************* 
// NOS PERMITE VER UNA ENTIDAD                   
//************************************************* 
function entidadVer(entidad_id){
    let datos_entidad = "";
    let url = "html/"+entidad_nombre+".html";
    let url_obtener_entidad = "funciones/localidadObtener.php";
    let breadcrumb = `<nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="#" onclick="load(1)">`+entidad_titulo2+`</></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Ver</li>
                            </ol>
                        </nav>`;
    $("#breadcrumb").slideDown("slow").html(breadcrumb);   
    datos_entidad = entidadObtenerPorId(entidad_id);
    $.get(url,function(data) {
          $("#resultado_accion").html("");
          $("#principal").slideDown("slow").html(data);
          //******************************************************************** 
          //**************************** CAMBIAR ******************************* 
          $("#spn_nombres").html(datos_entidad.datos[0].apellido+', '+datos_entidad.datos[0].nombres);
          $("#spn_fecha_nacimiento").html(datos_entidad.datos[0].fecha_nacimiento);
          $("#spn_documento").html(datos_entidad.datos[0].dni);
          $("#spn_domicilio").html(datos_entidad.datos[0].direccion);
          $("#spn_celular").html('('+datos_entidad.datos[0].telefono_caracteristica+') '+datos_entidad.datos[0].telefono_numero);
          $("#spn_email").html(datos_entidad.datos[0].email);
          $("#spn_localidad").html(datos_entidad.datos[0].localidad_nombre + ' | Pcia. ' + datos_entidad.datos[0].provincia_nombre + ' | CP. '+datos_entidad.datos[0].codigo_postal);
          $("#spn_asistio").html(datos_entidad.datos[0].asistio);
          $("#spn_pago").html(datos_entidad.datos[0].pago);
          $('#imgInteresado').attr('src','../fotos/' + datos_entidad.datos[0].foto);
          $('#btnVerEditar').attr('onclick', 'entidadEditar('+datos_entidad.datos[0].id+')');
          
           //******************************************************************** 
           //******************************************************************** 
    });
}


//************************************************************************************************ 
//************************************************************************************************ 
//************************************* EDICION DE LA ENTIDAD ************************************ 
//************************************************************************************************ 
//************************************************************************************************ 

//************************************************* 
// NOS PERMITE EDITAR UNA ENTIDAD                   
//************************************************* 
function entidadEditar(entidad_id){
      let datos_entidad = "";
      let url = "html/"+entidad_nombre+".html";
      let url_obtener_entidad = "funciones/localidadObtener.php";
      let breadcrumb = `<nav aria-label="breadcrumb" role="navigation">
                              <ol class="breadcrumb">
                                  <li class="breadcrumb-item" aria-current="page"><a href="home.php">Home</a></li>
                                  <li class="breadcrumb-item" aria-current="page"><a href="#" onclick="load(1)">`+entidad_titulo2+`</></a></li>
                                  <li class="breadcrumb-item active" aria-current="page">Editar</li>
                              </ol>
                          </nav>`;
      $("#breadcrumb").slideDown("slow").html(breadcrumb);   
      datos_entidad = entidadObtenerPorId(entidad_id);
      $.get(url,function(data) {
            $("#resultado_accion").html("");
            $("#principal").slideDown("slow").html(data);
            //******************************************************************** 
            //**************************** CAMBIAR ******************************* 
            $("#inputAccion").val('editar');
            $("#inputApellido").val(datos_entidad.datos[0].apellido);
            $("#inputNombre").val(datos_entidad.datos[0].nombre);
            $("#inputDocumento").attr('disabled',true)
            $("#inputDocumento").val(datos_entidad.datos[0].dni);
            $("#inputDomicilio").val(datos_entidad.datos[0].domicilioCalle+' '+datos_entidad.datos[0].domicilioDpto);
            $("#inputTelefono").val(datos_entidad.datos[0].telefono);
            $("#inputTelefono").attr('type','text');
            $("#inputTelefonoCaracteristica").val(datos_entidad.datos[0].telefono_caracteristica);
            $("#inputTelefonoNumero").val(datos_entidad.datos[0].telefono_numero);
            $("#inputEmail").val(datos_entidad.datos[0].email);
            $("#inputFechaNacimiento").datepicker({
                dateFormat: 'dd/mm/yy',
                maxDate: new Date()
            });
            if (datos_entidad.datos[0].fechaNacimiento!=null) {
                let anio = (datos_entidad.datos[0].fechaNacimiento).substr(0,4);
                let mes = (datos_entidad.datos[0].fechaNacimiento).substr(5,2);
                let dia = (datos_entidad.datos[0].fechaNacimiento).substr(8,2);
                $("#inputFechaNacimiento").val(datos_entidad.datos[0].fechaNacimiento);
                let realDate = new Date(anio+'/'+mes+'/'+dia);  
                $("#inputFechaNacimiento").datepicker('setDate',realDate);
            }
            $('#inputLocalidad').select2({
                theme: "bootstrap",
                placeholder: "Localidad",
                ajax: {
                    url: url_obtener_entidad,
                    dataType: 'json',
                    delay: 250,
                    data: function (datos) {
                        return {
                            searchTerm: datos.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results:response
                        };
                    },
                    cache: true
                }
            });
            var data = {
                id: datos_entidad.datos[0].localidad_id,
                text: datos_entidad.datos[0].localidad_nombre + ' (Pcia. ' + datos_entidad.datos[0].provincia_nombre + ')'
            };
            var newOption = new Option(data.text, data.id, false, false);
            $('#inputLocalidad').append(newOption).trigger('change');
            $("#inputLocalidad option[value="+ datos_entidad.datos[0].localidad_id +"]").attr("selected",true);
      });
}
 




//************************************************* 
// GRABA LA ENTIDAD NUEVO EN LA BASE DE DATOS       
//************************************************* 
function entidadGuardarEditado(){
    let accion = $("#inputAccion").val();
    let apellido = $("#inputApellido").val();
    let nombres = $("#inputNombre").val();
    let dni = $("#inputDocumento").val();
    let domicilio = $("#inputDomicilio").val();
    let telefono_caracteristica = $("#inputTelefonoCaracteristica").val();
    let telefono_numero = $("#inputTelefonoNumero").val();
    let email = $("#inputEmail").val();
    let localidad_id = $("#inputLocalidad").val();
    let fecha_nacimiento = $("#inputFechaNacimiento").val();
    let parametros = {"accion":accion, "apellido":apellido, "nombres":nombres, "dni":dni, "domicilio":domicilio, "telefono_caracteristica":telefono_caracteristica, "telefono_numero":telefono_numero ,"email":email, "localidad_id":localidad_id, "fecha_nacimiento":fecha_nacimiento};
    let url = "funciones/"+entidad_nombre+"Guardar.php";
    if (accion!="" && apellido!="" && nombres!=="" && dni!="" && localidad_id!="") {
        $.post(url,parametros, function(data) {
            if (data.codigo==100) {
                    $("#resultado_accion").html(`
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                                <span style="color: #000000;">
                                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                    &nbsp;<strong>Atenci&oacute;n:</strong> `+data.mensaje+`
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>   
                                                </span>    
                                            </div>`);
            } else {
                    $("#resultado_accion").html(`
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger">
                                                <span style="color: #000000;">
                                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                    &nbsp;<strong>Atenci&oacute;n:</strong> `+data.mensaje+`
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>   
                                                </span>    
                                            </div>`);
            };
            $("#inputApellido").val("");
            $("#inputNombre").val("");
            $("#inputDocumento").val("");
            $("#inputDomicilio").val("");
            $("#inputTelefono").val("");
            $("#inputCaracteristicaTelefono").val("");
            $("#inputNumeroTelefono").val("");
            $("#inputEmail").val("");
            $("#inputLocalidad").val("");
            $("#inputAccion").val("");
            let hoy = new Date();  
            let fecha_hoy = hoy.getDate() + '/' + ( hoy.getMonth() + 1 ) + '/' + hoy.getFullYear();
            $("#inputFechaNacimiento").datepicker('setDate',fecha_hoy);
        },"json"); 
        load(1);
    } else {
        $("#resultado_accion").html(`
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger">
            <span style="color: #000000;">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                &nbsp;<strong>Atenci&oacute;n:</strong> Debe completar todos los datos.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>   
            </span>    
        </div>`);
    }    
}


//************************************************************************************************ 
//************************************************************************************************ 
//************************************* ELIMINACION DEL ALUMNO   ********************************* 
//************************************************************************************************ 
//************************************************************************************************ 


//***************************************************************** 
// MANEJA LA SELECCION / DESELECCION DE TODOS LOS CHECKBOX          
//***************************************************************** 
$("body").on("click","#seleccionar_todos", function() {
    if( $(this).is(':checked') ){
          // Hacer algo si el checkbox ha sido seleccionado
          $('.check').prop('checked',true);
      } else {
          // Hacer algo si el checkbox ha sido deseleccionado
          $('.check').prop('checked',false);
      }
  });
  
/*  
  //******************************************************************************************** 
  // VERFICICA SI HAY ENTIDADES SELECCIONADOS/CHECKBOX Y PIDE CONFIRMACION PARA SU ELIMINACION   
  //******************************************************************************************** 
  function entidadEliminarSeleccionados(){
      let arreglo="";
      let cantidad_seleccionados = 0;
      $('.check:checked').each(
                  function() {
                      arreglo += ','+$(this).val();
                      cantidad_seleccionados++;
                  }
      );
      if (cantidad_seleccionados>0) {
              $("#confirmarEliminarTodosModal").modal("show");
      } else {
              $("#sinElementosModal").modal("show");
              $("#resultado_accion").html(`
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
                                              <span style="color: #000000;">
                                              <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                  &nbsp;<strong>Atenci&oacute;n:</strong> No hay `+entidad_titulo2+` seleccionados.
                                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>   
                                              </span>    
                                          </div>
              `);
      };
  }
  

  //*************************************************************************** 
  // ELIMINA TODOS LAS ENTIDADES CUYOS CHECKBOX ESTAN SELECCIONADOS             
  //*************************************************************************** 
  function entidadEliminarSeleccionadosConfirmar(){
      let arreglo="";
      let parametros = "";
      let url = "funciones/"+entidad_nombre+"Eliminar.php";
      let cantidad_seleccionados = 0;
      $('.check:checked').each(
                  function() {
                      arreglo += ','+$(this).val();
                  }
      );
      arreglo = arreglo.substr(1,arreglo.length-1);
      parametros = {"id":arreglo};
      $.post(url, parametros, function (data) {
              $("#resultado_accion").html(`
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success">
                          <span style="color: #000000;">
                          <i class="fa fa-info-circle" aria-hidden="true"></i>
                              <strong>Atención:</strong>&nbsp;`+data.mensaje+`
                          </span>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>       
                      </div>
              `);
              load(1);
      },"json");
  };
  
  //******************************************************* 
  // CONFIRMA LA ELIMINACION DE LA ENTIDAD DESDE EL MODAL   
  //******************************************************* 
  $('#confirmarModal').on('shown.bs.modal', function (e) {
       let button = $(e.relatedTarget); // BUTTON QUE DISPARO EL MODAL
       let id=button.data("id");
      $("#inputEliminarId").val(id);
  })
  
  //************************************************
  // NOS PERMITE ELIMINAR UNA ENTIDAD ESPECIFICA     
  //************************************************ 
  function entidadEliminarSeleccionado(entidad_id){
        let arreglo="";
        let parametros = "";
        let url = "funciones/"+entidad_nombre+"Eliminar.php";
        parametros = {"id":entidad_id};
                $.post(url, parametros, function (data) {
                        $("#resultado_accion").html(`
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                      <span style="color: #000000;">
                                      <i class="fa fa-info-circle" aria-hidden="true"></i>
                                          <strong>Atención:</strong>&nbsp;`+data.mensaje+`
                                      </span>
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>       
                                </div>
                        `);
                        load(1);
                },"json");
  };


  //************************************************ 
  // NOS PERMITE ENVIAR UN EMAIL A UNA INTERESADO    
  //************************************************ 
  function enviarEmail(id) {
    if (confirm("Desea enviar un Email con el QR y sus datos al Interesado?")) {
    let url = "./funciones/interesadoEnviarEmail.php";
    let parametros = {"interesado_id":id};
    $.post(url, parametros, function(data) {
        if (data.codigo==100) {
            $("#resultado_accion").html(`
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-success">
                                      <span style="color: #000000;">
                                      <i class="fa fa-info-circle" aria-hidden="true"></i>
                                          <strong>Atención:</strong>&nbsp;`+data.mensaje+`
                                      </span>
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>       
                                </div>
                        `);
        } else {
            $("#resultado_accion").html(`
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger">
                                      <span style="color: #000000;">
                                      <i class="fa fa-info-circle" aria-hidden="true"></i>
                                          <strong>Atención:</strong>&nbsp;`+data.mensaje+`
                                      </span>
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>       
                                </div>
                        `);
        }
    },"json");
    };
  } */

</script>

</body>
</html>