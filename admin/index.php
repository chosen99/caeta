<?php
session_start();
const HOME_PATH = "./";
const PLANTELES_PATH = "./planteles.php";
const ALUMNOS_PATH = "./alumno.php";
const PERSONAL_PATH = "./docente.php";
const MENSAJE_PATH = "#";
const ASISTENCIA_PATH = "#";
include "../recursos/funciones/funcionesgenerales.php";
if (isset($_SESSION['log'])) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Login CAE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/css/bootstrap-utilities.min.css">
        <link rel="stylesheet" href="../recursos/assets/css/utiles.css?v=<?php echo rand();?>">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body style="font-family: Helvetica, 'Helvetica Neue', Arial, sans-serif;">
    <?php
    pintarhederadmin();
    ?>
    <div class="container-fluid">
        <hr>
        <span style="font-size: 14px;">
            © 2022 - CAE by Grupo IP México 2022
        </span>
    </div>
    <script src="../recursos/assets/js/cae.index.js?v=<?php echo rand() ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="../recursos/assets/js/utiles.js?v=<?php echo rand() ?>"></script>
    </body>
    </html>
    <?php
} else {
    session_destroy();
    header('Location: ../');
}