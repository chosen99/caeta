<?php
include './TableData.php';
// Create instance of TableData class
$table_data = new TableData();
$table_data->get('credenciales_alumnos', 'id', array('Nombre', 'AP', 'AM', 'Matricula', 'CURP', 'Grupo', 'Especialidad' ,'Codigo','Generacion','CredencialEstado','id', 'Celulares', 'Foto'));
