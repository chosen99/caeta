<?php
session_start();
$_SESSION['csrf_CAE'] = md5(uniqid(mt_rand(), true));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Login CAE</title>
    <link rel="shortcut icon" href="./recursos/img/IPMico.ico" sizes="32x32">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recursos/assets/bootstrap-5.0.2/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="recursos/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- SWEET ALERT -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="./recursos/assets/css/login.css?v=<?php echo rand();?>">
    <link rel="stylesheet" href="./recursos/assets/css/utiles.css?v=<?php echo rand();?>">
</head>

<body>
<nav class="d-flex bg-opacity-100 py-2" style="background-color: rgb(34,34,34);">
    <div class="text-black text-warning" style="margin-left: 20pt; font-weight: bolder;">
        CAE - Control de Asistencia Escolar
    </div>
</nav>
<div class="text-center mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <section id="content">
                    <span id="Msg" style="color:Maroon;"></span><br/>
                    <form id="form_login" class="form" method="post">
                        <div class="sesion">
                            Iniciar sesión
                        </div>
                        <span class="failureNotification"></span>
                        <div class="Login">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_CAE'] ?? '' ?>">
                            <div>
                                <div class="input-group flex-nowrap mb-4">
                                    <span class="input-group-text" id="addon-wrapping"><img src="./recursos/img/svg/school.svg" alt="school" width="32"></span>
                                    <select class="form-select textbox" name="escuela" id="escuela" style="color: darkred; font-weight: bolder;" required>
                                        <option disabled selected value="null">PLANTEL</option>
                                        <option value="cae">ADMIN</option>
                                        <option value="cetis49">CETIS 49</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="input-group flex-nowrap mb-4">
                                    <span class="input-group-text" id="addon-wrapping"><img src="./recursos/img/svg/user.svg" alt="user" width="32"></span>
                                    <input type="text" class="form-control textbox" placeholder="Nombre de usuario" name="usuario" id="usuario" aria-label="Nombre de usuario" aria-describedby="addon-wrapping" required>
                                </div>
                            </div>
                            <div>
                                <div class="input-group flex-nowrap mb-4">
                                    <span class="input-group-text" id="addon-wrapping"><img src="./recursos/img/svg/padlock.svg" alt="pwd" width="32"></span>
                                    <input type="text" class="form-control textbox" placeholder="Contraseña" name="pwd" id="pwd" aria-label="Contraseña" aria-describedby="addon-wrapping" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <button name="LoginUser" class="button login">Iniciar sesión</button>
                                </div>
                            </div>
                            <br>
                            <div style="">
                                <a href="#" id="LoginUser_CloseSesion"
                                   title="Recuperar contraseña">¿Has olvidado la contraseña de tu cuenta?</a><br/>
                            </div>
                            <br/>
                        </div>
                    </form>
                </section>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script src="recursos/assets/js/login.js?v=<?php echo rand();?>"></script>

</body>
</html>
