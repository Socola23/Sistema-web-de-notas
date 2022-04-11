<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']!=2){
    header("location: escritorio.php");
}
$periodo = date("Y");
if(isset($_GET["eliminar"])){
    $conexion->query("DELETE FROM `asignacion` WHERE `id_asignacion`='".$_GET["eliminar"]."'");
    header("location: carga_academica.php");
    exit();
}
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Estudio</h1>
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
                                    <td>Estudiante</td>
                                    <td>Aula</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $periodo = date("Y");
                                    $muestro_docentes = $conexion->query("SELECT id_estudio, 
                                                                            CONCAT(alumno.apellidos,' ',alumno.nombres) AS estudiante,
                                                                            CONCAT( aula.grado,'° ',aula.seccion,' ',
                                                                                   (
                                                                                       CASE aula.nivel
                                                                                       WHEN 0 THEN
                                                                                       'Inicial'
                                                                                       WHEN 1 THEN
                                                                                       'Primaria'
                                                                                       WHEN 2 THEN
                                                                                       'Secundaria'
                                                                                       END
                                                                                   )
                                                                                  ) AS aula_descripcion,
                                                                            estudio.id_periodo FROM estudio
                                                                            INNER JOIN alumno
                                                                            ON
                                                                            alumno.id_alumno = estudio.id_alumno
                                                                            INNER JOIN aula
                                                                            ON
                                                                            aula.id_aula = estudio.id_aula
                                                                            WHERE estudio.id_periodo='$periodo'");
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
                                        echo "<td></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                            <?php } elseif(!isset($_GET["nuevo"])&&isset($_GET["editar"])) {
                                if(isset($_POST["editar"])){
                                    if(!empty($_POST["editar"])){
                                        $datos = $_POST["editar"];
                                        $conexion->query("UPDATE `estudio` SET `id_alumno`='$datos[0]',`id_aula`='$datos[1]' WHERE `id_estudio` = '".$_GET["editar"]."'");
                                        $conexion->query("DELETE FROM `calificacion` WHERE id_estudio='".$_GET["editar"]."'");
                                        header("location: estudio.php");
                                        exit();
                                    }
                                }
                                $muestro_datos = $conexion->query("SELECT `id_alumno`, `id_aula`, `id_periodo` FROM `estudio` WHERE id_estudio='".$_GET["editar"]."' AND id_periodo='$periodo'");
                                $datos = $muestro_datos->fetch_row();
                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div id="form-group">
                                                <label>Estudiante:</label>
                                                <select name="editar[]" class="form-control" required>
                                                    <option value="">Seleccione un estudiante</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT `id_alumno`, CONCAT(`apellidos`,' ',`nombres`) FROM `alumno`");
                                                        while($fila = $muestroDocente->fetch_row()){
                                                            if($fila[0]==$datos[0]){
                                                                echo "<option value=\"$fila[0]\" selected>$fila[1]</option>";
                                                            } else {
                                                                echo "<option value=\"$fila[0]\">$fila[1]</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Aula:</label>
                                                <select class="form-control" required name="editar[]" required>
                                                    <option value="">Seleccione una aula</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT `id_aula`,  
                                                            CONCAT( aula.grado,'° ',aula.seccion,' ',
                                                                               (
                                                                                   CASE aula.nivel
                                                                                   WHEN 0 THEN
                                                                                   'Inicial'
                                                                                   WHEN 1 THEN
                                                                                   'Primaria'
                                                                                   WHEN 2 THEN
                                                                                   'Secundaria'
                                                                                   END
                                                                               )
                                                            ) AS aula_descripcion FROM `aula`");
                                                        while($fila = $muestroDocente->fetch_row()){
                                                            if($fila[0]==$datos[1]){
                                                                echo "<option value=\"$fila[0]\" selected>$fila[1]</option>";
                                                            } else {
                                                                echo "<option value=\"$fila[0]\">$fila[1]</option>";
                                                            }
                                                        }
                                                    ?>
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
                                         $verificoExistencia = $conexion->query("SELECT `id_estudio`, `id_alumno`, `id_aula`, `id_periodo` FROM `estudio` WHERE id_alumno='$datos[0]' AND id_aula='$datos[1]' AND `id_periodo` = '$periodo'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("INSERT INTO `estudio`(`id_alumno`, `id_aula`, `id_periodo`) VALUES ('$datos[0]','$datos[1]','$periodo')");
                                        }
                                        header("location: estudio.php");
                                        exit();
                                    }
                                }
                            ?>
                                                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div id="form-group">
                                                <label>Estudiante:</label>
                                                <select name="crear[]" class="form-control" required>
                                                    <option value="">Seleccione un estudiante</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT `id_alumno`, CONCAT(`apellidos`,' ',`nombres`) FROM `alumno`");
                                                        while($fila = $muestroDocente->fetch_row()){
                                                            echo "<option value=\"$fila[0]\">$fila[1]</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Aula:</label>
                                                <select class="form-control" required name="crear[]" required>
                                                    <option value="">Seleccione una aula</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT `id_aula`,  
                                                            CONCAT( aula.grado,'° ',aula.seccion,' ',
                                                                               (
                                                                                   CASE aula.nivel
                                                                                   WHEN 0 THEN
                                                                                   'Inicial'
                                                                                   WHEN 1 THEN
                                                                                   'Primaria'
                                                                                   WHEN 2 THEN
                                                                                   'Secundaria'
                                                                                   END
                                                                               )
                                                            ) AS aula_descripcion FROM `aula`");
                                                        while($fila = $muestroDocente->fetch_row()){
                                                            echo "<option value=\"$fila[0]\">$fila[1]</option>";
                                                        }
                                                    ?>
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