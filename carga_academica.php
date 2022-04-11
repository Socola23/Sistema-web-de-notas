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
                    <h1 class="h3 mb-4 text-gray-800">Gestión Carga Académica</h1>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Lista Carga Académica</h6>
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
                                    <td>Docente</td>
                                    <td>Asignatura</td>
                                    <td>Aula</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $muestro_docentes = $conexion->query("SELECT asignacion.id_asignacion,
                                                                        CONCAT(docente.apellidos,' ',docente.nombres) AS docente_nombre,
                                                                        CONCAT(asignatura.descripcion) AS asignatura_descripcion,
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
                                                                              ) AS aula_descripcion
                                                                        FROM asignacion
                                                                        INNER JOIN docente
                                                                        ON
                                                                        docente.id_docente = asignacion.id_docente
                                                                        INNER JOIN asignatura
                                                                        ON
                                                                        asignatura.id_asignatura = asignacion.id_asignatura
                                                                        INNER JOIN aula
                                                                        ON
                                                                        aula.id_aula = asignacion.id_aula");
                                    while($fila = $muestro_docentes->fetch_row()){
                                        echo "<tr>";
                                        echo "<td>$fila[1]</td>";
                                        echo "<td>$fila[2]</td>";
                                        echo "<td>$fila[3]</td>";
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
                                                <a class="dropdown-item" href="calificacion_revisar.php?id_asignacion='.$fila[0].'">Revisar Notas</a>
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
                                        $verificoExistencia = $conexion->query("SELECT `id_asignacion` FROM `asignacion` 
                                            WHERE 
                                            `id_docente` = '$datos[0]' AND `id_asignatura` = '$datos[1]' AND `id_aula` = '$datos[2]' AND `periodo` = '$periodo'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("UPDATE `asignacion` SET `id_docente`='$datos[0]',`id_asignatura`='$datos[1]',`id_aula`='$datos[2]' WHERE `id_asignacion`='".$_GET["editar"]."'");
                                        }
                                        header("location: carga_academica.php");
                                        exit();
                                    }
                                }
                                $muestro_datos = $conexion->query("SELECT `id_docente`, `id_asignatura`, `id_aula` FROM `asignacion` WHERE id_asignacion='".$_GET["editar"]."' AND periodo='$periodo'");
                                $datos = $muestro_datos->fetch_row();

                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Docente:</label>
                                                <select name="editar[]" class="form-control" required>
                                                    <option value="">Selecciona un docente</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT `id_docente`,CONCAT(apellidos,' ',nombres)  FROM `docente` WHERE id_estado=0");
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
                                                <label>Asignatura:</label>
                                                <select name="editar[]" class="form-control" required>
                                                    <option value="">Selecciona una asignatura</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT asignatura.id_asignatura,CONCAT(asignatura.descripcion,' | ',area_curricular.descripcion) 
                                                            FROM asignatura
                                                            INNER JOIN area_curricular
                                                            ON
                                                            area_curricular.id_area_curricular = asignatura.id_area_curricular"
                                                            );
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
                                                            if($fila[0]==$datos[2]){
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
                                         $verificoExistencia = $conexion->query("SELECT `id_asignacion` FROM `asignacion` 
                                            WHERE 
                                            `id_docente` = '$datos[0]' AND `id_asignatura` = '$datos[1]' AND `id_aula` = '$datos[2]' AND `periodo` = '$periodo'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("INSERT INTO `asignacion`(`id_docente`, `id_asignatura`, `id_aula`, `periodo`) VALUES ('$datos[0]','$datos[1]','$datos[2]','$periodo')");
                                        }
                                        header("location: carga_academica.php");
                                        exit();
                                    }
                                }
                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Docente:</label>
                                                <select name="crear[]" class="form-control" required>
                                                    <option value="">Selecciona un docente</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT `id_docente`,CONCAT(apellidos,' ',nombres)  FROM `docente` WHERE id_estado=0");
                                                        while($fila = $muestroDocente->fetch_row()){
                                                            echo "<option value=\"$fila[0]\">$fila[1]</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Asignatura:</label>
                                                <select name="crear[]" class="form-control" required>
                                                    <option value="">Selecciona una asignatura</option>
                                                    <?php
                                                        $muestroDocente = $conexion->query("SELECT asignatura.id_asignatura,CONCAT(asignatura.descripcion,' | ',area_curricular.descripcion) 
                                                            FROM asignatura
                                                            INNER JOIN area_curricular
                                                            ON
                                                            area_curricular.id_area_curricular = asignatura.id_area_curricular"
                                                            );
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