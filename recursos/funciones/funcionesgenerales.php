<?php

function pintarhedergeneral(){
    echo '
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: rgb(34,34,34)!important;">
    <div class="container-fluid">
        <span class="navbar-brand text-warning">CAETA - Control de Asistencia Escolar</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Credenciales
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
';
}
function pintarhederadmin(){
    echo '
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: rgb(34,34,34)!important; font-size: 14px;">
    <div class="container-fluid">
        <span class="navbar-brand text-warning">CAETA</span>
        <button class="navbar-toggler boton" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active a" aria-current="page" href="'.HOME_PATH.'">Home</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link active a" aria-current="page" href="'.PLANTELES_PATH.'">Planteles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active a" aria-current="page" href="'.ALUMNOS_PATH.'">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active a" aria-current="page" href="'.PERSONAL_PATH.'">Personal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active a" aria-current="page" href="'.MENSAJE_PATH.'">Mensaje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active a" aria-current="page" href="'.ASISTENCIA_PATH.'">Asistencia</a>
                </li>
                
                
                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle a" href="#" id="credencial" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Credenciales
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="credencial">
                        <li><a class="dropdown-item" href="./alumno.php">Alumno</a></li>
                        <li><a class="dropdown-item" href="#">Docente</a></li>
                        <li><a class="dropdown-item" href="#">Director</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Actualizar firma Alumno</a></li>
                        <li><a class="dropdown-item" href="#">Actualizar firma Docente</a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link active a" aria-current="page" href="./planteles.php">Planteles</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle a" href="#" id="administracion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administración
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="administracion">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle a" href="#" id="horario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Horario
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="horario">
                        <li><a class="dropdown-item" href="#">Horario</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle a" href="#" id="mensaje" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mensaje
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="mensaje">
                        <li><a class="dropdown-item" href="#">Enviar</a></li>
                    </ul>
                </li> -->
            </ul>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-end">
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" target="_blank">Hola: Admin</a>
                </li>
                <li class="nav-item">
                    <button class="nav-link text-warning logout" style="background: none; border: none;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="LogOut">Cerrar Sesión</button>
                </li>
            </ul>
        </div>
    </div>
</nav>
';
}
