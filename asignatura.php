<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']!=2){
    header("location: escritorio.php");
}
if(isset($_GET["eliminar"])){
    $conexion->query("DELETE FROM `asignatura` WHERE `id_asignatura`='".$_GET["eliminar"]."'");
    header("location: asignatura.php");
    exit();
}
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Asignatura</h1>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Lista Asignatura</h6>
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
                                    <td>Area Curricular</td>
                                    <td>Asignatura</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $muestro_docentes = $conexion->query("  SELECT id_asignatura,area.descripcion AS area_descripcion,
                                                                            asignatura.descripcion AS asignatura_descripcion 
                                                                            FROM asignatura AS asignatura
                                                                            INNER JOIN area_curricular AS area
                                                                            ON
                                                                            area.id_area_curricular = asignatura.id_area_curricular");
                                    while($fila = $muestro_docentes->fetch_row()){
                                        echo "<tr>";
                                        echo "<td>$fila[1]</td>";
                                        echo "<td>$fila[2]</td>";
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
                                        $datos[1] = mb_strtoupper($datos[1], 'UTF-8');
                                        $verificoExistencia = $conexion->query("SELECT `id_asignatura` FROM `asignatura` WHERE `id_area_curricular` = '$datos[0]' AND `descripcion` = '$datos[1]'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("UPDATE `asignatura` SET `id_area_curricular`='$datos[0]',`descripcion`='$datos[1]' WHERE `id_asignatura`='".$_GET["editar"]."'");
                                        }
                                        header("location: asignatura.php");
                                        exit();
                                    }
                                }
                                $muestro_datos = $conexion->query("SELECT `id_area_curricular`, `descripcion` FROM `asignatura` WHERE `id_asignatura` = '".$_GET["editar"]."'");
                                $datos = $muestro_datos->fetch_row();

                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Área Curricular:</label>
                                                <select class="form-control" name="editar[]" required>
                                                <?php
                                                    $area_curricular = $conexion->query("SELECT `id_area_curricular`, `descripcion` FROM `area_curricular`");
                                                    while($fila = $area_curricular->fetch_row()){
                                                        if($fila[0]==$datos[0]){
                                                            echo "<option selected value=\"$fila[0]\">$fila[1]</option>";
                                                        } else {
                                                            echo "<option value=\"$fila[0]\">$fila[1]</option>";
                                                        }
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Asignatura:</label>
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
                                        $datos[1] = mb_strtoupper($datos[1], 'UTF-8');
                                        $verificoExistencia = $conexion->query("SELECT `id_asignatura` FROM `asignatura` WHERE `id_area_curricular` = '$datos[0]' AND `descripcion` = '$datos[1]'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("INSERT INTO `asignatura`(`id_area_curricular`, `descripcion`) VALUES ('$datos[0]','$datos[1]')");
                                        }
                                        header("location: asignatura.php");
                                        exit();
                                    }
                                }
                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Área Curricular:</label>
                                                <select class="form-control" name="crear[]" required>
                                                    <option value="">Seleccione una Área Curricular</option>
                                                <?php
                                                    $area_curricular = $conexion->query("SELECT `id_area_curricular`, `descripcion` FROM `area_curricular`");
                                                    while($fila = $area_curricular->fetch_row()){
                                                        echo "<option value=\"$fila[0]\">$fila[1]</option>";
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Asignatura:</label>
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