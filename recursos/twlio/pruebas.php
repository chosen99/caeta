<?php 
 
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
/*require_once '../assets/twilio/vendor/autoload.php';
 
use Twilio\Rest\Client; 
 
$sid    = "AC6cabef49d307247f77d8c2e22e415fab"; 
$token  = "9adc5c3572992ddb92fef435bc6b8b92"; 
$twilio = new Client($sid, $token);
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');
$fecha = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y') ;
$hora = date('H').":".date('i');
 
$message = $twilio->messages 
                  ->create("whatsapp:+5214621069012", // to 5544662118
                           array( 
                               "from" => "whatsapp:+5215531168502",       
                               "body" => "El alumno con la matrícula en terminación: *----1234* ha generado un registro a las *".$hora."* hrs del día *".$fecha."*. Gracias"
                           ) 
                  );
$v = $message->sid;
unset($v, $message, $twilio); */
//print($message->sid);

$tel = "4621069012"; //$_POST["telW"]
require_once '../assets/twilio/vendor/autoload.php';

use Twilio\Rest\Client;
if (is_numeric($tel) and strlen($tel) == 10){
    $matri = "----".substr("tola4234s",-4); //$_POST["Matricula"]
    echo $matri;


    $sid    = "AC6cabef49d307247f77d8c2e22e415fab";
    $token  = "9adc5c3572992ddb92fef435bc6b8b92";
    $twilio = new Client($sid, $token);
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    date_default_timezone_set('America/Mexico_City');
    $fecha = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y') ;
    $hora = date('H').":".date('i');

    $message = $twilio->messages
        ->create("whatsapp:+521".$tel,
            array(
                "from" => "whatsapp:+5215531168502",
                "body" => "El alumno con la matrícula en terminación: *".$matri."* ha generado un registro a las *".$hora."* hrs del día *".$fecha."*. Gracias"
            )
        );
    //$v = $message->sid;
    //print($message->sid);
    unset($v, $message, $twilio);
}