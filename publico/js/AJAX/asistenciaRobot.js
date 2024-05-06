var tabla;

// Función que se ejecuta al inicio
function init() {
    $("#formulario").on("submit", function(e) {
        registrar_asistencia(e);
    });
}

// Función para limpiar el formulario después de registrar una asistencia
function limpiar() {
    $("#codigo_persona").val("");
    setTimeout('document.location.reload()',2000);
}

// Función para registrar una asistencia
function registrar_asistencia(e) {
    e.preventDefault(); // Evitar la acción predeterminada del formulario
    $("#btnGuardar").prop("disabled", true);

    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../app/controladores/Asistencia.php?op=registrar_asistencia",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            $("#movimientos").html(datos);
            limpiar(); // Llamar a la función limpiar después de registrar
        },
        error: function(xhr, status, error) {
            console.error(error); // Manejar errores de la solicitud AJAX
            $("#btnGuardar").prop("disabled", false); // Habilitar el botón después de la solicitud
        }
    });
}
$(document).ready(function() {
    init();
});
