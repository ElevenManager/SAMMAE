var tabla;

// Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listarU();
    cargarDNIs();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });

    // Mostramos los permisos
    $.post("../../app/controladores/usuario.php?op=permisos&id=", function(r) {
        $("#permisos").html(r);
    });
}

// Función limpiar
function limpiar() {
    $("#id").val("");
    $("#pertenecia").val("");
    $("#nombre").val("");
    $("#rol").val("");
    $("#nivelid").val("");
    $("#login").val("");
    $("#estado").val("Activado");
}

// Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
function cancelarform()
{
    limpiar();
    mostrarform(false);
}
// Función Listar
function listarU() {
    tabla = $('#tbllistado').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
        "ajax": {
            url: '../../app/controladores/usuario.php?op=listarUsuarios',
            type: "GET",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });
}

// Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); // No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../app/controladores/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
}

// Función para mostrar detalles de usuario
function mostrar(idusuario) {
    // Usar $.ajax en lugar de $.post para manejar errores más fácilmente
    $.ajax({
        url: "../../app/controladores/usuario.php?op=mostrar",
        type: "POST",
        data: { idusuario: idusuario },
        dataType: "json", // Esperamos una respuesta JSON
        success: function(data) {
            // Verificar si la respuesta es válida antes de procesarla
            if (data && data.idusuario !== undefined) {
                mostrarform(true);
                $("#id").val(data.idusuario);
                $("#pertenecia").val(data.pertenecia);
                $("#nombre").val(data.nombre);
                $("#rol").val(data.rol);
                $("#nivelid").val(data.nivelid);
                $("#login").val(data.login);
                $("#estado").val(data.estado);
            } else {
                alert("Error: Datos de usuario no válidos");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("Error al obtener datos del usuario. Por favor, intenta de nuevo más tarde.");
        }
    });
}


// Función para desactivar registros
function desactivar(idusuario) {
    window.confirm("¿Está seguro de desactivar el usuario?", function(result) {
        if (result) {
            $.post("../../app/controladores/usuario.php?op=desactivar",{ idusuario: idusuario }, function(e) {
                window.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

// Función para activar registros
function activar(idusuario) {
    bootbox.confirm("¿Está seguro de activar el usuario?", function(result) {
        if (result) {
            $.post("../../app/controladores/usuario.php?op=activar", { idusuario: idusuario }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}
function cargarDNIs() {
    // Realizar una solicitud AJAX al controlador para obtener los DNIs
    $.ajax({
        url: '../../app/controladores/usuario.php?op=obtener_dniselect',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            // Limpiar las opciones actuales del select
            $('#dni').empty();

            // Agregar las nuevas opciones del select con los DNIs obtenidos
            $.each(response, function(index, value) {
                $('#dni').append('<option value="' + value + '">' + value + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error al cargar los DNIs');
        }
    });
}

init();
