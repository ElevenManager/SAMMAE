<?php
// Incluimos la conexión a la base de datos
require "../../configuracion/Conexion.php";

// Definimos la clase Usuario
class Usuario
{
    // Constructor de la clase
    public function __construct()
    {
        // Aquí podría ir código para inicializar la clase si fuera necesario
    }

    // Método para insertar registros de usuario y persona, y asignar permisos
    public function insertar($nombres, $apellidos, $tipo_documento, $num_documento, $fecha_nacimiento, $sexo, $estado_civil, $direccion, $telefono, $email, $ocupacion, $apoderado, $login, $clave, $permisos)
    {
        // Insertamos primero a la persona
        $sql1 = "INSERT INTO persona (nroDocumento, tipoDocumento, Nombres, Apellidos, FechaNacimiento, sexo, estado_civil, direccion, telefono, email, ocupacion, apoderado)
		VALUES ('$num_documento','$tipo_documento','$nombres','$apellidos','$fecha_nacimiento','$sexo','$estado_civil','$direccion','$telefono','$email','$ocupacion','$apoderado')";
        $idpersonanew = ejecutarConsulta_retornarID($sql1);

        // Insertamos luego al usuario asociado a la persona
        $sql2 = "INSERT INTO usuario (UsuarioID, nroDocumento, NombreUsuario, clave, login)
		VALUES ('$idpersonanew','$num_documento','$login','$clave','$login')";
        ejecutarConsulta_retornarID($sql2);

        // Asignamos los permisos a través de un bucle
        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso (UsuarioID, idpermiso) VALUES('$idpersonanew', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos++;
        }

        return $sw;
    }

    // Método para editar registros de usuario y persona, y actualizar permisos
    public function editar($idpersona, $nombres, $apellidos, $tipo_documento, $num_documento, $fecha_nacimiento, $sexo, $estado_civil, $direccion, $telefono, $email, $ocupacion, $apoderado, $login, $clave, $permisos)
    {
        // Actualizamos la información de la persona
        $sql1 = "UPDATE persona SET Nombres='$nombres', Apellidos='$apellidos', tipoDocumento='$tipo_documento', 
		nroDocumento='$num_documento', FechaNacimiento='$fecha_nacimiento', sexo='$sexo', estado_civil='$estado_civil', 
		direccion='$direccion', telefono='$telefono', email='$email', ocupacion='$ocupacion', apoderado='$apoderado' 
		WHERE nroDocumento='$idpersona'";
        ejecutarConsulta($sql1);

        // Actualizamos la información del usuario
        $sql2 = "UPDATE usuario SET NombreUsuario='$login', clave='$clave', login='$login' 
		WHERE nroDocumento='$idpersona'";
        ejecutarConsulta($sql2);

        // Eliminamos todos los permisos asignados para volver a asignarlos
        $sqldel = "DELETE FROM usuario_permiso WHERE UsuarioID='$idpersona'";
        ejecutarConsulta($sqldel);

        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso (UsuarioID, idpermiso) VALUES('$idpersona', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos++;
        }

        return $sw;
    }

    // Método para desactivar un usuario
    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='0' WHERE UsuarioID='$idusuario'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un usuario
    public function activar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='1' WHERE UsuarioID='$idusuario'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los datos de un usuario específico
    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario u INNER JOIN persona p ON u.nroDocumento=p.nroDocumento WHERE u.UsuarioID='$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los usuarios con sus detalles
    public function listar()
    {
        $sql = "SELECT * FROM usuario u INNER JOIN persona p ON u.nroDocumento=p.nroDocumento";
        return ejecutarConsulta($sql);
    }

    // Método para listar los permisos marcados de un usuario
    public function listarmarcados($idusuario)
    {
        $sql = "SELECT * FROM usuario_permiso WHERE UsuarioID='$idusuario'";
        return ejecutarConsulta($sql);
    }

    // Método para verificar el acceso de un usuario
    public function verificar($login, $clave)
    {
        $sql = "SELECT idpersona FROM usuario WHERE login='$login' AND clave='$clave' AND condicion='1'";
        return ejecutarConsulta($sql);
    }
}
?>
