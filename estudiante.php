<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']!=2){
    header("location: escritorio.php");
}
if(isset($_GET["eliminar"])){
    $conexion->query("DELETE FROM `alumno` WHERE id_alumno='".$_GET["eliminar"]."'");
    header("location: estudiante.php");
    exit();
}
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Estudiantes</h1>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Lista Estudiantes</h6>
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
                                    <td>DNI</td>
                                    <td>Apellidos y Nombres</td>
                                    <td>Dirección</td>
                                    <td>Teléfono</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $muestro_docentes = $conexion->query("SELECT id_alumno,dni,CONCAT(apellidos,' ',nombres) AS nombres,direccion,telefono FROM `alumno`");
                                    while($fila = $muestro_docentes->fetch_row()){
                                        echo "<tr>";
                                        echo "<td>$fila[1]</td>";
                                        echo "<td>$fila[2]</td>";
                                        echo "<td>$fila[3]</td>";
                                        echo "<td>$fila[4]</td>";
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
                                <tr>

                                </tr>
                            </table>
                            <?php } elseif(!isset($_GET["nuevo"])&&isset($_GET["editar"])) {
                                if(isset($_POST["editar"])){
                                    if(!empty($_POST["editar"])){
                                        $datos = $_POST["editar"];
                                        $actualizo = false;
                                        $verificoExistencia = $conexion->query("SELECT `id_alumno`,`dni` FROM `alumno` WHERE dni='$datos[4]'");
                                        if($verificoExistencia->num_rows==1){
                                            $dato_dni = $verificoExistencia->fetch_row();
                                            if($dato_dni[1]==$datos[4]){
                                                $actualizo = true;
                                            }
                                        } else {
                                            $actualizo = true;
                                        }
                                        if($actualizo==true){
                                            $conexion->query("UPDATE `alumno` SET `nombres`='$datos[0]',`apellidos`='$datos[1]',`direccion`='$datos[2]',`telefono`='$datos[3]',`dni`='$datos[4]',`clave`='$datos[5]',`id_estado`='$datos[6]' WHERE id_alumno='".$_GET["editar"]."'");
                                            header("location: estudiante.php");
                                            exit();
                                        }
                                    }
                                }
                                $muestro_datos = $conexion->query("SELECT `id_alumno`, `nombres`, `apellidos`, `direccion`, `telefono`, `dni`,`clave`,`id_estado` FROM `alumno` WHERE id_alumno='".$_GET["editar"]."'");
                                $datos = $muestro_datos->fetch_row();
                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form-group">
                                                <label>Nombres:</label>
                                                <input type="text" value="<?php echo $datos[1] ?>" name="editar[]" required class="form-control" placeholder="Nombres">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Apellidos:</label>
                                                <input type="text" value="<?php echo $datos[2] ?>" name="editar[]" required class="form-control" placeholder="Apellidos">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Dirección:</label>
                                                <input type="text" value="<?php echo $datos[3] ?>" name="editar[]" required class="form-control" placeholder="Dirección">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Teléfono:</label>
                                                <input type="number" value="<?php echo $datos[4] ?>" name="editar[]" required class="form-control" placeholder="Teléfono">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>DNI:</label>
                                                <input type="number" value="<?php echo $datos[5] ?>" name="editar[]" required class="form-control" placeholder="DNI">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Clave:</label>
                                                <input type="password" value="<?php echo $datos[6] ?>" name="editar[]" required class="form-control" placeholder="Clave">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Estado:</label>
                                                <select class="form-control" name="editar[]">
                                                    <option value="">Seleccione un estado</option>
                                                    <option value="0"<?php echo ($datos[7]==0)?" selected":"" ?>>Activo</option>
                                                    <option value="1"<?php echo ($datos[7]==1)?" selected":"" ?>>Inactivo</option>
                                                </select>
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
                                        $verificoExistencia = $conexion->query("SELECT `id_alumno`,`dni` FROM `alumno` WHERE dni='$datos[4]'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("INSERT INTO `alumno`(`nombres`, `apellidos`, `direccion`, `telefono`, `dni`, `clave`, `id_estado`) VALUES ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]')");
                                        }
                                        header("location: estudiante.php");
                                        exit();
                                    }
                                }
                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form-group">
                                                <label>Nombres:</label>
                                                <input type="text" name="crear[]" required class="form-control" placeholder="Nombres">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Apellidos:</label>
                                                <input type="text" name="crear[]" required class="form-control" placeholder="Apellidos">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Dirección:</label>
                                                <input type="text" name="crear[]" required class="form-control" placeholder="Dirección">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Teléfono:</label>
                                                <input type="number" name="crear[]" required class="form-control" placeholder="Teléfono">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>DNI:</label>
                                                <input type="number" name="crear[]" required class="form-control" placeholder="DNI">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Clave:</label>
                                                <input type="password" name="crear[]" required class="form-control" value="123456" required placeholder="Clave">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="form-group">
                                                <label>Estado:</label>
                                                <select class="form-control" name="crear[]" required>
                                                    <option value="">Seleccione un estado</option>
                                                    <option value="0">Activo</option>
                                                    <option value="1">Inactivo</option>
                                                </select>
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