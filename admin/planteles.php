<?php
session_start();
const HOME_PATH = "./";
const PLANTELES_PATH = "#";
const ALUMNOS_PATH = "./alumno.php";
const PERSONAL_PATH = "./docente.php";
const MENSAJE_PATH = "#";
const ASISTENCIA_PATH = "#";
include "../recursos/funciones/funcionesgenerales.php";
if (isset($_SESSION['log'])) {
    $dbs = array(
        0 => "gcae_cetis37",
        1 => "gcae_cetis64"
    );
    for ($i = 0; $i<count($dbs); $i++){
        $conex = new mysqli("localhost","root","",$dbs[$i]);
        $datos[] = $conex->query("SELECT Nombre, CURP, RFC, DireccionF, CCT, Personaje, NombreLargo, NombreCorto, Permisos FROM administracion WHERE id = 1")->fetch_assoc();
        $conex->close();
    }
    $tb = '';
    for ($i = 0; $i<count($datos); $i++){
        if ($datos[$i]['Permisos'] == 0){
            $edo = '<strong style="color: red;">INACTIVO</strong><br><input type="checkbox">';
        }else{
            $edo = '<strong style="color: green;">ACTIVO</strong><br><input type="checkbox">';
        }
        $tb .= '
        <tbody>
            <tr>
            <td>'.$datos[$i]['NombreCorto'].'</td>
                <td>'.$datos[$i]['Nombre'].'</td>
                <td>'.$datos[$i]['CURP'].'</td>
                <td>'.$datos[$i]['RFC'].'</td>
                <td>'.$datos[$i]['DireccionF'].'</td>
                <td>'.$datos[$i]['CCT'].'</td>
                <td>'.$datos[$i]['Personaje'].'</td>
                <td>'.$datos[$i]['NombreLargo'].'</td>
                <td>'.$edo. '</td>
                <td width="101">
                    <button class="editar_plantel" style="border: none; background: none;" value="'.$dbs[$i].'" data-bs-toggle="modal" data-bs-target="#editar"><img src="../recursos/img/svg/edit.svg" alt="editar" width="32"></button>
                    <button style="border: none; background: none;"><img src="../recursos/img/svg/delete.svg" alt="delete" width="32"></button>
                </td>
            </tr>
        </tbody>
        ';
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>CAE - Credencializacion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/css/bootstrap-utilities.min.css">
        <link rel="stylesheet" href="../recursos/assets/css/utiles.css?v=<?php echo rand();?>">
        <link rel="stylesheet" href="../recursos/assets/css/BootSideMenu.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            td{
                vertical-align: middle;
            }
            .boton-p{
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

            section{
                flex:1;
            }

            .button {
                background: #3071a9;
                box-shadow: inset 0 -3px 0 rgba(0,0,0,.3);
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
                width: 100%
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
                align-items:center;
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
            .error{
                display: block;
                text-align: center;
                position: relative;
                padding-top: 10pt;
            }
            video {
                /*position: fixed;
                left: 25%;
                top: 100px;*/
                z-index: -1;
            }
            #sect1{
                position: absolute;
                left: 30%;
                z-index: 999;
            }
        </style>
    </head>

    <body style="font-family: Helvetica, 'Helvetica Neue', Arial, sans-serif;">
    <?php
    pintarhederadmin();
    ?>
    <div class="container mt-4"></div>

    <!-- REGISTRO DE ALUMNO -->

    <div id="nu" style="display: block;">
        <div class="container-fluid">
            <div class="text-end pb-2">
                <button class="btn btn-success" data-toggle="tooltip" data-bs-placement="top" title="Agregar plantel"><strong>ADD</strong><img src="../recursos/img/svg/add.svg" alt="add" width="32"></button>
            </div>
            <div class="table-responsive">
                <table id="alumnos" class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>NOMBRE CORTO</th>
                        <th>NOMBRE</th>
                        <th>CURP</th>
                        <th>RFC</th>
                        <th>DIRECCION</th>
                        <th>CCT</th>
                        <th>PERSONAJE</th>
                        <th>NOMBRE LARGO</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <?php echo $tb; ?>
                    <tfoot>
                    <tr>
                        <th>NOMBRE CORTO</th>
                        <th>NOMBRE</th>
                        <th>CURP</th>
                        <th>RFC</th>
                        <th>DIRECCION</th>
                        <th>CCT</th>
                        <th>PERSONAJE</th>
                        <th>NOMBRE LARGO</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <!--
            <div class="divider"><span></span><span>Fotografía</span><span></span></div>
            <div>
                <div class="controles">
                    <button class="btn btn-danger play">Play</button>
                    <button class="btn btn-info pause" title="Pause">Pause</button>
                    <button id='capture' class="btn btn-outline-success screenshot" title="ScreenShot">Foto</button>
                </div>

                <div class="container-fluid text-center border">
                    <div class="m-auto">
                        <div class="div-foto" id="sect1">
                            <img src="../../recursos/img/svg/foto.svg" class="svg-foto" id="svg-foto" alt="foto" style="z-index: 999!important;">
                        </div>
                        <video id='video' style="width: 50%; height: 50%; transform: scaleX(-1); top: -400px!important;"></video>

                    </div>
                    <canvas class="canvas d-none"></canvas>
                </div>

                <div class="container-fluid">
                    <div class="m-auto" style="width: 70%; height: 70%;">
                        <div id="editor"></div>
                        <canvas id="preview" style="width: 50%; height: 50%;"></canvas>
                        <code id="base64"></code>
                    </div>
                </div>
            </div>

            <div class="divider"><span></span><span>Información Alumno</span><span></span></div>
            <div class="row text-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div>
                                <label for="apellidoP">Apellido Paterno</label>
                                <input class="form-control" id="apellidoP" name="apellidoP" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div>
                                <label for="apellidoM">Apellido Materno</label>
                                <input class="form-control" id="apellidoM" name="apellidoM" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2"></div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div>
                                <label for="Nombre">Nombre</label>
                                <input class="form-control" id="Nombre" name="Nombre" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div>
                                <label for="curp">CURP</label>
                                <input class="form-control" id="curp" name="curp" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2"></div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div>
                                <label for="matri">Matricula</label>
                                <input class="form-control" id="matri" name="matri" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div>
                                <label for="apellidoP_N">Teléfono</label>
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2"></div>
                    </div>
                </div>
            </div> -->
            <!-- FIRMA -->
            <!--
            <div class="divider"><span></span><span>FIRMA</span><span></span></div>

            <div class="text-center">
                <div class="contenedor">

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="draw-canvas" width="600" height="200">
                                No tienes un buen navegador.
                            </canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="button" class="button" id="draw-submitBtn" value="Generar FIRMA">
                            <input type="button" class="button" id="draw-clearBtn" value="Borrar">

                            <div style="display: none;">
                                <label for="color">Color</label>
                                <input type="color" id="color">
                            </div>
                            <div style="display: none;">
                                <label for="puntero">Tamaño pincel</label>
                                <input type="range" id="puntero" min="1" value="4" max="5" width="10%">
                            </div>

                        </div>

                    </div>

                    <div style="display: none;">
                        <textarea id="draw-dataUrl" class="form-control" rows="5">Base 64</textarea>
                    </div>
                    <br/>
                    <div class="contenedor">
                        <div class="col-md-12">
                            <img id="draw-image" src="" alt="Tu firma aparecera Aquí!"/>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <div class="container-fluid">
        <hr>
        <span style="font-size: 14px;">
            © 2022 - CAE by Grupo IP México 2022
        </span>
    </div>
    <!-- Menu lateral -->
    <!--
    <div id="menu-lat">
        <div class="list-group">
            <table id="tablaCredenciales" class="table table-striped table-hover tabla-slide-r">
                <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Apellido P</th>
                    <th>Apellido M</th>
                </tr>
                </thead>
                <tbody id="tb-nuevacred">
                </tbody>
            </table>
        </div>
    </div> -->

    <!-- Modal -->
    <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDITAR INFO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="info_plantel">
                        <div class="row text-center">
                            <div class="col-lg-4">
                                <label for="">Nombre</label>
                                <input class="form-control" type="text" id="" name="">
                            </div>
                            <div class="col-lg-4">
                                <label for="">CURP</label>
                                <input class="form-control" type="text" id="" name="">
                            </div>
                            <div class="col-lg-4">
                                <label for="">RFC</label>
                                <input class="form-control" type="text" id="" name="">
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-6">
                                <label for="">Direccion Fisica</label>
                                <textarea class="form-control" name="" id="" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-lg-6 m-auto">
                                <label for="">Nombre largo</label>
                                <textarea class="form-control" name="" id="" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-lg-4 m-auto">
                                <label for="">Nombre corto</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="col-lg-4">
                                <label for="">Personaje</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="col-lg-4 m-auto">
                                <label for="">CCT</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <label for="">Carreras</label>
                                <textarea class="form-control" name="carreras_grupos" id="carreras_grupos" cols="30" rows="6"></textarea>
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
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="../recursos/assets/js/cae.index.js?v=<?php echo rand() ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script src="../recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="../recursos/assets/js/utiles.js?v=<?php echo rand() ?>"></script>
    <script src="../recursos/assets/js/cae.planteles.js?v=<?php echo rand() ?>"></script>
    <script src="../recursos/assets/js/BootSideMenu.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    </body>
    </html>
    <?php
} else {
    session_destroy();
    header('Location: ../');
}