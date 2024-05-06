<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema SAMAAE | Menú</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <!-- Incluir jQuery (necesario para Bootbox) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="../../../../SAMMAE/publico/css/header.css"> <!-- Tu archivo CSS personalizado -->

</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Encabezado (Navbar horizontal) -->
<header class="main-header">
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" >SAMAAE</a>
                <a class="navbar-brand secondary-brand" >SanJose</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php
                    // Opciones del menú basadas en permisos de usuario
                    if ($_SESSION['escritorio'] == 1) {
                        echo '<li><a href="../../../../SAMMAE/app/vistas/escritorio.php">Escritorio</a></li>';
                    }
                    if ($_SESSION['cursos_profesor'] == 1) {
                        echo '<li><a href="Cursosprofesor.php">Cursos</a></li>';
                    }
                    if ($_SESSION['niveles'] == 1) {
                        echo '<li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="../../../../SAMMAE/app/vistas/Asitencias.php">A.Asistencias</a></li>
                                        <li><a href="../../../../SAMMAE/app/vistas/Usuarios.php">A.Usuarios</a></li>
                                        <li><a href="../../../../SAMMAE/app/vistas/Estudiante.php">A.Estudiantes</a></li>
                                        <li><a href="../../../../SAMMAE/app/vistas/Cursos.php">A.Cursos</a></li>
                                        <li><a href="permisos.php">A.Permisos</a></li>
                                    </ul>
                                </li>';
                    }
                    if ($_SESSION['asistencias'] == 1) {
                        echo '<li><a href="AsistenciaRobot.php">AsistenciaAutomatica</a></li>';
                    }
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo $_SESSION['NombreUsuario']; ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="../../../../SAMMAE/app/controladores/usuario.php?op=salir">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>



<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Incluir Bootbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<!-- Incluye tus scripts aquí -->

</body>
</html>
