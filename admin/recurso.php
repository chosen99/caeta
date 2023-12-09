<?php
session_start();
$bandera = $_POST['bandera'];
if ($bandera == "consulta_alumnos") {
    $_SESSION['db_SS'] = 'gcae_'.$_POST['plantel'];
    echo $_POST['plantel'] != "" ? json_encode(1) : json_encode(0);
    include "../conexion/connexion.php";
    $consulta = new con_dinamic_db();
    $consulta->selectASSOC("SELECT Carreras FROM administracion WHERE id = 1");
    $_SESSION['Carreras'] = $consulta->assoc['Carreras'];
}
elseif ($bandera == "consulta_docentes"){
    //include "../../conexion/connexion.php";
    if ($_POST['plantel'] != ""){
        $_SESSION['db_SS'] = 'gcae_'.$_POST['plantel'];
        echo json_encode(1);
    }
    else{
        echo json_encode(0);
    }
    /*$alumnos = new get_data_SS();
    $alumnos->selectASSOC("SELECT AP, AM, Nombre, CURP, Matricula FROM alumnos WHERE Grupo = '$grupo' AND CredencialEstado = 'Sin'");
    $trs='';
    for ($i=0; $i<$alumnos->num_rows; $i++){
        $trs .= '
        <tr>
            <td><button class="btn btn-outline-warning" onclick="autoSet(\''.$alumnos->assoc[$i]['AP'].'\',\''.$alumnos->assoc[$i]['AM'].'\',\''.$alumnos->assoc[$i]['Nombre'].'\',\''.$alumnos->assoc[$i]['CURP'].'\',\''.$alumnos->assoc[$i]['Matricula'].'\',)">'.$alumnos->assoc[$i]['Matricula'].'</button></td>
            <td>'.$alumnos->assoc[$i]['Nombre'].'</td>
            <td>'.$alumnos->assoc[$i]['AP'].'</td>
            <td>'.$alumnos->assoc[$i]['AM'].'</td>
        </tr>';
    }*/

}
elseif ($bandera == "get_info_edita_alumno"){
    $id = $_POST['id'];
    include "../conexion/connexion.php";
    $consulta = new con_dinamic_db();
    $consulta->selectASSOC("SELECT id, Matricula, AP, AM, Nombre, CURP, Grupo, Especialidad, Generacion, Foto, Firma, Cel_alumno, Cel_padre1, Cel_padre2 FROM alumnos WHERE id = '$id'");
    $datos['alumno'] = $consulta->assoc;
    $consulta->selectASSOC("SELECT Carreras FROM administracion WHERE id = 1");
    $datos['grupos'] = explode("!",$consulta->assoc['Carreras']);
    for ($i=0; $i<count($datos['grupos']); $i++){
        $datos['grupos_'][] = explode(">",$datos['grupos'][$i]);
    }
    for ($i=0; $i<count($datos['grupos']); $i++){
        $datos['gruposF'][] = explode(",",$datos['grupos_'][$i][1]);
    }
    unset($datos['grupos'],$datos['grupos_']);
    for ($i=0; $i<count($datos['gruposF']); $i++){
        if ($i==0)
            $datos['grupos'] = $datos['gruposF'][$i];
        else
            $datos['grupos'] = array_merge($datos['gruposF'][$i],$datos['grupos']);
    }
    unset($datos['gruposF']);
    echo json_encode($datos);
}
elseif ($bandera == "seve_update"){
    $id = $_POST['id_save'];
    include "../conexion/connexion.php";
    $sql = new con_dinamic_db();
    $matri = $_POST['matri'];
    $ap = $_POST['AP'];
    $am = $_POST['AM'];
    $nom = $_POST['Nombre'];
    $curp = $_POST['CURP'];
    $grupo = $_POST['Grupo'];
    $espe = $_POST['Especialidad'];
    $gene = $_POST['Generacion'];
    $Cel_A = $_POST['Cel_alumno'];
    $Cel_P1 = $_POST['Cel_p1'];
    $Cel_P2 = $_POST['Cel_p2'];

    $fo_fi = "";
    if (!empty($avatar = $_FILES['carga_foto']['tmp_name'])){
        $datos = file_get_contents($avatar);
        $tipo = ($_FILES['carga_foto']['type']);
        $base64_fo = /*'data:'.$tipo.';base64,'.*/base64_encode($datos);
        $fo_fi .= ", Foto = '$base64_fo'";
    }
    if (!empty($fir = $_FILES['carga_firma']['tmp_name'])){
        $datos = file_get_contents($fir);
        $tipo = ($_FILES['carga_firma']['type']);
        $base64_fi = 'data:'.$tipo.';base64,'.base64_encode($datos);
        $fo_fi .= ", Firma = '$base64_fi'";
    }
    else{
        $base64_fi = 'data:image/png;base64,'.$_POST['DatoBase64'];
        $fo_fi .= ", Firma = '$base64_fi'";
    }

    $sql->simpleSQL("UPDATE alumnos SET Matricula = '$matri', AP = '$ap', AM = '$am', Nombre = '$nom', CURP = '$curp', Grupo = '$grupo', Especialidad = '$espe', Generacion = '$gene', Cel_alumno = '$Cel_A', Cel_padre1 = '$Cel_P1', Cel_padre2 = '$Cel_P2' ".$fo_fi." WHERE id = '$id'");
    echo json_encode($id);
}
elseif ($bandera == "elimina_foto"){
    include "../conexion/connexion.php";
    $id = $_POST['id'];
    $sql = new con_dinamic_db();
    $sql->simpleSQL("UPDATE alumnos SET Foto = '' WHERE id = '$id'");
    echo json_encode("correcto");
}
elseif ($bandera == "elimina_firma"){
    include "../conexion/connexion.php";
    $id = $_POST['id'];
    $sql = new con_dinamic_db();
    $sql->simpleSQL("UPDATE alumnos SET Firma = '' WHERE id = '$id'");
    echo json_encode("correcto");
}
elseif ($bandera == "consulta_codigos"){
    include "../conexion/connexion.php";
    $id = $_POST['id'];

    $consulta = new con_dinamic_db();
    $consulta->selectASSOC("SELECT Codigo, CodigoStick, CodigoKey, Nombre, AP, AM FROM alumnos WHERE id = '$id'");

    echo json_encode($consulta->assoc);
}
elseif ($bandera == "edita_codigos"){
    include "../conexion/connexion.php";
    require '../recursos/phpqrcode/qrlib.php';
    $sql = new con_dinamic_db();

    $sql->selectASSOC_ALL("SELECT id FROM alumnos WHERE Codigo = '".$_POST['code_1']."' OR CodigoStick = '".$_POST['code_2']."' OR CodigoKey = '".$_POST['code_3']."' AND id != '".$_POST['id']."'");

    if ($sql->num_rows==0){
        $sql->simpleSQL("UPDATE alumnos 
                           SET
                           Codigo = '".$_POST['code_1']."',
                           CodigoStick = '".$_POST['code_2']."',
                           CodigoKey = '".$_POST['code_3']."'
                           WHERE
                           id = '".$_POST['id']."'
    ");
        $sql->selectASSOC("SELECT Matricula FROM alumnos WHERE id = '".$_POST['id']."'");
        QRcode::png($sql->assoc['Matricula'].",".$_POST['code_1'].",".$_SESSION['db_SS'],"temporales/qr.png",'H',16,1);
        $sql->simpleSQL("UPDATE alumnos SET QR = '".base64_encode(file_get_contents('temporales/qr.png'))."' WHERE id = '".$_POST['id']."'");

        echo json_encode('echo');
    }else{
        echo json_encode("Codigo existente en base de datos ".$sql->num_rows." - ".$sql->assoc[0]['id']); //TODO Corregir guardado mismo codigo en mismo contenedor
    }
}
// TODO Filtrar alumnos para no cargar existentes por curp y cambiar comlumnas de telefono
elseif ($bandera == "up_masivo"){
    $ext = pathinfo($_FILES['masivo']['name'], PATHINFO_EXTENSION);
    $name = strtolower('./alumnos_.'.$ext);
    $respuestas['estado'] = "error";
    if (move_uploaded_file($_FILES['masivo']['tmp_name'],'./temporales/'.$name)){
        $respuestas['estado'] = "subido";
        require "../recursos/spreadsheet/vendor/autoload.php";
        include "../conexion/connexion.php";
        $conexion = new con_dinamic_db();
        $conexion->selectAssocArrayCURP("SELECT CURP FROM alumnos");
        $cuenta = 0;
        if ($conexion->num_rows > 0) {
            $alumnos_DB = $conexion->assoc_array;
            // LEE ARCHIVO CARGADO
            $archivo = \PhpOffice\PhpSpreadsheet\IOFactory::load('./temporales/' . $name);
            // CUENTA DE LIBROS TOTALES EN EL ARCHIVO
            $total_libros = $archivo->getSheetCount();
            for ($i = 0; $i < $total_libros; $i++) {
                $libroActual = $archivo->getSheet($i);
                $columnas = $libroActual->getHighestColumn();   // OBTENER NUMERO DE COLUMNAS
                $filas = $libroActual->getHighestRow();         // OBTENER NUMERO DE FILAS
                for ($j = 2; $j <= $filas; $j++) {
                    if (!in_array($libroActual->getCell("E" . $j)->getValue(), $alumnos_DB)) {
                        $sql = "INSERT INTO alumnos (Matricula, Nombre, AP, AM, CURP, Grupo, Turno, Especialidad, Semestre ,Generacion, Cel_alumno, Cel_padre1, Cel_padre2)
                                VALUES (
                        '" . $libroActual->getCell("A" . $j)->getValue() . "',
                        '" . $libroActual->getCell("B" . $j)->getValue() . "',
                        '" . $libroActual->getCell("C" . $j)->getValue() . "',
                        '" . $libroActual->getCell("D" . $j)->getValue() . "',
                        '" . $libroActual->getCell("E" . $j)->getValue() . "',
                        '" . $libroActual->getCell("F" . $j)->getValue() . "',
                        '" . $libroActual->getCell("G" . $j)->getValue() . "',
                        '" . $libroActual->getCell("H" . $j)->getValue() . "',
                        '" . $libroActual->getCell("I" . $j)->getValue() . "',
                        '" . $libroActual->getCell("J" . $j)->getValue() . "',
                        '" . $libroActual->getCell("K" . $j)->getValue() . "',
                        '" . $libroActual->getCell("L" . $j)->getValue() . "',
                        '" . $libroActual->getCell("M" . $j)->getValue() . "'
                        )";
                        $conexion->simpleSQL($sql);
                        $cuenta++;
                    }
                }
            }
        }else{
            // LEE ARCHIVO CARGADO
            $archivo = \PhpOffice\PhpSpreadsheet\IOFactory::load('./temporales/' . $name);
            // CUENTA DE LIBROS TOTALES EN EL ARCHIVO
            $total_libros = $archivo->getSheetCount();
            for ($i = 0; $i < $total_libros; $i++) {
                $libroActual = $archivo->getSheet($i);
                $columnas = $libroActual->getHighestColumn();   // OBTENER NUMERO DE COLUMNAS
                $filas = $libroActual->getHighestRow();         // OBTENER NUMERO DE FILAS
                for ($j = 2; $j <= $filas; $j++) {
                    $sql = "INSERT INTO alumnos (Matricula, Nombre, AP, AM, CURP, Grupo, Turno, Especialidad, Semestre ,Generacion, Cel_alumno, Cel_padre1, Cel_padre2)
                                VALUES (
                        '" . $libroActual->getCell("A" . $j)->getValue() . "',
                        '" . $libroActual->getCell("B" . $j)->getValue() . "',
                        '" . $libroActual->getCell("C" . $j)->getValue() . "',
                        '" . $libroActual->getCell("D" . $j)->getValue() . "',
                        '" . $libroActual->getCell("E" . $j)->getValue() . "',
                        '" . $libroActual->getCell("F" . $j)->getValue() . "',
                        '" . $libroActual->getCell("G" . $j)->getValue() . "',
                        '" . $libroActual->getCell("H" . $j)->getValue() . "',
                        '" . $libroActual->getCell("I" . $j)->getValue() . "',
                        '" . $libroActual->getCell("J" . $j)->getValue() . "',
                        '" . $libroActual->getCell("K" . $j)->getValue() . "',
                        '" . $libroActual->getCell("L" . $j)->getValue() . "',
                        '" . $libroActual->getCell("M" . $j)->getValue() . "'
                        )";
                    $conexion->simpleSQL($sql);
                    $cuenta++;
                }
            }
        }
        // echo in_array("TT", $conexion->assoc_array);


        $respuestas['total'] = ($cuenta);
        echo json_encode($respuestas);
    }
    else{
        echo json_encode($respuestas);
    }
}
elseif ($bandera == "set_carrera"){

    $Carrera_grupos = explode("!",$_SESSION['Carreras']);
    for ($i=0; $i<count($Carrera_grupos); $i++){
        $separacion_g[] = explode(">",$Carrera_grupos[$i]);
    }
    for ($i=0; $i<count($separacion_g); $i++){
        $all[] = explode(",",$separacion_g[$i][1]);
    }

    for ($i = 0; $i< count($Carrera_grupos); $i++){
        if (in_array($_POST['grupo'],$all[$i])){
            $pos = $i;
        }
    }
    echo json_encode($separacion_g[$pos][0]);
}
elseif ($bandera == "get_info_plantel"){
    $_SESSION['db_SS'] = $_POST['db'];
    include "../conexion/connexion.php";
    $consulta = new con_dinamic_db();
    $consulta->selectASSOC("SELECT Nombre, CURP, RFC, Carreras, DireccionF, CCT, Personaje, NombreLargo, NombreCorto, Firma, Foto FROM administracion WHERE id = 1");

    $datos['data'] = $consulta->assoc;
    unset($datos['data']['Carreras']);
    $datos['carr_gru'] = explode("!",$consulta->assoc['Carreras']);
    echo json_encode($datos);
}
elseif ($bandera=='update_ff'){
    include "../conexion/connexion.php";
    $update = new con_dinamic_db();
    $update->simpleSQL("UPDATE alumnos SET Foto = '".str_replace('data:image/jpeg;base64,','',$_POST['foto'])."', Firma = '".$_POST['firma']."' WHERE id = '".$_POST['id']."'");
    echo json_encode('save');
}
elseif ($bandera == "imprimir_individual"){
    include "../conexion/connexion.php";
    $select = new con_dinamic_db();
    $select->selectASSOC("SELECT CURP, Grupo, Nombre, AP, AM, Generacion, Foto, Firma, Codigo From alumnos WHERE id = '".$_POST['id']."'");
    require '../recursos/mpdf/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [54, 85],'margin_left' => 0,'margin_right' => 0,
        'margin_top' => 1,
        'margin_bottom' => 1,
        'margin_header' => 9,
        'margin_footer' => 9,]);
    $mpdf->SetDefaultBodyCSS('background', "url('../recursos/img/aguila.jpg')");
    $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
    $frente = '
