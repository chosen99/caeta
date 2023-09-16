<?php
session_start();
include "../../recursos/funciones/funcionesgenerales.php";
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

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>

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
        </style>
    </head>

    <body style="font-family: Helvetica, 'Helvetica Neue', Arial, sans-serif;">
    <?php
    pintarhederadmin();
    ?>
    <div class="container-fluid mt-4">
        <h1>Credencial: Registrar/Actualizar Alumno</h1>
        <div class="row">
            <div class="col-6">
                <div class="border pb-3 cae-credenciales-cuadros">
                    <span>Seleccione un plantel y grupo para iniciar con el proceso de credencialización <strong>(Nuevos alumnos)</strong>:</span>
                    <form id="nuevos" method="post">
                        <div class="row text-center">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <label for="plantel_nuevos"><strong>Plantel</strong></label>
                                <select class="form-select text-center" name="plantel_nuevos" id="plantel_nuevos" required>
                                    <option selected disabled>- Seleccione una opción -</option>
                                    <option value="admin">admin</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <label for="grupo_nuevos"><strong>Grupo</strong></label>
                                <select class="form-select text-center" name="grupo_nuevos" id="grupo_nuevos" required onchange="$('#bunton').click()">
                                    <option selected disabled>- Seleccione una opción -</option>
                                    <option value="admin">admin</option>
                                </select>
                            </div>
                        </div>
                        <button class="consulta_n d-none" id="bunton" type="submit"></button>
                    </form>
                </div>
            </div>
            <div class="col-6">
                <div class="border pb-3 cae-credenciales-cuadros">
                    <span>Seleccione un plantel y grupo para iniciar con el proceso de credencialización <strong>(Actualizar alumnos)</strong>:</span>
                    <form id="actualizar">
                        <div class="row text-center">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <label for="plantel_actualiza"><strong>Plantel</strong></label>
                                <select class="form-select text-center" name="plantel_actualiza" id="plantel_actualiza">
                                    <option selected disabled>- Seleccione una opción -</option>
                                    <option value="admin">admin</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <label for="grupo_actualiza"><strong>Grupo</strong></label>
                                <select class="form-select text-center" name="grupo_actualiza" id="grupo_actualiza">
                                    <option selected disabled>- Seleccione una opción -</option>
                                    <option value="admin">admin</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container-fluid">
            <div class="divider"><span></span><span>Información Alumno</span><span></span></div>
            <div class="row text-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label for="apellidoP_N">Apellido Paterno</label>
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label for="apellidoP_N">Apellido Materno</label>
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3"></div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label for="apellidoP_N">Nombre</label>
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label for="apellidoP_N">CURP</label>
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3"></div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label for="apellidoP_N">Matricula</label>
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label for="apellidoP_N">Teléfono</label>
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3"></div>
                    </div>
                </div>
            </div>
            <!-- FIRMA -->

            <div class="divider"><span></span><span>FIRMA</span><span></span></div>

            <div class="text-center">
                <div class="contenedor">

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="draw-canvas" width="400" height="150">
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
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <hr>
        <span style="font-size: 14px;">
            © 2022 - CAE by Grupo IP México 2022
        </span>
    </div>
    <!-- Menu lateral -->
    <div id="test">
        <div class="list-group">
            <table class="table table-striped table-hover tabla-slide-r">
                <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Apellido P</th>
                    <th>Apellido M</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><button class="btn btn-outline-warning">000123</button></td>
                    <td>Andrés</td>
                    <td>Toledo</td>
                    <td>López</td>
                </tr>
                <tr>
                    <td><button class="btn btn-outline-warning">0001234</button></td>
                    <td>Bryan</td>
                    <td>Guevara</td>
                    <td>Pérez</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../recursos/assets/js/cae.index.js?v=<?php echo rand() ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script src="../recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="../recursos/assets/js/utiles.js?v=<?php echo rand() ?>"></script>
    <script src="../recursos/assets/js/cae.credenciales.js?v=<?php echo rand() ?>"></script>
    <script src="../recursos/assets/js/BootSideMenu.js"></script>
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
    </body>
    </html>
    <?php
} else {
    session_destroy();
    header('Location: ../');
}