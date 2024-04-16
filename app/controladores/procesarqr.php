<?php

// Asegúrate de que haya datos POST recibidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decodifica el JSON recibido
    $content = json_decode(file_get_contents("php://input"), true);
    
    // Verifica si el código QR es un número de 8 dígitos
    if (isset($content["codigo"]) && preg_match('/^\d{8}$/', $content["codigo"])) {
        echo "1"; // Código QR válido
    } else {
        echo "El código QR no es un número de 8 dígitos.";
    }
} else {
    echo "Solicitud no válida.";
}

?>

