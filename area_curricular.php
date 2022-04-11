<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']!=2){
    header("location: escritorio.php");
}
if(isset($_GET["eliminar"])){
    $conexion->query("DELETE FROM `area_curricular` WHERE `id_area_curricular`='".$_GET["eliminar"]."'");
    header("location: area_curricular.php");
    exit();
}
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Áreas Curriculares</h1>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Lista Área Curricular</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Opciones:</div>
                                    <a class="dropdown-item" href="?nuevo">Nuevo</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if(!isset($_GET["nuevo"])&&!isset($_GET["editar"])) { ?>
                            <table class="table">
                                <tr>
                                    <td>Descripción</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $muestro_docentes = $conexion->query("SELECT `id_area_curricular`, `descripcion` FROM `area_curricular` WHERE 1");
                                    while($fila = $muestro_docentes->fetch_row()){
                                        echo "<tr>";
                                        echo "<td>$fila[1]</td>";
                                        echo '
                                        <td>
                                        <div class="dropdown mb-4">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Opciones
                                            </button>
                                            <div class="dropdown-menu animated--fade-in"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="?editar='.$fila[0].'">Editar</a>
                                                <a class="dropdown-item" href="?eliminar='.$fila[0].'">Eliminar</a>
                                            </div>
                                        </div>
                                        </td>';
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                            <?php } elseif(!isset($_GET["nuevo"])&&isset($_GET["editar"])) {
                                if(isset($_POST["editar"])){
                                    if(!empty($_POST["editar"])){
                                        $datos = $_POST["editar"];
                                        $datos[0] = mb_strtoupper($datos[0], 'UTF-8');
                                        $verificoExistencia = $conexion->query("SELECT `descripcion` FROM `area_curricular` WHERE `descripcion` = '$datos[0]'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("UPDATE `area_curricular` SET `descripcion`='$datos[0]' WHERE `id_area_curricular`='".$_GET["editar"]."'");
                                        }
                                        header("location: area_curricular.php");
                                        exit();
                                    }
                                }
                                $muestro_datos = $conexion->query("SELECT `id_area_curricular`, `descripcion` FROM `area_curricular` WHERE id_area_curricular='".$_GET["editar"]."'");
                                $datos = $muestro_datos->fetch_row();

                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form-group">
                                                <label>Descripción:</label>
                                                <input type="text" value="<?php echo $datos[1] ?>" name="editar[]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Modificar</button>
                                </form>
                            <?php } elseif(isset($_GET["nuevo"])&&!isset($_GET["editar"])) {
                                if(isset($_POST["crear"])){
                                    if(!empty($_POST["crear"])){
                                        $datos = $_POST["crear"];
                                        $datos[0] = mb_strtoupper($datos[0], 'UTF-8');
                                        $verificoExistencia = $conexion->query("SELECT `descripcion` FROM `area_curricular` WHERE `descripcion` = '$datos[0]'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("INSERT INTO `area_curricular`(`descripcion`) VALUES ('$datos[0]')");
                                        }
                                        header("location: area_curricular.php");
                                        exit();
                                    }
                                }
                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form-group">
                                                <label>Descripción:</label>
                                                <input type="text" name="crear[]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Crear</button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End of Main Content -->
<?php include("global/bottom.php"); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>