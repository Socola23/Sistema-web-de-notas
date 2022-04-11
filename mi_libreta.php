<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']!=3){
    header("location: escritorio.php");
}
$periodo = date("Y");
$obtengo_id_estudio = $conexion->query("SELECT `id_estudio` FROM `estudio` WHERE id_alumno='".$_SESSION["id_usuario"]."' AND id_periodo='$periodo' LIMIT 1");
$id_estudio = $obtengo_id_estudio->fetch_row()[0];
$_SESSION["id_estudio"] = $id_estudio;
$datos_estudiante = $conexion->query("  SELECT 
                                        CONCAT(alumno.apellidos,' ',alumno.nombres) AS nombres_estudiante,
                                        alumno.dni AS dni_estudiante,
                                        (
                                            CASE aula.nivel
                                            WHEN 0 THEN
                                            'Inicial'
                                            WHEN 1 THEN
                                            'Primaria'
                                            WHEN 2 THEN
                                            'Secundaria'
                                            END
                                        ) as nivel_estudiante
                                        , aula.grado AS grado_estudiante
                                        , estudio.id_aula AS aula_estudiante
                                        FROM estudio
                                        INNER JOIN alumno
                                        ON
                                        alumno.id_alumno = estudio.id_alumno
                                        INNER JOIN aula
                                        ON
                                        estudio.id_aula = aula.id_aula
                                        WHERE
                                        estudio.id_estudio = '$id_estudio'");
$datos_estudiante = $datos_estudiante->fetch_row();
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Mi Libreta</h1>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Lista Notas</h6>
                        </div>
                        <div class="card-body">
                        <a href="libreta_nota.php?id_estudio=<?php echo $id_estudio?>" class="btn btn-primary" download>Descargar Libreta</a>
                        <center><img src="img/logo.png"></center>
                        <table width="100%">
                            <tr>
                                <td colspan="2" align="center"><b>INSTITUCIÓN EDUCATIVA PARTICULAR<br>“NEWTON COLLEGE”</b></td>
                            </tr>
                            <tr>
                                <td>DRE</td>
                                <td>LA LIBERTAD</td>
                            </tr>
                            <tr>
                                <td>UGEL</td>
                                <td>04 TRUJILLO SUR ESTE</td>
                            </tr>
                            <tr>
                                <td>NIVEL</td>
                                <td><?php echo $datos_estudiante[2] ?></td>
                            </tr>
                            <tr>
                                <td>GRADO</td>
                                <td><?php echo $datos_estudiante[3] ?></td>
                            </tr>
                            <tr>
                                <td>APELLIDOS Y NOMBRES DEL ESTUDIANTE</td>
                                <td><?php echo $datos_estudiante[0] ?></td>
                            </tr>
                            <tr>
                                <td>DNI</td>
                                <td><?php echo $datos_estudiante[1] ?></td>
                            </tr>
                        </table>
                        <br>
                        <table id="tablita" class="table" width="100%">
                            <tr align="center">
                                <td rowspan="2">AREA CURRICULAR</td>
                                <td rowspan="2">ASIGNATURA</td>
                                <td colspan="5">PERIODO</td>
                                <td rowspan="2">CONCLUSIÓN DESCRIPTIVA</td>
                            </tr>
                            <tr align="center">
                                <td>I</td>
                                <td>II</td>
                                <td>III</td>
                                <td>IV</td>
                                <td>PROM</td>
                            </tr>
                                <?php
                                    $muestroAreasCurriculares = $conexion->query("SELECT area_curricular.id_area_curricular,
                        area_curricular.descripcion,
                        (COUNT(asignatura.id_asignatura)) AS contador   
                        FROM area_curricular 
                        INNER JOIN asignatura
                        ON
                        asignatura.id_area_curricular = area_curricular.id_area_curricular
                        INNER JOIN asignacion
                        ON
                        asignacion.id_asignatura = asignatura.id_asignatura
                        AND
                        asignacion.id_aula='".$datos_estudiante[4]."'
                        GROUP BY area_curricular.id_area_curricular");
                                    while($fila = $muestroAreasCurriculares->fetch_row()){
                                        echo "<tr align=\"center\">
                                            <td rowspan=\"".($fila[2]+1)."\">$fila[1]</td>";
                                        $p = 0;
                                        $muestroAsignaturas = $conexion->query("SELECT asignatura.id_asignatura, asignatura.descripcion,
                                                                                (   SELECT calificacion FROM `calificacion` WHERE asignacion.id_asignacion = calificacion.id_asignacion AND id_estudio='".$id_estudio."'
                                                                                    AND unidad='1'),
                                                                                (   SELECT calificacion FROM `calificacion` WHERE asignacion.id_asignacion = calificacion.id_asignacion AND id_estudio='".$id_estudio."'
                                                                                AND unidad='2'),
                                                                                (   SELECT calificacion FROM `calificacion` WHERE asignacion.id_asignacion = calificacion.id_asignacion AND id_estudio='".$id_estudio."'
                                                                                AND unidad='3'),
                                                                                (   SELECT calificacion FROM `calificacion` WHERE asignacion.id_asignacion = calificacion.id_asignacion AND id_estudio='".$id_estudio."'
                                                                                AND unidad='4'),
                                                                                (   SELECT conclusion FROM `conclusion_descriptiva` AS conclusion_d WHERE asignacion.id_asignacion = conclusion_d.id_asignacion AND conclusion_d.id_estudio='".$id_estudio."')
                                                                                FROM asignatura
                                                                                INNER JOIN asignacion
                                                                                ON
                                                                                asignacion.id_aula='".$datos_estudiante[4]."'
                                                                                AND
                                                                                asignacion.id_asignatura = asignatura.id_asignatura
                                                                                WHERE asignatura.id_area_curricular='$fila[0]'");
                                        $total_filas = $muestroAsignaturas->num_rows;
                                        $p_unidad_1 = 0;
                                        $p_unidad_2 = 0;
                                        $p_unidad_3 = 0;
                                        $p_unidad_4 = 0;
                                        $p_unidad_g = 0;
                                        while($fila2 = $muestroAsignaturas->fetch_row()){
                                            if($p>0){
                                                echo "<tr align=\"center\">";
                                            }
                                            $p_unidad_1 += $fila2[2];
                                            $p_unidad_2 += $fila2[3];
                                            $p_unidad_3 += $fila2[4];
                                            $p_unidad_4 += $fila2[5];
                                            $p_unidad_g += (($fila2[2]+$fila2[3]+$fila2[4]+$fila2[5])/4);
                                            echo "<td>$total_filas - $fila2[1]</td>
                                                <td>$fila2[2]</td>
                                                <td>$fila2[3]</td>
                                                <td>$fila2[4]</td>
                                                <td>$fila2[5]</td>
                                                <td>".round((($fila2[2]+$fila2[3]+$fila2[4]+$fila2[5])/4))."</td>
                                                <td>$fila2[6]</td>
                                            </tr>
                                            ";
                                            $p++;   
                                        }
                                        echo "  <tr align=\"center\">
                                                <td>CALIFICACIÓN DEL ÁREA</td>
                                                <td>".round(($p_unidad_1/$fila[2]))."</td>
                                                <td>".round(($p_unidad_2/$fila[2]))."</td>
                                                <td>".round(($p_unidad_3/$fila[2]))."</td>
                                                <td>".round(($p_unidad_4/$fila[2]))."</td>
                                                <td>".round(($p_unidad_g/$fila[2]))."</td>
                                                <td></td>
                                                </tr>
                                        ";
                                    }
                                ?>
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