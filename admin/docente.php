<?php
session_start();
const HOME_PATH = "./";
const PLANTELES_PATH = "./planteles.php";
const ALUMNOS_PATH = "./alumno.php";
const PERSONAL_PATH = "#";
const MENSAJE_PATH = "#";
const ASISTENCIA_PATH = "#";
include "../recursos/funciones/funcionesgenerales.php";

if (isset($_SESSION['log'])) {
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
        <link rel="stylesheet" href="../recursos/assets/css/cae.alumnos.scss?v=<?php echo rand();?>">
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
    <div class="container mt-4">
        <h1>Credencial: Registrar/Actualizar Docente</h1>
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

    <div id="nu" style="display: block;">
        <div class="container-fluid">
            <div class="text-end pb-2">
                <button class="btn btn-success">Imprimir</button>
                <button class="btn btn-danger">Eliminar</button>
            </div>
            <div class="table-responsive">
                <table id="docentes" class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th></th>
                        <th>NOMBRE</th>
                        <th>RFC</th>
                        <th>CURP</th>
                        <th>AREA DE ADSCRIPCÓN</th>
                        <th>PUESTO</th>
                        <th>AREA DE SERVICIO</th>
                        <th>CODIGO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>NOMBRE</th>
                        <th>RFC</th>
                        <th>CURP</th>
                        <th>AREA DE ADSCRIPCÓN</th>
                        <th>PUESTO</th>
                        <th>AREA DE SERVICIO</th>
                        <th>CODIGO</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../recursos/assets/js/cae.index.js?v=<?php echo rand() ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script src="../recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="../recursos/assets/js/utiles.js?v=<?php echo rand() ?>"></script>
    <script src="../recursos/assets/js/cae.docentes.js?v=<?php echo rand() ?>"></script>
    <script src="../recursos/assets/js/BootSideMenu.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        /*
            https://stipaltamar.github.io/dibujoCanvas/
            https://developer.mozilla.org/samples/domref/touchevents.html - https://developer.mozilla.org/es/docs/DOM/Touch_events
            http://bencentra.com/canvas/signature/signature.html - https://bencentra.com/code/2014/12/05/html5-canvas-touch-events.html
    */

        (function() { // Comenzamos una funcion auto-ejecutable

            // Obtenenemos un intervalo regular(Tiempo) en la pamtalla
            window.requestAnimFrame = (function (callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function (callback) {
                        window.setTimeout(callback, 1000/60);
                        // Retrasa la ejecucion de la funcion para mejorar la experiencia
                    };
            })();

            // Traemos el canvas mediante el id del elemento html
            var canvas = document.getElementById("draw-canvas");
            var ctx = canvas.getContext("2d");


            // Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
            var drawText = document.getElementById("draw-dataUrl");
            var drawImage = document.getElementById("draw-image");
            var clearBtn = document.getElementById("draw-clearBtn");
            var submitBtn = document.getElementById("draw-submitBtn");
            clearBtn.addEventListener("click", function (e) {
                // Definimos que pasa cuando el boton draw-clearBtn es pulsado
                clearCanvas();
                drawImage.setAttribute("src", "");
            }, false);
            // Definimos que pasa cuando el boton draw-submitBtn es pulsado
            submitBtn.addEventListener("click", function (e) {
                var dataUrl = canvas.toDataURL();
                drawText.innerHTML = dataUrl;
                drawImage.setAttribute("src", dataUrl);
            }, false);

            // Activamos MouseEvent para nuestra pagina
            var drawing = false;
            var mousePos = { x:0, y:0 };
            var lastPos = mousePos;
            canvas.addEventListener("mousedown", function (e)
            {
                /*
                  Mas alla de solo llamar a una funcion, usamos function (e){...}
                  para mas versatilidad cuando ocurre un evento
                */
                var tint = document.getElementById("color");
                var punta = document.getElementById("puntero");
                console.log(e);
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);
            canvas.addEventListener("mouseup", function (e)
            {
                drawing = false;
            }, false);
            canvas.addEventListener("mousemove", function (e)
            {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Activamos touchEvent para nuestra pagina
            canvas.addEventListener("touchstart", function (e) {
                mousePos = getTouchPos(canvas, e);
                console.log(mousePos);
                e.preventDefault(); // Prevent scrolling when touching the canvas
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchend", function (e) {
                e.preventDefault(); // Prevent scrolling when touching the canvas
                var mouseEvent = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchleave", function (e) {
                // Realiza el mismo proceso que touchend en caso de que el dedo se deslice fuera del canvas
                e.preventDefault(); // Prevent scrolling when touching the canvas
                var mouseEvent = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchmove", function (e) {
                e.preventDefault(); // Prevent scrolling when touching the canvas
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);

            // Get the position of the mouse relative to the canvas
            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                /*
                  Devuelve el tamaño de un elemento y su posición relativa respecto
                  a la ventana de visualización (viewport).
                */
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                };
            }

            // Get the position of a touch relative to the canvas
            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                console.log(touchEvent);
                /*
                  Devuelve el tamaño de un elemento y su posición relativa respecto
                  a la ventana de visualización (viewport).
                */
                return {
                    x: touchEvent.touches[0].clientX - rect.left, // Popiedad de todo evento Touch
                    y: touchEvent.touches[0].clientY - rect.top
                };
            }

            // Draw to the canvas
            function renderCanvas() {
                if (drawing) {
                    var tint = document.getElementById("color");
                    var punta = document.getElementById("puntero");
                    ctx.strokeStyle = tint.value;
                    ctx.beginPath();
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    console.log(punta.value);
                    ctx.lineWidth = punta.value;
                    ctx.stroke();
                    ctx.closePath();
                    lastPos = mousePos;
                }
            }

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Allow for animation
            (function drawLoop () {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

        })();

    </script>
    <script>
        const video = document.querySelector('#video');
        const controles = document.querySelector('.controles');
        const botones = [...controles.querySelectorAll('button')];
        const canvas = document.querySelector('.canvas');
        const editor = document.querySelector('#editor');
        // El canvas donde se mostrará la previa
        const miCanvas = document.querySelector('#preview');
        // Contexto del canvas
        const contexto = miCanvas.getContext('2d');

        const [play, pause, screenshot] = botones;

        const restricciones = {
            video: {
                width: {
                    //min: 1280,
                    ideal: 1920,
                    //max: 2560,
                },
                height: {
                    //min: 720,
                    ideal: 1080,
                    //max: 1440
                },
                facingMode: 'environment'
            }
        };

        play.onclick = () => {
            navigator.mediaDevices.getUserMedia(restricciones).then(function (mediaStream) {
                video.srcObject = mediaStream;
                video.play();
                $("#video").removeClass("d-none");
            });
            //$("#lineas").css({"width":$("#video").width(), "height":$("#video").height()});
            $("#svg-foto").css("display","block");
            $(".svg-foto").attr("style", "width:"+($("#video").width()+80)/2+"px; z-index: 999!important; position: relative; left: 25%!important;");
        };

        document.querySelector('#capture').addEventListener('click', function (e) {
            /*canvas.height = video.videoHeight;
            canvas.width = video.videoWidth;*/
            //console.log(video.videoHeight*0.1 + " " + video.videoWidth*0.1)
            $("#canvas").width(video.videoHeight*0.1).height(video.videoWidth*0.1);
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            //$(".ss").width(video.videoWidth*.7).height(video.videoHeight*.7);
            const mediaStream = video.srcObject;
            const tracks = mediaStream.getTracks();
            tracks[0].stop();
            tracks.forEach(track => track.stop());
            $("#video").addClass('d-none');
            editar();

            //var context = canvas.getContext('2d');
            //context.drawImage(video, 0, 0) //150, 200, 500, 300, 60,60, 500, 300
        });
        function editar(){
            // Ruta de la imagen
            urlImage = canvas.toDataURL('image/webp');

            // Borra editor en caso que existiera una imagen previa
            editor.innerHTML = '';
            let cropprImg = document.createElement('img');
            cropprImg.setAttribute('id', 'croppr');
            editor.appendChild(cropprImg);

            // Limpia la previa en caso que existiera algún elemento previo
            contexto.clearRect(0, 0, miCanvas.width, miCanvas.height);

            // Envia la imagen al editor para su recorte
            document.querySelector('#croppr').setAttribute('src', urlImage);

            // Crea el editor
            new Croppr('#croppr', {
                aspectRatio: 1,
                startSize: [70, 70],
                onCropEnd: recortarImagen
            })
        }
        /**
         * Método que recorta la imagen con las coordenadas proporcionadas con croppr.js
         */
        function recortarImagen(data) {
            // Variables
            const inicioX = data.x;
            const inicioY = data.y;
            const nuevoAncho = data.width;
            const nuevaAltura = data.height;
            const zoom = 1;
            let imagenEn64 = '';
            // La imprimo
            miCanvas.width = nuevoAncho;
            miCanvas.height = nuevaAltura;
            // La declaro
            let miNuevaImagenTemp = new Image();
            // Cuando la imagen se carge se procederá al recorte
            miNuevaImagenTemp.onload = function() {
                // Se recorta
                contexto.drawImage(miNuevaImagenTemp, inicioX, inicioY, nuevoAncho * zoom, nuevaAltura * zoom, 0, 0, nuevoAncho, nuevaAltura);
                // Se transforma a base64
                imagenEn64 = miCanvas.toDataURL("image/png");
                // Mostramos el código generado
                document.querySelector('#base64').textContent = imagenEn64;
                document.querySelector('#base64HTML').textContent = '<img src="' + imagenEn64.slice(0, 40) + '...">';

            }
            // Proporciona la imagen cruda, sin editarla por ahora
            miNuevaImagenTemp.src = urlImage;
        }
    </script>
    </body>
    </html>
    <?php
} else {
    session_destroy();
    header('Location: ../');
}