<style>

    .educacion{
        position: absolute;
        width: 3.5cm;
    }
    .escudo{
        margin-top: -.5cm;
        height: 1cm;
        margin-left: 0.15cm;
    }
    .dgeti{
        margin-top: -1.1cm;
        margin-left: 4.4cm;
        height: 1.02cm;
    }
    
    .foto{
            width: 2.5cm;
            height: 3cm;
            background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
            background-size: cover;
            margin: auto;
            border-radius: 10pt;
    }
    .mini-foto{
            width: 1cm;
            height: 1.2cm;
            background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
            background-size: cover;
            margin: -.7cm 0 0 .65cm;
            border-radius: 10pt;
            float: left;
    }
    .firma-alumno{
        width: 100%;
        height: 1cm;
        background: url("data:image/jpeg;base64,'.$select->assoc['Firma'].'") no-repeat;
        background-size: 100% 100%;
    }
    .firma-director{
        width: 100%;
        height: 1cm;
        background: url("data:image/png;base64,'.$select->assoc['Firma'].'") no-repeat;
        background-size: 100% 100%;
    }
    .logo-carrera{
            position: absolute;
            width: 1.43cm;
            margin-top: -2cm;
            margin-left: 0.05cm;
        }
    .grupo{
            width: 1.47cm;
            position: absolute;
            margin-left: 3.92cm;
            text-align: center;
            margin-top: -1cm;
        }
    .color-letras{
            color: rgb(114, 30, 40);
        }
    .semestres, th{
            width: 100%;
            border: 1px solid grey;
        }
    th{
            border-collapse: collapse;
            color: rgb(114, 30, 40);
        }
    .info{
        margin-top: 1.5cm;
        text-align: center;
    }
