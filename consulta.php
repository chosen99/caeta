<?php
session_start();
$_SESSION['db'] = "grupoip2_cetis49";
include_once("./conexion/connexion.php");
$usuarios = new con();
$usuarios->selectASSOC("SELECT * FROM becas");
echo $usuarios->num_rows;
print_r($usuarios->assoc);
