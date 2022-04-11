<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']==3){
    header("location: escritorio.php");
}
$id_asignacion = $_GET["id_asignacion"];
if(isset($_POST["datos"])){
    if(!empty($_POST["datos"])){
        $conexion->query("DELETE FROM `calificacion` WHERE id_asignacion='$id_asignacion'");
        $conexion->query("DELETE FROM `conclusion_descriptiva` WHERE id_asignacion='$id_asignacion'");
        $datos = $_POST["datos"];
        foreach($datos as $clave=>$valor){
            foreach($valor as $clave2=>$valor2){
                if(!empty($valor2)){
                    $conexion->query("INSERT INTO `calificacion`(`id_estudio`, `id_asignacion`, `unidad`, `calificacion`) VALUES ('$clave','$id_asignacion','$clave2','$valor2')");
                }
            }
            //$insertoDatos = $conexion->
            //echo $datosAsignatura[0];
        }
        foreach($_POST["conclusion"] as $clave => $valor){
            $conexion->query("INSERT INTO `conclusion_descriptiva`(`id_estudio`, `id_asignacion`, `conclusion`) VALUES ('$clave','$id_asignacion','$valor')");
        }
        header("location: calificacion.php");
    }
}
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Calificaciones</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            Lista de Estudiantes | Asignatura: <?php echo $_GET["asignatura"] ?> | Aula: <?php echo $_GET["aula"] ?>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <table class="table">
                                    <tr>
                                        <th style="width: 20%">Apellidos y Nombres</th>
                                        <th style="width: 14%">I Bimestre</th>
                                        <th style="width: 14%">II Bimestre</th>
                                        <th style="width: 14%">III Bimestre</th>
                                        <th style="width: 14%">IV Bimestre</th>
                                        <th>Conclusión Descriptiva</th>
                                    </tr>
                                    <?php
                                        $muestro_docentes = $conexion->query("  SELECT 
                                                                            estudio.id_estudio,
                                                                            CONCAT(alumno.apellidos,' ',alumno.nombres) AS alumno,
                                                                            asignacion.id_asignatura
                                                                            FROM estudio
                                                                            INNER JOIN aula
                                                                            ON
                                                                            aula.id_aula = estudio.id_aula
                                                                            INNER JOIN asignacion
                                                                            ON
                                                                            asignacion.id_aula = aula.id_aula
                                                                            AND
                                                                            asignacion.id_asignacion = '$id_asignacion'
                                                                            INNER JOIN alumno
                                                                            ON
                                                                            alumno.id_alumno = estudio.id_alumno");
                                        while($fila = $muestro_docentes->fetch_row()){
                                            $verificoNota = $conexion->query("
                                            SELECT 
                                            (SELECT calificacion FROM calificacion WHERE id_estudio='$fila[0]' AND id_asignacion='$id_asignacion' AND unidad='1' LIMIT 1),
                                            (SELECT calificacion FROM calificacion WHERE id_estudio='$fila[0]' AND id_asignacion='$id_asignacion' AND unidad='2' LIMIT 1),
                                            (SELECT calificacion FROM calificacion WHERE id_estudio='$fila[0]' AND id_asignacion='$id_asignacion' AND unidad='3' LIMIT 1),
                                            (SELECT calificacion FROM calificacion WHERE id_estudio='$fila[0]' AND id_asignacion='$id_asignacion' AND unidad='4' LIMIT 1),
                                            (SELECT conclusion FROM conclusion_descriptiva WHERE id_estudio='$fila[0]' AND id_asignacion='$id_asignacion' LIMIT 1)");
                                            $muestroCalificacion = $verificoNota->fetch_row();
                                            echo "<tr>";
                                            echo "<td>$fila[1]</td>";
                                            echo '<td>
                                            <div class="form-group w-50">
                                                <input value="'.$muestroCalificacion[0].'" min="0" max="20" type="number" name="datos['.$fila[0].'][1]" class="form-control input-sm">
                                            </div>
                                            </td>';
                                            echo '<td>
                                            <div class="form-group w-50">
                                                <input value="'.$muestroCalificacion[1].'" min="0" max="20" type="number" name="datos['.$fila[0].'][2]" class="form-control input-sm">
                                            </div>
                                            </td>';
                                            echo '<td>
                                            <div class="form-group w-50">
                                                <input value="'.$muestroCalificacion[2].'" min="0" max="20" type="number" name="datos['.$fila[0].'][3]" class="form-control input-sm">
                                            </div>
                                            </td>';
                                            echo '<td>
                                            <div class="form-group w-50">
                                                <input value="'.$muestroCalificacion[3].'" min="0" max="20" type="number" name="datos['.$fila[0].'][4]" class="form-control input-sm">
                                            </div>
                                            </td>';
                                            echo '<td>
                                            <div class="form-group w-50">
                                                <textarea name="conclusion['.$fila[0].']" class="form-control input-sm">'.$muestroCalificacion[4].'</textarea>
                                            </div>
                                            </td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr>

                                    </tr>
                                </table>
                                <button type="submit" class="btn btn-primary">Registrar Calificaciones</button>
                            </form>
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