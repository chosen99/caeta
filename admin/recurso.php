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
    $sql = new con_dinamic_db();

    $sql->selectASSOC("SELECT id FROM alumnos WHERE Codigo IN('".$_POST['code_1']."') OR CodigoStick IN('".$_POST['code_2']."') OR CodigoKey IN ('".$_POST['code_3']."')");
    if ($sql->num_rows==0){
        $sql->simpleSQL("UPDATE alumnos 
                           SET
                           Codigo = '".$_POST['code_1']."',
                           CodigoStick = '".$_POST['code_2']."',
                           CodigoKey = '".$_POST['code_3']."'
                           WHERE
                           id = '".$_POST['id']."'
    ");
        echo json_encode('echo');
    }else{
        echo json_encode("Codigo existente en base de datos");
    }
}
// TODO Filtrar alumnos para no cargar existentes por curp
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

