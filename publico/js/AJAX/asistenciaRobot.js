var tabla;

// Función que se ejecuta al inicio
function init() {
    $("#formulario").on("submit", function (e) {
        registrar_asistencia(e);
    })
}
//funcion limpiar
function limpiar() {
    $("#codigo_persona").val("");
    setTimeout('document.location.reload()', 2000);
}

function registrar_asistencia(e){
    e.preventDefault();//no se activara la accion predeterminada
    $("#btnGuardar").prop("disabled",true);
    var formData=new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../app/controladores/Asistencia.php?op=Rasistencia",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            $("#movimientos").html(datos);
            //window.alert(datos);
        }
    });
    limpiar();
}
init();