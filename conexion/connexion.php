<?php
//nos conectamos a la base de datos (nombre de data base viene por session_start la cual se inicia en codes fuente)
//require "./conexion/conexion.php";

define("DB_NOMBRE", $_SESSION['db']);

class con{
    private string $DB_HOST = 'localhost';
    private string $DB_USUARIO = 'root';
    private string $DB_CONTRA = '';
    private string $DB_CHARSET = 'utf8';
    private mysqli $conexion;

    public array $assoc;
    public $num_rows;

    // Método que se encarga de abrir la conexión a la base de datos
    private function abreconexion(){
        $this->conexion = new mysqli($this->DB_HOST, $this->DB_USUARIO, $this->DB_CONTRA, DB_NOMBRE);
        //En caso de que la conexion no tenga exito.
        if ($this->conexion->connect_errno) {
            echo "Fallo al conectar a MySQL:" . $this->conexion->connect_error;
            return;
        }
        //Establecemos el juego de caracteres para poder admitir ñ entre otros caracteres
        $this->conexion->set_charset($this->DB_CHARSET);
    }
    // Método que se encarga de cerrar la conexión de la base de datos
    private function cierraconexion(){
        $this->conexion->close();
    }

    // Método que se encarga de hacer la consulta SQL y devuelve un array con los registros
    public function selectASSOC(string $query){
        $this->abreconexion();
        // Creamos una consulta SQL
        $resultado = $this->conexion->query($query);
        // Creamos un array asociativo que contendrá toda la información que estamos demandando de la mase de datos.
        $this->assoc = $resultado->fetch_all(MYSQLI_ASSOC);
        // Creamos dato extra para enviar el numero de rows obtenidos.
        $this->num_rows = $resultado->num_rows;
        $this->cierraconexion();
    }

}

class con_dinamic_db{
    private string $DB_HOST = 'localhost';
    private string $DB_USUARIO = 'root';
    private string $DB_CONTRA = '';
    private string $DB_CHARSET = 'utf8';
    private mysqli $conexion;

    public array $assoc;
    public array $assoc_array;
    public $num_rows;

    // Método que se encarga de abrir la conexión a la base de datos
    private function abreconexion(){
        $this->conexion = new mysqli($this->DB_HOST, $this->DB_USUARIO, $this->DB_CONTRA, $_SESSION['db_SS']);
        //En caso de que la conexion no tenga exito.
        if ($this->conexion->connect_errno) {
            echo "Fallo al conectar a MySQL:" . $this->conexion->connect_error;
            return;
        }
        //Establecemos el juego de caracteres para poder admitir ñ entre otros caracteres
        $this->conexion->set_charset($this->DB_CHARSET);
    }
    // Método que se encarga de cerrar la conexión de la base de datos
    private function cierraconexion(){
        $this->conexion->close();
    }

    // Método que se encarga de hacer la consulta SQL y devuelve un array con los registros
    public function selectASSOC(string $query){
        $this->abreconexion();
        // Creamos una consulta SQL
        $resultado = $this->conexion->query($query);
        // Creamos un array asociativo que contendrá toda la información que estamos demandando de la mase de datos.
        $this->assoc = $resultado->fetch_assoc();
        // Creamos dato extra para enviar el numero de rows obtenidos.
        $this->num_rows = $resultado->num_rows;
        $this->cierraconexion();
    }
    public function selectASSOC_ALL(string $query){
        $this->abreconexion();
        // Creamos una consulta SQL
        $resultado = $this->conexion->query($query);
        // Creamos un array asociativo que contendrá toda la información que estamos demandando de la mase de datos.
        $this->assoc = $resultado->fetch_all(MYSQLI_ASSOC);
        // Creamos dato extra para enviar el numero de rows obtenidos.
        $this->num_rows = $resultado->num_rows;
        $this->cierraconexion();
    }

    public function selectAssocArrayCURP(string $query){
        $this->abreconexion();
        // Creamos una consulta SQL
        $resultado = $this->conexion->query($query);
        // Creamos un array asociativo que contendrá toda la información que estamos demandando de la mase de datos.
        while ($row = $resultado->fetch_assoc()){
            $this->assoc_array[] = $row['CURP'];
        }
        // Creamos dato extra para enviar el numero de rows obtenidos.
        $this->num_rows = $resultado->num_rows;
        $this->cierraconexion();
    }

    public function simpleSQL(string $query){
        $this->abreconexion();
        $this->conexion->query($query);
        $this->cierraconexion();
    }

}