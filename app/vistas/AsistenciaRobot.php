<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CC | Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/AdminLTE.min.css">
</head>
<body class="hold-transition lockscreen">
<!-- Lock Screen Wrapper -->
<div class="lockscreen-wrapper">
    <div id="movimientos"></div> <!-- Contenedor para mostrar mensajes de movimiento -->

    <!-- Lock Screen Logo -->
    <div class="lockscreen-logo">
        <a href="#"><b>CC</b> ASISTENCIA</a>
    </div>

    <!-- Lock Screen Name -->
    <div class="lockscreen-name">ASISTENCIA</div>

    <!-- Lock Screen Form -->
    <div class="lockscreen-item">
        <form action="#" class="lockscreen-credentials" name="formulario" id="formulario" method="POST">
            <div class="input-group">
                <input type="password" class="form-control" name="codigo_persona" id="codigo_persona" placeholder="ID de Usuario">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right text-muted"></i></button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.lockscreen-item -->
</div>
<!-- /.lockscreen-wrapper -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Tu script personalizado -->
<script type="text/javascript" src="../../../SAMMAE/publico/js/AJAX/asistenciaRobot.js"></script>

</body>
</html>
