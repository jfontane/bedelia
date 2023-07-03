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
              <li class="breadcrumb-item active" aria-current="page">Calendario Académico</li>
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

<span id="modalEliminar">

</span>  

  

<!-- FOOTER -->
<?php include("componente_footer.html"); ?>




<!-- JAVASCRIPT CUSTOM -->
<script src="./js/funciones.js"></script>
<script>

$(function () {
    cargarModulos();
});

function cargarModulos() {
  	load(1);
};

// CARGA EL LISTADO DE EVENTOS
function load(page) {
      let anio_lectivo = $("#inputFiltroAnioLectivo").val();
      let evento = $("#inputFiltroEvento").val();
      let per_page = 10;
      let parametros = {"action": "listar","page": page,"per_page": per_page,"anio":anio_lectivo,"codigo":evento};
      let titulo = "<h1><i><u>Calendario de Eventos</u></i></h1><h2>Listado</h2>";
      $("#titulo").html(titulo);
      $.ajax({
          url: 'funciones/calendarioListar.php',
          data: parametros,
          method: 'POST',
          beforeSend: function () {
            $("#principal").html("<img src='../public/assets/img/load_icon.gif' width='50' >");  
          },
          success: function (data) {
              $("#principal").fadeIn(100).html(data);
              $("#tabla_calendario>tfoot").prepend(`<tr>
                                                      <td colspan="7">
                                                          <button class="btn btn-primary" onclick="calendarioAgregar()">Nuevo</button>
                                                      </td>
                                                  </tr>`);
          }
      });
};

$("body").on("click","#botonFiltro",function(e) {
      e.preventDefault();
      let anio_lectivo = $("#inputFiltroAnioLectivo").val();
      let evento = $("#inputFiltroEvento").val();
      console.info(anio_lectivo+'-'+evento);
      let per_page = 10;
      let parametros = {"action": "listar","page": 1,"per_page": per_page,"anio":anio_lectivo,"codigo":evento};
      $("#titulo").html(titulo);
      $.ajax({
          url: 'funciones/calendarioListar.php',
          data: parametros,
          method: 'POST',
          success: function (data) {
              $("#principal").html(data);
              $("#tabla_calendario>tfoot").prepend(`<tr>
                                                      <td colspan="5">
                                                          <button class="btn btn-primary" onclick="calendarioAgregar()">Nuevo</button>
                                                      </td>
                                                  </tr>`);
          }
      });

}) 




function calendarioAgregar() {
    let titulo = `<h1><i><u>Calendario de Eventos</u></i></h1><h2>Agregar Evento al Calendario</h2>`;
    let bread = `<nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#" onclick="">Home</a></li>
                      <li class="breadcrumb-item"><a href="#" onclick="cargarModulos()">Calendario</a></li>
                      <li class="breadcrumb-item">Agregar Evento </li>
                    </ol>
                  </nav>`;
    $("#filtro").html("");
    $("#breadcrumb").html(bread);
    $("#titulo").html(titulo);
    $.get("./html/calendarioAlta.html",function(datos) {
         $("#principal").html(datos);
         $("#inputAltaFechaInicio").datepicker({dateFormat: "yy-mm-dd"});
         $("#inputAltaFechaFinalizacion").datepicker({dateFormat: "yy-mm-dd"});
         $.post("./funciones/getAllEvento.php",function(datosEventos) {
              if (datosEventos.codigo == 100) {
                  let obj = datosEventos.data; 
                  obj.forEach(evento => {
                        $("#inputAltaEvento").append($('<option/>', {
                              text: ' ('+evento.codigo+') '+evento.descripcion,
                              value: evento.id,
                        }));
                  });
                  $('#inputAltaEvento').select2({
                        theme: "bootstrap4",
                  });
              }
         },"json")
    });
}

