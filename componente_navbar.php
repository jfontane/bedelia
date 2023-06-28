
<nav class="navbar navbar-expand-lg bg1 " id="myNavbar">
<a href="#" class="navbar-brand col1"><img src="../public/assets/img/logo.png" width="60">&nbsp;<b>Gestión del Alumno</b></a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
 </button>

 <div class="collapse navbar-collapse " id="mainNav">

 <ul class="navbar-nav">

  <li class="nav-item nav-item-home">
    <a class="nav-link" href="home.php">
      <img src="../public/assets/img/icons/home_icon.png" width="23">
      <span class="sr-only">(current)</span></a>
  </li>

  <li class="nav-item dropdown ">
        <a class="nav-link i dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Eventos 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="nav-link" href="menuEvento.php">Eventos Academicos<span class="sr-only">(current)</span></a>
          <a class="nav-link" href="menuCalendario.php">Calendario de Eventos<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Carreras
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="nav-link" href="menuCarrera.php">Carreras<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Homologación
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
           <a class="nav-link" href="menuHomologacionMateriaRegularizada.php">Regularidad<span class="sr-only">(current)</span></a>
           <a class="nav-link" href="menuHomologacionMateriaAprobada.php">Aprobación<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Promociones
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
           <a class="nav-link" href="menuPromociones.php">Listas de promocionados<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Gestión Docentes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
           <a class="nav-link" href="menuProfesor.php">Listar<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Gestión Alumnos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
           <a class="nav-link" href="menuAlumno.php">Listar<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Reportes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
           <a class="nav-link" href="menuActasPromociones.php">Actas Promociones<span class="sr-only">(current)</span></a>
           <a class="nav-link" href="menuActasExamenes.php">Actas Exámenes<span class="sr-only">(current)</span></a>
        </div>
  </li>


</ul>

<ul class="navbar-nav ml-auto">
  <li class="nav-item px-4 dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="servicesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="../public/assets/img/icons/user_icon.png" width="22">
        </a>
        <div class="dropdown-menu dropdown-menu-right bg-info" aria-labelledby="servicesDropdown">
            <a class="dropdown-item" href="#" onclick="cambiarPassword()">Cambiar Contraseña</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../logout.php">Salir</a>
        </div>
  </li>
</ul>

 </div>
</nav>