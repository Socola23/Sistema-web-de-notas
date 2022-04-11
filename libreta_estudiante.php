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
                    <h1 class="h3 mb-4 text-gray-800">Gestión Libreta de Notas</h1>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Lista</h6>
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
                            <table class="table">
                                <tr>
                                    <td>Descripción</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $muestro_docentes = $conexion->query("  SELECT id_estudio,CONCAT(alumno.apellidos,' ',alumno.nombres) FROM `estudio`
                                                                            INNER JOIN alumno
                                                                            ON
                                                                            alumno.id_alumno = estudio.id_alumno
                                                                            WHERE
                                                                            estudio.id_aula = '".$_GET["id_aula"]."'");
                                    while($fila = $muestro_docentes->fetch_row()){
                                        echo "<tr>";
                                        echo "<td>$fila[1]</td>";
                                        echo '
                                        <td><a target="_blank" href="libreta_nota.php?id_estudio='.$fila[0].'" class="btn btn-primary">Visualizar Libreta</a>
                                        </div>
                                        </td>';
                                        echo "</tr>";
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