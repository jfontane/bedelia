<nav class="navbar navbar-expand-md navbar-light bg1"  id="myNavbar">
  <a class="navbar-brand" href="index.php"><img
    src="../public/img/logo.png" width="100"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarCollapse">

    <ul class="navbar-nav mr-auto">
      
        <li class="nav-item nav-item-home">
            <a class="nav-link" href="home.php">
              <img src="../public/assets/img/icons/home_icon.png" width="23">
              <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item dropdown ">
              <a class="nav-link i dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Eventos 
              </a>
              <div class="dropdown-menu bg-info" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="menuEvento.php">Eventos Academicos<span class="sr-only">(current)</span></a>
                <a class="dropdown-item" href="menuCalendario.php">Calendario de Eventos<span class="sr-only">(current)</span></a>
              </div>
        </li>

        <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Carreras
        </a>
        <div class="dropdown-menu bg-info" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="menuCarrera.php">Carreras<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Homologación
        </a>
        <div class="dropdown-menu bg-info" aria-labelledby="navbarDropdownMenuLink">
           <a class="dropdown-item" href="menuHomologacionMateriaRegularizada.php">Regularidad<span class="sr-only">(current)</span></a>
           <a class="dropdown-item" href="menuHomologacionMateriaAprobada.php">Aprobación<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Promociones
        </a>
        <div class="dropdown-menu bg-info" aria-labelledby="navbarDropdownMenuLink">
           <a class="dropdown-item" href="menuPromociones.php">Listas de promocionados<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Gestión Docentes
        </a>
        <div class="dropdown-menu bg-info" aria-labelledby="navbarDropdownMenuLink">
           <a class="dropdown-item" href="menuProfesor.php">Listado de Docentes<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Gestión Alumnos
        </a>
        <div class="dropdown-menu bg-info" aria-labelledby="navbarDropdownMenuLink">
           <a class="dropdown-item" href="menuAlumno.php">Listado de Alumnos<span class="sr-only">(current)</span></a>
        </div>
  </li>

  <li class="nav-item dropdown">
        <a class="nav-link i dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Reportes
        </a>
        <div class="dropdown-menu bg-info" aria-labelledby="navbarDropdownMenuLink">
           <a class="dropdown-item" href="menuActasPromociones.php">Actas Promociones<span class="sr-only">(current)</span></a>
           <a class="dropdown-item" href="menuActasExamenes.php">Actas Exámenes<span class="sr-only">(current)</span></a>
        </div>
  </li>

</ul>

<ul class="navbar-nav ml-auto">
  <li class="nav-item dropdown">
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
