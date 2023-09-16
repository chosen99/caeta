<?php
session_start();
include "../recursos/funciones/funcionesgenerales.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Login CAE</title>
    <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js">
    <link href="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.0/dist/croppr.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.0/dist/croppr.min.js"></script>
    <style>
        table, td {
            border: 2px dashed red;
            border-collapse: collapse;
        }
        video {
            position: fixed;
            left: 25%;
            top: 100px;
            z-index: -1;
        }
        #sect1{
            position: fixed;
            left: 25%;
            top: 100px;
            z-index: -1;
        }
    </style>
</head>

<body>
<?php
pintarhedergeneral();
?>

<div class="controles">
    <button class="btn btn-danger play">Play</button>
    <button class="btn btn-info pause" title="Pause">Pause</button>
    <button id='capture' class="btn btn-outline-success screenshot" title="ScreenShot">Foto</button>
</div>

<div class="container-fluid text-center border">
    <div class="m-auto">
        <video id='video' style="width: 50%; height: 50%; transform: scaleX(-1)"></video>
        <section id="sect2">
            <img src="../recursos/img/svg/foto.svg" class="svg-foto" id="svg-foto" alt="foto" style="display: block;">
        </section>
        <!-- <section id="sect1" class="sect">
            <table id="lineas" style="z-index: 10;">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </section> -->
    </div>
    <section id="sect1">
        <img src="../recursos/img/svg/foto.svg" alt="foto">
    </section>
    <canvas class="canvas d-none"></canvas>
</div>

<div class="container-fluid">
    <div class="m-auto" style="width: 70%; height: 70%;">
        <div id="editor"></div>
        <canvas id="preview" style="width: 50%; height: 50%;"></canvas>
        <code id="base64"></code>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
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
        $(".svg-foto").attr("style", "width:"+($("#video").width())/2+"px;");
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