<?php
require "../../configuracion/Conexion.php";

class Asistencia {

    public function __construct() {
        // Constructor vacío
    }

    public function verificar_persona($documento) {
        $sql = "SELECT * FROM persona WHERE nroDocumento = ?";
        // Ejecutar consulta preparada
        return ejecutarConsultaSimpleFila($sql, array($documento));
    }

    public function registrar_asistencia($nroDocumento, $tipoAsistencia) {
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $anotacion = "puerta general";
        $sql = "INSERT INTO asistencia (nroDocumento, Curso, anotacion, Fecha, Hora) 
                VALUES (?, ?, ?, ?, ?)";
        // Ejecutar consulta preparada
        return ejecutarConsulta($sql, array($nroDocumento, $tipoAsistencia, $anotacion, $fecha, $hora));
    }
}