</style>
<div class="credencial-frete">
    <div class="header">
        <div style="text-align: center">
            <img class="educacion" src="../recursos/img/EDUCACION.png" alt="Educacion">
        </div>
        <div>
            <img class="escudo" src="../recursos/img/ESCUDO.png" alt="escudo">
        </div>
        <div>
            <img class="dgeti" src="../recursos/img/DGETI.png" alt="dgeti" >
        </div>
    </div>
    <div class="cuerpo-frente color-letras" style="background: white;">
        <div style="text-align: center; font-size: 6pt; margin-bottom: 0.2cm;"><b>INFORMÁTICA PROFESIONAL DE MÉXICO</b></div>
        <div class="foto"></div>
        <div class="logo-carrera">
            <div><img src="../recursos/img/SEP.png" alt="sep" style="width: 1.40cm;"></div>
            <div style="font-size: 4pt; text-align: center;">
                <b style="color: grey">INFORMÁTICA PROFESIONAL DE MÉXICO</b>
            </div>
        </div>
        <div class="grupo">
            <div><b class="color-letras" style="font-size: 8pt;">GRUPO</b></div>
            <div class="color-letras" style="font-size: 5.5pt;">'.$select->assoc['Grupo'].'</div>
        </div>
        <div class="info color-letras text-center">
            <div style="font-size: 8pt;">'.$select->assoc['CURP'].'</div>
            <div style="font-size: 10pt;"><b>Alumno</b></div>
            <div style="font-size: 8pt; margin-top: .2cm">'.$select->assoc['Nombre'].'<br><b>'.$select->assoc['AP'].' '.$select->assoc['AM'].'</b></div>
            <div style="font-size: 10pt; margin-top: .2cm"><b>SEMESTRE</b></div>
            <table class="semestres" style="text-align: center; font-size: 22pt;">
                <tr>
                    <th>AGO '.$select->assoc['Generacion'].'<br>ENE '.($select->assoc['Generacion']+1).'</th>
                    <th>FEB '.($select->assoc['Generacion']+1).'<br>JUL '.($select->assoc['Generacion']+1).'</th>
                    <th>AGO '.($select->assoc['Generacion']+1).'<br>ENE '.($select->assoc['Generacion']+2).'</th>
                    <th>FEB '.($select->assoc['Generacion']+2).'<br>JUL '.($select->assoc['Generacion']+2).'</th>
                    <th>AGO '.($select->assoc['Generacion']+2).'<br>ENE '.($select->assoc['Generacion']+3).'</th>
                    <th>FEB '.($select->assoc['Generacion']+3).'<br>JUL '.($select->assoc['Generacion']+3).'</th>
                </tr>
            </table>
        </div>
    </div>
