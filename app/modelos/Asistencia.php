<?php
require "../../configuracion/Conexion.php";

class Asistencia {

    public function __construct() {
        // Constructor vacío
    }

    public function verificar_persona($NroDocumento) {
        $sql = "SELECT * FROM persona WHERE nroDocumento = '$NroDocumento'";
        // Ejecutar consulta preparada
        $resultado = ejecutarConsulta($sql);

        // Verificar si se obtuvo algún resultado
        if ($resultado && $resultado->num_rows > 0) {
            // Obtener el primer resultado como un array asociativo
            $row = $resultado->fetch_assoc();
            // Devolver los datos obtenidos
            return $row;
        } else {
            // Devolver falso si no se encontraron resultados
            return false;
        }
    }


    public function registrar_asistencia($nroDocumento, $curso, $anotacion, $fecha, $hora) {
        $sql = "INSERT INTO asistencia (nroDocumento, curso, anotacion, Fecha , Hora) 
		VALUES ('$nroDocumento', '$curso', '$anotacion', '$fecha', '$hora')";
        return ejecutarConsulta($sql);
    }
}

?>