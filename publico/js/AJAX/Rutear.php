<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cifrado SHA-256 con Clave</title>
</head>
<body>
<h2>Cifrado SHA-256 con Clave</h2>
<form method="post" action="">
    <label for="clave">Clave:</label><br>
    <input type="password" id="clave" name="clave"><br><br>
    <input type="submit" name="submit" value="Cifrar">
</form>

<?php
// Función para cifrar un mensaje usando SHA-256 con una clave
function cifrarConClave($mensaje, $clave) {
    // Generar hash SHA-256 de la clave
    $claveHash = hash("SHA256", $clave);

    // Usar el hash de la clave como clave para cifrar el mensaje
    $mensajeCifrado = hash_hmac("SHA256", $mensaje, $claveHash);

    // Devolver el mensaje cifrado
    return $claveHash;
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $mensajeOriginal = $_POST["mensaje"];
    $claveSecreta = $_POST["clave"];

    // Verificar que se ingresó un mensaje y una clave
    if (!empty($claveSecreta)) {
        // Cifrar el mensaje usando la clave secreta
        $mensajeCifrado = cifrarConClave($mensajeOriginal, $claveSecreta);

        echo "<h3>Resultado:</h3>";
        echo "<p><strong>Mensaje Original:</strong> " . htmlspecialchars($mensajeOriginal) . "</p>";
        echo "<p><strong>Mensaje Cifrado:</strong> " . $mensajeCifrado . "</p>";
    } else {
        echo "<p style='color: red;'>Por favor, ingresa un mensaje y una clave.</p>";
    }
}
?>
</body>
</html>

