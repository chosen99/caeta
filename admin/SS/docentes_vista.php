<?php
include './TableData.php';
// Create instance of TableData class
$table_data = new TableData();
$table_data->get('docentes_vista', 'id', array('Nombre', 'AP', 'AM', 'RFC', 'CURP', 'Area', 'Puesto' ,'Area_servicio','Codigo'));
