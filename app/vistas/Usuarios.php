<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["NombreUsuario"]))
{
    header("Location: login.html");
}
else
{
    require 'General/header.php';
    if ($_SESSION['niveles']==1)
    {
        ?>
        <!--Contenido-->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Usuario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pertenecia</th>
                                        <th>Nombre</th>
                                        <th>Rol</th>
                                        <th>NivelID</th>
                                        <th>Login</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pertenecia</th>
                                        <th>Nombre</th>
                                        <th>Rol</th>
                                        <th>NivelID</th>
                                        <th>Login</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label>ID:</label>
                                        <input type="hidden" name="idusuario" id="idusuario">
                                        <input type="text" class="form-control" name="id" id="id" placeholder="ID" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label>Pertenecia:</label>
                                        <input type="text" class="form-control" name="pertenecia" id="pertenecia" placeholder="Pertenecia" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label>Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label>Rol:</label>
                                        <input type="text" class="form-control" name="rol" id="rol" placeholder="Rol" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label>NivelID:</label>
                                        <input type="text" class="form-control" name="nivelid" id="nivelid" placeholder="NivelID" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label>Login:</label>
                                        <input type="text" class="form-control" name="login" id="login" placeholder="Login" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label>Estado:</label>
                                        <select class="form-control" name="estado" id="estado" required>
                                            <option value="Activado">Activado</option>
                                            <option value="Desactivado">Desactivado</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    </div>
                                </form>
                            </div>
                            <!--Fin centro -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <!--Fin-Contenido-->

        <?php
    }
    else
    {
        require 'noacceso.php';
    }
    require 'General/footer.php';
    ?>

    <!-- jQuery -->


    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../../SAMMAE/publico/js/AJAX/usuario.js"></script>
    <?php
}
ob_end_flush();
?>