</div>
';
    $mpdf->WriteHTML($frente);
    $mpdf->AddPage();
    $reverso = '
<div class="credencial-reverso">
    <div class="header color-letras" style="text-align: center; font-size: 10pt;">
        <b>SISTEMA ESCOLARIZADO TURNO NOCTURNO</b>
    </div>
    <div class="cuerpo-reverso" style="text-align: center;">
        <div class="contenedor-info" style="background: url(../recursos/img/lineas.png); background-size: cover;">
            <table style="text-align: center; width: 100%; font-size: 6pt;">
                <tr>
                    <td class="color-letras"><b>FECHA DE EMISIÓN:<br>19/09/2023</b></td>
                    <td class="color-letras"><b>GENERACIÓN:<br>'.($select->assoc['Generacion']).' - '.($select->assoc['Generacion']+3).'</b></td>
                </tr>
            </table>
            <div style="margin-top: 0.2cm;">
                <div style="width: 1cm; float: left; margin-left: 0.64cm;">
                    <img src="../recursos/img/qr.png" alt="qr" style="height: 1cm;">
                    <span style="font-size: 3.3pt;"><b>Descarga la App</b></span>
                </div>
                <div style="width: 3cm; float: right; margin-right: 0.64cm;">
                    <div class="firma-alumno"></div>
                    <span class="color-letras" style="font-size: 5pt;"><b>FIRMA DEL ALUMNO</b></span>
                </div>
            </div>
            <div style="margin-top: 0.2cm;">
                <div style="text-align: center; max-height: 2cm; font-size: 6pt; margin-left: 1cm; margin-right: 1cm; border: 1px solid black;">
                    <b class="color-letras">N° DE CONTROL/MATRÍCULA</b>
                    Codigos barras o qr <br><br><br><br>
                </div>
                <div style="text-align: center; margin-left: 1.65cm; width: 3cm;">
                    <div class="firma-director" style="height: 1cm;"></div>
                    <span class="color-letras" style="font-size: 5pt; padding-left: .5cm;"><b>DIRECTOR DEL PLANTEL</b></span>
                </div>
            </div>
            <div style="margin-top: -0.4cm;">
                <div class="mini-foto"></div>
            </div>
        </div>
        <div class="color-letras" style="text-align: center; width: 100%; height: 1cm; margin-top: .1cm;">
            <div style="font-size: 5pt;">DIRECCIÓN DEL PLANTEL</div>
            <div style="font-size: 6pt;"><b>CALLE 5 NO 435</b></div>
        </div>
        <div class="color-letras" style="text-align: center; width: 100%; height: 1.1cm;">
            <b style="font-size: 6pt;">COMPONENTE BASICO Y PROPEDEUTICO</b>
        </div>
    </div>
