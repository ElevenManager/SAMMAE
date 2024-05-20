<?php
if (strlen(session_id()) < 1)
    session_start();
require_once "../modelos/usuario.php";

$usuario=new Usuario();

$UsuarioID=isset($_POST["UsuarioID"])? limpiarCadena($_POST["UsuarioID"]):"";
$nroDocumento=isset($_POST["nroDocumento"])? limpiarCadena($_POST["nroDocumento"]):"";
$NombreUsuario=isset($_POST["NombreUsuario"])? limpiarCadena($_POST["NombreUsuario"]):"";
$rol=isset($_POST["rol"])? limpiarCadena($_POST["rol"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$NivelID=isset($_POST["NivelID"])? limpiarCadena($_POST["NivelID"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$condicion=isset($_POST["condicion"])? limpiarCadena($_POST["condicion"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':

        // Hash SHA256 en la contraseña
        $clavehash=hash("SHA256",$clave);

        if (empty($UsuarioID)){
            $rspta=$usuario->insertar($nroDocumento,$NombreUsuario,$rol,$clavehash,$NivelID,$login,$condicion,$_POST['permisos']);
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        }
        else {
            $rspta=$usuario->editar($UsuarioID,$nroDocumento,$NombreUsuario,$rol,$clavehash,$NivelID,$login,$condicion,$_POST['permisos']);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;

    case 'desactivar':
        $rspta=$usuario->desactivar($UsuarioID);
        echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
        break;

    case 'activar':
        $rspta=$usuario->activar($UsuarioID);
        echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;

    case 'mostrar':
        $rspta=$usuario->mostrar($UsuarioID);
        echo json_encode($rspta);
        break;

    case 'listarUsuarios':
        // Obtener registros de usuarios
        $rspta = $usuario->listarUsuarioss();
        // Declarar un array para almacenar los datos de la tabla
        $data = Array();

        // Iterar sobre los registros obtenidos
        while ($reg = $rspta->fetch_object()) {

            $acciones = '<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>' .
                ' <button title="Desactivar" class="btdesactivar" onclick=" desactivar(' . $reg->UsuarioID . ')"><i class="d"></i></button>' .
                ' <button title="Activar" class="btnactivar" onclick="activar(' . $reg->UsuarioID . ')"><i class="c"></i></button>';

            // Construir el array de datos para cada registro
            $data[] = Array(
                "0" => $reg->UsuarioID,
                "1" => $reg->NombresPersona . ' '. $reg->ApellidosPersona,
                "2" => $reg->NombreUsuario,
                "3" => $reg->rol,
                "4" => $reg->NivelID,
                "5" => $reg->login,
                "6" => ($reg-> condicion) ? '<span class="actividacion">Activado</span>' : '<span class="desactivad">Desactivado</span>',
                "7" => $acciones
            );
        }

        // Construir el array de resultados para DataTables
        $results = Array(
            "sEcho" => 1,  // Información para DataTables
            "iTotalRecords" => count($data),  // Total de registros
            "iTotalDisplayRecords" => count($data),  // Total de registros a visualizar
            "aaData" => $data  // Datos de la tabla
        );

        // Devolver la respuesta en formato JSON
        echo json_encode($results);
        break;


    case 'listarimportante':
        // Obtener registros de usuarios importantes
        $rspta = $usuario->listarUsuariosImportantes();
        // Declarar un array para almacenar los datos de la tabla
        $data = Array();

        // Iterar sobre los registros obtenidos
        while ($reg = $rspta->fetch_object()) {
            $acciones = ($reg->condicion)
                ? '<button title="Editar" class="btn btn-warning" onclick="mostrar(' . $reg->UsuarioID . ')"><i class="fa fa-pencil"></i></button>' .
                ' <button title="Desactivar" class="btn btn-danger" onclick="desactivar(' . $reg->UsuarioID . ')"><i class="fa fa-close"></i></button>'
                : '<button title="Editar" class="btn btn-warning" onclick="mostrar(' . $reg->UsuarioID . ')"><i class="fa fa-pencil"></i></button>' .
                ' <button title="Activar" class="btn btn-primary" onclick="activar(' . $reg->UsuarioID . ')"><i class="fa fa-check"></i></button>';

            // Construir el array de datos para cada registro
            $data[] = Array(
                "0" => $reg->UsuarioID,
                "1" => $reg->NombresPersona . ' '. $reg->ApellidosPersona,
                "2" => $reg->NombreUsuario,
                "3" => $reg->rol,
                "4" => $reg->NivelID,
                "5" => $reg->login,
                "6" => ($reg-> condicion) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>',
                "7" => $acciones
            );
        }

        // Construir el array de resultados para DataTables
        $results = Array(
            "sEcho" => 1,  // Información para DataTables
            "iTotalRecords" => count($data),  // Total de registros
            "iTotalDisplayRecords" => count($data),  // Total de registros a visualizar
            "aaData" => $data  // Datos de la tabla
        );

            // Devolver la respuesta en formato JSON
            echo json_encode($results);
            break;


    case 'permisos':
        // Obtenemos todos los permisos de la tabla permisos
        require_once "../../app/modelos/Permisos.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        // Obtener los permisos asignados al usuario
        $id=$_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        // Declaramos el array para almacenar todos los permisos marcados
        $valores=array();

        // Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object())
        {
            array_push($valores, $per->idpermiso);
        }

        // Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
        {
            $sw=in_array($reg->idpermiso,$valores)?'checked':'';
            echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
        }
        break;

    case 'verifica':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];

        // Hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $clavea);

        // Verifica si las credenciales son correctas
        $rspta = $usuario->verificar($logina, $clavehash);
        $fetch = $rspta->fetch_object();

        if ($fetch) { // Verifica si se encontró un usuario válido
            // Configura las variables de sesión
            $_SESSION['UsuarioID'] = $fetch->UsuarioID;
            $_SESSION['login'] = $fetch->login;
            $_SESSION['NombreUsuario'] = $fetch->NombreUsuario;

            // Obtiene los permisos del usuario
            $marcados = $usuario->listarmarcados($fetch->UsuarioID);

            // Declara el array para almacenar los permisos marcados
            $valores = array();

            // Almacena los permisos marcados en el array
            while ($per = $marcados->fetch_object()) {
                array_push($valores, $per->idpermiso);
            }

            // Determina los accesos del usuario y configura las variables de sesión
            $_SESSION['escritorio'] = in_array(1, $valores) ? 1 : 0;
            $_SESSION['alumnos'] = in_array(2, $valores) ? 1 : 0;
            $_SESSION['profesores'] = in_array(3, $valores) ? 1 : 0;
            $_SESSION['cursos'] = in_array(4, $valores) ? 1 : 0;
            $_SESSION['cursos_profesor'] = in_array(5, $valores) ? 1 : 0;
            $_SESSION['asistencias'] = in_array(6, $valores) ? 1 : 0;
            $_SESSION['niveles'] = in_array(7, $valores) ? 1 : 0;
            $_SESSION['cargas_masivas'] = in_array(8, $valores) ? 1 : 0;

            // Devuelve los datos del usuario en formato JSON
            echo json_encode($fetch);
        } else {
            // Usuario no encontrado o credenciales incorrectas
            echo json_encode(array('error' => 'Usuario no encontrado o credenciales incorrectas'));
        }
        break;

        case 'obtener_dniselect':
            // Llamar a la función obtenerDNIs para obtener los DNIs desde la base de datos
            $dnis = $usuario->obtenerDNIs();

            // Crear un array para almacenar los DNIs de forma individual
            $dnis_individuales = array();
            foreach ($dnis as $dni) {
                // Agregar cada DNI al array de forma individual
                $dnis_individuales[] = $dni['nroDocumento'];
            }

            // Devolver los DNIs individuales como respuesta JSON
            echo json_encode($dnis_individuales);
            break;


    case 'salir':
        // Limpiamos las variables de sesión
        session_unset();
        // Destruimos la sesión
        session_destroy();
        // Redireccionamos al login
        header("Location: ../../../../SAMMAE/index.php");
        break;

    default:

        // Código en caso de que ninguna de las opciones anteriores se ejecute
        echo "Operación no reconocida";
        break;
}
?>
