<?php
require_once "../modelos/Asistencia.php";

$Asistencia = new Asistencia();

$nroDocumento = isset($_POST["nroDocumento"]) ? $_POST["nroDocumento"] : "";

if (isset($_GET["op"])) {
    switch ($_GET["op"]) {
        case 'registrar_asistencia':
            // Verificar si la persona existe en la base de datos
            $persona = $Asistencia->verificar_persona($nroDocumento);

            if ($persona) {
                date_default_timezone_set('America/Lima');
                $fecha = date("Y-m-d");
                $hora = date("H:i:s");
                $curso = "Automatico";

                // Determinar tipo de asistencia (entrada o salida)
                $anotacion = "Registrado en puerta";

                // Registrar la asistencia
                $rspta = $Asistencia->registrar_asistencia($nroDocumento, $anotacion);

                if ($rspta) {;
                    echo '<h3><strong>Nombres:</strong> ' . $persona['Nombres'] . ' ' . $persona['Apellidos'] . '</h3><div class="alert alert-success">' . $anotacion . '</div>';
                } else {
                    echo 'No se pudo registrar la asistencia';
                }
            } else {
                echo '<div class="alert alert-danger"><i class="icon fa fa-warning"></i> No hay Estudiante con ese codigo</div>';
            }
            break;


        default:
            echo "Operación no válida";
            break;
    }
}
?>
