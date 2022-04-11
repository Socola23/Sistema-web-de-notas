<?php 
include("global/conexion.php");
include("global/top.php");
$docente_presente = "";
if($_SESSION['tipo_usuario']==3){
    header("location: escritorio.php");
}
if($_SESSION['tipo_usuario']==1){
    $docente_presente = " AND asignacion.id_docente='".$_SESSION["id_usuario"]."'";
}
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Calificaciones</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            Lista de Aulas
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td>Asignatura</td>
                                    <td>Aula</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $periodo = date("Y");
                                    $muestro_docentes = $conexion->query("  SELECT id_asignacion,asignatura.descripcion,
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
                                                                                  ) AS aula_descripcion FROM asignacion
                                                                            INNER JOIN asignatura
                                                                            ON
                                                                            asignatura.id_asignatura = asignacion.id_asignatura
                                                                            INNER JOIN aula
                                                                            ON
                                                                            aula.id_aula = asignacion.id_aula
                                                                            WHERE
                                                                            asignacion.periodo = '$periodo'".$docente_presente);
                                    while($fila = $muestro_docentes->fetch_row()){
                                        echo "<tr>";
                                        echo "<td>$fila[1]</td>";
                                        echo "<td>$fila[2]</td>";
                                        echo '<td><a href="calificacion_estudiante.php?id_asignacion='.$fila[0].'&asignatura='.$fila[1].'&aula='.$fila[2].'" class="btn btn-primary"><i class="fas fa-list-ol"></i> Calificar</a></td>';
                                        echo "</tr>";
                                    }
                                ?>
                                <tr>

                                </tr>
                            </table>
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