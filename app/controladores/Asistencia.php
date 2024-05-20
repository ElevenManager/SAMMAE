<?php

require_once "../modelos/Asistencia.php";

$Asistencia = new Asistencia();

// Obteniendo 'codigo_persona' a través de POST
$codigo_persona = isset($_POST["codigo_persona"]) ? limpiarCadena($_POST["codigo_persona"]) : "";

// Verificar si 'op' está presente en la URL
$operacion = isset($_GET['op']) ? $_GET['op'] : '';

switch ($operacion) {
    case 'Rasistencia':
        // Verificar si la persona existe en la base de datos
        $result = $Asistencia->verificar_persona($codigo_persona);
        if ($result) {
            date_default_timezone_set('America/Lima');
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");
            $curso = "Puerta";

            // Determinar tipo de asistencia (entrada o salida)
            $anotacion = "Registrado";

            // Registrar la asistencia
            $rspta = $Asistencia->registrar_asistencia($codigo_persona, $curso, $anotacion, $fecha, $hora);

            if ($rspta) {
                echo '<div class="alert alert-success"> Ingreso registrado ' . $hora . '</div>';
            } else {
                echo 'No se pudo registrar la asistencia';
            }
        } else {
            echo '<div class="alert alert-danger"><i class="icon fa fa-warning"></i> No hay Estudiante con ese código</div>';
            echo $codigo_persona;
        }
        break;

    default:
        echo "Operación no válida";
        break;
}
?>