</div>

<div style="position: fixed; font-size: 6pt; bottom: 2.5cm; rotate: 90; text-align: center; width: 25mm;">
    <div style="border: 1px solid black;">'.$select->assoc['Codigo'].'</div>
    <b class="color-letras">CÓDIGO</b>
</div>
';
    $mpdf->WriteHTML($reverso);
    $mpdf->Output('./temporales/credencial.pdf');
    echo json_encode('Generando');
}
elseif ($bandera == 'imprimir-sel'){
    $ids = explode(',',$_POST['ids']);
    include "../conexion/connexion.php";
    $select = new con_dinamic_db();
    require '../recursos/mpdf/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [54, 85],'margin_left' => 0,'margin_right' => 0,
        'margin_top' => 1,
        'margin_bottom' => 1,
        'margin_header' => 9,
        'margin_footer' => 9,]);
    $mpdf->SetDefaultBodyCSS('background', "url('../recursos/img/aguila.jpg')");
    $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
    for ($i=0;$i<count($ids);$i++){
        $select->selectASSOC("SELECT CURP, Grupo, Nombre, AP, AM, Generacion, Foto, Firma, Codigo From alumnos WHERE id = '".$ids[$i]."'");
        if($i==0){
            $frente = '
            <style>
            
                .educacion{
                    position: absolute;
                    width: 3.5cm;
                }
                .escudo{
                    margin-top: -.5cm;
                    height: 1cm;
                    margin-left: 0.15cm;
                }
                .dgeti{
                    margin-top: -1.1cm;
                    margin-left: 4.4cm;
                    height: 1.02cm;
                }
                
                .foto{
                        width: 2.5cm;
                        height: 3cm;
                        background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
                        background-size: cover;
                        margin: auto;
                        border-radius: 10pt;
                }
                .mini-foto{
                        width: 1cm;
                        height: 1.2cm;
                        background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
                        background-size: cover;
                        margin: -.7cm 0 0 .65cm;
                        border-radius: 10pt;
                        float: left;
                }
                .firma-alumno{
                    width: 100%;
                    height: 1cm;
                    background: url("data:image/jpeg;base64,'.$select->assoc['Firma'].'") no-repeat;
                    background-size: 100% 100%;
                }
                .firma-director{
                    width: 100%;
                    height: 1cm;
                    background: url("data:image/png;base64,'.$select->assoc['Firma'].'") no-repeat;
                    background-size: 100% 100%;
                }
                .logo-carrera{
                        position: absolute;
                        width: 1.43cm;
                        margin-top: -2cm;
                        margin-left: 0.05cm;
                    }
                .grupo{
                        width: 1.47cm;
                        position: absolute;
                        margin-left: 3.92cm;
                        text-align: center;
                        margin-top: -1cm;
                    }
                .color-letras{
                        color: rgb(114, 30, 40);
                    }
                .semestres, th{
                        width: 100%;
                        border: 1px solid grey;
                    }
                th{
                        border-collapse: collapse;
                        color: rgb(114, 30, 40);
                    }
                .info{
                    margin-top: 1.5cm;
                    text-align: center;
                }
            </style>
            <div class="credencial-frete">
                <div class="header">
                    <div style="text-align: center">
                        <img class="educacion" src="../recursos/img/EDUCACION.png" alt="Educacion">
                    </div>
                    <div>
                        <img class="escudo" src="../recursos/img/ESCUDO.png" alt="escudo">
                    </div>
                    <div>
                        <img class="dgeti" src="../recursos/img/DGETI.png" alt="dgeti" >
                    </div>
                </div>
                <div class="cuerpo-frente color-letras">
                    <div style="text-align: center; font-size: 6pt; margin-bottom: 0.2cm;"><b>INFORMÁTICA PROFESIONAL DE MÉXICO</b></div>
                    <div class="foto"></div>
                    <div class="logo-carrera">
                        <div><img src="../recursos/img/SEP.png" alt="sep" style="width: 1.40cm;"></div>
                        <div style="font-size: 4pt; text-align: center;">
                            <b style="color: grey">INFORMÁTICA PROFESIONAL DE MÉXICO</b>
                        </div>
                    </div>
                    <div class="grupo">
                        <div><b class="color-letras" style="font-size: 8pt;">GRUPO</b></div>
                        <div class="color-letras" style="font-size: 5.5pt;">'.$select->assoc['Grupo'].'</div>
                    </div>
                    <div class="info color-letras text-center">
                        <div style="font-size: 8pt;">'.$select->assoc['CURP'].'</div>
                        <div style="font-size: 10pt;"><b>Alumno</b></div>
                        <div style="font-size: 8pt; margin-top: .2cm">'.$select->assoc['Nombre'].'<br><b>'.$select->assoc['AP'].' '.$select->assoc['AM'].'</b></div>
                        <div style="font-size: 10pt; margin-top: .2cm"><b>SEMESTRE</b></div>
                        <table class="semestres" style="text-align: center; font-size: 22pt;">
                            <tr>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            ';
            $mpdf->WriteHTML($frente);
            $mpdf->AddPage();
            $reverso = '
            <div class="credencial-reverso">
                <div class="header color-letras" style="text-align: center; font-size: 10pt;">
                    <b>SISTEMA ESCOLARIZADO TURNO NOCTURNO</b>
                </div>
                <div class="cuerpo-reverso" style="text-align: center;">
                    <div class="contenedor-info" style="background: url(../recursos/img/lineas.png); background-size: cover;">
                        <table style="text-align: center; width: 100%; font-size: 6pt;">
                            <tr>
                                <td class="color-letras"><b>FECHA DE EMISIÓN:<br>19/09/2023</b></td>
                                <td class="color-letras"><b>GENERACIÓN:<br>2022 - 2025</b></td>
                            </tr>
                        </table>
                        <div style="margin-top: 0.2cm;">
                            <div style="width: 1cm; float: left; margin-left: 0.64cm;">
                                <img src="../recursos/img/qr.png" alt="qr" style="height: 1cm;">
                                <span style="font-size: 3.3pt;"><b>Descarga la App</b></span>
                            </div>
                            <div style="width: 3cm; float: right; margin-right: 0.64cm;">
                                <div class="firma-alumno"></div>
                                <span class="color-letras" style="font-size: 5pt;"><b>FIRMA DEL ALUMNO</b></span>
                            </div>
                        </div>
                        <div style="margin-top: 0.2cm;">
                            <div style="text-align: center; max-height: 2cm; font-size: 6pt; margin-left: 1cm; margin-right: 1cm; border: 1px solid black;">
                                <b class="color-letras">N° DE CONTROL/MATRÍCULA</b>
                                Codigos barras o qr <br><br><br><br>
                            </div>
                            <div style="text-align: center; margin-left: 1.65cm; width: 3cm;">
                                <div class="firma-director" style="height: 1cm;"></div>
                                <span class="color-letras" style="font-size: 5pt; padding-left: .5cm;"><b>DIRECTOR DEL PLANTEL</b></span>
                            </div>
                        </div>
                        <div style="margin-top: -0.4cm;">
                            <div class="mini-foto"></div>
                        </div>
                    </div>
                    <div class="color-letras" style="text-align: center; width: 100%; height: 1cm; margin-top: .1cm;">
                        <div style="font-size: 5pt;">DIRECCIÓN DEL PLANTEL</div>
                        <div style="font-size: 6pt;"><b>CALLE 5 NO 435</b></div>
                    </div>
                    <div class="color-letras" style="text-align: center; width: 100%; height: 1.1cm;">
                        <b style="font-size: 6pt;">COMPONENTE BASICO Y PROPEDEUTICO</b>
                    </div>
                </div>
            </div>
            
            <div style="position: fixed; font-size: 6pt; bottom: 2.5cm; rotate: 90; text-align: center; width: 25mm;">
                <div style="border: 1px solid black;">'.$select->assoc['Codigo'].'</div>
                <b class="color-letras">CÓDIGO</b>
            </div>
            ';
            $mpdf->WriteHTML($reverso);
            $mpdf->AddPage();
        }
        elseif ($i==(count($ids)-1)){
            $frente = '
            <style>
                .foto{
                        width: 2.5cm;
                        height: 3cm;
                        background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
                        background-size: cover;
                        margin: auto;
                        border-radius: 10pt;
                }
                .mini-foto{
                        width: 1cm;
                        height: 1.2cm;
                        background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
                        background-size: cover;
                        margin: -.7cm 0 0 .65cm;
                        border-radius: 10pt;
                        float: left;
                }
                .firma-alumno{
                    width: 100%;
                    height: 1cm;
                    background: url("data:image/jpeg;base64,'.$select->assoc['Firma'].'") no-repeat;
                    background-size: 100% 100%;
                }
                .firma-director{
                    width: 100%;
                    height: 1cm;
                    background: url("data:image/png;base64,'.$select->assoc['Firma'].'") no-repeat;
                    background-size: 100% 100%;
                }
            </style>
            <div class="credencial-frete">
                <div class="header">
                    <div style="text-align: center">
                        <img class="educacion" src="../recursos/img/EDUCACION.png" alt="Educacion">
                    </div>
                    <div>
                        <img class="escudo" src="../recursos/img/ESCUDO.png" alt="escudo">
                    </div>
                    <div>
                        <img class="dgeti" src="../recursos/img/DGETI.png" alt="dgeti" >
                    </div>
                </div>
                <div class="cuerpo-frente color-letras">
                    <div style="text-align: center; font-size: 6pt; margin-bottom: 0.2cm;"><b>INFORMÁTICA PROFESIONAL DE MÉXICO</b></div>
                    <div class="foto"></div>
                    <div class="logo-carrera">
                        <div><img src="../recursos/img/SEP.png" alt="sep" style="width: 1.40cm;"></div>
                        <div style="font-size: 4pt; text-align: center;">
                            <b style="color: grey">INFORMÁTICA PROFESIONAL DE MÉXICO</b>
                        </div>
                    </div>
                    <div class="grupo">
                        <div><b class="color-letras" style="font-size: 8pt;">GRUPO</b></div>
                        <div class="color-letras" style="font-size: 5.5pt;">'.$select->assoc['Grupo'].'</div>
                    </div>
                    <div class="info color-letras text-center">
                        <div style="font-size: 8pt;">'.$select->assoc['CURP'].'</div>
                        <div style="font-size: 10pt;"><b>Alumno</b></div>
                        <div style="font-size: 8pt; margin-top: .2cm">'.$select->assoc['Nombre'].'<br><b>'.$select->assoc['AP'].' '.$select->assoc['AM'].'</b></div>
                        <div style="font-size: 10pt; margin-top: .2cm"><b>SEMESTRE</b></div>
                        <table class="semestres" style="text-align: center; font-size: 22pt;">
                            <tr>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            ';
            $mpdf->WriteHTML($frente);
            $mpdf->AddPage();
            $reverso = '
            <div class="credencial-reverso">
                <div class="header color-letras" style="text-align: center; font-size: 10pt;">
                    <b>SISTEMA ESCOLARIZADO TURNO NOCTURNO</b>
                </div>
                <div class="cuerpo-reverso" style="text-align: center;">
                    <div class="contenedor-info" style="background: url(../recursos/img/lineas.png); background-size: cover;">
                        <table style="text-align: center; width: 100%; font-size: 6pt;">
                            <tr>
                                <td class="color-letras"><b>FECHA DE EMISIÓN:<br>19/09/2023</b></td>
                                <td class="color-letras"><b>GENERACIÓN:<br>2022 - 2025</b></td>
                            </tr>
                        </table>
                        <div style="margin-top: 0.2cm;">
                            <div style="width: 1cm; float: left; margin-left: 0.64cm;">
                                <img src="../recursos/img/qr.png" alt="qr" style="height: 1cm;">
                                <span style="font-size: 3.3pt;"><b>Descarga la App</b></span>
                            </div>
                            <div style="width: 3cm; float: right; margin-right: 0.64cm;">
                                <div class="firma-alumno"></div>
                                <span class="color-letras" style="font-size: 5pt;"><b>FIRMA DEL ALUMNO</b></span>
                            </div>
                        </div>
                        <div style="margin-top: 0.2cm;">
                            <div style="text-align: center; max-height: 2cm; font-size: 6pt; margin-left: 1cm; margin-right: 1cm; border: 1px solid black;">
                                <b class="color-letras">N° DE CONTROL/MATRÍCULA</b>
                                Codigos barras o qr <br><br><br><br>
                            </div>
                            <div style="text-align: center; margin-left: 1.65cm; width: 3cm;">
                                <div class="firma-director" style="height: 1cm;"></div>
                                <span class="color-letras" style="font-size: 5pt; padding-left: .5cm;"><b>DIRECTOR DEL PLANTEL</b></span>
                            </div>
                        </div>
                        <div style="margin-top: -0.4cm;">
                            <div class="mini-foto"></div>
                        </div>
                    </div>
                    <div class="color-letras" style="text-align: center; width: 100%; height: 1cm; margin-top: .1cm;">
                        <div style="font-size: 5pt;">DIRECCIÓN DEL PLANTEL</div>
                        <div style="font-size: 6pt;"><b>CALLE 5 NO 435</b></div>
                    </div>
                    <div class="color-letras" style="text-align: center; width: 100%; height: 1.1cm;">
                        <b style="font-size: 6pt;">COMPONENTE BASICO Y PROPEDEUTICO</b>
                    </div>
                </div>
            </div>
            
            <div style="position: fixed; font-size: 6pt; bottom: 2.5cm; rotate: 90; text-align: center; width: 25mm;">
                <div style="border: 1px solid black;">'.$select->assoc['Codigo'].'</div>
                <b class="color-letras">CÓDIGO</b>
            </div>
            ';
            $mpdf->WriteHTML($reverso);
        }
        else{
            $frente = '
            <style>
                .foto{
                        width: 2.5cm;
                        height: 3cm;
                        background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
                        background-size: cover;
                        margin: auto;
                        border-radius: 10pt;
                }
                .mini-foto{
                        width: 1cm;
                        height: 1.2cm;
                        background: url("data:image/jpeg;base64,'.$select->assoc['Foto'].'");
                        background-size: cover;
                        margin: -.7cm 0 0 .65cm;
                        border-radius: 10pt;
                        float: left;
                }
                .firma-alumno{
                    width: 100%;
                    height: 1cm;
                    background: url("data:image/jpeg;base64,'.$select->assoc['Firma'].'") no-repeat;
                    background-size: 100% 100%;
                }
                .firma-director{
                    width: 100%;
                    height: 1cm;
                    background: url("data:image/png;base64,'.$select->assoc['Firma'].'") no-repeat;
                    background-size: 100% 100%;
                }
            </style>
            <div class="credencial-frete">
                <div class="header">
                    <div style="text-align: center">
                        <img class="educacion" src="../recursos/img/EDUCACION.png" alt="Educacion">
                    </div>
                    <div>
                        <img class="escudo" src="../recursos/img/ESCUDO.png" alt="escudo">
                    </div>
                    <div>
                        <img class="dgeti" src="../recursos/img/DGETI.png" alt="dgeti" >
                    </div>
                </div>
                <div class="cuerpo-frente color-letras">
                    <div style="text-align: center; font-size: 6pt; margin-bottom: 0.2cm;"><b>INFORMÁTICA PROFESIONAL DE MÉXICO</b></div>
                    <div class="foto"></div>
                    <div class="logo-carrera">
                        <div><img src="../recursos/img/SEP.png" alt="sep" style="width: 1.40cm;"></div>
                        <div style="font-size: 4pt; text-align: center;">
                            <b style="color: grey">INFORMÁTICA PROFESIONAL DE MÉXICO</b>
                        </div>
                    </div>
                    <div class="grupo">
                        <div><b class="color-letras" style="font-size: 8pt;">GRUPO</b></div>
                        <div class="color-letras" style="font-size: 5.5pt;">'.$select->assoc['Grupo'].'</div>
                    </div>
                    <div class="info color-letras text-center">
                        <div style="font-size: 8pt;">'.$select->assoc['CURP'].'</div>
                        <div style="font-size: 10pt;"><b>Alumno</b></div>
                        <div style="font-size: 8pt; margin-top: .2cm">'.$select->assoc['Nombre'].'<br><b>'.$select->assoc['AP'].' '.$select->assoc['AM'].'</b></div>
                        <div style="font-size: 10pt; margin-top: .2cm"><b>SEMESTRE</b></div>
                        <table class="semestres" style="text-align: center; font-size: 22pt;">
                            <tr>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                                <th>AGO 2022<br>ENE 2023</th>
                                <th>FEB 2022<br>JUL 2023</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            ';
            $mpdf->WriteHTML($frente);
            $mpdf->AddPage();
            $reverso = '
            <div class="credencial-reverso">
                <div class="header color-letras" style="text-align: center; font-size: 10pt;">
                    <b>SISTEMA ESCOLARIZADO TURNO NOCTURNO</b>
                </div>
                <div class="cuerpo-reverso" style="text-align: center;">
                    <div class="contenedor-info" style="background: url(../recursos/img/lineas.png); background-size: cover;">
                        <table style="text-align: center; width: 100%; font-size: 6pt;">
                            <tr>
                                <td class="color-letras"><b>FECHA DE EMISIÓN:<br>19/09/2023</b></td>
                                <td class="color-letras"><b>GENERACIÓN:<br>2022 - 2025</b></td>
                            </tr>
                        </table>
                        <div style="margin-top: 0.2cm;">
                            <div style="width: 1cm; float: left; margin-left: 0.64cm;">
                                <img src="../recursos/img/qr.png" alt="qr" style="height: 1cm;">
                                <span style="font-size: 3.3pt;"><b>Descarga la App</b></span>
                            </div>
                            <div style="width: 3cm; float: right; margin-right: 0.64cm;">
                                <div class="firma-alumno"></div>
                                <span class="color-letras" style="font-size: 5pt;"><b>FIRMA DEL ALUMNO</b></span>
                            </div>
                        </div>
                        <div style="margin-top: 0.2cm;">
                            <div style="text-align: center; max-height: 2cm; font-size: 6pt; margin-left: 1cm; margin-right: 1cm; border: 1px solid black;">
                                <b class="color-letras">N° DE CONTROL/MATRÍCULA</b>
                                Codigos barras o qr <br><br><br><br>
                            </div>
                            <div style="text-align: center; margin-left: 1.65cm; width: 3cm;">
                                <div class="firma-director" style="height: 1cm;"></div>
                                <span class="color-letras" style="font-size: 5pt; padding-left: .5cm;"><b>DIRECTOR DEL PLANTEL</b></span>
                            </div>
                        </div>
                        <div style="margin-top: -0.4cm;">
                            <div class="mini-foto"></div>
                        </div>
                    </div>
                    <div class="color-letras" style="text-align: center; width: 100%; height: 1cm; margin-top: .1cm;">
                        <div style="font-size: 5pt;">DIRECCIÓN DEL PLANTEL</div>
                        <div style="font-size: 6pt;"><b>CALLE 5 NO 435</b></div>
                    </div>
                    <div class="color-letras" style="text-align: center; width: 100%; height: 1.1cm;">
                        <b style="font-size: 6pt;">COMPONENTE BASICO Y PROPEDEUTICO</b>
                    </div>
                </div>
            </div>
            
            <div style="position: fixed; font-size: 6pt; bottom: 2.5cm; rotate: 90; text-align: center; width: 25mm;">
                <div style="border: 1px solid black;">'.$select->assoc['Codigo'].'</div>
                <b class="color-letras">CÓDIGO</b>
            </div>
            ';
            $mpdf->WriteHTML($reverso);
            $mpdf->AddPage();
        }
    }
    $mpdf->Output('./temporales/credenciales.pdf');
    echo json_encode('generado');
}