function calendarioEditar(idCalendario) {
    let titulo = `<h1><i><u>Calendario de Eventos</u></i></h1><h2>Editar Evento del Calendario</h2>`;
    let bread = `<nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#" onclick="">Home</a></li>
                      <li class="breadcrumb-item"><a href="#" onclick="cargarModulos()">Calendario</a></li>
                      <li class="breadcrumb-item">Editar Evento</li>
                    </ol>
                  </nav>`;
    let calendario_id = idCalendario;
    let anio_lectivo;
    let fecha_inicio;
    let fecha_finalizacion;
    let evento_id;       
    $("#filtro").html("");       
    $("#breadcrumb").html(bread);
    $("#titulo").html(titulo);

    let datos_calendario = getCalendarioPorId(calendario_id);
    if (datos_calendario.codigo == 100) {
        anio_lectivo = datos_calendario.data[0].AnioLectivo;
        fecha_inicio = datos_calendario.data[0].fechaInicioEvento;
        fecha_finalizacion = datos_calendario.data[0].fechaFinalEvento;
        evento_id = datos_calendario.data[0].idEvento;
    };
    $.get("./html/calendarioEditar.html",function(datos) {
         $("#principal").html(datos);
         $("#inputEditarAnio").val(anio_lectivo);
         $("#inputEditarFechaInicio").val(fecha_inicio);
         $("#inputEditarFechaFinalizacion").val(fecha_finalizacion);
         $("#inputEditarFechaInicio").datepicker({dateFormat: "yy-mm-dd"});
         $("#inputEditarFechaFinalizacion").datepicker({dateFormat: "yy-mm-dd"});
         $("#inputEditarIdCalendario").val(calendario_id);
         $.post("./funciones/getAllEvento.php",function(datosEventos) {
              if (datosEventos.codigo == 100) {
                    let obj = datosEventos.data; 
                    obj.forEach(evento => {
                            $("#inputEditarEvento").append($('<option/>', {
                                text: ' ('+evento.codigo+') '+evento.descripcion,
                                value: evento.id,
                            }));
                    });
                    $("#inputEditarEvento option[value="+ evento_id +"]").attr("selected",true);
                    $('#inputEditarEvento').select2({
                        theme: "bootstrap4",
                    });
              };

          },"json")
    });
};

function calendarioEditarGuardar() {
    let anio_lectivo = $("#inputEditarAnio").val();
    let evento = $('#inputEditarEvento').val();
    let fecha_inicio = $("#inputEditarFechaInicio").val();
    let fecha_finalizacion = $("#inputEditarFechaFinalizacion").val();
    let calendario = $("#inputEditarIdCalendario").val();
    let parametros = {"anio":anio_lectivo,"evento":evento,"fecha_inicio":fecha_inicio,"fecha_finalizacion":fecha_finalizacion,"calendario":calendario};

    $.post("./funciones/updCalendario.php",parametros,function(datos){
        if (datos.codigo == 100) {
            cargarModulos();
            $("#resultado_accion").html();
            $("#resultado_accion").append(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/ok_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                           `+datos.data+`</span></i>
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                         </button></div></div>`);
        } else {
            
            $("#resultado_accion").html(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/error_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                           `+datos.data+`</span></i>
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                         </button></div></div>`);
        }
    },"json");

    
}


function calendarioAltaGuardar() {
    let anio_lectivo = $("#inputAltaAnio").val();
    let evento = $('#inputAltaEvento').val();
    let fecha_inicio = $("#inputAltaFechaInicio").val();
    let fecha_finalizacion = $("#inputAltaFechaFinalizacion").val();
    let parametros = {"anio":anio_lectivo,"evento":evento,"fecha_inicio":fecha_inicio,"fecha_finalizacion":fecha_finalizacion};
    $.post("./funciones/setCalendario.php",parametros,function(datos){
        if (datos.codigo == 100) {
            cargarModulos();
            $("#resultado_accion").html();
            $("#resultado_accion").append(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/ok_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                           `+datos.data+`</span></i>
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                         </button></div></div>`);
        } else {
            
            $("#resultado_accion").html(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/error_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                           `+datos.data+`</span></i>
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                         </button></div></div>`);
        }
    },"json");
   
}


function calendarioEliminar(idCalendario) {
    if (confirm("Va a Eliminar un Evento del Calendario, desea hacerlo?.")) {
        let parametros = {"calendario":idCalendario};
        $.post("./funciones/delCalendario.php",parametros,function(datos){
            if (datos.codigo == 100) {
                cargarModulos();
                $("#resultado_accion").html();
                $("#resultado_accion").append(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/ok_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                            `+datos.data+`</span></i>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button></div></div>`);
            } else {
                $("#resultado_accion").html(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/error_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                            `+datos.data+`</span></i>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button></div></div>`);
            }
        },"json");
    }
   
}



</script>

</body>
</html>