<?php
session_start();
const HOME_PATH = "./";
const PLANTELES_PATH = "./planteles.php";
const ALUMNOS_PATH = "#";
const PERSONAL_PATH = "./docente.php";
const MENSAJE_PATH = "#";
const ASISTENCIA_PATH = "#";
include "../recursos/funciones/funcionesgenerales.php";
if (isset($_SESSION['log'])) {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <title>CAE - Credencializacion</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/css/bootstrap-utilities.min.css">
        <link rel="stylesheet" href="../recursos/assets/css/utiles.css?v=<?php echo rand(); ?>">
        <link rel="stylesheet" href="../recursos/assets/css/BootSideMenu.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" crossorigin="anonymous">
        <link rel="stylesheet" href="./cropper.css">
        <link rel="stylesheet" href="./main.css">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            td {
                vertical-align: middle;
            }

            .boton-p {
                cursor: pointer;
            }

            #draw-canvas {
                border: 2px dotted #000000;
                border-radius: 5px;
                cursor: crosshair;
            }

            #draw-dataUrl {
                width: 100%;
            }

            section {
                flex: 1;
            }

            .button {
                background: #3071a9;
                box-shadow: inset 0 -3px 0 rgba(0, 0, 0, .3);
                font-size: 14px;
                padding: 5px 10px;
                border-radius: 5px;
                margin: 0 15px;
                text-decoration: none;
                color: white;
            }

            .button:active {
                transform: scale(0.9);
            }

            .contenedor {
                width: 100%;
                margin: 5px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .instrucciones {
                width: 90%;
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                margin-bottom: 10px;
            }

            label {
                margin: 0 15px;
            }

            input[type=range] {
                -webkit-appearance: none;
                margin: 18px 0;

            }

            input[type=range]:focus {
                outline: none;
            }

            input[type=range]::-webkit-slider-runnable-track {
                width: 100%;
                height: 8.4px;
                cursor: pointer;
                animate: 0.2s;
                box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
                background: #3071a9;
                border-radius: 1.3px;
                border: 0.2px solid #010101;
            }

            input[type=range]::-webkit-slider-thumb {
                box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
                border: 1px solid #000000;
                height: 36px;
                width: 16px;
                border-radius: 3px;
                background: #ffffff;
                cursor: pointer;
                -webkit-appearance: none;
                margin-top: -14px;
            }

            input[type=range]:focus::-webkit-slider-runnable-track {
                background: #367ebd;
            }

            input[type=range]::-moz-range-track {
                width: 100%;
                height: 8.4px;
                cursor: pointer;
                animate: 0.2s;
                box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
                background: #3071a9;
                border-radius: 1.3px;
                border: 0.2px solid #010101;
            }

            input[type=range]::-moz-range-thumb {
                box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
                border: 1px solid #000000;
                height: 36px;
                width: 16px;
                border-radius: 3px;
                background: #ffffff;
                cursor: pointer;
            }

            input[type=range]::-ms-track {
                width: 100%;
                height: 8.4px;
                cursor: pointer;
                animate: 0.2s;
                background: transparent;
                border-color: transparent;
                border-width: 16px 0;
                color: transparent;
            }

            input[type=range]::-ms-fill-lower {
                background: #2a6495;
                border: 0.2px solid #010101;
                border-radius: 2.6px;
                box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            }

            input[type=range]::-ms-fill-upper {
                background: #3071a9;
                border: 0.2px solid #010101;
                border-radius: 2.6px;
                box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            }

            input[type=range]::-ms-thumb {
                box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
                border: 1px solid #000000;
                height: 36px;
                width: 16px;
                border-radius: 3px;
                background: #ffffff;
                cursor: pointer;
            }

            input[type=range]:focus::-ms-fill-lower {
                background: #3071a9;
            }

            input[type=range]:focus::-ms-fill-upper {
                background: #367ebd;
            }
        </style>
        <style>
            form .error {
                color: #ff0000;
            }

            .article-reference {
                margin-top: 15px;
            }

            .article-reference a {
                color: #e67e22;
            }

            form label,
            form input {
                border: 0;
                display: block;
                width: 100%;
            }

            .error {
                display: block;
                text-align: center;
                position: relative;
                padding-top: 10pt;
            }

            #sect1 {
                position: absolute;
                left: 30%;
                z-index: 999;
            }

            label {
                margin: auto;
            }

            /* FOTO */
            .fondo-help {
                /*width: 150px;
                        height: 90px;*/
                height: 387px;
                border-radius: 4px;
                /*border: 2px solid whitesmoke;*/
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
                position: absolute;
                bottom: 5px;
                /*left: 10px;*/
                left: auto;
                /*background: white;*/
                background: none;
            }

            .screenshot-image {
                width: 150px;
                height: 90px;
                border-radius: 4px;
                border: 2px solid whitesmoke;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
                position: absolute;
                bottom: 5px;
                left: 10px;
                /*background: white;*/
                background: none;
            }

            .display-cover {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 70%;
                margin: 2% auto;
                position: relative;
            }

            video {
                width: 100%;
                background: rgba(0, 0, 0, 0.2);
            }

            .video-options {
                position: absolute;
                left: 20px;
                top: 30px;
            }

            .controls {
                position: absolute;
                right: 20px;
                top: 20px;
                display: flex;
            }

            .controls>button {
                width: 45px;
                height: 45px;
                text-align: center;
                border-radius: 100%;
                margin: 0 6px;
                background: transparent;
            }

            .controls>button:hover svg {
                color: white !important;
            }

            @media (min-width: 300px) and (max-width: 400px) {
                .controls {
                    flex-direction: column;
                }

                .controls button {
                    margin: 5px 0 !important;
                }
            }

            .controls>button>svg {
                height: 20px;
                width: 18px;
                text-align: center;
                margin: 0 auto;
                padding: 0;
            }

            .controls button:nth-child(1) {
                border: 2px solid #D2002E;
            }

            .controls button:nth-child(1) svg {
                color: #D2002E;
            }

            .controls button:nth-child(2) {
                border: 2px solid #008496;
            }

            .controls button:nth-child(2) svg {
                color: #008496;
            }

            .controls button:nth-child(3) {
                border: 2px solid #00B541;
            }

            .controls button:nth-child(3) svg {
                color: #00B541;
            }

            .controls>button {
                width: 45px;
                height: 45px;
                text-align: center;
                border-radius: 100%;
                margin: 0 6px;
                background: transparent;
            }

            .controls>button:hover svg {
                color: white;
            }
        </style>
    </head>

    <body style="font-family: Helvetica, 'Helvetica Neue', Arial, sans-serif;">
        <?php
        pintarhederadmin();
        ?>
        <div class="container mt-4">
            <h1>Credencial: Registrar/Actualizar Alumno</h1>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 col-md-12 col-sm-12 pb-2 m-auto">
                    <div class="border pb-3 cae-credenciales-cuadros text-center">
                        <span>Seleccione un plantel</span>
                        <div class="row text-center">
                            <!--<div class="col-lg-6 col-md-6 col-sm-6">
                            <label for="plantel_nuevos"><strong>Plantel</strong></label>
                            <select class="form-select text-center" name="plantel_nuevos" id="plantel_nuevos" required onchange="$('#bunton2').click()">
                                <option selected disabled>- Seleccione una opción -</option>
                                <option value="admin">admin</option>
                            </select>
                        </div> -->
                            <div class="col-lg-3 col-md-3 col-sm-3"></div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <label for="grupo_nuevos"><strong>Plantel</strong></label>
                                <select class="form-select text-center" name="grupo_nuevos" id="grupo_nuevos" onchange="getplantel(this.value)">
                                    <option selected disabled>- Seleccione una opción -</option>
                                    <option value="cetis37">CETIS 37</option>
                                    <option value="cetis64">CETIS 64</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>


        <!-- REGISTRO DE ALUMNO -->
        <div id="nu" style="display: none;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-3 col-sm-2 col-2 m-auto">
                        <div class="text-star">
                            <button class="btn btn-success" data-toggle="tooltip" data-bs-placement="right" title="Carga individual"><img src="../recursos/img/svg/user-add.svg" alt="useradd" width="23"></button>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#carga-masiva" data-toggle="tooltip" data-bs-placement="top" title="Carga masiva"><img src="../recursos/img/svg/upload.svg" alt="useradd" width="23"></button>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#carga-masiva" data-toggle="tooltip" data-bs-placement="top" title="UPDATE"><img src="../recursos/img/svg/upload.svg" alt="useradd" width="23"></button>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-10 col-10 m-auto">
                        <div class="text-end">
                            <div class="d-inline-block" style="cursor: pointer;" data-toggle="tooltip" data-bs-placement="top" title="Exportar tabla a excel">
                                <img src="../recursos/img/svg/excel.svg" alt="excel" width="42">
                            </div>
                            <button class="btn btn-warning d-inline-block" data-toggle="tooltip" data-bs-placement="top" title="Exporta historial de impresión">Historial de impresión
                            </button>
                            <button class="btn btn-info d-inline-block" data-toggle="tooltip" data-bs-placement="top" title="Migración de alumnos">Migración
                            </button>
                            <button class="btn btn-success d-inline-block" data-toggle="tooltip" data-bs-placement="top" title="Imprimir credenciales">Imprimir
                            </button>
                            <button class="btn btn-danger d-inline-block" data-toggle="tooltip" data-bs-placement="left" title="Eliminar alumnos">Eliminar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="alumnos" class="table table-striped table-hover text-center w-100">
                        <thead>
                            <tr>
                                <th></th>
                                <th>NOMBRE</th>
                                <th>NO. CONTROL</th>
                                <th>CURP</th>
                                <th>GRUPO</th>
                                <th>ESPECIALIDAD</th>
                                <th>CODIGO</th>
                                <th>GENERACION</th>
                                <th>EDO. CREDENCIAL</th>
                                <th></th> <!-- no visible -->
                                <th></th> <!-- no visible -->
                                <th></th> <!-- no visible -->
                                <th></th> <!-- no visible -->
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>NOMBRE</th>
                                <th>NO. CONTROL</th>
                                <th>CURP</th>
                                <th>GRUPO</th>
                                <th>ESPECIALIDAD</th>
                                <th>CODIGO</th>
                                <th>GENERACION</th>
                                <th>ESTADO CREDENCIAL</th>
                                <th></th> <!-- no visible -->
                                <th></th> <!-- no visible -->
                                <th></th> <!-- no visible -->
                                <th></th> <!-- no visible -->
                                <th>ACCIONES</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

        <div class="container-fluid">
            <hr>
            <span style="font-size: 14px;">
                © 2022 - CAE by Grupo IP México 2022
            </span>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edita_alumno" class="text-center">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4">
                                        <label for="matri">Matricula</label>
                                        <input class="form-control" type="text" id="matri" name="matri" placeholder="MATRICULA" autocomplete="OFF">
                                        <input type="hidden" id="id_save" name="id_save">
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>
                                <!-- **************************************** -->
                                <div class="row">
                                    <div class="col-lg-4 pt-3">
                                        <label for="AP">Apellido Paterno</label>
                                        <input class="form-control" type="text" id="AP" name="AP" placeholder="APELLIDO PATERNO" autocomplete="OFF">
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <label for="AM">Apellido Materno</label>
                                        <input class="form-control" type="text" id="AM" name="AM" placeholder="APELLIDO MATERNO" autocomplete="OFF">
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <label for="Nombre">Nombre/s</label>
                                        <input class="form-control" type="text" id="Nombre" name="Nombre" placeholder="NOMBRE/S" autocomplete="OFF">
                                    </div>
                                </div>
                                <!-- **************************************** -->
                                <div class="row pt-3 text-center">
                                    <div class="col-lg-4 pt-3">
                                        <label for="CURP">CURP</label>
                                        <input class="form-control" id="CURP" name="CURP" type="text" placeholder="CURP" autocomplete="OFF">
                                    </div>
                                    <div class="col-lg-2 pt-3">
                                        <label for="Grupo">Grupo</label>
                                        <select class="form-select grupo" id="Grupo" name="Grupo" onchange="update_carrera(this.value)"></select>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <label for="Especialidad">Especialidad</label>
                                        <input class="form-control" id="Especialidad" name="Especialidad" type="text" placeholder="ESPECIALIDAD" autocomplete="OFF" readonly>
                                    </div>
                                    <div class="col-lg-3 pt-3">
                                        <label for="Generacion">Generacion</label>
                                        <input class="form-control" id="Generacion" name="Generacion" type="text" placeholder="GENERACION" autocomplete="OFF">
                                    </div>
                                    <div class="col-lg-3 pt-3">
                                        <label for="Cel_alumno">Cel Alumno:</label>
                                        <input class="form-control" type="tel" id="Cel_alumno" name="Cel_alumno">
                                    </div>
                                    <div class="col-lg-3 pt-3">
                                        <label for="Cel_p1"> Cel Padre 1</label>
                                        <input class="form-control" type="tel" id="Cel_p1" name="Cel_p1">
                                    </div>
                                    <div class="col-lg-3 pt-3">
                                        <label for="Cel_p2"> Cel Padre 2</label>
                                        <input class="form-control" type="tel" id="Cel_p2" name="Cel_p2">
                                    </div>
                                </div>
                                <!-- FOTO **************************************** -->
                                <div class="row">
                                    <div class="col-lg-2 pt-3"></div>
                                    <div class="col-lg-8 pt-3">
                                        <div class="row">
                                            <div class="col-6 text-end">
                                                <img id="get_fo" src="" alt="sin foto" width="120">
                                            </div>
                                            <div class="col-6 m-auto text-start">
                                                <div class="d-inline-block">
                                                    <input class="d-none" type="file" name="carga_foto" id="carga_foto" onchange="actualiza('get_fo')">
                                                    <label class="boton-p" for="carga_foto"><img data-toggle="tooltip" data-bs-placement="top" title="Cargar foto de alumno" src="../recursos/img/svg/upload-photo.svg" alt="carga_foto" width="60"></label>
                                                </div>
                                                <div class="d-inline-block">
                                                    <button class="d-inline-block elimina_foto_alumno" style="border: none; background: none;" data-toggle="tooltip" data-bs-placement="top" title="Eliminar foto de alumno"><img src="../recursos/img/svg/delete.svg" alt="eliminar" width="55"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 pt-3"></div>
                                </div>
                                <!-- FIRMA **************************************** -->
                                <div class="row ">
                                    <div class="col-lg-2 pt-3"></div>
                                    <div class="col-lg-8 pt-3">
                                        <div class="row">
                                            <div class="col-6 text-end">
                                                <img id="get_fi" src="" alt="sin firma" width="120">
                                            </div>
                                            <div class="col-6 m-auto text-start">
                                                <div class="d-inline-block">
                                                    <input class="d-none" type="file" name="carga_firma" id="carga_firma" onchange="actualiza('get_fi')">
                                                    <label class="boton-p" for="carga_firma"><img data-toggle="tooltip" data-bs-placement="top" title="Cargar firma de alumno" src="../recursos/img/svg/upload-photo.svg" alt="carga_firma" width="60"></label>
                                                </div>
                                                <div class="d-inline-block">
                                                    <button class="d-inline-block elimina_firma_alumno" style="border: none; background: none;" data-toggle="tooltip" data-bs-placement="top" title="Eliminar firma de alumno"><img src="../recursos/img/svg/delete.svg" alt="eliminar" width="55"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"></div>
                                            <div class="col-6"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 pt-3"></div>

                                    <div class="text-center">
                                        <canvas class="d-none" id="cnv" name="cnv" style="border: 1px solid black; width: 200pt; height: 100pt;"></canvas>
                                        <br>
                                        <canvas name="SigImg" id="SigImg" style="width: 500px; height: 20px;"></canvas>
                                        <form id="FORM1" name="FORM1">
                                            <p>
                                                <input class="btn btn-sm btn-success" id="SignBtn" name="SignBtn" value="Firmar" style="width: 100px;" onclick="firma1()">&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="HIDDEN" name="bioSigData">
                                                <input type="HIDDEN" name="sigImgData">
                                                <br>
                                                <textarea class="d-none" id="DatosTexto" name="DatosTexto" rows="20" cols="50">SigString: </textarea>
                                                <textarea class="" id="DatoBase64" name="DatoBase64" rows="5" cols="50" readonly></textarea>
                                            </p>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save_update">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editar-codigo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="text-center" id="edita_codigos">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="code_1">Editando codigos de:</label>
                                    <div class="fw-bolder h4" id="nombre_editando">...</div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="code_1">Codigo CARD</label>
                                    <input class="form-control" id="code_1" name="code_1" type="text">
                                </div>
                                <div class="col-lg-4">
                                    <label for="code_2">Codigo STICK</label>
                                    <input class="form-control" id="code_2" name="code_2" type="text">
                                </div>
                                <div class="col-lg-4">
                                    <label for="code_3">Codigo KEYS</label>
                                    <input class="form-control" id="code_3" name="code_3" type="text">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save_codes" id="boton_guarda_codigos">Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="carga-masiva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="text-center" id="excel_alumnos">
                            <label for="formFile" class="form-label fw-bolder">Seleccione archivo de EXCEL</label>
                            <input class="form-control" type="file" name="masivo" accept=".xlsx, .xls" id="formFile">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary sube-masivo">Subir</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="foto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Foto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="paso1">
                            <div class="display-cover">
                                <video autoplay style="transform: scaleX(-1);"></video>
                                <canvas class="d-none"></canvas>

                                <div class="video-options">
                                    <select name="" id="" class="custom-select videoSel">
                                        <option value="">Select camera</option>
                                    </select>
                                </div>

                                <img class="screenshot-image d-none" style="transform: scaleX(-1);" alt="">
                                <img class="fondo-help d-none" src="../recursos/img/svg/men.svg" alt="">

                                <div class="controls">
                                    <button class="btn btn-danger play" title="Play"><i data-feather="play-circle"></i>
                                    </button>
                                    <button class="btn btn-info pause d-none" title="Pause"><i data-feather="pause"></i>
                                    </button>
                                    <button class="btn btn-outline-success screenshot d-none" title="ScreenShot"><i data-feather="image"></i></button>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary continuar">CONTINUAR</button>
                            </div>
                        </div>
                        <div class="paso2 d-none">
                            <div class="row">
                                <div class="col-9">
                                    <div>
                                        <!-- <h3>Demo:</h3> -->
                                        <div class="docs-demo">
                                            <div class="img-container">
                                                <img id="foto_recorte" style="transform: scaleX(-1);" alt="Picture">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none">
                                        <!-- <h3>Preview:</h3> -->
                                        <div class="docs-preview clearfix">
                                            <div class="img-preview preview-lg"></div>
                                            <div class="img-preview preview-md"></div>
                                            <div class="img-preview preview-sm"></div>
                                            <div class="img-preview preview-xs"></div>
                                        </div>

                                        <!-- <h3>Data:</h3> -->
                                        <div class="docs-data">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text" for="dataX">X</label>
                                                </span>
                                                <input type="text" class="form-control" id="dataX" placeholder="x">
                                                <span class="input-group-append">
                                                    <span class="input-group-text">px</span>
                                                </span>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text" for="dataY">Y</label>
                                                </span>
                                                <input type="text" class="form-control" id="dataY" placeholder="y">
                                                <span class="input-group-append">
                                                    <span class="input-group-text">px</span>
                                                </span>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text" for="dataWidth">Width</label>
                                                </span>
                                                <input type="text" class="form-control" id="dataWidth" placeholder="width">
                                                <span class="input-group-append">
                                                    <span class="input-group-text">px</span>
                                                </span>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text" for="dataHeight">Height</label>
                                                </span>
                                                <input type="text" class="form-control" id="dataHeight" placeholder="height">
                                                <span class="input-group-append">
                                                    <span class="input-group-text">px</span>
                                                </span>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text" for="dataRotate">Rotate</label>
                                                </span>
                                                <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                                                <span class="input-group-append">
                                                    <span class="input-group-text">deg</span>
                                                </span>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text" for="dataScaleX">ScaleX</label>
                                                </span>
                                                <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <label class="input-group-text" for="dataScaleY">ScaleY</label>
                                                </span>
                                                <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div id="actions">
                                        <div class="docs-buttons">
                                            <!-- <h3>Toolbar:</h3> -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                                                        <span class="fa fa-arrows-alt"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                                                        <span class="fa fa-crop-alt"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                                                        <span class="fa fa-search-plus"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                                                        <span class="fa fa-search-minus"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
                                                        <span class="fa fa-arrow-left"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
                                                        <span class="fa fa-arrow-right"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
                                                        <span class="fa fa-arrow-up"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
                                                        <span class="fa fa-arrow-down"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                                                        <span class="fa fa-undo-alt"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                                                        <span class="fa fa-redo-alt"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
                                                        <span class="fa fa-arrows-alt-h"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
                                                        <span class="fa fa-arrows-alt-v"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
                                                        <span class="fa fa-check"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
                                                        <span class="fa fa-times"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
                                                        <span class="fa fa-lock"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
                                                        <span class="fa fa-unlock"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
                                                        <span class="fa fa-sync-alt"></span>
                                                    </span>
                                                </button>
                                                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                                                    <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                                                        <span class="fa fa-upload"></span>
                                                    </span>
                                                </label>
                                                <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.destroy()">
                                                        <span class="fa fa-power-off"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group btn-group-crop">
                                                <button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }" <!--data-bs-toggle="modal" data-bs-target="#getCroppedCanvasModal" -->
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas({ maxWidth: 4096, maxHeight: 4096 })">
                                                        Terminar
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 160, height: 90 })">
                                                        160&times;90
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 320, height: 180 })">
                                                        320&times;180
                                                    </span>
                                                </button>
                                            </div>

                                            <!-- Show the cropped image in modal -->
                                            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body"></div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                                            </button>
                                                            <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.modal -->
                                            <!-- BOTONES OCULTOS -->
                                            <div class="d-none">
                                                <button type="button" class="btn btn-secondary" data-method="getData" data-option data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getData()">
                                                        Get Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="setData" data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setData(data)">
                                                        Set Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="getContainerData" data-option data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getContainerData()">
                                                        Get Container Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="getImageData" data-option data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getImageData()">
                                                        Get Image Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="getCanvasData" data-option data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCanvasData()">
                                                        Get Canvas Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="setCanvasData" data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setCanvasData(data)">
                                                        Set Canvas Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="getCropBoxData" data-option data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCropBoxData()">
                                                        Get Crop Box Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="setCropBoxData" data-target="#putData">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setCropBoxData(data)">
                                                        Set Crop Box Data
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="moveTo" data-option="0">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.moveTo(0)">
                                                        Move to [0,0]
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="zoomTo" data-option="1">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoomTo(1)">
                                                        Zoom to 100%
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="rotateTo" data-option="180">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotateTo(180)">
                                                        Rotate 180°
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-method="scale" data-option="-2" data-second-option="-1">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scale(-2, -1)">
                                                        Scale (-2, -1)
                                                    </span>
                                                </button>
                                                <textarea class="form-control" id="putData" placeholder="Get data to here or set data with this value"></textarea>
                                            </div>

                                        </div><!-- /.docs-buttons -->

                                        <div class="docs-toggles d-none">
                                            <!-- <h3>Toggles:</h3> -->
                                            <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                                                <label class="btn btn-primary active">
                                                    <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="0.75">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 3 / 4">
                                                        3:4
                                                    </span>
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
                                                        4:3
                                                    </span>
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
                                                        1:1
                                                    </span>
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
                                                        2:3
                                                    </span>
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
                                                        Free
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                                                <label class="btn btn-primary active">
                                                    <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
                                                        VM0
                                                    </span>
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                                                        VM1
                                                    </span>
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
                                                        VM2
                                                    </span>
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
                                                        VM3
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="dropdown dropup docs-options">
                                                <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
                                                    Toggle Options
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="toggleOptions">
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="responsive" type="checkbox" name="responsive" checked>
                                                            <label class="form-check-label" for="responsive">responsive</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="restore" type="checkbox" name="restore" checked>
                                                            <label class="form-check-label" for="restore">restore</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="checkCrossOrigin" type="checkbox" name="checkCrossOrigin" checked>
                                                            <label class="form-check-label" for="checkCrossOrigin">checkCrossOrigin</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="checkOrientation" type="checkbox" name="checkOrientation" checked>
                                                            <label class="form-check-label" for="checkOrientation">checkOrientation</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="modal" type="checkbox" name="modal" checked>
                                                            <label class="form-check-label" for="modal">modal</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="guides" type="checkbox" name="guides" checked>
                                                            <label class="form-check-label" for="guides">guides</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="center" type="checkbox" name="center" checked>
                                                            <label class="form-check-label" for="center">center</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="highlight" type="checkbox" name="highlight" checked>
                                                            <label class="form-check-label" for="highlight">highlight</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="background" type="checkbox" name="background" checked>
                                                            <label class="form-check-label" for="background">background</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="autoCrop" type="checkbox" name="autoCrop" checked>
                                                            <label class="form-check-label" for="autoCrop">autoCrop</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="movable" type="checkbox" name="movable" checked>
                                                            <label class="form-check-label" for="movable">movable</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="rotatable" type="checkbox" name="rotatable" checked>
                                                            <label class="form-check-label" for="rotatable">rotatable</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="scalable" type="checkbox" name="scalable" checked>
                                                            <label class="form-check-label" for="scalable">scalable</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="zoomable" type="checkbox" name="zoomable" checked>
                                                            <label class="form-check-label" for="zoomable">zoomable</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="zoomOnTouch" type="checkbox" name="zoomOnTouch" checked>
                                                            <label class="form-check-label" for="zoomOnTouch">zoomOnTouch</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="zoomOnWheel" type="checkbox" name="zoomOnWheel" checked>
                                                            <label class="form-check-label" for="zoomOnWheel">zoomOnWheel</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="cropBoxMovable" type="checkbox" name="cropBoxMovable" checked>
                                                            <label class="form-check-label" for="cropBoxMovable">cropBoxMovable</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="cropBoxResizable" type="checkbox" name="cropBoxResizable" checked>
                                                            <label class="form-check-label" for="cropBoxResizable">cropBoxResizable</label>
                                                        </div>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="toggleDragModeOnDblclick" type="checkbox" name="toggleDragModeOnDblclick" checked>
                                                            <label class="form-check-label" for="toggleDragModeOnDblclick">toggleDragModeOnDblclick</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div><!-- /.dropdown -->

                                            <a class="btn btn-success btn-block d-none" data-toggle="tooltip" href="https://fengyuanchen.github.io/photo-editor" title="An advanced example of Cropper.js">Photo
                                                Editor</a>

                                        </div><!-- /.docs-toggles -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="paso3 d-none">
                            <div class="row">
                                <div class="col-lg-6 text-center">
                                    <img class="preview-recorte" width="300" alt="">
                                </div>
                                <div class="col-lg-6 text-center m-auto">
                                    <div class="text-center">
                                        <img id="get_fi_2" src="" alt="sin firma" width="300">
                                        <canvas class="d-none" id="cnv_2" name="cnv_2" style="border: 1px solid black; width: 200pt; height: 100pt;"></canvas>
                                        <br>
                                        <canvas name="SigImg" id="SigImg" style="width: 500px; height: 20px;"></canvas>
                                        <form id="FORM1" name="FORM1">
                                            <p>
                                                <input class="btn btn-sm btn-success" id="SignBtn" name="SignBtn" value="Firmar" style="width: 100px;" onclick="firma2()">&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="HIDDEN" name="bioSigData">
                                                <input type="HIDDEN" name="sigImgData">
                                                <br>
                                                <textarea class="d-none" id="DatosTexto_2" name="DatosTexto_2" rows="20" cols="50">SigString: </textarea>
                                                <textarea class="" id="DatoBase64_2" name="DatoBase64_2" rows="5" cols="50" readonly></textarea>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-success">GUARDAR DATOS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!--<button type="button" class="btn btn-primary">Subir</button>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Boton Eliminar FOTO -->

        <script src="https://unpkg.com/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
        <script src="../recursos/assets/js/cae.index.js?v=<?php echo rand() ?>"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
        <script src="https://www.w3schools.com/lib/w3.js"></script>
        <script src="../recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
        <script src="../recursos/assets/js/utiles.js?v=<?php echo rand() ?>"></script>
        <script src="../recursos/assets/js/cae.credenciales.js?v=<?php echo rand() ?>"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="https://fengyuanchen.github.io/shared/google-analytics.js" crossorigin="anonymous"></script>
        <script src="./cropper.js"></script>
        <script src="./main.js"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <!-- FIRMA -->
        <script type="text/javascript">
            let imgWidth;
            let imgHeight;
            let DatosTexto = '';
            let DatoBase64 = '';
            let estancia_firma = '';
            let canvasObj = '';

            function firma1() {
                DatosTexto = $("#DatosTexto");
                DatoBase64 = $("#DatoBase64");
                ctx = document.getElementById('cnv').getContext('2d');
                estancia_firma = $('#get_fi');
                canvasObj = document.getElementById('cnv');
                StartSign();
            }

            function firma2() {
                DatosTexto = $("#DatosTexto_2");
                DatoBase64 = $("#DatoBase64_2");
                ctx = document.getElementById('cnv_2').getContext('2d');
                estancia_firma = $('#get_fi_2');
                canvasObj = document.getElementById('cnv_2');
                StartSign();
            }

            function StartSign() {

                var isInstalled = document.documentElement.getAttribute('SigPlusExtLiteExtension-installed');
                if (!isInstalled) {
                    alert("La extensión SigPlusExtLite no está instalada o está deshabilitada. Please install or enable extension.");
                    return;
                }
                canvasObj.getContext('2d').clearRect(0, 0, canvasObj.width, canvasObj.height);

                //document.FORM1.DatosTexto.value = "SigString: ";
                DatosTexto.val("SigString: ");
                //document.FORM1.DatoBase64.value = "Base64 String: ";
                DatoBase64.val("Base64 String: ");

                imgWidth = canvasObj.width;
                imgHeight = canvasObj.height;
                const message = {
                    "firstName": "",
                    "lastName": "",
                    "eMail": "",
                    "location": "",
                    "imageFormat": 1,
                    "imageX": imgWidth,
                    "imageY": imgHeight,
                    "imageTransparency": true,
                    "imageScaling": false,
                    "maxUpScalePercent": 0.0,
                    "rawDataFormat": "ENC",
                    "minSigPoints": 25
                };

                top.document.addEventListener('SignResponse', SignResponse, false);
                const messageData = JSON.stringify(message);
                const element = document.createElement("MyExtensionDataElement");
                element.setAttribute("messageAttribute", messageData);
                document.documentElement.appendChild(element);
                const evt = document.createEvent("Events");
                evt.initEvent("SignStartEvent", true, false);
                element.dispatchEvent(evt);

            }

            function SignResponse(event) {
                const str = event.target.getAttribute("msgAttribute");
                const obj = JSON.parse(str);
                SetValues(obj, imgWidth, imgHeight);
            }

            function SetValues(objResponse, imageWidth, imageHeight) {
                var obj = null;
                if (typeof(objResponse) === 'string') {
                    obj = JSON.parse(objResponse);
                } else {
                    obj = JSON.parse(JSON.stringify(objResponse));
                }

                //let ctx = canvastx;

                if (obj.errorMsg != null && obj.errorMsg !== "" && obj.errorMsg !== "undefined") {
                    alert(obj.errorMsg);
                } else {
                    if (obj.isSigned) {
                        //document.FORM1.DatoBase64.value += obj.imageData;
                        DatoBase64.val('data:image/png;base64,' + obj.imageData);
                        estancia_firma.attr("src", 'data:image/png;base64,' + obj.imageData);
                        //document.FORM1.DatosTexto.value += obj.sigString;
                        DatosTexto.val(obj.sigString);
                        const img = new Image();
                        img.onload = function() {
                            ctx.drawImage(img, 0, 0, imageWidth, imageHeight);
                        }
                        img.src = "data:image/png;base64," + obj.imageData;
                    }
                }
            }

            function ClearFormData() {
                document.FORM1.DatosTexto.value = "SigString: ";
                document.FORM1.DatoBase64.value = "Base64 String: ";
                document.getElementById('SignBtn').disabled = false;
            }
        </script>
        <!-- FOTO -->
        <script>
            feather.replace();

            const controls = document.querySelector('.controls');
            const cameraOptions = document.querySelector('.videoSel');
            const video = document.querySelector('video');
            const canvas = document.querySelector('canvas');
            const screenshotImage = document.querySelector('.screenshot-image');
            const foto_recorte = document.querySelector('#foto_recorte');
            const foto_help = $(".fondo-help");
            const buttons = [...controls.querySelectorAll('button')];
            const paso1 = $(".paso1");
            const paso2 = $(".paso2");
            let streamStarted = false;
            let st;

            const [play, pause, screenshot] = buttons;

            const constraints = {
                video: {
                    width: {
                        min: 1280,
                        ideal: 1920,
                        max: 2560,
                    },
                    height: {
                        min: 720,
                        ideal: 1080,
                        max: 1440
                    },
                }
            };

            const getCameraSelection = async () => {
                const devices = await navigator.mediaDevices.enumerateDevices();
                const videoDevices = devices.filter(device => device.kind === 'videoinput');
                //console.log(videoDevices);
                const options = videoDevices.map(videoDevice => {
                    return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
                });
                cameraOptions.innerHTML = options.join('');
            };

            play.onclick = () => {
                if (streamStarted) {
                    video.play();
                    play.classList.add('d-none');
                    pause.classList.remove('d-none');
                    return;
                }
                if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
                    const updatedConstraints = {
                        ...constraints,
                        deviceId: {
                            exact: cameraOptions.value
                        }
                    };
                    foto_help.removeClass('d-none');
                    startStream(updatedConstraints);
                }
            };

            const startStream = async (constraints) => {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleStream(stream);
                st = stream;
            };

            const handleStream = (stream) => {
                video.srcObject = stream;
                play.classList.add('d-none');
                pause.classList.remove('d-none');
                screenshot.classList.remove('d-none');
                streamStarted = true;
            };

            getCameraSelection();


            cameraOptions.onchange = () => {
                const updatedConstraints = {
                    ...constraints,
                    deviceId: {
                        exact: cameraOptions.value
                    }
                };
                startStream(updatedConstraints);
            };

            const pauseStream = () => {
                video.pause();
                play.classList.remove('d-none');
                pause.classList.add('d-none');
            };

            const doScreenshot = () => {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                screenshotImage.src = canvas.toDataURL('image/webp');
                foto_recorte.src = canvas.toDataURL('image/webp');
                screenshotImage.classList.remove('d-none');
                //$('#aspectRatio1').click();
                /*st.getTracks().forEach(function(track) {
                    track.stop();
                });
                video.pause();
                play.classList.remove('d-none');
                pause.classList.add('d-none');
                getCameraSelection();*/
            };

            pause.onclick = pauseStream;
            screenshot.onclick = doScreenshot;

            $(document).on('click', '.continuar', function() {
                video.pause();
                play.classList.remove('d-none');
                pause.classList.add('d-none');
                foto_help.addClass('d-none');
                video.srcObject = null;
                st.getTracks().forEach(function(track) {
                    track.stop();
                });
                paso1.addClass('d-none');
                paso2.removeClass('d-none');
                $('#aspectRatio1').click();
            })


            /*
            RETOMAR CAMARA
            getCameraSelection();
                const updatedConstraints = {
                    ...constraints,
                    deviceId: {
                        exact: cameraOptions.value
                    }
                };
                startStream(updatedConstraints);
            */
        </script>
    </body>

    </html>
<?php
} else {
    session_destroy();
    header('Location: ../');
}
