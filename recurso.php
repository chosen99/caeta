<?php
session_start();
$_SESSION['db'] = "gcae_".$_POST['escuela'];
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
if (!$token || $token !== $_SESSION['csrf_CAE']) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
} else {
    // TODO redireccionar segun corresponda usuario
    include_once("./conexion/connexion.php");
    $login = new con();
    $login->selectASSOC("SELECT * FROM admin");
    if ($login->assoc[0]['pwd'] == md5($_POST['pwd']) AND $login->assoc[0]['user'] == $_POST['usuario']){
        echo json_encode("valido");
        $_SESSION['usuario'] = $_POST['escuela'];
        $_SESSION['log'] = "valido";
        //$_SESSION['grupos'] = $login->assoc[0]['grupos'];
    }else{
        echo json_encode("error");
    }
}
// prueba