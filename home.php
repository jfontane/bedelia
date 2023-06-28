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
              <li class="breadcrumb-item active" aria-current="page">Home</li>
          </ol>
      </nav>
    </div>
  </article>

  <article class="container">
    <div id="titulo">
    </div>
  </article>

  <article class="container">
       <section id="section_principal">

       
        
        </section>
  </article>

  <article class="container">
       <section id="section_footer">

       
        
        </section>
  </article>
  

<!-- FOOTER -->
<?php include("componente_footer.html"); ?>

<script>
$(function () {
    load();
});

function load() {
    $.get("./html/notice.html", function(data) {
            $("#section_principal").html(data);
    });
    $("#section_footer").html("");
}
  

function cambiarPassword() {
    $.get("./html/passwordModificar.html", function(data) {
            $("#section_principal").html(data);
    });
}

function guardarPassword() {
    let password_actual = $("#inputPasswordActual").val();
    let password_nueva = $("#inputPasswordNueva").val();
    let password_re_nueva = $("#inputRePasswordNueva").val();
    let parametros = {"dni":<?=$_SESSION['dni']?>,"password_actual":password_actual,"password_nueva":password_nueva,"password_re_nueva":password_re_nueva}
    if ( password_nueva==password_re_nueva) {
        $.post("./funciones/passwordModificar.php",parametros,function(datos){
                if (datos.codigo == 100) {
                    $("#section_footer").html();
                    $("#section_footer").append(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/ok_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                                `+datos.mensaje+`</span></i>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button></div></div>`);
                    habilitarControles(true);                             
                } else {
                    $("#section_footer").html(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/error_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                                `+datos.mensaje+`</span></i>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button></div></div>`);
                    habilitarControles(false);
                }
        },"json");
    } else {
        $("#section_footer").html(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><div class="alert alert-warning alert-dismissible fade show" role="alert"><img src="../public/assets/img/icons/error_icon.png" width="22">&nbsp;<i><span style="color: #000000;">
                                                La contraseña no coincide con la repetición.</span></i>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button></div></div>`);
        habilitarControles(true);
    }    

};

function habilitarControles(val) {
    $("#inputPasswordActual").attr("disabled",val);
    $("#inputPasswordNueva").attr("disabled",val);
    $("#inputRePasswordNueva").attr("disabled",val);
    $("#btnVerEditar").attr("disabled",val);
}

</script>
</body>
</html>