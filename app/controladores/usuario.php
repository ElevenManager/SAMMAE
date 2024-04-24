<?php
if (strlen(session_id()) < 1)
    session_start();
require_once "../modelos/Usuario.php";

$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nroDocumento=isset($_POST["nroDocumento"])? limpiarCadena($_POST["nroDocumento"]):"";
$NombreUsuario=isset($_POST["NombreUsuario"])? limpiarCadena($_POST["NombreUsuario"]):"";
$rol=isset($_POST["rol"])? limpiarCadena($_POST["rol"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$NivelID=isset($_POST["NivelID"])? limpiarCadena($_POST["NivelID"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$condicion=isset($_POST["condicion"])? limpiarCadena($_POST["condicion"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':


        //Hash SHA256 en la contraseña
        $clavehash=hash("SHA256",$clave);

        if (empty($idusuario)){
            $rspta=$usuario->insertar($nroDocumento,$NombreUsuario,$rol,$clavehash,$NivelID,$login,$condicion,$_POST['permisos']);
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        }
        else {
            $rspta=$usuario->editar($idusuario,$nroDocumento,$NombreUsuario,$rol,$clavehash,$NivelID,$login,$condicion,$_POST['permisos']);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;

    case 'desactivar':
        $rspta=$usuario->desactivar($idusuario);
        echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
        break;

    case 'activar':
        $rspta=$usuario->activar($idusuario);
        echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;

    case 'mostrar':
        $rspta=$usuario->mostrar($idusuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta=$usuario->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button title="Desactivar" class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
                    '<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button title="Activar" class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->apaterno . ' '.$reg->amaterno,
                "2"=>$reg->nombre,
                "3"=>$reg->fecha_nacimiento,
                "4"=>$reg->sexo,
                "5"=>$reg->estado_civil,
                "6"=>$reg->tipo_documento,
                "7"=>$reg->num_documento,
                "8"=>$reg->cargo,
                "9"=>$reg->especialidad,
                "10"=>$reg->login,
                "11"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                    '<span class="label bg-red">Desactivado</span>'
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;

    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        //Obtener los permisos asignados al usuario
        $id=$_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores=array();

        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object())
        {
            array_push($valores, $per->idpermiso);
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
        {
            $sw=in_array($reg->idpermiso,$valores)?'checked':'';
            echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
        }
        break;

    case 'verificar':
        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];

        //Hash SHA256 en la contraseña
        $clavehash=hash("SHA256",$clavea);

        $rspta=$usuario->verificar($logina, $clavehash);

        $fetch=$rspta->fetch_object();

        if (isset($fetch))
        {
            //Declaramos las variables de sesión
            $_SESSION['idusuario']=$fetch->UsuarioID;
            $_SESSION['nombre']=$fetch->NombreUsuario;
            $_SESSION['login']=$fetch->login;

            //Obtenemos los permisos del usuario
            $marcados = $usuario->listarmarcados($fetch->UsuarioID);

            //Declaramos el array para almacenar todos los permisos marcados
            $valores=array();

            //Almacenamos los permisos marcados en el array
            while ($per = $marcados->fetch_object())
            {
                array_push($valores, $per->idpermiso);
            }

            //Determinamos los accesos del usuario
            in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
            in_array(2,$valores)?$_SESSION['Cursos']=1:$_SESSION['pacientes']=0;
            in_array(3,$valores)?$_SESSION['clinica']=1:$_SESSION['clinica']=0;
            in_array(4,$valores)?$_SESSION['doctores']=1:$_SESSION['doctores']=0;
            in_array(5,$valores)?$_SESSION['usuarios']=1:$_SESSION['usuarios']=0;

            echo json_encode($fetch);
        }
        else
        {
            echo '0';
        }
        break;

    case 'salir':
        //Limpiamos las variables de sesión
        session_unset();
        //Destruimos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
        break;

    default:
        //Código en caso de que ninguna de las opciones anteriores se ejecute
        echo "Operación no reconocida";
        break;
}
?>

