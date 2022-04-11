<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']!=2){
    header("location: escritorio.php");
}
$id_asignacion = $_GET["id_asignacion"];
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Notas</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            Revisar Notas
                        </div>
                        <div class="card-body">
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
                                            echo '<td>'.$muestroCalificacion[0].'</td>';
                                            echo '<td>'.$muestroCalificacion[1].'</td>';
                                            echo '<td>'.$muestroCalificacion[2].'</td>';
                                            echo '<td>'.$muestroCalificacion[3].'</td>';
                                            echo '<td>'.$muestroCalificacion[4].'</td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr>

                                    </tr>
                                </table>
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