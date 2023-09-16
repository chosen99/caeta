<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>CAE</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="./recursos/img/IPMico.ico" sizes="32x32">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recursos/assets/bootstrap-5.0.2/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- SWEET ALERT -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Styles -->
    <style>
        button {
            font-family: Consolas, serif;
        }

        .myButton {
            -moz-box-shadow: 0px 2px 17px 5px #276873;
            -webkit-box-shadow: 2px 0px 19px 6px #276873;
            box-shadow: 2px 0px 19px 6px #276873;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #599bb3), color-stop(1, #408c99));
            background: -moz-linear-gradient(top, #599bb3 5%, #408c99 100%);
            background: -webkit-linear-gradient(top, #599bb3 5%, #408c99 100%);
            background: -o-linear-gradient(top, #599bb3 5%, #408c99 100%);
            background: -ms-linear-gradient(top, #599bb3 5%, #408c99 100%);
            background: linear-gradient(to bottom, #599bb3 5%, #408c99 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#599bb3', endColorstr='#408c99', GradientType=0);
            background-color: #599bb3;
            -moz-border-radius: 14px;
            -webkit-border-radius: 14px;
            border-radius: 14px;
            border: 3px solid #29668f;
            display: inline-block;
            cursor: pointer;
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
            padding: 13px 32px;
            text-decoration: none;
            text-shadow: 0px 1px 0px #3d768a;
            height: 88px;
            width: 88px;
            font-family: Consolas, serif;
        }

        .myButton:hover {
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #408c99), color-stop(1, #599bb3));
            background: -moz-linear-gradient(top, #408c99 5%, #599bb3 100%);
            background: -webkit-linear-gradient(top, #408c99 5%, #599bb3 100%);
            background: -o-linear-gradient(top, #408c99 5%, #599bb3 100%);
            background: -ms-linear-gradient(top, #408c99 5%, #599bb3 100%);
            background: linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#408c99', endColorstr='#599bb3', GradientType=0);
            background-color: #408c99;
        }

        .myButton:active {
            position: relative;
            top: 1px;
        }

        .btnborrar {
            -moz-box-shadow: 4px 1px 35px 2px #f5978e;
            -webkit-box-shadow: 4px 1px 35px 2px #f5978e;
            box-shadow: 4px 1px 35px 2px #f5978e;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f24537), color-stop(1, #c62d1f));
            background: -moz-linear-gradient(top, #f24537 5%, #c62d1f 100%);
            background: -webkit-linear-gradient(top, #f24537 5%, #c62d1f 100%);
            background: -o-linear-gradient(top, #f24537 5%, #c62d1f 100%);
            background: -ms-linear-gradient(top, #f24537 5%, #c62d1f 100%);
            background: linear-gradient(to bottom, #f24537 5%, #c62d1f 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f24537', endColorstr='#c62d1f', GradientType=0);
            background-color: #f24537;
            -moz-border-radius: 17px;
            -webkit-border-radius: 17px;
            border-radius: 17px;
            border: 3px solid #d02718;
            display: inline-block;
            cursor: pointer;
            color: #ffffff;
            font-family: Verdana;
            font-size: 19px;
            padding: 0px 0px;
            text-decoration: none;
            text-shadow: 0px -50px 50px #810e05;

        }

        .btnborrar:hover {
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #c62d1f), color-stop(1, #f24537));
            background: -moz-linear-gradient(top, #c62d1f 5%, #f24537 100%);
            background: -webkit-linear-gradient(top, #c62d1f 5%, #f24537 100%);
            background: -o-linear-gradient(top, #c62d1f 5%, #f24537 100%);
            background: -ms-linear-gradient(top, #c62d1f 5%, #f24537 100%);
            background: linear-gradient(to bottom, #c62d1f 5%, #f24537 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#c62d1f', endColorstr='#f24537', GradientType=0);
            background-color: #c62d1f;
        }

        .btnborrar:active {
            position: relative;
            top: 1px;
        }

        .btnok {
            -moz-box-shadow: 4px 1px 35px 2px #3dc21b;
            -webkit-box-shadow: 4px 1px 35px 2px #3dc21b;
            box-shadow: 4px 1px 35px 2px #3dc21b;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #40bd62), color-stop(1, #61b832));
            background: -moz-linear-gradient(top, #40bd62 5%, #61b832 100%);
            background: -webkit-linear-gradient(top, #40bd62 5%, #61b832 100%);
            background: -o-linear-gradient(top, #40bd62 5%, #61b832 100%);
            background: -ms-linear-gradient(top, #40bd62 5%, #61b832 100%);
            background: linear-gradient(to bottom, #40bd62 5%, #61b832 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#40bd62', endColorstr='#61b832', GradientType=0);
            background-color: #40bd62;
            -moz-border-radius: 17px;
            -webkit-border-radius: 17px;
            border-radius: 17px;
            border: 3px solid #1d9e29;
            display: inline-block;
            cursor: pointer;
            color: #ffffff;
            font-family: Verdana;
            font-size: 19px;
            padding: 0px 0px;
            text-decoration: none;
            text-shadow: 0px -50px 50px #2f6627;
        }

        .btnok:hover {
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #61b832), color-stop(1, #40bd62));
            background: -moz-linear-gradient(top, #61b832 5%, #40bd62 100%);
            background: -webkit-linear-gradient(top, #61b832 5%, #40bd62 100%);
            background: -o-linear-gradient(top, #61b832 5%, #40bd62 100%);
            background: -ms-linear-gradient(top, #61b832 5%, #40bd62 100%);
            background: linear-gradient(to bottom, #61b832 5%, #40bd62 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#61b832', endColorstr='#40bd62', GradientType=0);
            background-color: #61b832;
        }

        .btnok:active {
            position: relative;
            top: 1px;
        }

        input {
            background-color: transparent;
            border: 0px solid;
            height: 20px;
            width: 160px;
            color: #CCC;
        }

        .newviewsel {
            background-color: rgba(89, 155, 179);
            color: black !important;
            font-weight: bolder !important;
            height: auto !important;
            border: 4px solid #29668f !important;
            border-radius: 12px !important;
            padding: 10px 10px 10px 10px !important;
            display: block;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
            line-height: 1.3;
            width: 400px;
            max-width: 100%;
            box-shadow: 0 1px 0 1px rgba(0, 0, 0, .03);
            /*-moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;*/
            background-repeat: no-repeat, repeat;
            background-position: right .7em top 50%, 0 0;
            background-size: .65em auto, 100%;
        }

        .newviewsel:hover {
            box-shadow: 1px 1px 30px 1px rgb(105, 28, 50);
        }
    </style>
</head>
<!-- TODO implementar CSRF -->
<body style="background-color: rgb(26, 32, 44);">
<nav class="navbar navbar-light">
    <div class="container-fluid">
        <div class="navbar-brand text-warning">Control de Asistencia Escolar</div>
        <div class="d-flex">
            <button class="btn btn-outline-success" onclick="window.location='./login.php';">LOG IN</button>
        </div>
    </div>
</nav>

<div class="items-top justify-center min-h-screen sm:items-center">
    <div>
        <form>
            <select class="newviewsel text-center" name="escuela" id="escuela" style="margin: auto;">
                <option disabled selected value="null">PLANTEL</option>
                <option value="cae">CAE</option>
                <option value="cetis49">CETIS 49</option>
            </select>
            <div class="form-group">

                <div class="text-center">
                    <input name="codigo" type="text" id="codigo" class="form-control my-3" autocomplete="off" placeholder="---" style="color: aliceblue; height:52px;width:413px;text-align:center; font-size:25px; margin: auto; font-family: Consolas,serif; background-color: transparent; border: none;"/>
                </div>

            </div>
            <div class="text-center">
                <table style="margin: auto;">
                    <tr>
                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="7"><br/><br/>
                        </th>

                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="8"><br/><br/>
                        </th>

                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="9"><br/><br/>
                        </th>
                    </tr>
                    <tr>
                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="4"><br/><br/>
                        </th>

                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="5"><br/><br/>
                        </th>

                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="6"><br/><br/>
                        </th>
                    </tr>
                    <tr>
                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="1"><br/><br/>
                        </th>

                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="2"><br/><br/>
                        </th>

                        <th><input type="button" class="myButton" onclick="escribir(this.value)" value="3"><br/><br/>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <button type="button" class="myButton" onclick="escribir(this.value)" value="0">0</button>
                        </th>
                        <th>
                            <input type="button" class="btnborrar" onclick="deletecarac()" value="<<" style="height: 88px; width: 88px">
                        </th>
                        <th>
                            <button name="ButtonOk" id="ButtonOk" class="btnok consultar" value="OK" style="height:88px;width:88px;">OK</button></th>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script type="text/javascript">

    $(document).on('click', '.consultar', function (e){
        e.preventDefault();
        let plantel = document.getElementById('escuela').value;
        if (plantel === "null"){
            Swal.fire({
                icon: 'error',
                title: 'Plantel no selecionado',
                text: 'Por favor seleccione su plantel.'
            });
        }
    });

    function deletecarac() {
        var caja2 = document.getElementById('codigo').value;
        document.getElementById('codigo').value = caja2.substring(0, caja2.length - 1);
    }

    function escribir(n) {
        let codigo = document.getElementById('codigo').value;
        document.getElementById('codigo').value = codigo + n;
    }

</script>
</body>
</html>