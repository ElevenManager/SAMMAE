<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if ($_SESSION['cargas_masivas']==1)
{
    header("Location:Visualizacion de asistencias.html");
}
if (!isset($_SESSION["NombreUsuario"] ))
{
    header("Location: login.html");
}
else
    {
require 'General/header.php';

if ($_SESSION['escritorio']==1)

{
?>

<link rel="stylesheet" href="../../publico/css/escritorio.css">
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" id="sistema">
        <!-- Main content -->
        <section class="content">

                                  <?php
                                  session_start();
                                  $nombreUsuario = $_SESSION["login"];
                                  echo '<h3 style="font-size: 30px; text-align: center;">Hola '.$nombreUsuario.' </h3>';
                                  ?>

      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}
}

require 'General/footer.php';
?>
<!--script type="text/javascript" src="scripts/escritorio.js">/script-->
<script>setTimeout('document.location.reload()',10000); </script>
<?php
ob_end_flush();
?>